<?php
    class UploadUtil extends Zend_File_Transfer
    {
        public static $extension_image = array(
            'jpg',
            'jpeg',
            'gif',
            'png'
        );
        
        private static $_settings = array(
            'maxFileSize' => 4194304,
            'minWidth' => -1,
            'maxWidth' => -1,
            'minHeight' => -1,
            'maxHeight' => -1
        );
        
        public static function uploadImage( $option = array())
        {
            $settings = array();
            foreach ($option as $key => $value) {
                $settings[$key] =
                array_merge(self::$_settings, array('extension' => self::$extension_image), $option[$key]);
            }
            return self::_upload($settings);
        }
        
        private static function _upload($tenantCode, $controller, $settings, $lang = 'ja')
        {      
            $config = Zend_Registry::get('fileConfig');
        
            $tempDirectory =
            implode(DIRECTORY_SEPARATOR, array($config->upload->tmp, $tenantCode, $controller));
            if (!file_exists($tempDirectory)) {
                mkdir($tempDirectory, 755, true);
            }

        
            $adapter = new Zend_File_Transfer_Adapter_Http();
            $adapter->setDestination($tempDirectory);
        

            $files = $adapter->getFileName();
            if (empty($files)) {
                return null;
            }
        
            $tempFileName = array();
            $uploadFileName = array();
        
            foreach ($adapter->getFileInfo() as $key => $fileInfo) {
        
                $fileName = $fileInfo['name'];
                if (empty($fileName)) {
                    continue;
                }
        
                $newKey = preg_replace('/^form_(.+?)_$/', '$1', $key);
                if (empty($newKey)) {
                    $newKey = $key;
                }
        
                if (isset($settings[$newKey])) {
                    $option = $settings[$newKey];
                } else {
                    $option = $settings['default'];
                }
        

                $extension = strtolower(FilenameUtil::getExtension($fileName));
        

                $extensions = $option['extension'];
                if (!in_array($extension, $extensions)) {
                    throw new Exception($translate->_('ERR_UPLOAD_INVALID_EXTENSION'));
                }
        

                if ($fileInfo['size'] > $option['maxFileSize']) {
                    throw new Exception($translate->_('ERR_UPLOAD_FILESIZE_LIMIT'));
                }
        

                if ($option['minWidth'] > 0 || $option['maxWidth'] > 0
                    || $option['minHeight'] > 0 || $option['maxHeight'] > 0) {
                        $size = getimagesize($fileInfo['tmp_name']);

                    }
        

                    if ($option['mustSquareWithPixel'] > 0 ) {
                        $size = getimagesize($fileInfo['tmp_name']);
                        if($size[0] !== $option['mustSquareWithPixel'] || $size[1] !== $option['mustSquareWithPixel']) {
                            throw new Exception(sprintf($translate->_('ERR_UPLOAD_IMAGE_NOT_VALID_SIZE_SQUARE'), $option['mustSquareWithPixel'], $option['mustSquareWithPixel']));
                        }
                    }
        

                    $uploadFileName[$newKey] = $fileName;
                    $tempFileName[$newKey] =
                    $fileInfo['destination'] . '/' . self::_generateFileName($controller, $extension);
        
                    if (!$adapter->receive($key)) {
                        throw new Exception($translate->_('ERR_UPLOAD_EXCEPTION'));
                    }
        
                    // ファイルをリネーム
                    rename($fileInfo['destination'] . '/' . $fileName, $tempFileName[$newKey]);
            }
            return (object)array(
                'UploadFileName' => $uploadFileName,
                'TempFileName' => $tempFileName
            );
        }
    }
?>