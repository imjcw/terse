$(document).ready(function(){
    // 全局对象
    var path;
    path = window.location.pathname.match(/\/(\w+)(-\w+)*\//g);
    // 判断选中的菜单
    $(".terse.nav .subnav a").each(function(){
        var href = $(this).attr("href").match(/\/(\w+)(-\w+)*\//g);
        if (path[0] == href[0] ) {
            //选中当前所在栏目
            $(this).addClass('selected');
            $(this).parents(".subnav").siblings("a").addClass("selected");
            $(this).parents(".subnav").show();
            $(this).parents(".subnav").siblings("a").children(".dropdown").css("transform", "rotate(0deg) ").css('transition', 'transform 0.2s ease 0s');
            return false;
        }

    });
    //左侧导航
    $('.terse.nav>li>a').click(function(){
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            $(this).siblings('ul.subnav').slideUp();
            $(this).children('.terse.right').css("transform", "rotate(90deg) ").css('transition', 'transform 0.2s ease 0s');
        }else{
            $('.terse.nav>li>a').removeClass('selected');
            $('.terse.nav ul.subnav').slideUp();
            $('.terse.nav .terse.right').css("transform", "rotate(90deg) ").css('transition', 'transform 0.2s ease 0s');
            $(this).addClass('selected');
            $(this).siblings('ul.subnav').slideDown();
            $(this).children('.terse.right').css("transform", "rotate(0deg) ").css('transition', 'transform 0.2s ease 0s');
        }
    });
    //下拉列表
    $('.ui.dropdown').dropdown();
    //关闭提示框
    $('.terse.tip .remove').click(function(){
        closeTips();
    });
    //返回
    $('.go_back').click(function(){
        history.back();
    });
});

//提示框
var tips;
//取消提示框
function closeTips () {
    clearTimeout(tips);
    $('.terse.tip').animate({top:'0px',opacity:0},300);
    $('.terse.tip').fadeOut(500);
}
//显示提示框
function showTips (msg) {
    clearTimeout(tips);
    $('.terse.tip span').html(msg);
    $('.terse.tip').fadeIn(300, function(){
        tips = setTimeout(closeTips,5000);
    });
    $('.terse.tip').animate({top:'10px',opacity:1},300);
}
