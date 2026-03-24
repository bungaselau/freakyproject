<?php
include "conexao.php";

$cliente_id = $_POST['cliente_id'];
$produto_id = $_POST['produto_id'];
$vendedor_id = $_POST['vendedor_id'];
$quantidade = $_POST['quantidade'];
$valor_total = $_POST['valor_total'];

try {
    // Inserir venda
    $sql = "INSERT INTO venda 
            (cliente_id, produto_id, vendedor_id, quantidade, valor_total, data_venda)
            VALUES 
            (:cliente_id, :produto_id, :vendedor_id, :quantidade, :valor_total, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':cliente_id' => $cliente_id,
        ':produto_id' => $produto_id,
        ':vendedor_id' => $vendedor_id,
        ':quantidade' => $quantidade,
        ':valor_total' => $valor_total
    ]);

    echo "Venda registrada com sucesso!";

} catch (PDOException $e) {
    echo "Erro ao registrar venda: " . $e->getMessage();
}
?>