
function categorySH(b_idx) {
    var main = $(".idx" + b_idx);
    var sub = $(".idx_" + b_idx);
    console.log('개수' + sub.length);
    console.log('메인갯수'+main.length);

    if(main.hasClass("listO")) {
        // 목록 펼쳐진 상태
        main.removeClass("listO");
        sub.slideDown(200);
    } else {
        // 목록 닫힌 상태
        main.addClass("listO");
        sub.slideUp(200);
    }
}