<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8">
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html>
<!--<![endif]-->
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>{{ $videoIntro->title == '' ? 'Your awesome VidIntra title here' : $videoIntro->title }}</title>

        <link rel="stylesheet" href="//cdn.ckeditor.com/4.7.3/standard/contents.css?t=H8DA">
        <link rel='stylesheet' href='{{asset("/css/themestrike_videointro.min.css")}}'/>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

        <style>
            .vidintro-logo-wrapper a img {
                margin-top:{{ $videoIntro->logo_margin['margin-top'] }};
                margin-right:{{ $videoIntro->logo_margin['margin-right'] }};
                margin-bottom:{{ $videoIntro->logo_margin['margin-bottom'] }};
                margin-left:{{ $videoIntro->logo_margin['margin-left'] }};
            }
            body.vidintro-body {
                background-color:{{ $videoIntro->frame_border_bg_color }};
                background-image: {{ $videoIntro->frame_border_bg_image != "" && !is_null($videoIntro->frame_border_bg_image) ? 'url('.asset('images/'.$videoIntro->frame_border_bg_image).')' : ''}};
                background-repeat: {{ $videoIntro->frame_border_bg_repeat }};
                /*background-attachment: '';*/
                background-size: {{ $videoIntro->frame_border_bg_size  }};
                background-position: {{ $videoIntro->frame_border_bg_position }};
            }
            .vidintro-bottomtext,
            .vidintro-bottomtext a{
                color: #121517;
                font-family: 'Arial, Helvetica, sans-serif';
                font-size: 12px;
            }
            .vidintro-viewport {
                border-radius: {{ $videoIntro->frame_border_radius }}px;
                    -webkit-border-radius: {{ $videoIntro->frame_border_radius }}px;
            }
            .vidintro-logo-wrapper {
                text-align: {{ $videoIntro->logo_align }};
            }
            .vidintro-skipintro-link {
                border-radius: {{ $videoIntro->skipintro_border_radius }}px;
                    -webkit-border-radius: {{ $videoIntro->skipintro_border_radius }}px;
                background-color: {{ $videoIntro->skipintro_bg_color['regular'] }};
                color: {{ $videoIntro->skipintro_font_color['regular'] }};
            }
            .vidintro-skipintro-link:hover {
                background-color: {{ $videoIntro->skipintro_bg_color['hover'] }};
                color: {{ $videoIntro->skipintro_font_color['hover'] }};
            }
            .vidintro-bottomtext {
                line-height: {{ $videoIntro->frame_border_width }}px;
            }
            .vidintro-bottomtext-left {
                left: {{ $videoIntro->frame_border_width }}px;
            }
            .vidintro-bottomtext-right {
                right: {{ $videoIntro->frame_border_width }}px;
            }
        </style>
    </head>

    <body class="vidintro-body">
        <div class="clearfix"></div>
        <input id="vidintro-width" type="hidden" value="{!! str_replace('px', '', $videoIntro->video_size_width) !!}">
        <input id="vidintro-height" type="hidden" value="{!! str_replace('px', '', $videoIntro->video_size_height) !!}">
        <input id="vidintro-videofit" type="hidden" value="{!! $videoIntro->video_fit !!}">

        @if('transparent' == $videoIntro->frame_border_bg_color) 
            <input id="vidintro-frameborderwidth" type="hidden" value="0">
        @else 
            <input id="vidintro-frameborderwidth" type="hidden" value="{{ $videoIntro->frame_border_width }}">
        @endif

        @if ( trim($videoIntro->logo_img['url']) ) 
            <div class="vidintro-logo-wrapper">
                <a href="{{ $videoIntro->url_to_redirect }}"><img src="{{ $videoIntro->logo_img['url'] }}"></a>
            </div><!-- /.vidintro-logo-wrapper -->
        @endif

        <div class="vidintro-viewport">
            @if($videoIntro->skipintro_is_enabled)
                <div class="vidintro-skipintro-wrapper">
                    <a href="{{ $videoIntro->url_to_redirect }}" class="vidintro-skipintro-link">
                        <span class="vidintro-skipintro-text">{{ $videoIntro->skipintro_text }}</span>
                    </a>
                </div><!-- /.vidintro-skipintro-wrapper -->
            @endif

            <div class="vidintro-wrapper">
                <div class="vidintro-border"></div>
                <div id="vidintro-player-main" class="vidintro-player"></div>
            </div><!-- /.vidintro-wrapper -->

            <div class="vidintro-loader"></div>
        </div><!-- /.vidintro-viewport -->

        <div class="vidintro-bottomtext-left vidintro-bottomtext">
            {!! $videoIntro->bottom_text_left !!}
        </div><!-- /.vidintro-bottomtext-left -->
        <div class="vidintro-bottomtext-right vidintro-bottomtext">
            {!! $videoIntro->bottom_text_right !!}
        </div><!-- /.vidintro-bottomtext-right -->

        <script src='{{ asset("js/jquery.jplayer.min.js?ver=2.5.0") }}'></script>
        <script src='{{ asset("js/themestrike_videointro.min.js") }}'></script>
        @if(!empty($videoIntro->video_source) && empty($videoIntro->youtube_id))
            {!! \App\VideoIntro::getSelfHostedCode($videoIntro) !!}
        @else
            {!! \App\VideoIntro::getYoutubeCode($videoIntro) !!}
        @endif
    </body>
</html>