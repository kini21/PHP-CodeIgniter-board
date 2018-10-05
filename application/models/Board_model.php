<?php
class Board_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    public function getByAdmin($id)
    {
        return $this->db->query('SELECT * FROM admin WHERE id= '.'\''.$id.'\'')->row();
    }

    public function categoryRank($cate = 'category', $cur_rank, $cb_rank = '', $category_id = '')
    {
        if($cb_rank == 'up' && $cate == 'category'){
            return $this->db->query('SELECT category_id, category_rank FROM category WHERE category_rank= '.$cur_rank.'-1')->row();
        } 
        else if($cb_rank == 'down' && $cate == 'category') {
            return $this->db->query('SELECT category_id, category_rank FROM category WHERE category_rank= '.$cur_rank.'+1')->row();
        }
        else if($cb_rank == 'up' && $cate == 'sub_category') {
            return $this->db->query('SELECT sub_category_id , sub_category_rank FROM sub_category WHERE category_id= '.$category_id.' AND sub_category_rank= '.$cur_rank.'-1')->row();
        }
        else if($cb_rank == 'down' && $cate == 'sub_category') {
            return $this->db->query('SELECT sub_category_id , sub_category_rank FROM sub_category WHERE category_id= '.$category_id.' AND sub_category_rank= '.$cur_rank.'+1')->row();
        }
    }

    public function updateCategoryRank($upAnddown_rankID = '', $upAnddown_rank = '', $cur_rankID = '', $cur_rank = '', $chk = 'cur', $cb_rank = '')
    {
        if($chk != 'cur' && $cb_rank == 'up'){
            $this->db->set('category_rank', $upAnddown_rank.'+1', FALSE);
            $this->db->where('category_id', $upAnddown_rankID);
            $this->db->update('category');
        } 
        else if($chk == 'cur' && $cb_rank == 'cur_up'){
            $this->db->set('category_rank', $cur_rank.'-1', FALSE);
            $this->db->where('category_id', $cur_rankID);
            $this->db->update('category');
        }    
        else if($chk != 'cur' && $cb_rank == 'down'){
            $this->db->set('category_rank', $upAnddown_rank.'-1', FALSE);
            $this->db->where('category_id', $upAnddown_rankID);
            $this->db->update('category');
        } 
        else if($chk == 'cur' && $cb_rank == 'cur_down'){
            $this->db->set('category_rank', $cur_rank.'+1', FALSE);
            $this->db->where('category_id', $cur_rankID);
            $this->db->update('category');
        }

        return TRUE;
    }

    public function updateSubCategoryRank($upAnddown_rankID = '', $upAnddown_rank = '', $cur_rankID = '', $cur_rank = '', $chk = 'cur', $cb_rank = '')
    {
        if($chk != 'cur' && $cb_rank == 'up'){
            $this->db->set('sub_category_rank', $upAnddown_rank.'+1', FALSE);
            $this->db->where('sub_category_id', $upAnddown_rankID);
            $this->db->update('sub_category');
        } 
        else if($chk == 'cur' && $cb_rank == 'cur_up'){
            $this->db->set('sub_category_rank', $cur_rank.'-1', FALSE);
            $this->db->where('sub_category_id', $cur_rankID);
            $this->db->update('sub_category');
        }    
        else if($chk != 'cur' && $cb_rank == 'down'){
            $this->db->set('sub_category_rank', $upAnddown_rank.'-1', FALSE);
            $this->db->where('sub_category_id', $upAnddown_rankID);
            $this->db->update('sub_category');
        } 
        else if($chk == 'cur' && $cb_rank == 'cur_down'){
            $this->db->set('sub_category_rank', $cur_rank.'+1', FALSE);
            $this->db->where('sub_category_id', $cur_rankID);
            $this->db->update('sub_category');
        }

        return TRUE;
    }

    public function createCategory($category_name, $rank_max)
    {
        $this->db->set('category_name', $category_name);
        $this->db->set('category_rank', $rank_max.'+1', FALSE);
        $this->db->insert('category');
        return $this->db->insert_id();
    }

    public function createSubCategory($category_id, $category_name, $rank_max)
    {
        $this->db->set('category_id', $category_id);
        $this->db->set('sub_category_name', $category_name);
        $this->db->set('sub_category_rank', $rank_max.'+1', FALSE);
        $this->db->insert('sub_category');
        return $this->db->insert_id();
    }

    public function updateCategory($category_id, $category_name)
    {
        $data = array(
            'category_name' => $category_name
        );
        $this->db->where('category_id', $category_id);
        $this->db->update('category', $data);

        return TRUE;
    }

    public function updateSubCategory($category_id, $sub_category_name)
    {
        $data = array(
            'sub_category_name' => $sub_category_name
        );
        $this->db->where('category_id', $category_id);
        $this->db->update('sub_category', $data);

        return TRUE;
    }

    public function deleteCategory($category_id = '', $sub_category_id = '')
    {
        if($category_id != ''){
            $this->db->where('category_id', $category_id);
            $this->db->delete('category');
        } else {
            $this->db->where('sub_category_id', $sub_category_id);
            $this->db->delete('sub_category');
        }
  
        return TRUE;
    }

    public function maxCategory($category_id = '')
    {
        if($category_id != '') {
            return $this->db->query('SELECT max(sub_category_rank) AS MAX FROM sub_category WHERE category_id ='.$category_id)->row();
        } else {
            return $this->db->query('SELECT max(category_rank) AS MAX FROM category')->row();
        }
    }

    public function category_lists_gets($category_name = '')
    {
        if($category_name != '') {
            return $this->db->query('SELECT category_name FROM category WHERE category_name= '.'\''.$category_name.'\'')->row();
        } else {
            return $this->db->query('SELECT * FROM category ORDER BY category_rank ASC')->result();   
        }
    }

    public function sub_category_lists_gets($category_id = '', $sub_category_name = '', $chk = '')
    { 
        if($category_id != '' && $sub_category_name != ''){
            return $this->db->query('SELECT * FROM sub_category WHERE category_id= '.$category_id. ' AND sub_category_name= '.'\''.$sub_category_name.'\'')->row();
        }
        else if ($chk == 'board'){
            return $this->db->query('SELECT * FROM sub_category WHERE category_id= '.$category_id.' ORDER BY sub_category_rank ASC')->result();
        } 
        else {
            return $this->db->query('SELECT * FROM sub_category ORDER BY sub_category_rank ASC')->result();
        }
    }

    public function CateAndBoard_count($list, $cate = '')
    {
        if($cate == 'cate'){
            foreach($list as $li) {
                $cnt[] = $this->db->query('SELECT COUNT(*) AS CNT FROM sub_category WHERE category_id= '.$li->category_id)->result();
            } 
        } else {
            foreach($list as $li) {
                $cnt[] = $this->db->query('SELECT COUNT(*) AS CNT FROM board WHERE sub_category_id= '.$li->sub_category_id)->result();
            }
        }   
        return $cnt;
    }

    public function subCategoryLists_get($category_id)
    {
        return $this->db->query('SELECT * FROM sub_category WHERE category_id='.$category_id)->num_rows();
    }

    public function boardLists_get($sub_category_id = '', $type='', $offset='', $limit='', $search='')
    {
        $limit_query = '';
 
        if ($limit != '' OR $offset != '') {
            $limit_query = ' LIMIT ' . $offset . ', ' . $limit;
        }
        
        if ($sub_category_id != '') {
            $sql = "SELECT board_id, title, author, UNIX_TIMESTAMP(board_created) AS board_created, sub_category_id, secret, hits 
                    FROM board WHERE sub_category_id=".$sub_category_id." ORDER BY board_created DESC, board_id DESC".$limit_query;
        } 
        else if ($sub_category_id != '' && $type === 'count2') {
            $sql = "SELECT * FROM board WHERE sub_category_id=".$sub_category_id;
        } 
        else {
            $search_query = '"%'.$search.'%"';
            $sql = 'SELECT board_id, title, author, UNIX_TIMESTAMP(board_created) AS board_created, sub_category_id, secret, hits 
                     FROM board WHERE secret="N" AND (description LIKE '.$search_query.' OR title LIKE '.$search_query.') ORDER BY board_created DESC, board_id DESC'.$limit_query;
        }

        $query = $this->db->query($sql);
 
        if ($type === 'count' || $type === 'count2') {
            $result = $query -> num_rows();
        } else {
            $result = $query -> result();
        }
 
        return $result;
    }

    public function update_hits($board_id)
    {
        $this->db->set('hits', 'hits+1', FALSE);
        $this->db->where('board_id', $board_id);
        $this->db->update('board');

        return TRUE;
    }

    public function passwordCheck($board_id, $password)
    {
        return $this->db->select('password')
                ->where('board_id', $board_id)
                ->where('password', $password)
                ->get('board')
                ->row();
    }

    public function read_get($board_id = '', $sub_category_id = '', $board_created = '', $chk = '')
    {
        if($chk == 'next') {
            return $this->db->query('SELECT * FROM board WHERE sub_category_id='.$sub_category_id.' AND board_created < '.'\''.$board_created.'\''.' ORDER BY board_created DESC LIMIT 1')->row();
        }
        else if($chk == 'prev'){
            return $this->db->query('SELECT * FROM board WHERE sub_category_id='.$sub_category_id.' AND board_created > '.'\''.$board_created.'\''.' ORDER BY board_created ASC LIMIT 1')->row();
        }
        else{
            return $this->db->query('SELECT * FROM board WHERE board_id='.$board_id)->row();
        }
    }

    public function getName($sub_category_id = NULL, $category_id = NULL)
    {
        if($sub_category_id != NULL)
        {
            return $this->db->query('SELECT category_id, sub_category_name FROM sub_category WHERE sub_category_id='.$sub_category_id)->row();
        } else
        {
            return $this->db->query('SELECT category_name FROM category WHERE category_id='.$category_id)->row();
        } 
    }

    public function write($author, $password, $email, $tel, $title, $secret, $description, $sub_category_id)
    {
        $this->db->set('board_created', 'NOW()', false);
        $this->db->insert('board', array(
            'author' => $author,
            'password' => $password,
            'email' => $email,
            'tel' => $tel,
            'title' => $title,
            'secret' => $secret,
            'description' => $description,
            'sub_category_id'=> $sub_category_id
        ));
        return $this->db->insert_id();
    }

    public function update($board_id, $author, $password, $email, $tel, $title, $secret, $description)
    {
        $data = array(
            'author' => $author, 
            'password' => $password, 
            'email' => $email, 
            'tel' => $tel, 
            'title' => $title,
            'secret' => $secret, 
            'description' => $description
        );
        $this->db->where('board_id', $board_id);
        $this->db->update('board', $data);

        return TRUE;
    }

    public function delete($board_id)
    {
        $this->db->where('board_id', $board_id);
        $this->db->delete('board');
        
        return TRUE;
    }

    public function replyLists($board_id, $type='', $offset='', $limit='')
    {

        $limit_query = '';
 
        if ($limit != '' OR $offset != '') {
            $limit_query = ' LIMIT ' . $offset . ', ' . $limit;
        }
                    
        if($type === 'count')
        {
            return $this->db->query('SELECT reply_id ,board_id, re_author, re_description, reply_created 
                                     FROM reply WHERE board_id='.$board_id.' ORDER BY reply_created ASC'.$limit_query)->num_rows(); 
        }
        else if ($type === 'count2')
        {
            return $this->db->query('SELECT * FROM reply WHERE board_id='.$board_id)->num_rows(); 
        }
        else 
        {
            return $this->db->query('SELECT reply_id ,board_id, re_author, re_description, reply_created 
                                     FROM reply WHERE board_id='.$board_id.' ORDER BY reply_created ASC'.$limit_query)->result(); 
         }
                                 
    }

    public function reply_write($board_id, $re_author, $re_description)
    {
        $this->db->set('reply_created', 'NOW()', false);
        $this->db->insert('reply', array(
            'board_id'  => $board_id,
            're_author' => $re_author,
            're_description' => $re_description
        ));
        return $this->db->insert_id();
    }

    public function reply_update($reply_id, $re_author, $re_description)
    {
        $data = array(
            're_author' => $re_author,  
            're_description' => $re_description
        );
        $this->db->where('reply_id', $reply_id);
        $this->db->update('reply', $data);

        return TRUE;
    }

    public function reply_delete($reply_id = '', $board_id = '')
    {
        if($board_id == '') {
            $this->db->where('reply_id', $reply_id);
        } else {
            $this->db->where('board_id', $board_id);
        } 
        $this->db->delete('reply');
        
        return TRUE;
    }
}