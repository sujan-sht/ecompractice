@extends('admin.includes.main')
@section('title')Category Settings -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">General Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                    @can('role-create')
                    <a href="{{route('categories.create')}}" class="btn btn-success btn-sm float-right">Add Category</a>
                    @endcan
                </div>
                <div class="card-body p-0">
                    @include('admin.includes.message')
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Name </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td> {{$permission->id}} </td>
                                <td> {{$permission->name}} </td>
                                
                                <form action="{{route('permissions.destroy',$permission->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <td class="project-actions">
                                        <a class="btn btn-primary btn-sm" href="#">
                                            <i class="fas fa-folder">
                                            </i>
                                            View
                                        </a>
                                        @can('role-edit')
                                        <a class="btn btn-info btn-sm" href="{{route('permissions.edit',$permission->id)}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        @endcan
                                        @can('role-delete')
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                        @endcan
                                    </td>
                                </form>
                            </tr>
                            
                            @endforeach
                           
                        </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
    