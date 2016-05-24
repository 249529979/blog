@extends('layouts.admin')
    @section('content')
        <!--面包屑导航 开始-->
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 菜单管理
        </div>
        <!--面包屑导航 结束-->

        <!--结果集标题与导航组件 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>编辑菜单</h3>
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
                    <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>新增菜单</a>
                    <a href="{{url('admin/navs')}}"><i class="fa fa-list"></i>菜单列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        <!--结果集标题与导航组件 结束-->

        <div class="result_wrap">
            <form action="{{url('admin/navs/' . $field->id)}}" method="post">
                {{method_field('PUT')}}
                {{csrf_field()}}
                <table class="add_tab">
                    <tbody>
                    <tr>
                        <th><i class="require">*</i>菜单名称：</th>
                        <td>
                            <input type="text" class="md" name="name" value="{{$field->name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>菜单名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>菜单别名：</th>
                        <td>
                            <input type="text" class="md" name="alias" value="{{$field->alias}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>菜单别名必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>菜单地址：</th>
                        <td>
                            <input type="text" name="url" value="{{$field->url}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>菜单地址必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="sort" value="{{$field->sort}}">
                        </td>
                    </tr>
                    <tr>
                        <th>状态：</th>
                        <td>
                            <input type="radio" name="status" value="1">显示
                            <input type="radio" name="status" value="0">隐藏
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
                var navs_status = {{$field->status}};   //是否审核
                //是否审核
                $('input[name=status][value="' + navs_status + '"]').attr('checked', 'checked');
            });
        </script>
    @endsection