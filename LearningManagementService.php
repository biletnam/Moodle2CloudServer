<?php
require_once('API.php');
/**
 * LearningManagementService short summary.
 *
 * LearningManagementService description.
 *
 * @version 1.0
 * @author Crayons Team
 */
abstract class LearningManagementService extends API
{

    abstract function download($fileID);
    abstract function getFilesByCourse($courseID);

}