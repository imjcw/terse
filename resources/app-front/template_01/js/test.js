$(document).ready(function(){
    // 全局对象
    var path;
    path = window.location.pathname.match(/\/(\w+)(-\w+)*\//g);
    console.log(path);
});