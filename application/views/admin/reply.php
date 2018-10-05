<?php 
     $explode_uri = explode("/", $_SERVER['PHP_SELF']);    
?>
<table class="comments_table">
    <tbody>

            <tr>
                <th class="tl" style="padding: 15"><input readonly type="text" id="c_name_" name="re_author" value="댓글 총 <?=$cnt?> 개" placeholder="이름"></th>
            </tr>
        <?php
          foreach ($list as $li) {?>
            <form id="com_<?=$li->reply_id?>" method="post" action="">
                <input id="c_idx_" name="reply_id" type="hidden" value="<?=$li->reply_id?>">
                <input type="hidden" name="sub_category_id" value="<?=$explode_uri[4]?>"/>
                <input type="hidden" name="board_id" value="<?=$explode_uri[5]?>">
                
                <tr>
                    <th class="tl"><input readonly type="text" id="c_name_<?=$li->reply_id?>" name="re_author" value="<?=$li->re_author?>" placeholder="이름"></th>
                    <th class="tr" width="140px"><span id="created_<?=$li->reply_id?>"><?=$li->reply_created?></span></th>
                </tr>
                <tr>
                    <td class="tl">
                        <textarea id="c_content2_<?=$li->reply_id?>" name="re_description" placeholder="내용" style="display: none;"><?=$li->re_description?></textarea>
                        <span id="c_content_<?=$li->reply_id?>">
                            <?=$li->re_description?>
                        </span>
                    </td>
                    <td id="c_btn_<?=$li->reply_id?>" class="tr at">
                        <span onclick="edit('<?=$li->reply_id?>', 'edit');" style="cursor:pointer">수정</span>&nbsp;
                        <span onclick="reply_delete('<?=$li->reply_id?>');" style="cursor:pointer">삭제</span>
                    </td>
                    <td id="c_btn2_<?=$li->reply_id?>" class="tr at" style="display: none;">
                        <span onclick="save('<?=$li->reply_id?>', 'edit')"; style="cursor:pointer">저장</span>&nbsp;
                        <span onclick="editCancel();" style="cursor:pointer">취소</span>
                    </td>
                </tr>
            </form>
            <?php
            }
          ?>

                <tr>
                    <td colspan="2" class="tc" style="padding: 10px;">
                    <?php 
                    if($cnt >= 16) {?>   
                        <?=$pagination?>
                    <?php } else {?>
                        <span class="paging_span now">1</span>
                    <?php }?>
                    </td>
                </tr>  

        <form id="comments_form" method="POST" action="/Admin_board/reply_write">
            <input type="hidden" name="sub_category_id" value="<?=$explode_uri[4]?>"/>
            <input type="hidden" name="board_id" value="<?=$explode_uri[5]?>">
            <tr>
                <th class="tl">
                    <input type="text" name="re_author" value="" placeholder="글쓴이">
                </th>
                <th class="tr" width="140px" style="border-bottom:0px;">
                    
                </th>
            </tr>
            <tr>
                <td class="tl"><textarea name="re_description" placeholder="내용"></textarea></td>
                <td class="tr ab"><span class="btn" onclick="comments_form_submit();">등록하기</span></td>
            </tr>
        </form>

    </tbody>
</table>

<table class="board_table">
    <thead>
        <th width="80px" style="max-width: 80px;">번호</th>
        <th class="tl">게시글 제목 (▲▼ 이전 글, 다음 글)</th>
        <th width="100px" style="max-width: 100px;">글쓴이</th>
        <th width="100px" style="max-width: 100px;">작성일</th>
        <th width="60px" style="max-width: 60px;">조회 수</th>
    </thead>

    <tbody>
                        
        <?php if($prev != NULL){ ?>          
                <tr onclick="#">
                    <td><?=$prev->board_id?></td>    
                    <td class="tl" onclick="location.href = '/Admin_board/read/<?=$prev->sub_category_id?>/<?=$prev->board_id?>'"><?=$prev->title?></td>
                    <td><?=$prev->author?></td>
                    <td><?=$prev->board_created?></td>
                    <td><?=$prev->hits?></td>
                </tr>
        <?php } ?>
               
        <tr onclick="#" style="background-color:#f9f9f9; color:#009;">
            <td style="color:#009;">»</td>
            <td class="tl" style="color:#009;"><?=$now->title?></td>
            <td style="color:#009;"><?=$now->author?></td>
            <td style="color:#009;"><?=$now->board_created?></td>
            <td style="color:#009;"><?=$now->hits?></td>
        </tr>

            <?php if($next != NULL){ ?>  
                <tr onclick="#">
                    <td><?=$next->board_id?></td>
                    <td class="tl" onclick="location.href = '/Admin_board/read/<?=$next->sub_category_id?>/<?=$next->board_id?>'"><?=$next->title?></td>
                    <td><?=$next->author?></td>
                    <td><?=$next->board_created?></td>
                    <td><?=$next->hits?></td>
                </tr>
            <?php } ?>
     
    </tbody>
