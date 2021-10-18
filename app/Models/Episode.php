<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Episode extends Model
{
    protected $guarded = ['id'];

    public function video(){
    	return $this->hasOne(Video::class);
    }

    public function item(){
    	return $this->belongsTo(Item::class);
    }

    public function scopeHasVideo(){
    	return $this->where('status',1)->whereHas('video');
    }

    public function videoSrc(){
        $episode = $this;

        $video = @$episode->video;

        $general = GeneralSetting::first();
            if (@$video->server == 0) {
            @$videoFile = asset('assets/videos/'.@$video->content);
          }elseif(@$video->server == 1){
              @$storage = Storage::disk('custom-ftp');
              @$videoFile = $general->ftp->domain.'/'.Storage::disk('custom-ftp')->url(@$video->content);
          }else{
              $videoFile = @$video->content;
          }

          return $videoFile;
    }
}
