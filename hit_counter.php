<?php
/*
Website hit counter to demonstrate StorX usage.
2021-08-28
*/

require 'StorX.php';

$hit_count = hitcounter();

echo "
<!DOCTYPE html>
<html>
	<title>Hit counter</title>
	<body>
		<p>This script demonstrates StorX usage. 
		<br>We will use the library to implement a simple website hit counter.
		</p>
		<p><i>No. visitors: <b>$hit_count</b></i></p>
	</body>
</html>
";



function hitcounter(){
	if(!file_exists("hitcounter.dat")){
		//DB file doesn't exist
		
		//create DB file
		\StorX\createFile("hitcounter.dat");
		
		//create handle object to work with the DB file
		$sx = new \StorX\Sx;
		
		//open the DB file that we just created for read+write
		$sx->openFile("hitcounter.dat", 1);
		
		//write key "hit_count" with value '0'.
		$sx->writeKey("hit_count", 0);
		$sx->closeFile();
	}

	//create handle object to work with the DB file
	$sx = new \StorX\Sx;	
	
	//open the DB file for read+write
	$sx->openFile("hitcounter.dat", 1);
	
	//save current value of hit_count from DB file in $currentCount
	$currentCount = $sx->returnKey("hit_count");
	
	//increment value of hit_count in DB file by 1
	$sx->modifyKey("hit_count", $currentCount+1);
	
	//close file, write changes to disk
	$sx->closeFile();
	
	//return the current hit count
	return $currentCount;
}