<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoIntro extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function form()
    {
        return [
            'name' => '',
            'title' => '',
            'video_source' => '',
            'youtube_id' => '',
            'action_after_end' => '',
            'url_to_rewrite' => '',
            'url_to_redirect' => '',
            'logo_img' => '',
            'skipintro_is_enabled' => false,
            'skipintro_text' => '',
            'bottom_text_left' => '',
            'bottom_text_right' => '',

            'frame_border_width' => 40,
            'frame_border_radius' => 2,
            'frame_border_bg_color' => '#FFFFFF',
            'frame_border_bg_image' => '',
            'frame_border_bg_position' => '',
            'frame_border_bg_repeat' => '',
            'frame_border_bg_size' => ''
        ];
    }

    public static function getSelfHostedCode($intro)
    {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $("#vidintro-player-main").jPlayer({
                    ready: function ()
                    {
                        $(this).jPlayer("setMedia", {
                            m4v: "<?= url('videos/'.$intro->video_source) ?>",
                            ogv: "<?= url('videos/'.$intro->video_source) ?>"
                        }).jPlayer("play");;
                    },
                    swfPath:  '<?= url("swf/Jplayer.swf") ?>',
                    supplied: "m4v, ogv",
                    volume: <?= $intro->volume / 100 ?>,
                    nativeVideoControls: {
                      ipad: /ipad/,
                      iphone: /iphone/,
                      android: /android/,
                      blackberry: /blackberry/,
                      iemobile: /iemobile/
                    },
                    <?php if ('redirect' == $intro->action_after_end) : ?>
                        ended: function()
                        { window.open("<?= $intro->url_to_redirect ?>", "_self"); }
                    <?php else : ?>
                        loop: true
                    <?php endif ?>
                });
            });
        </script>
        <?php
    }

    public static function getYoutubeCode($intro)
    {

        ?>
        <script src="//www.youtube.com/player_api"></script>
        <script>

            // create youtube player
            var player;
            function onYouTubePlayerAPIReady()
            {
                player = new YT.Player('vidintro-player-main', {
                  height: '390',
                  width: '640',
                  videoId: '<?= $intro->youtube_id ?>',
                  playerVars: {
                    controls: 0,
                    showinfo: 0 ,
                    modestbranding: 1,
                    wmode: "opaque",
                    rel: 0,
                    cc_load_policy: 3,
                    iv_load_policy : 3
                  },
                  events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                  }
                });
            }

            // autoplay video
            function onPlayerReady(event) {
                event.target.setVolume(<?= $intro->volume ?>);
                event.target.playVideo();
            }

            // when video ends
            function onPlayerStateChange(event) {        
                if(event.data === 0) {          
                    <?php if ('redirect' == $intro->action_after_end) : ?>
                        window.open("<?= $intro->url_to_redirect ?>", "_self");
                    <?php else : ?>
                        event.target.playVideo();
                    <?php endif ?>
                }
            }

        </script>
        <?php
    }
}
