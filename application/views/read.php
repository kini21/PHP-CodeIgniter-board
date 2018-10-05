<script>
function move_page(i,j,flag) 
{
    if(flag == '1') {
        location.href = '/Board/contentLists/' + i + "?" + j;
    } else {
        location.href = '/Board/update/' + i + '/' + j + '?category_name=<?=$_GET['category_name'] ?>&sub_category_name=<?=$_GET['sub_category_name']?>';
    }
}

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
    $query_string = getenv("QUERY_STRING");
    $category_name = $_GET['category_name'];
    $sub_category_name = $_GET['sub_category_name'];       
?>
<form id="secret_form" method="post"></form>

<div id="main">
    <div class="subject">
        <span class="title"><?=$_GET['category_name']?></span>&nbsp;
        <span class="sub_title"><?=$_GET['sub_category_name']?></span>
    </div>
  <form id="contents_form" method="post" action="/Board/delete">
    <input type="hidden" name="board_id" value="<?=$result->board_id?>"/>
    <input type="hidden" name="category_name" value="<?=$category_name?>"/>
    <input type="hidden" name="sub_category_name" value="<?=$sub_category_name?>"/>
    <input type="hidden" name="sub_category_id" value="<?=$explode_uri[4]?>"/>
    <table id="contents_read">
        <tr>
            <td width="100px">작성자</td>
            <td width="300px" class="tl" style="padding-left: 0;"><?=$result->author?></td>
            <td width="100px">작성일</td>
            <td width="300px" class="tl" style="padding-left: 0;"><?=$result->board_created?></td>
        </tr>
        <tr>
            <td>이메일</td>
            <td class="tl" style="padding-left: 0;"><?=$result->email?></td>
            <td>전화번호</td>
            <td class="tl" style="padding-left: 0;"><?=$result->tel?></td>
        </tr>
        <tr>
            <td>제목</td>
            <td  class="tl" style="padding-left: 0;"><?=$result->title?></td>
            <td>조회 수</td>
            <td  class="tl" style="padding-left: 0;"><?=$result->hits?></td>
        </tr>
        <tr class="tl" style="padding-left: 0;">
            <td colspan="4" style="border-bottom: none;"><?=$result->description?></td>
        </tr>
        <tr>
            <td colspan="2" class="tl" style="padding-left: 0; border-bottom: none;">
                <span class="ebtn" onclick="move_page('<?=$explode_uri[4]?>', '<?=$result->board_id?>');">수정</span>&nbsp;
                <span class="ebtn" id="delete_btn" onclick="delete_article();">삭제</span>
                <input type="password" id="m_pass_" style="display:none" value="" placeholder="비밀번호를 입력해주세요"/>
                <input type="button" id="m_mit_" onclick="" style="display:none" value="확인" />
        </td>
            <td colspan="2" class="tr" style="border-bottom: none;">
                <span class="ebtn" onclick="move_page('<?=$explode_uri[4]?>', '<?=$query_string?>', '1');">목록</span>&nbsp;
            </td>
        </tr>
    </table>
   </form>
