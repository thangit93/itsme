<?php
require_once 'AbstractController.php';

class PictureController extends AbstractController
{

    public function init()
    {
        parent::init();
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
        else {
            $user_id = 1;
            $check = false;
        }
    
        $pictureModel = new Model_Pictures();
        $picture = $pictureModel->findAllPicturebyUserId($user_id);
        $limit = 6;       


         if(!empty($this->_request->getParam('page')))
        {
            $page = $this->_request->getParam('page');
        }
        else
        {
            $page = 1;
        }
        
        if($this->_request->isPost()){
        
            $form = $this->_getParam('form');
        
            $upload = new Zend_File_Transfer();
            $upload->setDestination(APPLICATION_PATH.'/../public/images/pictures/');
            $upload->addValidator('Extension',true,array('jpg','gif','png'));
            $files = $upload->getFileInfo();

            foreach($files as $file=>$info){
                if(!$upload->isUploaded($file)){
                    echo "<script>alert('Chưa chọn file');</script>";
                }
                elseif (!$upload->isValid()) {
                    echo "<script>alert('Sai cmn định dạng rồi');</script>";
                }
                else{
                    $form['img'] = $files['form_img_']['name'];
                    
                    $pictureModel->addImg($user_id, $form);
                    $upload->receive();
                    $this->redirect("picture/index");
                }
            }
        
            
        }
         
        
        $paginator = Zend_Paginator::factory($picture);
        $paginator->setItemCountPerPage($limit);
        $paginator->setPageRange(5);
        $paginator->setCurrentPageNumber($page);
        
        
        $this->view->picture = $paginator;
        $this->view->check = $check;
    }
    
}
?>
