@extends('partials.index')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @error('name')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    {{-- header --}}
    <form action="{{ route('categories.index') }}">
        <div class="row justify-content-center mb-2">
            <div class="col text-end">
                <a href="{{ route('categories.export') }}" class="btn btn-primary"><i class="bi bi-download"></i>
                    Export</a>
            </div>
            <div class="col ">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal"><i
                        class="bi bi-upload"></i>
                    Import</button>
            </div>
            <div class="col-5 text-end">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search name" aria-label="Search"
                        aria-describedby="addon-wrapping" name="search">
                </div>
            </div>
            <div class="col text-end">
                <button type="submit" class="btn btn-dark">Seacrh</button>
            </div>
            <div class="col ">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addModal"><i
                        class="bi bi-bounding-box"></i>
                    Create</button>
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
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $data->name }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal" data-bs-id="{{ $data->id }}"
                                    data-bs-name="{{ $data->name }}"><i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('categories.destroy', $data->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-danger"><i
                                            class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modal import -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add new category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="file" id="name" class="form-control form-control"
                                placeholder="Enter a valid username" name="file" required />
                            <label class="form-label" for="name">File</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add new category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="name" class="form-control form-control-lg"
                                placeholder="Enter a valid username" name="name" required />
                            <label class="form-label" for="name">Name</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.update') }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <!-- Hidden input for ID -->
                        <input type="hidden" id="edit-id" name="id">

                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="edit-name" class="form-control form-control-lg"
                                placeholder="Enter a valid username" name="name" required />
                            <label class="form-label" for="edit-name">Name</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const editModal = document.getElementById('editModal');

        editModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id');
            const name = button.getAttribute('data-bs-name');

            const modalBodyId = editModal.querySelector('#edit-id');
            modalBodyId.value = id;
            const modalBodyName = editModal.querySelector('#edit-name');
            modalBodyName.value = name;
        });
    </script>
@endsection
