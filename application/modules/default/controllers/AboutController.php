<?php
    require_once 'AbstractController.php';
    
    class AboutController extends AbstractController
    {
        public function init()
        {
            parent::init();
            $this->view->headTitle()->set("Thông tin của tôi!");
        }
        public function indexAction()
        {
            
        }
    }
?>