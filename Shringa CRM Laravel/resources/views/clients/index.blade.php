@extends('layouts.app')

@section('title', 'Clients')

@section('page_header', true)

@section('page_icon')
    <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
        </svg>
    </div>
@endsection

@section('page_title', 'Clients')

@section('page_subtitle', 'Manage your client relationships and information')

@section('page_actions')
    @can('create', App\Models\Client::class)
        <a href="{{ route('clients.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add Client
        </a>
    @endcan
@endsection

@section('content')
<div class="container mx-auto px-4 py-6">
    
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form action="{{ route('clients.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-grow md:flex-grow-0">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                    <option value="">All Status</option>
                    <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="archived" {{ $status === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            
            <div class="flex-grow md:flex-grow-0">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Client Type</label>
                <select id="type" name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                    <option value="">All Types</option>
                    @foreach($clientTypes as $clientType)
                    <option value="{{ $clientType }}" {{ $type === $clientType ? 'selected' : '' }}>{{ $clientType }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-grow">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <input type="text" id="search" name="search" value="{{ $search }}" placeholder="Search by name, email, phone..." 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 pl-10">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            
            <div class="flex items-end space-x-2 mt-6 md:mt-0">
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                
                <a href="{{ route('clients.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-times mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
    
    <!-- Clients List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($clients->count() > 0)
        <table class="min-w-full divide-y divide-gray-200 sticky-table-header">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($clients as $client)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $client->name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $client->company_name ?? 'Individual' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $client->phone }}</div>
                        <div class="text-sm text-gray-500">{{ $client->email ?? 'No email' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-500 text-white">
                            {{ $client->client_type }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-500 text-white">
                            {{ ucfirst($client->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('clients.show', $client) }}" class="text-primary-500 hover:text-primary-600" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @can('update', $client)
                            <a href="{{ route('clients.edit', $client) }}" class="text-primary-500 hover:text-primary-600" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            
                            @can('delete', $client)
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-primary-500 hover:text-primary-600" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $clients->withQueryString()->links() }}
        </div>
        @else
        <div class="p-6 text-center text-gray-500">
            <p>No clients found matching your criteria.</p>
            <a href="{{ route('clients.index') }}" class="text-primary-500 hover:underline mt-2 inline-block">Clear filters</a>
        </div>
        @endif
    </div>
</div>
@endsection 