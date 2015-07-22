<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 15/7/20
 * Time: 09:31
 */

namespace Admin\Controller;
use Admin\Api\AdminPublicApi;
use Admin\Api\DatatreeApi;
use Admin\Api\GoldcoinApi;


class GameController extends AdminController{

    /**
     * 游戏中心
     */
    public function center(){
        $this->redirect('Admin/Game/openbox');
    }

    /**
     * 开宝箱
     */
    public function openbox(){
    	$map=array();
        $page=  array('curpage'=>I('get.p',0),'size'=>10);
        $order = 'dtree_boxid asc';
		$result=apiCall(GoldcoinApi::QUERY,array($map,$page,$order));
		$gmap=array('parentid'=>31);
		$goldtype=apiCall(DatatreeApi::QUERY_NO_PAGING,array($gmap));
//		dump($goldtype);
		$this->assign('boxtype',$goldtype['info']);
		$this->assign('show',$result['info']['show']);
		$this->assign('goldcoin',$result['info']['list']);
        $this->display();
    }
	
	/*
	 * 添加宝箱
	 * */
	public function add(){
		if(IS_GET){
			$gmap=array('parentid'=>31);
			$goldtype=apiCall(DatatreeApi::QUERY_NO_PAGING,array($gmap));
			$this->assign('boxtype',$goldtype['info']);
			$this->display();
		}else{
			$entity=array(
				'name'=>I('boxname',''),
				'desc'=>I('boxdesc',''),
				'notes'=>I('notes',''),
				'dtree_boxid'=>I('typeid',0),
				'probability'=>I('gailv',0),
			);
			$result=apiCall(GoldcoinApi::ADD,array($entity));
			if($result['status']){
				$this->success('添加成功',U('Admin/Game/openbox'));
			}
		}
	}
	
	public function edit(){
		if(IS_GET){
			$ar=array('id'=>I('id'));
			$gmap=array('parentid'=>31);
			$goldtypes=apiCall(DatatreeApi::QUERY_NO_PAGING,array($gmap));
			$result=apiCall(GoldcoinApi::GET_INFO,array($ar));
			$this->assign('box',$result['info']);
			$this->assign('boxtypes',$goldtypes['info']);

			$this->display();
		}else{
			$id=I('id',0);
			$entity=array(
				'name'=>I('boxname',''),
				'desc'=>I('boxdesc',''),
				'notes'=>I('notes',''),
				'dtree_boxid'=>I('typeid',0),
				'probability'=>I('gailv',0),
			);
			$result=apiCall(GoldcoinApi::SAVE_BY_ID,array($id,$entity));
			if($result['status']){
				$this->success('修改成功',U('Admin/Game/openbox'));
			}
		}
	}
	public function delete(){
		$id=array('id'=>I('id',0));
		$result=apiCall(GoldcoinApi::DELETE,array($id));
		if($result['status']){
			$this->success('删除成功',U('Admin/Game/openbox'));
		}
	}
}