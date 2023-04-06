<?php
session_start();
require_once("conexao.php");

$nome = '';
$email = '';
$logi = '';
$senha = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['nome'])){
        $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    }

    if(isset($_POST['email'])){
        $email =  mysqli_real_escape_string($conexao, $_POST['email']);
    }

    if(isset($_POST['login'])){
        $logi =  mysqli_real_escape_string($conexao, $_POST['login']);
    }
    
    if(isset($_POST['senha'])){
        $senha =  mysqli_real_escape_string($conexao, $_POST['senha']);
    }

    $sql = "SELECT email FROM usuario WHERE email = '$email'";
    $verificarMail = mysqli_query($conexao, $sql);
    $count = mysqli_num_rows($verificarMail);

<<<<<<< HEAD
    if($count > 0 ){ 
        echo "login já existente";
=======
    if($ver > 0 ){ 

        echo " lopgin já existente ";
>>>>>>> fa91a928fe01f659c75672ce15c8ec006f206398
    } else{
        $sql = "INSERT INTO usuario (nome, email, login, senha) VALUES ('$nome','$email', '$logi',  '$senha')";
    
        if (mysqli_query($conexao, $sql)) {
            echo "Dados inseridos com sucesso!";
        } else {
            echo "Erro ao inserir os dados: " . mysqli_error($conexao);
        }

        header("Location: index.php");

        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;
        $_SESSION['login'] = $logi;
        $_SESSION['senha'] = $senha;

        mysqli_close($conexao);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  
  <!-- CSS -->
  <link rel="stylesheet" href="./css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="./css/fontawesome/fontawesome.min.css">
  <link rel="stylesheet" href="./css/fontawesome/brands.min.css">
  <link rel="stylesheet" href="./css/fontawesome/solid.min.css">
  <link rel="stylesheet" href="./css/sistema/landpage.css">
  <link rel="stylesheet" href="./css/sistema/cadastro.css">
</head>

<body>
  <header id="topo">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">IMC-MASTER</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">
                <i class="fas fa-home"></i>&nbsp;Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">
                <i class="fas fa-id-card"></i>&nbsp;Login
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class="form-signin">
    <h4>Cadastro inicial do usuário</h4>
    <form id="usuario_cadastro" method="POST">
      <div class="form-floating">
        <label for="email" class="col-sm-2 col-form-label col-form-label">E-mail</label>
        <div>
          <input type="email" class="form-control form-control" maxlength="100" id="email" name="email">
        </div>
      </div>
      <div class="form-floating">
        <label for="nome" class="col-sm-2 col-form-label col-form-label">Nome</label>
        <div>
          <input type="text" class="form-control form-control" maxlength="50" id="nome" name="nome" autofocus>
        </div>
      </div>
      <div class="form-floating">
        <label for="login" class="col-sm-2 col-form-label col-form-label">Login</label>
        <div>
          <input type="text" class="form-control form-control" maxlength="15" id="login" name="login">
        </div>
      </div>
      <div class="form-floating">
        <label for="senha" class="col-sm-2 col-form-label col-form-label">Senha</label>
        <div>
          <input type="password" class="form-control form-control" maxlength="10" id="senha" name="senha">
        </div>
      </div>
      <button type="submit" class="btn btn-primary" id="botao_cadastrar">Cadastrar</button>
      <button type="reset" class="btn btn-secondary" id="botao_limpar">Limpar</button>
    </form>

 
</main>

<footer class="container">
    <p>
        &copy; <script>
            document.write(new Date().getFullYear())
        </script>
      | IMC-MASTER - O Seu Sistema de gerenciador de pesso e altura   | desenvolvido por Kaue Marlon Pavanello e Nicollas Cauã Todt
        <a href="https://www.youtube.com/channel/UCUeidwLoy7YK4kEeuq2sPgw" target="_blank">Peregrino de TI</a>
    </p>
</footer>

<script src="./js/jquery/jquery.min.js"></script>
<script src="./js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="./js/fontawesome/fontawesome.min.js"></script>
<script src="./js/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="./js/sistema/cadastro.js"></script>

          