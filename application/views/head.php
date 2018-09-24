<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>KPOP AGENCY On THE MUSIC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-1.11.3.js"></script> <!-- 제이쿼리 사용 -->

    <!-- 위지윅 에디터를 위함 -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
    
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>

    <link rel="shortcut icon" href="/static/images/favicon.ico"> <!-- 파비콘 -->

    <script>
        var menu = false;

        $(document).ready(function() {
            $("#menuBg").hide();
        })

        function menuBtn() {
            menu = !menu;
            if(menu) {
                // 활성화
                $("nav").stop().animate({
                    left: 0
                });
                $("#menuBg").fadeIn();
            } else {
                // 비활성화
                $("nav").stop().animate({
                    left: -250
                });
                $("#menuBg").fadeOut();
            }
        }
    </script>

    <style>
        /* 기본사항 */
        @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css); 
         @import url(http://weloveiconfonts.com/api/?family=entypo|fontawesome|zocial|iconicstroke);
         @import url(http://api.mobilis.co.kr/webfonts/css/?fontface=NanumGothicWeb); 
        /* 웹 아이콘 폰트 사용 */

        @font-face {
            font-family: 'Goyang';
            src: url('/font/Goyang.off')
        }

        @font-face {
            font-family: 'Goyang';
            src: url('/font/Goyang.ttf')
        }

        * {
            font-family: 'Goyang', sans-serif,  !important;
        }

        html, body {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            /* font-family: 'Goyang', 'Nanum Gothic'; */
            font-family: 'Nanum Gothic';
        }

        /* 헤더 */
        header {
            width: 100%;
            height: 50px;
            border-bottom: 1px solid #c9c9c9;
            background-color: #fff;
            box-shadow: 1px 0px 15px #7f7f7f;
            position: absolute;
            z-index: 4;
        }

        header .ebtn {
            font-size: 12pt;
            font-weight: bold;
            line-height: 50px;
            cursor: pointer;
            color: #000;
            transition: 0.3s;
            padding: 7px;
            margin-left: 270px;
        }

        header .ebtn:hover {
            color: #E83954;
        }

        header .ico {
            width: 28px;
            height: 49px;
            background: none;
            border: none;
            padding: 10px;
            margin: 0;
            font-family: 'entypo', 'fontawesome', 'zocial', 'iconicstroke', sans-serif;
            font-size: 16pt;
            text-align: center;
            cursor: pointer;
            position: absolute;
            top: 0;
            right: 10px;

            transition: 0.3s;
        }

        header .ico:hover {
            color: #E83954;
        }

        header #menuBtn {
            display: none;
        }

        header #menuBg {
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 5;
        }

        /* 왼쪽 메뉴 */
        nav {
            width: 250px;
            height: 100%;
            background-color: #fff;
            box-shadow: 1px 0px 15px #7f7f7f;
            position: fixed;
            top: 0;
            left: 0;
            padding: 10px;
            overflow: auto;
            z-index: 6;
        }

        nav #logo {
            width: 100%;
            border-bottom: 1px solid #e08596;
            margin-bottom: 10px;
            cursor: pointer;
        }

        nav .title {
            width: calc(100% - 20px);
            display: block;
            font-size: 16pt;
            font-weight: bold;
            color: #E83954;
            margin-bottom: 5px;
            padding: 10px 10px 0 10px;
            cursor: pointer;
        }

        nav ul {
            font-size: 11pt;
            line-height: 22pt;
            margin: 0;
            cursor: pointer;
        }

        nav li {
            transition: 0.2s;
        }

        nav li:hover, nav .select {
            color: #E83954;
        }

        /* 초기화면 */
        /* 배너 */
        #banner {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            float: left;
            margin-bottom: 10px;
        }

        /* 회사소개 */
        #info {
            width: calc(100% - 250px);
            height: calc(100% - 50px);
            left: 250px;
            top: 50px;
            position: absolute;
            overflow: auto;
        }

        #info img {
            max-width: 100%;
        }

        /* 이미지 슬라이드 */
        #si {
            width: 100%;
            height: 100%;
            
        }

        #si_1, #si_2 {
            width: 100%;
            height: 600px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: absolute;
            top:210px;
        }

        #slide_img {
            display: none;
        }


        /* 메인 */
        #main {
            width: calc(100% - 250px);
            height: calc(100% - 50px);
            left: 250px;
            top: 50px;
            position: absolute;
            overflow: auto;
        }

        #main .subject {
            width: 100%;
            padding: 20px 30px 5px 30px;
        }

        #main .title {
            font-size: 20pt;
            font-weight: bold;
            color: #000;
        }

        #main .sub_title {
            font-size: 12pt;
            color: #000;
        }

        #contents {
            width: 800px;
            margin: 0 auto;
            padding: 0;
            color: #7f7f7f;
        }

        #contents th {
            border-bottom: 2px solid #E83954;
            font-weight: normal;
        }

        #contents th, #contents td {
            margin: 0;
            padding: 5px 0;
            text-align: center;
        }

        #contents tr {
            transition: 0.2s;
        }

        #contents tr:hover {
            background-color: #FFEFEFEF;
        }
        
        #contents td {
            cursor: pointer;
        }

        #contents .tl {
            text-align: left;
            padding-left: 10px;
        }

        #contents .ico {
            width: 28px;
            height: 100%;
            background: none;
            border: none;
            padding: 5px;
            margin: 0;
            font-family: 'entypo', 'fontawesome', 'zocial', 'iconicstroke', sans-serif;
            font-size: 16pt;
            text-align: center;
            display: inline-block;
            cursor: pointer;
        }

        #paging {
            width: 800px;
            margin: 0 auto;
            color: #7f7f7f;
            text-align: center;
        }

        #paging .paging_span {
            cursor: pointer;
            padding: 5px 5px;
            margin: 5px 0;
            transition: 0.2s;
        }

        #paging .paging_span:hover, #paging .select {
            color: #E83954;
        }

        #pagination_btn > li > a{
            color: #E83954;
            font-size: 16px;
        }

        #active{
            font-weight: bolder;
        }
        
        #write_btn {
            border:1px solid #d11835; -webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px;font-size:14px;font-family:arial, helvetica, sans-serif; padding: 7px 7px 7px 7px; text-decoration:none; display:inline-block;text-shadow: -1px -1px 0 rgba(0,0,0,0.3);font-weight:bold; color: #FFFFFF;
            background-color: #E83954; background-image: -webkit-gradient(linear, left top, left bottom, from(#E83954), to(#E83954));
            background-image: -webkit-linear-gradient(top, #E83954, #E83954);
            background-image: -moz-linear-gradient(top, #E83954, #E83954);
            background-image: -ms-linear-gradient(top, #E83954, #E83954);
            background-image: -o-linear-gradient(top, #E83954, #E83954);
            background-image: linear-gradient(to bottom, #E83954, #E83954);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#E83954, endColorstr=#E83954);
        }

        #write_btn:hover {
            border:1px solid #a8132a;
            background-color: #d51936; background-image: -webkit-gradient(linear, left top, left bottom, from(#d51936), to(#d51936));
            background-image: -webkit-linear-gradient(top, #d51936, #d51936);
            background-image: -moz-linear-gradient(top, #d51936, #d51936);
            background-image: -ms-linear-gradient(top, #d51936, #d51936);
            background-image: -o-linear-gradient(top, #d51936, #d51936);
            background-image: linear-gradient(to bottom, #d51936, #d51936);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#d51936, endColorstr=#d51936);
        }

        #contents_read {
            width: 800px;
            margin: 0 auto;
            padding: 0;
            color: #7f7f7f;
        }

        #contents_read td {
            border-bottom: 1px solid #afafaf;
            padding: 5px 0;
        }

        #contents_read .ebtn {
            border-radius: 5px;
            background-color: #E83954;
            color: #FFF;
            padding: 7px;
            cursor: pointer;
            transition: 0.3s;
        }

        #contents_read .ebtn:hover {
            background-color: #c45a6b;
        }

        #contents_read .tr {
            text-align: right;
        }

        #contents_write {
            width: 800px;
            margin: 0 auto;
            padding: 0;
            color: #7f7f7f;
        }

        #contents_write td {
            border-bottom: 1px solid #afafaf;
            padding: 5px 0;
        }

        #contents_write .ebtn {
            border-radius: 5px;
            background-color: #E83954;
            color: #FFF;
            padding: 7px;
            cursor: pointer;
            transition: 0.3s;
        }

        #contents_write .ebtn:hover {
            background-color: #c45a6b;
        }

        #contents_write .tr {
            text-align: right;
        }

        #contents_write input {
            border: none;
            width: 100%;
        }

        #contents_write input:focus {
            outline: none;
        }

        #comments_table {
            width: 800px;
            margin: 0 auto;
            padding: 0;
            color: #7f7f7f;
            font-size: 10pt;
        }

        #comments_table input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ddd;
            background-color: #FFF;
        }

        #comments_table input:read-only {
            width: 100%;
            border: none;
            border-bottom: 1px solid #FFF;
            background-color: #FFF;
        }

        #comments_table textarea {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ddd;
            background-color: #FFF;
            resize: none;
        }

        #comments_table input:focus, #comments_table textarea {
            outline: none;
        }

        #comments_table .tr {
            text-align: right;
        }

        #comments_table .tc {
            text-align: center;
        }
        
        .readmore {
            width: 28px;
            height: 49px;
            background: none;
            border: none;
            padding: 10px;
            margin: 0;
            font-family: 'entypo', sans-serif;
            font-size: 30pt;
            text-align: center;
            cursor: pointer; 
            top: 0;
            right: 10px;

            transition: 0.3s;
        }

        .readmore:hover {
            color: #E83954;
        }

        #comments_table .paging_span {
            cursor: pointer;
            padding: 5px 5px;
            margin: 5px 0;
            transition: 0.2s;
        }

        #comments_table .select {
            color: #E83954;
        }

        #comments_table .vb {
            vertical-align: bottom;
        }

        #comments_table .vt {
            vertical-align: top;
        }

        #comments_table th {
            padding: 7px 0;
        }

        #comments_table td {
            padding-bottom: 7px;
            border-bottom: 1px solid #aaa;
        }

        #comments_table .ebtn {
            cursor: pointer;
            transition: 0.3s;
            color: #E83954;
            padding: 7px;
        }

        #comments_table .nopadding {
            padding: 0;
        }

        .d6 {
            background: white;
            position: absolute;
            right: 30px;
            top: 0;
            z-index: 1;
        }

        .d6 form {
            height: 30px;
        }

        .d6 input {
            height: 100%;
            width: 0;
            padding: 0 42px 0 15px;
            border: none;
            border-bottom: 2px solid transparent;
            outline: none;
            background: transparent;
            transition: .4s cubic-bezier(0, 0.8, 0, 1);
            position: absolute;
            top: 10px;
            right: 5px;
            z-index: 2;
            font-size: 15px
        }

        .d6 input:focus {
            /*돋보기 클릭시 밑에 바 생기는거*/
            width: 300px;
            z-index: 1;
            border-bottom: 2px solid black;
        }

        .d6 button {
            background-color: transparent;
            border: none;
            height: 40px;
            width: 40px;
            position: absolute;
            top: 3px;
            right: 0;
            cursor: pointer;
        }

        .d6 button:before {
            content: "\f002";
            font-family: FontAwesome;
            font-size: 16px;
            color: black;
        }
        
        @media(max-width: 1060px) {
            /* width 1060px 이하일 때 */
            nav {
                left: -250px;
            }

            header #infoBtn {
                display: none;
            }

            header #menuBtn {
                display: inline;
                margin-left: 10px;
            }

            #main {
                width: 100%;
                left: 0;
            }
        }

        @media(max-width: 862px) {
            /* width 862px 이하 */
            #contents, #paging, #btn, #contents_read, #contents_write, #comments_table {
                width: calc(100% - 40px);
                margin: 0 auto;
            }
        }

    </style>
</head>
<body>
    
<header>
    <span id="menuBtn" class="ebtn" onclick="menuBtn();"><span class="ico entypo-menu" style="position: static;"></span></span>
    <div id="menuBg" onclick="menuBtn();"></div>
    <span id="infoBtn" class="ebtn" onclick="location.href='?intro=1';">회사소개</span>
    <div class="d6">
        <form id="search_form" action="/Board/searchLists" method="GET">
            <input type="hidden" name="category_name" value="검색결과">
            <input type="hidden" name="sub_category_name" value="제목+본문">
            <input type="text" name="search" placeholder="검색어 입력(제목+본문)" value="" >
            <button type="submit" style="cursor:pointer"></button>
        </form>
    </div>
    <span class="ico entypo-user" onclick="location.href='./admin'"></span>
</header>