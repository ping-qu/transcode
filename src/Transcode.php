<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2017/9/26
 * Time: 下午7:11
 */
namespace Pingqu;

class Transcode
{
    protected $access_key;
    protected $access_secret;
    public function __construct($access_key,$access_secret)
    {
        $this->access_key = $access_key;
        $this->access_secret = $access_secret;
    }

    public function addVideoJob($objectKeyInput, $objectKeyTarget, $type, $preset_id, $pipeline_id){
        $params = array(
            'input_file'=>$objectKeyInput,
            'output_file'=>$objectKeyTarget,
            'file_type'=>$type,
            'preset_id'=>$preset_id,
            'pipeline_id'=>$pipeline_id,
            'access_key'=>$this->access_key,
        );
        $header = array(
            'signature'=>\Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret)
        );
        $response = \Pingqu\Http\HttpHelper::curl('api.cloud.ping-qu.com/v4_1/add_video_job','POST',$params,$header);
        //$response = \Pingqu\Http\HttpHelper::curl('10.8.8.99/v4_1/upload_complete','POST',$params,$header);//
        return $response->getBody();
    }


    public function addLiveJob(){

        $params = array(
            'access_key'=>$this->access_key,

        );
        $header = array(
            'signature'=>\Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret)
        );
        //$response = \Pingqu\Http\HttpHelper::curl('yun.linyue.hznwce.com/api/livejob','POST',$params,$header);
        $response = \Pingqu\Http\HttpHelper::curl('api.cloud.ping-qu.com/api/livejob','POST',$params,$header);
        return $response->getBody();
    }
}