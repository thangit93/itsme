<?php
    class Model_Favqs extends Zend_Db_Table_Abstract
    {
        protected $db;
        public function __construct(){
            $this->db=Zend_Registry::get('db');
            $this->db->query("SET NAMES 'utf8'");
        }
        
        public function findFavqbyUserId($user_id = 1)
        {
            $sql = <<<SQL
SELECT *
FROM
    favorite_quote
WHERE
    del_chk = 0
AND
    user_id = :USERID
SQL;
            return $this->db->fetchAll($sql,array('USERID' => $user_id), Zend_Db::FETCH_OBJ);
        }
    }
?>