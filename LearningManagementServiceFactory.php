<?php
require_once('API.php');
require_once('LearningManagementService.php');
//setting auto loading for learning management services
function LMSLoader($className) {
    if (file_exists('./LearningManagementServices/' . $className . '.php')) {
        require_once('./LearningManagementServices/'. $className . '.php');
        return true;
    }
    return false;
}

spl_autoload_register('LMSLoader');

/**
 * LearningManagementServiceFactory short summary.
 *
 * LearningManagementServiceFactory description.
 *
 * @version 1.0
 * @author Crayons Team
 */
class LearningManagementServiceFactory
{

    /**
     * creates a class with the var name and return it.
     * @param string $lms_name
     * @return LearningManagementService
     */
    public static function create($lms_name){
        if(class_exists($lms_name) && in_array('LearningManagementService', class_parents($lms_name))){
            return new $lms_name();
        }else{
            throw new BadFunctionCallException("Learning Management Service called doesn't exist.");
        }
    }
}