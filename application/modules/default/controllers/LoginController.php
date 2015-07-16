<?php
require_once 'AbstractController.php';

class LoginController extends AbstractController
{

    public function init()
    {
        parent::init();
        $this->view->headTitle()->set("Nhật ký của tôi!");
    }

    public function indexAction()
    {
        if(isset($this->_globalSession->user))
        {  
            $this->_redirect(array('controller'=>'index','action'=>'index'));
        }
        else 
        {
            if(!empty($this->getParam('form')))
            {
                $form = $this->getParam('form');
                $userModel = new Model_Users();
                $user = $userModel->login($form['username'], $form['password']);
                if(empty($user))
                {
                    $this->view->message = "Tài khoản mật khẩu không đúng";                    
                }
                else
                {
                    $userId = $user->user_id;
                    $userModel->addUserLog($userId);
                    $this->_globalSession->user = $user;
                    $this->_redirect(array('controller'=>'index','action'=>'index'));
                }
            }   
        }
        
    }
    
    public function logoutAction()
    {
        unset($this->_globalSession->user);
        $this->_redirect(array('controller'=>'index','action'=>'index'));
    }
        
}