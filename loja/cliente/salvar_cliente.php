<?php
include "conexao.php";

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];

// Dados do endereço
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];
$complemento = $_POST['complemento'];

// Inserir endereço primeiro
$sql_endereco = "INSERT INTO endereco(rua, numero, bairro, cidade, estado, cep, complemento)
                 VALUES('$rua','$numero','$bairro','$cidade','$estado','$cep','$complemento')";

if ($conn->query($sql_endereco) === TRUE) {
    $endereco_id = $conn->insert_id;

    // Inserir cliente com endereco_id
    $sql_cliente = "INSERT INTO cliente(nome, cpf, telefone, endereco_id)
                    VALUES('$nome','$cpf','$telefone','$endereco_id')";

    if ($conn->query($sql_cliente) === TRUE) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar cliente: " . $conn->error;
    }

} else {
    echo "Erro ao cadastrar endereço: " . $conn->error;
}

$conn->close();
?>