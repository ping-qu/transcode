###屏趣云对外sdk转码模块
使用方法：
```$xslt
  $live_job = new \Pingqu\Transcode('access_key','access_secret');//请求屏趣云获取直播信息
  $liveData = $live_job->addLiveJob();
  $liveData = $live_job->addVideoJob();
```