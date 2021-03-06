@extends('system.layout.index')
@section('contents')

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-toolbar clearfix">
                        <div class="toolbar-btn-action">
                            @if(in_array('/system/admin/store',$btns))
                            <a class="btn btn-primary m-r-5" href="#" data-toggle="modal" data-target="#create"><i class="mdi mdi-plus"></i> 新增</a>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>
                                        <label class="lyear-checkbox checkbox-primary">
                                            <input type="checkbox" id="check-all"><span></span>
                                        </label>
                                    </th>
                                    <th>编号</th>
                                    <th>名称</th>
                                    <th>邮箱</th>
                                    <th>角色</th>
                                    <th>状态</th>
                                    <th>最后登录IP</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list['data'] as $v)
                                    <tr>
                                        <td>
                                            <label class="lyear-checkbox checkbox-primary">
                                                <input type="checkbox" name="ids[]" value="1"><span></span>
                                            </label>
                                        </td>
                                        <td did="{{ $v['id']}}">{{ $v['id']}}</td>
                                        <td name="{{ $v['name'] }}">{{ $v['name'] }}</td>
                                        <td email="{{ $v['email'] }}">{{ $v['email'] }}</td>
                                        @foreach($roles as $rv)
                                            @if($rv['id']==$v['role'])
                                                <td role="{{ $v['role'] }}">{{$rv['name']}}</td>
                                            @endif
                                        @endforeach
                                        <td access="{{ $v['access'] }}">
                                            @if($v['access']==0)
                                                <span class="text-success">允许登录</span>
                                            @else
                                                <span class="text-danger">禁止登录</span>
                                            @endif
                                        </td>
                                        <td>{{ $v['ip'] }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @if(in_array('/system/admin/update',$btns))
                                                <button class="btn-xs btn btn-info up">编辑</button>
                                                @endif
                                                @if(in_array('/system/admin/del',$btns))
                                                <button class="btn-xs btn btn-danger" onclick="del({{ $v['id'] }})">删除</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $list['page'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">新增管理员</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;" class="site-form">

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">管理员名称</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">EMAIL</label>
                            <input type="text" class="form-control" name="email">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">密码</label>
                            <input type="text" class="form-control" name="passwd">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">角色</label>
                            <select class="form-control role" size="1">
                                @foreach($roles as $v)
                                    <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">状态</label>
                            <select class="form-control access" size="1">
                                <option value="0">允许登录</option>
                                <option value="1">禁止登录</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="ok()">点击保存</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改管理员</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;" class="site-form">
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">名称</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">邮箱</label>
                            <input type="text" class="form-control"  id="email">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">密码</label>
                            <input type="text" class="form-control" id="passwd">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">角色</label>
                            <select class="form-control" size="1" id="role">
                                @foreach($roles as $v)
                                    <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">状态</label>
                            <select class="form-control" size="1" id="access">
                                <option value="0">允许登录</option>
                                <option value="1">禁止登录</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="up()">点击保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>

        function ok() {
            var name = $("input[name='name']").val();
            var email = $("input[name='email']").val();
            var passwd = $("input[name='passwd']").val();
            var access = $(".access option:selected").val();
            var role = $(".role option:selected").val();

            if(name==''){
                lightyear.notify('名称不能为空', 'danger', 100);
                return false;
            }

            if(email==''){
                lightyear.notify('邮箱不能为空', 'danger', 100);
                return false;
            }

            var reg = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
            if(!reg.test(email)){
                lightyear.notify('邮箱格式不正确', 'danger', 100);
                return false;
            }

            if(passwd==''){
                lightyear.notify('密码不能为空', 'danger', 100);
                return false;
            }

            if(access==''){
                lightyear.notify('状态不能为空', 'danger', 100);
                return false;
            }

            if(role==''){
                lightyear.notify('角色不能为空', 'danger', 100);
                return false;
            }

            var obj = new Object();
            obj.name=name;
            obj.email=email;
            obj.passwd=passwd;
            obj.access=access;
            obj.role=role;

            postData('/system/admin/store',obj);
        }

        $('.up').click(function(){
            var td = $(this).parent().parent().siblings();

            var id = $(td[1]).attr('did');
            var name = $(td[2]).attr('name');
            var email = $(td[3]).attr('email');
            var role = $(td[4]).attr('role');
            var access = $(td[5]).attr('access');

            $("input[name='id']").val(id);
            $("#update #name").val(name);
            $("#update #email").val(email);

            var role_id = $('#role option');
            for(i=0;i<role_id.length;i++){
                if(role_id[i].value==role){
                    $(role_id[i]).attr('selected',true)
                }
            }

            var access_id = $('#access option');
            for(i=0;i<access_id.length;i++){
                if(access_id[i].value==access){
                    $(access_id[i]).attr('selected',true)
                }
            }

            $("#update").modal("show");
        });

        function up() {
            var upobj = new Object();
            var pwd = $("#passwd").val();
            if(pwd==''){
                pwd=false;
            }
            upobj.id=$("input[name='id']").val();
            upobj.name= $("#name").val();
            upobj.email=$("#email").val();
            upobj.passwd=pwd
            upobj.role=$("#role").val();
            upobj.access=$("#access").val();
            postData('/system/admin/update',upobj);
        }

        function del(id) {
            var obj = new Object();
            obj.id = id;
            $.confirm({
                title: '警告',
                content: '删除后不可恢复,确定删除么?',
                type: 'orange',
                typeAnimated: false,
                buttons: {
                    omg: {
                        text: '确定',
                        btnClass: 'btn-orange',
                        action:function () {
                            postData('/system/admin/del',obj);
                        }
                    },
                    close: {
                        text: '关闭',
                    }
                }
            });
        }

    </script>
@endsection



