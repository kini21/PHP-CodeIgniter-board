<script>
    var type, cate, b_idx, b_name, c_idx, c_name, cb_view, cb_rank, cur_rank;
</script>

<form id="cb_form" method="post" action="" style="display: none;">
    
</form>

<div id="board_bg" onclick="view_btn('cancel');"></div>
<div id="board_popup">
    <div id="board_popup_x"><span class="ico entypo-cancel-circled" style="color: #009;" onclick="view_btn('close');"></span></div>
    <span id="board_popup_title" class="popup">일본어 자유게시판 수정</span>
    <div id="popup_in" method="post" action="?page=board_ok">
        <label id="lan_title" class="sub_title">1차 카테고리</label>
        <select id="board_popup_cate" class="popup">
            <?php
               foreach ($category_lists as $category_list) { 
            ?>
                <option value="<?=$category_list->category_id; ?>"><?=$category_list->category_name; ?></option>
            <?php
                    }
            ?>
        </select>
        <label id="total_name" class="sub_title">게시판 이름</label>
        <input id="board_popup_name" class="popup" type="text" placeholder="게시판 이름">
        <div class="popup" id="board_popup_view">
            <label class="sub_title">사용 여부</label>
            <input type="radio" id="v_enable" class="rd_btn" name="b_view" value="1" checked><label for="v_enable">&nbsp;&nbsp;&nbsp;사용</label>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="v_disable" class="rd_btn" name="b_view" value="0"><label for="v_disable">&nbsp;&nbsp;&nbsp;숨김</label>
        </div>
        <div id="board_popup_btn">
            <input type="button" value="저장" onclick="view_btn('save');" onkeyup="if(event.keyCode == 13) view_btn('save');">
            <input type="button" value="취소" onclick="view_btn('close');" style="margin-left: 6px;">
            <input type="button" value="삭제"  onclick="view_btn('delete');" style="margin-left: 6px;">
        </div>
    </div>
</div>

<table class="board_table">
    <thead>
        <tr>
        <th width="80px" style="max-width: 80px" style="text-align: center;">&nbsp;</th>
        <th>게시판 관리</th>
        <th width="100px" style="max-width: 100px" style="text-align: center;">
            <span class="btn" onclick="c_view('c_add', '', '', '1');">게시판 추가</span>
        </th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($category_lists as $category_list) {
            ?>
                 <!-- 게시판 추가(1차 카테고리) 추가 -->
                 <tr class="idx<?=$category_list->category_id?> listO cate_rank">
                        <td class="tc">
                            <span class="ico fontawesome-caret-up" onclick="rank('c_up', 'category', '-1', '<?=$category_list->category_id?>', '<?=$category_list->category_rank?>');"></span>
                            <span class="ico fontawesome-caret-down" onclick="rank('c_down', 'category', '-1', '<?=$category_list->category_id?>', '<?=$category_list->category_rank?>');"></span>
                        </td>
                        <td><span onclick="categorySH('<?=$category_list->category_id?>');"><?=$category_list->category_name?></span></td>
                        <td class="tr">
                            <span class="ico entypo-list-add" onclick="b_view('b_add', '<?=$category_list->category_id?>', '<?=$category_list->category_name?>', '1');">
                                <!-- 게시판 추가 버튼 -->
                            </span>
                            <span class="ico fontawesome-edit" onclick="c_view('c_edit', '<?=$category_list->category_id?>', '<?=$category_list->category_name?>', '1');">
                                <!-- 1차 카테고리 수정 버튼 -->
                            </span>
                        </td>
                    </tr>
                   <?php 
                    foreach ($sub_category_lists as $sub_category_list){
                        if($category_list->category_id === $sub_category_list->category_id){ 
                    ?>
                    <!-- 게시판 추가 -->
                    <tr class="sub_cate idx_<?=$category_list->category_id?>">
                        <td class="tc">
                            <span class="ico fontawesome-caret-up" onclick="rank('up', 'sub_category', '<?=$sub_category_list->sub_category_id?>', '<?=$category_list->category_id?>', '<?=$sub_category_list->sub_category_rank?>')";></span>
                            <span class="ico fontawesome-caret-down" onclick="rank('down', 'sub_category', '<?=$sub_category_list->sub_category_id?>', '<?=$category_list->category_id?>', '<?=$sub_category_list->sub_category_rank?>')";></span>
                        </td>
                            <td><span class="ico entypo-level-down"></span><span onclick="location.href = '?page=contents&cate=&board=';"><?=$sub_category_list->sub_category_name?></span></td>
                            <td class="tr">
                            <span class="ico fontawesome-edit" onclick="b_view('b_edit', '<?=$category_list->category_id?>', '<?=$category_list->category_name?>', '1', '<?=$sub_category_list->sub_category_id?>', '<?=$sub_category_list->sub_category_name?>');"></span>
                        </td>
                    </tr>
                  <?php
                        }    
                      }
                    }
                  ?>       
    </tbody>
</table>

<link rel="stylesheet" type="text/css" media="screen" href="/static/admin/css/board.css" />
<script src="/static/admin/js/board.js"></script>