<?php
include "./Controller/controller.php";


$nome = $_GET["nome"];
$item = $_GET["item"];
$quantidade = $_GET["quantidade"];
$observacoes = $_GET["observacoes"];

$controlador = new Controller();
$controlador->grava_pedido($nome,$item,$quantidade,$observacoes);

// Configuração do banco de dados
$servername = "localhost"; // Substitua pelo seu servidor de banco de dados
$username = "seu_usuario"; // Substitua pelo seu usuário do banco de dados
$password = "sua_senha";   // Substitua pela sua senha do banco de dados
$dbname = "lanchonete"; // Substitua pelo nome do seu banco de dados

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Coleta e sanitiza dados do formulário
$nome = $conn->real_escape_string($_POST['nome']);
$item = $conn->real_escape_string($_POST['item']);
$quantidade = intval($_POST['quantidade']);
$observacoes = $conn->real_escape_string($_POST['observacoes']);

// Prepara e executa a query de inserção
$sql = "INSERT INTO pedidos (nome, item, quantidade, observacoes) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssis", $nome, $item, $quantidade, $observacoes);

if ($stmt->execute()) {
    echo "Novo pedido registrado com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();

?>