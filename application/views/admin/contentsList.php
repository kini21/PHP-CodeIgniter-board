<script>
 var aCheck = false;

$(document).ready(function(){
    var chk = $("input[name=contentsCheck]");
        chk.each(function() {
            $(this).prop("checked", false);
        });
});
    function allCheck() {
        if(!aCheck) {
            // 전체 선택
            aCheck = true;
        } else {
            // 전체 해제
            aCheck = false;
        }
        var chk = $("input[name=contentsCheck]");
        chk.each(function() {
            $(this).prop("checked", aCheck);
        });
    }

    function chkDel() {
        var choose = confirm('삭제하시겠습니까?');
        if(choose) {
            var chk = $("input[name=contentsCheck]");
            var idxs = "";
            var tmp = false;
            var iTmp = 0;
            chk.each(function() {
                tmp = $(this).prop("checked");
                if(tmp) {
                    idxs += $(this).val() + ",";
                    iTmp++;
                }
            })
            if(iTmp > 0) {
                $("#delIdxs").val(idxs);
                $('#delete_form').submit();
            } else {
                alert('삭제할 게시글을 선택해주세요.');
                return false;
            }
        }
    }

    function move_page(i, j) 
    {
        location.href = '/Admin_board/read/' + i + '/' + j;
    }
</script>
<table class="board_table">
    <thead>
        <th width="60px" style="max-width: 60px; cursor: pointer;" onclick="allCheck();">선택</th>
        <th width="80px" style="max-width: 80px;">번호</th>
        <th class="tl">게시글 제목</th>
        <th width="100px" style="max-width: 100px;">작성자</th>
        <th width="100px" style="max-width: 100px;">작성일</th>
        <th width="60px" style="max-width: 60px;">조회수</th>
    </thead>

    <tbody>
            <?php
             if($cnt != 0) {          
                foreach($list as $li) {    
                    $today = date("Y-m-d");
                    $write_date = $li->board_created;
                    if (date("Y-m-d",$write_date) == $today) {
                                // 오늘 날짜이기 때문에 시간 표시
                        $created = date("H:i:s",$write_date);
                    } else {
                                // 날짜 표시
                        $created = date("Y-m-d",$write_date);
                    }
            ?>
            <tr>
                    <td><input type="checkbox" name="contentsCheck" value="<?=$li->board_id?>"></td>
                    <td><?=$li->board_id?></td>
                    <td class="tl" data-param="<?=$li->board_id?>" onclick="move_page('<?=$li->sub_category_id?>', '<?=$li->board_id?>');"> 
                        <?php
                            if($li->secret == 'Y') { ?>
                                <label class='ico entypo-lock' style='padding: 0; font-size: 10pt;'></label>
                            <?php
                            } else {
                            ?>
                                <?=strlen($li->title) >=60 ? substr($li->title,0 ,60)."..." : $li->title?> 
                            <?php } ?>
                        </td>
                        <td><?=$li->author?></td>
                        <td><?=$created?></td>
                        <td><?=$li->hits?></td>
                    </tr>
                <?php
                    }
                  } else {
                    ?>
                    <tr><td colspan="5">게시글이 없습니다.</td></tr>  
                <?php 
                   }  
                ?>
                    
    </tbody>
</table>
<div id="pach">
    <div id="paging">
        <?=$pagination ?>   
    </div>
    
    <?php 
        $explode_uri = explode("/", $_SERVER['PHP_SELF']);
        $query_string = getenv("QUERY_STRING"); 
    ?>
    <form id="search_form" action="/Admin_board/searchLists" method="get">
        <input id="searchTxt" name="search" type="text" placeholder="검색어 입력" value=""><input id="searchBtn" type="submit" value="검색">
        <?php
            if($explode_uri[3] != 'searchLists'){ ?> 
        <span id="write_btn" class="footer_btn" onclick="location.href='/Admin_board/write/'+ <?=$explode_uri[4]?>">글쓰기</span>
        <?php } else {} ?>
        <span id="delete_btn" class="footer_btn" onclick="chkDel();" style="margin-right: 5px;">삭제</span>
    </form>
    <form id="delete_form" action="/Admin_board/deletes" method="post">
        <input id="delIdxs" type="hidden" name="board_ids" value="">
        <?php
            if($explode_uri[3] != 'searchLists'){ ?> 
            <input id="subCate_id" type="hidden" name="sub_category_id" value="<?=$explode_uri[4]?>">
        <?php } else { ?>
            <input id="queryString_id" type="hidden" name="query_string" value="<?=$query_string?>">
        <?php } ?> 
    </form>
</div>

<link href="/static/admin/css/contents.css" rel="stylesheet">