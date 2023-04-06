<?php
include('conexao.php'); 

if(isset($_POST['login']) && isset($_POST['senha'])){
    
    if(strlen($_POST['login']) == 0 || strlen($_POST['senha']) == 0){

    } else {

        $login = $conexao->real_escape_string($_POST['login']);
        $senha = $conexao->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuario WHERE login = '$login' AND senha = '$senha'";
        $sql_query = $conexao->query($sql_code) or die ("Falha na execução do codigo SQL: ". $conexao->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {

            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)){
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: m.php");

        } else {
            echo "Verifique seu login e sua senha e tente novamente";
        }
    }
}

?>



<!doctype html>
<html lang="pt-BR">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="./css/fontawesome/fontawesome.min.css" rel="stylesheet">
    <link href="./css/fontawesome/brands.min.css" rel="stylesheet">
    <link href="./css/fontawesome/solid.min.css" rel="stylesheet">
    <link href="./css/sistema/landpage.css" rel="stylesheet">
    <link href="./css/sistema/login.css" rel="stylesheet">
</head>

<body>
    <header id="topo">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">TDS WEB 2</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php"><i class="fas fa-home"></i>&nbsp;Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-id-card"></i>&nbsp;Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="form-signin">

        <form id="formlogin"  method="POST">
            <h1 class="h3 mb-3 fw-normal">Favor logar-se</h1>
            <div  class="form-floating">
            <input type="texto" class="form-control" id="login" name="login" maxlength="10" placeholder="Login" required="required"> <label for="login">Login
                </label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="senha" name="senha" maxlength="15" placeholder="Senha"> <label for="senha">Senha</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Logar</button>
        </form>
        <p class="text-center"><a href="./conta .php">Cadastrar-se!</a></p>
       
    </main>
    <footer class="container">
        
        <p >
            <script>
                document.write(new Date().getFullYear())
            </script>
            | IMC-MASTER - O Seu Sistema de gerenciador de pesso e altura   | desenvolvido por Kaue Marlon Pavanello e Nicollas Cauã Todt
            
        </p>
    </footer>

    <script src="./js/jquery/jquery.min.js"></script>
    <script src="./js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./js/fontawesome/fontawesome.min.js"></script>
    <script src="./js/sistema/login.js"></script>
</body>

</html>