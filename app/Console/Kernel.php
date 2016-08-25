<?php
/**
 * 在这里放定时任务
 * linux 设置每分钟执行  * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
 *  
 * 定时任务
 * 
 */
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      
       //每天定时删除表数据
        $schedule->call(function () {
            dealRecycleData::file();
            dealRecycleData::table();
        })
        ->at("02:30");
        $schedule->call(function () {

            sendSms::export();
        })->sundays()->at("08:00");

    }
}
