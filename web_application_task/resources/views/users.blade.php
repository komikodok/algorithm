@extends('layouts.app')

@section('title', 'Laravel')

@section('content')
<div class="bg-gray-200 p-6">
    <div class="max-w-2xl border-2 border-gray-300 mx-auto my-4 bg-white shadow-lg shadow-gray-400 rounded-md p-6">
        <strong class="text-2xl bg-clip-text text-transparent bg-gradient-to-r from-black via-black to-gray-700 font-bold mb-8">Manage Users</strong>

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
                    <label for="image" class="block text-gray-700">Profile Image</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border rounded-md" required>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Create User</button>
        </form>

    </div>
    <table id="usersTable" class="display table-auto w-full mt-4 overflow-x-auto">
        <h2 class="text-xl font-semibold my-8">User List</h2>
        <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            var table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.data') }}',
                columns: [
                    { data: 'email', name: 'email' },
                    { data: 'name', name: 'name' },
                    {
                        data: 'avatar',
                        name: 'avatar',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return '<img src="' + data;
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
                        alert('Berhasil membuat user');
                        $('#createUserForm')[0].reset(); 
                        table.ajax.reload(null, false);
                    },
                    error: function(response) {
                        alert('Gagal membuat user');
                    }
                });
            });
        });
    </script>
</div>
@endsection
