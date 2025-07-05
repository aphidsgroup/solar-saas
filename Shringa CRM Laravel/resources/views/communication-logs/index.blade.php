@extends('layouts.app')

@section('title', 'Communication Logs')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Communication Logs</h2>
                    
                    @can('create', App\Models\CommunicationLog::class)
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('communication-logs.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Log Communication
                        </a>
                    </div>
                    @endcan
                </div>
                
                <!-- Filters -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <form action="{{ route('communication-logs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" id="type" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All Types</option>
                                <option value="email" {{ request('type') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="phone" {{ request('type') == 'phone' ? 'selected' : '' }}>Phone Call</option>
                                <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                                <option value="message" {{ request('type') == 'message' ? 'selected' : '' }}>Message</option>
                                <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="related_to" class="block text-sm font-medium text-gray-700 mb-1">Related To</label>
                            <select name="related_to" id="related_to" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All</option>
                                <option value="client" {{ request('related_to') == 'client' ? 'selected' : '' }}>Client</option>
                                <option value="lead" {{ request('related_to') == 'lead' ? 'selected' : '' }}>Lead</option>
                                <option value="project" {{ request('related_to') == 'project' ? 'selected' : '' }}>Project</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search logs..." class="form-input rounded-md shadow-sm mt-1 block w-full">
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
                
                <!-- Communication Logs List -->
                @if(isset($communicationLogs) && count($communicationLogs) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Related To</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logged By</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($communicationLogs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $log->communication_date->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->communication_date->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-500 text-white">
                                        {{ ucfirst($log->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->loggable_type && $log->loggable)
                                        @php
                                            $type = class_basename($log->loggable_type);
                                            $url = '';
                                            
                                            if ($type == 'Client') {
                                                $url = route('clients.show', $log->loggable_id);
                                                $name = $log->loggable->name;
                                            } elseif ($type == 'Lead') {
                                                $url = route('leads.show', $log->loggable_id);
                                                $name = $log->loggable->name;
                                            } elseif ($type == 'Project') {
                                                $url = route('projects.show', $log->loggable_id);
                                                $name = $log->loggable->name;
                                            }
                                        @endphp
                                        
                                        <div class="text-sm">
                                            <span class="text-gray-500">{{ $type }}:</span>
                                            <a href="{{ $url }}" class="text-primary-500 hover:text-primary-600">{{ $name }}</a>
                                        </div>
                                    @else
                                        <span class="text-gray-500">General</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $log->contact_name }}</div>
                                    @if($log->contact_email)
                                    <div class="text-xs text-gray-500">{{ $log->contact_email }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">{{ $log->subject }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $log->user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('communication-logs.show', $log) }}" class="text-primary-500 hover:text-primary-600" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        
                                        @can('update', $log)
                                        <a href="{{ route('communication-logs.edit', $log) }}" class="text-primary-500 hover:text-primary-600" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        @endcan
                                        
                                        @can('delete', $log)
                                        <form action="{{ route('communication-logs.destroy', $log) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this communication log?');">
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
                    {{ $communicationLogs->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-gray-500 mb-4">No communication logs found</p>
                    @can('create', App\Models\CommunicationLog::class)
                    <a href="{{ route('communication-logs.create') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Log Your First Communication
                    </a>
                    @endcan
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 