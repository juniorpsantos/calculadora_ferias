<div id='sale' class='sale_container'>
    <h2>O colaborador irar vender suas ferias?</h2>
    <div class='sale_content'>
        <div class="sale_input">
            <input type="radio" id="sale_yes" name="employee_absence" value="yes">
            <label for="sale_yes">Sim</label><br>
        </div>
        <div class="sale_input">
            <input type="radio" id="sale_no" name="employee_absence" value="no">
            <label for="sale_no">Não</label>
        </div>
    </div>
</div>

<style>
    .sale_container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-top: 8vh;
    }

    h2 {
        font-size: 50px;
        margin: 20px;
    }

    .sale_content {
        display: flex;
        padding: 20px;
        justify-content: center;
        margin: 8vh 0;
    }

    .sale_content label {
        margin-right: 15px;
    }

    .sale_content label,
    input {
        font-size: 18px;
    }
    
    .sale_input {
        margin: 0 2vw;
    }

    @media (max-width: 886px) {
        h2 {
            font-size: 40px;
            text-align: center;
        }
        input {
            font-size: 16px;
        }
    }

    @media (max-width: 450px) {
        .quest_one_container {
            margin-top: 15vh
        }
        h2 {
            font-size: 30px;
        }
        .sale_content label,
    input {
            font-size: 16px;
        }
    }
</style>

<script>
    function getData() {
        return {
            'is_sale_vacation': document.getElementById('sale_yes').checked
        }
    }
</script>