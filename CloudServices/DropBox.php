<?php

/**
 * DropBox Service Class
 *
 * Has all the functions related to suport Dropbox integration
 *
 * @version 1.0
 * @author Crayons Team
 */
class DropBox extends CloudService
{
    private $auth_token;

    #region CloudService Members

    /**
     *
     * @param  $file
     */
    function upload($file)
    {
        $curl = curl_init('https://content.dropboxapi.com/2/files/upload');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->auth_token, 'Dropbox-API-Arg: '.json_encode(array('path'=>'/test.txt', 'autorename'=>true),JSON_FORCE_OBJECT), 'Content-Type: application/octet-stream'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, file_get_contents('./CloudServices/'.$file));
        $r = curl_exec($curl);
        var_dump($r);
        curl_close($curl);
    }

    /**
     * Creates a directory (has to start with / due to DropBox policies)
     * @param mixed $dir_name
     */
    function createDirectory($dir_name)
    {
        $post = array('path'=>$dir_name,'autorename'=>true);
        $curl = curl_init('https://api.dropboxapi.com/2/files/create_folder');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->auth_token, 'Content-Type: text/plain; charset=dropbox-cors-hack'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $r = curl_exec($curl);
        curl_close($curl);
    }

    #endregion

    #region API Members
    /**
     *  Uses DropBox auth code to grab a token and the acc ID from the API
     * @param  $credentials
     */
    function auth($credentials)
    {
        $curl = curl_init('https://api.dropboxapi.com/oauth2/token');
        $post = array(
            'code'=>$credentials['code'],
            'grant_type'=>'authorization_code',
            'client_id'=>'d6zcl79nsuld0ac',
            'client_secret'=>file_get_contents('./DROPBOXSECRET'),
            'redirect_uri'=>'http://localhost:11546/back.php'
            );
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CAINFO,  getcwd()."/cacert.pem");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $return = json_decode(curl_exec($curl), true);

        $this->auth_token = $return['access_token'];
        var_dump($return);
        curl_close($curl);
        return array('token'=>$return['access_token'],
            'id'=>$return['account_id']
            );
    }

    function getAuthLink(){
        return "https://www.dropbox.com/oauth2/authorize?response_type=code&client_id=d6zcl79nsuld0ac&redirect_uri=".urlencode('http://localhost:11546/back.php')."&require_role=personal&force_reapprove=true";
    }

    /**
     * 
     * @param  $token
     */
    function checkAuth($token)
    {
    }

    #endregion

    function setToken($token){
        $this->auth_token = $token;
    }
    function getToken(){
        return $this->auth_token;
    }
}