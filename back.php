<?php
include_once('./LearningManagementServiceFactory.php');
$lms = LearningManagementServiceFactory::create('Moodle');
include_once('CloudServiceFactory.php');
$cs = CloudServiceFactory::create('DropBox');
$token = $cs->auth(array('code'=>$_GET['code']));
$lms->auth(array('user'=>214110962,'password'=>'xxxx'));
$courses = $lms->getCourses();
foreach($courses as $course){
    $contents = $lms->getFilesByCourse($course['id']);
    $foldername = $course['shortname'];
    foreach($contents as $week){
        foreach($week['modules'] as $module){
            if($module['modplural']=='Files'){
                foreach($module['contents'] as $file){
                    $cs->upload($lms->download($file['fileurl']),'/'.$foldername.'/'.$file['filename']);
                }
            }
        }
    }
}

//$cs->upload('example.txt');
?>