@extends('layouts.admin')
    @section('css')
        <link rel="stylesheet" href="{{asset('admin/uploadifive/uploadifive.css')}}">
    @endsection
    @section('js')
        <script type="text/javascript" src="{{asset('admin/uploadifive/jquery.uploadifive.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('admin/ueditor/ueditor.config.js')}}"></script>
        <script type="text/javascript" src="{{asset('admin/ueditor/ueditor.all.min.js')}}"> </script>
        <script type="text/javascript" src="{{asset('admin/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    @endsection
    @section('content')
        <!--面包屑导航 开始-->
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
        </div>
        <!--面包屑导航 结束-->

        <!--结果集标题与导航组件 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>编辑文章</h3>
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
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-list"></i>文章列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        <!--结果集标题与导航组件 结束-->

        <div class="result_wrap">
            <form action="{{url('admin/article/' . $field->id)}}" method="post">
                {{method_field('PUT')}}
                {{csrf_field()}}
                <table class="add_tab">
                    <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="cid">
                                @foreach($data as $value)
                                    <option value="{{$value->id}}" @if($value->id == $field->cid) selected="selected" @endif>{{$value->_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="title" value="{{$field->title}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>文章标题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>作者：</th>
                        <td>
                            <input type="text" class="sm" name="author" value="{{$field->author}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>作者必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <input type="hidden" name="thumb" value="{{$field->thumb}}">
                            <input type="file" id="file_upload" name="file_upload" multiple="true">
                            <div>
                                <ul>
                                    <li>
                                        <img src="{{$field->thumb}}" id="art_thumb_img" style="margin-top: 10px; max-width: 350px; max-height: 100px;"/>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <input type="text" class="lg" name="keywords" value="{{$field->keywords}}">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="description">{{$field->description}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章内容：</th>
                        <td>
                            <textarea id="editor" name="content" type="text/plain" style="width:860px;height:400px;">{{$field->content}}</textarea>
                            <p style="margin-top: 5px;"><i class="fa fa-exclamation-circle yellow"></i>文章内容必须填写</p>
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
                //调用编辑器
                var ue = UE.getEditor('editor');

                //上传缩略图
                $('#file_upload').uploadifive({
                    'auto'              : true,
                    'buttonText'        : '图片上传',
                    'fileType'          : 'image',
                    'removeCompleted'   : true,
                    'formData'          : {
                        '_token'        : "{{csrf_token()}}"
                    },
                    'uploadScript'      : "{{url('admin/article/upload')}}",
                    'onUploadComplete'  : function (file, data, response) {
                        $('input[name=thumb]').val(data);
                        $('#art_thumb_img').attr('src',data);
                    }
                });
            });
        </script>
    @endsection