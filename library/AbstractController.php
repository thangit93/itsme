<?php
    class AbstractController extends Zend_Controller_Action
    {
        protected $_globalSession;
        public function init()
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
            $this->view->isLogin = false;
            
            $this->view->headTitle()->set("Đây là tôi! Chất của tôi");
            $slideModel = new Model_Slides();
            $slide = $slideModel->findSlidebyUserId($user_id);
            $controllerName = $this->_request->getControllerName();
            
            $this->_globalSession = new Zend_Session_Namespace('Global');
            if(isset($this->_globalSession->user))
            {
                $this->view->isLogin = true;
                $this->view->user = $this->_globalSession->user;
            }
            
            $this->view->slide = $slide; 
            $this->view->controllerName = $controllerName;
        }
        
        public function preDispatch()
        {
            if (strpos($this->_request->getModuleName(), 'admin') !== false)
            {
                $this->_helper->layout->setLayout('layout-admin');
                if($this->_globalSession->user->role_id!=1)
                {
                    $this->_redirect(array('module'=>'default', 'controller'=>'index'));
                }            
            }
        }
        protected function _redirect($url, $options = array())
        {
            if (!is_array($url)) {
                parent::_redirect($url, $options);
            }
            parent::_redirect($this->_buildUrl($url));
        }
        private function _buildUrl($url = array())
        {
            $module = isset($url['module']) ? $url['module'] : $this->_moduleName;
            if ($module != 'default') {
                $urls[] = $module;
            }
            $urls[] = isset($url['controller']) ? $url['controller'] : $this->_controllerName;
            $urls[] = isset($url['action']) ? $url['action'] : '';
            return implode($urls, '/') . (!isset($url['parameter']) ? '' : '?' . http_build_query($url['parameter'], "\n"));
        }
    }
?>