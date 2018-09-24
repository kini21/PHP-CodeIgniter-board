
<script>
    function move(i, j, k) {
        location.href = '/Board/contentLists/' + i + '?category_name=' + j + '&sub_category_name=' + k;
    }
</script>
<nav>
    <img id="logo" src="/static/images/logo.svg" onclick="location.href='/';">
                <?php
                foreach ($category_lists as $category_list) {
                ?>
                  <span class="title"><?=$category_list->category_name?></span>
                   <?php 
                    foreach ($sub_category_lists as $sub_category_list){
                        if($category_list->category_id === $sub_category_list->category_id){ 
                    ?>
                  <ul>
                        <li onclick="move('<?=$sub_category_list->sub_category_id?>', '<?=$category_list->category_name?>', '<?=$sub_category_list->sub_category_name?>');"> 
                            <?=$sub_category_list->sub_category_name?>
                        </li>
                  </ul>
                  <?php
                        }    
                      }
                    }
                  ?>
</nav>