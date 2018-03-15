<?php 

    $filefield='fileToUpload';
    $textfield='imageRename';

    /*
        function to return the reason for any failure
    */
    function uploaderror( $code ){ 
        switch( $code ) { 
            case UPLOAD_ERR_INI_SIZE: return "The uploaded file exceeds the upload_max_filesize directive in php.ini"; 
            case UPLOAD_ERR_FORM_SIZE: return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form"; 
            case UPLOAD_ERR_PARTIAL: return "The uploaded file was only partially uploaded"; 
            case UPLOAD_ERR_NO_FILE: return "No file was uploaded"; 
            case UPLOAD_ERR_NO_TMP_DIR: return "Missing a temporary folder"; 
            case UPLOAD_ERR_CANT_WRITE: return "Failed to write file to disk"; 
            case UPLOAD_ERR_EXTENSION: return "File upload stopped by extension"; 
            default: return "Unknown upload error";
        }
    }

    /*
        test that the required items are present in posted data
    */
    if( isset( $_FILES[ $filefield ],$_POST[ $textfield ] ) ){

        $target_dir = "uploaded_files/";
        $errors=array();

        /* set permitted file extensions - not foolproof btw */
        $allowed=array('jpg','jpeg','png','gif');

        /* get the properties of the uploaded file */
        $obj=(object)$_FILES[ $filefield ];
        $name=$obj->name;
        $tmp=$obj->tmp_name;
        $size=$obj->size;
        $error=$obj->error;
        $type=$obj->type;


        /*
            determine the new name of the file if the user supplied a new name or not
        */
        $newname = !empty( $_POST[ $textfield ] ) ? $_POST[ $textfield ] : false;
        $ext = pathinfo( $name, PATHINFO_EXTENSION );

        $name =( $newname ) ? $newname .= ".{$ext}" : $name;


        /* no errors so far, proceed with logical tests of your own */
        if( $error==UPLOAD_ERR_OK ){

            if( !in_array( $ext,$allowed ) ) $errors[]="&#xd7; ONLY JPG, JPEG, PNG & GIF FILES ARE PERMITTED";
            if( $size > 9900000 )$errors[]="&#xd7; FILE IS TOO LARGE";
            if( !getimagesize( $tmp ) )$errors[]="&#xd7; FILE IS NOT AN IMAGE";
            if( !is_uploaded_file( $tmp ) )$errors[]="&#xd7; POSSIBLE FILE UPLOAD ATTACK";


            if( empty( $errors ) ){
                /*
                    set the new file location
                */
                $targetfile = $target_dir . DIRECTORY_SEPARATOR . $name;

                /*
                    save the file
                */
                $status = move_uploaded_file( $tmp, $targetfile );

                /*
                    determine what to do if it succeeded or not
                */
                if( $status ){
                    echo '<table style="width: 486px; text-align: left; margin-left: auto; margin-right: auto; height: 308px;"

      border="5">
      <tbody>
        <tr>
          <td style="background-color: #66ff99;">
            <h1 style="text-align: center;"><span style="font-family: Futura;">Your
                picture was uploaded successfully now <em><a href="https://fb.com/nurulhuda859"

                    title="Director" target="_top">Nurul Huda</a></em> will
                replace&nbsp; or add your picture after reviewing.</span></h1>
            <div style="text-align: center;"><img src="https://beta.nvesa.cf/mp/pcr/uploaded_files/'. basename( $name ). '"

                alt="Your Picture" title="Your Uploaded Picture" style="width: 180px; height: 180px;"></div>
          </td>
        </tr>
      </tbody>
    </table>
    <h1 style="text-align: center;"><br>
    </h1>
    <h1 style="text-align: center;"><span style="color: #1123c9;"></span></h1>';
                } else {
                    exit('error');
                }
            } else {/* edited: changed commas to periods */
                exit( '<pre>'.print_r($errors,1).'</pre>' );
            }
        } else {
            exit( uploaderror( $error ) );
        }
    }
?>