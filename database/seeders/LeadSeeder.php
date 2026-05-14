<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $salesStaff = User::where('role', 'sales_staff')->get();
        $customers  = Customer::all();

        $leads = [
            ['customer_id' => $customers[0]->id,  'name' => 'Website Redesign Project',        'email' => 'maria.santos@gmail.com',     'phone' => '+63 912 345 6789', 'source' => 'Referral',    'status' => 'qualified',     'priority' => 'high',   'expected_value' => 85000,  'notes' => 'Client wants full redesign with e-commerce.',             'assigned_user_id' => $salesStaff[0]->id],
            ['customer_id' => $customers[1]->id,  'name' => 'Office Renovation Supply',        'email' => 'jose.delacruz@yahoo.com',    'phone' => '+63 917 234 5678', 'source' => 'Cold Call',   'status' => 'proposal_sent', 'priority' => 'medium', 'expected_value' => 150000, 'notes' => 'Needs materials for 3-floor office renovation.',          'assigned_user_id' => $salesStaff[1]->id],
            ['customer_id' => $customers[2]->id,  'name' => 'Annual Supply Contract',          'email' => 'ana.reyes@outlook.com',      'phone' => '+63 918 876 5432', 'source' => 'Website',     'status' => 'negotiation',   'priority' => 'high',   'expected_value' => 320000, 'notes' => 'Recurring annual contract for merchandise supply.',        'assigned_user_id' => $salesStaff[2]->id],
            ['customer_id' => null,               'name' => 'IT Infrastructure Upgrade',       'email' => 'procurement@techcorp.com',   'phone' => '+63 922 333 4455', 'source' => 'LinkedIn',    'status' => 'new',           'priority' => 'medium', 'expected_value' => 500000, 'notes' => 'Large company upgrading server infrastructure.',          'assigned_user_id' => $salesStaff[0]->id],
            ['customer_id' => $customers[4]->id,  'name' => 'Logistics Partnership Deal',      'email' => 'liza.flores@email.com',      'phone' => '+63 935 444 5566', 'source' => 'Trade Fair',  'status' => 'won',           'priority' => 'high',   'expected_value' => 210000, 'notes' => 'Signed partnership for import logistics support.',        'assigned_user_id' => $salesStaff[1]->id],
            ['customer_id' => $customers[5]->id,  'name' => 'Hardware Bulk Order Q4',          'email' => 'ramon.villanueva@gmail.com', 'phone' => '+63 916 778 9900', 'source' => 'Referral',    'status' => 'contacted',     'priority' => 'medium', 'expected_value' => 75000,  'notes' => 'Q4 bulk order for construction hardware materials.',       'assigned_user_id' => $salesStaff[2]->id],
            ['customer_id' => $customers[6]->id,  'name' => 'Medical Equipment Supply',        'email' => 'christine.aquino@yahoo.com', 'phone' => '+63 919 321 4567', 'source' => 'Website',     'status' => 'qualified',     'priority' => 'high',   'expected_value' => 430000, 'notes' => 'Hospital-grade equipment supply for 2 clinics.',          'assigned_user_id' => $salesStaff[0]->id],
            ['customer_id' => $customers[7]->id,  'name' => 'Fleet Delivery Contract',         'email' => 'mark.bautista@gmail.com',    'phone' => '+63 923 654 3210', 'source' => 'Cold Call',   'status' => 'proposal_sent', 'priority' => 'high',   'expected_value' => 280000, 'notes' => 'Monthly delivery fleet contract for 12 months.',          'assigned_user_id' => $salesStaff[1]->id],
            ['customer_id' => $customers[9]->id,  'name' => 'Auto Parts Wholesale Deal',       'email' => 'ronaldo.garcia@gmail.com',   'phone' => '+63 908 112 2334', 'source' => 'Trade Fair',  'status' => 'negotiation',   'priority' => 'medium', 'expected_value' => 195000, 'notes' => 'Wholesale pricing negotiation for auto parts supply.',     'assigned_user_id' => $salesStaff[2]->id],
            ['customer_id' => $customers[10]->id, 'name' => 'Fashion Line Product Launch',     'email' => 'patricia.lim@email.com',     'phone' => '+63 917 445 6678', 'source' => 'Instagram',   'status' => 'new',           'priority' => 'low',    'expected_value' => 120000, 'notes' => 'New product line launch marketing and print collateral.',  'assigned_user_id' => $salesStaff[0]->id],
            ['customer_id' => $customers[11]->id, 'name' => 'Farm Equipment Financing',        'email' => 'eduardo.torres@yahoo.com',   'phone' => '+63 926 889 0011', 'source' => 'Referral',    'status' => 'qualified',     'priority' => 'medium', 'expected_value' => 350000, 'notes' => 'Equipment financing package for large farm operation.',    'assigned_user_id' => $salesStaff[1]->id],
            ['customer_id' => $customers[12]->id, 'name' => 'Corporate Printing Package',      'email' => 'sheila.navarro@gmail.com',   'phone' => '+63 933 223 4456', 'source' => 'Website',     'status' => 'won',           'priority' => 'low',    'expected_value' => 45000,  'notes' => 'Annual corporate printing package including tarpaulins.',  'assigned_user_id' => $salesStaff[2]->id],
            ['customer_id' => $customers[14]->id, 'name' => 'Bakery Expansion Supply',         'email' => 'maricel.domingo@gmail.com',  'phone' => '+63 929 334 5567', 'source' => 'Cold Call',   'status' => 'contacted',     'priority' => 'low',    'expected_value' => 60000,  'notes' => 'Supply agreement for new bakery branch equipment.',        'assigned_user_id' => $salesStaff[0]->id],
            ['customer_id' => $customers[15]->id, 'name' => 'Electronics Showroom Setup',      'email' => 'arnel.pascual@yahoo.com',    'phone' => '+63 915 678 9012', 'source' => 'LinkedIn',    'status' => 'proposal_sent', 'priority' => 'high',   'expected_value' => 275000, 'notes' => 'Full showroom setup with display units and signage.',      'assigned_user_id' => $salesStaff[1]->id],
            ['customer_id' => $customers[16]->id, 'name' => 'Dental Clinic Renovation',        'email' => 'rosario.ibarra@gmail.com',   'phone' => '+63 922 789 0123', 'source' => 'Referral',    'status' => 'negotiation',   'priority' => 'medium', 'expected_value' => 180000, 'notes' => 'Full interior renovation of 2 dental clinic branches.',    'assigned_user_id' => $salesStaff[2]->id],
            ['customer_id' => $customers[17]->id, 'name' => 'Cold Storage Expansion',          'email' => 'ferdinand.ramos@email.com',  'phone' => '+63 936 890 1234', 'source' => 'Trade Fair',  'status' => 'qualified',     'priority' => 'high',   'expected_value' => 620000, 'notes' => 'Expand cold storage capacity by 3 additional units.',      'assigned_user_id' => $salesStaff[0]->id],
            ['customer_id' => null,               'name' => 'School Canteen Supply Contract',  'email' => 'canteen@davaoschool.edu.ph', 'phone' => '+63 921 543 2100', 'source' => 'Website',     'status' => 'new',           'priority' => 'low',    'expected_value' => 95000,  'notes' => 'Daily supply contract for school canteen operations.',     'assigned_user_id' => $salesStaff[1]->id],
            ['customer_id' => null,               'name' => 'Hotel Amenities Supply',          'email' => 'purchasing@hotelgm.com',     'phone' => '+63 934 210 9876', 'source' => 'Cold Call',   'status' => 'contacted',     'priority' => 'medium', 'expected_value' => 240000, 'notes' => 'Monthly amenities supply for 4-star hotel chain.',         'assigned_user_id' => $salesStaff[2]->id],
            ['customer_id' => $customers[19]->id, 'name' => 'Steel Works Project Bid',         'email' => 'roberto.vergara@yahoo.com',  'phone' => '+63 928 012 3456', 'source' => 'Referral',    'status' => 'lost',          'priority' => 'high',   'expected_value' => 800000, 'notes' => 'Lost bid to competitor. Follow up next quarter.',         'assigned_user_id' => $salesStaff[0]->id],
            ['customer_id' => $customers[3]->id,  'name' => 'Software License Renewal',        'email' => 'carlo.mendoza@gmail.com',    'phone' => '+63 920 111 2233', 'source' => 'Email',       'status' => 'won',           'priority' => 'medium', 'expected_value' => 55000,  'notes' => 'Annual software license renewal for 15 workstations.',    'assigned_user_id' => $salesStaff[1]->id],
        ];

        foreach ($leads as $data) {
            Lead::create($data);
        }

        $this->command->info('20 leads seeded.');
    }
}