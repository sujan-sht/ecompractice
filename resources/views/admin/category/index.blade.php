@extends('admin.includes.main')
@section('title')Category Settings -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')

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
                                <th>Image</th>
                                <th> Name </th>
                                <th>Under Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td> {{$category->id}} </td>
                                <td>
                                    @if(empty($category->image)) 
                                        <img src="{{asset('category/no-image.png')}}" alt="no-image" width="80px" height="80px" class="img-fluid"> 
                                    @else
                                        <img src="{{asset('category/'.$category->image)}}" alt="{{$category->name}}" width="80px" height="80px" class="img-fluid">
                                    @endif
                                </td>
                                <td> {{$category->name}} </td>
                                <td>
                                    @if($category->parent_id==0) 
                                        Main Category 
                                    @else 
                                        {{$category->parent_id}} 
                                    @endif
                                </td>
                                <td>
                                    @if($category->status==1) 
                                        Show 
                                    @else 
                                        Hide 
                                    @endif
                                </td>
                                
                                <form action="{{route('categories.destroy',$category->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <td class="project-actions">
                                        <a class="btn btn-primary btn-sm" href="#">
                                            <i class="fas fa-folder">
                                            </i>
                                            View
                                        </a>
                                        @can('role-edit')
                                        <a class="btn btn-info btn-sm" href="{{route('categories.edit',$category->id)}}">
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
                           
                        </tbody>
                    </table>
                </div>
                {{ $categories->links() }}
            </div>
        </div>
    </section>
</div>
@endsection
    