@extends('Admin.app')
@section('title')
Topic Video
@endsection
@section('style')
<link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
<style type="text/css">
    .container_box{
        border: 1px solid #80808061;
        padding: 20px;
        margin-bottom: 10px;
        overflow: auto;
    }
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
            <h3 class="text-themecolor m-b-0 m-t-0">Edit Topic Video</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Topic Video</li>
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
                                <option {{($TopicVideo->topic_id == $topic->id) ? 'selected' : ''}} value="{{$topic->id}}">{{$topic->title}}</option>
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
                        <div class="form-group m-b-40" id="new">
                            <label for="video_type">Video Type</label>
                            <select class="select2 m-b-10 form-control" onchange="videotype()" id="video_type" name="video_type" data-toggle="tooltip" data-placement="bottom" title="Select video type!">
                                <option value="">-select Video Type-</option>
                                <option value="1" {{($TopicVideo->video_type ==1) ? 'selected' : ''}}>Server Video</option>
                                <option value="2" {{($TopicVideo->video_type ==2) ? 'selected' : ''}}>Youtube Id</option>
                            </select>
                            <span class="bar"></span>
                            @error('video_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('video_type') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group m-b-40">
                            <label for="video">Topic Video Id</label>
                            @if($TopicVideo->video_type == 1)
                            <div>
                                <input type="file" class="form-control" name="video" id="GetserverVideo" accept="video/*" value="{{ $TopicVideo->video }}" data-toggle="tooltip" data-placement="bottom" title="Enter Topic Video Id!">
                                <video width="500" controls style="margin-top: 10px;" height="315"><source src="{{ url('/uploads/topic_video/'.$TopicVideo->video)}}" id="video_here">Your browser does not support HTML5 video.</video> 
                                <span class="bar"></span>
                            </div>
                            @else
                            <div>
                                <input type="text"  class="form-control" onkeyup="GetYoutubeVideo(this);" name="video" id="video" value="{{ old('video',$TopicVideo->video) }}" data-toggle="tooltip" data-placement="bottom" title="Enter Topic Video Id!">
                                <iframe width="500" class="ifram_section" style="margin-top: 10px;" height="315" src="https://www.youtube.com/embed/{{$TopicVideo->video}}" onerror="BlankIframe(this);"></iframe> 
                                <span class="bar"></span>
                            </div>
                            @endif
                            @error('video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('video') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group m-b-40">
                            <input type="radio" class="check" {{($TopicVideo->is_paid == 1) ? 'checked=""' : ''}} id="paid_radio" name="is_paid" value="1">
                            <label for="paid_radio">Paid</label>
                            <input type="radio" {{($TopicVideo->is_paid == 0) ? 'checked=""' : ''}} class="check" id="free_radio"  name="is_paid" value="0">
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
        $('#edit_topic').validate({
            wrapper: "span",
            errorClass:"has-danger",
            errorPlacement: function(label, element) {
                label.addClass('help-inline');
                if (element.attr("type") == "radio") {
                    $(element).parents('.controls').append(label)
                } else {
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
                }
            },
            messages: {
                topic:{
                    required:"Please select topic."
                },
                topic:{
                    required:"Please enter title."
                }
            }
        });
    });
    function remove_add_more_document_ajax(ele,id)
    {
        var error;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-Token': Laravel.csrfToken},
                    url: '{{ route("admin.topic.document.delete") }}',
                    dataType : 'json',
                    data: {id:id},
                    success: function(response) {
                        if(response.succsess == true)
                        {
                            Swal.fire(
                              'Deleted!',
                              'Document has been deleted.',
                              'success'
                            )
                            $(ele).parent('div').parent('div').remove();
                            $('body>.tooltip').remove();
                        }
                    },
                    error: function (jqXHR, status, exception) {
                        if (jqXHR.status === 0) {
                            error = 'Not connected.\nPlease verify your network connection.';
                        } else if (jqXHR.status == 404) {
                            error = 'The requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            error = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            error = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            error = 'Time out error.';
                        } else if (exception === 'abort') {
                            error = 'Ajax request aborted.';
                        } else {
                            error = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        Swal.fire('Error!',error,'error');
                    }
                });
            }
        })
    }
    function GetYoutubeVideo(ele)
    {
        if(ele.value)
        {
            $('.ifram_section').show();
            $('.ifram_section').attr('src','https://www.youtube.com/embed/'+ele.value);
        }
        else
        {
            $('.ifram_section').hide();
            $('.ifram_section').attr('src','');
        }
    }
    function BlankIframe(ele)
    {
        $(ele).hide();
    }
</script>
<script>
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
</script>
<script>
    $(document).on("change", "#GetserverVideo", function(evt){
        $('#video_here').css('diaplay','block');
        var $source = $('#video_here');
        $source[0].src = URL.createObjectURL(this.files[0]);
        $source.parent()[0].load();
    });
</script>
@endsection
