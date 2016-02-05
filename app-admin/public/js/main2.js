//获取当天日期
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
    $('.join_left .ui.menu .join_item a.join_father').click(function(){
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
    $('.ui.pagination.menu a').click(function(){
        $(this).siblings().removeClass('active blue');
        $(this).addClass('active blue');
    });
    //日期设置
    if ($('input').hasClass('join_date')) {
        $('.join_date').datetimepicker({
            lang:'ch',
            format:"Y-m-d",
            timepicker:false
        });
    }
    //选中当前所在栏目
    $('.join_left .join_item:eq(0) a.join_father').addClass('join_menu_hover');
    $('.join_left .join_item:eq(0) a.join_father').siblings('ul').slideDown();
    $('.join_left .join_item:eq(0) a.join_father').children('.float_right').css("transform", "rotate(0deg) ").css('transition', 'transform 0.2s ease 0s');
    $('.join_left .join_item:eq(0) .item:eq(0)').addClass('join_active');
});