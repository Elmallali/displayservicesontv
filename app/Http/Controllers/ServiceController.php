<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index()
    {
        $services = Service::latest()->get();
        return view('services.index', compact('services'));
    }

    
    public function create()
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('services.index')
                ->with('error', 'You do not have permission to create services.');
        }
        
        return view('services.create');
    }

    
    public function store(Request $request)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('services.index')
                ->with('error', 'You do not have permission to create services.');
        }
        
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $service = new Service();
        $service->title = $request->title;
        $service->description = $request->description;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $service->image = $path;
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'Service added successfully.');
    }

    
    public function edit(Service $service)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('services.index')
                ->with('error', 'You do not have permission to edit services.');
        }
        
        return view('services.edit', compact('service'));
    }

    
    public function update(Request $request, Service $service)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('services.index')
                ->with('error', 'You do not have permission to update services.');
        }
        
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $service->title = $request->title;
        $service->description = $request->description;

        if ($request->hasFile('image')) {
            
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $path = $request->file('image')->store('services', 'public');
            $service->image = $path;
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    
    public function destroy(Service $service)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('services.index')
                ->with('error', 'You do not have permission to delete services.');
        }
        
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    
    public function public()
    {
        $services = Service::latest()->get();
        return view('public', compact('services'));
    }
}
