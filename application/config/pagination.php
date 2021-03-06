<?php
defined('BASEPATH') OR exit('No direct script access allowed');  	
	$config['pagination']	= [
		'full_tag_open'         => '<ul class="pagination" id="pagination_btn">',
		'full_tag_close'        => '</ul>',
		'first_tag_open'  		=> '<li class="page-item">',
		'first_link'			=> 'First',
		'first_tag_close'		=> '</li>',
		'last_tag_open'			=> '<li class="page-item">',
		'last_link'				=> 'Last',
		'last_tag_close'		=> '</li>',
		'prev_tag_open'			=> '<li class="page-item">',
		'prev_link'				=> 'Prev',
		'prev_tag_close'		=> '</li>',
		'next_tag_open'			=> '<li class="page-item">',
		'next_link'				=> 'Next',
		'next_tag_close'		=> '</li>',
		'cur_tag_open'          => '<li class="page-item" id="active"><a>',
		'cur_tag_close'         => '</a></li>',
		'num_tag_open'			=> '<li class="page-item">',
		'num_tag_close'			=> '</li>'
	];

	$config['pagination2']	= [
		'full_tag_open'         => '<span class="paging_span">',
		'full_tag_close'        => '</span>',
		'first_tag_open'  		=> '<span class="paging_span">',
		'first_link'			=> '&lt;&lt;',
		'first_tag_close'		=> '</span>',
		'last_tag_open'			=> '<span class="paging_span">',
		'last_link'				=> '&gt;&gt;',
		'last_tag_close'		=> '</span>',
		'prev_tag_open'			=> '<span class="paging_span">',
		'prev_link'				=> '&lt;',
		'prev_tag_close'		=> '</span>',
		'next_tag_open'			=> '<span class="paging_span">',
		'next_link'				=> '&gt;',
		'next_tag_close'		=> '</span>',
		'cur_tag_open'          => '<span class="paging_span now">',
		'cur_tag_close'         => '</span>',
		'num_tag_open'			=> '<span class="paging_span">',
		'num_tag_close'			=> '</span>'
	];