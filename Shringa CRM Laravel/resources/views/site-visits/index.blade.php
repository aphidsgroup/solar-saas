@extends('layouts.app')

@section('title', 'Site Visits')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Site Visits</h2>
                    
                    @can('create', App\Models\SiteVisit::class)
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('site-visits.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            New Site Visit
                        </a>
                    </div>
                    @endcan
                </div>
                
                <!-- Filters -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <form action="{{ route('site-visits.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All Statuses</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="visit_type" class="block text-sm font-medium text-gray-700 mb-1">Visit Type</label>
                            <select name="visit_type" id="visit_type" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All Types</option>
                                <option value="initial_survey" {{ request('visit_type') == 'initial_survey' ? 'selected' : '' }}>Initial Survey</option>
                                <option value="measurement" {{ request('visit_type') == 'measurement' ? 'selected' : '' }}>Measurement</option>
                                <option value="review" {{ request('visit_type') == 'review' ? 'selected' : '' }}>Review</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search site visits..." class="form-input rounded-md shadow-sm mt-1 block w-full">
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
                
                <!-- Site Visits List -->
                @if(count($siteVisits) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 sticky-table-header">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client/Project</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($siteVisits as $visit)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $visit->visit_date->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ date('h:i A', strtotime($visit->start_time)) }} - 
                                        {{ $visit->end_time ? date('h:i A', strtotime($visit->end_time)) : 'TBD' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($visit->client)
                                            <a href="{{ route('clients.show', $visit->client) }}" class="text-primary-500 hover:text-primary-600">
                                                {{ $visit->client->name }}
                                            </a>
                                        @elseif($visit->lead)
                                            <a href="{{ route('leads.show', $visit->lead) }}" class="text-primary-500 hover:text-primary-600">
                                                {{ $visit->lead->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-500">No Client/Lead</span>
                                        @endif
                                    </div>
                                    @if($visit->project)
                                    <div class="text-xs text-gray-500">
                                        <a href="{{ route('projects.show', $visit->project) }}" class="text-primary-500 hover:text-primary-600">
                                            {{ $visit->project->name }}
                                        </a>
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $visit->visit_type)) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">{{ $visit->address }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-500 text-white">
                                        {{ ucfirst($visit->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($visit->assignedUser)
                                            {{ $visit->assignedUser->name }}
                                        @else
                                            <span class="text-gray-500">Unassigned</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('site-visits.show', $visit) }}" class="text-primary-500 hover:text-primary-600" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        
                                        @if($visit->status !== 'completed' && $visit->status !== 'cancelled')
                                            @if(!$visit->checked_in_at)
                                            <form action="{{ route('site-visits.check-in', $visit) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-primary-500 hover:text-primary-600" title="Check In">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @elseif(!$visit->checked_out_at)
                                            <form action="{{ route('site-visits.check-out', $visit) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-primary-500 hover:text-primary-600" title="Check Out">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        @endif
                                        
                                        @if(!$visit->client_notified)
                                        <form action="{{ route('site-visits.notify-client', $visit) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-primary-500 hover:text-primary-600" title="Notify Client">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                        
                                        @can('update', $visit)
                                        <a href="{{ route('site-visits.edit', $visit) }}" class="text-primary-500 hover:text-primary-600" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        @endcan
                                        
                                        @can('delete', $visit)
                                        <form action="{{ route('site-visits.destroy', $visit) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this site visit?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-primary-500 hover:text-primary-600" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6">
                    {{ $siteVisits->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-gray-500 mb-4">No site visits found</p>
                    @can('create', App\Models\SiteVisit::class)
                    <a href="{{ route('site-visits.create') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Schedule Your First Site Visit
                    </a>
                    @endcan
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 