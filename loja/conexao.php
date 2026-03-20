<?php
$host = "localhost";
$user = "root";
$senha = "";
$banco = "loja";

// Conexão segura usando mysqli
$conn = new mysqli($host, $user, $senha, $banco);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Função para excluir o banco de dados de forma segura
function excluirBanco($conn, $banco, $confirmacao) {
    // Só executa se a confirmação for exatamente "SIM"
    if ($confirmacao === "SIM") {
        $sql = "DROP DATABASE `$banco`";
        if ($conn->query($sql) === TRUE) {
            echo "Banco de dados '$banco' excluído com sucesso!";
        } else {
            echo "Erro ao excluir banco: " . $conn->error;
        }
    } else {
        echo "Exclusão cancelada. Para excluir, defina a confirmação como 'SIM'.";
    }
}

// Exemplo de uso (apenas se você realmente quiser apagar o banco)
// excluirBanco($conn, $banco, "SIM");

$conn->close();
?>