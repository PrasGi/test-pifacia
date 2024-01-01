@extends('partials.index')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @error('email')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('name')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('password')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    <form action="{{ route('accounts.index') }}">
        @csrf
        <div class="row justify-content-center mb-2">
            <div class="col-2 text-end">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addModal"><i
                        class="bi bi-person"></i>
                    Create</button>
            </div>
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
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $index => $data)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->role->name }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal" data-bs-id="{{ $data->id }}"
                                    data-bs-name="{{ $data->name }}" data-bs-email="{{ $data->email }}"
                                    data-bs-role-id="{{ $data->role->id }}"><i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                                    data-bs-target="#editPasswordModal" data-bs-password-id="{{ $data->id }}"><i
                                        class="bi bi-key"></i>
                                </button>
                                <form action="{{ route('accounts.destroy', $data->id) }}" method="post" class="d-inline">
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

    <!-- Modal add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add new account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="name" class="form-control form-control-lg"
                                placeholder="Enter a valid username" name="name" required />
                            <label class="form-label" for="name">Name</label>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="email" class="form-control form-control-lg"
                                placeholder="Enter a valid email" name="email" required />
                            <label class="form-label" for="email">Email</label>
                        </div>

                        <div class="form-outline mb-4">
                            <select class="form-select" aria-label="Search" name="role_id">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="email">Role</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" id="password" class="form-control form-control-lg"
                                placeholder="Enter password" name="password" required />
                            <label class="form-label" for="password">Password</label>
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
                <form action="{{ route('accounts.update') }}" method="post">
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

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="edit-email" class="form-control form-control-lg"
                                placeholder="Enter a valid email" name="email" required />
                            <label class="form-label" for="edit-email">Email</label>
                        </div>

                        <!-- Role select -->
                        <div class="form-outline mb-4">
                            <select class="form-select" name="role_id" id="edit-role">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="edit-role">Role</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit password -->
    <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit password account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('accounts.password') }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <!-- Hidden input for ID -->
                        <input type="hidden" id="edit-password-id" name="id">

                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="edit-password" class="form-control form-control-lg"
                                placeholder="Enter a valid username" name="password" required />
                            <label class="form-label" for="edit-password">Password</label>
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
        const editPasswordModal = document.getElementById('editPasswordModal');

        editModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id');
            const name = button.getAttribute('data-bs-name');
            const email = button.getAttribute('data-bs-email');
            const roleId = button.getAttribute('data-bs-role-id');

            const modalBodyId = editModal.querySelector('#edit-id');
            modalBodyId.value = id;
            const modalBodyName = editModal.querySelector('#edit-name');
            modalBodyName.value = name;
            const modalBodyEmail = editModal.querySelector('#edit-email');
            modalBodyEmail.value = email;

            // Select the corresponding role
            const modalBodyRole = editModal.querySelector('#edit-role');
            modalBodyRole.value = roleId;
        });

        editPasswordModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-password-id');

            const modalBodyId = editPasswordModal.querySelector('#edit-password-id');
            modalBodyId.value = id;
        });
    </script>

@endsection
