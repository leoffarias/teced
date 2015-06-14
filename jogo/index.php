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
                  <li>
                    <div class="input-group" style="width:200px; padding:6px 12px;">
                      <input type="text" class="form-control" placeholder="Buscar jogos" style="margin-top:1px;">
                      <span class="input-group-btn">
                        <button class="btn btn-default glyphicon glyphicon-search" type="button"></button>
                      </span>
                    </div><!-- /input-group -->

                  </li>
                  <li><a href="http://tecedu.16mb.com/logout/index.php">Sair</a></li>
                </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </div>
        </nav>

      </header>

      <div class="container">

        <?php
        
        session_start();

        if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {

          header("Location: http://tecedu.16mb.com/");

        }

        
        $host = "mysql.hostinger.com.br";
        $database = "u160152407_teced";
        $user = "u160152407_leo";
        $password = "123456";
        $id_prof=$_SESSION['userid'];

        $conn = new mysqli($host, $user, $password, $database);

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $id_jogo = $_GET["id"];

        $sql = "SELECT DISTINCT j.nome, j.img, j.descr, j.link FROM jogo j WHERE j.id = '$id_jogo' ";

        $result = $conn->query($sql);

        $row = mysqli_fetch_assoc($result);

        if ($row != "") {
          echo '<div class="page-header"> <h1>'.$row["nome"].'</h1> </div>';
          echo '<p class="descricao-jogo">'.$row["descr"];

          $sql2 = "SELECT t.nome, t.id FROM tag t, jogo_tags jt WHERE '$id_jogo' = jt.id_jogo AND t.id = jt.id_tag ";

          $result2 = $conn->query($sql2);

          if ($result2->num_rows > 0) {
            echo "<br /><br />Habilidades envolvidas: ";
            $col = 0;
            while($row2 = $result2->fetch_assoc()) {
              if($col == 0) {
                echo "<a href='http://tecedu.16mb.com/jogos?cat=" . $row2["id"] . "'>" . $row2["nome"]. "</a>";
                $col = 1;
              } else {
                echo ", <a href='http://tecedu.16mb.com/jogos?cat=" . $row2["id"] . "'>" .$row2["nome"] . "</a>";
              }
            }
            echo ".";
          }
          echo '<br /><br /><br /><a class="link-jogar" target="_blank" href="'.$row["link"].'" ><button type="button" class="btn btn-success btn-jogar">Jogar</button></a></p>';
          if($row['img'] != "") {
          echo "<img class='img-jogo' src='data:image/jpeg;base64,".base64_encode( $row['img'] )."' />";
        }
          
        } else {
          echo "<p>Jogo inexistente</p>";
        }
        $conn->close();


        ?>

      </div>


      <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/main.js"></script>
    </body>
    </html>
