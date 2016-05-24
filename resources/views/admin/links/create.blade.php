@extends('layouts.admin')
    @section('css')
        <link rel="stylesheet" href="{{asset('admin/uploadifive/uploadifive.css')}}">
    @endsection
    @section('js')
        <script type="text/javascript" src="{{asset('admin/uploadifive/jquery.uploadifive.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('admin/laydate/laydate.js')}}"></script>
    @endsection
    @section('content')
        <!--面包屑导航 开始-->
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接
        </div>
        <!--面包屑导航 结束-->

        <!--结果集标题与导航组件 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>新增友情链接</h3>
                @if(count($errors)>0)
                    <div class="mark">
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        @else
                            <p>{{$errors}}</p>
                        @endif
                    </div>
                @endif
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增友情链接</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-list"></i>友情链接列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        <!--结果集标题与导航组件 结束-->

        <div class="result_wrap">
            <form action="{{url('admin/links')}}" method="post">
                {{csrf_field()}}
                <table class="add_tab">
                    <tbody>
                    <tr>
                        <th><i class="require">*</i>链接名称：</th>
                        <td>
                            <input type="text" class="md" name="name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>链接名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>链接地址：</th>
                        <td>
                            <input type="text" name="url" value="http://">
                            <span><i class="fa fa-exclamation-circle yellow"></i>链接地址必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>链接方式：</th>
                        <td>
                            <input type="radio" name="display" value="0" checked="checked">文字链接　
                            <input type="radio" name="display" value="1">图片链接
                        </td>
                    </tr>
                    <tr class="links_logo">
                        <th>LOGO：</th>
                        <td>
                            <input type="hidden" name="logo">
                            <input type="file" id="file_upload" name="file_upload" multiple="true">
                            <div id="uploadList">
                                <ul>
                                    <li>

                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <input type="text" class="lg" name="description">
                        </td>
                    </tr>
                    <tr>
                        <th>有效时间：</th>
                        <td>
                            <input type="text" class="sm" name="valid" placeholder="请输入日期" onclick="laydate()">
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="sort" value="0">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <script type="text/javascript">
            $(function() {
                //切换链接方式
                $('.links_logo').hide();
                $('input[name=display]').click(function(){
                    if($(this).val() == 1){
                        $('.links_logo').show('slow');
                    }else{
                        $('.links_logo').hide('slow');
                    }
                });

                //上传LOGO
                $('#file_upload').uploadifive({
                    'auto'              : true,
                    'buttonText'        : '图片上传',
                    'fileType'          : 'image',
                    'removeCompleted'   : true,
                    'formData'          : {
                        '_token'        : "{{csrf_token()}}"
                    },
                    'uploadScript'      : "{{url('admin/links/upload')}}",
                    'onUploadComplete'  : function (file, data, response) {
                        var img = '<img src="' + data + '" id="art_logo_img" style="margin-top: 10px; max-width: 135px; max-height: 90px;"/>'
                        $('input[name=logo]').val(data);
                        $("#uploadList li").prepend(img);
                    }
                });
            });
        </script>
    @endsection