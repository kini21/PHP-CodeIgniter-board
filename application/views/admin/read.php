<link href="/static/admin/css/contents.css" rel="stylesheet">
<script>
function delete_article()
{
    if(confirm('정말로 삭제하시겠습니까?')) {
        $('#contents_form').submit();
        return true;
    } else {
        return false;
    }
}
</script>
<?php 
    $explode_uri = explode("/", $_SERVER['PHP_SELF']);     
?>
<form id="contents_form" method="post" action="/Admin_board/delete">
<input type="hidden" name="board_id" value="<?=$result->board_id?>"/>
<input type="hidden" name="sub_category_id" value="<?=$result->sub_category_id?>"/>
<table class="write_table">
    <tr>
        <td width="80px" class="tbold">글쓴이</td>
        <td><?=$result->author?></td>
        <td width="80px" class="tbold">작성일</td>
        <td><?=$result->board_created?></td>
    </tr>
    <tr>
        <td width="80px" class="tbold">이메일</td>
        <td><?=$result->email?></td>
        <td width="80px" class="tbold">전화번호</td>
        <td><?=$result->tel?></td>
    </tr>
    <tr>
        <td class="tbold">제목</td>
        <td class="tl"><?=$result->title?></td>
        <td class="tbold">조회수</td>
        <td class="tl"><?=$result->hits?></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom: none;">
            <div style="display: block;"><?=$result->description?></div>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <span style="margin-left: 10px;" class="footer_btn" onclick="delete_article();">삭제</span>
            <span style="margin-left: 10px;" class="footer_btn" onclick="location.href='/Admin_board/update/<?=$explode_uri[4]?>/<?=$result->board_id?>'">수정</span>
        </td>
    </tr>
</table>
</form>