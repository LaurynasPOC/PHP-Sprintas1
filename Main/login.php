<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="all" href="./styleBrowser.css">
    <title>FileBrowser</title>
</head>
<body> 
    
<?php
    if (isset($_POST['delete'])) {
        $fileDelete = './' . $_GET['path'] . $_POST['delete'];
    
        if (is_file($fileDelete)) {
        unlink($fileDelete);
        }
    }

    if (isset($_POST['create'])) {
        if ($_POST['create'] != "") {
         $dirCreate = './' . $_GET['path'] . $_POST['create'];
            if (!is_dir($dirCreate))
                mkdir($dirCreate, 0777, true);  
        }
    }

    if(isset($_POST['download'])){
        $file='./' . $_GET["path"] . $_POST['download'];
        $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
        ob_clean();
        ob_start();
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf'); 
        header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileToDownloadEscaped)); 
        ob_end_flush();
        readfile($fileToDownloadEscaped);
        exit;
    }



    $path = "./".$_GET['path'];
    $files = array_diff(scandir($path), array("..", "."));

    $target_dir = $path;
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
  // Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
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
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      header('refresh: 0');
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}


print '<H2>Your content path is: '.$path;

 print ("<table id='files'>
 <thead>
 <tr>
 <th>Type</th>
 <th>Name</th>
 <th>Action</th>
 </tr>
 </thead>");
 print "<tbody>";
 

 foreach ($files as $fnd) {
        print('<tr>');
        print('<td>' . (is_dir($path . $fnd) ? "Directory" : "File") . '</td>');
        print('<td>' . (is_dir($path . $fnd)
            ? '<a href="' . (isset($_GET['path'])
                ? $_SERVER['REQUEST_URI'] . $fnd . '/'
                : $_SERVER['REQUEST_URI'] . '?path=' . $fnd . '/') . '">' . $fnd . '</a>'
            : $fnd)
            . '</td>');
        print('<td>'
            . (is_dir($path . $fnd)
                ? ''
                : '<form style="display: inline-block" action="" method="post">
                <input type="hidden" name="download" value=' . $fnd. '>
                <button id="download" type="submit">Download</button>
               </form>
                <form style="display: inline-block" action="" method="post">
                <input  type="hidden" name="delete" value=' . $fnd . '>
                <button id="delete" type="submit">Delete</button>
                </form>')
            . "</form></td>");
        print('</tr>');
}
print("</table>");
 print "</tbody></table>";   

?>
<button id="back" onclick="goBack()">Go Back</button>
<br>
<form action="" method="POST">
        <input type="text" name="create" placeholder="Name of new directory">
        <input type="submit" value='sukurti'>
</form>
<br>
<form id='upload' action="" method="post" enctype="multipart/form-data">
  Select image to upload:
  <br>
  <input type="file" name="fileToUpload" id="fileToUpload">
  <br>
  <input type="submit" value="Upload Image" name="submit">
</form>
<br>
<a href="index.php">Log Out</a>
<script>
function goBack() {
  window.history.back();
}
</script>
</body>
</html>