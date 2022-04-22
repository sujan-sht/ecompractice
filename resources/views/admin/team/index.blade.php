@extends('admin.includes.main')
@section('title')Testimonials -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')

    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @can('role-create')
                        <a href="{{route('testimonials.create')}}" class="btn btn-success btn-sm float-right">Add Team</a>
                    @endcan
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects" id="myTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>Image</th>
                                <th> Name </th>
                                <th>Designation</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($testimonials)>0)
                                @foreach ($testimonials as $testimonial)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td>
                                        @if(empty($testimonial->image)) 
                                            <img src="{{asset('category/no-image.png')}}" alt="no-image" width="80px" height="80px" class="img-fluid"> 
                                        @else
                                            <img src="{{asset('uploads/testimonials/'.$testimonial->image)}}" alt="{{$testimonial->name}}" width="80px" height="80px" class="img-fluid">
                                        @endif
                                    </td>
                                    <td> {{$testimonial->name}} </td>
                                    <td> {{$testimonial->designation}} </td>
                                    <td> {{$testimonial->message}} </td>
                                    <form action="{{route('testimonials.destroy',$testimonial->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <td class="project-actions">
                                            {{-- <a class="btn btn-primary btn-sm" href="#">
                                                <i class="fas fa-folder">
                                                </i>
                                                View
                                            </a> --}}
                                            @can('role-edit')
                                            <a class="btn btn-info btn-sm" href="{{route('testimonials.edit',$testimonial->id)}}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                Edit
                                            </a>
                                            @endcan
                                            @can('role-delete')
                                            <button class="btn btn-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" title='Delete'>
                                                <i class="fas fa-trash">
                                                </i>
                                                Delete
                                            </button>
                                            @endcan
                                        </td>
                                    </form>

                                </tr>
                                
                                @endforeach
                            @else
                                <tr><td colspan="6"><i class="fa fa-exclamation-triangle"></i> {!! trans('No Data Found') !!}</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection

    