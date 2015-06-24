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

      <div class="jumbotron jumb-categorias">
      </div>

      <div class="container">

        <div class="page-header">
          <h1>Categorias</h1>
        </div>

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

        $sql = "SELECT DISTINCT t.id, t.nome FROM tag t, jogo_tags jt WHERE t.id = jt.id_tag GROUP BY jt.id_tag ORDER BY COUNT(*) DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

          $col = 1;
          echo '<table class="table table-condensed categorias">';

          while($row = $result->fetch_assoc()) {
            if($col == 1) {
              echo "<tr> <td><a href='http://tecedu.16mb.com/jogos?cat=" . $row["id"] . "'>" . $row["nome"] . "</a></td>";
              $col = 2;
            } else {
              echo "<td><a href='http://tecedu.16mb.com/jogos?cat=" . $row["id"] . "'>" . $row["nome"] . "</td> </tr>";
              $col = 1;
            }
          }
          if($col == 1) {
            echo "</tr>";
          }
          echo '</table>';
        } else {
          echo "<p>Não há categorias registradas no momento.</p>";
        }
        $conn->close();


        ?>

      </div>


      <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/main.js"></script>
    </body>
    </html>
