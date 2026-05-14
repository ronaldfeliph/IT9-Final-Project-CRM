<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    private function resolveDateRange(Request $request): array
    {
        // Quick range shortcuts
        if ($request->filled('range')) {
            return match ($request->range) {
                'this_month'  => [now()->startOfMonth(), now()->endOfMonth()],
                'last_month'  => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
                'this_year'   => [now()->startOfYear(), now()->endOfYear()],
                default       => [now()->startOfMonth(), now()->endOfMonth()],
            };
        }

        // Custom date range
        $from = $request->filled('date_from')
            ? Carbon::parse($request->date_from)->startOfDay()
            : now()->startOfMonth();

        $to = $request->filled('date_to')
            ? Carbon::parse($request->date_to)->endOfDay()
            : now()->endOfMonth();

        return [$from, $to];
    }

    // ─── Index ───────────────────────────────────────────────────

    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->isSalesStaff()) {
            abort(403, 'You are not authorized to view reports.');
        }

        [$dateFrom, $dateTo] = $this->resolveDateRange($request);

        $data = [
            'dateFrom' => $dateFrom,
            'dateTo'   => $dateTo,

            // ── Customer Report ──────────────────────────────────
            'totalCustomers'     => Customer::count(),
            'activeCustomers'    => Customer::where('status', 'active')->count(),
            'inactiveCustomers'  => Customer::where('status', 'inactive')->count(),
            'customersThisMonth' => Customer::whereBetween('created_at', [$dateFrom, $dateTo])->count(),

            // ── Lead Report ──────────────────────────────────────
            'totalLeads'         => Lead::count(),
            'leadsByStatus'      => Lead::selectRaw('status, count(*) as total')
                                        ->groupBy('status')
                                        ->pluck('total', 'status'),
            'totalExpectedValue' => Lead::active()->sum('expected_value'),
            'totalWonValue'      => Lead::byStatus('won')
                                        ->whereBetween('updated_at', [$dateFrom, $dateTo])
                                        ->sum('expected_value'),
            'leadsThisMonth'     => Lead::whereBetween('created_at', [$dateFrom, $dateTo])->count(),

            // ── Follow-up Report ─────────────────────────────────
            'totalFollowUps'     => FollowUp::count(),
            'pendingFollowUps'   => FollowUp::pending()->count(),
            'completedFollowUps' => FollowUp::completed()->count(),
            'overdueFollowUps'   => FollowUp::overdue()->count(),

            // ── Activity Report ──────────────────────────────────
            'totalActivities'      => Activity::count(),
            'activitiesByType'     => Activity::selectRaw('activity_type, count(*) as total')
                                          ->groupBy('activity_type')
                                          ->pluck('total', 'activity_type'),
            'activitiesThisMonth'  => Activity::whereBetween('activity_date', [$dateFrom, $dateTo])->count(),
        ];

        // ── Staff Performance (admin + manager) ──────────────────
        if ($user->isAdmin() || $user->isManager()) {
            $data['staffPerformance'] = User::where('role', 'sales_staff')
                ->withCount([
                    'assignedCustomers',
                    'assignedLeads',
                    'activities as activities_this_month_count' => fn ($q) =>
                        $q->whereBetween('activity_date', [$dateFrom, $dateTo]),
                    'followUps as completed_follow_ups_count' => fn ($q) =>
                        $q->where('status', 'completed')
                          ->whereBetween('updated_at', [$dateFrom, $dateTo]),
                    'followUps as pending_follow_ups_count' => fn ($q) =>
                        $q->where('status', 'pending'),
                ])
                ->get();
        }

        return view('reports.index', $data);
    }

    // ─── Export CSV ──────────────────────────────────────────────

    public function export(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->isSalesStaff()) {
            abort(403);
        }

        [$dateFrom, $dateTo] = $this->resolveDateRange($request);

        $filename = 'crm-report-' . $dateFrom->format('Y-m-d') . '-to-' . $dateTo->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($dateFrom, $dateTo, $user) {
            $handle = fopen('php://output', 'w');

            // ── Summary ──────────────────────────────────────────
            fputcsv($handle, ['CRM Report']);
            fputcsv($handle, ['Period', $dateFrom->format('M d, Y') . ' - ' . $dateTo->format('M d, Y')]);
            fputcsv($handle, ['Generated', now()->format('M d, Y h:i A')]);
            fputcsv($handle, ['Generated By', auth()->user()->name]);
            fputcsv($handle, []);

            // ── Customers ────────────────────────────────────────
            fputcsv($handle, ['CUSTOMERS']);
            fputcsv($handle, ['Name', 'Email', 'Phone', 'Company', 'Status', 'Assigned To', 'Created At']);

            $customers = Customer::with('assignedUser')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->get();

            foreach ($customers as $customer) {
                fputcsv($handle, [
                    $customer->full_name,
                    $customer->email,
                    $customer->phone,
                    $customer->company ?? '',
                    $customer->status,
                    $customer->assignedUser->name ?? 'Unassigned',
                    $customer->created_at->format('M d, Y'),
                ]);
            }

            fputcsv($handle, []);

            // ── Leads ─────────────────────────────────────────────
            fputcsv($handle, ['LEADS']);
            fputcsv($handle, ['Name', 'Email', 'Source', 'Status', 'Priority', 'Expected Value', 'Assigned To', 'Created At']);

            $leads = Lead::with('assignedUser')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->get();

            foreach ($leads as $lead) {
                fputcsv($handle, [
                    $lead->name,
                    $lead->email ?? '',
                    $lead->source ?? '',
                    str_replace('_', ' ', $lead->status),
                    $lead->priority,
                    $lead->expected_value ? number_format($lead->expected_value, 2) : '',
                    $lead->assignedUser->name ?? 'Unassigned',
                    $lead->created_at->format('M d, Y'),
                ]);
            }

            fputcsv($handle, []);

            // ── Activities ────────────────────────────────────────
            fputcsv($handle, ['ACTIVITIES']);
            fputcsv($handle, ['Type', 'Description', 'Customer', 'Lead', 'Logged By', 'Date']);

            $activities = Activity::with(['customer', 'lead', 'user'])
                ->whereBetween('activity_date', [$dateFrom, $dateTo])
                ->get();

            foreach ($activities as $activity) {
                fputcsv($handle, [
                    $activity->activity_type,
                    $activity->description,
                    $activity->customer->full_name ?? '',
                    $activity->lead->name ?? '',
                    $activity->user->name ?? '',
                    $activity->activity_date->format('M d, Y'),
                ]);
            }

            fputcsv($handle, []);

            // ── Follow-ups ────────────────────────────────────────
            fputcsv($handle, ['FOLLOW-UPS']);
            fputcsv($handle, ['Title', 'Customer', 'Lead', 'Assigned To', 'Due Date', 'Status']);

            $followUps = FollowUp::with(['customer', 'lead', 'user'])
                ->whereBetween('due_date', [$dateFrom, $dateTo])
                ->get();

            foreach ($followUps as $followUp) {
                fputcsv($handle, [
                    $followUp->title,
                    $followUp->customer->full_name ?? '',
                    $followUp->lead->name ?? '',
                    $followUp->user->name ?? '',
                    $followUp->due_date->format('M d, Y'),
                    $followUp->status,
                ]);
            }

            // ── Staff Performance ─────────────────────────────────
            if ($user->isAdmin() || $user->isManager()) {
                fputcsv($handle, []);
                fputcsv($handle, ['STAFF PERFORMANCE']);
                fputcsv($handle, ['Name', 'Email', 'Customers', 'Leads', 'Activities', 'Completed Follow-ups', 'Pending Follow-ups']);

                $staff = User::where('role', 'sales_staff')
                    ->withCount([
                        'assignedCustomers',
                        'assignedLeads',
                        'activities as activities_this_month_count' => fn ($q) =>
                            $q->whereBetween('activity_date', [$dateFrom, $dateTo]),
                        'followUps as completed_follow_ups_count' => fn ($q) =>
                            $q->where('status', 'completed'),
                        'followUps as pending_follow_ups_count' => fn ($q) =>
                            $q->where('status', 'pending'),
                    ])
                    ->get();

                foreach ($staff as $member) {
                    fputcsv($handle, [
                        $member->name,
                        $member->email,
                        $member->assigned_customers_count,
                        $member->assigned_leads_count,
                        $member->activities_this_month_count,
                        $member->completed_follow_ups_count,
                        $member->pending_follow_ups_count,
                    ]);
                }
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}