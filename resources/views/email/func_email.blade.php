<!doctype html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  </head>
<body>
 URL:<a href="<?php echo $errUrl;?>"><?php echo $errUrl;?></a>
 <hr/>
  错误:<?php echo $errMessage ?>
 <hr/>
   出错程序：<?php echo $errFile;?>在第 <?php echo $errLine?> 行
 
</body>
</html>