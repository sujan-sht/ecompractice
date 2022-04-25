@extends('admin.includes.main')
@section('title')Add Team Member -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Team Member</h3>
                            <a href="{{route('teams.index')}}" class="btn btn-success btn-sm float-right">View Team Member</a>
                        </div>
                        <div class="card-body">
                            <form action="{{route('teams.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label> <span class="text-danger"> * </span>
                                            <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" class="form-control" name="designation" value="{{old('designation')}}">
                                        </div>
                                    </div>  
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact</label><br>
                                            <input type="tel" name="contact" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Details</label>
                                            <textarea class="form-control" name="details">{{old('details')}}</textarea>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Image</label><br>
                                            <input type="file" name="image" id="image">
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <img id="preview-image-before-upload"  style="max-height:150px;">
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

