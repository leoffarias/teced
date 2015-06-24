<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Teced</title>    
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/interno.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>



<?php

    session_start();

    if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {

      $host = "mysql.hostinger.com.br";
      $database = "u160152407_teced";
      $user = "u160152407_leo";
      $password = "123456";

      $conn = new mysqli($host, $user, $password, $database);

      if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

      $senha=$_POST['senha'];
      $email=$_POST['email'];

      $sql = "SELECT u.id, u.senha, u.email, u.tipo FROM user u WHERE u.email = '$email'";

      $result = $conn->query($sql);

      $row = mysqli_fetch_assoc($result);

      if ($row == "") {
        echo "<p>Wrong username</p>";
      }
      else if ($row["senha"] == $senha) {
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $row["id"];
        $_SESSION['tipo'] = $row["tipo"];
        mysql_close();

        if($row["tipo"] == "aluno") {
        header("Location: http://tecedu.16mb.com/categorias");
      } else if ($row["tipo"] == "professor") {
        header("Location: http://tecedu.16mb.com/professor");
      }
        die();
      }
      else {
        echo "<p>Wrong password</p>";
      }

      
    } else {
      echo "<p>You are already logged in. To log in again, <a href='signout.php'>sign out</a>.</p>";
    }
    ?>

      
<header>

    <nav class="navbar navbar-default">
  <div class="container-fluid">

    <div class="container">
    <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">TecEd</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li><a href="http://tecedu.16mb.com/categorias">Jogos</a></li>
        <li><a href="#">Saiba mais</a></li>
        <li><a href="#" data-toggle="modal" data-target="#myModal">Entrar</a></li> 
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</div>
</nav>

<!--Caixa de login -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Entrar</h4>
      </div>
      <div class="modal-body">
        <form class="form-signin" action="professor/professor.php">
        <label for="inputEmail" class="sr-only">E-mail</label>
        <br /><input type="email" id="inputEmail" name="email" class="form-control" placeholder="E-mail" required autofocus><br />
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" id="inputPassword" name="senha" class="form-control" placeholder="Senha" required><br />
     
        <a href="contas/index.html">Ainda não possuo conta.</a><br /><br/>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" type="submit">Entrar</button>
      </div>
       </form>
    </div>
  </div>
  </header>

        <div class="container">

          
        </div>


        <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/main.js"></script>
      </body>
      </html>
