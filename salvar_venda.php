<?php
include "conexao.php";

$cliente_id = $_POST['cliente_id'];
$produto_id = $_POST['produto_id'];
$vendedor_id = $_POST['vendedor_id'];
$quantidade = $_POST['quantidade'];
$valor_total = $_POST['valor_total'];

// Inserir venda
$sql = "INSERT INTO venda(cliente_id, produto_id, vendedor_id, quantidade, valor_total, data_venda)
        VALUES('$cliente_id','$produto_id','$vendedor_id','$quantidade','$valor_total', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "Venda registrada com sucesso!";
} else {
    echo "Erro ao registrar venda: " . $conn->error;
}

$conn->close();
?>