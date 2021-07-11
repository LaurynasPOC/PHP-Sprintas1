<?php
require_once 'login.php';
function delete()
{
    if (isset($_POST['delete'])) {
        $fileDelete = './' . $_GET['path'] . $_POST['delete'];

        if (is_file($fileDelete)) {
            unlink($fileDelete);
            header("Refresh: 0.1");
        }
    }
}

function create()
{
    if (isset($_POST['create'])) {
        if ($_POST['create'] != "") {
            $dirCreate = './' . $_GET['path'] . $_POST['create'];
            if (!is_dir($dirCreate))
                mkdir($dirCreate, 0777, true);
            header("Refresh: 0.1");
        }
    }
}

function download()
{
    if (isset($_POST['download'])) {
        $file = './' . $_GET["path"] . $_POST['download'];
        $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, 1, 'utf-8'));
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
}

function upload($imageFileType, $target_file, $uploadOk)
{
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
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
        if ($_FILES["fileToUpload"]["size"] > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                header('refresh: 0');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}


function logOut()
{
    if (isset($_GET['action']) == 'logout') {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
        print('Logged out!');
    }
}

function login()
{
    print '<h2 class="login">Enter Username and Password:</h2>
    <div>';

    session_start();
    $msg = '';
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        if ($_POST['username'] == 'Laurynas' && $_POST['password'] == '1234') {
            $_SESSION['logged_in'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = 'Laurynas';
            header('location: login.php');
        } else {
            $msg = 'Wrong username or password';
        }
    }

    print '</div>
    <div class="login">
       <form id="login" action="" method="post">
          <input type="text" name="username" placeholder="username = Laurynas" required autofocus></br>
          <input type="password" name="password" placeholder="password = 1234" required>
          <br>
          <button type="submit" name="login">Login</button>
       </form>
    </div>';
    echo $msg;
}
