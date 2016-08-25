<?php
/**
 *  用户推广
 *  @author wangzhoudong
 *  @version    1.0
 *  @date 2016年4月8日
 *
 */
namespace App\Services\User;

use App\Models\UserInfoModel;
use App\Models\UserInviteInfoModel;
use App\Models\UserInfoWithdrawModel;
use App\Services\Base\BaseProcess;
use DB;
use Illuminate\Support\Facades\Redis;
use App\Services\Finance\FinanceUser;

class UserInviteInfo extends BaseProcess
{
    /**
     * 模型
     */
    private $_model;
    private $_userInfoModel;
    private $_modelUserInfoWithdraw;
    private $_erpRedis;
    private $_modelFinanceUser;
    
    /**
     * 初始化
     */
    public function __construct()
    {
        if( !$this->_model ) $this->_model = new UserInviteInfoModel();
        if( !$this->_userInfoModel ) $this->_userInfoModel = new UserInfoModel();
        if( !$this->_modelFinanceUser ) $this->_modelFinanceUser = new FinanceUser();
        if( !$this->_modelUserInfoWithdraw ) $this->_modelUserInfoWithdraw = new UserInfoWithdrawModel();
    }


    /**
     * @param $indirect_order
     */
    public function getIndirectOrder($indirect_order)
    {
        $list = $this->_model->where('from_user_id', '=', $indirect_order)->get();
        $return = [];
        foreach($list as $item){
            $uids = $this->_model->select('from_user_id', 'invited_user_id')
                ->where('is_create_order', '=', 1)
                ->where('ids', 'like', "%,{$item->id},%")
                ->get();
            foreach($uids as $id){
                $return[] = $id->invited_user_id;
            }
        }
        return $return;
    }

    /**
     *
     * @param $indirect_register
     */
    public function getIndirectRegister($indirect_register)
    {
        $list = $this->_model->where('from_user_id', '=', $indirect_register)->get();
        $return = [];
        foreach($list as $item){
            $uids = $this->_model->select('from_user_id', 'invited_user_id')
                ->where('ids', 'like', "%,{$item->id},%")
                ->get();
            foreach($uids as $id){
                $return[] = $id->invited_user_id;
            }
        }
        return $return;
    }


