$(document).ready(function () {
	//configurando a tabela de dados listados
	$("#lista_categoria").DataTable({
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
	$("#categoria_dados").validate({
		rules: {
			descricao_categoria: {
				required: true
			},
			tipo_categoria: {
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
			descricao_categoria: {
				required: "Este campo não pode ser vazio!"
			},
			tipo_categoria: {
				required: "Este campo não pode ser vazio!",
			}
		}
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação da listagem
	$("#div_mensagem_botao_categoria").click(function () {
		$("#div_mensagem_categoria").hide();
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação do registro
	$("#div_mensagem_registro_botao_categoria").click(function () {
		$("#div_mensagem_registro_categoria").hide();
	});

	//voltando para a página inicial do menu do sistema
	$("#home_index_categoria").click(function () {
		$(location).prop("href", "menu.php");
	});

	//voltando para a página de listagem de categoria na mesma página onde ocorreu a chamada
	$("#categoria_index").click(function (e) {
		e.stopImmediatePropagation();

		$("#conteudo").load("categoria_index.php", {
			pagina_categoria: $("#pagina_categoria").val(),
			texto_busca_categoria: $("#texto_busca_categoria").val()
		});
	});

	//botão limpar do cadastro de informações
	$("#botao_limpar_categoria").click(function () {
		$("#nome").focus();
		$("#categoria_dados").each(function () {
			$(this).find(":input").removeClass("is-invalid");
			$(this).find(":input").removeAttr("value");
		});
	});

	//botão salvar do cadastro de informações
	$("#botao_salvar_categoria").click(function (e) {
		$("#modal_salvar_categoria").modal("show");
	});

	//botão sim da pergunta de salvar as informações de cadastro
	$("#modal_salvar_sim_categoria").click(function (e) {
		e.stopImmediatePropagation();

		if (!$("#categoria_dados").valid()) {
			$("#modal_salvar_categoria").modal("hide");
			return;
		}

		var dados = $("#categoria_dados").serializeArray().reduce(function (vetor, obj) {
			vetor[obj.name] = obj.value;
			return vetor;
		}, {});
		var operacao = null;

		$("#carregando_categoria").removeClass("d-none");

		if ($.trim($("#id_categoria").val()) != "") {
			operacao = "editar";
		} else {
			operacao = "adicionar";
		}
		dados = JSON.stringify(dados);

		$.ajax({
			type: "POST",
			cache: false,
			url: "categoria_crud.php",
			data: {
				acao: operacao,
				registro: dados
			},
			dataType: "json",
			success: function (e) {
				$("#conteudo").load("categoria_index.php", {
					pagina_categoria: $("#pagina_categoria").val(),
					texto_busca_categoria: $("#texto_busca_categoria").val()
				}, function () {
					$("#div_mensagem_texto_categoria").empty().append("Categoria cadastrada!");
					$("#div_mensagem_categoria").show();
				});
			},
			error: function (e) {
				$("#div_mensagem_registro_texto_categoria").empty().append(e.responseText);
				$("#div_mensagem_registro_categoria").show();
			},
			complete: function () {
				$("#modal_salvar_categoria").modal("hide");
				$("#carregando_categoria").addClass("d-none");
			}
		});
	});

	//botão adicionar da tela de listagem de registros
	$("#botao_adicionar_categoria").click(function (e) {
		e.stopImmediatePropagation();

		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var pagina = $("#pagina_categoria.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_categoria").val();

		$("#conteudo").load("categoria_add.php", function () {
			$("#carregando_categoria").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "categoria_add.php",
				data: {
					pagina_categoria: pagina,
					texto_busca_categoria: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_categoria").empty().append(e.responseText);
					$("#div_mensagem_categoria").show();
				},
				complete: function () {
					$("#carregando_categoria").addClass("d-none");
				}
			});
		});
	});

	//botão pesquisar da tela de listagem de registros
	$("#botao_pesquisar_categoria").click(function (e) {
		e.stopImmediatePropagation();

		$("#carregando_categoria").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "categoria_index.php",
			data: {
				texto_busca_categoria: $("#texto_busca_categoria").val()
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_categoria").empty().append(e.responseText);
				$("#div_mensagem_categoria").show();
			},
			complete: function () {
				$("#carregando_categoria").addClass("d-none");
			}
		});
	});

	//botão editar da tela de listagem de registros
	$(document).on("click", "#botao_editar_categoria", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_categoria.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_categoria").val();

		$("#conteudo").load("categoria_edit.php", function () {
			$("#carregando_categoria").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "categoria_edit.php",
				data: {
					id_categoria: id,
					pagina_categoria: pagina,
					texto_busca_categoria: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_categoria").empty().append(e.responseText);
					$("#div_mensagem_categoria").show();
				},
				complete: function () {
					$("#carregando_categoria").addClass("d-none");
				}
			});
		});
	});

	//botão visualizar da tela de listagem de registros
	$(document).on("click", "#botao_view_categoria", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_categoria.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_categoria").val();

		$("#conteudo").load("categoria_view.php", function () {
			$("#carregando_categoria").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "categoria_view.php",
				data: {
					id_categoria: id,
					pagina_categoria: pagina,
					texto_busca_categoria: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_categoria").empty().append(e.responseText);
					$("#div_mensagem_categoria").show();
				},
				complete: function () {
					$("#carregando_categoria").addClass("d-none");
				}
			});
		});
	});

	//botão paginação da tela de listagem de registros
	$(document).on("click", "#pagina_categoria", function (e) {
		//Aqui como links de botões têm o mesmo nome é necessário parar as chamadas
		e.stopImmediatePropagation();

		var texto_busca = $("#texto_busca_categoria").val();
		var pagina = $(this).val();
		$("#carregando_categoria").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "categoria_index.php",
			data: {
				pagina_categoria: pagina,
				texto_busca_categoria: texto_busca
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_categoria").empty().append(e.responseText);
				$("#div_mensagem_categoria").show();
			},
			complete: function () {
				$("#carregando_categoria").addClass("d-none");
				$("#texto_busca_categoria").text(texto_busca);
			}
		});
	});

	//botão excluir da tela de listagem de registros
	$(document).on("click", "#botao_excluir_categoria", function (e) {
		e.stopImmediatePropagation();

		confirmaExclusao(this);
	});

	function confirmaExclusao(registro) {
		$("#modal_excluir_categoria").modal("show");
		$("#id_excluir_categoria").val($(registro).attr("chave"));
	}

	//botão sim da pergunta de excluir de listagem de registros
	$("#modal_excluir_sim_categoria").click(function () {
		excluirRegistro();
	});

	//operação de exclusão do registro
	function excluirRegistro() {
		var registro = new Object();
		var registroJson = null;

		registro.id = $("#id_excluir_categoria").val();
		registroJson = JSON.stringify(registro);

		$.ajax({
			type: "POST",
			cache: false,
			url: "categoria_crud.php",
			data: {
				acao: "excluir",
				registro: registroJson
			},
			dataType: "json",
			success: function () {
				$("#div_mensagem_texto_categoria").empty().append("Categoria excluída!");
				$("#div_mensagem_categoria").show();
				$("tr#" + registro.id + "_categoria").remove();
			},
			error: function (e) {
				$("#div_mensagem_texto_categoria").empty().append(e.responseText);
				$("#div_mensagem_categoria").show();
			},
			complete: function () {
				$("#modal_excluir_categoria").modal("hide");
			}
		});
	}
});