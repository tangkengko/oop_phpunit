<?php 
use Coalition\ConfigRepository;
include "ConfigRepository.php";

$config = new ConfigRepository;
$config->load('../tests/files/app.php');

var_dump($config->get('app'));

?>