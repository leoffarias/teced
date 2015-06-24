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
                  <li><a href="http://tecedu.16mb.com/categorias">Jogos</a></li>
                  <li>
                    <form method="get" action="http://tecedu.16mb.com/busca.php">
                    <div class="input-group" style="width:200px; padding:6px 12px;">

                      <input type="text" class="form-control" name="consulta" placeholder="Buscar jogos" style="margin-top:1px;">
                      <span class="input-group-btn">
                        <button class="btn btn-default glyphicon glyphicon-search" type="submit"></button>
                      </span>
                    </div><!-- /input-group -->
                  </form>

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

        $id_tag = $_GET["cat"];

        $sql2 = "SELECT t.nome FROM tag t WHERE t.id = '$id_tag'";

        $result2 = $conn->query($sql2);

        $row2 = mysqli_fetch_assoc($result2);

        echo '<div class="page-header"> <h1>Jogos - '.$row2["nome"].'</h1> </div>';

        $sql = "SELECT DISTINCT j.id, j.nome, j.img FROM jogo j, jogo_tags jt WHERE j.id = jt.id_jogo AND jt.id_tag = '$id_tag' ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

          $col = 1;
          echo '<table class="table categorias">';

          while($row = $result->fetch_assoc()) {
            if($col == 1) {
              echo "<tr> <td> <a href='http://tecedu.16mb.com/jogo?id=". $row["id"] . "'><p>". $row["nome"] ."</p>";

              if ($row['img'] != "") { echo "<img src='http://tecedu.16mb.com/cadastrarjogo/fotos/".$row['img']."' /> </a></td>"; }
              else {
                echo "</a></td>";
              }
              $col = 2;
            } else {
              echo "<td><a href='http://tecedu.16mb.com/jogo?id=". $row["id"] . "'><p>" . $row["nome"] . "</p>";
              if ($row['img'] != "") {
                echo "<img src='http://tecedu.16mb.com/cadastrarjogo/fotos/".$row['img']."' /> </a></td></tr>";
              } else {
                echo "</a></td></tr>";
              }
              $col = 1;
            }
          }
          if($col == 1) {
            echo "</tr>";
          }
          echo '</table>';
        } else {
          echo "<p>Não há jogos registrados nesta categoria no momento.</p>";
        }
        $conn->close();


        ?>

      </div>


      <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/main.js"></script>
    </body>
    </html>
