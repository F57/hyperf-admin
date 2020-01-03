@extends('admin.layout.index')
@section('css')
    <link href="/css/materialdesignicons.min.css" rel="stylesheet">
@endsection
@section('contents')

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><h4>设置权限</h4></div>
                    <div class="card-body">

                        <form action="#!" method="post">
                            <div class="form-group">
                                <label for="example-text-input">角色名称</label>
                                <input class="form-control" value="{{ $roleInfo['name'] }}" type="text" name="role-input" placeholder="角色名称" disabled="disabled">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="lyear-checkbox checkbox-primary">
                                                <input name="checkbox" type="checkbox" id="check-all">
                                                <span> 全选</span>
                                            </label>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($menuList as $v)
                                        <tr>
                                            <td>
                                                <label class="lyear-checkbox checkbox-primary">
                                                    <input name="rules[]" type="checkbox" class="checkbox-parent" dataid="id-{{ $v['id'] }}" value="{{ $v['id'] }}" @if(in_array($v['id'],$permissions)) checked="checked"@endif>
                                                    <span> {{ $v['display_name'] }}</span>
                                                </label>
                                            </td>
                                        </tr>
                                        @if(count($v['child']) != 0)
                                            @foreach($v['child'] as $vv)
                                                <tr>
                                                    <td class="p-l-20">
                                                        <label class="lyear-checkbox checkbox-primary">
                                                            <input name="rules[]" type="checkbox" class="checkbox-parent checkbox-child" dataid="id-{{ $v['id'] }}-{{ $vv['id'] }}" value="{{ $vv['id'] }}" @if(in_array($vv['id'],$permissions)) checked="checked"@endif>
                                                            <span> {{ $vv['display_name'] }}</span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                @if(count($vv['child']) != 0)
                                                    <tr>
                                                        <td class="p-l-40">
                                                            @foreach($vv['child'] as $vvv)
                                                                <label class="lyear-checkbox checkbox-primary checkbox-inline">
                                                                    <input name="rules[]" type="checkbox" class="checkbox-child" dataid="id-{{ $v['id'] }}-{{ $vv['id'] }}-{{ $vvv['id'] }}" value="{{ $vvv['id'] }}" @if(in_array($vvv['id'],$permissions)) checked="checked"@endif>
                                                                    <span> {{ $vvv['display_name'] }}</span>
                                                                </label>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-primary ajax-post" onclick="ok()">确 定</button>
                                    <button type="button" class="btn btn-default" onclick="javascript:history.back(-1);return false;">返 回</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script type="text/javascript" src="/js/chosen.jquery.min.js"></script>
    <script type="text/javascript">
        $(function(){
            //动态选择框，上下级选中状态变化
            $('input.checkbox-parent').on('change', function(){
                var dataid = $(this).attr("dataid");
                $('input[dataid^=' + dataid + '-]').prop('checked', $(this).is(':checked'));
            });
            $('input.checkbox-child').on('change', function(){
                var dataid = $(this).attr("dataid");
                dataid = dataid.substring(0, dataid.lastIndexOf("-"));
                var parent = $('input[dataid=' + dataid + ']');
                if($(this).is(':checked')){
                    parent.prop('checked', true);
                    //循环到顶级
                    while(dataid.lastIndexOf("-") != 2){
                        dataid = dataid.substring(0, dataid.lastIndexOf("-"));
                        parent = $('input[dataid=' + dataid + ']');
                        parent.prop('checked', true);
                    }
                }else{
                    //父级
                    if($('input[dataid^=' + dataid + '-]:checked').length == 0){
                        parent.prop('checked', false);
                        //循环到顶级
                        while(dataid.lastIndexOf("-") != 2){
                            dataid = dataid.substring(0, dataid.lastIndexOf("-"));
                            parent = $('input[dataid=' + dataid + ']');
                            if($('input[dataid^=' + dataid + '-]:checked').length == 0){
                                parent.prop('checked', false);
                            }
                        }
                    }
                }
            });
        });
        function ok() {
            var obj =$("input[name='rules[]']");
            var check_arr = [];
            for (var i = 0; i < obj.length; i++) {
                if (obj[i].checked)
                    check_arr.push(obj[i].value);
            }
            if(check_arr.length==0){
                lightyear.notify('权限不能为空~', 'danger', 100);
                return false;
            }
            lightyear.loading('show');
            $.ajax({
                url : "/system/role/auth?id={{ $id }}",
                type : "POST",
                data : {'ids':check_arr},
                dataType : "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success : function(result) {
                    lightyear.loading('hide');
                    if(result.code==200){
                        lightyear.notify('添加成功，页面即将自动刷新~', 'success', 5000);
                        location.reload();
                    }else{
                        var msg= result.message;
                        lightyear.notify(msg, 'danger', 100);
                    }

                },
                error:function(msg){
                    lightyear.notify('连接超时,请重试~', 'danger', 100);
                    lightyear.loading('hide');
                }
            })
        }
    </script>
@endsection