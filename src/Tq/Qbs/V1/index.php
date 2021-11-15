<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';

$open_id = '96f07d4a346c55beccb687abbbdccb57';
$open_secret = 'c49994c7cd5b1753b1cfd48e691dc5ed';
$open_key = '48fca866adaaa042bcc02bb62450b8c5';

$service = new \Tq\Qbs\V1\Service($open_id, $open_secret, $open_key);

$res = $service->register('15951652938', 'lh', 'lh');
var_dump($res);
//$res = $service->register('17321380914', 'zx', 'zx');
//var_dump($res);


$access_token = $service->getToken('15951652938', 'lh');
$service->setToken($access_token);
var_dump($access_token);

//$stages = $service->fetchStages();
//var_dump($stages);

//$grades = $service->fetchGrades(1);
//var_dump($grades);

//$editions = $service->fetchEditions();
//var_dump($editions);

//$subjects = $service->fetchSubjects(1);
//var_dump($subjects);

//$directories = $service->fetchDirectories1(1);
//var_dump($directories);

//$directories = $service->fetchDirectories2(1, 1, 1);
//var_dump($directories);


