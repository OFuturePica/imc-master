	// populando o gráfico conforme altera o produto
	$('#gerar_grafico').click(function () {
	    $.ajax({
	        'type': 'POST',
	        'url': $('#produto_id').attr('rel') +
	            '?id=' + $('#produto_id').val() +
	            '&ano=' + $('select[name="data_movimentacao[year]"]').val(),
	        'dataType': 'json',
	        'cache': false,
	        'success': function (data) {
	            var html = '';
	            var entrada = [];
	            var entrada_meses = [];
	            var entrada_valores = [];
	            var saida = [];
	            var saida_meses = [];
	            var saida_valores = [];
	            var ano = $('select[name="data_movimentacao[year]"]').val();
	            var produto = $('#produto_id option:selected').text();

	            $.each(data, function (i, item) {
	                if (i == 0) {
	                    entrada = item;
	                } else {
	                    saida = item;
	                }
	            });

	            $.each(entrada, function (i, item) {
	                entrada_meses.push(i);
	                entrada_valores.push(item);
	            });

	            $.each(saida, function (i, item) {
	                saida_meses.push(i);
	                saida_valores.push(item);
	            });

	            var dados = {
	                labels: entrada_meses,
	                datasets: [{
	                        label: 'Entrada',
	                        backgroundColor: '#4080bf',
	                        borderColor: '#3973ac',
	                        hoverBackgroundColor: '#ccccff',
	                        hoverBorderColor: '#b3b3ff',
	                        borderWidth: 1,
	                        data: entrada_valores
	                    },
	                    {
	                        label: 'Saída',
	                        backgroundColor: '#ff3300',
	                        borderColor: '#e62e00',
	                        hoverBackgroundColor: '#ffe6e6',
	                        hoverBorderColor: '#ffcccc',
	                        borderWidth: 1,
	                        data: saida_valores
	                    }
	                ]

	            };

	            var grafico_canva = $("#canva_grafico");

	            var graficoBarra = new Chart(
	                grafico_canva, {
	                    type: 'bar',
	                    data: dados,
	                    options: {
	                        responsive: true,
	                        legend: {
	                            position: 'top',
	                        },
	                        title: {
	                            display: true,
	                            text: 'Movimentação de estoque - ' +
	                                produto +
	                                ' - Entrada x Saída - ' +
	                                ano
	                        },
	                        scales: {
	                            yAxes: [{
	                                scaleLabel: {
	                                    display: true,
	                                    labelString: 'Quantidade movimentada sem conversão de unidade de medida'
	                                }
	                            }],
	                            xAxes: [{
	                                scaleLabel: {
	                                    display: true,
	                                    labelString: 'Meses do ano'
	                                }
	                            }]
	                        }
	                    }
	                });
	        },
	        'error': function (xhr,
	            textStatus, error) {
	            alert('Erro: ' +
	                textStatus +
	                error);
	        },
	        'beforeSend': function () {
	            $('#carregando').css({
	                display: "block"
	            });
	        },
	        'complete': function () {
	            $('#carregando').css({
	                display: "none"
	            });
	        }
	    });
	});