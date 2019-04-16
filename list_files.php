<?php

$filepath = 'audio';
$recurse = true;
if (!empty($_GET['path'])) $filepath = $_GET['path'];
$ret = get_files($filepath,$recurse);
$ret['path'] = $filepath;
$json = json_encode($ret);
echo $json;

function get_files($filepath,$recurse)
{
	$filenames = array();
	$dirs = array();
	$ret = array();
	if ($handle = opendir($filepath)) {
	    while (false !== ($entry = readdir($handle))) {
	        if ($entry != "." && $entry != "..") {
	        	$fullpath = $filepath.'/'.$entry;
	            if (is_dir($fullpath)) { 
	            	if ($recurse) {
	            		$dirs[$entry] = get_files($fullpath,$recurse);
	            	}
	            	else {
	            		$dirs[] = $fullpath;
	            	}
	            }
	            else {
	            	$filenames[] = $entry;// $fullpath;
	            }
	        }
	    }
	    closedir($handle);
	}
	$ret['files'] = $filenames;
	$ret['dirs'] = $dirs;
	return($ret);
}

?>