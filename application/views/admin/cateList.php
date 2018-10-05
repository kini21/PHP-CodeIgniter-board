<table class="board_table">
    <thead>
        <th width="80px" style="max-width: 80px;">번호(선택)</th>
        <th>언어 이름</th>
        <th width="80px" style="max-width: 80px;">게시판 수</th>
    </thead>

    <tbody>
            <?php
                $i = 0;
                $j = count($cnt);
               while($i <= $j-1){ 
                foreach($cate_lists as $list){ ?>
                    <tr onclick="location.href = ('/Admin_board/board_admin');">
                        <td><?=$i=$i+1?></td>
                        <td><?=$list->category_name?></td>   
                        <td><?=str_replace("\"","",json_encode($cnt[$i-1][0]->CNT))?></td>
                  </tr>
               <?php
                    }
                   $i++;    
                }
            ?> 
    </tbody>
</table>

<link href="/static/admin/css/contents.css" rel="stylesheet">