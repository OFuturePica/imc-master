<?php
session_start();

?>
<?php
require_once("conexao.php");

$nome = '';
$email = '';
$logi = '';
$senha = '';

if($_SERVER['REQUEST_METHOD'] == 'post'){

    if(insset($_POST_post['nome'])){
        $nome =  mysqli_real_escape_string($conexao, $_POST['nome']);
    }

    if(insset($_POST_post['email'])){
        $email =  mysqli_real_escape_string($conexao, $_POST['email']);
    }

    if(insset($_post['login'])){
        $login =  mysqli_real_escape_string($conexao, $_POST['login']);
    }
    
    if(insset($_post['senha'])){
        $senha =  mysqli_real_escape_string($conexao, $_POST['senha']);
    }

    $sql = "SELECT login FROM usuario WHERE email = '$login' ";
    $verifiLogin = mysqli_query($conexao, $sql);
    $ver =  mysqli_num_rows($verifiLogin);

    if($ver > 0 ){ ;

        echo = " lopgin já existente ";
    } else{
        $sql = "INSERT INTO usuario (nome, email, logi, senha) VALUES ('$nome','$email', '$logi',  '$senha')";
    }

    if (mysqli_query($conexao, $sql)) {
        echo "Dados inseridos com sucesso!";
    } else {
        echo "Erro ao inserir os dados: " . mysqli_error($conexao);
    }

    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;
    $_SESSION['login'] = $logi;
    $_SESSION['senha'] = $senha;

 mysqli_close($conexao);

}


?>

<!doctype html>
<html lang="pt-BR">

<head>
    <title>Login</title>
    <!-- Required meta tags --> b
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="./css/fontawesome/fontawesome.min.css" rel="stylesheet">
    <link href="./css/fontawesome/brands.min.css" rel="stylesheet">
    <link href="./css/fontawesome/solid.min.css" rel="stylesheet">
    <link href="./css/sistema/landpage.css" rel="stylesheet">
    <link href="./css/sistema/cadastro.css" rel="stylesheet">
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
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php"><i class="fas fa-home"></i>&nbsp;Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-id-card"></i>&nbsp;Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="form-signin">
    <?php
        if (isset($_SESSION["erros"])) {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
            echo "<button type='button' class='btn-close btn-sm' data-bs-dismiss='alert'
                aria-label='Close'></button>";
            foreach ($_SESSION["erros"] as $chave => $valor) {
                echo $valor . "<br>";
            }
            echo "</div>";
        }
        unset($_SESSION["erros"]);
        ?>
       
        <h4>Cadastro inicial do usuário</h4>
        <form id="usuario_cadastro" action="conta .php" method="post">
          <div class="form-floating">
              <label for="email" class="col-sm-2 col-form-label col-form-label">E-mail</label>
              <div >
                  <input type="email" class="form-control form-control" maxlength="100" id="email" name="email" value="<?php echo isset($_SESSION['dados']['email']) ? $_SESSION['dados']['email'] : '' ?>">
              </div>
          </div>
            <div class="form-floating">
                <label for="nome" class="col-sm-2 col-form-label col-form-label">Nome</label>
                <div >
                    <input type="text" class="form-control form-control" maxlength="50" id="nome" name="nome" value="<?php echo isset($_SESSION['dados']['nome']) ? $_SESSION['dados']['nome'] : '' ?>" autofocus>
                </div>
            </div>
            <div class="form-floating">
                <label for="login" class="col-sm-2 col-form-label col-form-label">Login</label>
                <div >
                    <input type="text" class="form-control form-control" maxlength="15" id="login" name="login" value="<?php echo isset($_SESSION['dados']['login']) ? $_SESSION['dados']['login'] : '' ?>">
                </div>
            </div>
            <div class="form-floating">
                <label for="senha" class="col-sm-2 col-form-label col-form-label">Senha</label>
                <div >
                    <input type="password" class="form-control form-control" maxlength="10" id="senha" name="senha" value="<?php echo isset($_SESSION['dados']['senha']) ? $_SESSION['dados']['senha'] : '' ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="botao_cadastrar">Cadastrar</button>
            <button type="reset" class="btn btn-secondary" id="botao_limpar">Limpar</button>
        </form>
        <?php
        unset($_SESSION["dados"]);
        ?>
     
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
</body>

</html>