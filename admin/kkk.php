<?php
//  echo date('y-m-d h-i-s',time('-1day'));
// INSERT INTO FROM lamp  VALUES(,,'张三',23,1,'php班');
// UPDATE lamp SET classid=Android where id='12'; 


include '../public/Config/config.php';
include './Model/Model.class.php';
 $mo = new Model('user_copy');
 $data['name']= '11111';
 $data['level']= '0';
 $data['id']=2;
 var_dump($data);
 $molist = $mo->update($data);
 // var_dump($molist);
 echo $mo->sql;
