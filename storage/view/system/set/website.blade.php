@extends('system.layout.index')

@section('contents')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs page-tabs">
                        @if(in_array('/system/set/upload',$btns))
                        <li> <a href="/system/set/upload">上传</a> </li>
                        @endif
                        <li class="active"> <a href="javascript:void(0);">网站设置</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active">

                            <form onsubmit="return false;" class="edit-form">
                                @foreach($list as $k=>$v)
                                    @if($v['key']=='website_title')
                                        <div class="form-group">
                                            <label for="upload_image_size">网站标题</label>
                                            <input class="form-control" type="text" id="website_title" name="website_title" value="{{ $list[$k]['value'] }}" placeholder="请输入网站标题" >
                                        </div>
                                    @elseif($v['key']=='website_keywords')
                                        <div class="form-group">
                                            <label for="upload_file_size">关键词</label>
                                            <input class="form-control" type="text" id="website_keywords" name="website_keywords" value="{{ $list[$k]['value'] }}" placeholder="请输入关键词" >
                                            <small class="help-block">多个用,分割</small>
                                        </div>
                                    @elseif($v['key']=='website_description')
                                        <div class="form-group">
                                            <label for="web_site_description">站点描述</label>
                                            <textarea class="form-control" id="website_description" rows="5" name="website_description" placeholder="请输入站点描述">{{ $list[$k]['value'] }}</textarea>
                                            <small class="help-block">网站描述，有利于搜索引擎抓取相关信息</small>
                                        </div>
                                    @elseif($v['key']=='blog_name')
                                        <div class="form-group">
                                            <label for="upload_file_size">博客名称</label>
                                            <input class="form-control" type="text" id="blog_name" name="blog_name" value="{{ $list[$k]['value'] }}" placeholder="请输入博客名称" >
                                        </div>
                                    @elseif($v['key']=='website_record')
                                        <div class="form-group">
                                            <label for="upload_file_size">备案号</label>
                                            <input class="form-control" type="text" id="website_record" name="website_record" value="{{ $list[$k]['value'] }}" placeholder="请输入备案号" >
                                        </div>
                                    @elseif($v['key']=='website_about')
                                        <div class="form-group">
                                            <label for="web_site_description">关于本站</label>
                                            <textarea class="form-control" id="website_about" rows="5" name="website_about" placeholder="请输入关于本站描述">{{ $list[$k]['value'] }}</textarea>
                                        </div>
                                    @elseif($v['key']=='website_copyright')
                                        <div class="form-group">
                                            <label for="upload_file_size">版权</label>
                                            <input class="form-control" type="text" id="website_copyright" name="website_copyright" value="{{ $list[$k]['value'] }}" placeholder="请输入版权" >
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
            upobj.website_title=$("input[name='website_title']").val();
            upobj.website_keywords=$("input[name='website_keywords']").val();
            upobj.website_description=$("#website_description").val();
            upobj.blog_name=$("input[name='blog_name']").val();
            upobj.website_record=$("input[name='website_record']").val();
            upobj.website_about=$("#website_about").val();
            upobj.website_copyright=$("input[name='website_copyright']").val();
            upobj.website_top_js=$("#website_top_js").val();
            upobj.website_bottom_js=$("#website_bottom_js").val();
            upobj.website_total=$("#website_total").val();
            postData('/system/set/update',upobj);
        }
    </script>
@endsection



