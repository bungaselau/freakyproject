<?php
include "conexao.php";

$nome = $_POST['nome_produto'];
$marca = $_POST['marca'];
$cor = $_POST['cor'];
$tamanho = $_POST['tamanho'];
$fornecedor_id = $_POST['fornecedor_id'];

// Verifica duplicidade do produto para o fornecedor
$verificar = "SELECT id FROM produto WHERE nome_produto='$nome' AND fornecedor_id='$fornecedor_id'";
$resultado = $conn->query($verificar);

if ($resultado->num_rows > 0) {
    echo "Produto já cadastrado para este fornecedor.";
} else {
    $sql = "INSERT INTO produto(nome_produto, marca, cor, tamanho, fornecedor_id)
            VALUES('$nome','$marca','$cor','$tamanho','$fornecedor_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto: " . $conn->error;
    }
}

$conn->close();
?>