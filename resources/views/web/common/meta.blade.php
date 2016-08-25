<title><?php 
if(isset($_seo['page_title']) && $_seo['page_title']){
    echo $_seo['page_title'];
}elseif(isset($seo['page_title']) && $seo['page_title']){
    echo $seo['page_title'];
}else if(isset($data['page_title']) && $data['page_title']){
        echo $data['page_title'];
}else{
    echo "PPP在线咨询项目";
}
?></title>
<meta name="keywords" content="<?php 
if(isset($_seo['meta_keyword']) && $_seo['meta_keyword']){
    echo $_seo['meta_keyword'];
}elseif(isset($seo['meta_keyword']) && $seo['meta_keyword']){
    echo $seo['meta_keyword'];
}elseif(isset($data['meta_keyword']) && $data['meta_keyword']){
   echo $data['meta_keyword'];
}else{
    echo 'PPP在线咨询项目';
}
?>" />
<meta name="description" content="<?php 
if(isset($_seo['meta_description']) && $_seo['meta_description']){
    echo $_seo['meta_description'];
}elseif(isset($seo['meta_description']) && $seo['meta_description']){
    echo $seo['meta_description'];
}elseif(isset($data['meta_description']) && $data['meta_description']){
   echo $data['meta_description'];
}else{
    echo 'PPP在线咨询项目';
}
?>">
<meta name="baidu-site-verification" content="CEDLYAATxU" />
<meta name="baidu-site-verification" content="MuWhY7jhi6" />
