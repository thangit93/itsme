<?php
require_once 'AbstractController.php';

class Admin_UserController extends AbstractController
{

    public function init()
    {
        parent::init();        
    }

    public function indexAction()
    {
        $this->_redirect(array('module'=>'admin','controller'=>'user','action'=>'list'));
    }
    
    public function listAction()
    {
        $userModel = new Model_Users();
        $userList = $userModel->findAllUser();
        $this->view->title = "Danh sách user";
        $this->view->userList = $userList;
    }
    
    public function lockAction()
    {
        $userId = $this->getParam('uid');
        $userModel = new Model_Users();
        $userModel->lockUser($userId);
        $this->_redirect(array('module'=>'admin','controller'=>'user','action'=>'list'));
    }
    
    public function unlockAction()
    {
        $userId = $this->getParam('uid');
        $userModel = new Model_Users();
        $userModel->unlockUser($userId);
        $this->_redirect(array('module'=>'admin','controller'=>'user','action'=>'list'));
    }

}

