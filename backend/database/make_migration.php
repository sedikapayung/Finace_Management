<?php 

$migrationName = $argv[1] ?? 'new_migration';

$timestamp = date("Y_m_d_His");

$filename =  __DIR__ . '/migrations/'.$timestamp.'_'. $migrationName.'.sql';

$content = "-- Migration: {$migrationName}\n-- Created at :" . date('Y-m-d H:i:s')."\n\n";



file_put_contents($filename, $content);
echo ("Migrations file succesfully created : $filename")

?>