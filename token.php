<?php
require_once('LearningManagementServiceFactory.php');
$db = mysqli_connect('localhost', 'root', '', 'moodle2cloud');
if(isset($_POST['username'])){
    $lms = LearningManagementServiceFactory::create($_POST['service']);
    $auth = $lms->auth(array('user'=>$_POST['username'],'password'=>$_POST['password']));
    $result = json_encode($auth);
    if(isset($auth['token'])){
        $checkdb = mysqli_query($db, 'SELECT COUNT(*) FROM users WHERE username='.mysqli_real_escape_string($db,$_POST['username']));
    }
}else if(isset($_POST['token'])){

}
?>