<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Admin\Controller;
use App\Services\Project\Expert;
use App\Services\Project\Project;
use App\Services\Project\Question;
use Request;
use Validator;

/**
 * 
 *--------------------------------------------------------------------------
 * META信息管理
 *--------------------------------------------------------------------------
 *
 * @author wangzhoudong
 * @date 2015年12月29日 下午4:21:16
 * @version V1.0
 *
 */
class QuestionController extends Controller
{
    private $_service;
    private $_serviceData;
    
    public function __construct() {
        parent::__construct();
        if(!$this->_service) $this->_service = new Question();
    }



    /**
     * 专家
     */
    public function deleteData() {
        $id = request()->get('data_id');

        $ok = $this->_service->destroyData($id);

        if($ok) {
            $this->showMessage('操作成功');
        }else{
            $this->showWarning($this->_service->getMessage());
        }
        return view('admin.project.info.question',compact('data','question','afterYear'));

    }

    /**
     * 删除
     */
    public function destroy() {
        $bool = $this->_service->destroy(Request::input('id'));
        $this->showMessage($bool !== false?'操作成功':'操作失败');
    }

    

}