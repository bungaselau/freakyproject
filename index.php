<?php
// 1. CONEXÃO COM O BANCO
$host = "localhost";
$user = "root";
$pass = "";
$db = "escola";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("<div style='color:red'>Erro de conexão: " . $conn->connect_error . "</div>");
}

// 2. LÓGICA PARA DELETAR
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM alunos WHERE id=$id");
    header("Location: index.php?msg=removido");
    exit();
}

// 3. LÓGICA PARA INSERIR (Agora permanece na mesma página)
if (isset($_POST['salvar'])) {
    $nome = $conn->real_escape_string($_POST['nome']);
    $periodo = $conn->real_escape_string($_POST['periodo']);
    $sala = $conn->real_escape_string($_POST['sala']);
    
    $sql = "INSERT INTO alunos (nome, periodo, sala) VALUES ('$nome', '$periodo', '$sala')";
    
    if ($conn->query($sql)) {
        // PERMANECE NO INDEX.PHP COM MENSAGEM DE SUCESSO
        header("Location: index.php?msg=sucesso");
        exit();
    }
}

// 4. BUSCAR DADOS
$result = $conn->query("SELECT * FROM alunos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema Escolar - Salas</title>
    <style>
        :root { --primary: #a61010; --dark: #2c3e50; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .form-group { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end; }
        input { padding: 10px; border: 1px solid #ddd; border-radius: 8px; width: 100%; box-sizing: border-box; }
        button { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; }
        th { background: var(--primary); color: white; padding: 15px; text-align: left; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        .btn-delete { color: #e74c3c; text-decoration: none; font-size: 0.9rem; border: 1px solid #fed7d7; padding: 5px; border-radius: 4px; }
        .nav-links { margin-bottom: 20px; padding: 10px; background: white; border-radius: 8px; }
        .nav-links a { text-decoration: none; color: var(--primary); font-weight: bold; margin-right: 15px; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-links"> 
        <a href="alunos.php">🏠 Cadastrar Endereços</a>
    </div>

    <h2>Painel de Controle de Salas</h2>

    <?php if(isset($_GET['msg'])): ?>
        <p style="color: <?php echo $_GET['msg'] == 'sucesso' ? 'green' : 'orange'; ?>; font-weight: bold;">
            <?php echo $_GET['msg'] == 'sucesso' ? "✅ Aluno e sala cadastrados!" : "🗑️ Registro removido!"; ?>
        </p>
    <?php endif; ?>

    <div class="card">
        <form method="POST" class="form-group">
            <div><label>Nome</label><input type="text" name="nome" required></div>
            <div><label>Período</label><input type="text" name="periodo" required></div>
            <div><label>Sala</label><input type="text" name="sala" required></div>
            <!-- BOTAO ALTERADO PARA SALVAR -->
            <button type="submit" name="salvar">Salvar Aluno</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Período</th>
                <th>Sala</th>
                <th style="text-align:center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['periodo']; ?></td>
                <td><?php echo $row['sala']; ?></td>
                <td style="text-align:center;">
                    <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Excluir aluno?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
