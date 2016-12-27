<?php

/**
 * CloudService short summary.
 *
 * CloudService description.
 *
 * @version 1.0
 * @author sauda
 */
abstract class CloudService extends API
{
    abstract function upload($file, $path);
    abstract function createDirectory($dir_name);
}