<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 15/7/20
 * Time: 09:31
 */

namespace Admin\Controller;


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

        $this->display();
    }

}