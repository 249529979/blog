@extends('layouts.admin')
    @section('content')
        <!--面包屑导航 开始-->
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 配置管理
        </div>
        <!--面包屑导航 结束-->

        <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>配置列表</h3>
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

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/config/changeContent')}}" method="post">
                    {{csrf_field()}}
                    <table class="list_tab">
                        <tr>
                            <th class="tc">排序</th>
                            <th class="tc">ID</th>
                            <th>配置标题</th>
                            <th>配置名称</th>
                            <th>配置内容</th>
                            <th class="tc">操作</th>
                        </tr>
                        @foreach($data as $value)
                            <tr>
                                <td class="tc">
                                    <input type="text" onchange="changeSort(this, {{$value->id}})" value="{{$value->sort}}">
                                </td>
                                <td class="tc">{{$value->id}}</td>
                                <td>
                                    <a href="" target="_blank">{{$value->title}}</a>
                                </td>
                                <td>
                                    {{$value->name}}
                                </td>
                                <td>
                                    <input type="hidden" name="id[]" value="{{$value->id}}">
                                    {!! $value->_html !!}
                                </td>
                                <td>
                                    <a href="{{url('admin/config/'.$value->id.'/edit')}}">修改</a>
                                    <a href="javascript:;" onclick="destroy({{$value->id}})">删除</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="btn_group">
                        <input type="submit" value="提交">
                    </div>
                </form>
            </div>
        </div>
        <!--搜索结果页面 列表 结束-->
        <script type="text/javascript">

            /**
             * 异步更新排序
             * @param obj
             * @param id  分类ID
             */
            function changeSort(obj, id) {
                var sort = $(obj).val();
                $.post("{{url('admin/config/changeSort')}}", {
                    '_token': '{{csrf_token()}}',
                    'id': id,
                    'sort': sort
                }, function (data) {
                    if (data.status == 0) {
                        layer.msg(data.message, {icon: 6});
                        setTimeout('location.href = location.href', 2000);
                    } else {
                        layer.msg(data.message, {icon: 5});
                    }
                });
            }

            /**
             * 异步删除分类
             * @param id
             */
            function destroy(id) {
                layer.confirm('您确认要删除这个友情链接嘛?', {
                    btn: ['确定', '取消']  //按钮
                }, function () {
                    $.post("{{url('admin/config/')}}/" + id, {
                        '_method': 'delete',
                        '_token': "{{csrf_token()}}"
                    }, function (data) {
                        if (data.status == 0) {
                            layer.msg(data.message, {icon: 6});
                            setTimeout('location.href = location.href', 2000);
                        } else {
                            layer.msg(data.message, {icon: 5});
                        }
                    });
                }, function () {

                });
            }
        </script>
    @endsection