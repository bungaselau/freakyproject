<?php
include "conexao.php";

$produto_id = $_POST['produto_id'];
$quantidade = $_POST['quantidade_calca'];
$preco_fornecedor = $_POST['preco_fornecedor'];
$preco_venda = $_POST['preco_venda'];

// Verifica se já existe estoque para o produto
$verificar = "SELECT id FROM estoque WHERE produto_id='$produto_id'";
$resultado = $conn->query($verificar);

if ($resultado->num_rows > 0) {
    echo "Estoque já cadastrado para este produto.";
} else {
    $sql = "INSERT INTO estoque(produto_id, quantidade_calca, preco_fornecedor, preco_venda)
            VALUES('$produto_id','$quantidade','$preco_fornecedor','$preco_venda')";
    if ($conn->query($sql) === TRUE) {
        echo "Estoque cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar estoque: " . $conn->error;
    }
}

$conn->close();
?>