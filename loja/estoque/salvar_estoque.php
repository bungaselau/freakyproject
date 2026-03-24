<?php
include "conexao.php";

$produto_id = $_POST['produto_id'];
$quantidade = $_POST['quantidade_calca'];
$preco_fornecedor = $_POST['preco_fornecedor'];
$preco_venda = $_POST['preco_venda'];

try {
    // Verifica se já existe estoque para o produto
    $sql_verifica = "SELECT id FROM estoque WHERE produto_id = :produto_id";
    $stmt = $conn->prepare($sql_verifica);
    $stmt->execute([':produto_id' => $produto_id]);

    if ($stmt->rowCount() > 0) {
        echo "Estoque já cadastrado para este produto.";
    } else {
        // Inserir estoque
        $sql = "INSERT INTO estoque (produto_id, quantidade_calca, preco_fornecedor, preco_venda)
                VALUES (:produto_id, :quantidade, :preco_fornecedor, :preco_venda)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':produto_id' => $produto_id,
            ':quantidade' => $quantidade,
            ':preco_fornecedor' => $preco_fornecedor,
            ':preco_venda' => $preco_venda
        ]);

        echo "Estoque cadastrado com sucesso!";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>