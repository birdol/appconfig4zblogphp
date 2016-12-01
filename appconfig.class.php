<?php
/****************************************************
* ZBLOGPHP Config读写辅助类
* 作者： 十五楼的鸟儿
* http://www.birdol.com/
* 2016.12.01
* Version 1.0 

* 使用方法(以appid为default举例)：
* 1、数组保存
* $appconfig=new nobird_appconfig('default');
* $appconfig->KV_Set($array);

* 2、HTTP请求直接保存
* $appconfig=new nobird_appconfig('default');
* $appconfig->KV_Request_Set('POST');

* 3、删除指定值
* $appconfig=new nobird_appconfig('default');
* $appconfig->Del($key);

* 4、删除全部
* $appconfig=new nobird_appconfig('default');
* $appconfig->DelAll();
*****************************************************/


class nobird_appconfig{
    public $appid='';
    function __construct($appid) {
      global $zbp;
      $this->appid=$appid;
    }

    public function KV_Set($array_kv) {
        global $zbp;
      if(!is_array($array_kv)){
        $arr=explode('|',$array_kv);
        $k=$arr['0'];
        $v=$arr['1'];
        $zbp->Config($this->appid)->$k = $v;
      }else{
        foreach ($array_kv as $k=>$v){
          $zbp->Config($this->appid)->$k = $v;
        }
      }
      $this->Save();
    }
    public function KV_Request_Set($type = 'REQUEST') {
        global $zbp;
        $array = &$GLOBALS[strtoupper("_$type")];
        if(count($array)>0){
          foreach ($array as $k=>$v){
              $zbp->Config($this->appid)->$k = $v;
          }
        }
      $this->Save();
    }
    
    public function Save() {
        global $zbp;
        $zbp->SaveConfig($this->appid);
    }

    public function Del($key) {
        global $zbp;
        $zbp->configs[$this->appid]->DelKey($key);
    }
    public function DelAll() {
        global $zbp;
        $zbp->configs[$this->appid]->Delete();
    }
}

