@extends('layouts.app')

@section('title', 'Documents')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Documents</h2>
                    
                    @can('create', App\Models\Document::class)
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('documents.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Upload Document
                        </a>
                    </div>
                    @endcan
                </div>
                
                <!-- Filters -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <form action="{{ route('documents.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category" id="category" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All Categories</option>
                                <option value="contract" {{ request('category') == 'contract' ? 'selected' : '' }}>Contracts</option>
                                <option value="invoice" {{ request('category') == 'invoice' ? 'selected' : '' }}>Invoices</option>
                                <option value="quotation" {{ request('category') == 'quotation' ? 'selected' : '' }}>Quotations</option>
                                <option value="design" {{ request('category') == 'design' ? 'selected' : '' }}>Design Files</option>
                                <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="related_to" class="block text-sm font-medium text-gray-700 mb-1">Related To</label>
                            <select name="related_to" id="related_to" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All</option>
                                <option value="client" {{ request('related_to') == 'client' ? 'selected' : '' }}>Client</option>
                                <option value="project" {{ request('related_to') == 'project' ? 'selected' : '' }}>Project</option>
                                <option value="invoice" {{ request('related_to') == 'invoice' ? 'selected' : '' }}>Invoice</option>
                                <option value="quotation" {{ request('related_to') == 'quotation' ? 'selected' : '' }}>Quotation</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search documents..." class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Documents List -->
                @if(isset($documents) && count($documents) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 sticky-table-header">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Related To</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded By</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($documents as $document)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded bg-gray-100">
                                            @php
                                                $extension = pathinfo($document->filename, PATHINFO_EXTENSION);
                                                $color = 'text-gray-500';
                                                
                                                if (in_array($extension, ['pdf'])) {
                                                    $color = 'text-red-500';
                                                } elseif (in_array($extension, ['doc', 'docx'])) {
                                                    $color = 'text-blue-500';
                                                } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                                    $color = 'text-green-500';
                                                } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                    $color = 'text-purple-500';
                                                }
                                            @endphp
                                            <span class="{{ $color }} uppercase font-bold text-xs">{{ $extension }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $document->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $document->filename }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $document->category === 'contract' ? 'bg-blue-100 text-blue-800' : 
                                        ($document->category === 'invoice' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($document->category === 'quotation' ? 'bg-green-100 text-green-800' : 
                                        ($document->category === 'design' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'))) }}">
                                        {{ ucfirst($document->category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($document->documentable_type && $document->documentable)
                                        @php
                                            $type = class_basename($document->documentable_type);
                                            $url = '';
                                            
                                            if ($type == 'Client') {
                                                $url = route('clients.show', $document->documentable_id);
                                                $name = $document->documentable->name;
                                            } elseif ($type == 'Project') {
                                                $url = route('projects.show', $document->documentable_id);
                                                $name = $document->documentable->name;
                                            } elseif ($type == 'Invoice') {
                                                $url = route('invoices.show', $document->documentable_id);
                                                $name = $document->documentable->invoice_number;
                                            } elseif ($type == 'Quotation') {
                                                $url = route('quotations.show', $document->documentable_id);
                                                $name = $document->documentable->quotation_number;
                                            }
                                        @endphp
                                        
                                        <div class="text-sm">
                                            <span class="text-gray-500">{{ $type }}:</span>
                                            <a href="{{ $url }}" class="text-blue-600 hover:text-blue-900">{{ $name }}</a>
                                        </div>
                                    @else
                                        <span class="text-gray-500">No relation</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $document->user->name ?? 'System' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @php
                                            $size = $document->size;
                                            if ($size < 1024) {
                                                echo $size . ' bytes';
                                            } elseif ($size < 1024 * 1024) {
                                                echo round($size / 1024, 2) . ' KB';
                                            } else {
                                                echo round($size / (1024 * 1024), 2) . ' MB';
                                            }
                                        @endphp
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $document->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $document->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('documents.download', $document) }}" class="text-blue-600 hover:text-blue-900" title="Download">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        
                                        @can('update', $document)
                                        <a href="{{ route('documents.edit', $document) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        @endcan
                                        
                                        @can('delete', $document)
                                        <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
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
                    {{ $documents->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500 mb-4">No documents found</p>
                    @can('create', App\Models\Document::class)
                    <a href="{{ route('documents.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Upload Your First Document
                    </a>
                    @endcan
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 