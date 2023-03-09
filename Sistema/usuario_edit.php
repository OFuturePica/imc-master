
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 d-flex justify-content-start">
                    <h4>Editar Usuário</h4>
                </div>
                <div class="col-md-4 d-flex justify-content-center">
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_usuario"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="Usuário" id="usuario_index"><i class="fas fa-user-cog"></i> <span>Usuário</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <hr>
           
            <div class="alert alert-info alert-dismissible fade show" style="display: none;" id="div_mensagem_registro_usuario">
                <button type="button" class="btn-close btn-sm" aria-label="Close" id="div_mensagem_registro_botao_usuario"></button>
                <p id="div_mensagem_registro_texto_usuario"></p>
            </div>
            <hr>
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="post" accept-charset="utf-8" id="usuario_dados" role="form" action="">
                    <ul class="nav nav-tabs" id="tab_usuario" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_usuario" data-bs-toggle="tab" data-bs-target="#dados_usuario" type="button" role="tab" aria-controls="dados_usuario" aria-selected="true">Dados</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="segurancatab_usuario" data-bs-toggle="tab" data-bs-target="#seguranca_usuario" type="button" role="tab" aria-controls="seguranca_usuario" aria-selected="false">Segurança</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabdados_usuario">
                        <div class="tab-pane fade show active" id="dados_usuario" role="tabpanel" aria-labelledby="dados_usuario">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" maxlength="50" value="<?php echo isset($resultado['nome']) ? $resultado['nome'] : ''; ?>" autofocus>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email_usuario" name="email_usuario" maxlength="100" value="<?php echo isset($resultado['email']) ? $resultado['email'] : ''; ?>">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="seguranca_usuario" role="tabpanel" aria-labelledby="seguranca_usuario">
                            <div class="col-md-6">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" class="form-control" id="login_usuario" name="login_usuario" maxlength="15" value="<?php echo isset($resultado['login']) ? $resultado['login'] : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" maxlength="10" value="<?php echo isset($resultado['senha']) ? $resultado['senha'] : ''; ?>">
                            </div>
                            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo isset($id) ? $id : '' ?>" />
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="button" class="btn btn-primary" id="botao_salvar_usuario">Salvar</button>
                        <button type="reset" class="btn btn-secondary" id="botao_limpar_usuario">Limpar</button>
                    </div>
                </form>
            </div>
            <div>
                <input type="hidden" id="pagina_usuario" name="pagina_usuario" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                <input type="hidden" id="texto_busca_usuario" name="texto_busca_usuario" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
            </div>
        </div>
    </div>
</div>

<!--modal de salvar-->
<div class="modal fade" id="modal_salvar_usuario" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutlabel_usuario">Pergunta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja salvar o registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_salvar_sim_usuario">Sim</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>

<script>
    //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/usuario.js";
    $.getScript(url);
</script>