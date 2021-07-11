<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" media="all" href="style.css">
  <title>FileBrowser</title>
</head>

<body>

  <?php
  require_once 'functions.php';


  $path = "./" . $_GET['path'];
  $url = $_GET['path'];
  $files = array_diff(scandir($path), array("..", "."));
  $target_dir = $path;
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  print('<table>');
  print '<tr><H2>Your content path is: ' . $url . '</tr>';
  print "<tr><br><button><a href='login.php' style='text-decoration:none;'>Back to the homepage</a><br></button></tr>";
  print('</table>');
  print("<table id='files'>
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
    print('<td>' . (is_dir($path . $fnd) ? '<a href="' . (isset($_GET['path']) ? $_SERVER['REQUEST_URI'] . $fnd . '/' : $_SERVER['REQUEST_URI'] . '?path=' . $fnd . '/') . '">' . $fnd . '</a>' : $fnd)
      . '</td>');
    print('<td>'
      . (is_dir($path . $fnd)
        ? ''
        : '<form style="display: inline-block" action="" method="post">
                <input type="hidden" name="download" value=' . $fnd . '>
                <button id="download" type="submit">Download</button>
          </form>
          <form style="display: inline-block" action="" method="post">
                <input  type="hidden" name="delete" value=' . $fnd . '>
                <button id="delete" type="submit">Delete</button>
          </form>')
      . "</td>");
    print('</tr>');
  }

  print "</tbody></table><br>";

  ?>

  <br>
  <form action="" method="POST">
    <input type="text" name="create" placeholder="Name of new directory">
    <input type="submit" value='Create'>
  </form>
  <br>
  <form id='upload' action="" method="POST" enctype="multipart/form-data">
    Select image to upload:
    <br>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br>
    <input type="submit" value="Upload Image" name="submit">
  </form>
  <br>

  <?php
  delete();
  create();
  download();
  upload($imageFileType, $target_file, $uploadOk);
  logOut();


  $arr = explode('/', $url);
  array_pop($arr);
  array_pop($arr);
  $newUrl = implode('/', $arr);

  // print '<br>' . $url;
  // print '<br>';

  // print '<br>';
  // print_r($arr);
  // print '<br> suskaldytas';

  // print_r($wlast);
  // print '<br>';

  // print 'naujasurl yra ' . $newUrl;


  ?>

  <a name='back' href="<?php print 'login.php?path=' . $newUrl . '/' ?>">Back</a>


</body>

</html>