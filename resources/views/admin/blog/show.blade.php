@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Blog Details
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/custom_css/blog.css') }}" />
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>{!! $blog->title!!}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-fw fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li>Blog</li>
            <li class="active">Blog Details</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <!--main content-->
        <div class="row">
            <div class="col-sm-11 col-md-12 col-full-width-right">
                <div class="blog-detail-image mrg_btm15">
                    @if(!empty($blog->image))
                        <img src="{{URL::to('uploads/blog/'.$blog->image)}}" class="img-responsive" alt="Image">
                    @endif
                </div>
                <!-- /.blog-detail-image -->
                <div class="the-box no-border blog-detail-content">
                    <p>
                        <span class="label label-danger square">{!! $blog->created_at!!}</span>
                    </p>
                    <p class="text-justify">
                        {!! $blog->content !!}
                    </p>
                    <p><strong>Tags:</strong> {!! $blog->tagList !!}</p>
                    <hr>
                    <p>
                        <span class="label label-success square">COMMENTS</span>
                    </p>
                    @if(!empty($comments))
                        <ul class="media-list media-sm media-dotted recent-post">
                            @foreach($comments as $comment)
                                <li class="media">
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="{!! $comment->website !!}">{!! $comment->name !!}</a>
                                        </h4>
                                        <p>
                                            {!! $comment->comment!!}
                                        </p>
                                        <p class="text-danger">
                                            <small> {!! $comment->created_at!!}</small>
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <hr>
                    <p>
                        <span class="label label-info square">LEAVE A COMMENT</span>
                    </p>
                    {!! Form::open(array('url' => URL::to('admin/blog/'.$blog->id.'/storecomment'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::text('name', null, array('class' => 'form-control input-lg','required' => 'required', 'placeholder'=>'Your name')) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::text('email', null, array('class' => 'form-control input-lg','required' => 'required', 'placeholder'=>'Your email')) !!}
                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
                        {!! Form::text('website', null, array('class' => 'form-control input-lg', 'placeholder'=>'Your website')) !!}
                        <span class="help-block">{{ $errors->first('website', ':message') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
                        {!! Form::textarea('comment', null, array('class' => 'form-control input-lg no-resize','required' => 'required', 'style'=>'height: 200px', 'placeholder'=>'Your comment')) !!}
                        <span class="help-block">{{ $errors->first('comment', ':message') }}</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-md"><i class="fa fa-comment"></i>
                            Send comment
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /the.box .no-border --> </div>
            <!-- /.col-sm-9 --></div>
        <!--main content ends-->
    </section>
@stop
@section('footer_scripts')
    <script>
        $('img').addClass('img-responsive');
    </script>
@stop