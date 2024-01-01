@extends('partials.index')
@section('content')
    <div class="card text-center">
        <div class="card-header">
            By {{ $story->user->name }} on {{ $story->created_at->format('d M Y') }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $story->title }}</h5>
            <p class="card-text">{{ $story->description }}</p>
        </div>
        <div class="card-footer text-muted">
            {{ $story->created_at->diffForHumans() }}
        </div>
    </div>
@endsection
