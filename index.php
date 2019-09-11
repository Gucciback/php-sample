<?php
ini_set('max_execution_time', 6000);
ini_set('memory_limit', -1);
require_once 'vendor/autoload.php';

$db = new \some\Mysql('fotostrana');

$counter = new \some\Counter($db);

print_r($counter->getResults());

echo xdebug_time_index();