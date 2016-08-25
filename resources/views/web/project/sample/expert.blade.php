@extends('web.layout')

@section('content')
        <!--上面head--><!-- Topic Header -->
@include("web.project.sample.topic")
<div class="container" id="project">
    <div class="row">
        <div class="col-sm-3">
            @include("web.project.sample.left_panel")
        </div>
        <div class="col-sm-9">
                @foreach($data as $val)
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="team-member text-center">
                        <a class="head"  target="_blank" href="/expert/detail/{{$val->user_id}}"><img class="img-responsive" src="{{ $val->avater }}" alt="..."></a>
                        <div class="info">
                            <h3><a class="name" target="_blank" href="/expert/detail/{{$val->user_id}}"><strong>{{ $val->name }}</strong></a><i>/</i><a class="area"  target="_blank" href="/expert.html?territory={{$val->territory}}">{!! dict()->get("global","territory",$val->territory)  !!} </a></h3>

                            <p><span>{{$val->resume}}</span></p>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

@endsection
