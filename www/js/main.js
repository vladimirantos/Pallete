$(function () {
    $(".ClickMe").click(function (e) {
        e.preventDefault();
        $a = $(this).find("a").click();
    });
});
