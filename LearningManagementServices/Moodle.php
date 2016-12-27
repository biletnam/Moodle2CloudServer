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
     * @param  $fileID
     */
    function download($fileID)
    {
        $link = $this->website.'/webservice/pluginfile.php'.$path;
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
        $link = $this->website.'/webservice/rest/server.php?wstoken='.$this->token.'&wsfunction=core_course_get_contents&courseid='.$courseid;
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
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
        $debug=json_decode($r, true);
        $this->token = $debug['token'];
        $this->uid=$credentials['user'];
        return $debug['token'];
    }

    function getCourses(){
        $link = $this->website.'/webservice/rest/server.php?wstoken='.$this->token.'&wsfunction=core_enrol_get_users_courses&userid='.$this->uid;

    }

    /**
     *
     * @param  $token
     */
    function checkAuth($token)
    {

    }



    #endregion
}