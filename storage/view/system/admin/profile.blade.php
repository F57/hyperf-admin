@extends('system.layout.index')
@section('css')
    <link href="/fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="/fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <style>
        .theme-fa{
            display: none;
        }
    </style>
@endsection
@section('contents')


    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="edit-avatar">
                            <img src="{{$users['photo']}}" class="img-avatar">
                            <div class="avatar-divider"></div>
                            <div class="edit-avatar-content">
                                <button class="btn btn-default uplo">修改头像</button>
                                <input id="input-ke-2" name="file" type="file" style="display: none">
                                    <input type="hidden" class="img" id="img" value="{{$users['photo']}}" name="img">
                            </div>
                        </div>
                        <hr>
                        <form onsubmit="return false;" class="site-form">
                            <div class="form-group">
                                <label for="nickname">昵称</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="输入您的昵称" value="{{ $users['name'] }}">
                            </div>

                            <div class="form-group">
                                <label for="email">邮箱</label>
                                <input type="text" class="form-control" name="email" id="email" value="{{ $users['email'] }}"/>
                                <small id="emailHelp" class="form-text text-muted">请保证您填写的邮箱地址是正确的。</small>
                            </div>
                            @if(in_array('/system/admin/info',$btns))
                            <button class="btn btn-block btn-primary" type="submit" name="submit" onclick="sub()">确定</button>
                            @endif
                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
@section('js')
    <script src="/fileinput/themes/explorer-fas/theme.js" type="text/javascript"></script>
    <script src="/fileinput/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="/fileinput/js/fileinput.js" type="text/javascript"></script>
    <script src="/fileinput/js/locales/zh.js" type="text/javascript"></script>
    <script src="/fileinput/themes/explorer-fa/theme.js" type="text/javascript"></script>
    <script src="/fileinput/themes/fa/theme.js"></script>
    <script>
        $(function () {
            $('form').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    img: {
                        validators: {
                            notEmpty: {
                                message: '头像不能为空'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: '邮箱地址不能为空'
                            },
                            emailAddress: {
                                message: '邮箱地址格式有误'
                            }
                        }
                    },
                    name: {
                        validators: {
                            notEmpty: {
                                message: '昵称不能为空'
                            }
                        }
                    }
                },
            });
        });


        $('.uplo').click(function () {
            $("#input-ke-2").click();
        });

        $("#input-ke-2").fileinput({
            language:'zh',
            theme: 'fa',
            uploadUrl:'/common/upload/image',
            showCaption:false,
            showPreview:false,
            showRemove:false,
            showUpload:false,
            showCancel:false,
            showClose:false,
            uploadAsync:true,
            showUploadedThumbs:false,
            uploadExtraData:{ 'x-csrf-token':$('meta[name="csrf-token"]').attr('content') },
            previewClass:'btn btn-default uplo',
            allowedFileExtensions: ['jpg', 'png','jpeg'],
        }).on("filebatchselected", function(event, files) {
            $(event.target).fileinput('upload');
        }).on("fileuploaded", function(event, data) {

            var result = data.response;
            if(result.code==200){
                lightyear.notify('头像上传成功~', 'success', 100);
                $('.img-avatar').attr('src',result.url);
                $('.img').val(result.url);
            }else{
                var msg= result.message;
                lightyear.notify(msg, 'danger', 100);
            }
        });

        function sub() {

            var username = $("input[name='name']").val();
            var email = $("input[name='email']").val();
            var img = $("input[name='img']").val();
            var obj = new Object();
            obj.name= username;
            obj.email= email;
            obj.img= img;
            postData('/system/admin/info',obj);
        }
    </script>
@endsection
