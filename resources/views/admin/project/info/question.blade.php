@extends('admin.project.info.layout')

@section('detail_content')
<style>

    /* qa */
    .PPP-qa-box{ margin-bottom:30px; }
    .PPP-qa-q{ }
    .PPP-qa-a{ }
    .PPP-qa-a li{ background:#fafafa; min-height:72px; padding:6px 6px 6px 72px; border:1px solid #eee; position:relative; list-style:none; margin-bottom:10px; border-radius:2px; }
    .PPP-qa-a img{ position:absolute; top:6px; left:6px; width:60px; height:60px; border-radius:2px; }
    .PPP-qa-name{ font-size:14px; color:#333; }
    .PPP-qa-time{ color:#666; position:absolute; right:6px; top:6px; font-size:12px; }
    .PPP-qa-cont{ margin-top:10px; font-size:12px; line-height:24px; }

</style>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>讨论区</h5>
            <div class="ibox-tools">
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-9">
                    @foreach($question as $item)
                    <div class="PPP-qa-box">
                        <p class="PPP-qa-q"><span>【问】</span>{{$item->title}}？<a href="/Project/Question/destroy?id=">删除问题</a></p>
                        <ul class="PPP-qa-a">
                            @foreach($item->dataInfo as $item1)
                            <li>
                                <a href="javascript:void();">
                                    <img src="{{$item1->baseUser->avater}}" title="" alt="">
                                </a>
                                <a class="PPP-qa-name" href="javascript:void();">{{$item1->nickname}}</a>
                                <span class="PPP-qa-time">{{$item1->created_at}}</span>
                                <p class="PPP-qa-cont"><span>【答】</span>{{$item1->content}}</p>
                                <p><a class="deleteData" data-url="/Project/Question/deleteData?data_id={{$item1->id}}" href="javascript:;"> 删除</a></p>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                    @endforeach

                    <div class="PPP-qa-box">
                        <p class="PPP-qa-q">创建新问题</p>
                        <form method="post" class="exp_answer">
                            <textarea name="title" class=" form-control" placeholder="输入问题"></textarea>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                            <input type="hidden" name="project_id" value="{{request('project_id')}}"/>
                            <input type="submit" class="btn btn-success" value="提交">
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){

           $('.deleteData').click(function() {
               $.getJSON($(this).data('url'),function(){
                    layer.msg("操作成功");
                    $(this).parent().parent().remove();
                } );
           });
        });


    </script>
@endsection
