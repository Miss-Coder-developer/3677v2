<?php
namespace App\Http\Controllers\Traits;

use App\Models\Post;
use App\Models\Upload;

trait FileUpdateMachineTrait {

    private static $IMAGE = '';
    private static $AUDIO = '';
    private static $VIDEO = '';

    public static function updateFiles($request, $id) {
        $data = $request->except(['_token', '_method']);
        $item = Post::where('id', $id)->first();
        $image = explode('/',$item->image);
        $audio = explode('/',$item->audio);
        $video = explode('/',$item->video);
        $location_image = public_path('images');
        $location_audio = public_path('audio');
        $location_video = public_path('video');
        if($request->hasFile('image')){

            foreach ($image as $image_item){
                if($image_item != ''){
                    if(file_exists($location_image.'/'.$image_item)){
                        unlink($location_image.'/'.$image_item);
                    }
                }
            }
            foreach($request->image as $image_request_item) {
                $filename = trim(time() . 'image-' . $image_request_item->getClientOriginalName());
                self::$IMAGE .= $filename.'/';
                $image_request_item->move($location_image, $filename);
                $data['image'] = substr(self::$IMAGE, 0, -1);
            }
        }
        if($request->hasFile('audio')){
            foreach ($audio as $audio_item){
                if($audio_item != ''){
                    if(file_exists($location_audio.'/'.$audio_item)){
                        unlink($location_audio.'/'.$audio_item);
                    }
                }
            }
            foreach($request->audio as $audio_request_item) {
                $filename = trim(time() . 'image-' . $audio_request_item->getClientOriginalName());
                self::$AUDIO .= $filename.'/';
                $audio_request_item->move($location_audio, $filename);
                $data['audio'] = substr(self::$AUDIO, 0, -1);
            }
        }
        if($request->hasFile('video')){
            foreach ($video as $video_item){
                if($video_item != ''){
                    if(file_exists($location_video.'/'.$video_item)){
                        unlink($location_video.'/'.$video_item);
                    }
                }
            }
            foreach($request->video as $video_request_item) {
                $filename = trim(time() . 'image-' . $video_request_item->getClientOriginalName());
                self::$VIDEO .= $filename.'/';
                $video_request_item->move($location_video, $filename);
                $data['video'] = substr(self::$VIDEO, 0, -1);
            }
        }
        return $data;
    }
}
