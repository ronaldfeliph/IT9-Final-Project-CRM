<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Seeder;

class FollowUpSeeder extends Seeder
{
    public function run(): void
    {
        $salesStaff = User::where('role', 'sales_staff')->get();
        $customers  = Customer::all();
        $leads      = Lead::all();

        $followUps = [
            ['customer_id' => $customers[0]->id,  'lead_id' => $leads[0]->id,  'user_id' => $salesStaff[0]->id, 'title' => 'Send project wireframes for review',         'description' => 'Prepare and send initial wireframes to Maria for approval before development starts.',           'due_date' => now()->addDays(3),   'status' => 'pending'],
            ['customer_id' => $customers[1]->id,  'lead_id' => $leads[1]->id,  'user_id' => $salesStaff[1]->id, 'title' => 'Follow up on submitted proposal',            'description' => 'Check if Jose reviewed the renovation supply proposal and address any concerns he has.',         'due_date' => now()->addDays(1),   'status' => 'pending'],
            ['customer_id' => $customers[2]->id,  'lead_id' => $leads[2]->id,  'user_id' => $salesStaff[2]->id, 'title' => 'Negotiate final contract terms',              'description' => 'Schedule call with Ana to finalize pricing and delivery schedule for the annual contract.',       'due_date' => now()->subDays(2),   'status' => 'pending'],
            ['customer_id' => null,               'lead_id' => $leads[3]->id,  'user_id' => $salesStaff[0]->id, 'title' => 'Prepare IT infrastructure demo',             'description' => 'Set up demo environment and prepare presentation for TechCorp procurement team.',                'due_date' => now()->addDays(7),   'status' => 'pending'],
            ['customer_id' => $customers[4]->id,  'lead_id' => $leads[4]->id,  'user_id' => $salesStaff[1]->id, 'title' => 'Send signed contract copy to Liza',          'description' => 'Email signed contract and onboarding documents to Liza Flores from Flores Import & Export.',      'due_date' => now()->subDays(5),   'status' => 'completed'],
            ['customer_id' => $customers[5]->id,  'lead_id' => $leads[5]->id,  'user_id' => $salesStaff[2]->id, 'title' => 'Send formal quotation to Ramon',             'description' => 'Prepare and send detailed quotation for Q4 hardware bulk order to Villanueva Hardware.',          'due_date' => now()->addDays(2),   'status' => 'pending'],
            ['customer_id' => $customers[6]->id,  'lead_id' => $leads[6]->id,  'user_id' => $salesStaff[0]->id, 'title' => 'Submit equipment specs to Christine',        'description' => 'Send complete technical specifications and pricing sheet for medical equipment to Aquino Clinic.',  'due_date' => now()->addDays(4),   'status' => 'pending'],
            ['customer_id' => $customers[7]->id,  'lead_id' => $leads[7]->id,  'user_id' => $salesStaff[1]->id, 'title' => 'Follow up on fleet contract legal review',   'description' => 'Check with Mark if their legal team has finished reviewing the fleet delivery contract terms.',    'due_date' => now()->subDays(1),   'status' => 'pending'],
            ['customer_id' => $customers[9]->id,  'lead_id' => $leads[8]->id,  'user_id' => $salesStaff[2]->id, 'title' => 'Send revised contract to Ronaldo',           'description' => 'Draft and send updated contract reflecting the 6% discount agreed during negotiation call.',        'due_date' => now()->addDays(1),   'status' => 'pending'],
            ['customer_id' => $customers[10]->id, 'lead_id' => $leads[9]->id,  'user_id' => $salesStaff[0]->id, 'title' => 'Schedule product demo with Patricia',        'description' => 'Book showroom visit with Patricia Lim to present the new fashion line collection in person.',      'due_date' => now()->addDays(5),   'status' => 'pending'],
            ['customer_id' => $customers[11]->id, 'lead_id' => $leads[10]->id, 'user_id' => $salesStaff[1]->id, 'title' => 'Prepare financing proposal for Eduardo',     'description' => 'Prepare 24-month installment plan breakdown for farm equipment and send to Torres Farm Supplies.',  'due_date' => now()->subDays(3),   'status' => 'pending'],
            ['customer_id' => $customers[12]->id, 'lead_id' => $leads[11]->id, 'user_id' => $salesStaff[2]->id, 'title' => 'Confirm payment receipt from Sheila',        'description' => 'Verify if Navarro Printing Services has processed the payment for corporate printing package.',    'due_date' => now()->subDays(8),   'status' => 'completed'],
            ['customer_id' => $customers[14]->id, 'lead_id' => $leads[12]->id, 'user_id' => $salesStaff[0]->id, 'title' => 'Send bakery equipment catalog',              'description' => 'Email full product catalog and pricing list for bakery equipment to Maricel Domingo.',             'due_date' => now()->addDays(2),   'status' => 'pending'],
            ['customer_id' => $customers[15]->id, 'lead_id' => $leads[13]->id, 'user_id' => $salesStaff[1]->id, 'title' => 'Revise showroom signage proposal for Arnel', 'description' => 'Update signage section of the showroom setup proposal based on Arnels feedback from last meeting.',  'due_date' => now()->addDays(1),   'status' => 'pending'],
            ['customer_id' => $customers[16]->id, 'lead_id' => $leads[14]->id, 'user_id' => $salesStaff[2]->id, 'title' => 'Send counter-proposal to Rosario',           'description' => 'Finalize and send the 6% discount counter-proposal for dental clinic renovation to Ibarra Clinic.',  'due_date' => now()->subDays(1),   'status' => 'pending'],
            ['customer_id' => $customers[17]->id, 'lead_id' => $leads[15]->id, 'user_id' => $salesStaff[0]->id, 'title' => 'Follow up cold storage proposal',            'description' => 'Check with Ferdinand if he has reviewed the cold storage expansion proposal and has questions.',    'due_date' => now()->addDays(6),   'status' => 'pending'],
            ['customer_id' => null,               'lead_id' => $leads[16]->id, 'user_id' => $salesStaff[1]->id, 'title' => 'Deliver trial supply to school canteen',     'description' => 'Coordinate trial supply delivery to Davao school canteen and collect feedback after one week.',      'due_date' => now()->addDays(8),   'status' => 'pending'],
            ['customer_id' => null,               'lead_id' => $leads[17]->id, 'user_id' => $salesStaff[2]->id, 'title' => 'Prepare hotel amenities demo kit',           'description' => 'Assemble sample amenities kit and schedule presentation with hotel purchasing manager.',            'due_date' => now()->addDays(5),   'status' => 'pending'],
            ['customer_id' => $customers[19]->id, 'lead_id' => $leads[18]->id, 'user_id' => $salesStaff[0]->id, 'title' => 'Re-engage Roberto next quarter',             'description' => 'Schedule a follow-up call with Roberto Vergara next quarter for the steel works project rebid.',   'due_date' => now()->addDays(90),  'status' => 'pending'],
            ['customer_id' => $customers[3]->id,  'lead_id' => $leads[19]->id, 'user_id' => $salesStaff[1]->id, 'title' => 'Send renewal confirmation to Carlo',         'description' => 'Email software renewal confirmation letter and updated license keys to Carlo Mendoza.',             'due_date' => now()->subDays(10),  'status' => 'completed'],
        ];

        foreach ($followUps as $data) {
            FollowUp::create($data);
        }

        $this->command->info('20 follow-ups seeded.');
    }
}