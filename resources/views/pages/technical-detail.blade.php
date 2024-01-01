@extends('partials.index')
@section('content')
    <div class="card text-center">
        <div class="card-header">
            By {{ $technical->user->name }} on {{ $technical->created_at->format('d M Y') }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $technical->title }}</h5>
            <p class="card-text">{{ $technical->description }}</p>
            <div class="row">
                <div class="col">
                    @foreach ($technical->tags as $tag)
                        <span class="badge rounded-pill text-bg-secondary">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('technicals.downloadFile', $technical->id) }}" class="btn btn-primary mt-4"><i
                    class="bi bi-download"></i> download file</a>
        </div>
        <div class="card-footer text-muted">
            {{ $technical->created_at->diffForHumans() }}
        </div>
    </div>
@endsection
