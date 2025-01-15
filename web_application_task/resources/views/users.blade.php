@extends('layouts.app')

@section('title', 'Laravel')

@section('content')
<div class="bg-gray-200 p-6">
    <div class="max-w-2xl mx-auto my-4 bg-white shadow-lg shadow-gray-400 rounded-md p-6">
        <strong class="text-2xl bg-clip-text text-transparent bg-gradient-to-r from-black via-gray-900 to-black font-bold mb-8">Manage Users</strong>

        <form id="createUserForm" class="mt-4 mb-6" method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border rounded-md" required>
                </div>
                <div>
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border rounded-md" required>
                </div>
                <div>
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border rounded-md" required>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 border rounded-md" required>
                </div>
                <div>
                    <label for="image" class="block text-gray-700">Profile Image</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border rounded-md" required>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Create User</button>
        </form>
    </div>

    <div class="mt-6">
        <h1 class="text-xl font-bold mb-4">User Management</h1>
    
        <!-- Alert -->
        @if(session('status') == 'success')
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif
        @if(session('status') == 'error')
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif
    
        <!-- User Table -->
        <table id="usersTable" class="table-auto w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Avatar</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        @if ($user->avatar)
                            <img src="{{ asset('uploads/' . $user->avatar) }}" alt="Avatar" class="w-12 h-12 rounded-full">
                        @else
                            <span>No Avatar</span>
                        @endif
                    </td>
                    <td class="border border-gray-300 flex px-4 py-2">
                        <!-- Edit Button -->
                        <a href="javascript:void(0)" onclick="openEditModal({{ $user }})"
                           class="bg-blue-500 text-white w-14 m-2 px-4 py-2 rounded hover:bg-blue-600">
                           Edit
                        </a>
                        <!-- Delete Form -->
                        <form action="{{ route('users.delete', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white m-2 px-4 py-2 flex rounded hover:bg-red-600"
                                onclick="return confirm('Are you sure you want to delete this user?');">
                                <span class="m-auto">Delete</span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="hidden fixed inset-0 bg-gray-900 w-full h-full bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-md shadow-md w-full max-w-lg">
            <h2 class="text-xl font-bold mb-4">Edit User</h2>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editUserId" name="id">
                <div class="mb-4">
                    <label for="editName" class="block text-gray-700">Name</label>
                    <input type="text" id="editName" name="name" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="editPassword" class="block text-gray-700">Password</label>
                    <input type="password" id="editPassword" name="password" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="editImage" class="block text-gray-700">Profile Image</label>
                    <input type="file" id="editImage" name="image" class="w-full p-2 border rounded-md">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update User</button>
                <button type="button" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(user) {
            console.log(user);
            $('#editUserId').val(user.id);
            $('#editName').val(user.name);
            $('#editPassword').val('');
            $('#editImage').val('');
            $('#editUserForm').attr('action', `/users/${user.id}`);

            $('#editUserModal').removeClass('hidden');
        }

        function closeEditModal() {
            $('#editUserModal').addClass('hidden');
        }

        $('#editUserForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert('User updated successfully!');
                    console.log('Success:', response);
                },
                error: function (xhr) {
                    console.log('Error:', xhr.responseJSON);
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';

                    for (let field in errors) {
                        errorMessage += errors[field].join(' ') + '\n';
                    }

                    alert(errorMessage);
                }
            });
        });


        $(document).ready(function() {
            var table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'avatar', name: 'avatar', orderable: false, searchable: false },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <a href="javascript:void(0)" onclick='openEditModal(${JSON.stringify(row)})'
                                    class="bg-blue-500 text-white w-14 m-2 px-4 py-2 rounded hover:bg-blue-600">
                                    Edit
                                </a>
                                <form action="/users/${data}" method="POST" style="display:inline;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="bg-red-500 text-white m-2 px-4 py-2 flex rounded hover:bg-red-600"
                                            onclick="return confirm('Are you sure you want to delete this user?');">
                                        <span class="m-auto">Delete</span>
                                    </button>
                                </form>
                            `;
                        }
                    }
                ],
                pageLength: 10
            });

            $('#createUserForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('users.store') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('User created successfully');
                        $('#createUserForm')[0].reset(); 
                        table.ajax.reload(null, false);
                    },
                    error: function(response) {
                        alert('Failed to create user');
                    }
                });
            });
        });
    </script>
</div>
@endsection