    /**
     * 搜索
     * @param $search
     * @param $pagesize
     */
    public function search($search, $orderby, $pagesize = PAGE_NUMS)
    {
        $currentQuery = $this->_model;
        if(isset($search['keyword']) && !empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('from_user_id'  , 'like', $keywords)
                ->orwhere('invited_user_id', 'like', $keywords);
            });
        }
        
        if(isset($search['from_user_id'])){
            $currentQuery = $currentQuery->whereIn('from_user_id', (array)$search['from_user_id']);
        }
        
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }else{
            $currentQuery = $currentQuery->orderBy('id', 'DESC');
        }
        $currentQuery = $currentQuery->with('hasOneInvitedUserInfo');
        $currentQuery = $currentQuery->paginate($pagesize);
        if($currentQuery) {
           
            foreach ($currentQuery as &$item) {
                $item->is_create_order = $this->_checkOrder($item,true) ? 1 : 0;
            }
        }
        return $currentQuery;
    }
    
    public function updateFinanceUser($from_user_id) {
        $data = $this->_model->where("from_user_id",$from_user_id)->where("is_create_order",0)->get();
        if($data) {
            foreach ($data as $item) {
                $this->_checkOrder($item,true);
            }
        }
    }
    /**
     * 
     * @param object $item
     * @param bool $addFinance 添加财务信息
     */
    private function _checkOrder($item,$addFinance=false) {
        if($item->is_create_order) {
            return true;
        }
        if(!$this->_erpRedis) {
            $this->_erpRedis = Redis::connection('erp');
        }
        $redisKey = '$user_order_' . $item->invited_user_id;
        if($this->_erpRedis->exists($redisKey)) {
            $data = $this->_erpRedis->hGetAll($redisKey);
            $amount = 0;
            foreach($data as $val) {
                $order = json_decode($val,true);
                
                
                //如果下单的条件满足,
                if(isset($order['financialFinish']) && $order['financialFinish']==true) {
                    $order['contractMoney'] = isset($order['contractMoney'])  ?  $order['contractMoney'] : 0;
                    $amount = $amount +  $order['contractMoney'];
//                     echo $amount;
                    if($amount >= (AMOOUNT_USER_PLATEFUL/100)) {
                        //添加财务信息
                        if($addFinance) {
//                             echo "执行付款";;;
                            $ok = $this->_addOrderFinance($item);
                            if(!$ok) {
                                echo $this->getMessage(); 
                                return false;
                            }
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
    /**
     * 用户下单的金额
     * @param object $item 
     */
    private function _addOrderFinance($item) {
        //邀请人获得财务信息
        \DB::beginTransaction();
        
        $ok = $this->_model->where("id",$item->id)->where("is_create_order",0)->update(['is_create_order'=>1]);
        if(!$ok) {
            \DB::rollback();
            $this->setMsg("改变状态失败");
            return false;
        }

        //找到上级的所有的id
        $myuids = $this->_model->whereIn('id', (array)explode(',', trim($item['ids'], ',')))->lists('from_user_id')->toArray();
        // 更新userinfo child_order_count
        $ok = $this->_userInfoModel->whereIn('id', (array)$myuids)->increment('child_order_count', 1);
        if($ok === false) {
            \DB::rollback();
            $this->setMsg("增加间接邀请下单用户人数失败");
            return false;
        }

        $addFinance['source_type'] = 2;
        $addFinance['amount'] =  AMOUNT_USER_ORDER;//流水金额
        $addFinance['user_id'] = $item->from_user_id;
        $addFinance['pay_type'] = "system";
        $ok = $this->_modelFinanceUser->addAmount($addFinance);
        
        if(!$ok) {
            \DB::rollback();
            $this->setMsg("返现失败" . $this->_modelFinanceUser->getMessage());
            return false;
        }
        
        
        //被邀请人获得财务信息
        $addFinance['source_type'] = 3;
        $addFinance['amount'] =  AMOUNT_USER_ORDER;//流水金额
        $addFinance['user_id'] = $item->invited_user_id;
        $addFinance['pay_type'] = "system";
        
        $ok = $this->_modelFinanceUser->addAmount($addFinance);
        
        if(!$ok) {
            \DB::rollback();
            $this->setMsg("返现失败" . $this->_modelFinanceUser->getMessage());
            return false;
        }
        
        
        \DB::commit();
        return true;        
    }
    /**
     * 添加
     * @param $data
     */
    public function create($data){
        $invited = $this->_userInfoModel->find($data['invited_user_id'])->toArray();
        $from = $this->_userInfoModel->find($data['from_user_id'])->toArray();

        if(strtotime($invited['created_at']) < strtotime($from['created_at'])){
            $this->setMsg('您添加的邀请人已经注册！');
            return false;
        }

        $count = $this->_model->where('invited_user_id', $data['invited_user_id'])->count();
        if($count){
            //这里不能重复添加，而且不能影响流程，所以返回true
            return true;
        }

        // 找到邀请人的被邀请信息（父级）
        $frominfo = $this->_model->where('invited_user_id', '=', trim($data['from_user_id']))->first();
        if($frominfo){
            $data['parent_id'] = $frominfo->id;
            // 如果rootid为0则id就是rootid
            $data['root_id'] = intval($frominfo->root_id)?$frominfo->root_id:$frominfo->id;
            $data['ids'] = "{$frominfo->ids}{$frominfo->id},";
            $data['ids'] = trim($data['ids'], ',');
            $data['ids'] = trim($data['ids'])?",{$data['ids']},":'';

            // 找到顶级的邀请信息
            $rootinfo = $this->_model->where('id', '=', $data['root_id'])->first();
            if($rootinfo && $rootinfo->from_user_id == $data['invited_user_id']){
                // 你总不能邀请最顶级的撒
                $this->setMsg('添加邀请人失败！');
                return false;
            }
        }else{
            // 没找到父级，说明是顶级
            $data['parent_id'] = 0;
            $data['root_id'] = 0;
            $data['ids'] = '';
        }

        DB::beginTransaction();
        //找到上级的所有的id
        $uids = $this->_model->whereIn('id', (array)explode(',', trim($data['ids'], ',')))->lists('from_user_id')->toArray();
        $ok = $this->_userInfoModel->whereIn('id', (array)$uids)->increment('child_reg_count', 1);
        if($ok === false){
            DB::rollback();
            $this->setMsg('增加间接邀请注册用户人数失败！');
            return false;
        }
        $obj = $this->_model->create($data);
        if($obj === false){
            DB::rollback();
            $this->setMsg('添加邀请人失败！');
            return false;
        }
        DB::commit();
        return $obj;
    }
    
    /**
     * 更新
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $bool = $this->_model->where('id', $id)->update($data);
        if($bool){
            return $id;
        }else{
            return false;
        }
    }
    
    /**
     * 删除
     * @param $id
     */
    public function destroy($id)
    {
        return $this->_model->destroy($id);
    }


    
    /**
     * 获取一行数据
     * @param $where
     * @return
     */
    public function find($id)
    {
        return $this->_model->find($id);
    }
    
    /**
     * 用户ID获取数据
     * @param $where
     * @return
     */
    public function getByUserId($user_id)
    {
        return $this->_model->where('from_user_id', $user_id)->get();
    }
    
    /**
     * 查询多条数据
     */
    public function get($pagesize = 0)
    {
        if($pagesize){
            return $this->_model->take($pagesize)->orderBy('id', 'DESC')->get();
        }else{
            return $this->_model->orderBy('id', 'DESC')->get();
        }
    }
    
    /**
     * 查询多条数据并分页
     */
    public function getPage($pagesize = PAGE_NUMS)
    {
        return $this->_model->orderBy('id', 'DESC')->paginate($pagesize);
    }
    
    /**
     * 条件筛选
     */
    public function filter($where, $orderby, $pagesize = PAGE_NUMS)
    {
        //条件
        $currentQuery = $this->_model;
        if($where && is_array($where)){
            foreach ($where AS $field => $value){
                $currentQuery = $currentQuery->where($field, $value);
            }
        }
        //排序
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery->orderBy($field, $value);
            }
        }
        return $currentQuery->take($pagesize)->get();
    }
    
    /**
     * 根据用户ID获取受邀用户ID
     * @param unknown $user_id
     */
    public function getInviteUIdForUid($user_id){
        return $this->_model->whereIn('from_user_id', (array)$user_id)->lists('invited_user_id')->toArray();
    }
    
    /**
     * 根据用户ID获取即将要到账的
     * @param unknown $user_id
     */
    public function getUpcomingAmount($user_id){
        return $this->_model->where('from_user_id', $user_id)->where('is_create_order', '=', 0)->sum('order_amount');
    }
    
    /**
     * 获取到统计信息
     * @param unknown $user_ids
     */
    public function countData($user_ids){
        $currentQuery = $this->_model;
        
        $uiit = $currentQuery->getTable();
        $uiwt = $this->_modelUserInfoWithdraw->getTable();
        
        $currentQuery = $currentQuery->select(
                "{$uiit}.from_user_id", 
                DB::raw("COUNT({$uiit}.id) AS reg_count"), 
                DB::raw("SUM({$uiit}.reg_amount) AS reg_amount") , 
                DB::raw("SUM(uiw.amount) AS no_withdraw_amount") , 
                DB::raw("SUM(uiw2.amount) AS  withdraw_amount"));
        
        $currentQuery = $currentQuery->leftJoin("{$uiwt} as uiw", function($join) use($uiit){
            $join->on("uiw.user_id", '=', "{$uiit}.from_user_id")->where('uiw.status', '=', 1);
        });
        
        $currentQuery = $currentQuery->leftJoin("{$uiwt} as uiw2", function($join) use($uiit){
            $join->on("uiw2.user_id", '=', "{$uiit}.from_user_id")->where('uiw2.status', '=', 12);
        });
        
        $currentQuery = $currentQuery->whereIn("{$uiit}.from_user_id", (array)$user_ids);
        
        if(is_array($user_ids)){
            return $currentQuery->first();
        }else{
            return $currentQuery->get();
        }
    }
    
    public function updateFinanceAll() {
        $data = $this->_model->where('is_create_order',0)->get();
        if($data) {
            foreach ($data as $item) {
                
                $this->_checkOrder($item,true);
            }
        }
        return true;
        
    }
    
    
}
