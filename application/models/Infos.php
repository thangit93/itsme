<?php
    class Model_Infos extends Zend_Db_Table_Abstract
    {
        protected $db;
        public function __construct(){
            $this->db=Zend_Registry::get('db');
            $this->db->query("SET NAMES 'utf8'");
        }
        
        public function findInfobyUserId($user_id = 1)
        {
            $sql = <<<SQL
SELECT *
FROM
    info
WHERE
    del_chk = 0
AND
    user_id = :USERID
SQL;
           return $this->db->fetchAll($sql,array('USERID' => $user_id), Zend_Db::FETCH_OBJ);
        }
        
    }
?>