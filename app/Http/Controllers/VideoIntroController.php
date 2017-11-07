<?php

namespace App\Http\Controllers;

use App\VideoIntro;
use Illuminate\Http\Request;
use File;

class VideoIntroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except(['index', 'show']);

        $this->rules =  [
            'name' => 'required',
            'url_to_redirect' => 'required|url',
            'action_after_end' => 'required',
            'skipintro_is_enabled' => 'required',
        ];
    }

    private function getFileName($file)
    {
        return str_random(32).'.'.$file->extension();
    }

    public function index()
    {
        $user = auth()->guard('api')->user();
        $intros = $user->videoIntros()->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'video_source', 'youtube_id']);
        
        return response()
            ->json([
                'intros' => $intros
            ]);
    }

    public function create()
    {
        return response()->json(['form' => VideoIntro::form()]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if ($request->skipintro_is_enabled == 'true') {
            $this->rules['skipintro_text'] = 'required';
        } else {
            unset($this->rules['skipintro_text']);
        }

        $this->validate($request, $this->rules);

        if ($request->hasFile('logo_img')) {
            if (!$request->file('logo_img')->isValid()) {
                return abort(404, 'Image not uploaded!');
            } else {
                $filename = $this->getFileName($request->logo_img);
                $request->logo_img->move(public_path('images'), $filename);
                $input['logo_img'] = $filename;
            }
        }
        
        if ($request->hasFile('video_source')) {
            if (!$request->file('video_source')->isValid()) {
                return abort(404, 'Video not uploaded!');
            } else {
                $filename = $this->getFileName($request->video_source);
                $request->video_source->move(public_path('videos'), $filename);
                $input['video_source'] = $filename;
            }

            $input['youtube_id'] = null;
        } else {
            $input['video_source'] = null;
        }

        
        $input['skipintro_is_enabled'] = (int) $request->skipintro_is_enabled;
        $input['user_id'] = auth()->guard('api')->user()->id;

        $intro = VideoIntro::create($input);
        if (isset($intro->id)) {
            return response()
                ->json([
                    'saved' => true,
                    'id' => $intro->id,
                    'message' => 'You have successfully created a new Video Intro!'
                ]);
        }
        
        return abort(404, 'Video Intro was not created.');
    }

    public function show(VideoIntro $videoIntro)
    {
        $videoIntro->video_size = array('width' => 1280, 'height' => 720); //in pixels
        $videoIntro->video_fit = 'fill'; //options: 'fill' (fill screen) / 'fit' (fit to screen)
        $videoIntro->volume = 80; //0 - 100

        $videoIntro->logo_img = array('url' => asset('images/'.$videoIntro->logo_img));
        $videoIntro->logo_margin = array(
            'margin-top'     => '0px',
            'margin-right'   => '0px',
            'margin-bottom'  => '0px',
            'margin-left'    => '0px',
           );
        $videoIntro->logo_align = 'center'; //options: 'left' / 'center' / 'right'

        /**
         * Frame Options
         */
        $videoIntro->frame_border_width = 40; //in pixels
        $videoIntro->frame_border_radius = 2; //in pixels
        $videoIntro->frame_border_bg = array(
            'background-color' => '#FFFFFF',
            'background-image' => '',//url
            'background-repeat' => '',
            'background-attachment' => '',
            'background-position' => ''
           );

        /**
         * Skip Intro Button Options
         */
        $videoIntro->skipintro_bg_color = array('regular' => '#121517', 'hover' => '#fff');
        $videoIntro->skipintro_font_color = array('regular' => '#fff', 'hover' => '#121517');
        $videoIntro->skipintro_border_radius = 4; //in pixels

        /**
         * Bottom Text Options
         */
        $videoIntro->bottom_text_typography = array(
            'color' => "#121517",
            'font-weight' => '400',
            'font-family' => 'Arial, Helvetica, sans-serif',
            'font-size' => '12px'
        );

        return view('show')->withVideoIntro($videoIntro);
    }

    public function edit(VideoIntro $videoIntro)
    {
        return response()->json(['form' => $videoIntro]);
    }

    public function update(Request $request, VideoIntro $videoIntro)
    {
        $input = $request->except(['_method']);

        if ($request->skipintro_is_enabled == 'true') {
            $this->rules['skipintro_text'] = 'required';
        } else {
            unset($this->rules['skipintro_text']);
        }

        $this->validate($request, $this->rules);

        if ($request->hasFile('logo_img')) {
            if (!$request->file('logo_img')->isValid()) {
                return abort(404, 'Image not uploaded!');
            } else {
                $filename = $this->getFileName($request->logo_img);
                $request->logo_img->move(public_path('images'), $filename);
                $input['logo_img'] = $filename;

                // remove old image
                if (!empty($videoIntro->logo_img)) {
                    File::delete(public_path('images/'.$videoIntro->logo_img));
                }
            }
        } else {
            // remove old image
            if (!empty($videoIntro->logo_img) && empty($input['logo_img'])) {
                File::delete(public_path('images/'.$videoIntro->logo_img));
            }
        }
        
        if ($request->hasFile('video_source')) {
            if (!$request->file('video_source')->isValid()) {
                return abort(404, 'Video not uploaded!');
            } else {
                $filename = $this->getFileName($request->video_source);
                $request->video_source->move(public_path('videos'), $filename);
                $input['video_source'] = $filename;

                // remove old video
                if (!empty($videoIntro->video_source)) {
                    File::delete(public_path('videos/'.$videoIntro->video_source));
                }
            }

            $input['youtube_id'] = null;
        } else {
            if (array_key_exists("video_source", $input)) {
                if ($input['video_source'] == null || $input['video_source'] == "") {
                    $input['video_source'] = null;
                }
            }
        }

        
        $input['skipintro_is_enabled'] = (int) $request->skipintro_is_enabled;
        $input['user_id'] = auth()->guard('api')->user()->id;

        foreach ($input as $key => $value) {
            $videoIntro->$key = $value;
        }

        if ($videoIntro->save()) {
            return response()
                ->json([
                    'saved' => true,
                    'id' => $videoIntro->id,
                    'message' => 'You have successfully updated your Video Intro!'
                ]);
        }
        
        return abort(404, 'Video Intro was not updated.');
    }

    public function destroy(VideoIntro $videoIntro)
    {
        $res = $videoIntro->delete();

        return response()->json([
            'deleted' => $res
        ]);
    }
}
