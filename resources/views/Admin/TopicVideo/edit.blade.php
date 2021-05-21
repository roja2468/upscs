@extends('Admin.app')
@section('title')
Topic Video
@endsection
@section('style')
<link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
<style type="text/css">
    .btn-circle.btn-lg {
    width: 30px !important;
    height: 30px !important;
    padding: 1px 7px !important;
    font-size: 18px;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Add Topic Video</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active">Add Topic Video</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="m-t-40" method="post" action="{{route('admin.topic.video.update',$TopicVideo->id)}}" id="edit_topic" enctype="multipart/form-data">
                    	@csrf
                        <div class="form-group m-b-40">
                            <label for="topic">Topic</label>
                            <select class="select2 m-b-10 form-control" id="topic" name="topic" data-toggle="tooltip" data-placement="bottom" title="Select Topic!">
                                <option value="">-select topic-</option>
                                @foreach($Topic as $key => $topic)
                                <option value="{{$topic->id}}" {{($TopicVideo->topic_id == $topic->id) ? 'selected' : ''}} >{{$topic->title}}</option>
                                @endforeach
                            </select>
                            <span class="bar"></span>
                            @error('topic')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('topic') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group m-b-40">
                            <label for="title">Topic Video Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title',$TopicVideo->title) }}" data-toggle="tooltip" data-placement="bottom" title="Enter Topic Video Title!">
                            <span class="bar"></span>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group m-b-40">
                            <label for="topic_video_image">Topic Video Image</label>
                            <input type="file" id="topic_video_image" data-max-file-size="10M" data-errors-position="outside" data-allowed-file-extensions="jpg jpeg gif png" name="topic_video_image" data-toggle="tooltip" data-show-remove="false" data-placement="bottom" title="Select Topic Video Image!" class="dropify" value="{{$TopicVideo->image}}" data-default-file="{{$TopicVideo->image}}"/>
                            <span class="bar"></span>
                            @error('topic_video_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('topic_video_image') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group m-b-40">
                            <label for="video_type">Video Upload Type</label>
                            <select class="select2 m-b-10 form-control" onchange="videouploadtype()" id="videoupload_type" name="videoupload_type" data-toggle="tooltip" data-placement="bottom" title="Select video upload type!">
                                <option value="">-select Video Upload TYpe-</option>
                                <option value="1">New Video</option>
                                <option value="2">Existing Video</option>
                            </select>
                            <span class="bar"></span>
                            @error('video_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('video_type') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group m-b-40">
                            <label for="video_type">Video Type</label>
                            <select class="select2 m-b-10 form-control" onchange="videotype()" id="video_type" name="video_type" data-toggle="tooltip" data-placement="bottom" title="Select video type!">
                                <option value="">- Select Video Type -</option>
                                <option value="1" {{($TopicVideo->video_type ==1) ? 'selected' : ''}}>Server Video</option>
                                <option value="2" {{($TopicVideo->video_type == 2) ? 'selected' : ''}}>Youtube Id</option>
                            </select>
                            <span class="bar"></span>
                            @error('video_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('video_type') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group m-b-40">
                            <label for="video">Topic Video File</label>
                            <div  id="youtube" style="display:none;"> 
                                <input type="text"  class="form-control" onkeyup="GetYoutubeVideo(this);" name="video" id="video" value="{{ old('video',$TopicVideo->video) }}" data-toggle="tooltip" data-placement="bottom" title="Enter Topic Video Id!">
                                <iframe width="500" class="ifram_section" style="margin-top: 10px;" height="315" src="https://www.youtube.com/embed/{{$TopicVideo->video}}" onerror="BlankIframe(this);"></iframe> 
                                <span class="bar"></span>
                            </div>
                            <div  id="server" style="display:none;">
                                <input type="file" class="form-control" name="video" id="GetserverVideo" accept="video/*" value="{{ $TopicVideo->video }}" data-toggle="tooltip" data-placement="bottom" title="Enter Topic Video Id!">
                                <video width="500" controls style="margin-top: 10px;" height="315"><source src="{{ url('/uploads/topic_video/'.$TopicVideo->video)}}" id="video_here">Your browser does not support HTML5 video.</video> 
                                <span class="bar"></span>
                            </div>
                            @error('video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('video') }}</strong>
                                </span>
                            @enderror
                        </div>
                            <input type="hidden" value="{{old('video_type',$TopicVideo->video_type)}}" name=video_typeup"/>
                            <input type="hidden" value="{{old('video',$TopicVideo->video)}}" name="sidevalueup"/>
                            
                        <div class="form-group m-b-40" id="Existing" style="display:none;">
                            <label for="topic">Existing Topic Video</label>
                            <select class="select2 m-b-10 form-control" id="videop" name="videop" data-toggle="tooltip" data-placement="bottom" title="Select Topic!"></select>
                            <span class="bar"></span>
                            @error('topic')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('topic') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group m-b-40">
                            <input type="radio" class="check" id="paid_radio" {{($TopicVideo->is_paid == 1) ? 'checked=""' : ''}}  checked="" name="is_paid" value="1">
                            <label for="paid_radio">Paid</label>
                            <input type="radio" class="check" id="free_radio" {{($TopicVideo->is_paid == 0) ? 'checked=""' : ''}} name="is_paid" value="0">
                            <label for="free_radio">Free</label>
                            @error('is_paid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('is_paid') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Submit</button>
                                            <a href="{{route('admin.topic.video.list')}}" class="btn btn-inverse">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
@endsection
@section('script')
<script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    var drEvent = $('.dropify').dropify();
    drEvent.on('dropify.beforeClear', function(event, element) {
        // return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });
    drEvent.on('dropify.afterClear', function(event, element) {
        // alert('File deleted');
    });
    drEvent.on('dropify.errors', function(event, element) {
        console.log('Has Errors');
    });
    $(document).ready(function(){
        $('#add_topic').validate({
            wrapper: "span",
            errorClass:"has-danger",
            errorPlacement: function(label, element) {
                label.addClass('help-inline');
                if (element.attr("type") == "radio") {
                    $(element).parents('.controls').append(label)
                } else if (element.attr("type") == "file") {
                    console.log(label);
                    $('.dropify-errors-container ul').append(label);
                }else {
                    label.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.control-group').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.control-group').removeClass(errorClass).addClass(validClass);
            },
            rules: {
                topic:{
                    required:true,
                },
                title:{
                    required:true,
                },
                topic_video_image:{
                    required:true,
                },
                video:{
                    required:true,
                },
                video_type:{
                    required:true,
                },
                videoupload_type:{
                    required:true,
                }
             },
            messages: {
                topic:{
                    required:"Please select topic."
                },
                topic:{
                    required:"Please enter title."
                },
                topic_video_image:{
                    required:"Please select image."
                },
                video:{
                    required:"Please enter video id."
                },
                videoupload_type:{
                    required:"Please select video upload type."
                },
                video_type:{
                    required:"Please select video type."
                }
            }
        });
    });
    function GetYoutubeVideo(ele){
        if(ele.value){
            $('.ifram_section').show();
            $('.ifram_section').attr('src','https://www.youtube.com/embed/'+ele.value);
        }
        else {
            $('.ifram_section').hide();
            $('.ifram_section').attr('src','');
        }
    }
    function BlankIframe(ele){
        $(ele).hide();
    }
    function videotype(){
        var id = $("#video_type option:selected").val(); 
        if(id == "1"){
            $('#youtube').css('display','none');
            $('#server').css('display','block');
            $('#GetserverVideo').removeAttr("disabled");
        }else if(id== "2"){
            $('#youtube').css('display','block');
            $('#server').css('display','none');
            $('#video').removeAttr("disabled");
        }else{
            $('#youtube').css('display','none');
            $('#server').css('display','none');
            $('#GetserverVideo').prop("disabled", true);
            $('#video').prop("disabled", true);
        }
    } 
    function videouploadtype(){
        var id = $("#videoupload_type option:selected").val();
        var ids = $("#video_type option:selected").val();  
        if(id == "1"){
            $('#new').css('display','block');
            $('#Existing').css('display','none');
            if(ids == "1"){
                $('#youtube').css('display','none');
                $('#server').css('display','block');
                $('#GetserverVideo').removeAttr("disabled");
            }else if(ids== "2"){
                $('#youtube').css('display','block');
                $('#server').css('display','none');
                $('#video').removeAttr("disabled");
            }else{
                $('#youtube').css('display','none');
                $('#server').css('display','none');
                $('#GetserverVideo').prop("disabled", true);
                $('#video').prop("disabled", true);
            }
        }else if(id== "2"){
            $('#new').css('display','none');
            $('#Existing').css('display','block');
            $('#youtube').css('display','none');
            $('#server').css('display','none');
        }else{
            $('#new').css('display','none');
            $('#Existing').css('display','none');
            $('#youtube').css('display','none');
            $('#server').css('display','none');
            $('#GetserverVideo').prop("disabled", true);
            $('#video').prop("disabled", true);
        }
    }
</script>
<script>
    $(document).on("change", "#GetserverVideo", function(evt){
        $('#video_here').css('diaplay','block');
        var $source = $('#video_here');
        $source[0].src = URL.createObjectURL(this.files[0]);
        $source.parent()[0].load();
    });
</script>
<script>
    $(document).ready(function() {
        videouploadtype();
        videotype();
        $("#topic").change(function(){
            $.ajax({
                method: 'POST',
                headers: {'X-CSRF-Token': Laravel.csrfToken},
                url: '/admin/topic-video/toipcvideo', 
                data: {'topic' : $("#topic option:selected").val()}, 
                success:function(data) {
                    $('select[name="videop"]').html('<option value="">-select topic-</option>');
                    if(data.status == true)
                    {
                        $('select[name="videop"]').append(data.html);
                    }
                }
            });
        })
    });
</script>
@endsection