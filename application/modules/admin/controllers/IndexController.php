<?php
require_once 'AbstractController.php';

class Admin_IndexController extends AbstractController
{

    public function init()
    {
        parent::init();        
    }

    public function indexAction()
    {
        $userModel = new Model_Users();
        $userList = $userModel->findAllUser();
        $this->view->countUser = count($userList);
        $this->view->title = "Bảng điều khiển";
    }


}

