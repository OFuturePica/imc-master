$(document).ready(function () {
	//configurando a tabela de dados listados
	$("#lista_contareceber").DataTable({
		columnDefs: [{
			targets: [6],
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
	$("#contareceber_dados").validate({
		rules: {
			descricao_contareceber: {
				required: true
			},
			favorecido_contareceber: {
				required: true
			},
			valor_contareceber: {
				required: true
			},
			datavencimento_contareceber: {
				required: true
			},
			categoria_id_contareceber: {
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
			descricao_contareceber: {
				required: "Este campo não pode ser vazio!"
			},
			favorecido_contareceber: {
				required: "Este campo não pode ser vazio!"
			},
			valor_contareceber: {
				required: "Este campo não pode ser vazio!"
			},
			datavencimento_contareceber: {
				required: "Este campo não pode ser vazio!",
			},
			categoria_id_contareceber: {
				required: "Este campo não pode ser vazio!",
			}
		}
	});

	$("#valor_contareceber").inputmask("currency", {
		autoUnmask: true,
		radixPoint: ",",
		groupSeparator: ".",
		allowMinus: false,
		prefix: 'R$ ',
		digits: 2,
		digitsOptional: false,
		rightAlign: true,
		unmaskAsNumber: false
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação da listagem
	$("#div_mensagem_botao_contareceber").click(function () {
		$("#div_mensagem_contareceber").hide();
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação do registro
	$("#div_mensagem_registro_botao_contareceber").click(function () {
		$("#div_mensagem_registro_contareceber").hide();
	});

	//voltando para a página inicial do menu do sistema
	$("#home_index_contareceber").click(function () {
		$(location).prop("href", "menu.php");
	});

	//voltando para a página de listagem de contas a receber na mesma página onde ocorreu a chamada
	$("#contareceber_index").click(function (e) {
		e.stopImmediatePropagation();

		$("#conteudo").load("conta_receber_index.php", {
			pagina_contareceber: $("#pagina_contareceber").val(),
			texto_busca_contareceber: $("#texto_busca_contareceber").val()
		});
	});

	//botão limpar do cadastro de informações
	$("#botao_limpar_contareceber").click(function () {
		$("#nome").focus();
		$("#contareceber_dados").each(function () {
			$(this).find(":input").removeClass("is-invalid");
			$(this).find(":input").removeAttr("value");
		});
	});

	//botão salvar do cadastro de informações
	$("#botao_salvar_contareceber").click(function (e) {
		$("#modal_salvar_contareceber").modal("show");
	});

	//botão sim da pergunta de salvar as informações de cadastro
	$("#modal_salvar_sim_contareceber").click(function (e) {
		e.stopImmediatePropagation();

		if (!$("#contareceber_dados").valid()) {
			$("#modal_salvar_contareceber").modal("hide");
			return;
		}

		var dados = $("#contareceber_dados").serializeArray().reduce(function (vetor, obj) {
			vetor[obj.name] = obj.value;
			return vetor;
		}, {});
		var operacao = null;

		$("#carregando_contareceber").removeClass("d-none");

		if ($.trim($("#id_contareceber").val()) != "") {
			operacao = "editar";
		} else {
			operacao = "adicionar";
		}
		dados = JSON.stringify(dados);

		$.ajax({
			type: "POST",
			cache: false,
			url: "conta_receber_crud.php",
			data: {
				acao: operacao,
				registro: dados
			},
			dataType: "json",
			success: function (e) {
				$("#conteudo").load("conta_receber_index.php", {
					pagina_contareceber: $("#pagina_contareceber").val(),
					texto_busca_contareceber: $("#texto_busca_contareceber").val()
				}, function () {
					$("#div_mensagem_texto_contareceber").empty().append("Contas a receber cadastrada!");
					$("#div_mensagem_contareceber").show();
				});
			},
			error: function (e) {
				$("#div_mensagem_registro_texto_contareceber").empty().append(e.responseText);
				$("#div_mensagem_registro_contareceber").show();
			},
			complete: function () {
				$("#modal_salvar_contareceber").modal("hide");
				$("#carregando_contareceber").addClass("d-none");
			}
		});
	});

	//botão adicionar da tela de listagem de registros
	$("#botao_adicionar_contareceber").click(function (e) {
		e.stopImmediatePropagation();

		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var pagina = $("#pagina_contareceber.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_contareceber").val();

		$("#conteudo").load("conta_receber_add.php", function () {
			$("#carregando_contareceber").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "conta_receber_add.php",
				data: {
					pagina_contareceber: pagina,
					texto_busca_contareceber: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_contareceber").empty().append(e.responseText);
					$("#div_mensagem_contareceber").show();
				},
				complete: function () {
					$("#carregando_contareceber").addClass("d-none");
				}
			});
		});
	});

	//botão pesquisar da tela de listagem de registros
	$("#botao_pesquisar_contareceber").click(function (e) {
		e.stopImmediatePropagation();

		$("#carregando_contareceber").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "conta_receber_index.php",
			data: {
				texto_busca_contareceber: $("#texto_busca_contareceber").val()
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_contareceber").empty().append(e.responseText);
				$("#div_mensagem_contareceber").show();
			},
			complete: function () {
				$("#carregando_contareceber").addClass("d-none");
			}
		});
	});

	//botão editar da tela de listagem de registros
	$(document).on("click", "#botao_editar_contareceber", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_contareceber.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_contareceber").val();

		$("#conteudo").load("conta_receber_edit.php", function () {
			$("#carregando_contareceber").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "conta_receber_edit.php",
				data: {
					id_contareceber: id,
					pagina_contareceber: pagina,
					texto_busca_contareceber: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_contareceber").empty().append(e.responseText);
					$("#div_mensagem_contareceber").show();
				},
				complete: function () {
					$("#carregando_contareceber").addClass("d-none");
				}
			});
		});
	});

	//botão visualizar da tela de listagem de registros
	$(document).on("click", "#botao_view_contareceber", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_contareceber.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_contareceber").val();

		$("#conteudo").load("conta_receber_view.php", function () {
			$("#carregando_contareceber").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "conta_receber_view.php",
				data: {
					id_contareceber: id,
					pagina_contareceber: pagina,
					texto_busca_contareceber: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_contareceber").empty().append(e.responseText);
					$("#div_mensagem_contareceber").show();
				},
				complete: function () {
					$("#carregando_contareceber").addClass("d-none");
				}
			});
		});
	});

	//botão paginação da tela de listagem de registros
	$(document).on("click", "#pagina_contareceber", function (e) {
		//Aqui como links de botões têm o mesmo nome é necessário parar as chamadas
		e.stopImmediatePropagation();

		var texto_busca = $("#texto_busca_contareceber").val();
		var pagina = $(this).val();
		$("#carregando_contareceber").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "conta_receber_index.php",
			data: {
				pagina_contareceber: pagina,
				texto_busca_contareceber: texto_busca
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_contareceber").empty().append(e.responseText);
				$("#div_mensagem_contareceber").show();
			},
			complete: function () {
				$("#carregando_contareceber").addClass("d-none");
				$("#texto_busca_contareceber").text(texto_busca);
			}
		});
	});

	//botão excluir da tela de listagem de registros
	$(document).on("click", "#botao_excluir_contareceber", function (e) {
		e.stopImmediatePropagation();

		confirmaExclusao(this);
	});

	function confirmaExclusao(registro) {
		$("#modal_excluir_contareceber").modal("show");
		$("#id_excluir_contareceber").val($(registro).attr("chave"));
	}

	//botão sim da pergunta de excluir de listagem de registros
	$("#modal_excluir_sim_contareceber").click(function () {
		excluirRegistro();
	});

	//operação de exclusão do registro
	function excluirRegistro() {
		var registro = new Object();
		var registroJson = null;

		registro.id = $("#id_excluir_contareceber").val();
		registroJson = JSON.stringify(registro);

		$.ajax({
			type: "POST",
			cache: false,
			url: "conta_receber_crud.php",
			data: {
				acao: "excluir",
				registro: registroJson
			},
			dataType: "json",
			success: function () {
				$("#div_mensagem_texto_contareceber").empty().append("Contas a receber excluída!");
				$("#div_mensagem_contareceber").show();
				$("tr#" + registro.id + "_contareceber").remove();
			},
			error: function (e) {
				$("#div_mensagem_texto_contareceber").empty().append(e.responseText);
				$("#div_mensagem_contareceber").show();
			},
			complete: function () {
				$("#modal_excluir_contareceber").modal("hide");
			}
		});
	}
});