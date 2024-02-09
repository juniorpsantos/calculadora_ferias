<?php
//id=quest_one -> sallary
//id=quest_two -> is_resignation
//// Se o usuário selecionar demissão
//id=resignation_one -> total_work_days     
//id=resignation_result -> result
//// else
//id=vacation_one -> total_vocation_days
//id=sale -> is_sale_vocation
//id=vacation_result -> result

include_once('config.php');

session_start();

// check if exists jwt token in session 
if (!isset($_SESSION['jwt'])) {
    header('Location: /secret/');
    exit;
}

// get current step from http request
$step = $_GET['step'] ?? 'start';
$calculator_id = $_GET['id'] ?? '';
$data = [];

function getLastDataFromCalculadora($user_id)
{
    global $conexao;
    $sql = "SELECT * FROM calculadora WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        // Handle error - for example, log or throw an exception
        echo "Error preparing statement: " . $conexao->error;
        return false;
    }
    $result = $stmt->get_result();
    $data = $result->fetch_assoc(); // Fetch the data as an associative array
    return $data;
}

if (empty($step) || $step == 'start') {
    $data = getLastDataFromCalculadora($_SESSION['user_id']);
    debug_to_console($data);
}

?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <title>dashboard</title>
</head>

<body>
    <nav>
        <div class="nav-bar">
            <h1>Dashboard</h1>
            <button id="exit_button">Sair</button>
        </div>
    </nav>

    <main class="main-container">
        <div class="content">


            <?php
            if (empty($step) || $step == 'start') {
                include('pages/components/init.php'); //id=start
            } elseif ($step == 'quest_one')
                include('pages/components/questOne.php'); //id=quest_one
            elseif ($step == 'quest_two')
                include('pages/components/questTwo.php'); //id=quest_two
            elseif ($step == 'resignation_one')
                include('pages/components/resignationOne.php'); //id=resignation_one
            elseif ($step == 'resignation_result')
                include('pages/components/resignationResult.php'); //id=resignation_result
            elseif ($step == 'vacation_one')
                include('pages/components/vacationOne.php'); //id=vacation_one
            elseif ($step == 'sale')
                include('pages/components/sale.php'); // id=sale
            elseif ($step == 'vacation_result')
                include('pages/components/vacationResult.php'); //id=vacation_result
            ?>

            <div class='button_group'>
                <?php
                if (!empty($step)) {
                    if ($step == 'quest_one' || $step == 'quest_two' || $step == 'resignation_one' || $step == 'vacation_one' || $step == 'sale') {
                        echo '<button id="back_button" class="button_back">Voltar</button>';
                        echo '<button id="cancel_button" class="button_cancel">Cancelar</button>';
                    }
                    if ($step == 'quest_one' || $step == 'resignation_one' || $step == 'vacation_one' || $step == 'sale' || $step == 'init' || $step == 'quest_two') {
                        echo '<button id="next_button" class="button_next">Continuar</button>';
                    }
                    if ($step == 'vacation_result' || $step == 'resignation_result') {
                        echo '<button id="end_button" class="button_end">Concluir</button>';
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <style>
        .button_group {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .button_back,
        .button_cancel,
        .button_next,
        .button_end {
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

        .button_end:hover {
            background: #3286ca;
        }

        .button_back:hover {
            background: #3286ca;
        }

        .button_cancel:hover {
            background: #3286ca;
        }

        .button_next:hover {
            background: #3286ca;
        }
    </style>

    <script>
        // get current step
        var step = '<?php echo $step; ?>';

        function request(data) {
            const _data = {
                ...data,
                step: step
            };
            // se o $calculator_id não estiver vazio, adicione-o ao objeto _data
            if ('<?php echo $calculator_id; ?>' != '') {
                _data.id = '<?php echo $calculator_id; ?>';
            }

            console.log("Enviando requisição: ", _data);
            $.ajax({
                type: "POST",
                url: '/secret/api/calculator_post.php',
                data: _data,
                success: function(data) {
                    if (step == 'resignation_result' || step == 'vacation_result') {
                        window.location.href = '/secret/dashboard';
                    } else {
                        window.location.href = '/secret/dashboard?step=' + data.step + '&id=' + data.id;
                    }
                },
                error: function(data) {
                    alert('Erro ao processar a requisição\n' + data.message);
                }
            });
        }

        // get buttons
        var exit_button = document.getElementById('exit_button');
        var back_button = document.getElementById('back_button');
        var next_button = document.getElementById('next_button');
        var end_button = document.getElementById('end_button');
        var cancel_button = document.getElementById('cancel_button');

        var start_button = document.getElementById('start_button');

        // add event listeners
        exit_button != null && exit_button.addEventListener('click', function() {
            $.ajax({
                type: "POST",
                url: '/secret/api/logout.php',
                success: function(data) {
                    console.log(data);
                    window.location.href = '/secret/';
                },
                error: function(data) {
                    const response = JSON.parse(data);
                    alert('Erro ao processar a requisição\n' + response.message);
                }
            });
        });

        back_button != null && back_button.addEventListener('click', function() {
            if (step == 'quest_two' || step == 'resignation_one' || step == 'vacation_one') {
                window.location.href = '/secret/dashboard';
            } else if (step == 'resignation_result' || step == 'vacation_result') {
                window.location.href = '/secret/dashboard';
            } else if (step == 'colaborator_faults') {
                window.location.href = '/secret/dashboard';
            }
        });

        next_button != null && next_button.addEventListener('click', function() {
            request(getData());
        });

        end_button != null && end_button.addEventListener('click', function() {
            request(getData());
        });

        cancel_button != null && cancel_button.addEventListener('click', function() {
            $.ajax({
                type: "POST",
                url: '/secret/api/calculator_del.php',
                data: {
                    id: '<?php echo $calculator_id; ?>'
                },
                success: function(data) {
                    console.log(data);
                    window.location.href = '/secret/dashboard'
                },
                error: function(data) {
                    const response = JSON.parse(data);
                    alert('Erro ao processar a requisição\n' + response.message);
                }
            });
        });

        start_button != null && start_button.addEventListener('click', function() {
            request({
                step: 'start'
            });
        });
    </script>
</body>

</html>