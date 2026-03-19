<?php
include "conexao.php";

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];

// Verifica duplicidade pelo nome
$verificar = "SELECT id FROM vendedor WHERE nome='$nome'";
$resultado = $conn->query($verificar);

if ($resultado->num_rows > 0) {
    echo "Vendedor já cadastrado com este nome.";
} else {
    $sql = "INSERT INTO vendedor(nome, telefone, quantidade_vendas, cliente_vendas)
            VALUES('$nome','$telefone',0,'')";
    if ($conn->query($sql) === TRUE) {
        echo "Vendedor cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar vendedor: " . $conn->error;
    }
}

$conn->close();
?>