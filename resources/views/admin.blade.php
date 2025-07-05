<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h4>Admin Panel</h4>

    <form method="POST" action="{{ route('users.store') }}" class="border p-4 rounded shadow-sm mb-4">
        @csrf
        <h5>Buat User Baru</h5>

        <input type="text" name="name" class="form-control mb-2" placeholder="Nama" required>
        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

        <select name="role" class="form-select mb-2" required>
            <option value="">Pilih Role</option>
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="staff">Staff</option>
        </select>

        <button class="btn btn-primary" type="submit">Create</button>
    </form>

    <div class="border p-3 shadow-sm">
        <h5>Daftar User</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->role }}</td>
                        <td>
                            <span class="badge bg-{{ $u->status ? 'success' : 'secondary' }}">
                                {{ $u->status ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('users.toggle', $u->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-outline-{{ $u->status ? 'danger' : 'success' }}">
                                    {{ $u->status ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>