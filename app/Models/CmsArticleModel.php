<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 文章主表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-06-21
 *
 */
class CmsArticleModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'cms_article';
    /**
                主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = PAGE_NUMS;
    
    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = [
                           'cate_id',
                           'cate_pid',
                           'title',
                           'image',
                           'author',
                           'tags',
                           'pubtime',
                           'abstract',
                           'page_view',
                           'content_url',
                           'article_path',
                           'valid',
                           'hot',
                           'top',
                           'in_home',
                           'sort',
                           'status'
                           ];
                                
}