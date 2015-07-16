<?php
require_once 'AbstractController.php';

class IndexController extends AbstractController
{

    public function init()
    {
        parent::init();
        $this->_helper->layout->setLayout('layout');
    }

    public function indexAction()
    {
        if(!empty($this->_getParam('viewuser')))
        {
            $user_id = $this->_getParam('viewuser');
        }
        elseif(isset($this->_globalSession->user))
        {
            $user_id = $this->_globalSession->user->user_id;
        }
        else {
            $user_id = 1;
        }
        
        $infoModel = new Model_Infos();
        $info = $infoModel->findInfobyUserId($user_id);
        
        $pictureModel = new Model_Pictures();
        $picture = $pictureModel->findPicturebyUserId($user_id);
        
        $favqModel = new Model_Favqs();
        $favq = $favqModel->findFavqbyUserId($user_id);
        
        
        $this->view->info = $info;
        $this->view->picture = $picture;
        $this->view->favq = $favq;
    }
    
}
?>
