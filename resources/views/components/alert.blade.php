@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissible fade show" role="alert"><button class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>@foreach ($errors->all() as $error){{ $error }} @endforeach</div>
@endif

@if (!empty(Session::get('success')))
    <div class="alert alert-primary alert-success fade show" role="alert"><button class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <?php
        $message= Session::get('success');
        if($message){
            echo $message;
            Session::put('success',null);
        }
    ?>
    </div>
 @endif

@if (!empty(Session::get('failed')))
    <div class="alert alert-danger alert-dismissible fade show" role="alert"><button class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?php
            $message_failed= Session::get('failed');
            if($message_failed){
                echo $message_failed;
                Session::put('failed',null);
                }
        ?>
    </div>
 @endif