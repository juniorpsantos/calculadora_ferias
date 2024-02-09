
<div id='quest_one' class='quest_one_container'>
    <label for="salary-input"><h2>Qual o valor do salário?</h2></label>
    <input type="text" id="salary" name="salary-input" onKeyUp="mascaraMoeda(this, event)"  value="" required>
</div>

<style>
    .quest_one_container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-top: 8vh;

    }
    h2 {
        font-size: 50px;
        margin: 20px;
        text-align: center;
    }
    input {
        padding: 15px;
        font-size: 18px;
        margin: 30px 0;
        outline: none;
    }

    @media (max-width: 886px) {
        h2 {
            font-size: 40px;
        }
        input {
            padding: 13px;
        }
    }

    @media (max-width: 450px) {
        .quest_one_container {
            margin-top: 15vh
        }
        h2 {
            font-size: 30px;
        }
        input {
            padding: 10px;
        }
    }
</style>

<script>    
    function getData() {
        var salary = document.getElementById('salary').value;
        return {salary}
    }

    String.prototype.reverse = function(){
        return this.split('').reverse().join(''); 
};

function mascaraMoeda(campo,evento){
    var tecla = (!evento) ? window.event.keyCode : evento.which;
    var valor  =  campo.value.replace(/[^\d]+/gi,'').reverse();
    var resultado  = "";
    var mascara = "##.###.###,##".reverse();
    for (var x=0, y=0; x<mascara.length && y<valor.length;) {
        if (mascara.charAt(x) != '#') {
            resultado += mascara.charAt(x);
            x++;
        } else {
            resultado += valor.charAt(y);
            y++;
            x++;
        }
    }
    campo.value = resultado.reverse();
}


</script>