@extends('partials.index')
@section('content')
    {{-- header --}}
    <form action="{{ route('history.story') }}">
        <div class="row justify-content-center mb-2">
            <div class="col-5 text-center">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search note" aria-label="Search"
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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Action</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $index => $data)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $data->action }}</td>
                        <td>{{ $data->user->name }}</td>
                        <td>{{ $data->user->role->name }}</td>
                        <td>{{ $data->note }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
