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

try {
    // Inicia transação (boa prática)
    $conn->beginTransaction();

    // Inserir endereço
    $sql_endereco = "INSERT INTO endereco (rua, numero, bairro, cidade, estado, cep, complemento)
                     VALUES (:rua, :numero, :bairro, :cidade, :estado, :cep, :complemento)";
    
    $stmt = $conn->prepare($sql_endereco);
    $stmt->execute([
        ':rua' => $rua,
        ':numero' => $numero,
        ':bairro' => $bairro,
        ':cidade' => $cidade,
        ':estado' => $estado,
        ':cep' => $cep,
        ':complemento' => $complemento
    ]);

    // Pega o ID do endereço inserido
    $endereco_id = $conn->lastInsertId();

    // Inserir cliente
    $sql_cliente = "INSERT INTO cliente (nome, cpf, telefone, endereco_id)
                    VALUES (:nome, :cpf, :telefone, :endereco_id)";
    
    $stmt = $conn->prepare($sql_cliente);
    $stmt->execute([
        ':nome' => $nome,
        ':cpf' => $cpf,
        ':telefone' => $telefone,
        ':endereco_id' => $endereco_id
    ]);

    // Confirma tudo
    $conn->commit();

    echo "Cliente cadastrado com sucesso!";

} catch (PDOException $e) {
    // Desfaz tudo se der erro
    $conn->rollBack();
    echo "Erro: " . $e->getMessage();
}
?>