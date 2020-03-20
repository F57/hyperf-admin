@extends('admin.layout.base')
@section('contents')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-toolbar clearfix">
                        <div class="toolbar-btn-action">
                            <a class="btn btn-primary m-r-5" href="#" data-toggle="modal" data-target="#create"><i class="mdi mdi-plus"></i> 新增</a>
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
                                    <th>权限</th>
                                    <th>说明</th>
                                    <th>地址</th>
                                    <th>图标</th>
                                    <th>排序</th>
                                    <th>认证类型</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($info as $v)
                                    <tr>
                                        <td pid="{{ $v->parent_id }}">
                                            <label class="lyear-checkbox checkbox-primary">
                                                <input type="checkbox" name="ids[]" value="1"><span></span>
                                            </label>
                                        </td>
                                        <td lid="{{ $v->id }}">{{ $v->id }}</td>
                                        <td name="{{ $v->name }}">{{ $v->name }}</td>
                                        <td display_name="{{ $v->display_name }}">{{ $v->display_name }}</td>
                                        <td url="{{ $v->url }}">{{ $v->url }}</td>
                                        <td icon="{{ $v->icon }}">{{ $v->icon }}</td>
                                        <td sort="{{ $v->sort }}">{{ $v->sort }}</td>
                                        <td guard_name="{{ $v->guard_name }}">{{ $v->guard_name }}</td>
                                        <td status="{{ $v->status }}">
                                            @if($v->status==0)
                                                <span class="text-success">显示</span>
                                            @else
                                                <span class="text-danger">禁用</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn-xs btn btn-info up-btn">编辑</button>
                                                <button class="btn-xs btn btn-danger" onclick="del({{ $v->id }})">删除</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @if(count($v->child) !=0)
                                        @foreach($v->child as $kk=>$vv)
                                            <tr>
                                                <td pid="{{ $vv->parent_id }}">
                                                    <label class="lyear-checkbox checkbox-primary">
                                                        <input type="checkbox" name="ids[]" value="1"><span></span>
                                                    </label>
                                                </td>
                                                <td lid="{{ $vv->id }}">{{ $vv->id }}</td>
                                                <td name="{{ $vv->name }}">--&nbsp;{{ $vv->name }}</td>
                                                <td display_name="{{ $vv->display_name }}">{{ $vv->display_name }}</td>
                                                <td url="{{ $vv->url }}">{{ $vv->url }}</td>
                                                <td icon="{{ $vv->icon }}">{{ $vv->icon }}</td>
                                                <td sort="{{ $vv->sort }}">{{ $vv->sort }}</td>
                                                <td guard_name="{{ $vv->guard_name }}">{{ $vv->guard_name }}</td>
                                                <td status="{{ $vv->status }}">
                                                    @if($vv->status==0)
                                                        <span class="text-success">显示</span>
                                                    @else
                                                        <span class="text-danger">禁用</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn-xs btn btn-info up-btn">编辑</button>
                                                        <button class="btn-xs btn btn-danger" onclick="del({{ $vv->id }})">删除</button>
                                                    </div>
                                                </td>
                                            </tr>

                                            @if(count($vv->child) !=0)
                                                @foreach($vv->child as $kkk=>$vvv)
                                                    <tr>
                                                        <td pid="{{ $vvv->parent_id }}">
                                                            <label class="lyear-checkbox checkbox-primary">
                                                                <input type="checkbox" name="ids[]" value="1"><span></span>
                                                            </label>
                                                        </td>
                                                        <td lid="{{ $vvv->id }}">{{ $vvv->id }}</td>
                                                        <td name="{{ $vvv->name }}">-----&nbsp;{{ $vvv->name }}</td>
                                                        <td display_name="{{ $vvv->display_name }}">{{ $vvv->display_name }}</td>
                                                        <td url="{{ $vvv->url }}">{{ $vvv->url }}</td>
                                                        <td icon="{{ $vvv->icon }}">{{ $vvv->icon }}</td>
                                                        <td sort="{{ $vvv->sort }}">{{ $vvv->sort }}</td>
                                                        <td guard_name="{{ $vvv->guard_name }}">{{ $vvv->guard_name }}</td>
                                                        <td status="{{ $vvv->status }}">
                                                            @if($vvv->status==0)
                                                                <span class="text-success">显示</span>
                                                            @else
                                                                <span class="text-danger">禁用</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button class="btn-xs btn btn-info up-btn">编辑</button>
                                                                <button class="btn-xs btn btn-danger" onclick="del({{ $vvv->id }})">删除</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        @endforeach
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
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
                    <h4 class="modal-title" id="myModalLabel">新增菜单</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;" class="site-form">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">父级菜单</label>
                            <select class="form-control parent_id" size="1">
                                <option value="0">无</option>
                                @foreach($info as $v)
                                    <option value="{{ $v->id }}">{{ $v->display_name }}</option>
                                    @if(count($v->child) !=0)
                                        @foreach($v->child as $kk=>$vv)
                                            <option value="{{ $vv->id }}">--{{ $vv->display_name }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">权限</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">说明</label>
                            <input type="text" class="form-control" name="display_name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">地址</label>
                            <input type="text" class="form-control" name="url">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">图标</label>
                            <input type="text" class="form-control" name="icon">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">认证类型</label>
                            <input type="text" class="form-control" name="guard_name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">排序</label>
                            <input type="text" class="form-control" name="sort" value="0">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">状态</label>
                            <select class="form-control status" size="1">
                                <option value="0">启用</option>
                                <option value="1">禁用</option>
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
                    <h4 class="modal-title" id="myModalLabel">修改菜单</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;" class="site-form">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">父级菜单</label>
                            <select class="form-control parent_id" size="1" id="parent_id">
                                <option value="0">无</option>
                                @foreach($info as $v)
                                    <option value="{{ $v->id }}">{{ $v->display_name }}</option>
                                    @if(count($v->child) !=0)
                                        @foreach($v->child as $kk=>$vv)
                                            <option value="{{ $vv->id }}">--{{ $vv->display_name }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">权限</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">说明</label>
                            <input type="text" class="form-control" name="display_name" id="display_name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">地址</label>
                            <input type="text" class="form-control" name="url" id="url">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">图标</label>
                            <input type="text" class="form-control" name="icon" id="icon">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">认证类型</label>
                            <input type="text" class="form-control" name="guard_name" id="guard_name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">排序</label>
                            <input type="text" class="form-control" name="sort" value="0" id="sort">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">状态</label>
                            <select class="form-control" size="1" id="status">
                                <option value="0">启用</option>
                                <option value="1">禁用</option>
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
            var parent_id = $(".parent_id option:selected").val();
            var name = $("input[name='name']").val();
            var display_name = $("input[name='display_name']").val();
            var url = $("input[name='url']").val();
            var icon = $("input[name='icon']").val();
            var guard_name = $("input[name='guard_name']").val();
            var sort = $("input[name='sort']").val();
            var status = $(".status option:selected").val();
            var obj = new Object();
            obj.parent_id=parent_id;
            obj.name=name;
            obj.display_name=display_name;
            obj.url=url;
            obj.icon=icon;
            obj.guard_name=guard_name;
            obj.status=status;
            obj.sort=sort;
            if(name==''){
                lightyear.notify('权限不能为空', 'danger', 100);
                return false;
            }
            if(url==''){
                lightyear.notify('地址不能为空', 'danger', 100);
                return false;
            }
            if(sort==''){
                lightyear.notify('排序不能为空', 'danger', 100);
                return false;
            }
            postData('/v1/menu/store',obj);
        }

        $('.up-btn').click(function(){
            var td = $(this).parent().parent().siblings();
            var parent_id = $(td[0]).attr('pid');
            var id = $(td[1]).attr('lid');
            var name = $(td[2]).attr('name');
            var display_name = $(td[3]).attr('display_name');
            var url = $(td[4]).attr('url');
            var icon = $(td[5]).attr('icon');
            var sort = $(td[6]).attr('sort');
            var guard_name = $(td[7]).attr('guard_name');
            var status = $(td[8]).attr('status');

            var pid = $('#parent_id option');
            for(i=0;i<pid.length;i++){
                if(pid[i].value==parent_id){
                    $(pid[i]).attr('selected',true)
                }
            }
            $("input[name='id']").val(id);
            $("#update #name").val(name);
            $("#update #display_name").val(display_name);
            $("#update #url").val(url);
            $("#update #icon").val(icon);
            $("#update #sort").val(sort);
            $("#update #guard_name").val(guard_name);

            var sta = $('#status option');
            for(i=0;i<sta.length;i++){
                if(sta[i].value==status){
                    $(sta[i]).attr('selected',true)
                }
            }
            $("#update").modal("show");
        });

        function up() {
            var upobj = new Object();
            upobj.parent_id=$("#parent_id option:selected").val();
            upobj.id=$("input[name='id']").val();
            upobj.name= $("#name").val();
            upobj.display_name=$("#display_name").val();
            upobj.url=$("#url").val();
            upobj.icon=$("#icon").val();
            upobj.guard_name=$("#guard_name").val();
            upobj.status=$("#status option:selected").val();;
            upobj.sort=$("#sort").val();
            postData('/v1/menu/update',upobj);
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
                            postData('/v1/menu/del',obj);
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