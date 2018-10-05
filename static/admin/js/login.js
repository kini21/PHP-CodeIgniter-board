$(document).ready(function () {
    var $id_box = $("#id_box");
    var $pw_box = $("#pw_box");

    $("#id_box").hover(function () {
        $id_box.css("border", "1px solid #f1f1f1");
    }, function () {
        $id_box.css("border", "1px solid #ffffff");
    });

    $("#pw_box").hover(function () {
        $pw_box.css("border", "1px solid #f1f1f1");
    }, function () {
        $pw_box.css("border", "1px solid #ffffff");
    });
});

function login_check() {
    // 유효성 검사 필요
    $("#login_form").submit();
}