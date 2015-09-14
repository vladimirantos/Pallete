$(function () {
    $(".click").click(function (e) {
        e.preventDefault();
        $a = $(this).find("a").click();
    });
});
