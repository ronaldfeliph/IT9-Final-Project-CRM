<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $salesStaff = User::where('role', 'sales_staff')->get();
        $customers  = Customer::all();
        $leads      = Lead::all();

        $activities = [
            ['customer_id' => $customers[0]->id,  'lead_id' => $leads[0]->id,  'user_id' => $salesStaff[0]->id, 'activity_type' => 'call',    'description' => 'Initial discovery call with Maria. Discussed project scope and timeline. Client is ready to proceed.',                    'activity_date' => now()->subDays(20)],
            ['customer_id' => $customers[1]->id,  'lead_id' => $leads[1]->id,  'user_id' => $salesStaff[1]->id, 'activity_type' => 'meeting', 'description' => 'On-site visit at JDC Construction office. Took measurements and discussed material specs for the renovation project.',  'activity_date' => now()->subDays(18)],
            ['customer_id' => $customers[2]->id,  'lead_id' => $leads[2]->id,  'user_id' => $salesStaff[2]->id, 'activity_type' => 'email',   'description' => 'Sent revised proposal with updated pricing for the annual supply contract. Awaiting confirmation from Ana.',            'activity_date' => now()->subDays(15)],
            ['customer_id' => null,               'lead_id' => $leads[3]->id,  'user_id' => $salesStaff[0]->id, 'activity_type' => 'call',    'description' => 'Cold call to TechCorp procurement. Spoke with IT manager who showed interest. Demo scheduled for next week.',           'activity_date' => now()->subDays(14)],
            ['customer_id' => $customers[4]->id,  'lead_id' => $leads[4]->id,  'user_id' => $salesStaff[1]->id, 'activity_type' => 'note',    'description' => 'Contract signed by both parties. Handover meeting set for Monday. Logistics partnership deal officially closed.',       'activity_date' => now()->subDays(12)],
            ['customer_id' => $customers[5]->id,  'lead_id' => $leads[5]->id,  'user_id' => $salesStaff[2]->id, 'activity_type' => 'call',    'description' => 'Followed up with Ramon on Q4 hardware bulk order. He confirmed interest and requested a formal quotation.',             'activity_date' => now()->subDays(11)],
            ['customer_id' => $customers[6]->id,  'lead_id' => $leads[6]->id,  'user_id' => $salesStaff[0]->id, 'activity_type' => 'meeting', 'description' => 'Site visit to Aquino clinic. Assessed equipment needs. Two units of autoclave and dental chairs required.',            'activity_date' => now()->subDays(10)],
            ['customer_id' => $customers[7]->id,  'lead_id' => $leads[7]->id,  'user_id' => $salesStaff[1]->id, 'activity_type' => 'email',   'description' => 'Sent fleet delivery contract proposal to Mark Bautista. Pricing valid for 30 days. Waiting for their legal review.',   'activity_date' => now()->subDays(9)],
            ['customer_id' => $customers[9]->id,  'lead_id' => $leads[8]->id,  'user_id' => $salesStaff[2]->id, 'activity_type' => 'meeting', 'description' => 'Price negotiation meeting with Ronaldo. Agreed on 12% discount for bulk order. Final contract to be drafted.',         'activity_date' => now()->subDays(8)],
            ['customer_id' => $customers[10]->id, 'lead_id' => $leads[9]->id,  'user_id' => $salesStaff[0]->id, 'activity_type' => 'note',    'description' => 'Patricia requested product catalog. Sent via email. She is planning a major reorder for the upcoming collection.',      'activity_date' => now()->subDays(7)],
            ['customer_id' => $customers[11]->id, 'lead_id' => $leads[10]->id, 'user_id' => $salesStaff[1]->id, 'activity_type' => 'call',    'description' => 'Discussed farm equipment financing options with Eduardo. He prefers a 24-month installment plan with low interest.',   'activity_date' => now()->subDays(6)],
            ['customer_id' => $customers[12]->id, 'lead_id' => $leads[11]->id, 'user_id' => $salesStaff[2]->id, 'activity_type' => 'email',   'description' => 'Sent final invoice for corporate printing package to Sheila. Payment due in 15 days. Deal confirmed and closed.',      'activity_date' => now()->subDays(5)],
            ['customer_id' => $customers[14]->id, 'lead_id' => $leads[12]->id, 'user_id' => $salesStaff[0]->id, 'activity_type' => 'call',    'description' => 'Called Maricel to follow up on bakery expansion plans. She confirmed they are moving forward with the new branch.',    'activity_date' => now()->subDays(4)],
            ['customer_id' => $customers[15]->id, 'lead_id' => $leads[13]->id, 'user_id' => $salesStaff[1]->id, 'activity_type' => 'meeting', 'description' => 'Walked Arnel through the showroom setup proposal. He approved the layout and requested minor changes on signage.',    'activity_date' => now()->subDays(3)],
            ['customer_id' => $customers[16]->id, 'lead_id' => $leads[14]->id, 'user_id' => $salesStaff[2]->id, 'activity_type' => 'call',    'description' => 'Negotiation call with Rosario on clinic renovation. She wants a 10% reduction. Submitted counter-proposal at 6%.',    'activity_date' => now()->subDays(3)],
            ['customer_id' => $customers[17]->id, 'lead_id' => $leads[15]->id, 'user_id' => $salesStaff[0]->id, 'activity_type' => 'email',   'description' => 'Sent cold storage expansion proposal to Ferdinand. Included specs for 3 additional units and timeline breakdown.',     'activity_date' => now()->subDays(2)],
            ['customer_id' => null,               'lead_id' => $leads[16]->id, 'user_id' => $salesStaff[1]->id, 'activity_type' => 'email',   'description' => 'Reached out to Davao school canteen. Introduced product lineup and offered a trial supply for one week.',              'activity_date' => now()->subDays(2)],
            ['customer_id' => null,               'lead_id' => $leads[17]->id, 'user_id' => $salesStaff[2]->id, 'activity_type' => 'call',    'description' => 'Cold call to hotel purchasing team. They expressed interest in a monthly amenities supply contract. Demo next week.',  'activity_date' => now()->subDays(1)],
            ['customer_id' => $customers[19]->id, 'lead_id' => $leads[18]->id, 'user_id' => $salesStaff[0]->id, 'activity_type' => 'note',    'description' => 'Lost the steel works bid to a competitor offering 15% lower pricing. Will reconnect with Roberto next quarter.',      'activity_date' => now()->subDays(1)],
            ['customer_id' => $customers[3]->id,  'lead_id' => $leads[19]->id, 'user_id' => $salesStaff[1]->id, 'activity_type' => 'meeting', 'description' => 'Closed software renewal with Carlo. Completed onboarding call and sent license keys. Invoice issued and paid.',        'activity_date' => now()],
        ];

        foreach ($activities as $data) {
            Activity::create($data);
        }

        $this->command->info('20 activities seeded.');
    }
}