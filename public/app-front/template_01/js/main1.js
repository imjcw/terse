//获取当天日期，啦啦
function setTodayDate(className){
    var myDate = new Date();
    var today = myDate.getFullYear() + '-';
    today += myDate.getMonth() + '-';
    today += myDate.getDate();
    $('.'+className).val(today);
}

$(document).ready(function(){
    //更多，下拉
    $('.join_header .dropdown').dropdown({
        transition: 'drop'
    });
    //左侧导航
    $('.join_left a.join_father').click(function(){
        if ($(this).hasClass('join_menu_hover')) {
            $(this).removeClass('join_menu_hover');
            $(this).siblings('ul').slideUp();
            $(this).children('.float_right').css("transform", "rotate(90deg) ").css('transition', 'transform 0.2s ease 0s');
        }else{
            $(this).addClass('join_menu_hover');
            $(this).siblings('ul').slideDown();
            $(this).children('.float_right').css("transform", "rotate(0deg) ").css('transition', 'transform 0.2s ease 0s');
            $($(this).parent().siblings()).children('a').removeClass('join_menu_hover');
            $($(this).parent().siblings()).children('ul').slideUp();
            $($(this).parent().siblings()).children('a').children('.float_right').css("transform", "rotate(90deg) ").css('transition', 'transform 0.2s ease 0s');
        }
    });
    //下拉列表
    $('select.dropdown').dropdown();
    $('.ui.dropdown').dropdown();
    //单选
    $('.ui.radio.checkbox').checkbox();
    //分页

    //日期设置
    // if ($('input').hasClass('join_date')) {
    //     $('input.join_date').datetimepicker({
    //         lang:'ch',
    //         format:"Y-m-d",
    //         timepicker:false
    //     });
    // }

    // 全局对象
    var site = {};
    // 获取 url path  去掉最后"/"
    site.path = window.location.pathname.replace(/(\/*$)/g, "");
    // 判断选中的菜单
    $("#menu_list .submenu a").each(function(){
        var href = $(this).attr("href").replace(/(\/*$)/g, "");
        if (site.path == href ) {
            //选中当前所在栏目
            $(this).parents("li").addClass('join_active');
            $(this).parents(".join_item").find(".join_father").addClass("join_menu_hover");
            $(this).parents(".submenu").show();
            $(this).parents('.join_item').find(".dropdown").css("transform", "rotate(0deg) ").css('transition', 'transform 0.2s ease 0s');
            return false;
        };

    });

});