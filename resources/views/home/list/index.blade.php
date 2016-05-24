@extends('layouts.home')
    @section('info')
        <title>{{Config::get('web.web_title')}} - {{Config::get('web.seo_title')}}</title>
        <meta charset="utf-8"/>
        <meta name="keywords" content="{{Config::get('keywords')}}"/>
        <meta name="description" content="{{Config::get('description')}}"/>
    @endsection
    @section('css')
        <link href="{{asset('home/css/style.css')}}" rel="stylesheet">
    @endsection
    @section('content')
        <article class="blogs">
            <h1 class="t_nav"><span>{{$category->title}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('c_' . $category->id)}}" class="n2">{{$category->name}}</a></h1>
            <div class="newblog left">
                @foreach($photo as $value)
                    <h2>{{$value->title}}</h2>
                    <p class="dateview"><span>发布时间：{{date('Y-m-d',$value->release_time)}}</span><span>作者：{{$value->author}}</span><span>分类：[<a href="{{url('c_' . $value->cid)}}">{{$value->name}}</a>]</span></p>
                    <figure><img src="{{$value->thumb}}"></figure>
                    <ul class="nlist">
                        <p>{{$value->description}}</p>
                        <a title="{{$value->title}}" href="{{url('a_' . $value->id)}}" target="_blank" class="readmore">阅读全文>></a>
                    </ul>
                    <div class="line"></div>
                @endforeach
                <div class="blank"></div>
                <div class="ad">
                    <img src="{{asset('home/images/ad.png')}}">
                </div>
                <div class="page">
                    {{$photo->links()}}
                </div>
            </div>
            <aside class="right">
                @if($childData->all())
                    <div class="rnav">
                        <ul>
                            @foreach($childData as $key => $value)
                                <li class="rnav{{$key+1}}"><a href="{{url('c_' . $value->id)}}" target="_blank">{{$value->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="news">
                    @parent
                </div>
                <div class="visitors">
                    <h3><p>最近访客</p></h3>
                    <ul>
                    </ul>
                </div>
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
            </aside>
        </article>
    @endsection