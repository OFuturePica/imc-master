$(document).ready(function () {
	//configurando a tabela de dados listados
	$("#lista_usuario").DataTable({
		columnDefs: [{
			targets: [2],
			orderable: false
		}],
		destroy: true,
		info: false,
		language: {
            decimal: ",",
            thousands: "."
        },
		order: [
			[0, "asc"]
		],
		ordering: true,
		paging: false,
		searching: false
	});

	//configurando validação dos dados digitados no cadastro/edição
	$("#usuario_dados").validate({
		rules: {
			nome_usuario: {
				required: true
			},
			email_usuario: {
				required: true
			},
			login_usuario: {
				required: true
			},
			senha_usuario: {
				required: true
			}
		},
		highlight: function (element) {
			$(element).addClass("is-invalid");
		},
		unhighlight: function (element) {
			$(element).removeClass("is-invalid");
		},
		errorElement: "div",
		errorClass: "invalid-feedback",
		errorPlacement: function (error, element) {
			if (element.parent(".input-group-prepend").length) {
				$(element).siblings(".invalid-feedback").append(error);
			} else {
				error.insertAfter(element);
			}
		},
		messages: {
			nome_usuario: {
				required: "Este campo não pode ser vazio!"
			},
			email_usuario: {
				required: "Este campo não pode ser vazio!",
				email: "Email com formato inválido"
			},
			login_usuario: {
				required: "Este campo não pode ser vazio!"
			},
			senha_usuario: {
				required: "Este campo não pode ser vazio!",
			}
		}
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação da listagem
	$("#div_mensagem_botao_usuario").click(function () {
		$("#div_mensagem_usuario").hide();
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação do registro
	$("#div_mensagem_registro_botao_usuario").click(function () {
		$("#div_mensagem_registro_usuario").hide();
	});

	//voltando para a página inicial do menu do sistema
	$("#home_index_usuario").click(function () {
		$(location).prop("href", "menu.php");
	});

	//voltando para a página de listagem de usuário na mesma página onde ocorreu a chamada
	$("#usuario_index").click(function (e) {
		e.stopImmediatePropagation();

		$("#conteudo").load("usuario_index.php", {
			pagina_usuario: $("#pagina_usuario").val(),
			texto_busca_usuario: $("#texto_busca_usuario").val()
		});
	});

	//botão limpar do cadastro de informações
	$("#botao_limpar_usuario").click(function () {
		$("#nome").focus();
		$("#usuario_dados").each(function () {
			$(this).find(":input").removeClass("is-invalid");
			$(this).find(":input").removeAttr("value");
		});
	});

	//botão salvar do cadastro de informações
	$("#botao_salvar_usuario").click(function (e) {
		$("#modal_salvar_usuario").modal("show");
	});

	//botão sim da pergunta de salvar as informações de cadastro
	$("#modal_salvar_sim_usuario").click(function (e) {
		e.stopImmediatePropagation();

		if (!$("#usuario_dados").valid()) {
			$("#modal_salvar_usuario").modal("hide");
			return;
		}

		var dados = $("#usuario_dados").serializeArray().reduce(function (vetor, obj) {
			vetor[obj.name] = obj.value;
			return vetor;
		}, {});
		var operacao = null;

		$("#carregando_usuario").removeClass("d-none");

		if ($.trim($("#id_usuario").val()) != "") {
			operacao = "editar";
		} else {
			operacao = "adicionar";
		}
		dados = JSON.stringify(dados);

		$.ajax({
			type: "POST",
			cache: false,
			url: "usuario_crud.php",
			data: {
				acao: operacao,
				registro: dados
			},
			dataType: "json",
			success: function (e) {
				$("#conteudo").load("usuario_index.php", {
					pagina_usuario: $("#pagina_usuario").val(),
					texto_busca_usuario: $("#texto_busca_usuario").val()
				}, function () {
					$("#div_mensagem_texto_usuario").empty().append("Usuário cadastrado!");
					$("#div_mensagem_usuario").show();
				});
			},
			error: function (e) {
				$("#div_mensagem_registro_texto_usuario").empty().append(e.responseText);
				$("#div_mensagem_registro_usuario").show();
			},
			complete: function () {
				$("#modal_salvar_usuario").modal("hide");
				$("#carregando_usuario").addClass("d-none");
			}
		});
	});

	//botão adicionar da tela de listagem de registros
	$("#botao_adicionar_usuario").click(function (e) {
		e.stopImmediatePropagation();

		alert("Opção não disponível nesse módulo!");
	});

	//botão pesquisar da tela de listagem de registros
	$("#botao_pesquisar_usuario").click(function (e) {
		e.stopImmediatePropagation();

		$("#carregando_usuario").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "usuario_index.php",
			data: {
				texto_busca_usuario: $("#texto_busca_usuario").val()
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_usuario").empty().append(e.responseText);
				$("#div_mensagem_usuario").show();
			},
			complete: function () {
				$("#carregando_usuario").addClass("d-none");
			}
		});
	});

	//botão editar da tela de listagem de registros
	$(document).on("click", "#botao_editar_usuario", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_usuario.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_usuario").val();

		$("#conteudo").load("usuario_edit.php", function () {
			$("#carregando_usuario").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "usuario_edit.php",
				data: {
					id_usuario: id,
					pagina_usuario: pagina,
					texto_busca_usuario: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_usuario").empty().append(e.responseText);
					$("#div_mensagem_usuario").show();
				},
				complete: function () {
					$("#carregando_usuario").addClass("d-none");
				}
			});
		});
	});

	//botão visualizar da tela de listagem de registros
	$(document).on("click", "#botao_view_usuario", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_usuario.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_usuario").val();

		$("#conteudo").load("usuario_view.php", function () {
			$("#carregando_usuario").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "usuario_view.php",
				data: {
					id_usuario: id,
					pagina_usuario: pagina,
					texto_busca_usuario: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_usuario").empty().append(e.responseText);
					$("#div_mensagem_usuario").show();
				},
				complete: function () {
					$("#carregando_usuario").addClass("d-none");
				}
			});
		});
	});

	//botão paginação da tela de listagem de registros
	$(document).on("click", "#pagina_usuario", function (e) {
		//Aqui como links de botões têm o mesmo nome é necessário parar as chamadas
		e.stopImmediatePropagation();

		var texto_busca = $("#texto_busca_usuario").val();
		var pagina =  $(this).val();
		$("#carregando_usuario").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "usuario_index.php",
			data: {
				pagina_usuario: pagina,
				texto_busca_usuario: texto_busca
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_usuario").empty().append(e.responseText);
				$("#div_mensagem_usuario").show();
			},
			complete: function () {
				$("#carregando_usuario").addClass("d-none");
				$("#texto_busca_usuario").text(texto_busca);
			}
		});
	});

	//botão excluir da tela de listagem de registros
	$(document).on("click", "#botao_excluir_usuario", function (e) {
		//Aqui como links de botões têm o mesmo nome é necessário parar as chamadas
		e.stopImmediatePropagation();
		//confirmaExclusao(this);
		alert("Opção não disponível nesse módulo!");
	});

	function confirmaExclusao(registro) {
		$("#modal_excluir_usuario").modal("show");
		$("#id_excluir_usuario").val($(registro).attr("chave"));
	}

	//botão sim da pergunta de excluir de listagem de registros
	$("#modal_excluir_sim_usuario").click(function () {
		excluirRegistro();
	});

	//operação de exclusão do registro
	function excluirRegistro() {
		var registro = new Object();
		var registroJson = null;

		registro.id = $("#id_excluir_usuario").val();
		registroJson = JSON.stringify(registro);

		$.ajax({
			type: "POST",
			cache: false,
			url: "usuario_crud.php",
			data: {
				acao: "excluir",
				registro: registroJson
			},
			dataType: "json",
			success: function () {
				$("#div_mensagem_texto_usuario").empty().append("Usuário excluído!");
				$("#div_mensagem_usuario").show();
				$("tr#" + registro.id+"_usuario").remove();
			},
			error: function (e) {
				$("#div_mensagem_texto_usuario").empty().append(e.responseText);
				$("#div_mensagem_usuario").show();
			},
			complete: function () {
				$("#modal_excluir_usuario").modal("hide");
			}
		});
	}
});