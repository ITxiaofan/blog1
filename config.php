<?php
return [
    'db'=>[
       'host'=>'127.0.0.1',
       'dbname'=>'blog' ,
       'user'=>'root',
       'pass'=>'123456',
       'charset'=>'utf8'
    ],
    'redis'=>[
        'scheme' => 'tcp',
        'host'   => '127.0.0.1',
        'port'   => 6379,
    ],
    'email'=>[
        'port'=>25,
        'host'=>'smtp.126.com',
        'name'=>'ITXIFAN.126.com',
        'pass'=>'ITXIFAN;',
        'from_email'=>'ITXIFAN.126.com',
        'from_name'=>'全栈1班'
    ]
];