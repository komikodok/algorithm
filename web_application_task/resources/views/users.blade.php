@extends('layouts.app')

@section('title', 'Laravel')

@section('content')
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-md p-6">
        <h2 class="text-2xl font-bold mb-4">Manage Users</h2>

        <form id="createUserForm" class="mb-6" method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

        <h3 class="text-xl font-semibold mt-8">User List</h3>
        <table id="usersTable" class="display table-auto w-full mt-4">
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
    </div>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.data') }}',
                columns: [
                    { data: 'email', name: 'email' },
                    { data: 'name', name: 'name' },
                    { data: 'avatar', name: 'avatar', orderable: false, searchable: false }
                ],
                pageLength: 10
            });
        });
    </script>
</body>
@endsection
