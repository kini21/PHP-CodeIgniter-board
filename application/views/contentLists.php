<script>

var board_id = "";
var password = "";
var sub_category_id = "";

$(document).ready(function(){
     $('#pwModal').on('show.bs.modal', function (event) {
         board_id = $(event.relatedTarget).data('param');
         sub_category_id = $(event.relatedTarget).data('sub_category_id');

         $('#password').val("");
         $('#alert').removeClass('alert alert-danger').text("");

         $(function(){
            $('#pwModal').keypress(function(e){
                if(e.which == 13) {
                    $('#pw-btn').trigger("click");
                    return false;
                }
              })
            })

             $('#pw-btn').click(function(){
                password = $('#password').val();
                    $.ajax({
                    type : "POST",
                    url : "/Board/passwordCheck",
                    data : { "board_id" : board_id, "password" : password, "sub_category_id" : sub_category_id },
                    dataType :'json',
                    success: function (result) {
                      if(result.pwchk != null) {
                        location.href = '/Board/read/' + sub_category_id + '/' + board_id + '?category_name=' + result.category_name + '&sub_category_name=' + result.sub_category_name;
                      } else {
                          $('#alert').addClass("alert alert-danger");
                          $('#alert').attr('role', "role");
                          $('#alert').text("비밀번호가 일치하지 않습니다.");
                          return false;
                      }
                    }
                })
             });
       });
});

function move_page(i) 
{
    location.href = '/Board/write/' + i + '?category_name=<?=$_GET['category_name'] ?>&sub_category_name=<?=$_GET['sub_category_name']?>';
}
</script>

<div id="main">
    <div class="subject">
        <span class="title"><?=$_GET['category_name'] ?></span>&nbsp;
        <span class="sub_title"><?=$_GET['sub_category_name'] ?></span>
    </div>
    <table id="contents">
        <tr>
            <th width="80px">번호</th>
            <th class="tl">제목</th>
            <th width="100px">글쓴이</th>
            <th width="100px">날짜</th>
            <th width="60px">조회 수</th>
        </tr>
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
                        <td><?=$li->board_id?></td>
                        <td class="tl" id="openPWmodal" data-toggle="modal" data-target="#pwModal" data-param="<?=$li->board_id?>" data-sub_category_id="<?=$li->sub_category_id?>">
                             <?php
                                if($li->secret == 'Y') { ?>
                                    <label class='ico entypo-lock' style='padding: 0; font-size: 10pt;'></label>
                                <?php
                                } else {
                                ?>
                                  <?=strlen($li->title) >=60 ? substr($li->title,0 ,60)."..." : $li->title?> 
                                <?php } ?>
                        </td>
                        <td> <?=$li->author?></td>
                        <td> <?=$created?></td>
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
    </table>

    <div class="modal fade sm" id="pwModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" keyboard="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel">비밀번호 입력</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="passwordCheck_form" method="post">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">비밀번호</label>
                                            <input type="password" class="form-control" name="password" id="password" value="">
                                        </div>
                                        <div id="alert" class="" role="">
                                            
                                        </div> 
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="pw-btn">확인</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                        </div>

    <div class="container">
        <div class="row">
        <div class="col align-self-center">
        <?php 
            if($cnt >= 11) {
                ?>
                <div style="float:right; margin-top:25px;">
                <?=$pagination ?>
                </div>
            <?php
                }
             else {
                 ?>
                <div style="float:right; margin-left:0px; margin-top:25px;">
                    <ul class="pagination" id="pagination_btn">
                        <li class="page-item" id="active"><a>1</a></li>
                    </ul>
                </div> 
            <?php
             }   
            ?>
    
        </div>
        
        <div class="col align-self-end">
            <?php 
            $explode_uri = explode("/", $_SERVER['PHP_SELF']);
            if($explode_uri[3] != 'searchLists'){ 
            ?>
                <button type="button" id="write_btn" class="btn btn-light" 
                style="float:right; margin-right: 150px; margin-bottom: 30px;" onclick="move_page('<?=$explode_uri[4]?>');">
                    글쓰기
                </button> 
            <?php
                }
                else {}
            ?>
        </div>
        </div>
        </div>        
                   
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>