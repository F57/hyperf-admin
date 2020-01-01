@extends('admin.layout.index')

@section('contents')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs page-tabs">
                        <li class="active"> <a href="javascript:void(0);">上传</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active">

                            <form onsubmit="return false;" class="edit-form">
                                @foreach($list as $k=>$v)
                                    @if($v['key']=='img_upload_size')
                                        <div class="form-group">
                                            <label for="upload_image_size">图片上传大小限制</label>
                                            <input class="form-control" type="text" id="upload_image_size" name="upload_image_size" value="{{ $list[$k]['value'] }}" placeholder="请输入图片上传大小限制" >
                                            <small class="help-block">0为不限制大小.</small>
                                        </div>
                                    @elseif($v['key']=='img_upload_type')
                                        <div class="form-group">
                                            <label for="upload_file_size">图片上传类型限制</label>
                                            <input class="form-control" type="text" id="upload_image_type" name="upload_image_type" value="{{ $list[$k]['value'] }}" placeholder="请输入图片上传类型限制" >
                                            <small class="help-block">多个用,分割</small>
                                        </div>
                                    @else
                                    @endif
                                @endforeach
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary m-r-5" onclick="up()">确 定</button>
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
            upobj.img_upload_size=$("input[name='upload_image_size']").val();
            upobj.img_upload_type=$("input[name='upload_image_type']").val();
            postData('/system/set/update',upobj);
        }
    </script>
@endsection



