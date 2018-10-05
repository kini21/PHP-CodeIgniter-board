$(document).ready(function () {
    $("#board_bg").fadeOut('300', function () {
        $("#board_bg").css("display", "");
    });

    $("#board_popup").fadeOut('300', function () {
        $("#board_popup").css("display", "");
    });
    $("#board_popup_cate").on("change", function () {
        // cate = $(this).find("option[value='" + $(this).val() + "']").text();
        cate_name = $("#board_popup_cate option:selected").text();
    });
    $(document).keydown(function (event) {
        if (event.keyCode == 27) {
            view_close();
        }
    });
});

function rank(str, cate, b_idx, c_idx, cur_rank) {
    // 순위 적용 (업/다운, 게시판 번호, 언어 번호)

    var sub = $(".idx_" + c_idx);
    var max_rank = $(".cate_rank").length;

    if(cur_rank === '1' && str === 'up'){
        alert("첫번째 게시판입니다. 순서를 변경할 수 없습니다.");
        return false;
    } 
    else if(cur_rank == sub.length && str === 'down'){
        alert("마지막 게시판입니다. 순서를 변경할 수 없습니다.");
        return false;
    } 
    else if(cur_rank === '1' && str === 'c_up') {
        alert("첫번째 카테고리입니다. 순서를 변경할 수 없습니다.");
        return false;
    } 
    else if(cur_rank == max_rank && str === 'c_down'){
        alert("마지막 카테고리입니다. 순서를 변경할 수 없습니다.");
        return false;
    }

    var form = $("#cb_form");
    var insert = "";

    this.type = str;
    this.cate = cate;
    this.b_idx = b_idx;
    this.b_name = -1;
    this.c_idx = c_idx;
    this.c_name = -1;
    this.cb_view = -1;
    this.cb_rank = str;
    this.cur_rank = cur_rank;

    insert += "<input name='b_name' value='" + this.b_name + "'>";
    insert += "<input name='c_name' value='" + this.c_name + "'>";
    insert += "<input name='cb_view' value='" + this.cb_view + "'>";
    insert += "<input name='category_id' value='" + this.c_idx + "'>";

    insert += "<input name='type' value='" + this.type + "'>";
    insert += "<input name='cate' value='" + this.cate + "'>";
    insert += "<input name='sub_category_id' value='" + this.b_idx + "'>";

    insert += "<input name='cb_rank' value='" + this.cb_rank + "'>";
    insert += "<input name='cur_rank' value='" + this.cur_rank + "'>";

    form.html(insert);
    
    if(cate == 'category'){
        form.attr('action','/Admin_board/updateCategoryRank');
    } else {
        form.attr('action','/Admin_board/updateSubCategoryRank');
    }
    
    form.submit();
}

function c_view(str, c_idx, c_name, cb_view) {
    // 1차 카테고리 설정 창 (추가/수정, 1차 카테고리 번호, 1차 카테고리 이름, 숨김여부)
    this.type = str;
    this.cate = "category";
    this.b_idx = -1;
    this.b_name = -1;
    this.c_idx = c_idx;
    this.c_name = c_name;
    this.cb_view = cb_view;
    this.cb_rank = "no";

    $("#total_name").text("1차 카테고리  이름");
    $("#board_popup_name").attr("placeholder", "1차 카테고리 이름");
    $("#lan_title").css("display", "none");
    $("#board_popup_cate").css("display", "none");

    $("#board_popup_name").val(this.c_name);
    $("#board_popup_cate").val(c_idx + "").prop("selected", true);

    if(str == 'c_add') {
        // 1차 카테고리 추가
        $("#board_popup_title").text("1차 카테고리 추가");
        $("#board_popup_view").css("display", "none");
        $("#board_popup_btn input").eq(2).css("display", "none");

        $("#board_popup_btn input").css("width", "169px");
        $("#board_popup").css("height", "200px");
    } else if(str == 'c_edit') {
        // 1차 카테고리 수정
        $("#board_popup_view input[value=" + cb_view + "]").prop("checked", true);
        $("#board_popup_title").text("1차 카테고리 수정");
        $("#board_popup_name").val(c_name);
        $("#board_popup_view").css("display", "block");
        $("#board_popup_btn input").eq(2).css("display", "inline-block");

        $("#board_popup_btn input").css("width", "109px");
        $("#board_popup").css("height", "260px");
    }
    view_open();
}

