@extends('partials.index')
@section('content')
    <form action="{{ route('role-management.index') }}">
        @csrf
        <div class="row justify-content-center mb-2">
            <div class="col-5 text-center">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search name" aria-label="Search"
                        aria-describedby="addon-wrapping" name="search">
                </div>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-dark">Seacrh</button>
            </div>
        </div>
    </form>

    <div class="mt-3">
        @if ($datas->isEmpty())
            @include('partials.empty')
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->role->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
