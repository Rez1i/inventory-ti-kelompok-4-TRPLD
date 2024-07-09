@extends('admin.layouts.template')

@section('main')
<h2>Create New Data</h2>
@if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
    <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
<form method="post" action="/admin/user">
    @csrf
    <div class="width-75">
        <div class="mb-3">
            <label for="namalengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control @error('namalengkap') is-invalid @enderror" id="namalengkap" name="namalengkap" value="{{ old('namalengkap') }}" required>
            @error('namalengkap')<div class="invalid-feedback">{{$message}}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
            @error('username')<div class="invalid-feedback">{{$message}}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')<div class="invalid-feedback">{{$message}}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmation Password</label>
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')<div class="invalid-feedback">{{$message}}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-select text-secondary" required>
                <option value="">Pilih Role</option>
                @can('isAdministrator')
                <option value="Admin" @if(old('role') == 'Admin') selected @endif>Admin</option>
                @endcan
                <option value="Pimpinan" @if(old('role') == 'Pimpinan') selected @endif>Pimpinan</option>
                <option value="User" @if(old('role') == 'User') selected @endif>User</option>
            </select>
            @error('role')<div class="invalid-feedback d-block">{{$message}}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

@endsection
