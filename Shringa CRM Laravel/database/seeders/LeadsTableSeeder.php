<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get user IDs for assignment
        $designerIds = User::where('role', 'designer')->pluck('id')->toArray();
        $pmIds = User::where('role', 'pm')->pluck('id')->toArray();
        
        // Create new leads
        $this->createLead([
            'name' => 'Rajesh Gupta',
            'email' => 'rajesh@example.com',
            'phone' => '9876123450',
            'source' => 'Website',
            'status' => 'new',
            'assigned_to' => $designerIds[0] ?? 1,
            'requirements' => '3BHK apartment interior design with modern theme',
            'address' => 'Andheri West, Mumbai',
            'follow_up_date' => now()->addDays(3),
        ]);
        
        $this->createLead([
            'name' => 'Neha Sharma',
            'email' => 'neha@example.com',
            'phone' => '9876123451',
            'source' => 'Social Media',
            'status' => 'contacted',
            'assigned_to' => $designerIds[0] ?? 1,
            'requirements' => 'Office interior design for tech startup',
            'address' => 'Bandra, Mumbai',
            'follow_up_date' => now()->addDays(1),
            'last_contacted_at' => now()->subDays(2),
        ]);
        
        $this->createLead([
            'name' => 'Sanjay Mehta',
            'email' => 'sanjay@example.com',
            'phone' => '9876123452',
            'source' => 'Referral',
            'status' => 'quoted',
            'assigned_to' => $pmIds[0] ?? 1,
            'requirements' => 'Renovation of 2BHK apartment',
            'address' => 'Powai, Mumbai',
            'follow_up_date' => now()->addDays(2),
            'last_contacted_at' => now()->subDays(1),
        ]);
        
        $this->createLead([
            'name' => 'Prachi Desai',
            'email' => 'prachi@example.com',
            'phone' => '9876123453',
            'source' => 'Exhibition',
            'status' => 'design_discussion',
            'assigned_to' => $designerIds[1] ?? 1,
            'requirements' => 'Luxury villa interior design',
            'address' => 'Juhu, Mumbai',
            'follow_up_date' => now()->addDays(1),
            'last_contacted_at' => now()->subHours(12),
        ]);
        
        $this->createLead([
            'name' => 'Vikram Singhania',
            'email' => 'vikram@example.com',
            'phone' => '9876123454',
            'source' => 'Website',
            'status' => 'lost',
            'assigned_to' => $designerIds[0] ?? 1,
            'requirements' => 'Restaurant interior design',
            'address' => 'Worli, Mumbai',
            'follow_up_date' => null,
            'last_contacted_at' => now()->subDays(10),
            'notes' => 'Client went with a competitor offering lower rates',
        ]);
        
        $this->createLead([
            'name' => 'Anjali Patel',
            'email' => 'anjali@example.com',
            'phone' => '9876123455',
            'source' => 'Walk-in',
            'status' => 'design_discussion',
            'assigned_to' => $pmIds[0] ?? 1,
            'requirements' => 'Commercial space design for retail store',
            'address' => 'Malad, Mumbai',
            'follow_up_date' => now()->addDays(1),
            'last_contacted_at' => now()->subDays(1),
        ]);
        
        $this->createLead([
            'name' => 'Karan Kapoor',
            'email' => 'karan@example.com',
            'phone' => '9876123456',
            'source' => 'Referral',
            'status' => 'new',
            'assigned_to' => $designerIds[1] ?? 1,
            'requirements' => 'Home office setup design',
            'address' => 'Goregaon, Mumbai',
            'follow_up_date' => now()->addDays(2),
        ]);
        
        $this->createLead([
            'name' => 'Meera Iyer',
            'email' => 'meera@example.com',
            'phone' => '9876123457',
            'source' => 'Website',
            'status' => 'contacted',
            'assigned_to' => $pmIds[0] ?? 1,
            'requirements' => 'Small studio apartment design',
            'address' => 'Borivali, Mumbai',
            'follow_up_date' => now()->addDays(3),
            'last_contacted_at' => now()->subHours(6),
        ]);
        
        $this->createLead([
            'name' => 'Arjun Kapoor',
            'email' => 'arjun@example.com',
            'phone' => '9876123458',
            'source' => 'Social Media',
            'status' => 'quoted',
            'assigned_to' => $designerIds[0] ?? 1,
            'requirements' => 'Resort interior design',
            'address' => 'Alibaug, Maharashtra',
            'follow_up_date' => now()->addDays(4),
            'last_contacted_at' => now()->subDays(2),
        ]);
        
        $this->createLead([
            'name' => 'Pooja Sharma',
            'email' => 'pooja@example.com',
            'phone' => '9876123459',
            'source' => 'Exhibition',
            'status' => 'converted',
            'assigned_to' => $pmIds[0] ?? 1,
            'requirements' => '4BHK duplex interior',
            'address' => 'Navi Mumbai, Maharashtra',
            'follow_up_date' => null,
            'last_contacted_at' => now()->subDays(5),
        ]);
    }
    
    /**
     * Helper function to create leads with default values
     */
    private function createLead(array $attributes): void
    {
        Lead::create(array_merge([
            'name' => 'Default Name',
            'email' => null,
            'phone' => '9876543210',
            'source' => 'Website',
            'status' => 'new',
            'assigned_to' => 1,
            'requirements' => null,
            'address' => null,
            'notes' => null,
            'follow_up_date' => null,
            'last_contacted_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ], $attributes));
    }
}
