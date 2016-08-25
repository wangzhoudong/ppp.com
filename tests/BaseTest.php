<?php
/**
 *  测试框架运行，以及配置
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年2月17日
 *
 */
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BaseTest extends TestCase
{
    
    /**
     * 检查配置是否存在
     */
    public function testConfig() {
        $this->assertFileExists(base_path() . "/.env");
        $this->assertContains(env('APP_ENV'), array('local','testing','development','production'));
        $this->assertContains(env('APP_DEBUG'),array(true,false));
        $this->assertNotNull(env('APP_KEY'),'env not exists  APP_KEY');
        $this->assertNotNull(env('DB_HOST'),'env not exists  DB_HOST');
        $this->assertNotNull(env('DB_DATABASE'),'env not exists  DB_DATABASE');
        $this->assertNotNull(env('DB_USERNAME'),'env not exists  DB_USERNAME');
        $this->assertNotNull(env('DB_PASSWORD'),'env not exists  DB_PASSWORD');
        $this->assertNotNull(env('CACHE_DRIVER'),'env not exists CACHE_DRIVER');
        $this->assertNotNull(env('SESSION_DRIVER'),'env not exists SESSION_DRIVER');
        $this->assertNotNull(env('QUEUE_DRIVER'),'env not exists QUEUE_DRIVER');
        $this->assertNotNull(env('ADMIN_DOMAIN'),'env not exists  ADMIN_DOMAIN');

        $this->assertNotNull(env('FILE_URL'),'env not exists  FILE_URL');
        $this->assertNotNull(env('IMAGES_URL'),'env not exists  IMAGES_URL');
        $this->assertNotNull(env('MAIL_DRIVER'),'env not exists  MAIL_DRIVER');
        $this->assertNotNull(env('MAIL_HOST'),'env not exists  MAIL_HOST');
        $this->assertNotNull(env('MAIL_PORT'),'env not exists  MAIL_PORT');
        $this->assertNotNull(env('MAIL_USERNAME'),'env not exists  MAIL_USERNAME');
        $this->assertNotNull(env('MAIL_PASSWORD'),'env not exists  MAIL_PASSWORD');
        $this->assertNotNull(env('MAIL_ENCRYPTION'),'env not exists  MAIL_ENCRYPTION');
    }
    
    public function testDb() {
        $testTable = 'test';
        if(\Schema::hasTable($testTable)) {
            \Schema::drop($testTable);
        }
        $ok = \Schema::create($testTable, function($table)
        {
            $table->increments('id');
            $table->string('name');
        });
        $this->assertNull($ok,'create databases error');
        
        $this->assertTrue(\DB::table($testTable)->insert(array('name' => 'John')),'insert table error');
        
        $this->assertGreaterThanOrEqual(0,\DB::table($testTable)->count());
        \Schema::drop($testTable);
    }

    
    public function testIndex() {
        
    }
    
    
    
}