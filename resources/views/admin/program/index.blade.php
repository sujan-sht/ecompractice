@extends('admin.includes.main')
@section('title')Programs -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')

    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @can('role-create')
                        <a href="{{route('programs.create')}}" class="btn btn-success btn-sm float-right">Add Program</a>
                    @endcan
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects" id="myTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>Image</th>
                                <th> Title </th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($programs)>0)
                                @foreach ($programs as $program)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td>
                                        @if(empty($program->image)) 
                                            <img src="{{asset('category/no-image.png')}}" alt="no-image" width="80px" height="80px" class="img-fluid"> 
                                        @else
                                            <img src="{{asset('uploads/programs/'.$program->image)}}" alt="{{$program->title}}" width="80px" height="80px" class="img-fluid">
                                        @endif
                                    </td>
                                    <td> {{$program->title}} </td>
                                    {{-- <td>{!! Str::limit($program->description, 200, $end='.......') !!}</td> --}}
                                    <td>{{$program->date}}</td>
                                    <td>{{$program->location}}</td>

                                    <form action="{{route('programs.destroy',$program->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <td class="project-actions">
                                            {{-- <a class="btn btn-primary btn-sm" href="#">
                                                <i class="fas fa-folder">
                                                </i>
                                                View
                                            </a> --}}
                                            @can('role-edit')
                                            <a class="btn btn-info btn-sm" href="{{route('programs.edit',$program->id)}}">
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

@section('scripts')


<script>
    $(document).ready(function(){
        //datatable
        $('#myTable').DataTable();
    });

</script>




@endsection