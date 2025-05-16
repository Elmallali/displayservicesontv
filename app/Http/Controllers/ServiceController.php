<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    // عرض جميع الخدمات للـ admin
    public function index()
    {
        $services = Service::latest()->get();
        return view('services.index', compact('services'));
    }

    // نموذج إضافة خدمة
    public function create()
    {
        return view('services.create');
    }

    // حفظ الخدمة
    public function store(Request $request)
    {
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

    // نموذج التعديل
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    // تحديث الخدمة
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $service->title = $request->title;
        $service->description = $request->description;

        if ($request->hasFile('image')) {
            // حذف القديمة إذا كانت موجودة
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $path = $request->file('image')->store('services', 'public');
            $service->image = $path;
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    // حذف الخدمة
    public function destroy(Service $service)
    {
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    // عرض الخدمات للزوار
    public function public()
    {
        $services = Service::latest()->get();
        return view('public', compact('services'));
    }
}
