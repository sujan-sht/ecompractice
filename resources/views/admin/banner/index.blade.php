@extends('admin.includes.main')
@section('title')All Banners -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')

    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7">
                            <a href="{{route('banners.create')}}" class="btn btn-success btn-sm">Add Banner</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects" id="myTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>Image</th>
                                <th> Url </th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($banners)>0)
                                
                                @foreach ($banners as $banner)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td>
                                        @if(empty($banner->image)) 
                                            <img src="{{asset('category/no-image.png')}}" alt="no-image" width="80px" height="80px" class="img-fluid"> 
                                        @else
                                            <img src="{{asset('uploads/banners/'.$banner->image)}}" alt="{{$banner->title}}" width="80px" height="80px" class="img-fluid">
                                        @endif
                                    </td>
                                    <td> {{$banner->url}} </td>
                                    <td>
                                        <input type="checkbox" data-id="{{ $banner->id }}" name="status" class="js-switch" {{ $banner->status == 1 ? 'checked' : '' }}>
                                        
                                    </td>
                                    <form action="{{route('banners.destroy',$banner->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <td class="project-actions">
                                            
                                            <a class="btn btn-info btn-sm" href="{{route('banners.edit',$banner->id)}}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                Edit
                                            </a>
                                            <button class="btn btn-danger btn-sm" type="submit">
                                                <i class="fas fa-trash">
                                                </i>
                                                Delete
                                            </button>
                                            
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
            
            let banner_status = $(this).prop('checked') === true ? 1 : 0;
            
            let banner_id = $(this).data('id');
            //   console.log(category_id);
    
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('banner.update_status') }}',
                data: {'status': banner_status, 'id': banner_id},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 20;
                    toastr.success(data.message);
                }
            });
        });
    });

</script>




@endsection
