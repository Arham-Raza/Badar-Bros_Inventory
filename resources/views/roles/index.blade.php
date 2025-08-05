@extends('layouts.master')

@section('content')
    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Role Management</h4>

    <div class="card">
        <div class="card-header flex-column flex-md-row">
            <div class="head-label text-center">
            </div>
            @can('role-create')
                <div class="dt-action-buttons  pt-3 pt-md-0">
                    <div class="dt-buttons btn-group flex-wrap">
                        <a href="{{ route('roles.create') }}" class="btn btn-secondary create-new btn-primary" tabindex="0"
                            aria-controls="DataTables_Table_0" type="button"><span><i class="mdi mdi-plus me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">Add New </span></span></a>
                    </div>
                </div>
            @endcan
        </div>
        <div class="card-datatable table-responsive pt-0 p-3">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>
                        <th>SR #</th>
                        <th>TITLE</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                {{-- <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}"><i
                                        class="fa-solid fa-list"></i> Show</a> --}}
                                @can('role-edit')
                                    <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}"><i
                                            class="mdi mdi-pencil"></i></a>
                                @endcan

                                @can('role-delete')
                                    <form method="POST" action="{{ route('roles.destroy', $role->id) }}"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
