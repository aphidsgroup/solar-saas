@extends('layouts.app')

@section('title', 'Client Financials - ' . $client->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i> Back to Client
        </a>
    </div>
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Financial Summary: {{ $client->name }}</h1>
            @if($client->company_name)
            <p class="text-gray-600">{{ $client->company_name }}</p>
            @endif
        </div>
        
        <div class="mt-4 md:mt-0 flex space-x-2">
            @can('create', App\Models\Quotation::class)
            <a href="{{ route('quotations.create', ['client_id' => $client->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                <i class="fas fa-file-invoice mr-2"></i> New Quotation
            </a>
            @endcan
            
            @can('create', App\Models\Invoice::class)
            <a href="{{ route('invoices.create', ['client_id' => $client->id]) }}" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md">
                <i class="fas fa-file-invoice-dollar mr-2"></i> New Invoice
            </a>
            @endcan
        </div>
    </div>
    
    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="text-sm font-medium text-gray-500 mb-1">Total Quoted</div>
            <div class="text-2xl font-semibold text-blue-600">₹{{ number_format($summary['total_quoted'], 2) }}</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="text-sm font-medium text-gray-500 mb-1">Total Invoiced</div>
            <div class="text-2xl font-semibold text-green-600">₹{{ number_format($summary['total_invoiced'], 2) }}</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="text-sm font-medium text-gray-500 mb-1">Total Paid</div>
            <div class="text-2xl font-semibold text-green-700">₹{{ number_format($summary['total_paid'], 2) }}</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="text-sm font-medium text-gray-500 mb-1">Total Due</div>
            <div class="text-2xl font-semibold text-red-600">₹{{ number_format($summary['total_due'], 2) }}</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="text-sm font-medium text-gray-500 mb-1">Overdue Invoices</div>
            <div class="text-2xl font-semibold text-red-600">{{ $summary['overdue_invoices'] }}</div>
        </div>
    </div>
    
    <!-- Financial Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="#quotations" class="financial-tab active-tab border-b-2 border-blue-500 py-4 px-6 text-center text-blue-600 font-medium">
                    <i class="fas fa-file-invoice mr-2"></i> Quotations
                </a>
                <a href="#invoices" class="financial-tab border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-file-invoice-dollar mr-2"></i> Invoices
                </a>
                <a href="#payments" class="financial-tab border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-money-bill-wave mr-2"></i> Payments
                </a>
            </nav>
        </div>
    </div>
    
    <!-- Quotations Tab -->
    <div id="quotations-content" class="financial-content">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($client->quotations->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quotation #</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($client->quotations as $quotation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $quotation->quotation_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $quotation->date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($quotation->project)
                                <a href="{{ route('projects.show', $quotation->project) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $quotation->project->name }}
                                </a>
                                @else
                                <span class="text-gray-500">No Project</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">₹{{ number_format($quotation->total, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $quotation->status === 'draft' ? 'bg-gray-100 text-gray-800' : 
                                  ($quotation->status === 'sent' ? 'bg-blue-100 text-blue-800' : 
                                  ($quotation->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                {{ ucfirst($quotation->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('quotations.show', $quotation) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @can('update', $quotation)
                                <a href="{{ route('quotations.edit', $quotation) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                
                                @can('delete', $quotation)
                                <form action="{{ route('quotations.destroy', $quotation) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this quotation?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
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
            @else
            <div class="p-6 text-center text-gray-500">
                <p>No quotations found for this client.</p>
                @can('create', App\Models\Quotation::class)
                <a href="{{ route('quotations.create', ['client_id' => $client->id]) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    <i class="fas fa-plus mr-1"></i> Create Quotation
                </a>
                @endcan
            </div>
            @endif
        </div>
    </div>
    
    <!-- Invoices Tab -->
    <div id="invoices-content" class="financial-content hidden">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($client->invoices->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($client->invoices as $invoice)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $invoice->date->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">Due: {{ $invoice->due_date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($invoice->project)
                                <a href="{{ route('projects.show', $invoice->project) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $invoice->project->name }}
                                </a>
                                @else
                                <span class="text-gray-500">No Project</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">₹{{ number_format($invoice->total, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm {{ $invoice->amount_due > 0 ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                                ₹{{ number_format($invoice->amount_due, 2) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $invoice->status === 'draft' ? 'bg-gray-100 text-gray-800' : 
                                  ($invoice->status === 'sent' ? 'bg-blue-100 text-blue-800' : 
                                  ($invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                  ($invoice->status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'))) }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @can('update', $invoice)
                                <a href="{{ route('invoices.edit', $invoice) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                
                                @can('recordPayment', $invoice)
                                <a href="{{ route('invoices.record-payment', $invoice) }}" class="text-green-600 hover:text-green-900" title="Record Payment">
                                    <i class="fas fa-money-bill-wave"></i>
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-6 text-center text-gray-500">
                <p>No invoices found for this client.</p>
                @can('create', App\Models\Invoice::class)
                <a href="{{ route('invoices.create', ['client_id' => $client->id]) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    <i class="fas fa-plus mr-1"></i> Create Invoice
                </a>
                @endcan
            </div>
            @endif
        </div>
    </div>
    
    <!-- Payments Tab -->
    <div id="payments-content" class="financial-content hidden">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if(isset($payments) && $payments->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $payment->date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <a href="{{ route('invoices.show', $payment->invoice) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $payment->invoice->invoice_number }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">₹{{ number_format($payment->amount, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ ucfirst($payment->payment_method) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $payment->reference_number ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $payment->notes ?? '-' }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-6 text-center text-gray-500">
                <p>No payment records found for this client.</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const financialTabs = document.querySelectorAll('.financial-tab');
        const financialContents = document.querySelectorAll('.financial-content');
        
        financialTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                financialTabs.forEach(tab => {
                    tab.classList.remove('active-tab', 'border-blue-500', 'text-blue-600');
                    tab.classList.add('border-transparent', 'text-gray-500');
                });
                
                // Add active class to current tab
                this.classList.add('active-tab', 'border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-gray-500');
                
                // Hide all tab contents
                financialContents.forEach(content => {
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