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

$vacation_days = (strtotime($data['vacation_end_date']) - strtotime($data['vacation_start_date'])) / (60 * 60 * 24);

$result = ($data['salary'] + ($data['salary'] / 3)) + ($data['is_sale_vacation'] ? ($data['salary'] / 3) : 0);

// Formatar o resultado para exibir apenas dois algarismos após a vírgula
$result = number_format($result, 2, '.', ',');

?>

<div id='vacation_result'>
    <h2>Resultado para trabalhador de férias</h2>
    <div>
        <span>Valor do salário: <?php echo $data['salary']; ?></span>
        <br />
        <!-- vacation_start_date and vacation_end_date format to brl -->
        <span>Período de férias de <?php echo date('d/m/Y', strtotime($data['vacation_start_date'])); ?> até <?php echo date('d/m/Y', strtotime($data['vacation_end_date'])); ?>(<?php echo $vacation_days; ?> dias)</span>
        <br />
        <span>Venda de férias? <?php echo $data['is_sale_vacation'] ? 'Sim' : 'Não'; ?></span>
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