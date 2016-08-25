<?php

namespace App\Http\Controllers\Api\Project;

use App\Services\Project\Expert;
use App\Services\Project\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Validator;

class InfoController extends Controller
{

    private $_service;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * 给专家评分
     * @param Request $request
     */
    public function govScore(Request $request) {
        $_request = $request->all();
        $rules = array(
            'project_expert_id'          => 'required',
        );

        $validator = Validator::make($_request, $rules, []);
        if($validator->fails()){
            $this->toFailure($validator->messages()->first());
        }
        $updateData['gov_score'] = $request->get('exp_score');
        $updateData['gov_score_desc'] = $request->get('score_desc');
        $obj = new Expert();
        $ok = $obj->update($request->get('project_expert_id'),$updateData);
        if($obj) {
            //登录
            $this->toSucess('操作成功');
        }else{
            $this->toFailure($obj->getMessage());
        }
    }

    /**
     * 专家评分
     * @param Request $request
     */
    public function expertScore(Request $request) {
        $_request = $request->all();
        $rules = array(
            'project_expert_id'          => 'required',
            'zb_life_score'          => 'required',
            'zb_risk_score'          => 'required',
            'zb_encourage_score'          => 'required',
            'zb_potential_score'          => 'required',
            'zb_gov_score'          => 'required',
            'zb_financing_score'          => 'required',
            'zb_size_score'          => 'required',
            'zb_expected_score'          => 'required',
            'zb_fixed_score'          => 'required',
            'zb_measure_score'          => 'required',
            'zb_growth_score'          => 'required',
            'zb_demonstration_score'          => 'required',
            'zb_life_reason'          => 'required',
            'zb_risk_reason'          => 'required',
            'zb_encourage_reason'          => 'required',
            'zb_potential_reason'          => 'required',
            'zb_gov_reason'          => 'required',
            'zb_financing_reason'          => 'required',
            'zb_size_reason'          => 'required',
            'zb_expected_reason'          => 'required',
            'zb_fixed_reason'          => 'required',
            'zb_measure_reason'          => 'required',
            'zb_growth_reason'          => 'required',
            'zb_demonstration_reason'          => 'required',
        );

        $validator = Validator::make($_request, $rules, []);
        if($validator->fails()){
            $this->toFailure('请填写完整的评分以及评分理由');
        }
        $updateData['zb_life_score'] = $request->get('zb_life_score');
        $updateData['zb_risk_score'] = $request->get('zb_risk_score');
        $updateData['zb_encourage_score'] = $request->get('zb_encourage_score');
        $updateData['zb_potential_score'] = $request->get('zb_potential_score');
        $updateData['zb_gov_score'] = $request->get('zb_gov_score');
        $updateData['zb_financing_score'] = $request->get('zb_financing_score');
        $updateData['zb_size_score'] = $request->get('zb_size_score');
        $updateData['zb_expected_score'] = $request->get('zb_expected_score');
        $updateData['zb_fixed_score'] = $request->get('zb_fixed_score');
        $updateData['zb_measure_score'] = $request->get('zb_measure_score');
        $updateData['zb_growth_score'] = $request->get('zb_growth_score');
        $updateData['zb_demonstration_score'] = $request->get('zb_demonstration_score');


        $updateData['zb_life_reason'] = $request->get('zb_life_reason');
        $updateData['zb_risk_reason'] = $request->get('zb_risk_reason');
        $updateData['zb_encourage_reason'] = $request->get('zb_encourage_reason');
        $updateData['zb_potential_reason'] = $request->get('zb_potential_reason');
        $updateData['zb_gov_reason'] = $request->get('zb_gov_reason');
        $updateData['zb_financing_reason'] = $request->get('zb_financing_reason');
        $updateData['zb_size_reason'] = $request->get('zb_size_reason');
        $updateData['zb_expected_reason'] = $request->get('zb_expected_reason');
        $updateData['zb_fixed_reason'] = $request->get('zb_fixed_reason');
        $updateData['zb_measure_reason'] = $request->get('zb_measure_reason');
        $updateData['zb_growth_reason'] = $request->get('zb_growth_reason');
        $updateData['zb_demonstration_reason'] = $request->get('zb_demonstration_reason');


        $obj = new Expert();
        $ok = $obj->update($request->get('project_expert_id'),$updateData);
        if($obj) {
            //登录
            $this->toSucess('操作成功');
        }else{
            $this->toFailure($obj->getMessage());
        }
    }

    /**
     * 权重
     * @param Request $request
     */
    public function expertWeight(Request $request) {
        $_request = $request->all();
        $rules = array(
            'zb_life_weight'          => 'required',
            'zb_risk_weight'          => 'required',
            'zb_encourage_weight'          => 'required',
            'zb_potential_weight'          => 'required',
            'zb_gov_weight'          => 'required',
        );

        $validator = Validator::make($_request, $rules, []);
        if($validator->fails()){
            $this->toFailure($validator->messages()->first());
        }
        $updateData['zb_life_weight'] = $request->get('zb_life_weight');
        $updateData['zb_risk_weight'] = $request->get('zb_risk_weight');
        $updateData['zb_encourage_weight'] = $request->get('zb_encourage_weight');
        $updateData['zb_potential_weight'] = $request->get('zb_potential_weight');
        $updateData['zb_gov_weight'] = $request->get('zb_gov_weight');
        $updateData['zb_financing_weight'] = $request->get('zb_financing_weight');
        $updateData['zb_size_weight'] = $request->get('zb_size_weight');
        $updateData['zb_expected_weight'] = $request->get('zb_expected_weight');
        $updateData['zb_fixed_weight'] = $request->get('zb_fixed_weight');
        $updateData['zb_measure_weight'] = $request->get('zb_measure_weight');
        $updateData['zb_growth_weight'] = $request->get('zb_growth_weight');
        $updateData['zb_demonstration_weight'] = $request->get('zb_demonstration_weight');
        $count = 0;
        foreach($updateData as $val) {
            $count = $count+$val;
        }
        if($count!=100) {
            $this->toFailure("指标合计必须等于100");
        }
        $obj = new Expert();
        $ok = $obj->update($request->get('project_expert_id'),$updateData);
        if($obj) {
            //登录
            $this->toSucess('操作成功');
        }else{
            $this->toFailure($obj->getMessage());
        }
    }

    public function questionData(Request $request) {
        $_request = $request->all();
        $rules = array(
            'project_question_id'          => 'required',
            'content'          => 'required',
        );

        $validator = Validator::make($_request, $rules, []);
        if($validator->fails()){
            $this->toFailure($validator->messages()->first());
        }
        $addData['project_question_id'] = $request->get('project_question_id');
        $addData['project_id'] = $request->get('project_id');
        $addData['user_id'] = $this->_user['id'];
        $addData['nickname'] = $this->_user['name'];
        $addData['content'] = $request->get('content');
        $addData['avater'] = $this->_user['avater'];
        $obj = new Question();
        $ok = $obj->addData($addData);
        if($obj) {
            //登录
            $this->toSucess($addData);
        }else{
            $this->toFailure($obj->getMessage());
        }
    }


}
