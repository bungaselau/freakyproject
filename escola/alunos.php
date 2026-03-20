<?php
// 1. CONFIGURAÇÕES DE CONEXÃO
$host = "localhost";
$user = "root";
$pass = "";
$db = "escola";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// 2. LÓGICA DE EXCLUSÃO
if (isset($_GET['excluir'])) {
    $id_excluir = intval($_GET['excluir']);
    $sql_delete = "DELETE FROM `alunos.dados` WHERE id = $id_excluir";
    
    if ($conn->query($sql_delete) === TRUE) {
        // Redireciona para limpar a URL e evitar exclusão repetida
        header("Location: " . $_SERVER['PHP_SELF'] . "?msg=excluido");
        exit();
    }
}

// 3. LÓGICA DE CADASTRO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];

    $sql = "INSERT INTO `alunos.dados` (nome, email, rua, numero, complemento, bairro, cidade) 
            VALUES ('$nome', '$email', '$rua', '$numero', '$complemento', '$bairro', '$cidade')";

    if ($conn->query($sql) === TRUE) {
        // Redireciona para evitar reenvio de dados ao atualizar (F5)
        header("Location: " . $_SERVER['PHP_SELF'] . "?msg=sucesso");
        exit();
    }
}

// 4. BUSCA PARA A LISTA
$sql_lista = "SELECT * FROM `alunos.dados` ORDER BY nome ASC";
$result = $conn->query($sql_lista);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Alunos</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        .container { max-width: 900px; margin: auto; }
        form { background: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 8px; margin: 5px 0 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        .btn-excluir { background: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-links">
        <a href="index.php">📍 Cadastro de Salas</a>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alert" style="color: <?php echo $_GET['msg'] == 'sucesso' ? 'green' : 'orange'; ?>;">
            <?php 
                if($_GET['msg'] == 'sucesso') echo "✅ Aluno cadastrado com sucesso!";
                if($_GET['msg'] == 'excluido') echo "🗑️ Registro removido com sucesso!";
            ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <h2>Cadastrar Novo Aluno</h2>
        <input type="text" name="nome" placeholder="Nome Completo" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="rua" placeholder="Rua" required>
        <input type="text" name="numero" placeholder="Número" required>
        <input type="text" name="complemento" placeholder="Complemento">
        <input type="text" name="bairro" placeholder="Bairro" required>
        <input type="text" name="cidade" placeholder="Cidade" required>
        <button type="submit">Salvar Aluno</button>
    </form>

    <h2>Lista de Alunos</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo "{$row['rua']}, {$row['numero']} ({$row['complemento']})"; ?></td>
                        <td>
                            <a href="?excluir=<?php echo $row['id']; ?>" class="btn-excluir" onclick="return confirm('Deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">Nenhum aluno cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
