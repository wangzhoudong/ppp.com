<html>
<head>
<title>@if($code==200)}信息提示@else信息提示@endif</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
*{
	font-family:		Consolas, Courier New, Courier, monospace;
	font-size:			14px;
}
body {
	background-color:	#fff;
	margin:				40px;
	color:				#000;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
line-height:160%;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#990000;
margin: 			0 0 4px 0;
}
</style>
</head>
<body>
	<div id="content">
	asfdasdf
		<h1>{{if $type}}错误警告{{else}}信息提示{{/if}}</h1>
		<ul>
		{{foreach from=$msgs item=msg}}
        <li>{{$msg}}</li>
        {{/foreach}}
        </ul>
		<hr>
		<ul>
		{{foreach from=$urls item=url}}
		<li><a href="{{$url.url}}" >{{$url.title}}</a></li>
		{{/foreach}}
		</ul>
	</div>
</body></html>