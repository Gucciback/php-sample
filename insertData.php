<?php
ini_set('max_execution_time', 6000);
ini_set('memory_limit', -1);
//ini_set('xdebug.profiler_enable_trigger' , 1);
//ini_set('xdebug.profiler_output_dir', 'C:\Users\Professional\PhpstormProjects\fotostrana\logs\profiler');
require_once 'vendor/autoload.php';

$db = new \some\Mysql('fotostrana');
$q = $db->prepare("SHOW VARIABLES LIKE 'max_allowed_packet'");
$q->execute();
$vars = $q->fetch(PDO::FETCH_ASSOC);

$objects_count = 1001;
$every = 1000;
$packet = [];
foreach(some\Dummy::generate($objects_count) as $k=>$v){
    if(($k !== 0 && $k%$every === 0) || $k === ($objects_count - 1)){
       $ins = $db->prepare("INSERT INTO `users` (`name`,`gender`,`email`) VALUES ".implode(",\n", $packet).";");
       $ins->execute();
       $packet = [];
    }
    $row = $v->getObj();
    $packet[] = "('{$row['name']}', {$row['gender']}, '{$row['email']}')";
}

echo "memory (byte): ", memory_get_peak_usage(true);