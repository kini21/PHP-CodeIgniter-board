<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_board extends MY_Controller {

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
		$this->load->view('/admin/login');
	}

	public function authentication()
	{
        $admin = $this->Board_model->getByAdmin($this->input->post('id'));
        if($this->input->post('id') == $admin->id && $this->input->post('password') == $admin->password) {
            
            $session_data = array(
                'is_login' => true,
                'id' => $admin->id
			);
			$this->session->set_userdata($session_data);
			redirect("/Admin_board/cateList");
        } else 
            $this->session->set_flashdata('message', '로그인에 실패 했습니다.');
            redirect("/Admin_board/index");
	}
	
	public function logout()
	{
        session_destroy();
        $this->load->view('/admin/login');
    }

	public function cateList()
	{
		$this->_admin_head();
		$category_lists = $this->Board_model->category_lists_gets();

		$result['cate_lists'] = $category_lists;
		$result['cnt'] = $this->Board_model->CateAndBoard_count($category_lists, 'cate');
		$this->load->view('admin/cateList', $result);
	}

	public function board_admin()
	{
		$this->_admin_head();
		$category_lists = $this->Board_model->category_lists_gets();
        $sub_category_lists = $this->Board_model->sub_category_lists_gets();

		$this->load->view('admin/board', array(
										'category_lists'=>$category_lists,
										'sub_category_lists'=>$sub_category_lists
									));
	}

	public function updateCategoryRank()
	{
		if($this->input->post('cb_rank') === 'c_up'){
			$up_rank = $this->Board_model->categoryRank('category', $this->input->post('cur_rank'), 'up');
			$up_result = $this->Board_model->updateCategoryRank(
								$up_rank->category_id,
								$up_rank->category_rank,
								'',
								'',
								'',
								'up'
								);
			$cur_result = $this->Board_model->updateCategoryRank(
									'',
									'',
									$this->input->post('category_id'),
									$this->input->post('cur_rank'),
									'cur',
									'cur_up'
									);
		}
		else if($this->input->post('cb_rank') === 'c_down'){
			$down_rank = $this->Board_model->categoryRank('category', $this->input->post('cur_rank'), 'down');
			$down_result = $this->Board_model->updateCategoryRank(
								$down_rank->category_id,
								$down_rank->category_rank,
								'',
								'',
								'',
								'down'
								);
			$cur_result = $this->Board_model->updateCategoryRank(
									'',
									'',
									$this->input->post('category_id'),
									$this->input->post('cur_rank'),
									'cur',
									'cur_down'
									);
		}

		redirect('/Admin_board/board_admin');
	}

	public function updateSubCategoryRank()
	{
		if($this->input->post('cb_rank') === 'up'){
			$up_rank = $this->Board_model->categoryRank('sub_category', $this->input->post('cur_rank'), 'up', $this->input->post('category_id'));
			$up_result = $this->Board_model->updateSubCategoryRank(
								$up_rank->sub_category_id,
								$up_rank->sub_category_rank,
								'',
								'',
								'',
								'up'
								);
			$cur_result = $this->Board_model->updateSubCategoryRank(
									'',
									'',
									$this->input->post('sub_category_id'),
									$this->input->post('cur_rank'),
									'cur',
									'cur_up'
									);
		}
		else if($this->input->post('cb_rank') === 'down'){
			$down_rank = $this->Board_model->categoryRank('sub_category', $this->input->post('cur_rank'), 'down', $this->input->post('category_id'));
			$down_result = $this->Board_model->updateSubCategoryRank(
								$down_rank->sub_category_id,
								$down_rank->sub_category_rank,
								'',
								'',
								'',
								'down'
								);
			$cur_result = $this->Board_model->updateSubCategoryRank(
									'',
									'',
									$this->input->post('sub_category_id'),
									$this->input->post('cur_rank'),
									'cur',
									'cur_down'
									);
		}

		redirect('/Admin_board/board_admin');
	}

	public function createCategory()
	{
		$this->form_validation->set_rules('category_name', '카테고리명', 'required');

		$result = $this->Board_model->category_lists_gets($this->input->post('category_name'));

		if ($this->form_validation->run() == FALSE){
			$this->load->view('admin/board');
        } else if ($result->category_name == $this->input->post('category_name')){
			  echo "<script>
						alert('이미 존재하는 이름입니다.'); 
						history.go(-1);
					</script>";
		} else {
			$rank_max = $this->Board_model->maxCategory();
			$category_id = $this->Board_model->createCategory(
						$this->input->post('category_name'),
						$rank_max->MAX
			 );

			 redirect('/Admin_board/board_admin');
		}
	}

	public function updateCategory()
	{
		$this->form_validation->set_rules('category_name', '카테고리명', 'required');

		$result = $this->Board_model->category_lists_gets($this->input->post('category_name'));

		if ($this->form_validation->run() == FALSE){
			$this->load->view('admin/board');
        } else if ($result->category_name == $this->input->post('category_name')){
				echo "<script>
						alert('이미 존재하는 이름입니다.'); 
						history.go(-1);
					</script>";
		} else {
			$category_id = $this->Board_model->updateCategory(
						$this->input->post('category_id'),
						$this->input->post('category_name')
			 );

			 redirect('/Admin_board/board_admin');
		}
	}

	public function createSubCategory()
	{
		$this->form_validation->set_rules('sub_category_name', '게시판명', 'required');

		$result = $this->Board_model->sub_category_lists_gets($this->input->post('category_id'), $this->input->post('sub_category_name'));

		if ($this->form_validation->run() == FALSE){
			$this->load->view('admin/board');
        } else if ($result->sub_category_name == $this->input->post('sub_category_name')){
			  echo "<script>
						alert('이미 존재하는 이름입니다.'); 
						history.go(-1);
					</script>";
		} else {
			$rank_max = $this->Board_model->maxCategory($this->input->post('category_id'));
			$sub_category_id = $this->Board_model->createSubCategory(
						$this->input->post('category_id'),
						$this->input->post('sub_category_name'),
						$rank_max->MAX
			 );

			 redirect('/Admin_board/board_admin');
		}
	}

	public function updateSubCategory()
	{
		$this->form_validation->set_rules('sub_category_name', '카테고리명', 'required');

		$result = $this->Board_model->sub_category_lists_gets($this->input->post('category_id'), $this->input->post('sub_category_name'));

		if ($this->form_validation->run() == FALSE){
			$this->load->view('admin/board');
        } else if ($result->sub_category_name == $this->input->post('sub_category_name')){
				echo "<script>
						alert('이미 존재하는 이름입니다.'); 
						history.go(-1);
					</script>";
		} else {
			$sub_category_id = $this->Board_model->updateSubCategory(
						$this->input->post('category_id'),
						$this->input->post('sub_category_name')
			 );

			 redirect('/Admin_board/board_admin');
		}
	}

	public function deleteCategory()
	{
		$cnt = $this->Board_model->subCategoryLists_get($this->input->post('category_id'));
		
		if($cnt > 0){
			echo "<script>
					alert('하위 게시판 삭제 후 카테고리 삭제가 가능합니다.');
					history.go(-1);
				  </script>";
		} else {
			$result = $this->Board_model->deleteCategory($this->input->post('category_id'));
			if($result == TRUE) redirect('/Admin_board/board_admin');
		}		
	}

	public function deleteSubCategory()
	{
		$cnt = $this->Board_model->boardLists_get($this->input->post('sub_category_id'), 'count2');
		
		if($cnt > 0){
			echo "<script>
					alert('게시글 삭제 후 게시판 삭제가 가능합니다.');
					history.go(-1);
				  </script>";
		} else {
			$result = $this->Board_model->deleteCategory('', $this->input->post('sub_category_id'));
			if($result == TRUE) redirect('/Admin_board/board_admin');
		}		
	}

	public function boardList($category_id)
	{
		$this->_admin_head();
		$sub_category_lists = $this->Board_model->sub_category_lists_gets($category_id, '', 'board');

		$result['sub_lists'] = $sub_category_lists;
		
		if($sub_category_lists == NULL){
			$result['cnt'] = '0';	
		} else {
			$result['cnt'] = $this->Board_model->CateAndBoard_count($sub_category_lists);
		}

		$this->load->view('admin/boardList', $result);
	}

	public function contentsList($sub_category_id = NULL)
	{
		$this->_admin_head();

		$config['base_url'] = '/Admin_Board/contentsList/'.$sub_category_id; //페이징 주소
		$config['first_url'] = $config['base_url'];
		
		$data['cnt'] = $this->Board_model->boardLists_get($sub_category_id, 'count');
		
		$config['total_rows'] = $data['cnt'];
        $config['per_page'] = 15;
		$config['uri_segment'] = 4;

		foreach ($this->config->item('pagination2') as $key => $value)
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

		$this->load->view('admin/contentsList', $data);
	}

	public function searchLists()
	{
		$this->_admin_head();
		$search = $this->input->get('search');
		
		$config['base_url'] = '/Admin_board/searchLists';
		$config['first_url'] = $config['base_url'];
		
		$data['cnt'] = $this->Board_model->boardLists_get('', 'count','','',$search);
		
		$config['total_rows'] = $data['cnt'];
        $config['per_page'] = 15;
		$config['uri_segment'] = 3;

		foreach ($this->config->item('pagination2') as $key => $value)
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
		
		$this->load->view('admin/contentsList', $data);
	}

	public function read($sub_category_id, $board_id)
	{
		$this->_admin_head();

		if($this->input->cookie('hits'.$board_id) == NULL){
			$this->input->set_cookie('hits'.$board_id, true, 86400);
			$true = $this->Board_model->update_hits($board_id);
		}

		$config['base_url'] = '/Admin_board/read/'.$sub_category_id.'/'.$board_id; //페이징 주소
		$config['first_url'] = $config['base_url'];
		
		$replyLists['cnt'] = $this->Board_model->replyLists($board_id, 'count');
		
		$config['total_rows'] = $replyLists['cnt'];
        $config['per_page'] = 15;
		$config['uri_segment'] = 5;

		foreach ($this->config->item('pagination2') as $key => $value)
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
		$replyLists['now'] = $result;
		$result_prev  = $this->Board_model->read_get('', $result->sub_category_id, $result->board_created, 'prev');
		$replyLists['prev'] = $result_prev;
		$result_next  = $this->Board_model->read_get('', $result->sub_category_id, $result->board_created, 'next');
		$replyLists['next'] = $result_next;

		$this->load->view('admin/read', array('result' => $result));
        $this->load->view('admin/reply' , $replyLists);
	}

	public function write()
	{
        $this->_admin_head();

		$this->form_validation->set_rules('author', '작성자', 'required');
		$this->form_validation->set_rules('password', '비밀번호', 'required');
		$this->form_validation->set_rules('email', '이메일', 'required|valid_email');
        $this->form_validation->set_rules('tel', '전화번호', 'required');
		$this->form_validation->set_rules('title', '제목', 'required');
		$this->form_validation->set_rules('secret', '비밀글', 'required');
		$this->form_validation->set_rules('description', '본문', 'required');

        if ($this->form_validation->run() == FALSE)
            {
				$this->load->view('admin/write');
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
               
               redirect('/Admin_board/read/' .$this->input->post('sub_category_id'). '/' .$board_id);
            }
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

	public function update($sub_category_id = NULL, $board_id = NULL)
	{
        $this->_admin_head();

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
				$this->load->view('admin/update', array('result' => $result));
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
               
               if($result == TRUE) redirect('/Admin_board/read/' .$this->input->post('sub_category_id'). '/' .$this->input->post('board_id'));
		}
	}

	public function delete()
	{
		$cnt = $this->Board_model->replyLists($this->input->post('board_id'), 'count2');
		
		if($cnt > 0){
			$re_result = $this->Board_model->reply_delete('', $this->input->post('board_id'));
		}
		
		$result = $this->Board_model->delete($this->input->post('board_id'));
		if($result == TRUE) redirect('/Admin_board/contentsList/'.$this->input->post('sub_category_id'));
	}

	public function deletes()
	{
		$ids = explode(",", $this->input->post('board_ids'));

		for($i = 0; $i < count($ids)-1; $i++){
			$cnt = $this->Board_model->replyLists($ids[$i], 'count2');
			if($cnt != NULL){
				$re_result = $this->Board_model->reply_delete('', $ids[$i]);
			}
			$this->Board_model->delete($ids[$i]);
		}

		if($this->input->post('sub_category_id') != NULL) {
			redirect('/Admin_board/contentsList/'.$this->input->post('sub_category_id'));
		} else {
			redirect('/Admin_board/searchLists?'.$this->input->post('query_string'));
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
               
               redirect('/Admin_board/read/' .$this->input->post('sub_category_id'). '/' .$this->input->post('board_id'));
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
               
               redirect('/Admin_board/read/' .$this->input->post('sub_category_id'). '/' .$this->input->post('board_id'));
            }
	}

	public function reply_delete()
	{
		$result = $this->Board_model->reply_delete($this->input->post('reply_id'));
		if($result == TRUE) redirect('/Admin_board/read/'.$this->input->post('sub_category_id'). '/' .$this->input->post('board_id'));
	}
}