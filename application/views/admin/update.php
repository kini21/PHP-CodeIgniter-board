<script>
    // 에디터
    $(document).ready(function() {
        $('#summernote').summernote({
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
                 url: '/Admin_board/upload',
                 cache: false,
                 contentType: false,
                 enctype: 'multipart/form-data',
                 processData: false,
                 success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj.success) {
                     var image = $('<img>').attr('src', '' + obj.save_url); // 에디터에 img 태그로 저장
                     $('#summernote').summernote("insertNode", image[0]); // summernote 에디터에 img 태그를 보여줌
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

    function move_categoryLists(i) {
            if(confirm('정말로 취소하시겠습니까?')) {
                location.href = '/Admin_board/contentsList/' + i;
                return true;
            } else {
                return false;
            }
    }

    // 유효성검사
    function write_submit() {
        var form = $('#contents_form');
        var author = $('input[name=author]');
        var password = $('input[name=password]');
        var email = $('input[name=email]');
        var tel = $('input[name=tel]');
        var title = $('input[name=title]');
        var description = $('#summernote');

        var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;

        if(author.val().trim() == '' || author.val().trim() == null) {
            alert('글쓴이를 입력해주세요.');
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
?>
<?php echo validation_errors(); ?>
<form id="contents_form" action="/Admin_board/update" method="post">
    <input type="hidden" name="board_id" value="<?=$result->board_id?>"/>
    <input type="hidden" name="sub_category_id" value="<?=$explode_uri[4]?>"/>
    <table class="write_table" style="margin-top: 10px;">
        <tr>
            <td width="80px">글쓴이</td>
            <td><input type="text" value="<?php echo set_value('author'); ?><?=$result->author?>" placeholder="이름을 입력해주세요" name="author" class="write_input"></td>
        </tr>
        <tr>
            <td>이메일</td>
            <td><input type="text" value="<?php echo set_value('email'); ?><?=$result->email?>" placeholder="이메일을 입력해주세요" name="email" class="write_input"></td>
        </tr>
        <tr>
            <td>전화번호</td>
            <td><input type="text" value="<?php echo set_value('tel'); ?><?=$result->tel?>" placeholder="전화번호를 입력해주세요" name="tel" class="write_input"></td>
        </tr>
        <tr>
            <td>비밀번호</td>
            <td><input type="password" value="<?php echo set_value('password'); ?><?=$result->password?>" placeholder="비밀번호를 입력해주세요" name="password" class="write_input"></td>
        </tr>
        <tr>
            <td>비밀글</td>
            <input type="hidden" name="secret" value="" />
            <td><input type="checkbox" value="" <?=$result->secret == 'Y' ? 'checked="checked"' : "" ?> name="secretCheck"></td>
        </tr>
        <tr>
            <td>제목</td>
            <td><input type="text" value="<?php echo set_value('title'); ?><?=$result->title?>" placeholder="제목을 입력해주세요" name="title" class="write_input"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: none;">
                <textarea id="summernote" name="description"><?php echo set_value('description'); ?><?=$result->description?></textarea>
                <script>
                    var postForm = function() {
                        var contents =  $('textarea[name="description"]').html($('#summernote').code());
                        var scroll = 0;
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tc">
                <span class="w_btn" onclick="write_submit();">등록</span>
                <span class="w_btn" onclick="move_categoryLists('<?=$explode_uri[4]?>');">취소</span>
            </td>
        </tr>
    </table>
</form>

<link href="/static/admin/css/contents.css" rel="stylesheet">