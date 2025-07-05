@extends('layouts.app')

@section('title', 'Dashboard - Shringa CRM')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
        </svg>
            {{ __('Dashboard') }}
        </h2>
@endsection

@section('content')
    <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Welcome Section -->
        <div class="glass-card overflow-hidden shadow-modern-lg sm:rounded-xl mb-8">
            <div class="p-6 sm:p-8 bg-gradient-to-r from-primary-600 to-secondary-500 text-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="mb-6 md:mb-0">
                        <h3 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h3>
                        <p class="text-white text-lg">{{ now()->format('l, F j, Y') }}</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 rounded-lg text-white hover:bg-opacity-30 transition-all duration-200 ease-in-out shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>My Tasks</span>
                        </a>
                        <a href="{{ route('leads.index') }}" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 rounded-lg text-white hover:bg-opacity-30 transition-all duration-200 ease-in-out shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            <span>View Leads</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Leads -->
            <div class="glass-card overflow-hidden shadow-modern rounded-xl transition-all hover:shadow-modern-lg animate-fade-in">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-primary-500 text-white mr-4 animate-float">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm uppercase font-semibold text-gray-500">Total Leads</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_leads'] }}</p>
                            <div class="flex items-center mt-1 text-sm">
                                <span class="text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                    </svg>
                                    12%
                                </span>
                                <span class="text-gray-500 ml-1">vs. last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Clients -->
            <div class="glass-card overflow-hidden shadow-modern rounded-xl transition-all hover:shadow-modern-lg animate-fade-in" style="animation-delay: 0.1s">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-secondary-500 text-white mr-4 animate-float" style="animation-delay: 0.3s">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm uppercase font-semibold text-gray-500">Total Clients</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_clients'] }}</p>
                            <div class="flex items-center mt-1 text-sm">
                                <span class="text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                    </svg>
                                    8%
                                </span>
                                <span class="text-gray-500 ml-1">vs. last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Active Projects -->
            <div class="glass-card overflow-hidden shadow-modern rounded-xl transition-all hover:shadow-modern-lg animate-fade-in" style="animation-delay: 0.2s">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-success-500 text-white mr-4 animate-float" style="animation-delay: 0.6s">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm uppercase font-semibold text-gray-500">Active Projects</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['active_projects'] }}</p>
                            <div class="flex items-center mt-1 text-sm">
                                <span class="text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                                    </svg>
                                    3%
                                </span>
                                <span class="text-gray-500 ml-1">vs. last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pending Tasks -->
            <div class="glass-card overflow-hidden shadow-modern rounded-xl transition-all hover:shadow-modern-lg animate-fade-in" style="animation-delay: 0.3s">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-warning-500 text-white mr-4 animate-float" style="animation-delay: 0.9s">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm uppercase font-semibold text-gray-500">Pending Tasks</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_tasks'] }}</p>
                            <div class="flex items-center mt-1 text-sm">
                                <span class="text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                    </svg>
                                    5%
                                </span>
                                <span class="text-gray-500 ml-1">completed this week</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Dashboard Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Leads -->
            <div class="glass-card overflow-hidden shadow-modern rounded-xl lg:col-span-1 animate-fade-in" style="animation-delay: 0.4s">
                <div class="flex justify-between items-center p-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Leads</h3>
                    <a href="{{ route('leads.index') }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium flex items-center">
                        View All
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="p-5">
                    @if(count($recent_leads) > 0)
                        <div class="space-y-4">
                            @foreach($recent_leads as $lead)
                                <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold">
                                        {{ substr($lead->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900">{{ $lead->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $lead->email }}</div>
                                    </div>
                                    <div class="text-xs text-gray-500 bg-gray-100 py-1 px-2 rounded-full">
                                        {{ $lead->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No recent leads found</p>
                            <a href="{{ route('leads.create') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition duration-150 ease-in-out text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Lead
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Project Status -->
            <div class="glass-card overflow-hidden shadow-modern rounded-xl lg:col-span-2 animate-fade-in" style="animation-delay: 0.5s">
                <div class="flex justify-between items-center p-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Project Status</h3>
                    <a href="{{ route('projects.index') }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium flex items-center">
                        View All
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="p-5">
                    @if(count($projects) > 0)
                        <div class="space-y-8">
                            @foreach($projects as $project)
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-900">{{ $project->name }}</span>
                                        <span class="text-xs py-1 px-2 rounded-full 
                                            @if($project->progress < 25) bg-danger-100 text-danger-700
                                            @elseif($project->progress < 50) bg-warning-100 text-warning-700
                                            @elseif($project->progress < 75) bg-primary-100 text-primary-700
                                            @else bg-success-100 text-success-700
                                            @endif">
                                            {{ $project->progress }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="h-2.5 rounded-full transition-all duration-500 
                                            @if($project->progress < 25) bg-danger-500
                                            @elseif($project->progress < 50) bg-warning-500
                                            @elseif($project->progress < 75) bg-primary-500
                                            @else bg-success-500
                                            @endif" 
                                            style="width: {{ $project->progress }}%"></div>
                                    </div>
                                    <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                                        <span>Start: {{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</span>
                                        <span class="mx-2 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="ml-1">{{ $project->deadline ? now()->diffInDays($project->deadline, false) . ' days left' : 'No deadline' }}</span>
                                        </span>
                                        <span>Deadline: {{ $project->deadline ? $project->deadline->format('M d, Y') : 'N/A' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-2 text-gray-500">No active projects found</p>
                            <a href="{{ route('projects.create') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition duration-150 ease-in-out text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Create Project
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="glass-card overflow-hidden shadow-modern rounded-xl mt-8 animate-fade-in" style="animation-delay: 0.6s">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
            </div>
            <div class="p-5">
                @if(count($recent_activities) > 0)
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($recent_activities as $index => $activity)
                                <li>
                                    <div class="relative pb-8">
                                        @if($index !== count($recent_activities) - 1)
                                            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                <div class="h-10 w-10 rounded-full flex items-center justify-center ring-8 ring-white
                                                    @if($activity->type === 'lead') bg-primary-100 text-primary-600
                                                    @elseif($activity->type === 'client') bg-secondary-100 text-secondary-600
                                                    @elseif($activity->type === 'project') bg-success-100 text-success-600
                                                    @elseif($activity->type === 'task') bg-warning-100 text-warning-600
                                                    @else bg-gray-100 text-gray-600
                                                    @endif">
                                                    @if($activity->type === 'lead')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                                        </svg>
                                                    @elseif($activity->type === 'client')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                                        </svg>
                                                    @elseif($activity->type === 'project')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    @elseif($activity->type === 'task')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $activity->description }}
                                                    </div>
                                                    <p class="mt-0.5 text-sm text-gray-500">
                                                        {{ $activity->user ? 'By ' . $activity->user->name : 'System' }} · {{ $activity->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-gray-500">No recent activities found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
