<?php
require_once 'AbstractController.php';

class UserController extends AbstractController
{

    public function init()
    {
        parent::init();
        $this->view->headTitle()->set("Trang cá nhân");
    }
    
    public function indexAction()
    {
        if(!empty($this->_getParam('viewuser')))
        {
            $user_id = $this->_getParam('viewuser');
            $check = false;
        }
        elseif(isset($this->_globalSession->user))
        {
            $user_id = $this->_globalSession->user->user_id;
            $check = true;
        }
        
        $userModel = new Model_Users();
        $userInfo = $userModel->findUserbyUserId($user_id);
        $this->view->userInfo = $userInfo;
        $this->view->check = $check;
    }
}