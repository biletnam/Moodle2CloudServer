<?php
require_once('API.php');
require_once('CloudService.php');
//setting auto loading for cloud services
function __autoload($className) {
    if (file_exists('./CloudServices/' . $className . '.php')) {
        require_once('./CloudServices/'. $className . '.php');
        return true;
    }
    return false;
}
/**
 * A factory method for creating a cloud service object.
 *
 * gets cloud service name
 *
 * @version 1.0
 * @author Crayons team
 */
class CloudServiceFactory
{

    /**
     * creates a class with the var name and return it.
     * @param string $cs_name
     * @return CloudService
     */
    public static function create($cs_name){
        if(class_exists($cs_name) &&in_array('CloudService', class_parents($cs_name))){
            return new $cs_name();
        }else{
            throw new BadFunctionCallException("Cloud Service called doesn't exist.");
        }
    }
}