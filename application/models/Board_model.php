<?php
class Board_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    public function category_lists_gets()
    {
      return $this->db->query('SELECT * FROM category')->result();
    }

    public function sub_category_lists_gets()
    { 
      return $this->db->query('SELECT * FROM sub_category')->result();
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
        } else {
            $search_query = '"%'.$search.'%"';
            $sql = 'SELECT board_id, title, author, UNIX_TIMESTAMP(board_created) AS board_created, sub_category_id, secret, hits 
                     FROM board WHERE secret="N" AND (description LIKE '.$search_query.' OR title LIKE '.$search_query.') ORDER BY board_created DESC, board_id DESC'.$limit_query;
        }

        $query = $this->db->query($sql);
 
        if ($type === 'count') {
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

    public function read_get($board_id)
    {
        return $this->db->query('SELECT * FROM board WHERE board_id='.$board_id)->row();
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
                    
         if($type === 'count'){
            return $this->db->query('SELECT reply_id ,board_id, re_author, re_description, reply_created 
                                     FROM reply WHERE board_id='.$board_id.' ORDER BY reply_created ASC'.$limit_query)->num_rows(); 
         } else {
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

    public function reply_delete($reply_id)
    {
        $this->db->where('reply_id', $reply_id);
        $this->db->delete('reply');
        return TRUE;
    }
}