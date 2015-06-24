<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Teced</title>    
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/interno.css">
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
                    <li><form method="get" action="http://tecedu.16mb.com/busca.php">
                    <div class="input-group" style="width:200px; padding:6px 12px;">

                      <input type="text" class="form-control" name="consulta" placeholder="Buscar jogos" style="margin-top:1px;">
                      <span class="input-group-btn">
                        <button class="btn btn-default glyphicon glyphicon-search" type="submit"></button>
                      </span>
                    </div><!-- /input-group -->
                  </form></li>

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

         /*if (!isset($_GET['consulta'])) {
          header("Location: http://tecedu.16mb.com/");
        }*/

        $host = "mysql.hostinger.com.br";
        $database = "u160152407_teced";
        $user = "u160152407_leo";
        $password = "123456";

        $conn = new mysqli($host, $user, $password, $database);

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $busca = mysqli_real_escape_string($conn, $_GET['consulta']);

// ============================================

// Registros por página
$por_pagina = 20;

// Monta a consulta MySQL para saber quantos registros serão encontrados
$condicoes = "((`nome` LIKE '%{$busca}%') OR ('%{$busca}%'))";
$sql = "SELECT COUNT(*) AS total FROM `jogo` WHERE {$condicoes}";
// Salva o valor da coluna 'total', do primeiro registro encontrado pela consulta
$query = $conn->query($sql);
while ($resultado2 = mysqli_fetch_assoc($query)) {
$total = $resultado2['total'];
}
// Calcula o máximo de paginas
$paginas =  (($total % $por_pagina) > 0) ? (int)($total / $por_pagina) + 1 : ($total / $por_pagina);

// ============================================

if (isset($_GET['pagina'])) {
  $pagina = (int)$_GET['pagina'];
} else {
  $pagina = 1;
}
$pagina = max(min($paginas, $pagina), 1);
$offset = ($pagina - 1) * $por_pagina;

// ============================================

// Monta outra consulta MySQL, agora a que fará a busca com paginação
$sql2 = "SELECT * FROM `jogo` WHERE {$condicoes} LIMIT {$offset}, {$por_pagina}";
// Executa a consulta
$query2 = $conn->query($sql2);

// ============================================

// Começa a exibição dos resultados

echo "Resultados ".min($total, ($offset + 1))." - ".min($total, ($offset + $por_pagina))." de ".$total." resultados encontrados para '".$_GET['consulta']."'";

echo "<ul>";
while($resultado3 = $query2->fetch_assoc()) {
  $nome = $resultado3['nome'];
  $link = 'http://tecedu.16mb.com/jogo/?id=' . $resultado3['id'];
  
  echo "<li>";
    echo "<a href='{$link}'>";
      echo "<h3>{$nome}</h3>";
    echo "</a>";
  echo "</li>";
}
echo "</ul><br /><br />";

// Links de paginação
// Começa a exibição dos paginadores
if ($total > 0) {
  for ($n = 1; $n <= $paginas; $n++) {
    echo "<a href='busca.php?consulta={$_GET['consulta']}&pagina={$n}'>{$n}</a>";
  }
}
        $conn->close();


        ?>

      </div>


      <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/main.js"></script>
    </body>
    </html>
