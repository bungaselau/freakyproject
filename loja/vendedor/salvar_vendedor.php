<?php
include "conexao.php";

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];

try {
    // Verifica duplicidade pelo nome
    $sql_verifica = "SELECT id FROM vendedor WHERE nome = :nome";
    $stmt = $conn->prepare($sql_verifica);
    $stmt->execute([':nome' => $nome]);

    if ($stmt->rowCount() > 0) {
        echo "Vendedor já cadastrado com este nome.";
    } else {
        // Inserir vendedor
        $sql = "INSERT INTO vendedor (nome, telefone, quantidade_vendas, cliente_vendas)
                VALUES (:nome, :telefone, 0, '')";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':telefone' => $telefone
        ]);

        echo "Vendedor cadastrado com sucesso!";
    }

} catch (PDOException $e) {
    echo "Erro ao cadastrar vendedor: " . $e->getMessage();
}
?>