@extends('web.layout')

@section('content')
        <!--上面head-->  <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="/">首页</a></li>
                <li><a href="/expert.html">专家库</a></li>
                <li class="active">{{$item->baseUser->name}}</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->
<div class="container" id="expert_detail">
    <div class="sign-form">
        <div class="sign-inner">
            <div class="row expert_info">
                <div class="col-sm-4">
                    <div class="item">
                        <img src="{{$item->baseUser->avater}}" class="img-responsive" alt="...">
                    </div>
                </div>

                <div class="col-sm-8">
                    <h3><span class="name">{{$item->baseUser->name}}</span><i>/</i><a class="territory" href="/expert.html?territory={{$item->territory}}">{!! dict()->get("global","territory",$item->territory)  !!}</a></h3>
                    <p class="info"><span>{{$item->resume}}</span></p>
                    <br>
                    <h4><span>专家信息</span></h4>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="key">职务：</td>
                            <td class="val">{{$item->position}}</td>
                        </tr>
                        <tr>
                            <td class="key">毕业院校：</td>
                            <td class="val">{{$item->academy}}</td>
                        </tr>
                        <tr>
                            <td class="key">最高学历：</td>
                            <td class="val">{{dict()->get('global','education',$item->education)}}</td>
                        </tr>
                        <tr>
                            <td class="key">曾参与PPP项目：</td>
                            <td class="val">{{$item->project_desc}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> <!-- / .container -->

@endsection
