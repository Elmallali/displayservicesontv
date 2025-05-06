@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Services</h2>
        <a href="{{ route('services.create') }}" class="btn btn-primary">Add New Service</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($services->isEmpty())
        <p>No services found.</p>
    @else
        <div class="row">
            @foreach ($services as $service)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $service->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $service->title }}</h5>
                            <p class="card-text">{{ $service->description }}</p>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
