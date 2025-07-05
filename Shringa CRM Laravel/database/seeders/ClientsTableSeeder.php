<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Lead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create clients from converted leads
        $convertedLeads = Lead::where('status', 'converted')->get();
        
        foreach ($convertedLeads as $lead) {
            Client::create([
                'name' => $lead->name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'address' => $lead->address,
                'client_type' => 'Residential',
                'lead_id' => $lead->id,
                'gst_number' => null,
                'company_name' => null,
                'special_notes' => 'Client converted from lead',
            ]);
        }
        
        // Create additional clients directly
        $this->createClient([
            'name' => 'Mohan Industries',
            'email' => 'info@mohanindustries.com',
            'phone' => '9870123456',
            'address' => 'MIDC, Andheri East, Mumbai',
            'client_type' => 'Commercial',
            'company_name' => 'Mohan Industries Pvt Ltd',
            'gst_number' => '27AABCT3518Q1ZV',
            'special_notes' => 'Large manufacturing unit, looking for office space redesign',
            'preferences' => 'Modern workspace design with sufficient meeting rooms',
        ]);
        
        $this->createClient([
            'name' => 'Suresh Patel',
            'email' => 'suresh@gmail.com',
            'phone' => '9870123457',
            'address' => 'Palm Beach Road, Vashi, Navi Mumbai, Maharashtra - 400703',
            'client_type' => 'Residential',
            'special_notes' => 'High-end client, looking for luxury home interior',
            'preferences' => 'Italian marble, premium lighting, imported furniture',
        ]);
        
        $this->createClient([
            'name' => 'TechSoft Solutions',
            'email' => 'contact@techsoft.com',
            'phone' => '9870123458',
            'address' => 'Hiranandani Gardens, Powai, Mumbai, Maharashtra - 400076',
            'client_type' => 'Commercial',
            'company_name' => 'TechSoft Solutions LLP',
            'gst_number' => '27AADFT2641R1Z3',
            'special_notes' => 'IT company expanding their office, need modern workspace design',
            'preferences' => 'Collaborative spaces, ergonomic furniture, tech integration',
        ]);
        
        $this->createClient([
            'name' => 'Green Valley Resorts',
            'email' => 'manager@greenvalley.com',
            'phone' => '9870123459',
            'address' => 'Karjat, Raigad, Maharashtra - 410201',
            'client_type' => 'Commercial',
            'company_name' => 'Green Valley Hospitality Pvt Ltd',
            'gst_number' => '27AADCG3521P1ZS',
            'special_notes' => 'Resort renovation project, need sustainable design',
            'preferences' => 'Eco-friendly materials, natural lighting, indigenous art',
        ]);
        
        $this->createClient([
            'name' => 'Laxmi Traders',
            'email' => 'laxmi@gmail.com',
            'phone' => '9870123460',
            'address' => 'Crawford Market, Mumbai, Maharashtra - 400001',
            'client_type' => 'Commercial',
            'company_name' => 'Laxmi Traders',
            'gst_number' => '27AADPL8731Q1Z1',
            'special_notes' => 'Retail store renovation',
            'preferences' => 'Display shelving, accent lighting, counters with storage',
        ]);
    }
    
    /**
     * Helper function to create clients with default values
     */
    private function createClient(array $attributes): void
    {
        Client::create(array_merge([
            'name' => 'Default Name',
            'email' => null,
            'phone' => '9876543210',
            'address' => null,
            'client_type' => 'Residential',
            'company_name' => null,
            'gst_number' => null,
            'special_notes' => null,
            'preferences' => null,
            'lead_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ], $attributes));
    }
}
