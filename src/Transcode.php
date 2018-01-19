<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2017/9/26
 * Time: 下午7:11
 */
namespace Pingqu;

use Pingqu\Exception\ApiException;

class Transcode
{
    protected $access_key;
    protected $access_secret;
    protected $url;
    private $callback_params;
    private $callbacl_url;

    public function __construct($endpoint,$access_key,$access_secret)
    {
        $this->access_key = $access_key;
        $this->access_secret = $access_secret;
        $this->url = $endpoint;
    }

    public function setCallbackParams($params){
        if (!is_string($params)){
            throw new ApiException('自定义回调参数只能是字符串类型');
        }
        $this->callback_params = $params;
        return $this;
    }


    public function setCallbackUrl($url){
        if (!is_string($url)){
            throw new ApiException('回调地址格式错误');
        }
        $this->callbacl_url = $url;
        return $this;
    }

    //添加视频转码任务
    public function addVideoJob($objectKeyInput, $objectKeyTarget, $type, $preset_id, $pipeline_id){
        $params = array(
            'input_file'=>$objectKeyInput,
            'output_file'=>$objectKeyTarget,
            'file_type'=>$type,
            'preset_id'=>$preset_id,
            'pipeline_id'=>$pipeline_id,
            'access_key'=>$this->access_key,
        );
        if (isset($this->callback_params)){
            $params['callback_params'] = $this->callback_params;
        }
        if (isset($this->callbacl_url)){
            $params['callback_url'] = $this->callbacl_url;
        }
        $header = array(
            'signature'=>\Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret)
        );
        $response = \Pingqu\Http\HttpHelper::curl($this->url.'/api/add_video_job','POST',$params,$header);
        //$response = \Pingqu\Http\HttpHelper::curl('10.8.8.99/v4_1/upload_complete','POST',$params,$header);//
        return json_decode($response->getBody(),true);
    }

    //添加直播转码任务
    public function addLiveJob($preset_id = array()){

        $params = array(
            'preset_id'=>$preset_id,
            'access_key'=>$this->access_key,
        );
        $header = array(
            'signature'=>\Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret)
        );
        //$response = \Pingqu\Http\HttpHelper::curl('yun.linyue.hznwce.com/api/livejob','POST',$params,$header);
        $response = \Pingqu\Http\HttpHelper::curl($this->url.'/api/livejob','POST',$params,$header);
        return json_decode($response->getBody(),true);
    }


    //重新转码
    public function transcodeAgain($job_id){
        $params = array(
            'job_id'=>$job_id,
            'access_key'=>$this->access_key,
        );
        $header = array(
            'signature'=>\Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret)
        );
        $response = \Pingqu\Http\HttpHelper::curl($this->url.'/api/transcode_again','POST',$params,$header);
        return json_decode($response->getBody(),true);
    }

    //开始直播
    public function startLive($stream_name){
        $params = array(
            'sessionid'=>$stream_name,
            'access_key'=>$this->access_key,
        );
        $header = array(
            'signature'=>\Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret)
        );
        //$response = \Pingqu\Http\HttpHelper::curl('yun.linyue.hznwce.com/api/transcode_again','POST',$params,$header);
        $response = \Pingqu\Http\HttpHelper::curl($this->url.'/api/start_live','POST',$params,$header);
        return json_decode($response->getBody(),true);
    }

    //暂停直播
    public function pauseLive($stream_name){
        $params = array(
            'sessionid'=>$stream_name,
            'access_key'=>$this->access_key,
        );
        $header = array(
            'signature'=>\Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret)
        );
        //$response = \Pingqu\Http\HttpHelper::curl('yun.linyue.hznwce.com/api/transcode_again','POST',$params,$header);
        $response = \Pingqu\Http\HttpHelper::curl($this->url.'/api/pause_live','POST',$params,$header);
        return json_decode($response->getBody(),true);
    }

    //停止直播
    public function stopLive($stream_name){
        $params = array(
            'sessionid'=>$stream_name,
            'access_key'=>$this->access_key,
        );
        $header = array(
            'signature'=>\Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret)
        );
        //$response = \Pingqu\Http\HttpHelper::curl('yun.linyue.hznwce.com/api/transcode_again','POST',$params,$header);
        $response = \Pingqu\Http\HttpHelper::curl($this->url.'/api/stop_live','POST',$params,$header);
        return json_decode($response->getBody(),true);
    }
    //获取推流token
    public function getToken($stream_name){
        $params = array(
            'sessionid'=>$stream_name,
            'access_key'=>$this->access_key,
        );
        $header = array(
            'signature'=>\Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret)
        );
        $response = \Pingqu\Http\HttpHelper::curl($this->url.'/api/live_token','POST',$params,$header);
        return json_decode($response->getBody(),true);
    }


    public function signature($params,$signatureData){
        $signature = \Pingqu\Auth\Signature::doSignMd5($params,$this->access_secret);
        if ($signature == $signatureData){
            return true;
        }else{
            return false;
        }
    }

    public function getCallbackData(){
        $data = $_POST;
        $signatureData = $data['signature'];
        unset($data['signature']);
        $signature = \Pingqu\Auth\Signature::doSignMd5($data,$this->access_secret);
        if ($signature == $signatureData){
            return $data;
        }else{
            throw new ApiException('签名失败');
        }
    }
}