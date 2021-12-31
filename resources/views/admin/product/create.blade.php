@extends('admin.includes.main')
@section('title')Product Settings -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                            <a href="{{route('products.index')}}" class="btn btn-success btn-sm float-right">View Product</a>
                        </div>
                        <div class="col-md-12 p-0">
                            @include('admin.includes.message')
                        </div>
                        <div class="card-body">
                            <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label> <span class="text-danger"> * </span>
                                            <input type="text" class="form-control" name="category" value="{{old('category')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent">Category</label><span class="text-danger"> * </span>
                                            <select class="form-control" name="parent_id">
                                                <option selected disabled>--Select--</option>
                                                {{-- <option value="0">Main Category</option> --}}
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                    </div>  
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Image</label><span class="text-danger"> * </span><br>
                                            <input type="file" name="image" id="image">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="slug">Slug</label><span class="text-danger"> * </span>
                                            <input type="text" class="form-control" name="slug" value="{{old('slug')}}">
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <img id="preview-image-before-upload"  style="max-height:150px;">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" name="featured" value="1" @if(old('featured') == '1') checked @endif>
                                        <label class="form-label">Is Featured</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Status</label> <span class="text-danger"> * </span>
                                        <input type="radio" name="status" value="1" @if(old('status') == '1') checked @endif> Show
                                        <input type="radio" name="status" value="0" @if(old('status') == '0') checked @endif> Hide
                                    </div>
                                </div> 
                                <button type="submit" class="btn btn-success btn-sm float-right">Save</button> 
                            </form>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
            
    $(document).ready(function (e) {
    
    
    $('#image').change(function(){
                
        let reader = new FileReader();
    
        reader.onload = (e) => { 
    
        $('#preview-image-before-upload').attr('src', e.target.result); 
        }
    
        reader.readAsDataURL(this.files[0]); 
    
    });
    
    });
    
</script>

