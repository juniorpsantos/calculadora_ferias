<div id='vacation_one' class='vacation_one_container'>
    <h2>Selecione o periodo:</h2>
    <p>Selecione o período de início e termino das férias.</p>
    <div class='date_vacation'>
        <div class="vacation_input">
            <label for="date_start_vacation_input'">Início</label>
            <input type="date" id='date_start_vacation' name='date_start_vacation_input'>
        </div>
        <div class="vacation_input">
            <label for="date_finish_vacation_input'">Término</label>
            <input type="date" id='date_finish_vacation' name='date_finish_vacation_input'>
        </div>
    </div>
</div>

<style>
    .vacation_one_container {
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

    p {
        font-size: 20px;
        margin: 0 0 2vw 0;
        text-align: center;
    }

    .date_vacation {
        display: flex;
        padding: 20px;
        justify-content: center;
    }

    .date_vacation div input,
    label {
        font-size: 18px;
        outline: none;
        border-radius: 3px;
        border: none;
    }

    .vacation_input {
        display: flex;
        justify-content: start;
        flex-direction: column;
        align-items: start;
        margin: 0 4vw 3vh 4vw;
    }

    @media (max-width: 886px) {

        h2 {
            font-size: 40px;
        }

        p {
            font-size: 14px;
            padding: 0 30px;
            margin: 0 0 4vh 0;
        }

        .date_vacation div input,
        label {
            font-size: 16px;
        }
    }

    @media (max-width: 450px) {
        h2 {
            font-size: 30px;
        }
    }
</style>

<script>
    const inputStart = document.getElementById('date_start_vacation')
    const inputEnd = document.getElementById('date_finish_vacation')

    function calculateDateDiff() {
        let start = inputStart.value
        let end = inputEnd.value

        start = new Date(start)
        end = new Date(end)

        let diffInTime = Math.abs(end - start)
        let timeInOneDay = 1000 * 60 * 60 * 24 //milisegundos * segundos * minutos *horas dia
        let diffInDays = Math.ceil(diffInTime / timeInOneDay)

        return diffInDays
    }

    function getData() {
        return {
            'vacation_start_date': inputStart.value,
            'vacation_end_date': inputEnd.value
        }
    }
</script>