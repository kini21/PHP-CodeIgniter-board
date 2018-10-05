<?php
        if($this->session->flashdata('message')){
        ?>
            <script>
                alert('<?=$this->session->flashdata('message')?>')
            </script>
        <?php    
        }
        ?>
<div id="login_box">
    <form id="login_form" method="post" action="/Admin_board/authentication">
        <div id="id_box" class="in_box">
            <label class="ico fontawesome-user" for="admin_id"></label>
            <input type="text" placeholder="admin id" id="admin_id" name="id" value="admin_boardCI" autofocus>
        </div>

        <div id="pw_box" class="in_box">
            <label class="ico fontawesome-lock" for="admin_pw"></label>
            <input type="password" placeholder="admin pw" id="admin_pw" name="password" value="ICdraob_nimdaKI2921" onkeyup="if(event.keyCode == 13) login_check();">
        </div>

        <div id="btn_box" class="in_box">
            <input id="login_btn" type="text" value="LOGIN" style="width: 100%;" readonly onclick="login_check();">
        </div>
    </form>
</div>

<link rel="stylesheet" type="text/css" media="screen" href="/static/admin/css/login.css" />
<script src="https://code.jquery.com/jquery-1.11.3.js"></script> <!-- 제이쿼리 사용 -->
<script src="/static/admin/js/login.js"></script>