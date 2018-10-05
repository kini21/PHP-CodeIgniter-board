<?php
class MY_Controller extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
		$this->load->config('pagination');
    }
    function _admin_head(){
        $category_lists = $this->Board_model->category_lists_gets();
        $sub_category_lists = $this->Board_model->sub_category_lists_gets();
        $this->load->view('admin/head', array(
                                        'category_lists'=>$category_lists,
                                        'sub_category_lists'=>$sub_category_lists
                                    ));
    }

    function _head(){
        $this->load->view('head');
    }       
    function _sidebar(){
        $category_lists = $this->Board_model->category_lists_gets();
        $sub_category_lists = $this->Board_model->sub_category_lists_gets();
        $this->load->view('nav', array(
                                'category_lists'=>$category_lists,
                                'sub_category_lists'=>$sub_category_lists
                            ));
    }
}
?>