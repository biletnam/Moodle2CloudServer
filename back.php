<?php
include_once('CloudServiceFactory.php');
$cs = CloudServiceFactory::create('DropBox');
$token = $cs->auth(array('code'=>$_GET['code']));
$cs->createDirectory('zift');
$cs->upload('example.txt');
?>