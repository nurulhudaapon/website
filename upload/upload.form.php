<?php

// filename: upload.form.php

// first let's set some variables

// make a note of the current working directory relative to root.
$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);

// make a note of the location of the upload handler
$uploadHandler = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.processor.php';

// set a max file size for the html upload form
$max_file_size = 90000000; // size in bytes

// now echo the html page
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
		
		<title>Picture Upload</title>
	
	</head>
	
	<body>
	
	<form id="Upload" action="<?php echo $uploadHandler ?>" enctype="multipart/form-data" method="post">
	
		<h1>Upload Your Picture in Square Size</h1>
		
		
		<p>
		<label for="imageRename">Member ID:</label>
		<input type =  "text" name = "imageRename">
        </p>
		
		
		<p>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>">
		</p>
		
		
		
		
		<p>
			<label for="file">Picture:</label>
			<input id="file" type="file" name="fileToUpload">
		</p>
				
		<p>
			<label for="submit">Upload</label>
			<input id="submit" type="submit" name="submit" value="Upload">
		</p>
	
	</form>
	
	
	</body>

</html>