<?php

include_once('CloudServiceFactory.php');
$cs = CloudServiceFactory::create('DropBox');
echo '<a href="'.$cs->getAuthLink().'">Click here :)</a>';
?>