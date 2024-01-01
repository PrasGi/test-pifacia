@extends('partials.index')

@section('content')
    {{-- header --}}
    <form action="{{ route('dashboard') }}">
        <div class="row justify-content-center mb-2">
            <div class="col-3">
                <div class="form-outline mb-4">
                    <select class="form-select" aria-label="Search" name="category_id">
                        <option value="0" selected>filter by category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-5 text-center">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search title" aria-label="Search"
                        aria-describedby="addon-wrapping" name="search">
                </div>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-dark">Seacrh</button>
            </div>
        </div>
    </form>
    @if ($datas->isEmpty())
        @include('partials.empty')
    @else
        @foreach ($datas as $data)
            <div class="card shadow">
                <div class="card-header">
                    By {{ $data->user->name }} on {{ $data->created_at->format('d M Y') }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $data->title }}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($data->description, 300) }}</p>
                    <a href="{{ route('technicals.show', $data->id) }}" class="btn btn-outline-dark"><i
                            class="bi bi-eye"></i> Go
                        view</a>
                </div>
            </div>
        @endforeach
    @endif
@endsection
