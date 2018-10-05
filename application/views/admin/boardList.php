<table class="board_table">
    <thead>
        <th width="80px" style="max-width: 80px;">번호(선택)</th>
        <th>게시판 이름</th>
        <th width="80px" style="max-width: 80px;">게시글 수</th>
    </thead>

    <tbody>
              <?php
               if($sub_lists != NULL){
                $i = 0;
                $j = count($cnt);
               while($i <= $j-1){ 
                foreach($sub_lists as $list){ ?>
                    <tr onclick="location.href = ('/Admin_board/contentsList/<?=$list->sub_category_id?>');">
                        <td><?=$i=$i+1?></td>
                        <td><?=$list->sub_category_name?></td>   
                        <td><?=str_replace("\"","",json_encode($cnt[$i-1][0]->CNT))?></td>
                  </tr>
               <?php
                    }
                   $i++;    
                }
            } else {
            ?>  <tr><td colspan="3">게시판이 존재하지 않습니다.</td></tr>
            <?php } ?>   
        
    </tbody>
</table>

<link href="/static/admin/css/contents.css" rel="stylesheet">