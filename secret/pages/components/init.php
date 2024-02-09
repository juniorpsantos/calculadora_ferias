<div class='init_container'>
    <h2>Bem vindo(a)
        <?php
        if (!empty($_SESSION['user_name'])) {
            echo $_SESSION['user_name'];
        }
        ?>
        <br> à Calculadora de Férias
    </h2>

    <div <?php if (empty($data)) {
                echo "style='display: none;'";
            } ?>
            >
        <p>
            <?php
            if (!empty($data)) {
                echo "Último cálculo realizado em " . date('d/m/Y', strtotime($data['created_at'])) . " às " . date('H:i', strtotime($data['created_at'])) . "h";
                echo "<br>";
                echo "Com o valor de R$ " . number_format($data['result'], 2, ',', '.');
            }
            ?>
        </p>
    </div>

</div>
<?php
if (empty($data)) {
    echo "<button id='start_button' class='button_init'>Iniciar Cálculo</button>";
} else {
    echo "<button id='start_button' class='button_init'>Realizar novo cálculo</button>";
}
?>
</div>

<style>
    .init_container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-top: 10vh;

    }

    h2 {
        font-size: 50px;
        margin-bottom: 8vh;
    }

    .button_init {
        padding: 5px 10px;
        margin: 30px 10px 0 10px;
        background: #4aa4ee;
        color: #fff;
        border: none;
        font-weight: 500;
        cursor: pointer;
        font-size: 20px;
        transition: 0.3s;
        border-radius: 5px;
    }

    .button_init:hover {
        background: #3286ca;
    }


    @media (max-width: 886px) {
        h2 {
            font-size: 40px;
        }

        @media (max-width: 450px) {
            h2 {
                font-size: 30px;
            }
        }
    }
</style>