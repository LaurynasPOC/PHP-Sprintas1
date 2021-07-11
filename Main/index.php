<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Document</title>
</head>

<body><?php
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

      ?>
</body>

</html>