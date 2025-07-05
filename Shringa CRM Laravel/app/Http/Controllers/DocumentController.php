<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Client;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Document::class, 'document');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get filter parameters
        $category = $request->input('category');
        $related_to = $request->input('related_to');
        $search = $request->input('search');
        
        // Base query
        $query = Document::query()->with(['user', 'documentable']);
        
        // Apply filters if provided
        if ($category) {
            $query->where('category', $category);
        }
        
        if ($related_to) {
            if ($related_to === 'client') {
                $query->where('documentable_type', Client::class);
            } elseif ($related_to === 'project') {
                $query->where('documentable_type', Project::class);
            } elseif ($related_to === 'invoice') {
                $query->where('documentable_type', Invoice::class);
            } elseif ($related_to === 'quotation') {
                $query->where('documentable_type', Quotation::class);
            }
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('filename', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Get paginated results
        $documents = $query->latest()->paginate(10);
        
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clients = Client::all();
        $projects = Project::all();
        $invoices = Invoice::all();
        $quotations = Quotation::all();
        
        return view('documents.create', compact('clients', 'projects', 'invoices', 'quotations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'document_file' => 'required|file|max:10240', // 10MB max
            'documentable_type' => 'nullable|string',
            'documentable_id' => 'nullable|integer',
        ]);
        
        $file = $request->file('document_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $filename, 'public');
        
        $document = new Document();
        $document->title = $validated['title'];
        $document->description = $validated['description'] ?? null;
        $document->category = $validated['category'];
        $document->filename = $filename;
        $document->path = $path;
        $document->size = $file->getSize();
        $document->mime_type = $file->getMimeType();
        $document->user_id = auth()->id();
        
        // Set polymorphic relationship if applicable
        if (!empty($validated['documentable_type']) && !empty($validated['documentable_id'])) {
            $documentableType = null;
            
            if ($validated['documentable_type'] === 'client') {
                $documentableType = Client::class;
            } elseif ($validated['documentable_type'] === 'project') {
                $documentableType = Project::class;
            } elseif ($validated['documentable_type'] === 'invoice') {
                $documentableType = Invoice::class;
            } elseif ($validated['documentable_type'] === 'quotation') {
                $documentableType = Quotation::class;
            }
            
            if ($documentableType) {
                $document->documentable_type = $documentableType;
                $document->documentable_id = $validated['documentable_id'];
            }
        }
        
        $document->save();
        
        return redirect()->route('documents.index')
            ->with('success', 'Document uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document): View
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document): View
    {
        $clients = Client::all();
        $projects = Project::all();
        $invoices = Invoice::all();
        $quotations = Quotation::all();
        
        return view('documents.edit', compact('document', 'clients', 'projects', 'invoices', 'quotations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'document_file' => 'nullable|file|max:10240', // 10MB max
            'documentable_type' => 'nullable|string',
            'documentable_id' => 'nullable|integer',
        ]);
        
        $document->title = $validated['title'];
        $document->description = $validated['description'] ?? null;
        $document->category = $validated['category'];
        
        // Update the file if a new one is uploaded
        if ($request->hasFile('document_file')) {
            // Delete old file
            Storage::disk('public')->delete($document->path);
            
            // Store new file
            $file = $request->file('document_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');
            
            $document->filename = $filename;
            $document->path = $path;
            $document->size = $file->getSize();
            $document->mime_type = $file->getMimeType();
        }
        
        // Update polymorphic relationship if applicable
        if (!empty($validated['documentable_type']) && !empty($validated['documentable_id'])) {
            $documentableType = null;
            
            if ($validated['documentable_type'] === 'client') {
                $documentableType = Client::class;
            } elseif ($validated['documentable_type'] === 'project') {
                $documentableType = Project::class;
            } elseif ($validated['documentable_type'] === 'invoice') {
                $documentableType = Invoice::class;
            } elseif ($validated['documentable_type'] === 'quotation') {
                $documentableType = Quotation::class;
            }
            
            if ($documentableType) {
                $document->documentable_type = $documentableType;
                $document->documentable_id = $validated['documentable_id'];
            }
        } else {
            $document->documentable_type = null;
            $document->documentable_id = null;
        }
        
        $document->save();
        
        return redirect()->route('documents.index')
            ->with('success', 'Document updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document): RedirectResponse
    {
        // Delete the file from storage
        Storage::disk('public')->delete($document->path);
        
        // Delete the record
        $document->delete();
        
        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully.');
    }
    
    /**
     * Download the specified document.
     */
    public function download(Document $document): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download(storage_path('app/public/' . $document->path), $document->filename);
    }
    
    /**
     * Upload a document.
     */
    public function upload(Request $request): RedirectResponse
    {
        // This is just a convenience method for quick uploads, redirects to store()
        return $this->store($request);
    }
}
