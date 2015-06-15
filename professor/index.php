<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teced</title>    
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css">
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

      header("Location: http://tecedu.16mb.com/");

    } ?>

<div class="pag capa-prof">
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
      <a class="navbar-brand" href="http://tecedu.16mb.com/">TecEdu</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Jogos</a></li>
        <li><a href="#">Saiba mais</a></li>
        <li><a href="http://tecedu.16mb.com/alunos">Alunos</a></li>
        <li><a href="http://tecedu.16mb.com/cadastrar">Cadastrar</a></li>
         <li><a href="http://tecedu.16mb.com/logout/index.php">Sair</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</div>
</nav>

  </header>
      <div class="page-title-prof page-title">
    <h1>TecEdu<br /><small>Desenvolva habilidades jogando</small></h1>
  </div>

  </div>
<!--
  <div class="pag destaques">
    teste
  </div>-->

    <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>