@extends('system.layout.index')

@section('contents')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs page-tabs">
                        <li class="active"> <a href="javascript:void(0);">上传</a> </li>
                        @if(in_array('/system/set/website',$btns))
                        <li> <a href="/system/set/website">网站设置</a> </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active">

                            <form onsubmit="return false;" class="edit-form">
                                @foreach($list as $k=>$v)
                                    @if($v['key']=='upload_size')
                                        <div class="form-group">
                                            <label for="upload_size">上传大小限制</label>
                                            <input class="form-control" type="text" id="upload_size" name="upload_size" value="{{ $list[$k]['value'] }}" placeholder="请输入上传大小限制" >
                                            <small class="help-block">0为不限制大小.</small>
                                        </div>
                                    @elseif($v['key']=='upload_type')
                                        <div class="form-group">
                                            <label for="upload_file_size">上传类型限制</label>
                                            <input class="form-control" type="text" id="upload_type" name="upload_type" value="{{ $list[$k]['value'] }}" placeholder="请输入上传类型限制" >
                                            <small class="help-block">多个用,分割</small>
                                        </div>
                                    @elseif($v['key']=='upload_dir')
                                        <div class="form-group">
                                            <label for="upload_file_size">上传目录</label>
                                            <input class="form-control" type="text" id="upload_dir" name="upload_dir" value="{{ $list[$k]['value'] }}" placeholder="请输入上传目录" >
                                        </div>
                                    @else
                                    @endif
                                @endforeach
                                <div class="form-group">
                                    @if(in_array('/system/set/update',$btns))
                                    <button type="button" class="btn btn-primary m-r-5" onclick="up()">确 定</button>
                                    @endif
                                </div>
                            </form>


                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
@section('js')
    <script>
        function up() {
            var upobj = new Object();
            upobj.upload_size=$("input[name='upload_size']").val();
            upobj.upload_type=$("input[name='upload_type']").val();
            upobj.upload_dir=$("input[name='upload_dir']").val();
            postData('/system/set/update',upobj);
        }
    </script>
@endsection



