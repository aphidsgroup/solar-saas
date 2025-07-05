<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SiteVisitController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\CommunicationLogController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Authentication required routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Root route - redirect to clients
    Route::get('/', function () {
        return redirect()->route('clients.index');
    });
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Leads management
    Route::resource('leads', LeadController::class);
    Route::get('/leads-analytics', [LeadController::class, 'analytics'])->name('leads.analytics');
    Route::get('/leads/{lead}/convert-to-client', [LeadController::class, 'convertToClient'])->name('leads.convert');
    
    // Clients management
    Route::resource('clients', ClientController::class);
    
    // Projects management
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/dashboard', [ProjectController::class, 'dashboard'])->name('projects.dashboard');
    
    // Quotations management
    Route::resource('quotations', QuotationController::class);
    Route::post('/quotations/{quotation}/send', [QuotationController::class, 'send'])->name('quotations.send');
    Route::get('/quotations/{quotation}/download', [QuotationController::class, 'download'])->name('quotations.download');
    
    // Invoices management
    Route::resource('invoices', InvoiceController::class);
    Route::post('/invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('/invoices/{invoice}/record-payment', [InvoiceController::class, 'recordPayment'])->name('invoices.record-payment');
    Route::post('/invoices/{invoice}/send-reminder', [InvoiceController::class, 'sendReminder'])->name('invoices.send-reminder');
    Route::get('/invoices-analytics', [InvoiceController::class, 'analytics'])->name('invoices.analytics');
    
    // Payments management
    Route::resource('payments', PaymentController::class);
    Route::get('/payments/{payment}/download-receipt', [PaymentController::class, 'downloadReceipt'])->name('payments.download-receipt');
    Route::post('/payments/{payment}/send-receipt', [PaymentController::class, 'sendReceipt'])->name('payments.send-receipt');
    
    // Site visits management
    Route::resource('site-visits', SiteVisitController::class);
    Route::post('/site-visits/{siteVisit}/check-in', [SiteVisitController::class, 'checkIn'])->name('site-visits.check-in');
    Route::post('/site-visits/{siteVisit}/check-out', [SiteVisitController::class, 'checkOut'])->name('site-visits.check-out');
    Route::post('/site-visits/{siteVisit}/notify-client', [SiteVisitController::class, 'notifyClient'])->name('site-visits.notify-client');
    Route::get('/site-visits/{siteVisit}/report', [SiteVisitController::class, 'generateReport'])->name('site-visits.report');
    Route::post('/site-visits/{siteVisit}/share-report', [SiteVisitController::class, 'shareReport'])->name('site-visits.share-report');
    Route::post('/site-visits/{siteVisit}/upload-photos', [SiteVisitController::class, 'uploadPhotos'])->name('site-visits.upload-photos');
    Route::post('/site-visits/{siteVisit}/upload-documents', [SiteVisitController::class, 'uploadDocuments'])->name('site-visits.upload-documents');
    Route::get('/site-visits-calendar', [SiteVisitController::class, 'calendar'])->name('site-visits.calendar');
    
    // Documents management
    Route::resource('documents', DocumentController::class);
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    
    // Tasks management
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{task}/complete', [TaskController::class, 'markComplete'])->name('tasks.complete');
    
    // Daily reports management
    Route::resource('daily-reports', DailyReportController::class);
    Route::post('/daily-reports/{dailyReport}/share-with-client', [DailyReportController::class, 'shareWithClient'])->name('daily-reports.share');
    
    // Communication logs management
    Route::resource('communication-logs', CommunicationLogController::class);
});

// Admin only routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::get('/reports/performance', [DashboardController::class, 'performanceReports'])->name('reports.performance');
    Route::get('/reports/sales', [DashboardController::class, 'salesReports'])->name('reports.sales');
    Route::get('/reports/projects', [DashboardController::class, 'projectReports'])->name('reports.projects');
});

// Public quotation routes (no auth required)
Route::get('/quotations/view/{token}', [QuotationController::class, 'publicView'])->name('quotations.public.view');
Route::post('/quotations/status/{token}', [QuotationController::class, 'updateStatus'])->name('quotations.public.update-status');

require __DIR__.'/auth.php';
