function calcIMC(){
    var resultado = document.querySelector("resultado");
    var altura = Number(document.getElementById("altura").value);
    var peso = Number(document.getElementById("peso").value);
    var imc = Number(document.getElementById("imc").value);

        if(altura != '' && peso != ''){
            var imc = (peso / (altura * altura));
            let classification = ''

            if(imc < 18.5){
                classification = "abaixo do peso"
            } else if(imc < 25){
                classification = "peso normal"
            } else if(imc < 30){
                classification = "acima do peso"
            } else if(imc < 35){
                classification = "Obesidade Grau I"
            } else if(imc < 41){
                classification = "Obesidade Grau II"
            } else {
                classification = "Obesidade Grau III"
            }
            resultado.innerHTML = `IMC: ${imc} (${classification})`
    }
}