@extends('layouts.admin')
    @section('content')
        <!--面包屑导航 开始-->
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置管理
        </div>
        <!--面包屑导航 结束-->

        <!--结果集标题与导航组件 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>编辑配置</h3>
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
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>新增配置</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-list"></i>配置列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        <!--结果集标题与导航组件 结束-->

        <div class="result_wrap">
            <form action="{{url('admin/config/' . $field->id)}}" method="post">
                {{method_field('PUT')}}
                {{csrf_field()}}
                <table class="add_tab">
                    <tbody>
                    <tr>
                        <th><i class="require">*</i>配置标题：</th>
                        <td>
                            <input type="text" class="md" name="title" value="{{$field->title}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置标题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>配置名称：</th>
                        <td>
                            <input type="text" class="md" name="name" value="{{$field->name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>类型名：</th>
                        <td>
                            <input type="radio" name="type" value="input">input　
                            <input type="radio" name="type" value="textarea">textarea　
                            <input type="radio" name="type" value="radio">radio
                        </td>
                    </tr>
                    <tr class="config_value">
                        <th>类型值：</th>
                        <td>
                            <input type="text" name="value" value="{{$field->value}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>radio类型：1|开启,0|关闭</span>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="sort" value="{{$field->sort}}">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="remark">{{$field->remark}}</textarea>
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
                var config_type = "{{$field->type}}";    //类型
                //类型选择
                $('input[name=type][value="' + config_type + '"]').attr('checked', 'checked');

                //切换类型方式
                if (config_type !== 'radio') {
                    $('.config_value').hide();
                }
                $('input[name=type]').click(function () {
                    if ($(this).val() == 'radio') {
                        $('.config_value').show('slow');
                    } else {
                        $('.config_value').hide('slow');
                    }
                });
            });
        </script>
    @endsection