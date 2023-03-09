
<br>
<div class="container">
    <div class="row">
        <div id="carregando_contareceber" class="d-none text-center">
            <img src="./imagens/carregando.gif" />
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 d-flex justify-content-start">
                    <h4>Lista de Contas a Receber</h4>
                </div>
                <div class="col-md-4 d-flex justify-content-center">
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_contareceber"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contas a Receber</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 d-flex justify-content-start">
                    <a href="#" class="btn btn-primary btn-sm" title="Adicionar" id="botao_adicionar_contareceber"><i class="fas fa-plus-square"></i>&nbsp;Adicionar</a>
                </div>
                <div class="col-md-4 d-flex justify-content-center">
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <input type="text" name="texto_busca" value="<?php echo $texto_busca; ?>" id="texto_busca_contareceber" maxlength="25">
                    <a id="botao_pesquisar_contareceber" class="btn btn-primary btn-sm" title="Pesquisar"><i class="fas fa-search"></i>&nbsp;Pesquisar</a>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-md-12">
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
            <div class="alert alert-info alert-dismissible fade show" style="display: none;" id="div_mensagem_contareceber">
                <button type="button" class="btn-close btn-sm" aria-label="Close" id="div_mensagem_botao_contareceber"></button>
                <p id="div_mensagem_texto_contareceber"></p>
            </div>
            <?php
            if (!count($contas)) {
            ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    Nenhuma conta a receber encontrada!
                </div>
            <?php
            } else {
            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="lista_contareceber">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descri&ccedil;&atilde;o</th>
                                <th>Favorecido</th>
                                <th>Valor R$</th>
                                <th>Vencimento</th>
                                <th>Categoria</th>
                                <th>A&ccedil;&otilde;es</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($contas as $conta) {
                            ?>
                                <tr id="<?php echo $conta['id'] . "_contareceber"; ?>">
                                    <td><?php echo $conta["id"]; ?></td>
                                    <td><?php echo $conta["descricao"]; ?></td>
                                    <td><?php echo $conta["favorecido"]; ?></td>
                                    <td><?php echo number_format($conta["valor"], 2, ',', '.'); ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($conta["data_vencimento"])); ?></td>
                                    <td><?php echo buscarCategoria($conta["categoria_id"])[0]["descricao"]; ?></td>
                                    <td>
                                        <a id="botao_view_contareceber" chave="<?php echo $conta['id']; ?>" class="btn btn-info btn-sm" title="Visualizar"><i class="fas fa-eye"></i></a>
                                        <a id="botao_editar_contareceber" chave="<?php echo $conta['id']; ?>" class="btn btn-success btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                        <a id="botao_excluir_contareceber" chave="<?php echo $conta['id']; ?>" class="btn btn-danger btn-sm" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php echo $barra_paginacao; ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<!--modal de excluir-->
<div class="modal fade" id="modal_excluir_contareceber" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutlabel_contareceber">Pergunta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja excluir o registro?
                <input type="hidden" id="id_excluir_contareceber" value="" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_excluir_sim_contareceber">Sim</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>

<script>
    //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/conta_receber.js";
    $.getScript(url);
</script>