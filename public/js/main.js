$(document).ready(function(){
    // 全局对象
    var site = {};
    site.path = window.location.pathname.replace(/\/(\w+\.\w+)(\?.*)*/, "");alert(site.path);
    // 判断选中的菜单
    $(".terse.nav .subnav a").each(function(){
        var href = $(this).attr("href").replace(/(\/*$)/g, "");
        if (site.path == href ) {
            //选中当前所在栏目
            $(this).addClass('selected');
            $(this).parents(".subnav").siblings("a").addClass("selected");
            $(this).parents(".subnav").show();
            $(this).parents(".subnav").siblings("a").children(".dropdown").css("transform", "rotate(0deg) ").css('transition', 'transform 0.2s ease 0s');
            return false;
        };

    });
    //左侧导航
    $('.terse.nav>li>a').click(function(){
        if ($(this).hasClass('selected')) {
            $(this).siblings('ul.subnav').slideUp();
            $(this).children('.terse.right').css("transform", "rotate(90deg) ").css('transition', 'transform 0.2s ease 0s');
        }else{
            $(this).addClass('selected');
            $(this).siblings('ul.subnav').slideDown();
            $(this).children('.terse.right').css("transform", "rotate(0deg) ").css('transition', 'transform 0.2s ease 0s');
            $($(this).parent().siblings()).children('a').removeClass('selected');
            $($(this).parent().siblings()).children('ul.subnav').slideUp();
            $($(this).parent().siblings()).children('a').children('.terse.right').css("transform", "rotate(90deg) ").css('transition', 'transform 0.2s ease 0s');
        }
    });
});
//\/(\w+-\w+\.\w+)(\?.*)*
//\/(\w+\.\w+\.\w+)(\?.*)*
//\/(\w+-.*)(\?.*)*