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

        header("Location: http://tecedu.16mb.com/");

      } else if ($_SESSION['tipo'] == "aluno") {

        header("Location: http://tecedu.16mb.com/categorias");

      } ?>

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

      <div class="container">

        <?php

        $host = "mysql.hostinger.com.br";
        $database = "u160152407_teced";
        $user = "u160152407_leo";
        $password = "123456";

        $conn = new mysqli($host, $user, $password, $database);

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $nome=$_POST['nome'];
        $link=$_POST['link'];

        if($link[0] != 'h') {
          $link = "http://".$link;
        }

        $desc=$_POST['desc'];

        $id_prof=$_SESSION['userid'];
        $foto = $_FILES["jogoimg"];

        if($nome != "" && $link != "" && $desc != "" && $foto != "") {


         preg_match("/.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

          // Gera um nome único para a imagem
         $nome_imagem = md5(uniqid(time())) . "." . $ext[1];

         $caminho_imagem = "fotos/" . $nome_imagem;

         move_uploaded_file($foto["tmp_name"], $caminho_imagem);




         $sql = "INSERT INTO jogo (nome, link, descr, img) VALUES ('$nome', '$link', '$desc', '$nome_imagem')"; 
         if ($conn->query($sql) === TRUE) {
          $id_jogo2 = mysqli_insert_id($conn);

          $hab=$_POST['hab'];

          $sql2 = "SELECT t.id FROM tag t WHERE t.nome = '$hab' ";

          $result2 = $conn->query($sql2);

          $row2 = mysqli_fetch_assoc($result2);

        if ($row2 != "") { // Ja existe, apenas adiciona a relacao com o jogo

          $id_tag2 = $row2["id"];
          
          $sql3 = "INSERT INTO jogo_tags (id_jogo, id_tag) VALUES ('$id_jogo2', '$id_tag2')";
          
          if ($conn->query($sql3) === TRUE) {

           echo "<div class='alert alert-success' role='alert'>Jogo registrado com sucesso!</div>";

         }

        } else { // Nao existe, adiciona no bd e adiciona a relacao com o jogo

          $sql3 = "INSERT INTO tag (nome) VALUES ('$hab')";

          if ($conn->query($sql3) === TRUE) {

            $id_tag2 = mysqli_insert_id($conn);

            $sql4 = "INSERT INTO jogo_tags (id_jogo, id_tag) VALUES ('$id_jogo2', '$id_tag2')";

            if ($conn->query($sql4) === TRUE) {

             echo "<div class='alert alert-success' role='alert'>Jogo registrado com sucesso!</div>";

           }

         }

       }

     } else {
      echo "<div class='alert alert-danger' role='alert'>Houve um erro ao registrar o jogo</div>";
    }
  }


  ?>





  <div class="page-header">
    <h1>Cadastro</h1>
  </div>

  <div class="panel panel-primary">
    <div class="panel-heading panel-cadastro">
      <h2 class="panel-title">Cadastrar Planilha de Alunos</h2>
    </div>
    <div class="panel-body" style="display:none;">
      <form method="post" action="http://tecedu.16mb.com/cadastrarplanilha/index.php" enctype="multipart/form-data">
        <div class="form-group">
          <label for="exampleInputFile">Planilha</label>
          <input type="file" name="planilha" id="planilha">
          <p class="help-block">Os campos devem seguir esse formato: Nome, e-mail, senha.</p>
        </div>
        <br />
        <button type="submit" class="btn btn-success">Cadastrar</button>
      </form>

    </div>

  </div>

  <div class="panel panel-primary">
    <div class="panel-heading panel-cadastro">
      <h2 class="panel-title">Cadastrar Aluno</h2>
    </div>
    <div class="panel-body" style="display:none;">
      <p><strong>Preencha o formulário abaixo:</strong></p><br />
      <form method="post" action="http://tecedu.16mb.com/cadastraralunos/index.php">
        <div class="form-group">
          <label for="exampleInputNome1">Nome do aluno</label>
          <input type="text" class="form-control" name="nome" id="exampleInputNome1" placeholder="Nome" required>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">E-mail do aluno</label>
          <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="E-mail" required>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Senha do aluno</label>
          <input type="password" class="form-control" name="senha" id="exampleInputPassword1" placeholder="Senha" required>
        </div>

        <br />
        <button type="submit" class="btn btn-success">Cadastrar</button>
      </form>

    </div>

  </div>

  <div class="panel panel-primary">
    <div class="panel-heading panel-cadastro">
      <h2 class="panel-title">Cadastrar Jogo</h2>
    </div>
    <div class="panel-body" style="display:none;">

      <p><strong>Preencha o formulário abaixo:</strong></p><br />
      <form method="post" action="http://tecedu.16mb.com/cadastrarjogo/index.php" enctype="multipart/form-data">
        <div class="form-group">
          <label for="exampleInputNome1">Nome do jogo</label>
          <input type="text" class="form-control" name="nome" id="exampleInputNome1" placeholder="Nome" required>
        </div>
        <div class="form-group">
          <label for="exampleInputLink1">Link do jogo</label>
          <input type="text" class="form-control" name="link" id="exampleInputLink1" placeholder="Link" required>
        </div>
        <div class="form-group">
          <label for="exampleInputDesc1">Descrição do jogo</label>
          <textarea class="form-control" rows="3" id="exampleInputDesc1" name="desc" required></textarea>
        </div>
        <div class="form-group">
          <label for="exampleInputHab1">Habilidade envolvida</label>
          <input type="text" class="form-control" name="hab" id="exampleInputHab1" placeholder="Habilidade" required>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">Imagem do jogo</label>
          <input type="file" name="jogoimg" id="jogoimg">
          <!--<p class="help-block">Adicione uma imagem sobre o jogo.</p>-->
        </div>

        <br />
        <button type="submit" class="btn btn-success">Cadastrar</button>
      </form>

    </div>
  </div>



</div>


<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
