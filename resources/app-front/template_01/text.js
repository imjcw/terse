<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" type="text/css" href="/public/include/semantic/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main.css">
    <script type="text/javascript" src="/public/include/jquery/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="/public/include/semantic/semantic.min.js"></script>
    <script type="text/javascript" src="/public/js/main.js"></script>
    <style type="text/css">
    body{
        background-color: #f1f1f1;
    }
    ul li{
        display: inline-block;
        list-style: none;
    }
    .ui.container.header ul li a{
        display: block;
        line-height: 65px;
        padding: 0 20px;
    }
    .ui.container.header ul li a.select{
        line-height: 60px;
        border-bottom: 3px solid #009C95;
        margin-bottom: 2px;
    }
    </style>
<body>
    <div class="ui container">
        <div class="ui two column stackable grid">
            <div class="eleven wide column">
                <div class="ui segment">Content</div>
                <div class="ui attached segment">
                    <h1 style="background-color: #ebebeb; border-left: 4px solid #009C95; border-right: 4px solid #009C95; margin: 35px -18px 20px; line-height: 40px; text-align: center;font-size: 18px;">test</h1>
                    <h3 style="line-height: 30px; margin: 0 -14px 5px; border-left: 4px solid #009C95; text-indent: 40px;">test</h3>
                    <p style="font-size: 14px;">首先要安装kibana4.2或更高版本，参见上一篇。然后执行下面命令：</p>
                </div>
                <div class="ui bottom attached message">
                    版权
                </div>
            </div>
            <div class="five wide column">
                <div class="ui segment">Content<?php echo "string";?></div>
            </div>
        </div>
    </div>
</body>
</html>