</table>

<div id="pach">
    <span id="list_btn" class="footer_btn" style="float: left;" onclick="location.href='/Admin_board/contentsList/<?=$explode_uri[4]?>'">목록보기</span>
    <form id="search_form" action="/Admin_board/searchLists" method="get">
        <input id="searchTxt" name="search" type="text" placeholder="검색어 입력" value=""><input id="searchBtn" type="submit" value="검색">
        <span id="write_btn" class="footer_btn" onclick="location.href='/Admin_board/write/'+ <?=$explode_uri[4]?>">글쓰기</span>
    </form>    
</div>

<link href="/static/admin/css/contents.css" rel="stylesheet">
<script>
    var name = '';
    var content = '';
    var idx = '';
    var create = '';

    function reply_delete(reply_id)
    {
        if(confirm('정말로 삭제하시겠습니까?')) {
            $('#com_' + reply_id).attr("action", "/Admin_board/reply_delete");
            $('#com_' + reply_id).submit();
            return true;
        } else {
            return false;
        }
    }

    function edit(i, j) {
        if(idx != '') {
            editCancel();
        }
        name = $('#c_name_' + i).val();
        content = $('#c_content_' + i).val();
        create = $('#created_' + i).text();
        idx = i;

        $('#c_btn_' + i).css('display', 'none');
        if(j=='edit') {
            $('#c_name_' + i).attr("readonly", false);
            $('#c_content_' + idx).css('display', 'none');
            $('#c_content2_' + idx).css('display', '');
            $('#c_btn2_' + i).css('display', '');
        } else {
            $('#c_btn3_' + i).css('display', '');
        }

        // 메인 페이지에서 주석 제거
        // $('#c_pw_' + i).attr('type', 'password');
        // $('#created_' + i).css('display', 'none');
    }

    function editCancel() {
        $('#c_name_' + idx).val(name);
        $('#c_name_' + idx).attr("readonly", true);

        $('#c_content_' + idx).css('display', '');
        $('#c_content2_' + idx).val(content);
        $('#c_content2_' + idx).css('display', 'none');


        // 메인 페이지에서 주석 제거
        // $('#c_pw_' + idx).val('');
        // $('#c_pw_' + idx).attr('type', 'hidden');

        // $('#created_' + idx).text(create);
        // $('#created_' + idx).css('display', '');

        $('#c_btn_' + idx).css('display', '');
        $('#c_btn2_' + idx).css('display', 'none');
        $('#c_btn3_' + idx).css('display', 'none');
    }

    function save(i, j) {
        var name = $('#c_name_' + i).val();
        var content = $('#c_content2_' + i).val();

        if(name.trim() == '' || name.trim() == null) {
            alert('이름을 입력해주세요.');
            $('#c_name_' + i).focus();
            return false;
        }
        if(content.trim() == '' || content.trim() == null) {
            alert('내용을 입력해주세요.');
            $('#c_content2_' + i).focus();
            return false;
        }
        
        $('#com_' + i).attr("action", "/Admin_board/reply_update");
        $('#com_' + i).submit();
    }

    function comments_form_submit() {
        var author = $("input[name=re_author]").last().val().trim();
        var description = $("textarea[name=re_description]").last().val().trim();

        if(author == '' || author == null) {
            alert('이름을 입력해주세요.');
            $("input[name=re_author]").last().focus();
            return false;
        }
        if(description == '' || description == null) {
            alert('내용을 입력해주세요.');
            $("textarea[name=re_description").last().focus();
            return false;
        }

        $("#comments_form").submit();
    }

</script>