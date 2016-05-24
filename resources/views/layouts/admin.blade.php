<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>后台-首页</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="{{asset('admin/style/css/ch-ui.admin.css')}}"/>
        <link rel="stylesheet" href="{{asset('admin/style/font/css/font-awesome.min.css')}}"/>
        @yield('css')
        <script type="text/javascript" src="{{asset('admin/style/js/jquery.js')}}"></script>
        <script type="text/javascript" src="{{asset('admin/style/js/ch-ui.admin.js')}}"></script>
        <script type="text/javascript" src="{{asset('admin/layer/layer.js')}}"></script>
        @yield('js')
    </head>
    <body>
        @yield('content')
    </body>
</html>