@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold">Profile</h2>
        <div class="mt-4">
            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Phone:</strong> {{ auth()->user()->phone ?? '-' }}</p>
            <p><strong>Address:</strong> {{ auth()->user()->address ?? '-' }}</p>
        </div>
    </div>
@endsection
