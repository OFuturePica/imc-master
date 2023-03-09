
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 d-flex justify-content-start">
                    <h4>Visualizar Contas a Receber</h4>
                </div>
                <div class="col-md-3 d-flex justify-content-center">
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_contareceber"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="Contas a Receber" id="contareceber_index"><i class="fas fa-calendar-plus"></i> <span>Contas a Receber</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Visualizar</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <hr>
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
            <hr>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="tab_contareceber" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_contareceber" data-bs-toggle="tab" data-bs-target="#dados_contareceber" type="button" role="tab" aria-controls="dados_contareceber" aria-selected="true">Dados</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="complementotab_contareceber" data-bs-toggle="tab" data-bs-target="#complemento_contareceber" type="button" role="tab" aria-controls="complemento_contareceber" aria-selected="false">Complemento</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="tabdados_contareceber">
                        <div class="tab-pane fade show active" id="dados_contareceber" role="tabpanel" aria-labelledby="dados_contareceber">
                            <h4>
                                <b><?= isset($resultado["id"]) ? $resultado["id"] : "" ?></b>
                                <b><?= " - "  ?></b>
                                <b><?= isset($resultado[""]) ? $resultado[""] : "" ?></b>
                            </h4>
                            <br>
                            <dl>
                                <dt>peso</dt>
                                <dd>
                                    <?= isset($resultado[""]) ? $resultado[""] : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>altura</dt>
                                <dd>
                                    <?= isset($resultado[""]) ? $resultado[""] : ""; ?>
                                </dd>
                            </dl>
                    
                        </div>
                        <div class="tab-pane fade" id="complemento_contareceber" role="tabpanel" aria-labelledby="complemento_contareceber">
                            <dl>
                                <dt>Vencimento</dt>
                                <dd>
                                    <?= isset($resultado[""]) ?
                                        date("d/m/Y", strtotime($resultado[""])) : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="hidden" id="pagina_contareceber" name="pagina" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                    <input type="hidden" id="texto_busca_contareceber" name="texto_busca_contareceber" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/conta_receber.js";
    $.getScript(url);
</script>