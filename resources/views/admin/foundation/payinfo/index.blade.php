@extends('admin.layout')

@section('header')
<style>
.footable-row-detail-value{width:93%;}
.footable-row-detail-value div.wrap{width:92%;word-break:break-all;}
.footable-row-detail-inner{width: 100%;}
</style>

<link href="/admin-skins/css/plugins/footable/footable.core.css" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>支付日志列表</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
				    <div class="row">
    					<div class="col-sm-5">
    						<form method="GET" action="" accept-charset="UTF-8">
        						<div class="input-group">
                                    <input type="text" value="{{Request::get('keyword')}}"	placeholder="请输入关键词 （标题,正文,金额,用户名称,支付系统标识）" name="keyword" class="input-sm form-control"> 
                                    <span class="input-group-btn">
                                    	<button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                    </span>
        						</div>
    						</form>
    					</div>
					</div>
                    <div class="row">
                        <div class="col-sm-1 pull-left">
                            <div class="input-group">
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary pull-right" id="btn_zankai_and_shouqi" data-statu='zankai'>展开列表</a>
                            </div>
    					</div>
                    </div>
					<table class="footable table table-stripped toggle-arrow-tiny table-bordered table-hover dataTable breakpoint">
						<thead>
							<tr>
								<th class="sorting" data-sort="pay_id">Pay id</th>
								<th>标题</th>
								<th data-hide="all" style="display:none;">正文</th>
								<th>订单号</th>
								<th>支付系统标识</th>
								<th>支付方式</th>
								<th>支付时间</th>
								<th data-hide="all" style="display:none;">支付验证数据</th>
								<th>支付的金额</th>
								<th data-hide="all" style="display:none;">页面显示</th>
								<th>支付状态</th>
								<th>允许的交易类型</th>
								<th>用户名称</th>
								<th>创建时间</th>
								<th data-hide="all" style="display:none;">日志类型</th>
								<th data-hide="all" style="display:none;">描述</th>
								<th data-hide="all" style="display:none;">请求的数据</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($list))
							@foreach($list as $key=>$item)
							<tr class="@if($key+1 & 1) footable-even @else footable-odd @endif" style="display: table-row;">
								<td class="footable-visible footable-first-column"><span class="footable-toggle"></span>{{ $item->pay_id }}</td>
								<td class="footable-visible">{{ $item->subject }}</td>
								<td style="display: none;">{{ $item->body }}</td>
								<td class="footable-visible">{{ $item->order_id }}</td>
                                <td class="footable-visible">{{ $item->order_system }}</td>
                                <td class="footable-visible">{{ $item->pay_type }}</td>
                                <td class="footable-visible">@if($item->pay_time) <?php echo date('Y-m-d H:i:s', strtotime($item->pay_time));?> @endif</td>
                                <td style="display: none;">{{ $item->pay_request }}</td>
                                <td class="footable-visible">￥{{ $item->amount/100 }}</td>
                                <td style="display: none;">{{ $item->show_url }}</td>
                                <td class="footable-visible">
                                    @if($item->status == -1)
                                    <font color="red">支付失败</font>
                                    @elseif($item->status == 1)
                                    <font color="#46b8da">待支付</font>
                                    @elseif($item->status == 2)
                                    <font color="#46b8da">支付成功</font>
                                    @endif
                                </td>
                                <td class="footable-visible">{{ $item->allow_pay_types }}</td>
                                <td class="footable-visible">{{ $item->pay_user_name }}</td>
                                <td class="footable-visible">{{ $item->created_at }}</td>
								<td style="display: none;">
                                @if(isset($item->loginfo->log_type))
                                	@if($item->loginfo->log_type == -1)
                                    <font color="red">非法请求</font>
                                    @elseif($item->loginfo->log_type == -2)
                                    <font color="#46b8da">设置数据库不成功</font>
                                    @elseif($item->loginfo->log_type == 0)
                                    <font color="#46b8da">支付成功</font>
                                    @elseif($item->loginfo->log_type == 1)
                                    <font color="#46b8da">创建支付</font>
                                    @elseif($item->loginfo->log_type == 2)
                                    <font color="#46b8da">尝试支付</font>
                                    @endif
                                @endif
								</td>
                                <td style="display: none;">@if(isset($item->loginfo)) {{ $item->loginfo->opt_reason }} @endif</td>
                                <td style="display: none;">@if(isset($item->loginfo)) {{ $item->loginfo->request_data }} @endif</td>
							</tr>
                            <tr class="footable-row-detail" style="display: none;">
                                <td class="footable-row-detail-cell" colspan="11">
                                    <div class="footable-row-detail-inner">
                                        @if(is_object($item->logs))
                                        @foreach($item->logs as $log)
                                        <div class="footable-row-detail-row">
                                            <div class="footable-row-detail-name">{{$log->created_at}}</div>
                                            <div class="footable-row-detail-value"><div class="wrap">{{ $log->opt_reason or '&nbsp;' }}</div></div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            
							@endforeach
					    @endif
						</tbody>
					</table>
					@if(isset($list))
					<div class="row">
						<div class="col-sm-6">
							<div class="dataTables_info" role="alert" aria-live="polite" aria-relevant="all">每页{{ $list->count() }}条，共{{ $list->lastPage() }}页，总{{ $list->total() }}条。</div>
						</div>
						<div class="col-sm-6">
						<div class="dataTables_paginate paging_simple_numbers">
						{!! $list->setPath('')->appends(Request::all())->render() !!}
						</div>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@endsection



@section('footer')
<script>
$(function() {
	$('.footable tr.footable-even,.footable tr.footable-odd').click(function(event){
		if(event.target.className == "caret" || event.target.nodeName == "BUTTON"){
			return ;
		}
		zankaiAndshouqi('', $(this));
	});
	
	$('#btn_zankai_and_shouqi').click(function(event){
		var statu = $(this).data('statu');
		if(statu == 'zankai'){
			$(this).html('收起列表').data('statu', 'shouqi');
		}else{
			$(this).html('展开列表').data('statu', 'zankai');	
		}
		$('.footable tr.footable-even,.footable tr.footable-odd').each(function(index, element) {
            zankaiAndshouqi(statu, $(element));
        });
	});
});
function zankaiAndshouqi(statu,$target){
	var $detail = $target.next();
	var display = $detail.css('display');
	
	if(statu){
		//存在则由总的控制
		display = statu=='zankai'?'none':'';
	}
	
	if(display != 'none'){
		$target.removeClass('footable-detail-show');
		$detail.css('display', 'none');
	}else{
		$target.addClass('footable-detail-show');
		$detail.css('display', 'table-row');
	}
}
</script>
@endsection