@extends('admin.layouts.template')

@section('main')
    <h2>Update Data</h2>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
    <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <form method="post" action="/admin/user/{{$user->id}}">
        @csrf
        @method('put')
        <div class="width-75">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                @error('username')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <p>Biarkan default jika tidak ingin mengubah password</p>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" class="form-select text-secondary @error('role') is-invalid @enderror" required>
                    <option value="">Pilih Role</option>
                    <option value="Admin" @if(old('role', $user->role) == 'Admin') selected @endif>Admin</option>
                    <option value="Pimpinan" @if(old('role', $user->role) == 'Pimpinan') selected @endif>Pimpinan</option>
                    <option value="User" @if(old('role', $user->role) == 'User') selected @endif>User</option>
                </select>
                @error('role')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

@endsection
