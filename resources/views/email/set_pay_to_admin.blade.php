<!doctype html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  </head>
<body>
<p>好消息！</p>
<p> 有人付款了，赶快跟踪一下</p>
<p>支付单号：{{$payInfo['pay_id']}}</p>
<p>订单号：{{$payInfo['order_id']}}</p>
<p>支付金额：{{$payInfo['amount']/100}}</p>
<p>付款用户：{{$payInfo['pay_user_name']}}</p>
</body>
</html>