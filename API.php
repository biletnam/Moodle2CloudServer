<?php

/**
 * The Abstract API Class
 *
 * An abstract class for all APIs used by Moodle2Cloud
 *
 * @version 1.0
 * @author Crayons team
 */
abstract class API
{   
    public abstract function auth($credentials);
    public abstract function checkAuth($token);
}