function b_view(str, c_idx, c_name, cb_view, b_idx, b_name) {
    // 게시판 설정 창 (추가/수정, 1차 카테고리 번호, 1차 카테고리 이름, 숨김여부, 게시판 번호, 게시판 이름)
    cb_view = cb_view == 0 ? 0 : 1;
    this.type = str;
    this.cate = "sub_category";
    this.b_idx = b_idx;
    this.b_name = b_name;
    this.c_idx = c_idx;
    this.c_name = c_name;
    this.cb_view = cb_view;
    this.cb_rank = "no";
    
    $("#board_popup_cate").val(c_idx + "").prop("selected", true);
    $("#board_popup_name").val(b_name);
    $("#total_name").text("게시판 이름");
    $("#board_popup_name").attr("placeholder", "게시판 이름");
    $("#lan_title").css("display", "block");
    $("#board_popup_cate").css("display", "block");

    if(str == 'b_add') {
        // 게시판 추가
        $("#board_popup_title").text("게시판 추가");
        $("#board_popup_view").css("display", "none");
        $("#board_popup_btn input").eq(2).css("display", "none");

        $("#board_popup_btn input").css("width", "169px");
        $("#board_popup").css("height", "260px");
    } else if(str == 'b_edit') {
        // 게시판 수정
        $("#board_popup_view input[value=" + cb_view + "]").prop("checked", true);
        $("#board_popup_title").text("게시판 수정");
        $("#board_popup_view").css("display", "block");
        $("#board_popup_btn input").eq(2).css("display", "inline-block");

        $("#board_popup_btn input").css("width", "109px");
        $("#board_popup").css("height", "330px");
    }
    view_open();
}

function view_open() {
    scroll = $("html").scrollTop();
    $("html").animate({
        scrollTop: 0
    }, 300);
    $("#board_bg").fadeIn('300');
    $("#board_popup").fadeIn('300');
}

function view_close() {
    // 설정 창 닫기
    $("#board_bg").fadeOut('300');
    $("#board_popup").fadeOut('300');
    $("html").animate({
        scrollTop: scroll
    }, 300);
}

function view_btn(str) {
    var form = $("#cb_form");
    var insert = "";
    
    this.b_name = $("#board_popup_name").val();
    this.c_name = $("#board_popup_name").val();
    this.c_idx = $("#board_popup_cate option:selected").val();
    this.cb_view = $("#board_popup_view input:radio[name=b_view]:checked").val();

    // 설정 창 버튼 (저장/삭제/취소)
    if (str == 'save' || str == 'delete') {
        // 저장, 삭제버튼
        if(str == 'delete') {
            this.type = 'delete';
        } else {
            if ($("#board_popup_name").val() == '' || $("#board_popup_name").val() == null) {
                alert('이름부분이 비었습니다.');
                return false;
            }
        }
        insert += "<input name='sub_category_name' value='" + this.b_name + "'>";
        insert += "<input name='category_name' value='" + this.c_name + "'>";
        insert += "<input name='cb_view' value='" + this.cb_view + "'>";
        insert += "<input name='category_id' value='" + this.c_idx + "'>";

        insert += "<input name='type' value='" + this.type + "'>";
        insert += "<input name='cate' value='" + this.cate + "'>";
        insert += "<input name='sub_category_id' value='" + this.b_idx + "'>";
        
        insert += "<input name='cb_rank' value='" + this.cb_rank + "'>";

        if(type === 'c_add') {
            form.attr('action','/Admin_board/createCategory');
        } 
        else if (type === 'b_add') {
            form.attr('action','/Admin_board/createSubCategory');
        }
        else if (type === 'c_edit') {
            form.attr('action','/Admin_board/updateCategory');
        }
        else if (type === 'b_edit') {
            form.attr('action','/Admin_board/updateSubCategory');
        }
        else if (this.type === 'delete' && this.b_idx != null && this.cate === 'sub_category') {
            form.attr('action','/Admin_board/deleteSubCategory');
        }
        else if (this.type === 'delete' && this.c_idx != null && this.cate === 'category') {
            form.attr('action','/Admin_board/deleteCategory');
        }

        form.html(insert);
        form.submit();
    } else {
        // 취소버튼(닫기)
        view_close();
    }
}

function categorySH(b_idx) {
    var main = $(".idx" + b_idx);
    var sub = $(".idx_" + b_idx);
    console.log('개수' + sub.length);

    if(main.hasClass("listO")) {
        // 목록 펼쳐진 상태
        main.removeClass("listO");
        sub.fadeOut(200);
    } else {
        // 목록 닫힌 상태
        main.addClass("listO");
        sub.fadeIn(200);
    }
}