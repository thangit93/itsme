<?php
require_once 'AbstractController.php';

class DiaryController extends AbstractController
{

    public function init()
    {
        parent::init();
        $this->view->headTitle()->set("Nhật ký của tôi!");
    }

    public function indexAction()
    {
        $this->redirect("diary/list");
    }
    
    public function listAction()
    {
        $diaryModel = new Model_Diaries();
        $limit = 6;
        
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
        else {
            $user_id = 1;
            $check = false;
        }
        
        if($this->_request->isPost()){
            
            $form = $this->_getParam('form');
            //var_dump($form['title']); exit;
            
            $upload = new Zend_File_Transfer();
            $upload->setDestination(APPLICATION_PATH.'/../public/images/diary/');
            $upload->addValidator('Extension',true,array('jpg','gif','png'));
            $files = $upload->getFileInfo();
            //echo "<pre>";
            //var_dump(substr($files['form_img_']['name'],strpos($files['form_img_']['name'],'.')+1));
            //echo "</pre>"; exit;
            foreach($files as $file=>$info){                
                if(!$upload->isUploaded($file)){
                    echo "<script>alert('Chưa chọn file');</script>";
                }
                elseif (!$upload->isValid()) {
                    echo "<script>alert('Sai cmn định dạng rồi');</script>";
                }
                else{
                    $form['img'] = $files['form_img_']['name'];
                    
                    $diaryModel->addDiary($user_id, $form);
                    $upload->receive();
                    $this->redirect("diary/index");
                }
            }
            
            
        }
        
        if(!empty($this->_request->getParam('page')))
        {
            $page = $this->_request->getParam('page');
        }
        else
        {
            $page = 1;
        }
        
        
        
        
        $diary = $diaryModel->findDiarybyUserId($user_id);
        
        $paginator = Zend_Paginator::factory($diary);
        $paginator->setItemCountPerPage($limit);
        $paginator->setPageRange(5);
        $paginator->setCurrentPageNumber($page);
        
        
        $this->view->diary = $paginator;
        $this->view->check = $check;
    }
    
    
}

