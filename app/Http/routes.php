<?php

use App\Services\Base\Routes as RoutesManager;

$routesManager = new RoutesManager();
$routesManager->admin()->api();


#-------------------------------------单页star-------------------------------#

Route::get('/', [
    'as' => 'index', 'uses' => 'Web\IndexController@index',
]);//首页
Route::get('login/index', 'Web\LoginController@index');
Route::get('login/logout', 'Web\LoginController@logout');
Route::any('login/gov', 'Web\LoginController@gov');
Route::any('login/expert', 'Web\LoginController@expert');
Route::any('login/resetPwd', 'Web\LoginController@resetPwd');

Route::any('register/gov', 'Web\RegisterController@gov');
Route::any('register/expert', 'Web\RegisterController@expert');
Route::get('/user/edit', 'Web\UserController@edit');





Route::any('tools/uploadImg', 'Web\ToolsController@uploadImg');

#=====================================单页 end==============================#
#----------------------------------用户中心start-------------------------------#
##个人中心
Route::any('user/index', ['middleware' => ['auth'],'uses'=>'Web\UCenter\UserController@index']);

###用户信息
Route::any('account/userinfo', ['middleware' => ['auth'],'uses'=>'Web\UCenter\UserController@userInfo']);

#====================================用户中心end==============================#

Route::get('project.html',['middleware' => ['auth'],'uses'=>  'Web\ProjectController@index']);
Route::get('/project/info/detail', ['middleware' => ['auth'],'uses'=>'Web\Project\InfoController@index']);
Route::get('/project/info/expert', ['middleware' => ['auth'],'uses'=>'Web\Project\InfoController@expert']);
Route::get('/project/info/question', ['middleware' => ['auth'],'uses'=>'Web\Project\InfoController@question']);
Route::get('/project/info/weight', ['middleware' => ['auth'],'uses'=>'Web\Project\InfoController@weight']);
Route::get('/project/info/score', ['middleware' => ['auth'],'uses'=>'Web\Project\InfoController@score']);
Route::get('/project/info/risk', ['middleware' => ['auth'],'uses'=>'Web\Project\InfoController@risk']);


Route::get('/project/sample/detail','Web\Project\SampleController@index');
Route::get('/project/sample/expert','Web\Project\SampleController@expert');
Route::get('/project/sample/question','Web\Project\SampleController@question');
Route::get('/project/sample/weight','Web\Project\SampleController@weight');
Route::get('/project/sample/score','Web\Project\SampleController@score');
Route::get('/project/sample/risk', 'Web\Project\SampleController@risk');




Route::any('project/add1', ['middleware' => ['gov_auth'],'uses'=> 'Web\ProjectController@addOne']);
Route::any('project/add2',  ['middleware' => ['gov_auth'],'uses'=>'Web\ProjectController@addTwo']);
Route::any('project/add3',  ['middleware' => ['gov_auth'],'uses'=>'Web\ProjectController@addThree']);
Route::any('project/add4',  ['middleware' => ['gov_auth'],'uses'=>'Web\ProjectController@addFour']);
Route::any('project/add5',  ['middleware' => ['gov_auth'],'uses'=>'Web\ProjectController@addFive']);




Route::get('expert.html', 'Web\ExpertController@index');
Route::get('/expert/detail/{user_id}', 'Web\ExpertController@detail');
Route::get('videos.html', 'Web\VideosController@index');
Route::get('flow.html', 'Web\FlowController@index');
Route::get('about.html', 'Web\AboutController@index');
Route::get('about/protocol.html', 'Web\AboutController@protocol');
Route::get('about/pay.html', 'Web\AboutController@pay');
Route::get('about/user.html', 'Web\AboutController@user');


