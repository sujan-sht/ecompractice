@extends('admin.includes.main')
@section('title')Category Settings -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')

    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7">
                            @can('role-create')
                                <a href="{{route('categories.create')}}" class="btn btn-success btn-sm">Add Category</a>
                            @endcan
                            
                        </div>
                        <div class="col-md-5">
                            {{-- <input type="text" class="form-control" id="search" name="search"> --}}
                            <form action="">
                                <div class="input-group">
                                    <input type="search" class="form-control form-control-sm" placeholder="Type your keywords here" id="search" name="search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-sm btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                <th>Featured</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($categories)>0)
                                
                                @foreach ($categories as $category)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
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
                                        @php
                                        $cat=App\Models\Category::where('id',$category->parent_id)->first(); 
                                        @endphp
                                            {{$cat->name}} 
                                        @endif
                                    </td>
                                    <td>
                                        <input type="checkbox" data-id="{{ $category->id }}" name="status" class="js-switch" {{ $category->status == 1 ? 'checked' : '' }}>
                                        {{-- @if($category->status==1) 
                                            Show 
                                        @else 
                                            Hide 
                                        @endif --}}
                                    </td>
                                    <td>
                                        <input type="checkbox" data-id="{{ $category->id }}" name="featured" class="js-feature" {{ $category->featured == 1 ? 'checked' : '' }}>
                                        
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
                            @else
                                <tr><td colspan="6"><i class="fa fa-exclamation-triangle"></i> {!! trans('No Data Found') !!}</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                {{ $categories->links() }}
            </div>
        </div>
        <script type="text/javascript">
            let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function(html) {
                let switchery = new Switchery(html,  { size: 'small' });
            });
          </script>
          <script type="text/javascript">
            let featured = Array.prototype.slice.call(document.querySelectorAll('.js-feature'));
            featured.forEach(function(html) {
                let switchery = new Switchery(html,  { size: 'small' });
            });
          </script>
    </section>
</div>
@endsection
@section('scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

  <script>
    $(document).ready(function(){
      $('.js-switch').change(function () {
          let status = $(this).prop('checked') === true ? 1 : 0;
          // console.log(status);
          let category_id = $(this).data('id');
        //   console.log(category_id);
  
          $.ajax({
              type: "GET",
              dataType: "json",
              url: '{{ route('category.update_status') }}',
              data: {'status': status, 'cat_id': category_id},
              success: function (data) {
                toastr.options.closeButton = true;
                toastr.options.closeMethod = 'fadeOut';
                toastr.options.closeDuration = 20;
                toastr.success(data.message);
              }
          });
      });
      $('.js-feature').change(function () {
          let featured = $(this).prop('checked') === true ? 1 : 0;
          // console.log(status);
          let category_id = $(this).data('id');
        //   console.log(category_id);
  
          $.ajax({
              type: "GET",
              dataType: "json",
              url: '{{ route('category.update_feature') }}',
              data: {'featured': featured, 'cat_id': category_id},
              success: function (data) {
                toastr.options.closeButton = true;
                toastr.options.closeMethod = 'fadeOut';
                toastr.options.closeDuration = 20;
                toastr.success(data.message);
              }
          });
      });
  });

    var path = "{{ route('categories.search') }}";
    $('#search').typeahead({
         minLength: 2,
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });

  </script>
@endsection

    