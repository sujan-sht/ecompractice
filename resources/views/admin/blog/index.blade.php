@extends('admin.includes.main')
@section('title')All Blogs -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')

    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7">
                            @can('role-create')
                                <a href="{{route('blogs.create')}}" class="btn btn-success btn-sm">Add Blog</a>
                            @endcan
                            
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @include('admin.includes.message')
                    <table class="table table-striped projects" id="myTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>Image</th>
                                <th> Title </th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($blogs)>0)
                                
                                @foreach ($blogs as $blog)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td>
                                        @if(empty($blog->image)) 
                                            <img src="{{asset('category/no-image.png')}}" alt="no-image" width="80px" height="80px" class="img-fluid"> 
                                        @else
                                            <img src="{{asset('uploads/blogs/'.$blog->image)}}" alt="{{$blog->title}}" width="80px" height="80px" class="img-fluid">
                                        @endif
                                    </td>
                                    <td> {{$blog->title}} </td>
                                    <td>
                                        <input type="checkbox" data-id="{{ $blog->id }}" name="status" class="js-switch" {{ $blog->status == 1 ? 'checked' : '' }}>
                                        
                                    </td>
                                    <form action="{{route('blogs.destroy',$blog->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <td class="project-actions">
                                            <a class="btn btn-primary btn-sm" href="#">
                                                <i class="fas fa-folder">
                                                </i>
                                                View
                                            </a>
                                            @can('role-edit')
                                            <a class="btn btn-info btn-sm" href="{{route('blogs.edit',$blog->id)}}">
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
                            @else
                                <tr><td colspan="6"><i class="fa fa-exclamation-triangle"></i> {!! trans('No Data Found') !!}</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                {{-- {{ $categories->links() }} --}}
            </div>
        </div>
        <script type="text/javascript">
            let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function(html) {
                let switchery = new Switchery(html,  { size: 'small' });
            });
        </script>

        </script>
    </section>
</div>
@endsection
@section('scripts')


<script>
    $(document).ready(function(){
        //datatable
        $('#myTable').DataTable();
        //category status
        $('.js-switch').change(function () {
            let status = $(this).prop('checked') === true ? 1 : 0;
            // console.log(status);
            let blog_id = $(this).data('id');
            //   console.log(category_id);
    
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('blog.update_status') }}',
                data: {'status': status, 'id': blog_id},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 20;
                    toastr.success(data.message);
                }
            });
        });
    });

    // $('.show_confirm').click(function(event) {
    //       var form =  $(this).closest("form");
    //       {{-- console.log(form); --}}
    //       var name = $(this).data("name");
    //       {{-- console.log(name); --}}

    //       event.preventDefault();
    //       swal({
    //           title: `Are you sure you want to delete this record?`,
    //           text: "If you delete this, it will be gone forever.",
    //           icon: "warning",
    //           buttons: true,
    //           dangerMode: true,
    //       })
    //       .then((willDelete) => {
    //         if (willDelete) {
    //           form.submit();
    //         }
    //       });
    //   });

</script>




@endsection
