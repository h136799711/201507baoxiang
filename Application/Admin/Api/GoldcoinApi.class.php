<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY 杭州博也网络科技有限公司
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2016, http://www.itboye.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Admin\Api;

use Common\Api\Api;
use Admin\Model\GoldcoinModel;

class GoldcoinApi extends Api{

    /**
     * 查询单条记录
     */
    const GET_INFO = "Admin/Goldcoin/getInfo";
    /**
     * 查询，不分页
     */
    const QUERY_NO_PAGING = "Admin/Goldcoin/queryNoPaging";
    /**
     * 添加
     */
    const ADD = "Admin/Goldcoin/add";
    /**
     * 保存
     */
    const SAVE = "Admin/Goldcoin/save";
    /**
     * 保存根据ID主键
     */
    const SAVE_BY_ID = "Admin/Goldcoin/saveByID";

    /**
     * 删除
     */
    const DELETE = "Admin/Goldcoin/delete";

    /**
     * 查询
     */
    const QUERY = "Admin/Goldcoin/query";
	protected function _init(){
		$this->model = new GoldcoinModel();
	}
	
}
