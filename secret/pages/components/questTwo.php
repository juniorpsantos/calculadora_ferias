<div id='quest_two' class='quest_two_container'>
    <h2>Selecione o tipo de cálculo:</h2>
    <div class='quest_two_content'>
        <div class='input_box'>
            <input type="radio" id="resignation" name="calculation_type" value="resignation_value">
            <label for="resignation">Demissão</label><br>
        </div>
        <div class='input_box'>
            <input type="radio" id="vacation" name="calculation_type" value="vacation_value">
            <label for="vacation">Férias</label>
        </div>
    </div>
</div>

<style>
    .quest_two_container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-top: 15vh;
    }

    h2 {
        font-size: 50px;
        margin: 20px;
        text-align: center;
    }

    .quest_two_content {
        display: flex;
    }

    .input_box {
        margin: 8vh 3vw;
    }

    .quest_two_content div label,
    input {
        font-size: 20px;
    }

    @media (max-width: 886px) {
        h2 {
            font-size: 30px;
        }

        .quest_two_content div label,
        input {
            font-size: 20px;
        }
    }

    @media (max-width: 450px) {
        .quest_one_container {
            margin-top: 15vh
        }

        h2 {
            font-size: 25px;
        }

        .quest_two_content div label,
        input {
            font-size: 18px;
        }
    }
</style>

<script>
    function getData() {
        return {
            'is_resignation': document.getElementById('resignation').checked
        };
    }
</script>