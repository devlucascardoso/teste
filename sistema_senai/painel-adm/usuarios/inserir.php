<?php 
require_once("../../conexao.php");

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$endereco = $_POST['endereco'];
$id = $_POST['id'];

$antigo = $_POST['antigo'];

// EVITAR DUPLICIDADE NO CPF
if($antigo != $cpf){
	$query_con = $pdo->prepare("SELECT * from usuarios WHERE cpf = :cpf");
	$query_con->bindValue(":cpf", $cpf);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res_con) > 0){
		echo 'O CPF do usuário já está cadastrado!';
		exit();
	}
}

if($id == ""){
	$res = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, endereco = :endereco");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":endereco", $endereco);
	$res->execute();
}else{
	$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, endereco = :endereco WHERE id = :id");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":endereco", $endereco);
	$res->bindValue(":id", $id);
	$res->execute();
//bindValue recebe tanto variáveis como strings
//bindParam -> não
}


echo 'Salvo com Sucesso!';
?>