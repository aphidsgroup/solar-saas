@extends('layouts.app')

@section('title', 'Projects')

@section('page_header', true)

@section('page_icon')
    <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
    </div>
@endsection

@section('page_title', 'Projects')

@section('page_subtitle', 'Track and manage interior design projects')

@section('page_actions')
    @can('create', App\Models\Project::class)
        <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            New Project
        </a>
    @endcan
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                <!-- Filters -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <form action="{{ route('projects.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All Statuses</option>
                                <option value="concept" {{ request('status') == 'concept' ? 'selected' : '' }}>Concept</option>
                                <option value="design" {{ request('status') == 'design' ? 'selected' : '' }}>Design</option>
                                <option value="execution" {{ request('status') == 'execution' ? 'selected' : '' }}>Execution</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" id="type" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All Types</option>
                                <option value="Residential" {{ request('type') == 'Residential' ? 'selected' : '' }}>Residential</option>
                                <option value="Commercial" {{ request('type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                <option value="Retail" {{ request('type') == 'Retail' ? 'selected' : '' }}>Retail</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search projects..." class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Projects List -->
                @if(count($projects) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                        <div class="bg-gray-50 px-4 py-2 border-b">
                            <div class="flex justify-between items-center">
                                <h3 class="text-md font-medium text-gray-800">{{ $project->name }}</h3>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-primary-500 text-white">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="mb-4">
                                <div class="text-sm font-medium text-gray-500">Client</div>
                                <div class="mt-1">{{ $project->client->name }}</div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="text-sm font-medium text-gray-500">Type</div>
                                <div class="mt-1">{{ $project->type }}</div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="text-sm font-medium text-gray-500">Timeline</div>
                                <div class="mt-1">{{ $project->start_date->format('d M Y') }} - {{ $project->estimated_completion_date ? $project->estimated_completion_date->format('d M Y') : 'Ongoing' }}</div>
                            </div>
                            
                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Budget</div>
                                    <div class="mt-1">₹{{ number_format($project->budget, 2) }}</div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Area</div>
                                    <div class="mt-1">{{ number_format($project->area, 2) }} {{ $project->area_unit }}</div>
                                </div>
                            </div>
                            
                            <a href="{{ route('projects.show', $project) }}" class="block text-center bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md">
                                View Project
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $projects->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <p class="text-gray-500 mb-4">No projects found</p>
                    @can('create', App\Models\Project::class)
                    <a href="{{ route('projects.create') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Create Your First Project
                    </a>
                    @endcan
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 