<?php
require_once('LearningManagementService.php');

/**
 * moodle short summary.
 *
 * moodle description.
 *
 * @version 1.0
 * @author Crayons Team
 */
class Moodle extends LearningManagementService
{
    var $token;
    var $website = 'https://lms.psu.edu.sa';
    var $uid;

    #region LearningManagementService Members

    /**
     *
     * @param  $filePATH
     */
    function download($filePATH)
    {
        $link = $filePATH.'&token='.$this->token;
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
        return curl_exec($curl);
    }

    /**
     *
     * @param  $courseID
     */
    function getFilesByCourse($courseID)
    {
        $link = $this->website.'/webservice/rest/server.php?moodlewsrestformat=json&wstoken='.$this->token.'&wsfunction=core_course_get_contents&courseid='.$courseID;
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
        $r = curl_exec($curl);
        return json_decode($r, true);
    }

    #endregion

    #region API Members
    /**
     *
     * @param  $credentials
     */
    function auth($credentials)
    {
        $curl = curl_init($this->website.'/login/token.php?username='.urlencode($credentials['user']).'&password='.urlencode($credentials['password']).'&service=moodle_mobile_app');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $r = curl_exec($curl);
        $info=json_decode($r, true);
        if(isset($info['token'])){
            $this->token = $info['token'];
            $return = array('token'=>$this->token);
        }else{
            $return = array(0=>0);
        }
        curl_close($curl);
        $link = $this->website.'/webservice/rest/server.php?moodlewsrestformat=json';
        $post = array('wstoken'=>$this->token,'wsfunction'=>'core_webservice_get_site_info');
        $curl = curl_init($link);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
        $r = json_decode(curl_exec($curl), true);
        $this->uid=$r['userid'];
        return $return;
    }

    function getCourses(){
        $link = $this->website.'/webservice/rest/server.php?moodlewsrestformat=json';
        $post = array('userid'=>$this->uid,'wstoken'=>$this->token,'wsfunction'=>'core_enrol_get_users_courses');
        $curl = curl_init($link);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
        $r = curl_exec($curl);
        return json_decode($r, true);
    }

    /**
     *
     * @param  $token
     */
    function checkAuth($token)
    {
        $link = $this->website.'/webservice/rest/server.php?moodlewsrestformat=json';
        $post = array('wstoken'=>$token,'wsfunction'=>'core_webservice_get_site_info');
        $curl = curl_init($link);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
        $r = json_decode(curl_exec($curl), true);
        if(isset($r['userid'])){
            $this->uid=$r['userid'];
            return true;
        }else{

        }
    }



    #endregion
}