<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $salesStaff = User::where('role', 'sales_staff')->get();

        $customers = [
            ['first_name' => 'Maria',     'last_name' => 'Santos',     'email' => 'maria.santos@gmail.com',      'phone' => '+63 912 345 6789', 'company' => 'Santos Trading Co.',         'address' => 'Blk 5 Lot 3, Matina, Davao City',           'status' => 'active',   'assigned_user_id' => $salesStaff[0]->id],
            ['first_name' => 'Jose',      'last_name' => 'dela Cruz',  'email' => 'jose.delacruz@yahoo.com',     'phone' => '+63 917 234 5678', 'company' => 'JDC Construction',            'address' => 'Purok 4, Buhangin, Davao City',              'status' => 'active',   'assigned_user_id' => $salesStaff[1]->id],
            ['first_name' => 'Ana',       'last_name' => 'Reyes',      'email' => 'ana.reyes@outlook.com',       'phone' => '+63 918 876 5432', 'company' => 'Reyes General Merchandise',   'address' => 'Door 2, Agdao, Davao City',                  'status' => 'active',   'assigned_user_id' => $salesStaff[2]->id],
            ['first_name' => 'Carlo',     'last_name' => 'Mendoza',    'email' => 'carlo.mendoza@gmail.com',     'phone' => '+63 920 111 2233', 'company' => 'Mendoza Tech Solutions',      'address' => 'Unit 3B, Lanang, Davao City',                'status' => 'inactive', 'assigned_user_id' => $salesStaff[0]->id],
            ['first_name' => 'Liza',      'last_name' => 'Flores',     'email' => 'liza.flores@email.com',       'phone' => '+63 935 444 5566', 'company' => 'Flores Import & Export',      'address' => '123 Quirino Ave, Poblacion, Davao City',     'status' => 'active',   'assigned_user_id' => $salesStaff[1]->id],
            ['first_name' => 'Ramon',     'last_name' => 'Villanueva', 'email' => 'ramon.villanueva@gmail.com',  'phone' => '+63 916 778 9900', 'company' => 'Villanueva Hardware',         'address' => 'Km 7, Matina, Davao City',                   'status' => 'active',   'assigned_user_id' => $salesStaff[2]->id],
            ['first_name' => 'Christine', 'last_name' => 'Aquino',     'email' => 'christine.aquino@yahoo.com',  'phone' => '+63 919 321 4567', 'company' => 'Aquino Medical Supplies',     'address' => 'Door 5, Bajada, Davao City',                 'status' => 'active',   'assigned_user_id' => $salesStaff[0]->id],
            ['first_name' => 'Mark',      'last_name' => 'Bautista',   'email' => 'mark.bautista@gmail.com',     'phone' => '+63 923 654 3210', 'company' => 'Bautista Logistics',          'address' => 'Purok 6, Panacan, Davao City',               'status' => 'active',   'assigned_user_id' => $salesStaff[1]->id],
            ['first_name' => 'Grace',     'last_name' => 'Soriano',    'email' => 'grace.soriano@outlook.com',   'phone' => '+63 931 987 6543', 'company' => 'Soriano Events & Catering',   'address' => 'Blk 3 Phase 2, Communal, Davao City',       'status' => 'inactive', 'assigned_user_id' => $salesStaff[2]->id],
            ['first_name' => 'Ronaldo',   'last_name' => 'Garcia',     'email' => 'ronaldo.garcia@gmail.com',    'phone' => '+63 908 112 2334', 'company' => 'Garcia Auto Parts',           'address' => '45 MacArthur Hwy, Ulas, Davao City',        'status' => 'active',   'assigned_user_id' => $salesStaff[0]->id],
            ['first_name' => 'Patricia',  'last_name' => 'Lim',        'email' => 'patricia.lim@email.com',      'phone' => '+63 917 445 6678', 'company' => 'Lim Fashion House',           'address' => 'SM City Annex, Davao City',                  'status' => 'active',   'assigned_user_id' => $salesStaff[1]->id],
            ['first_name' => 'Eduardo',   'last_name' => 'Torres',     'email' => 'eduardo.torres@yahoo.com',    'phone' => '+63 926 889 0011', 'company' => 'Torres Farm Supplies',        'address' => 'Purok 2, Tugbok, Davao City',                'status' => 'active',   'assigned_user_id' => $salesStaff[2]->id],
            ['first_name' => 'Sheila',    'last_name' => 'Navarro',    'email' => 'sheila.navarro@gmail.com',    'phone' => '+63 933 223 4456', 'company' => 'Navarro Printing Services',   'address' => 'Doors 1-2, Bankerohan, Davao City',          'status' => 'active',   'assigned_user_id' => $salesStaff[0]->id],
            ['first_name' => 'Bernard',   'last_name' => 'Cruz',       'email' => 'bernard.cruz@outlook.com',    'phone' => '+63 910 567 8900', 'company' => 'Cruz Real Estate',            'address' => 'Abreeza Mall Area, J.P. Laurel, Davao City', 'status' => 'inactive', 'assigned_user_id' => $salesStaff[1]->id],
            ['first_name' => 'Maricel',   'last_name' => 'Domingo',    'email' => 'maricel.domingo@gmail.com',   'phone' => '+63 929 334 5567', 'company' => 'Domingo Bakery & Cafe',       'address' => 'Purok 8, Toril, Davao City',                 'status' => 'active',   'assigned_user_id' => $salesStaff[2]->id],
            ['first_name' => 'Arnel',     'last_name' => 'Pascual',    'email' => 'arnel.pascual@yahoo.com',     'phone' => '+63 915 678 9012', 'company' => 'Pascual Electronics',         'address' => 'Gaisano Mall Area, Ilustre, Davao City',     'status' => 'active',   'assigned_user_id' => $salesStaff[0]->id],
            ['first_name' => 'Rosario',   'last_name' => 'Ibarra',     'email' => 'rosario.ibarra@gmail.com',    'phone' => '+63 922 789 0123', 'company' => 'Ibarra Dental Clinic',        'address' => 'Blk 12, Talomo, Davao City',                 'status' => 'active',   'assigned_user_id' => $salesStaff[1]->id],
            ['first_name' => 'Ferdinand', 'last_name' => 'Ramos',      'email' => 'ferdinand.ramos@email.com',   'phone' => '+63 936 890 1234', 'company' => 'Ramos Cold Storage',          'address' => 'Sasa Port Area, Davao City',                 'status' => 'active',   'assigned_user_id' => $salesStaff[2]->id],
            ['first_name' => 'Glenda',    'last_name' => 'Castillo',   'email' => 'glenda.castillo@gmail.com',   'phone' => '+63 911 901 2345', 'company' => 'Castillo Travel Agency',      'address' => 'Magsaysay Park Area, Davao City',            'status' => 'inactive', 'assigned_user_id' => $salesStaff[0]->id],
            ['first_name' => 'Roberto',   'last_name' => 'Vergara',    'email' => 'roberto.vergara@yahoo.com',   'phone' => '+63 928 012 3456', 'company' => 'Vergara Steel Works',         'address' => 'Mintal Industrial Area, Davao City',         'status' => 'active',   'assigned_user_id' => $salesStaff[1]->id],
        ];

        foreach ($customers as $data) {
            Customer::updateOrCreate(['email' => $data['email']], $data);
        }

        $this->command->info('20 customers seeded.');
    }
}