@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lead Analytics') }}
        </h2>
        <a href="{{ route('leads.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Leads
        </a>
    </div>
@endsection

@section('content')
    <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Summary Statistics -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Leads -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/60 glass-card hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary-500 rounded-full p-3">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Leads</dt>
                                <dd>
                                    <div class="text-lg font-semibold text-gray-900">{{ $totalLeads }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Converted Leads -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/60 glass-card hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary-500 rounded-full p-3">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Converted Leads</dt>
                                <dd>
                                    <div class="text-lg font-semibold text-gray-900">{{ $convertedLeads }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Conversion Rate -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/60 glass-card hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-primary-500 rounded-full p-3">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Conversion Rate</dt>
                                <dd>
                                    <div class="text-lg font-semibold text-gray-900">{{ number_format($conversionRate, 1) }}%</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Leads by Source Chart -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/60 glass-card">
                <div class="border-b border-gray-200 bg-gray-50/70 px-6 py-3">
                    <h3 class="text-lg font-semibold text-gray-700">Leads by Source</h3>
                </div>
                <div class="p-6">
                    @if($leadsBySource->count() > 0)
                        <div class="space-y-4">
                            @foreach($leadsBySource as $source)
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $source->source }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $source->count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-primary-500 h-2 rounded-full" style="width: {{ ($source->count / $totalLeads) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center">No data available</p>
                    @endif
                </div>
            </div>
            
            <!-- Leads by Status Chart -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/60 glass-card">
                <div class="border-b border-gray-200 bg-gray-50/70 px-6 py-3">
                    <h3 class="text-lg font-semibold text-gray-700">Leads by Status</h3>
                </div>
                <div class="p-6">
                    @if($leadsByStatus->count() > 0)
                        <div class="space-y-4">
                            @foreach($leadsByStatus as $status)
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $status->status)) }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $status->count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full bg-primary-500" 
                                            style="width: {{ ($status->count / $totalLeads) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center">No data available</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Source Details Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Leads by Source Detail -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/60 glass-card">
                <div class="border-b border-gray-200 bg-gray-50/70 px-6 py-3">
                    <h3 class="text-lg font-semibold text-gray-700">Leads by Source Detail</h3>
                </div>
                <div class="p-6">
                    @if($leadsBySourceDetail->count() > 0)
                        <div class="space-y-4">
                            @foreach($leadsBySourceDetail as $detail)
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $detail->source_detail }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $detail->count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-primary-500 h-2 rounded-full" style="width: {{ ($detail->count / $totalLeads) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center">No source detail data available</p>
                    @endif
                </div>
            </div>
            
            <!-- Leads by Source Campaign -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/60 glass-card">
                <div class="border-b border-gray-200 bg-gray-50/70 px-6 py-3">
                    <h3 class="text-lg font-semibold text-gray-700">Leads by Campaign</h3>
                </div>
                <div class="p-6">
                    @if($leadsBySourceCampaign->count() > 0)
                        <div class="space-y-4">
                            @foreach($leadsBySourceCampaign as $campaign)
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $campaign->source_campaign }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $campaign->count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-primary-500 h-2 rounded-full" style="width: {{ ($campaign->count / $totalLeads) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center">No campaign data available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 