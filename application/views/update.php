<script>
    // 에디터
    $(document).ready(function() {
        $('#w_description').summernote({
            height : 500, // 에디터의 높이 
            lang : 'ko-KR', // 기본 메뉴언어 US->KR로 변경
            callbacks: {
                 onImageUpload: function(files, editor, welEditable) {
                    for (var i = files.length - 1; i >= 0; i--) {
                        sendFile(files[i], this);
                    }
                 }
            }
        });

         function sendFile(file, editor, welEditable) {
             var form_data = new FormData();
             form_data.append('file', file);
             $.ajax({
                 data: form_data,
                 type: "POST",
                 url: '/Board/upload',
                 cache: false,
                 contentType: false,
                 enctype: 'multipart/form-data',
                 processData: false,
                 success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj.success) {
                     var image = $('<img>').attr('src', '' + obj.save_url); // 에디터에 img 태그로 저장
                     $('#w_description').summernote("insertNode", image[0]); // summernote 에디터에 img 태그를 보여줌
                    } else {
                       alert(obj.error);
                        /*switch(parseInt(obj.error)) {
                        case 1: alert('업로드 용량 제한에 걸렸습니다.'); break;
                        case 2: alert('MAX_FILE_SIZE 보다 큰 파일은 업로드할 수 없습니다.'); break;
                        case 3: alert('파일이 일부분만 전송되었습니다.'); break;
                        case 4: alert('파일이 전송되지 않았습니다.'); break;
                        case 6: alert('임시 폴더가 없습니다.'); break;
                        case 7: alert('파일 쓰기 실패'); break;
                        case 8: alert('알수 없는 오류입니다.'); break;
                        case 100: alert('허용된 파일이 아닙니다.'); break;
                        case 101: alert('0 byte 파일은 업로드할 수 없습니다.'); break;
                        }*/
                    }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus+" "+errorThrown);
                            }        
             });
         }
    });

    function move_categoryLists(i,j) {
            if(confirm('정말로 취소하시겠습니까?')) {
                location.href = '/Board/contentLists/' + i + "?" + j;
                return true;
            } else {
                return false;
            }
    }

    // 유효성검사
    function update_submit() {
        var form = $('#contents_form');
        var author = $('#w_author');
        var password = $('#w_password');
        var email = $('#w_email');
        var tel = $('#w_tel');
        var title = $('#w_title');
        var description = $('#w_description');

        var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;

        if(author.val().trim() == '' || author.val().trim() == null) {
            alert('작성자를 입력해주세요.');
            author.focus();
            return false;
        }
        if(password.val() == '' || password.val() == null) {
            alert('비밀번호를 입력해주세요.');
            password.focus();
            return false;
        }
        if(email.val().trim() == '' || email.val().trim == null) {
            alert('이메일을 입력해주세요.');
            email.focus();
            return false;
        }
        if(regExp.test(email.val()) == false) {
            alert('잘못된 형식의 이메일 주소입니다.');
            email.focus();
            return false;
        }
        if(tel.val().trim() == '' || tel.val().trim() == null) {
            alert('전화번호를 입력해주세요.');
            tel.focus();
            return false;
        }
        if(title.val().trim() == '' || title.val().trim() == null) {
            alert('제목을 입력해주세요.');
            title.focus();
            return false;
        }
        if(description.val().trim() == '' || description.val().trim() == null) {
            alert('내용을 입력해주세요.');
            description.focus();
            return false;
        }
        
        if ($('input[name=secretCheck]').is(":checked")) {
            $('input[name=secret]').val('Y');
        } else {
            $('input[name=secret]').val('N');
        }

        form.submit();
    }

</script>
<?php 
    $explode_uri = explode("/", $_SERVER['PHP_SELF']);
    $query_string = getenv("QUERY_STRING");
    $category_name = $_GET['category_name'];
    $sub_category_name = $_GET['sub_category_name'];   
?>
<div id="main">
    <div class="subject">
        <?php echo validation_errors(); ?>
        <span class="title"><?=$category_name?></span>&nbsp;
        <span class="sub_title"><?=$sub_category_name?></span>
    </div>
    <form id="contents_form" method="post" action="/Board/update">
        <input type="hidden" name="board_id" value="<?=$result->board_id?>"/>
        <input type="hidden" name="category_name" value="<?=$category_name?>"/>
        <input type="hidden" name="sub_category_name" value="<?=$sub_category_name?>"/>
        <input type="hidden" name="sub_category_id" value="<?=$explode_uri[4]?>"/>
        <table id="contents_write">
            <tr>
                <td width="100px"><label for="w_author">작성자</label></td>
                <td width="300px" class="tl" style="padding-left: 0;"><input id="w_author" type="text" name="author" value="<?php echo set_value('author'); ?><?=$result->author?>"></td>
                <td width="100px"><label for="w_password">비밀번호</label></td>
                <td width="300px" class="tl" style="padding-left: 0;"><input id="w_password" type="password" name="password" value="<?php echo set_value('password'); ?><?=$result->password?>"></td>
            </tr>
            <tr>
                <td><label for="w_email">이메일</label></td>
                <td class="tl" style="padding-left: 0;"><input id="w_email" type="text" name="email" value="<?php echo set_value('email'); ?><?=$result->email?>"></td>
                <td><label for="w_tel">전화번호</label></td>
                <td class="tl" style="padding-left: 0;"><input id="w_tel" type="text" name="tel" value="<?php echo set_value('tel'); ?><?=$result->tel?>"></td>
            </tr>
            <tr>
                <td><label for="w_title">제목</label></td>
                <td class="tl" style="padding-left: 0;"><input id="w_title" type="text" name="title" value="<?php echo set_value('title'); ?><?=$result->title?>"></td>
                <td><label for="w_secret">비밀글</label></td>
                <input type="hidden" name="secret" value="" />
                <td class="tl"><input id="w_secret" type="checkbox" name="secretCheck" value="" <?=$result->secret == 'Y' ? 'checked="checked"' : "" ?> style="width: auto;"></td>
            </tr>
            <tr class="tl" style="padding-left: 0;">
                <td colspan="4" style="border-bottom: none;"><textarea id="w_description" name="description"><?php echo set_value('description'); ?><?=$result->description?></textarea></td>
            </tr>
            <tr>
                <td colspan="2" class="tl" style="padding-left: 0; border-bottom: none;">
                    <span class="ebtn" onclick="move_categoryLists('<?=$explode_uri[4]?>', '<?=$query_string?>');">취소</span>
            </td>
                <td colspan="2" class="tr" style="border-bottom: none;">
                    <span class="ebtn "onclick="update_submit();">등록</span>
                </td>
            </tr>
        </table>
    </form>
</div>