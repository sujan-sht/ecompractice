@extends('admin.includes.main')
@section('title')Social Settings -  {{ config('app.name', 'Laravel') }} @endsection
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Settings</h3>
                        </div>
                        
                        <form method="post" action="{{ route('socialUpdate',$social->id) }}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="card-body">
                                @include('admin.includes.message')
                                <div class="form-group">
                                    <label for="Facebook">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" value="{{old('facebook',$social->facebook)}}">
                                </div>
                                <div class="form-group">
                                    <label for="Twitter">Twitter</label>
                                    <input type="text" class="form-control" name="twitter" value="{{old('twitter',$social->twitter)}}">
                                </div>
                                <div class="form-group">
                                    <label for="Instagram">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" value="{{old('instagram',$social->instagram)}}">
                                </div>
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn</label>
                                    <input type="text" class="form-control" name="linkedin" value="{{old('linkedin',$social->linkedin)}}">
                                </div>
                            </div>
                            @can('role-create')
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            @endcan
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
    