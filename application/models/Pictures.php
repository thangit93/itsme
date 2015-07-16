<?php
    class Model_Pictures extends Zend_Db_Table_Abstract
    {
        protected $db;
        public function __construct(){
            $this->db=Zend_Registry::get('db');
            $this->db->query("SET NAMES 'utf8'");
        }
        
        public function findPicturebyUserId($user_id = 1)
        {
            $sql = <<<SQL
SELECT *
FROM
    picture
WHERE
    del_chk = 0
AND
    user_id = :USERID
ORDER BY 
        picture_id DESC
LIMIT 0,6
SQL;
            return $this->db->fetchAll($sql,array('USERID' => $user_id), Zend_Db::FETCH_OBJ);
        }
        
        public function findAllPicturebyUserId($user_id = 1)
        {
            $sql = <<<SQL
SELECT *
FROM
    picture
WHERE
    del_chk = 0
AND
    user_id = :USERID
ORDER BY
        picture_id DESC
SQL;
            return $this->db->fetchAll($sql,array('USERID' => $user_id), Zend_Db::FETCH_OBJ);
        }
        
    public function addImg($user_id = 1, $data)
        {
            $sql = <<<SQL
INSERT INTO
    picture(
            picture_name,
            picture_content,
            picture_img,
            picture_date,
            user_id,
            del_chk
        )
VALUES
(
    :PICTURETITLE,
    :PICTURECONTENT,
    :PICTUREIMG,
     CURRENT_TIMESTAMP,
    :USERID,
    0
)
SQL;
            $result = $this->db->prepare($sql);
            $result->execute(array('PICTURETITLE' => $data['title'], 'PICTURECONTENT' => $data['content'], 'PICTUREIMG' => $data['img'], 'USERID' => $user_id));
        }
    }
?>