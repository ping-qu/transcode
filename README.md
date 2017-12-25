
### 接入概述
1、到屏趣云后台申请access_key和access_secret

2、在屏趣云后台管理创建队列，创建转码模板和回调通知

3、安装转码sdk填入access_key和access_secret

4、提供回调地址，接收转码任务结果通知。依据接口文档实现业务逻辑
### 1、转码sdk的接入
#### 安装
```
composer require ping-qu/transcode
```
#### 使用
1、添加视频转码任务
```
 $client = new \Pingqu\Transcode('endpoint',access_key','access_secret');
 //endpoint填service.cloud.ping-qu.com
 
 $client->addVideoJob('objectKeyInput', 'objectKeyOutput', 'type', 'preset_id', 'pipeline_id');//添加视频转码任务
 
```  
参数说明：
|参数|描述|示例|
|---|---|---|
|objectKeyInput|输入文件|video/test.mp4|
|objectKeyOutput|输出文件|video/test.m3u8|
|type|转码类型|mp4、m3u8|
|preset_id|模板id，在屏趣云后台配置|1|
|pipeline_id|在屏趣云后台申请到的队列id|1|

返回格式
array(
    'message'=>'',
    'data'=>'',//job_id等信息
    'errorId'=>'',
    'statusCode'=>0
)
    

statusCode状态码表述

|statusCode|描述|
|---|---|
|200|成功|
|400|access_key错误|
|401|签名失败|
|422|参数错误|
|500|内部服务器错误|


2、刷新转码
```
$client = new \Pingqu\Transcode('access_key','access_secret');
$client->transcodeAgain($job_id);
```

3、添加直播转码任务
```
$client = new \Pingqu\Transcode('access_key','access_secret');
$client->addLiveJob($preset_id_array);
```
其中$preset_id_array为模板数组，如果传空数组则不转码，1为默认模板，可以在屏趣云后台创建直播转码模板

返回格式：
```
array(
    'message'=>'',
    'data'=>array(
        'push_rtmp_url'=>'',
        'play_hls_history_url'=>'',
        'sessionid'=>'',
        'pull_audio_hls_url'=>'',
        'play_hls_url'=>'',
        'description'=>'',
        'job_id'=>'',
        'play_hls_url_tc'=>array();//转码后的url数组
    )
    'errorId'=>'',
    'statusCode'=>0
)
//php示例
array(){
  ["data"]=>
  array(8) {
    ["push_rtmp_url"]=>
    string(42) "rtmp://39.108.71.241/live/vBGV1wRiGwpx3E6e"
    ["play_hls_history_url"]=>
    string(87) "http://pingqu-test.oss-cn-shenzhen.aliyuncs.com/user/live/vBGV1wRiGwpx3E6e/history.m3u8"
    ["sessionid"]=>
    string(16) "vBGV1wRiGwpx3E6e"
    ["pull_audio_hls_url"]=>
    string(72) "http://pingqu-test.oss-cn-shenzhen.aliyuncs.com/user/hls_audio/live.m3u8"
    ["play_hls_url"]=>
    string(84) "http://pingqu-test.oss-cn-shenzhen.aliyuncs.com/user/live/vBGV1wRiGwpx3E6e/live.m3u8"
    ["description"]=>
    string(21) "this is a descriptoin"
    ["job_id"]=>
    int(207)
    ["play_hls_url_tc"]=>
    array(2) {
      [0]=>
      string(84) "http://pingqu-test.oss-cn-shenzhen.aliyuncs.com/user/live/vBGV1wRiGwpx3E6e/live.m3u8"
      [1]=>
      string(92) "http://pingqu-test.oss-cn-shenzhen.aliyuncs.com/user/live/vBGV1wRiGwpx3E6e_640x360/live.m3u8"
    }
  }
  ["errorId"]=>
  string(2) "OK"
  ["statusCode"]=>
  int(200)
}
```


### 2、转码回调

请求方式：post

|参数|描述|
|---|---|
|job_id|转码任务id|
|output_file|输出文件|
|state|转码状态，1成功，-1失败|
|type|文件类型|
|duration|时长|
|input_file|输入文件|
|signature|签名|

你需要在接收回调的接口调用验证签名的方法
```
 $client = new \Pingqu\Transcode('endpoint',access_key','access_secret');
 $data = $client->getCallbackDate();
```
getCallbackData封装了回调验签

### 3、计费

屏趣云只负责转码，不负责存储转码后的文件，文件将按队列信息中填写的OSS信息上传到对应的OSS，屏趣云按转码文件流入大小收取转码费用。
![image](
http://pingqu-test.oss-cn-shenzhen.aliyuncs.com/image/QQ20171211-160614.png)
