<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width">
    <script src="https://code.jquery.com/jquery-1.11.3.js"></script> <!-- 제이쿼리 사용 -->
    <!-- 위지윅 에디터를 위함 -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
    
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>

    <link rel="shortcut icon" href="/static/admin/images/favicon.ico"> <!-- 파비콘 -->
    <link rel="stylesheet" type="text/css" media="screen" href="/static/admin/css/menu.css" />
    
    <style>
        @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css); /* 나눔고딕 사용 */
        @import url(http://weloveiconfonts.com/api/?family=entypo|fontawesome|zocial|iconicstroke); /* 웹 아이콘 폰트 사용 */
    </style>
</head>
<body>

            <?php
                if(! $this->session->userdata('is_login')){
                    echo "<script>alert('로그인 후 이용해 주세요.'); history.go(-1);</script>";
                }
            ?> 

<div class='menu'>
    <ul>
        <li>
            <a href='?'>관리자페이지</a>
        </li>
        <li>
            <!-- <a href='?page=main'>메인관리</a> -->
        </li>
        <li>
            <a href='/Admin_board/cateList'>게시판관리</a>
        </li>
                <li class='active sub'>
                    <a href='#'>게시글관리</a>
                    <ul>
                        <?php
                        foreach ($category_lists as $category_list) {
                        ?>
                        <li class="sub"><a href='/Admin_board/boardList/<?=$category_list->category_id?>'><?=$category_list->category_name?></a>
                        <ul>
                        <?php 
                            foreach ($sub_category_lists as $sub_category_list){
                                if($category_list->category_id === $sub_category_list->category_id){ 
                            ?>
                        
                            <li><a href='/Admin_board/contentsList/<?=$sub_category_list->sub_category_id?>'><?=$sub_category_list->sub_category_name?></a></li>
                        <?php
                                  }    
                                }
                                echo"</ul>";
                            echo "</li>";
                          }
                        ?>

                    </ul>
                </li>

        <li class='last' style="float: right;">
            <a href='/Admin_board/logout'>로그아웃</a>
        </li>
    </ul>
</div>