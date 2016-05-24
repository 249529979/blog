<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        @yield('info')
        <link href="{{asset('home/css/base.css')}}" rel="stylesheet">
        @yield('css')
        <!--[if lt IE 9]>
        <script src="{{asset('home/js/modernizr.js')}}"></script>
        <![endif]-->
    </head>
    <body>
        <header>
            <div id="logo"><a href="/"></a></div>
            <nav class="topnav" id="topnav">
                @foreach($navs as $value)<a href="{{$value->url}}"><span>{{$value->name}}</span><span class="en">{{$value->alias}}</span></a>@endforeach
            </nav>
        </header>
        @section('content')
            <h3>
                <p>最新<span>文章</span></p>
            </h3>
            <ul class="rank">
                @foreach($new as $value)
                    <li><a href="{{url('a_' . $value->id)}}" title="{{$value->title}}" target="_blank">{{$value->title}}</a></li>
                @endforeach
            </ul>
            <h3 class="ph">
                <p>点击<span>排行</span></p>
            </h3>
            <ul class="paih">
                @foreach($hot as $value)
                    <li><a href="{{url('a_' . $value->id)}}" title="{{$value->title}}" target="_blank">{{$value->title}}</a></li>
                @endforeach
            </ul>
        @show
        <footer>
            <p>{!! Config::get('web.web_copyright') !!} <a href="/">网站统计</a></p>
        </footer>
        <script src="{{asset('home/js/silder.js')}}"></script>
    </body>
</html>
