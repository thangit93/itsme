<?php
    class Model_Diaries extends Zend_Db_Table_Abstract
    {
        protected $db;
        public function __construct(){
            $this->db=Zend_Registry::get('db');
            $this->db->query("SET NAMES 'utf8'");
        }
        
        public function findDiarybyUserId($user_id = 1)
        {
            $sql = <<<SQL
SELECT *
FROM
    diary
WHERE
    del_chk = 0
AND
    user_id = :USERID
ORDER BY
    diary_id DESC
SQL;
            return $this->db->fetchAll($sql,array('USERID' => $user_id), Zend_Db::FETCH_OBJ);
        }
        
        public function addDiary($user_id = 1, $data)
        {
            $sql = <<<SQL
INSERT INTO
    diary(
            diary_title,
            diary_content,
            diary_img,
            user_id,
            del_chk
        )
VALUES
(
    :DIARYTITLE,
    :DIARYCONTENT,
    :DIARYIMG,
    :USERID,
    0
)
SQL;
            $result = $this->db->prepare($sql);
            $result->execute(array('DIARYTITLE' => $data['title'], 'DIARYCONTENT' => $data['content'], 'DIARYIMG' => $data['img'], 'USERID' => $user_id));
        }
        
    }
?>