@extends('layouts.admin')

@section('title', 'ユーザー一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endsection

@section('content')
    <div class="user-list-container">
        <h1>ユーザー一覧</h1>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ユーザー名</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name ?? $user->email }}</td>
                        <td class="details">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info">詳細</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
