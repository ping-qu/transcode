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
    protected $server_id;
    protected $sign;
    public function __construct($server_id,$sign)
    {
        $this->server_id = $server_id;
        $this->sign = $sign;
    }

    public function addVideoJob($objectKeyInput, $objectKeyTarget, $type, $preset_id, $pipeline_id){
        $params = array(
            'input_file'=>$objectKeyInput,
            'output_file'=>$objectKeyTarget,
            'file_type'=>$type,
            'preset_id'=>$preset_id,
            'pipeline'=>$pipeline_id,
            'server_id'=>$this->server_id,
            'sign'=>$this->sign,
        );
        $response = \Pingqu\Http\HttpHelper::curl('api.cloud.ping-qu.com/v4_1/upload_complete','POST',$params);
        return $response;
    }


    public function addLiveJob(){
        $params = array(
            'server_id'=>$this->server_id,
            'sign'=>$this->sign,
        );
        $response = \Pingqu\Http\HttpHelper::curl('api.cloud.ping-qu.com/api/livejob','POST',$params);
        return $response;
    }
}