@extends('layouts.app')

@section('title', 'Client Projects - ' . $client->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i> Back to Client
        </a>
    </div>
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Projects for {{ $client->name }}</h1>
            @if($client->company_name)
            <p class="text-gray-600">{{ $client->company_name }}</p>
            @endif
        </div>
        
        @can('create', App\Models\Project::class)
        <div class="mt-4 md:mt-0">
            <a href="{{ route('projects.create', ['client_id' => $client->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                <i class="fas fa-plus mr-2"></i> New Project
            </a>
        </div>
        @endcan
    </div>
    
    <!-- Project Status Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="#all" class="status-tab active-tab border-b-2 border-blue-500 py-4 px-6 text-center text-blue-600 font-medium">
                    All Projects
                </a>
                <a href="#concept" class="status-tab border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium">
                    Concept
                </a>
                <a href="#design" class="status-tab border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium">
                    Design
                </a>
                <a href="#execution" class="status-tab border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium">
                    Execution
                </a>
                <a href="#completed" class="status-tab border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium">
                    Completed
                </a>
            </nav>
        </div>
    </div>
    
    <!-- All Projects -->
    <div id="all-content" class="status-content">
        @if(count($groupedProjects['concept']) + count($groupedProjects['design']) + count($groupedProjects['execution']) + count($groupedProjects['completed']) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(array_merge($groupedProjects['concept']->toArray(), $groupedProjects['design']->toArray(), $groupedProjects['execution']->toArray(), $groupedProjects['completed']->toArray()) as $project)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-4 py-2 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-md font-medium text-gray-800">{{ $project['name'] }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $project['status'] === 'concept' ? 'bg-blue-100 text-blue-800' : 
                              ($project['status'] === 'design' ? 'bg-purple-100 text-purple-800' : 
                              ($project['status'] === 'execution' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')) }}">
                            {{ ucfirst($project['status']) }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="mb-4">
                        <div class="text-sm font-medium text-gray-500">Project Value</div>
                        <div class="mt-1 text-lg font-semibold">₹{{ number_format($project['value'], 2) }}</div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-sm font-medium text-gray-500">Timeline</div>
                        <div class="mt-1">{{ date('d M Y', strtotime($project['start_date'])) }} - {{ $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Ongoing' }}</div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-sm font-medium text-gray-500">Tasks</div>
                        <div class="mt-1">{{ count($project['tasks'] ?? []) }} tasks</div>
                    </div>
                    
                    <a href="{{ route('projects.show', $project['id']) }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
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
    
    <!-- Concept Projects -->
    <div id="concept-content" class="status-content hidden">
        @if(count($groupedProjects['concept']) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($groupedProjects['concept'] as $project)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-4 py-2 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-md font-medium text-gray-800">{{ $project->name }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            Concept
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
                    
                    <div class="mb-4">
                        <div class="text-sm font-medium text-gray-500">Tasks</div>
                        <div class="mt-1">{{ $project->tasks->count() }} tasks</div>
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
            <p class="text-gray-500">No concept phase projects found for this client.</p>
        </div>
        @endif
    </div>
    
    <!-- Design Projects -->
    <div id="design-content" class="status-content hidden">
        @if(count($groupedProjects['design']) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($groupedProjects['design'] as $project)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-4 py-2 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-md font-medium text-gray-800">{{ $project->name }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            Design
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
                    
                    <div class="mb-4">
                        <div class="text-sm font-medium text-gray-500">Tasks</div>
                        <div class="mt-1">{{ $project->tasks->count() }} tasks</div>
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
            <p class="text-gray-500">No design phase projects found for this client.</p>
        </div>
        @endif
    </div>
    
    <!-- Execution Projects -->
    <div id="execution-content" class="status-content hidden">
        @if(count($groupedProjects['execution']) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($groupedProjects['execution'] as $project)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-4 py-2 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-md font-medium text-gray-800">{{ $project->name }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Execution
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
                    
                    <div class="mb-4">
                        <div class="text-sm font-medium text-gray-500">Tasks</div>
                        <div class="mt-1">{{ $project->tasks->count() }} tasks</div>
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
            <p class="text-gray-500">No execution phase projects found for this client.</p>
        </div>
        @endif
    </div>
    
    <!-- Completed Projects -->
    <div id="completed-content" class="status-content hidden">
        @if(count($groupedProjects['completed']) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($groupedProjects['completed'] as $project)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-4 py-2 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-md font-medium text-gray-800">{{ $project->name }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Completed
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
                        <div class="mt-1">{{ $project->start_date->format('d M Y') }} - {{ $project->end_date ? $project->end_date->format('d M Y') : 'Completed' }}</div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-sm font-medium text-gray-500">Tasks</div>
                        <div class="mt-1">{{ $project->tasks->count() }} tasks</div>
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
            <p class="text-gray-500">No completed projects found for this client.</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusTabs = document.querySelectorAll('.status-tab');
        const statusContents = document.querySelectorAll('.status-content');
        
        statusTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                statusTabs.forEach(tab => {
                    tab.classList.remove('active-tab', 'border-blue-500', 'text-blue-600');
                    tab.classList.add('border-transparent', 'text-gray-500');
                });
                
                // Add active class to current tab
                this.classList.add('active-tab', 'border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-gray-500');
                
                // Hide all tab contents
                statusContents.forEach(content => {
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