@extends('partials.index')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @error('failed')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    @error('title')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    @error('description')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    @error('category_id')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    {{-- header --}}
    <form action="{{ route('stories.index') }}">
        <div class="row justify-content-center mb-2">
            <div class="col-2 text-end">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addModal"><i
                        class="bi bi-book"></i> Create</button>
            </div>
            <div class="col-3">
                <div class="form-outline mb-4">
                    <select class="form-select" aria-label="Search" name="by">
                        <option value="all" selected>filter by all</option>
                        <option value="owned">filter by owned</option>
                        <option value="except me">filter by except me</option>
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
                    @if (auth()->user()->id == $data->user_id)
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                            data-bs-id="{{ $data->id }}" data-bs-title="{{ $data->title }}"
                            data-bs-description="{{ $data->description }}"
                            data-bs-category-id="{{ $data->category->id }}"><i class="bi bi-pencil-square"></i>
                        </button>
                    @endif
                    <a href="{{ route('stories.show', $data->id) }}" class="btn btn-outline-dark"><i class="bi bi-eye"></i>
                        Go
                        view</a>
                    @if (auth()->user()->id == $data->user_id)
                        <form action="{{ route('stories.destroy', $data->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    <!-- Modal add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add new story test</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('stories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="name" class="form-control form-control"
                                placeholder="Enter a title" name="title" required />
                            <label class="form-label" for="tile">Title</label>
                        </div>
                        <div class="form-outline mb-4">
                            <textarea type="text" id="name" class="form-control form-control" placeholder="Enter a description"
                                name="description" required></textarea>
                            <label class="form-label" for="description">Description</label>
                        </div>
                        <div class="form-outline mb-4">
                            <select class="form-select" aria-label="Search" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="email">Category</label>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit story technical test</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('stories.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <!-- Hidden input for ID -->
                        <input type="hidden" id="edit-id" name="id">

                        <!-- Title input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="edit-title" class="form-control form-control"
                                placeholder="Enter a valid title" name="title" required />
                            <label class="form-label" for="edit-title">Title</label>
                        </div>

                        <!-- Description input -->
                        <div class="form-outline mb-4">
                            <textarea type="text" id="edit-description" class="form-control form-control" placeholder="Enter a description"
                                name="description" required></textarea>
                            <label class="form-label" for="edit-description">Description</label>
                        </div>

                        <!-- Category input -->
                        <div class="form-outline mb-4">
                            <select class="form-select" aria-label="Select category" name="category_id"
                                id="edit-category">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="edit-category">Category</label>
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
            const title = button.getAttribute('data-bs-title');
            const description = button.getAttribute('data-bs-description');
            const category_id = button.getAttribute('data-bs-category-id');

            // Set values in the form
            const modalBodyId = editModal.querySelector('#edit-id');
            modalBodyId.value = id;
            const modalBodyTitle = editModal.querySelector('#edit-title');
            modalBodyTitle.value = title;
            const modalBodyDescription = editModal.querySelector('#edit-description');
            modalBodyDescription.value = description;
            const modalBodyCategory = editModal.querySelector('#edit-category');
            modalBodyCategory.value = category_id;

            // Trigger Select2 to update its display
            $('#edit-category').trigger('change');
        });
    </script>
@endsection
