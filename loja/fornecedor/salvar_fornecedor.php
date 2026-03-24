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

try {
    // Verifica duplicidade de CNPJ
    $sql_verifica = "SELECT id FROM fornecedor WHERE cnpj = :cnpj";
    $stmt = $conn->prepare($sql_verifica);
    $stmt->execute([':cnpj' => $cnpj]);

    if ($stmt->rowCount() > 0) {
        echo "CNPJ já cadastrado no sistema.";
    } else {
        // Inicia transação
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

        // Pega ID do endereço
        $endereco_id = $conn->lastInsertId();

        // Inserir fornecedor
        $sql_fornecedor = "INSERT INTO fornecedor (nome, cnpj, telefone, endereco_id)
                           VALUES (:nome, :cnpj, :telefone, :endereco_id)";
        
        $stmt = $conn->prepare($sql_fornecedor);
        $stmt->execute([
            ':nome' => $nome,
            ':cnpj' => $cnpj,
            ':telefone' => $telefone,
            ':endereco_id' => $endereco_id
        ]);

        // Confirma tudo
        $conn->commit();

        echo "Fornecedor cadastrado com sucesso!";
    }

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Erro: " . $e->getMessage();
}
?>