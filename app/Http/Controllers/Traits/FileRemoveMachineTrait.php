<?php
namespace App\Http\Controllers\Traits;


use App\Models\Upload;

trait FileRemoveMachineTrait {
    public static function destroyFile($id){
        $data = Upload::where('id', $id)->first();
        $image = explode('/', $data->image);
        $audio = explode('/', $data->audio);
        $video = explode('/', $data->video);
        if($data->image){
            foreach ($image as $image_item) {
                if(file_exists(public_path('images').'/'.$image_item)){
                    unlink(public_path('images').'/'.$image_item);
                }
            }
        }

        if($data->audio){
            foreach ($audio as $audio_item) {
                if(file_exists(public_path('audio').'/'.$audio_item)){
                    unlink(public_path('audio').'/'.$audio_item);
                }
            }
        }

        if($data->video){
            foreach ($video as $video_item) {
                if(file_exists(public_path('video').'/'.$video_item)){
                    unlink(public_path('video').'/'.$video_item);
                }
            }
        }
    }

    public static function editUpdate($id, $type){
        $data = Upload::where('id', $id)->first();
        $file = explode('/', $data->$type);
        foreach ($file as $file_item) {
            if(file_exists(public_path($type).'/'.$file_item)){
                unlink(public_path($type).'/'.$file_item);
            }
        }
    }
}
