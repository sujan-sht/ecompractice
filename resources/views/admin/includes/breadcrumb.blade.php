<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3>{{ ucwords(Request::segment(2))}}</h3>
            </div><!-- /.col -->
            <div class="col-sm-6 d-flex justify-content-end">
                <a href="{{route('dashboard')}}"><i class="fas fa-home"></i>  </a> /              
                <?php $link = "" ?>
                @for($i = 2; $i <= count(Request::segments()); $i++)
                    @if($i < count(Request::segments()) & $i > 0)
                    
                    <?php $link .= "/admin/" . Request::segment($i); ?>
                    <a href="<?= $link ?>">{{ ucwords(str_replace('-',' ',Request::segment($i)))}}</a> /
                    @else {{ucwords(str_replace('-',' ',Request::segment($i)))}}
                    @endif
                @endfor
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->