<?php
include "conexao.php";

$nome = $_POST['nome'];
$cnpj = $_POST['cnpj'];
$telefone = $_POST['telefone'];

// Dados do endereço
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];
$complemento = $_POST['complemento'];

// Verifica duplicidade CNPJ
$verificar = "SELECT id FROM fornecedor WHERE cnpj='$cnpj'";
$resultado = $conn->query($verificar);

if ($resultado->num_rows > 0) {
    echo "CNPJ já cadastrado no sistema.";
} else {
    // Inserir endereço
    $sql_endereco = "INSERT INTO endereco(rua, numero, bairro, cidade, estado, cep, complemento)
                     VALUES('$rua','$numero','$bairro','$cidade','$estado','$cep','$complemento')";
    if ($conn->query($sql_endereco) === TRUE) {
        $endereco_id = $conn->insert_id;

        // Inserir fornecedor
        $sql_fornecedor = "INSERT INTO fornecedor(nome, cnpj, telefone, endereco_id)
                           VALUES('$nome','$cnpj','$telefone','$endereco_id')";
        if ($conn->query($sql_fornecedor) === TRUE) {
            echo "Fornecedor cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar fornecedor: " . $conn->error;
        }
    } else {
        echo "Erro ao cadastrar endereço: " . $conn->error;
    }
}

$conn->close();
?>