@extends('layouts.master')

@section('content')
    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> User</h4>

    <div class="card">
        <div class="card-header flex-column flex-md-row">
            <div class="head-label text-center">
                {{-- <h5 class="card-title mb-0">USERS</h5> --}}
            </div>
            <div class="dt-action-buttons  pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <a href="{{ route('users.create') }}" class="btn btn-secondary create-new btn-primary" tabindex="0"
                        aria-controls="DataTables_Table_0" type="button"><span><i class="mdi mdi-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">Add New </span></span></a>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive pt-0 p-3">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>
                        <th>SR #</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ROLES</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($data as $key => $user)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge bg-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                {{-- <a class="btn btn-info btn-sm" href="{{ route('users.show', $user->id) }}"><i
                                        class="fa-solid fa-list"></i> Show</a> --}}
                                <a class="btn btn-primary me-2 p-2-5" href="{{ route('users.edit', $user->id) }}"><i
                                    class="mdi mdi-pencil"></i></a>
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger p-2-5">
                                        <i class="mdi mdi-delete" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
