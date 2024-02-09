<div id="resignation_one" class='resignation_one_container'>
    <h2>Selecione o período:</h2>
    <p>Para selecionar o périodo você vai olhar a partir da data de início trabalho do ultimo ano.
        <br><em>Exemplo: data de retorno do ultimo período de férias.</em> <br /><br />Se o funcionário tiver menos que
        um ano de empresa o início é a data de contratação.
    </p>
    <div class='date_resignation'>
        <div class='resignation_input'>
            <label for="date_start_input">Início</label>
            <input type="date" id='start' name='date_start_input'>
        </div>
        <div class='resignation_input'>
            <label for="date_finish_input">Término</label>
            <input type="date" id='end' name='date_finish_input'>
        </div>
    </div>
</div>

<style>
    .resignation_one_container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

    h2 {
        font-size: 50px;
        margin-top: 5vh;
        text-align: center;
    }

    p {
        font-size: 16px;
        padding: 10px;
        margin: 4vh 0 4vh 0;
    }

    .resignation_input {
        display: flex;
        justify-content: start;
        flex-direction: column;
        align-items: start;
        margin: 0 4vw 3vh 4vw;
    }

    .date_resignation {
        display: flex;
        padding: 20px;
        justify-content: center;
    }

    .date_resignation div input,
    label {
        font-size: 18px;
        outline: none;
        border-radius: 3px;
        border: none;
    }

    @media (max-width: 886px) {
        h2 {
            font-size: 40px;
        }

        p {
            font-size: 14px;
            padding: 0 30px;
        }

        .date_resignation div input,
        label {
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
    }
</style>

<script>
    const inputStart = document.getElementById('start');
    const inputEnd = document.getElementById('end');

    function calculateDateDiff() {
        let start = inputStart.value;
        let end = inputEnd.value; // Fixed variable name

        start = new Date(start); // Fixed syntax error
        end = new Date(end); // Fixed syntax error

        let diffInTime = Math.abs(end - start);
        let timeInOneDay = 1000 * 60 * 60 * 24; // Milliseconds * seconds * minutes * hours
        let diffInDays = Math.ceil(diffInTime / timeInOneDay);

        return diffInDays;
    }

    function getData() {
        return {
            'work_start_date': inputStart.value,
            'work_end_date': inputEnd.value
        };
    }
</script>