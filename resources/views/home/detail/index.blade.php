@extends('layouts.home')
    @section('info')
        <title>{{Config::get('web.web_title')}} - {{Config::get('web.seo_title')}}</title>
        <meta charset="utf-8"/>
        <meta name="keywords" content="{{Config::get('keywords')}}"/>
        <meta name="description" content="{{Config::get('description')}}"/>
    @endsection
    @section('css')
        <link href="{{asset('home/css/new.css')}}" rel="stylesheet">
    @endsection
    @section('content')
        <article class="blogs">
            <h1 class="t_nav">
                <span>您当前的位置：
                    <a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;
                    @foreach($parent as $key => $value)
                        <a href="{{url('c_' . $value->id)}}">{{$value->name}}</a>@if($key != $last)&nbsp;&gt;&nbsp;@endif
                    @endforeach
                </span>
                <a href="{{url('/')}}" class="n1">网站首页</a>
                <a href="{{url('c_' . $info->cid)}}" class="n2">{{$info->name}}</a>
            </h1>
            <div class="index_about">
                <h2 class="c_titile">{{$info->title}}</h2>
                <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d', $info->release_time)}}</span><span>编辑：{{$info->author}}</span><span>查看次数：{{$info->view}}</span></p>
                <ul class="infos">
                    {!! $info->content !!}
                </ul>
                <div class="keybq">
                    <p><span>关键字词</span>：{{$info->keywords}}</p>

                </div>
                <div class="ad"> </div>
                <div class="nextinfo">
                    <p>上一篇：
                        @if($pre)
                            <a href="{{url('a_' . $pre->id)}}">{{$pre->title}}</a></p>
                        @else
                            <span>没有上一篇了</span>
                        @endif
                    <p>下一篇：
                        @if($next)
                            <a href="{{url('a_' . $next->id)}}">{{$next->title}}</a></p>
                        @else
                            <span>没有下一篇了</span>
                        @endif
                    </p>
                </div>
                <div class="otherlink">
                    <h2>相关文章</h2>
                    <ul>
                        @foreach($related as $value)
                        <li><a href="{{url('a_' . $value->id)}}" title="{{$value->title}}">{{$value->title}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <aside class="right">
                <!-- 分享开始 -->
                <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
                    <a class="bds_tsina"></a>
                    <a class="bds_qzone"></a>
                    <a class="bds_tqq"></a>
                    <a class="bds_renren"></a>
                    <span class="bds_more"></span>
                    <a class="shareCount"></a>
                </div>
                <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585"></script>
                <script type="text/javascript" id="bdshell_js"></script>
                <script type="text/javascript">
                    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000)
                </script>
                <!-- 分享结束 -->
                <div class="blank"></div>
                <div class="news">
                    @parent
                </div>
                <div class="visitors">
                    <h3>
                        <p>最近访客</p>
                    </h3>
                    <ul>
                    </ul>
                </div>
            </aside>
        </article>
    @endsection