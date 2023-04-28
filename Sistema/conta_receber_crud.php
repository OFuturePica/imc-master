<?php
require_once("valida_acesso.php");
?>
<?php
require_once("conexao.php");
require_once("conta_receber_filtro.php");

//operações via ajax
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    if (!isset($_POST["acao"])) {
        return;
    }

    switch ($_POST["acao"]) {
        case "adicionar":
            try {
                $errosAux = "";

                $registro = new stdClass();
                $registro = json_decode($_POST['registro']);
                validaDados($registro);

                $sql = "insert into conta_receber(descricao, favorecido, valor, data_vencimento, categoria_id, usuario_id) VALUES (?, ?, ?, ?, ?, ?) ";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->descricao_contareceber,
                    $registro->favorecido_contareceber,
                    $registro->valor_contareceber,
                    $registro->datavencimento_contareceber,
                    $registro->categoria_id_contareceber,
                    $registro->usuario_id_contareceber
                ));
                print json_encode($conexao->lastInsertId());
            } catch (Exception $e) {
                if (isset($_SESSION["erros"])) {
                    foreach ($_SESSION["erros"] as $chave => $valor) {
                        $errosAux .= $valor . "<br>";
                    }
                }
                $errosAux .= $e->getMessage();
                unset($_SESSION["erros"]);
                echo "Erro: " . $errosAux . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        case "editar":
            try {
                $errosAux = "";

                $registro = new stdClass();
                $registro = json_decode($_POST['registro']);
                validaDados($registro);

                $sql = "update conta_receber set descricao = ?, favorecido = ?, valor = ?, data_vencimento = ?, categoria_id = ? where id = ? ";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->descricao_contareceber,
                    $registro->favorecido_contareceber,
                    $registro->valor_contareceber,
                    $registro->datavencimento_contareceber,
                    $registro->categoria_id_contareceber,
                    $registro->id_contareceber
                ));
                print json_encode(1);
            } catch (Exception $e) {
                foreach ($_SESSION["erros"] as $chave => $valor) {
                    $errosAux .= $valor . "<br>";
                }
                $errosAux .= $e->getMessage();
                unset($_SESSION["erros"]);
                echo "Erro: " . $errosAux . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        case "excluir":
            try {
                $registro = new stdClass();
                $registro = json_decode($_POST["registro"]);

                $sql = "delete from conta_receber where id = ? ";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->id
                ));

                print json_encode(1);
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage() . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        case 'buscar':
            try {
                $registro = new stdClass();
                $registro = json_decode($_POST["registro"]);

                $sql = "select * from conta_receber where id = ?";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->id
                ));

                print json_encode($pre->fetchAll(PDO::FETCH_ASSOC));
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage() . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        case 'grafico':
            try {
                $ano = filter_var($_POST["ano"], FILTER_VALIDATE_INT);
                $usuario_id = filter_var($_POST["usuario"], FILTER_VALIDATE_INT);
                $receber = null;
                $receber_aux = [];
                $linhas = [];
                $retorno = [];

                $meses = [
                    1 => 'Janeiro',
                    2 => 'Fevereiro',
                    3 => 'Março',
                    4 => 'Abril',
                    5 => 'Maio',
                    6 => 'Junho',
                    7 => 'Julho',
                    8 => 'Agosto',
                    9 => 'Setembro',
                    10 => 'Outubro',
                    11 => 'Novembro',
                    12 => 'Dezembro'
                ];

                $sql = "select extract(month from data_vencimento) as mes, sum(valor) as valor " . "from conta_receber where usuario_id = ? " .
                    "and extract(year from data_vencimento) = ? " .
                    "group by mes order by mes";

                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $usuario_id,
                    $ano
                ));

                $receber = $pre->fetchAll(PDO::FETCH_ASSOC);

                // aqui extraindo os dados de recebimentos da consulta
                for ($i = 0; $i < count($receber); $i++) {
                    $linha = $receber[$i];

                    if (array_key_exists($linha["mes"], $meses)) {
                        $linhas[$meses[$linha["mes"]]] = $linha["valor"];
                    }
                }

                // só preenchendo o vetor com os dados restantes se não vier 12 meses na consulta
                if (count($linhas) < 12) {
                    for ($i = 1; $i < 13; $i++) {
                        if (array_key_exists($meses[$i], $linhas)) {
                            $receber_aux[$meses[$i]] = $linhas[$meses[$i]];
                        } else {
                            $receber_aux[$meses[$i]] = 0;
                        }
                    }
                }


                $retorno[] = $receber_aux;
                print json_encode($retorno);
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage() . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        default:
            print json_encode(0);
            return;
    }
}

//consulta sem ajax
function buscarContaReceber(int $id)
{
    try {
        $sql = "select * from conta_receber where id = ?";
        $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
        $pre = $conexao->prepare($sql);
        $pre->execute(array(
            $id
        ));

        return $pre->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage() . "<br>";
    } finally {
        $conexao = null;
    }
}

//consulta sem ajax
function listarContaReceber()
{
    try {
        $sql = "select * from conta_receber order by descricao";
        $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
        $pre = $conexao->prepare($sql);
        $pre->execute();

        return $pre->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage() . "<br>";
    } finally {
        $conexao = null;
    }
}
