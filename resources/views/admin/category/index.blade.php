@extends('layouts.admin')
    @section('content')
        <!--面包屑导航 开始-->
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 分类管理
        </div>
        <!--面包屑导航 结束-->

        <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>分类列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-list"></i>分类列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>名称</th>
                        <th>标题</th>
                        <th class="tc">查看次数</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $value)
                        <tr>
                            <td class="tc">
                                <input type="text" onchange="changeSort(this, {{$value->id}})" value="{{$value->sort}}">
                            </td>
                            <td class="tc">{{$value->id}}</td>
                            <td>
                                <a href="#">{{$value->_name}}</a>
                            </td>
                            <td>{{$value->title}}</td>
                            <td class="tc">{{$value->views}}</td>
                            <td>
                                <a href="{{url('admin/category/'.$value->id.'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="destroy({{$value->id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
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
                $.post("{{url('admin/category/changeSort')}}", {
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
                layer.confirm('您确认要删除这个分类嘛?', {
                    btn: ['确定', '取消']  //按钮
                }, function () {
                    $.post("{{url('admin/category/')}}/" + id, {
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


























