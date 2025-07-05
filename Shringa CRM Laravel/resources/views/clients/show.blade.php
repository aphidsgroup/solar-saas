@extends('layouts.app')

@section('title', 'Client Details - ' . $client->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('clients.index') }}" class="text-primary-500 hover:text-primary-600">
            <i class="fas fa-arrow-left mr-2"></i> Back to Clients
        </a>
    </div>
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">{{ $client->name }}</h1>
            @if($client->company_name)
            <p class="text-gray-600">{{ $client->company_name }}</p>
            @endif
        </div>
        
        <div class="flex space-x-2 mt-4 md:mt-0">
            @can('update', $client)
            <a href="{{ route('clients.edit', $client) }}" class="bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            @endcan
            
            @can('delete', $client)
            <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
            @endcan
        </div>
    </div>
    
    <!-- Client Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="text-sm font-medium text-gray-500 mb-1">Total Projects</div>
            <div class="text-2xl font-semibold">{{ $stats['total_projects'] }}</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="text-sm font-medium text-gray-500 mb-1">Ongoing Projects</div>
            <div class="text-2xl font-semibold">{{ $stats['ongoing_projects'] }}</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="text-sm font-medium text-gray-500 mb-1">Total Invoices</div>
            <div class="text-2xl font-semibold">{{ $stats['total_invoices'] }}</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="text-sm font-medium text-gray-500 mb-1">Pending Amount</div>
            <div class="text-2xl font-semibold">₹{{ number_format($stats['pending_amount'], 2) }}</div>
        </div>
    </div>
    
    <!-- Client Details -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-50 px-4 py-2 border-b">
                <h2 class="text-lg font-medium text-gray-800">Client Information</h2>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Client Type</div>
                        <div class="mt-1">{{ $client->client_type }}</div>
                    </div>
                    
                    <div>
                        <div class="text-sm font-medium text-gray-500">Status</div>
                        <div class="mt-1">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-primary-500 text-white">
                                {{ ucfirst($client->status) }}
                            </span>
                        </div>
                    </div>
                    
                    @if($client->gst_number)
                    <div>
                        <div class="text-sm font-medium text-gray-500">GST Number</div>
                        <div class="mt-1">{{ $client->gst_number }}</div>
                    </div>
                    @endif
                    
                    @if($client->lead_id)
                    <div>
                        <div class="text-sm font-medium text-gray-500">Converted from Lead</div>
                        <div class="mt-1">
                            <a href="{{ route('leads.show', $client->lead_id) }}" class="text-primary-500 hover:text-primary-600">
                                View Original Lead
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-50 px-4 py-2 border-b">
                <h2 class="text-lg font-medium text-gray-800">Contact Information</h2>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Phone</div>
                        <div class="mt-1">
                            <a href="tel:{{ $client->phone }}" class="text-primary-500 hover:text-primary-600">
                                {{ $client->phone }}
                            </a>
                        </div>
                    </div>
                    
                    @if($client->email)
                    <div>
                        <div class="text-sm font-medium text-gray-500">Email</div>
                        <div class="mt-1">
                            <a href="mailto:{{ $client->email }}" class="text-primary-500 hover:text-primary-600">
                                {{ $client->email }}
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($client->address)
                    <div>
                        <div class="text-sm font-medium text-gray-500">Address</div>
                        <div class="mt-1">
                            {{ $client->address }}
                            @if($client->city || $client->state || $client->pincode)
                            <br>
                            {{ $client->city ?? '' }}{{ $client->city && $client->state ? ', ' : '' }}{{ $client->state ?? '' }}
                            {{ $client->pincode ? ' - ' . $client->pincode : '' }}
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Notes -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-50 px-4 py-2 border-b">
                <h2 class="text-lg font-medium text-gray-800">Notes</h2>
            </div>
            <div class="p-4">
                @if($client->notes)
                <p class="text-gray-700 whitespace-pre-line">{{ $client->notes }}</p>
                @else
                <p class="text-gray-500 italic">No notes available</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Tabs for related data -->
    <div class="mt-8">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="#projects" class="tab-link active-tab border-b-2 border-primary-500 py-4 px-6 text-center text-primary-600 font-medium">
                    <i class="fas fa-project-diagram mr-2"></i> Projects
                </a>
                
                @can('viewFinancials', $client)
                <a href="#financials" class="tab-link border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-money-bill-wave mr-2"></i> Financials
                </a>
                @endcan
                
                <a href="#documents" class="tab-link border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-file mr-2"></i> Documents
                </a>
                
                <a href="#site-visits" class="tab-link border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-hard-hat mr-2"></i> Site Visits
                </a>
            </nav>
        </div>
        
        <!-- Tab Content -->
        <div class="py-6">
            <!-- Projects Tab -->
            <div id="projects-content" class="tab-content">
                @if($client->projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($client->projects as $project)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 border-b">
                            <div class="flex justify-between items-center">
                                <h3 class="text-md font-medium text-gray-800">{{ $project->name }}</h3>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $project->status === 'concept' ? 'bg-blue-100 text-blue-800' : 
                                      ($project->status === 'design' ? 'bg-purple-100 text-purple-800' : 
                                      ($project->status === 'execution' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')) }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="mb-4">
                                <div class="text-sm font-medium text-gray-500">Project Value</div>
                                <div class="mt-1 text-lg font-semibold">₹{{ number_format($project->value, 2) }}</div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="text-sm font-medium text-gray-500">Timeline</div>
                                <div class="mt-1">{{ $project->start_date->format('d M Y') }} - {{ $project->end_date ? $project->end_date->format('d M Y') : 'Ongoing' }}</div>
                            </div>
                            
                            <a href="{{ route('projects.show', $project) }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                                View Project
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">No projects found for this client.</p>
                    @can('create', App\Models\Project::class)
                    <a href="{{ route('projects.create', ['client_id' => $client->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                        <i class="fas fa-plus mr-2"></i> Create Project
                    </a>
                    @endcan
                </div>
                @endif
            </div>
            
            <!-- Other tab contents would be here but hidden initially -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                tabLinks.forEach(tab => {
                    tab.classList.remove('active-tab', 'border-primary-500', 'text-primary-600');
                    tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700');
                });
                
                // Add active class to current tab
                this.classList.add('active-tab', 'border-primary-500', 'text-primary-600');
                this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700');
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Show current tab content
                const tabId = this.getAttribute('href').substring(1);
                document.getElementById(tabId + '-content').classList.remove('hidden');
            });
        });
    });
</script>
@endpush
@endsection 