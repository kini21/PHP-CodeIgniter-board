<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends MY_Controller {

	 function __construct()
	 {
         parent::__construct();
         $this->load->database();
		 $this->load->model('Board_model');
		 $this->load->helper('url');
		 $this->load->library('form_validation');
		 $this->load->library('pagination');
		 $this->load->config('pagination');
		 $this->load->helper('cookie');
	}

	public function index()
	{	
		$this->_head();
        $this->_sidebar();
		$this->load->view('main');
	}

	public function contentLists($sub_category_id = NULL)
	{	
		$this->_head();
		$this->_sidebar();

		$category_name = $this->input->get('category_name');
        $sub_category_name = $this->input->get('sub_category_name');
		
		$config['suffix'] = '?'.$_SERVER['QUERY_STRING'];
		$config['base_url'] = '/Board/contentLists/'.$sub_category_id; //페이징 주소
		$config['first_url'] = $config['base_url'] . $config['suffix'];
		
		$data['cnt'] = $this->Board_model->boardLists_get($sub_category_id, 'count');
		
		$config['total_rows'] = $data['cnt'];
        $config['per_page'] = 10;
		$config['uri_segment'] = 4;

		foreach ($this->config->item('pagination') as $key => $value)
		{
			$config[$key] = $value;
		}

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
 
        $page = $this->uri->segment(4,1);
 
        if ($page > 1) {
			 $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
             $start = ($page - 1) * $config['per_page'];
        }
 
        $limit = $config['per_page'];
	    $data['list'] = $this->Board_model->boardLists_get($sub_category_id, '', $start, $limit, '');
		
		$this->load->view('contentLists', $data);
	}

	public function searchLists()
	{
		$this->_head();
		$this->_sidebar();

		$category_name = $this->input->get('category_name');
		$sub_category_name = $this->input->get('sub_category_name');
		$search = $this->input->get('search');
		
		$config['suffix'] = '?'.$_SERVER['QUERY_STRING'];
		$config['base_url'] = '/Board/searchLists';
		$config['first_url'] = $config['base_url'] . $config['suffix'];
		
		$data['cnt'] = $this->Board_model->boardLists_get('', 'count','','',$search);
		
		$config['total_rows'] = $data['cnt'];
        $config['per_page'] = 10;
		$config['uri_segment'] = 3;

		foreach ($this->config->item('pagination') as $key => $value)
		{
			$config[$key] = $value;
		}

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
 
        $page = $this->uri->segment(3,1);
 
        if ($page > 1) {
			 $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
             $start = ($page - 1) * $config['per_page'];
        }
 
        $limit = $config['per_page'];
	    $data['list'] = $this->Board_model->boardLists_get(NULL, '', $start, $limit, $search);
		
		$this->load->view('contentLists', $data);

	}

	public function passwordCheck()
	{
		$result = array();
		$result['pwchk'] = $this->Board_model->passwordCheck($this->input->post('board_id'), $this->input->post('password'));
		$sub_id_name = $this->Board_model->getName($this->input->post('sub_category_id'));
		$cate_name = $this->Board_model->getName(NULL, $sub_id_name->category_id);
		
		$result['sub_category_name'] = $sub_id_name->sub_category_name;
		$result['category_name'] = $cate_name->category_name;
		
		echo json_encode($result);
	}

	public function read($sub_category_id, $board_id)
	{
		$this->_head();
		$this->_sidebar();

		if($this->input->cookie('hits'.$board_id) == NULL){
			$this->input->set_cookie('hits'.$board_id, true, 86400);
			$true = $this->Board_model->update_hits($board_id);
		}

		$category_name = $this->input->get('category_name');
        $sub_category_name = $this->input->get('sub_category_name');
		
		$config['suffix'] = '?'.$_SERVER['QUERY_STRING'].'#focus';
		$config['base_url'] = '/Board/read/'.$sub_category_id.'/'.$board_id; //페이징 주소
		$config['first_url'] = $config['base_url'] . $config['suffix'];
		
		$replyLists['cnt'] = $this->Board_model->replyLists($board_id, 'count');
		
		$config['total_rows'] = $replyLists['cnt'];
        $config['per_page'] = 10;
		$config['uri_segment'] = 5;

		foreach ($this->config->item('pagination') as $key => $value)
		{
			$config[$key] = $value;
		}

        $this->pagination->initialize($config);
        $replyLists['pagination'] = $this->pagination->create_links();
 
        $page = $this->uri->segment(5,1);
 
        if ($page > 1) {
			 $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
             $start = ($page - 1) * $config['per_page'];
        }
 
        $limit = $config['per_page'];
	    $replyLists['list'] = $this->Board_model->replyLists($board_id, '', $start, $limit, '');

		$result  = $this->Board_model->read_get($board_id);
		$this->load->view('read', array('result' => $result));
        $this->load->view('reply' , $replyLists);
	}

	public function write()
	{
        $this->_head();
        $this->_sidebar();

		$this->form_validation->set_rules('author', '작성자', 'required');
		$this->form_validation->set_rules('password', '비밀번호', 'required');
		$this->form_validation->set_rules('email', '이메일', 'required|valid_email');
        $this->form_validation->set_rules('tel', '전화번호', 'required');
		$this->form_validation->set_rules('title', '제목', 'required');
		$this->form_validation->set_rules('secret', '비밀글', 'required');
		$this->form_validation->set_rules('description', '본문', 'required');

        if ($this->form_validation->run() == FALSE)
            {
				$this->load->view('write');
            }
        else
            {
               $board_id = $this->Board_model->write(
						   $this->input->post('author'),
						   $this->input->post('password'),
						   $this->input->post('email'),
						   $this->input->post('tel'),
						   $this->input->post('title'),
						   $this->input->post('secret'),  
						   $this->input->post('description'),
						   $this->input->post('sub_category_id')
						   );
               
               redirect('/Board/read/' .$this->input->post('sub_category_id'). '/' .$board_id.'?category_name='.$this->input->post('category_name').'&sub_category_name='.$this->input->post('sub_category_name'));
            }
	}
	
	public function update($sub_category_id = NULL, $board_id = NULL)
	{
        $this->_head();
        $this->_sidebar();

		$this->form_validation->set_rules('author', '작성자', 'required');
		$this->form_validation->set_rules('password', '비밀번호', 'required');
		$this->form_validation->set_rules('email', '이메일', 'required|valid_email');
        $this->form_validation->set_rules('tel', '전화번호', 'required');
		$this->form_validation->set_rules('title', '제목', 'required');
		$this->form_validation->set_rules('secret', '비밀글', 'required');
		$this->form_validation->set_rules('description', '본문', 'required');

        if ($this->form_validation->run() == FALSE && $board_id > 0)
        {
				$result  = $this->Board_model->read_get($board_id);
				$this->load->view('update', array('result' => $result));
        }
		else
        {
              $result = $this->Board_model->update(
							$this->input->post('board_id'),
							$this->input->post('author'),
							$this->input->post('password'),
							$this->input->post('email'),
							$this->input->post('tel'),
							$this->input->post('title'),
							$this->input->post('secret'),  
							$this->input->post('description')
						   );
               
               if($result == TRUE) redirect('/Board/read/' .$this->input->post('sub_category_id'). '/' .$this->input->post('board_id').'?category_name='.$this->input->post('category_name').'&sub_category_name='.$this->input->post('sub_category_name'));
		}
	}
	
	public function delete()
	{
		$result = $this->Board_model->delete($this->input->post('board_id'));
		if($result == TRUE) redirect('/Board/contentLists/'.$this->input->post('sub_category_id').'?category_name='.$this->input->post('category_name').'&sub_category_name='.$this->input->post('sub_category_name'));
	}
	
	public function upload()
    {
        # 파일 업로드
        $config['upload_path'] = './static/user';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = TRUE;
		
		$log_field = array();

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('file'))
        {
            $error_message = $this->upload->display_errors();
            echo json_encode(array('success' => FALSE, 'error' => strip_tags($error_message)));
        } else {
            $data = array('upload_data' => $this->upload->data());
            $save_url = '/static/user/'.$data['upload_data']['file_name'];
            echo json_encode(array('success' => TRUE, 'save_url' => $save_url));
        }
	}

	public function reply_write()
	{
		$this->form_validation->set_rules('re_author', '작성자', 'required');
		$this->form_validation->set_rules('re_description', '본문', 'required');

        if ($this->form_validation->run() == FALSE)
            {
				echo "<script>alert('댓글 입력 오류입니다.')</script>";
            }
        else
            {
               $reply_id = $this->Board_model->reply_write(
				   		   $this->input->post('board_id'),
						   $this->input->post('re_author'),
						   $this->input->post('re_description')
						   );
               
               redirect('/Board/read/' .$this->input->post('sub_category_id'). '/' .$this->input->post('board_id').'?category_name='.$this->input->post('category_name').'&sub_category_name='.$this->input->post('sub_category_name'));
            }
	}

	public function reply_update()
	{
		$this->form_validation->set_rules('re_author', '작성자', 'required');
		$this->form_validation->set_rules('re_description', '본문', 'required');

        if ($this->form_validation->run() == FALSE)
            {
				echo "<script>alert('댓글 수정 오류입니다.')</script>";
            }
        else
            {
               $reply_id = $this->Board_model->reply_update(
				   		   $this->input->post('reply_id'),
						   $this->input->post('re_author'),
						   $this->input->post('re_description')
						   );
               
               redirect('/Board/read/' .$this->input->post('sub_category_id'). '/' .$this->input->post('board_id').'?category_name='.$this->input->post('category_name').'&sub_category_name='.$this->input->post('sub_category_name'));
            }
	}

	public function reply_delete()
	{
		$result = $this->Board_model->reply_delete($this->input->post('reply_id'));
		if($result == TRUE) redirect('/Board/read/'.$this->input->post('sub_category_id'). '/' .$this->input->post('board_id').'?category_name='.$this->input->post('category_name').'&sub_category_name='.$this->input->post('sub_category_name'));
	}

	public function reply_readmore($loaded_replys)
	{
		$result['list'] = $this->Board_model->replyLists($this->input->get('board_id'),'',$loaded_replys);
		echo json_encode($result);
	}
}
