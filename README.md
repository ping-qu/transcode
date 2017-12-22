
### 接入概述
1、到屏趣云后台申请access_key和access_secret

2、在屏趣云后台管理创建队列，创建转码模板和回调通知

3、安装转码sdk填入access_key和access_secret

4、依据接口文档实现业务逻辑
### 转码sdk的接入
#### 安装
```
composer require ping-qu/transcode
```
#### 使用
1、添加转码任务
```
 $client = new \Pingqu\Transcode('access_key','access_secret');
 
 $client->addVideoJob();//添加视频转码任务
 $client->transcodeAgain($job_id);
```  
返回格式
{
    'message'=>'',
    'data'=>'',
    'errorId'=>'',
    'statusCode'=>0
}
statusCode状态码表述

|statusCode|描述|
|---|---|
|200|成功|
|400|access_key错误|
|401|签名失败|
|422|参数错误|
|500|内部服务器错误|

#### 回调参数
|参数|描述|
|---|---|
|job_id|转码任务id|
|output_file|输出文件|
|state|转码状态，1成功，-1失败|
|type|文件类型|
|duration|时长|
|input_file|输入文件|
### 接入概述
1、到屏趣云后台申请access_key和access_secret

2、在屏趣云后台管理创建队列，创建转码模板和回调通知

3、安装转码sdk填入access_key和access_secret

4、依据接口文档实现业务逻辑
### 转码sdk的接入
#### 安装
```
composer require ping-qu/transcode
```
#### 使用
1、添加转码任务
```
 $client = new \Pingqu\Transcode('access_key','access_secret');
 
 $client->addVideoJob();//添加视频转码任务
 $client->transcodeAgain($job_id);
```  
返回格式
{
    'message'=>'',
    'data'=>'',
    'errorId'=>'',
    'statusCode'=>0
}
statusCode状态码表述

|statusCode|描述|
|---|---|
|200|成功|
|400|access_key错误|
|401|签名失败|
|422|参数错误|
|500|内部服务器错误|

#### 回调参数
|参数|描述|
|---|---|
|job_id|转码任务id|
|output_file|输出文件|
|state|转码状态，1成功，-1失败|
|type|文件类型|
|duration|时长|
|input_file|输入文件|