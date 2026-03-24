<?php
include "conexao.php";

$nome = $_POST['nome_produto'];
$marca = $_POST['marca'];
$cor = $_POST['cor'];
$tamanho = $_POST['tamanho'];
$fornecedor_id = $_POST['fornecedor_id'];

try {
    // Verifica duplicidade do produto para o fornecedor
    $sql_verifica = "SELECT id FROM produto 
                     WHERE nome_produto = :nome AND fornecedor_id = :fornecedor_id";
    
    $stmt = $conn->prepare($sql_verifica);
    $stmt->execute([
        ':nome' => $nome,
        ':fornecedor_id' => $fornecedor_id
    ]);

    if ($stmt->rowCount() > 0) {
        echo "Produto já cadastrado para este fornecedor.";
    } else {
        // Inserir produto
        $sql = "INSERT INTO produto (nome_produto, marca, cor, tamanho, fornecedor_id)
                VALUES (:nome, :marca, :cor, :tamanho, :fornecedor_id)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':marca' => $marca,
            ':cor' => $cor,
            ':tamanho' => $tamanho,
            ':fornecedor_id' => $fornecedor_id
        ]);

        echo "Produto cadastrado com sucesso!";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>