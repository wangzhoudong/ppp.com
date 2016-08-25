<?php
/**
 *  
 *  @author  wangzhoudong  <admin@zhen.pl>
 *  @version    1.0
 *  @date 2015-8-11
 *
 */
$mysql_server_name = "123.57.234.19"; // 数据库服务器名称
$mysql_username = "ppp"; // 连接数据库用户名
$mysql_password = "ppp"; // 连接数据库密码
$mysql_database = "ppp"; // 数据库的名字
$author = "wangzhoudong  <admin@yijinba.com>"; 
$notFillable = array('created_at','updated_at',"deleted_at");
$conn = mysql_connect($mysql_server_name, $mysql_username, $mysql_password);
$strsql = "SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA='$mysql_database'";
mysql_query('SET NAMES UTF8',$conn);
$result = mysql_db_query($mysql_database, $strsql, $conn);
$date = date("Y-m-d");
$filePath = str_replace('\\','/',dirname(__FILE__))  . "/../app/Models/";
$tpl = "<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description {{table_comment}}
 *  @author  $author;
 *  @version    1.0
 *  @date $date
 *
 */
class {{class_name}} extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected \$table = '{{table_name}}';
    /**
                主键
     */
    protected \$primaryKey = '{{table_primary}}';

    //分页
    protected \$perPage = PAGE_NUMS;
    
    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected \$fillable = {{fillable}};
                                
}";

while ($row = mysql_fetch_assoc ($result)) {
    $sql = "SELECT COLUMN_NAME,COLUMN_KEY FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='{$row['TABLE_SCHEMA']}' AND TABLE_NAME='{$row['TABLE_NAME']}';";
    $result1 = mysql_db_query($mysql_database, $sql, $conn);
    $table_primary = '';
    $fillable = "";
    while ($data = mysql_fetch_array($result1)) {
        if($data['COLUMN_KEY'] == "PRI") {
            $table_primary = $data['COLUMN_NAME'];
        }elseif(!in_array($data['COLUMN_NAME'],$notFillable)) {
            $fillable .= "\r\n                           '{$data['COLUMN_NAME']}',";
        }
    }
    $fillable = $fillable ? '['. substr($fillable,0,-1) ."\r\n                           ]": $fillable;
    $className =  convertUnderline1($row['TABLE_NAME']) . "Model";
    
    $str = str_replace("{{table_comment}}", $row['TABLE_COMMENT'], $tpl);
    $str = str_replace("{{table_name}}", $row['TABLE_NAME'], $str);
    $str = str_replace("{{table_primary}}", $table_primary, $str);
    $str = str_replace("{{fillable}}", $fillable, $str);
    $str = str_replace("{{class_name}}", $className, $str);
    $file = $filePath . $className . ".php";
    if(file_exists($file)) {
        echo "存在$file" . "<BR>";
    }else{
    
        echo "创建:" . $file;
        file_put_contents($file, $str);
    }
    
}
//将下划线命名转换为驼峰式命名
function convertUnderline1 ( $str , $ucfirst = true)
{
    while(($pos = strpos($str , '_'))!==false)
        $str = substr($str , 0 , $pos).ucfirst(substr($str , $pos+1));

    return $ucfirst ? ucfirst($str) : $str;
}



mysql_free_result($result);
mysql_close($conn);
