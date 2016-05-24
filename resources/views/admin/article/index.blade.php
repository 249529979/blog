@extends('layouts.admin')
    @section('content')
        <!--面包屑导航 开始-->
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 文章管理
        </div>
        <!--面包屑导航 结束-->

        <!--结果页快捷搜索框 开始-->
        <div class="search_wrap">
            <form action="" method="post">
                <table class="search_tab">
                    <tr>
                        <th width="70">关键字:</th>
                        <td><input type="text" name="keywords" placeholder="关键字"></td>
                        <td><input type="submit" name="sub" value="查询"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--结果页快捷搜索框 结束-->

        <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>文章列表</h3>
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

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th class="tc">查看次数</th>
                        <th class="tc">作者</th>
                        <th class="tc">发布时间</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $value)
                        <tr>
                            <td class="tc">{{$value->id}}</td>
                            <td>
                                <a href="#">{{$value->title}}</a>
                            </td>
                            <td class="tc">{{$value->view}}</td>
                            <td>{{$value->author}}</td>
                            <td class="tc">{{date('Y-m-d', $value->release_time)}}</td>
                            <td>
                                <a href="{{url('admin/article/'.$value->id.'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="destroy({{$value->id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="page_list">
                    {{$data->links()}}
                </div>
            </div>
        </div>
        <!--搜索结果页面 列表 结束-->
        <script type="text/javascript">
            /**
             * 异步删除分类
             * @param id
             */
            function destroy(id) {
                layer.confirm('您确认要删除这个文章嘛?', {
                    btn: ['确定', '取消']  //按钮
                }, function () {
                    $.post("{{url('admin/article/')}}/" + id, {
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
