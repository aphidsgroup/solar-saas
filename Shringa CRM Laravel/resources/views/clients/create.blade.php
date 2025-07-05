@extends('layouts.app')

@section('title', 'Add New Client')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('clients.index') }}" class="text-primary-500 hover:text-primary-600">
            <i class="fas fa-arrow-left mr-2"></i> Back to Clients
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h1 class="text-xl font-semibold text-gray-800">Add New Client</h1>
        </div>
        
        <form action="{{ route('clients.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div>
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Basic Information</h2>
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Client Name <span class="text-primary-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('company_name') border-red-500 @enderror">
                        @error('company_name')
                            <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="gst_number" class="block text-sm font-medium text-gray-700 mb-1">GST Number</label>
                        <input type="text" id="gst_number" name="gst_number" value="{{ old('gst_number') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('gst_number') border-red-500 @enderror">
                        @error('gst_number')
                            <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="client_type" class="block text-sm font-medium text-gray-700 mb-1">Client Type <span class="text-primary-500">*</span></label>
                        <select id="client_type" name="client_type" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('client_type') border-red-500 @enderror">
                            <option value="">Select Client Type</option>
                            <option value="Residential" {{ old('client_type') === 'Residential' ? 'selected' : '' }}>Residential</option>
                            <option value="Commercial" {{ old('client_type') === 'Commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="Office" {{ old('client_type') === 'Office' ? 'selected' : '' }}>Office</option>
                            <option value="Other" {{ old('client_type') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('client_type')
                            <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    @if(isset($leads) && $leads->count() > 0)
                    <div class="mb-4">
                        <label for="lead_id" class="block text-sm font-medium text-gray-700 mb-1">Convert from Lead</label>
                        <select id="lead_id" name="lead_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('lead_id') border-red-500 @enderror">
                            <option value="">Select Lead (Optional)</option>
                            @foreach($leads as $lead)
                            <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>{{ $lead->name }} - {{ $lead->phone }}</option>
                            @endforeach
                        </select>
                        @error('lead_id')
                            <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif
                </div>
                
                <!-- Contact Information -->
                <div>
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Contact Information</h2>
                    
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-primary-500">*</span></label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea id="address" name="address" rows="2"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('city') border-red-500 @enderror">
                            @error('city')
                                <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                            <input type="text" id="state" name="state" value="{{ old('state') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('state') border-red-500 @enderror">
                            @error('state')
                                <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="pincode" class="block text-sm font-medium text-gray-700 mb-1">Pincode</label>
                        <input type="text" id="pincode" name="pincode" value="{{ old('pincode') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('pincode') border-red-500 @enderror">
                        @error('pincode')
                            <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Notes -->
            <div class="mt-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea id="notes" name="notes" rows="3"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-primary-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Submit Button -->
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white py-2 px-6 rounded-md">
                    <i class="fas fa-save mr-2"></i> Save Client
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 