<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/calculo_imc.css">
    <title>IMC</title>

</head>
<body>
    <main>
        <h2>Cálculo IMC</h2>
        <div class="divAltura">
            <label for="altura">Altura (M)</label>
            <input type="number" id="altura">
        </div>

        <div class="divPeso">
            <label for="peso">peso (KG)</label>
            <input type="number" id="peso">
        </div>

        <div class="divCalc">
            <button onclick="calcIMC()">Calcular</button>
        </div>
        <span id="resultado"></span>
    </main>

    <script src="./js/sistema/calculo.js" defer></script>
</body>
</html>