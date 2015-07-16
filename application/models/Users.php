<?php
    class Model_Users extends Zend_Db_Table_Abstract
    {
        protected $db;
        public function __construct(){
            $this->db=Zend_Registry::get('db');
            $this->db->query("SET NAMES 'utf8'");
        }
        
        public function login($user_name, $password)
        {
            $sql = <<<SQL
SELECT *
FROM
    user
WHERE
    del_chk = 0
AND
    user_name = :USERNAME
AND
    password = :PASSWORD
SQL;
           return $this->db->fetchRow($sql,array('USERNAME' => $user_name, 'PASSWORD' => md5($password)), Zend_Db::FETCH_OBJ);
        }
        
        public function findUserbyUserId($userId)
        {
            $sql = <<<SQL
SELECT *
FROM
    user U
INNER JOIN
    role R
ON
    U.role_id = R.role_id
WHERE
    U.del_chk = 0
AND
    U.user_id = :USERID
SQL;
            return $this->db->fetchRow($sql,array('USERID' => $userId), Zend_Db::FETCH_ASSOC);
        }
        
        public function findAllUser()
        {
            $sql = <<<SQL
SELECT 
                U.user_id,
                U.user_name,
                U.role_id,
                R.role_name,
                U.del_chk
FROM
    user U
INNER JOIN
    role R
ON
    U.role_id = R.role_id
SQL;
            return $this->db->fetchAll($sql,array(), Zend_Db::FETCH_OBJ);
        }

        public function lockUser($userId)
        {
            $sql = <<<SQL
UPDATE
    user U
SET
    U.del_chk = 1
WHERE
    U.user_id = :USERID
SQL;
            $result = $this->db->prepare($sql);
            $result->execute(array('USERID'=>$userId));
        }
        
        public function unlockUser($userId)
        {
            $sql = <<<SQL
UPDATE
    user U
SET
    U.del_chk = 0
WHERE
    U.user_id = :USERID
SQL;
            $result = $this->db->prepare($sql);
            $result->execute(array('USERID'=>$userId));
        }
        
        public function addUserLog($userId)
        {
            $sql = <<<SQL
            INSERT INTO
                user_log
            VALUES(
                '',
                :USERID,
                CURRENT_TIMESTAMP,
                '',
                0    
            )
SQL;
            $result = $this->db->prepare($sql);
            $result->execute(array('USERID'=>$userId));
        }
    }
?>