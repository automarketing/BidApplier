<?php
$con = mysqli_connect("localhost", "star", "starstars", "Kawnain");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

 // $check_sql = "SELECT isverified from  cs_user where checkno = $verify_code";
 //        $check_result = mysqli_query($con, $check_sql) or die("<pre>$check_sql</pre>");
 //        $check_cnt = mysqli_num_rows($check_result);

 //  if($check_cnt > 0)
 // {

    $target_dir = "images/";
    $target_file = $target_dir .date("Y-m-d-h-m-s"). basename($_FILES["photo_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photo_file"]["tmp_name"]);
        $imgData = addslashes(file_get_contents($_FILES['photo_file']['tmp_name']));
        $imgtype = $check['mime'];

        if($check !== false) {
          //  echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["photo_file"]["size"] > 50000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        // if (move_uploaded_file($_FILES["photo_file"]["tmp_name"], $target_file)) {

                  $pho_sql = "Update u_subscriber set photo = '{$imgData}' where uid = $userid  ";
                //  $typ_sql = "Update cs_user set phototype = '{$imgtype}' where checkno = $verify_code ";
                  mysqli_query($con, $pho_sql);
                //  mysqli_query($con, $typ_sql);
                //  echo "The file has been uploaded.";
                  echo  "<script type='text/javascript'>
                          window.close();
                          </script>";


        // } else {
        //     echo "Sorry, there was an error uploading your file.";
        // }
           }
 // }
 // else
 // {
 //    echo "Your verification is not.";
 // }
mysqli_close($con);

?>
