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
            'slug' => '',
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
                            m4v: "<?= asset('videos/'.$intro->video_source) ?>",
                            ogv: "<?= asset('videos/'.$intro->video_source) ?>"
                        }).jPlayer("play");;
                    },
                    swfPath:  '<?= asset("swf/Jplayer.swf") ?>',
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
        <script src="http://www.youtube.com/player_api"></script>
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
                    wmode: "opaque"
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
