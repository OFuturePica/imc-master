<?php

function validaDados($registro)
{
    $erros = [];

    if (!filter_var($registro->descricao_contareceber, FILTER_SANITIZE_STRING)) {
        $erros["descricao_contareceber"] =  "Descrição: Campo vazio e ou informação inválida!";
    }

    if (!filter_var($registro->favorecido_contareceber, FILTER_SANITIZE_STRING)) {
        $erros["favorecido_contareceber"] =  "Favorecido: Campo vazio e ou informação inválida!";
    }

    //retirar a máscara nessa sequência
    $registro->valor_contareceber = str_replace(".","",$registro->valor_contareceber);
    $registro->valor_contareceber = str_replace(",",".",$registro->valor_contareceber);
    if (!filter_var($registro->valor_contareceber, FILTER_VALIDATE_FLOAT)) {
        $erros["valor_contareceber"] =  "Valor R$: Campo vazio e ou informação inválida!";
    }

    if (!filter_var($registro->datavencimento_contareceber, FILTER_SANITIZE_STRING)) {
        $erros["datavencimento_contareceber"] =  "Data Vencimento: Campo vazio e ou informação inválida!";
    }

    if (!filter_var($registro->categoria_id_contareceber, FILTER_SANITIZE_STRING)) {
        $erros["categoria_id_contareceber"] =  "Categoria: Campo vazio e ou informação inválida!";
    }

    if (count($erros) > 0) {
        $_SESSION["erros"] = $erros;
        throw new Exception("Erro nas informações!");
    }
}
