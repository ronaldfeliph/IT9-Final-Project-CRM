<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => $this->adminDashboard(),
            'manager' => $this->managerDashboard(),
            'sales_staff' => $this->salesStaffDashboard($user),
        };
    }

    private function adminDashboard()
    {
        return view('dashboard', [
            'totalUsers' => User::count(),
            'totalCustomers' => Customer::count(),
            'activeLeads' => Lead::active()->count(),
            'completedFollowUps' => FollowUp::completed()->count(),
            'leadsByStatus' => Lead::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'recentActivities'  => Activity::with(['user', 'customer', 'lead'])->recent(7)->latest('activity_date')->take(10)->get(),
            'upcomingFollowUps' => FollowUp::with(['user', 'customer', 'lead'])->upcoming(7)->orderBy('due_date')->take(10)->get(),
        ]);
    }

    private function managerDashboard()
    {
        return view('dashboard', [
            'totalCustomers'    => Customer::count(),
            'totalActiveLeads'  => Lead::active()->count(),
            'wonLeads'          => Lead::byStatus('won')->count(),
            'completedFollowUps'  => FollowUp::completed()->count(),
            'leadsByStatus'     => Lead::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'staffPerformance'  => User::where('role', 'sales_staff')->withCount(['assignedCustomers','assignedLeads','followUps as completed_follow_ups_count' => fn ($q) =>$q->where('status', 'completed'),])->get(),
            'upcomingFollowUps' => FollowUp::with(['user', 'customer', 'lead'])->upcoming(7)->orderBy('due_date')->take(10)->get(),
        ]);
    }

    private function salesStaffDashboard(object $user)
    {
        return view('dashboard', [
            'myCustomers'        => Customer::assignedTo($user->id)->count(),
            'myActiveLeads'      => Lead::assignedTo($user->id)->active()->count(),
            'myPendingFollowUps' => FollowUp::forUser($user->id)->pending()->count(),
            'myCompletedFollowUps' => FollowUp::forUser($user->id)->completed()->count(),
            'myLeadsByStatus'    => Lead::assignedTo($user->id)->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'recentActivities'   => Activity::with(['customer', 'lead'])->forUser($user->id)->recent(7)->latest('activity_date')->take(10)->get(),
            'upcomingFollowUps'  => FollowUp::with(['customer', 'lead'])->forUser($user->id)->upcoming(7)->orderBy('due_date')->take(5)->get(),
        ]);
    }
}