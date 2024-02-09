<?php
include('config.php');

// Function to get data from the calculadora table by id
function getDataFromCalculadora($id)
{
    global $conexao;
    $sql = "SELECT * FROM calculadora WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        // Handle error - for example, log or throw an exception
        echo "Error preparing statement: " . $conexao->error;
        return false;
    }
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = $result->fetch_assoc(); // Fetch the data as an associative array
        return $data;
    } else {
        // Handle error - for example, log or throw an exception
        echo "Error executing statement: " . $stmt->error;
        return false;
    }
}

$data = getDataFromCalculadora($calculator_id);

// format salary to float, salary is in brl
$data['salary'] = floatval(str_replace(',', '.', str_replace('.', '', $data['salary'])));

function countWorkedMonths($workStartDate, $workEndDate)
{
    // Convert the start and end dates to DateTime objects
    $startDate = new DateTime($workStartDate);
    $endDate = new DateTime($workEndDate);

    // Calculate the difference between the start and end dates
    $interval = $startDate->diff($endDate);

    // Extract the total months and the leftover days
    $totalMonths = $interval->m + ($interval->y * 12); // convert years to months if any
    $leftoverDays = $interval->d;

    // If more than 15 days are worked in the last month, consider it as a full month
    if ($leftoverDays > 15) {
        $totalMonths++;
    }

    return $totalMonths;
}
$months = countWorkedMonths($data['work_start_date'], $data['work_end_date']);

$result_1 = ($data['salary'] * ($months + 1)) / 12; // one more day for the month of resignation
$result_2 = $result_1 / 3;
$result = $result_1 + $result_2;

// Formatar o resultado para exibir apenas dois algarismos após a vírgula
$result = number_format($result, 2, ',', '.');
?>

<div id='resignation_result' class="">
    <h2>Resultado</h2>
    <div>
        <span>Valor do salário: R$ <?php echo $data['salary']; ?></span>
        <br />
        <span>Período: <?php echo $months; ?> mêses + 1 mês de aviso prévio</span>
    </div>
    <div>
        <span>Total a se pagar: R$ <?php echo $result; ?></span>
    </div>
</div>

<style>
    
    h2 {
        font-size: 50px;
        margin-bottom: 20px;
    }

    @media (max-width: 886px) {
        h2 {
            font-size: 40px;
        }
    }

    @media (max-width: 450px) {
        
        h2 {
            font-size: 30px;
        }
    }
</style>

<script>
    function getData() {
        return {
            result: <?php echo $result; ?>
        };
    }
</script>