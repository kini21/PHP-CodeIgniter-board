<?php 
     $explode_uri = explode("/", $_SERVER['PHP_SELF']);
     $query_string = getenv("QUERY_STRING");
     $category_name = $_GET['category_name'];
     $sub_category_name = $_GET['sub_category_name'];       
?>
<script>
var board_id = "";
var reply_id = "";
var sub_category_id = "";
var sub_category_name = "";
var category_name = "";
var re_author = "";
var re_description = "";

$(document).ready(function(){
     $('#updateModal').on('show.bs.modal', function (event) {
         reply_id = $(event.relatedTarget).data('reply_id');
         re_author = $(event.relatedTarget).data('re_author');
         re_description = $(event.relatedTarget).data('re_description');
         category_name = $(event.relatedTarget).data('category_name');
         sub_category_name = $(event.relatedTarget).data('sub_category_name');
         sub_category_id = $(event.relatedTarget).data('sub_category_id');
         board_id = $(event.relatedTarget).data('board_id');
         
         $("#update_reply_id").val(reply_id);
         $("#update_author").val(re_author);
         $("#update_description").val(re_description);
         $("#update_category_name").val(category_name);
         $("#update_sub_category_name").val(sub_category_name);
         $("#update_sub_category_id").val(sub_category_id);
         $("#update_board_id").val(board_id);

         $('#update-btn').click(function(){
            $("#reply_update_form").submit();
         });
     });
});
function reply_delete(reply_id)
{
    if(confirm('정말로 삭제하시겠습니까?')) {
        $("input[name=reply_id]").val(reply_id);
        $('.reply_form').submit();
        return true;
    } else {
        return false;
    }
}

function reply_write_form_submit() {
    var author = $("input[name=re_author]").first().val();
    var description = $("textarea[name=re_description").first().val();

    if(author == '' || author == null) {
        alert('글쓴이를 입력해주세요.');
        $("input[name=re_author]").first().focus();
        return false;
    }
    if(description == '' || description == null) {
        alert('본문을 입력해주세요.');
        $("textarea[name=re_description").first().focus();
        return false;
    }
    $("#reply_write_form").submit();
}

</script>

<br><br>
<table id="comments_table">
    <tbody>

        <form id="reply_write_form" method="POST" action="/Board/reply_write">
            <input type="hidden" name="category_name" value="<?=$category_name?>"/>
            <input type="hidden" name="sub_category_name" value="<?=$sub_category_name?>"/>
            <input type="hidden" name="sub_category_id" value="<?=$explode_uri[4]?>"/>
            <input type="hidden" name="board_id" value="<?=$explode_uri[5]?>">
            <tr>
                <th class="tl">
                    <input type="text" name="re_author" value="" placeholder="글쓴이">
                </th>
            </tr>
            <tr>
                <td class="tl"><textarea name="re_description" placeholder="본문"></textarea></td>
                <td class="tr vb"><span class="ebtn" onclick=" reply_write_form_submit();">등록하기</span></td>
            </tr>
            <tr style="border-bottom: 0px solid #aaa;">
                <td colspan="2" class="tc" style="padding: 30px; padding-left:0px; border-bottom: 0px solid #aaa; text-align:left;">
                    <b>댓글</b>&nbsp;&nbsp;&nbsp; 총 <span style="color: #E83954; font-weight:bold;"><?=$cnt?></span> 개
                </td>
            </tr>
        </form>
        <div id="focus"></div>
        <?php
          foreach ($list as $li) {?>
            <div class="reply_append">
            <form class="reply_form" method="post" action="/Board/reply_delete">
                <input type="hidden" name="category_name" value="<?=$category_name?>"/>
                <input type="hidden" name="sub_category_name" value="<?=$sub_category_name?>"/>
                <input name="reply_id" type="hidden" value="">
                <input name="board_id" type="hidden" value="<?=$li->board_id?>">
                <input type="hidden" name="sub_category_id" value="<?=$explode_uri[4]?>"/>
                <tr>
                    <th><input readonly type="text" name="re_author" value="<?=$li->re_author?>" placeholder=""></th>
                    <th class="tr" width="140px"><input type="hidden" name="password" value="" placeholder=""><span><?=$li->reply_created?></span></th>
                </tr>
                <tr>
                    <td>
                        <textarea name="re_description" placeholder="본문" style="display: none;"><?=$li->re_author?></textarea>
                        <span>
                            <?=$li->re_description?>
                        </span>
                    </td>
                    <td class="tr vt">
                            <span class="ebtn nopadding" id="openUpdateModal" data-toggle="modal" data-target="#updateModal"
                            data-re_author="<?=$li->re_author?>" data-re_description="<?=$li->re_description?>" data-reply_id="<?=$li->reply_id?>"
                            data-category_name="<?=$category_name?>" data-sub_category_name="<?=$sub_category_name?>" data-sub_category_id="<?=$explode_uri[4]?>" data-board_id="<?=$li->board_id?>"> 
                            수정</span>&nbsp;
                            <span class="ebtn nopadding" onclick="reply_delete(<?=$li->reply_id?>);">삭제</span>
                            <input type="password" style="width: calc(100% - 60px); display:none;" value="" placeholder="비밀번호"/>
                            <span class="ebtn nopadding" onclick="" style="width: 60px; display:none;">확인</span>
                    </td>
                </tr>
            </form>
            </div>
          <?php
            }
          ?>
            <?php 
            if($cnt >= 16) {
                ?>
            <tr>
                    <td colspan="2" class="tc" style="padding: 10px; border-bottom: 0px solid #aaa;">
                      <?=$pagination?>
                    </td>
            </tr>
            <?php
                } else {
                ?>
                <tr>
                    <td colspan="2" class="tc" style="padding: 10px; border-bottom: 0px solid #aaa;">
                        <ul class="pagination" id="pagination_btn">
                            <li class="page-item" id="active"><a>1</a></li>
                        </ul>
                    </td>
                </tr>
            <?php
                }
            ?>

    </tbody>
</table>
<br><br><br><br>
</div>

<div class="modal fade sm" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" keyboard="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel">댓글 수정</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="reply_update_form" method="post" action="/Board/reply_update">
                                        <input id="update_category_name" type="hidden" name="category_name" value=""/>
                                        <input id="update_sub_category_name" type="hidden" name="sub_category_name" value=""/>
                                        <input id="update_reply_id" name="reply_id" type="hidden" value="">
                                        <input id="update_board_id" name="board_id" type="hidden" value="">
                                        <input id="update_sub_category_id"" type="hidden" name="sub_category_id" value=""/>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">작성자</label>
                                            <input type="text" class="form-control" id="update_author" name="re_author" value="">

                                            <label for="recipient-name" class="col-form-label">본문</label>
                                            <textarea class="form-control" id="update_description" name="re_description"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="update-btn">수정 완료</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                    </div>