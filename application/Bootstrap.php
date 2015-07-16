<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initLayout()
    {
        $option = array(
            'layoutPath' => APPLICATION_PATH .'/layouts/scripts',
            'layout' => 'main'
        );
        Zend_Layout::startMvc($option);
    }
    
    protected function _initDb()
    {
        $db = $this->getPluginResource('db')->getDbAdapter();
        Zend_Registry::set('db', $db);
    }
    
    protected function _initAutoLoad()
    {
        $autoloader = new Zend_Application_Module_Autoloader(
            array (
                'namespace' => '',
                'basePath' => APPLICATION_PATH
            )
        );
        return $autoloader;
    }
    
    protected function _initFile()
    {
        $options = new Zend_Config($this->getOptions());
    
        $fileConfig = $options->file;
        Zend_Registry::set('fileConfig', $fileConfig);
    }
    
}

