<?php 
require_once("../../conexao.php");

$nome = $_POST['nome'];
$num_conta = $_POST['num_conta'];
$id = $_POST['id'];

$antigo = $_POST['antigo'];

// EVITAR DUPLICIDADE NO NUM CONTA
if($antigo != $num_conta){
	$query_con = $pdo->prepare("SELECT * from conta WHERE num_conta = :num_conta");
	$query_con->bindValue(":num_conta", $num_conta);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res_con) > 0){
		echo 'O Número da Conta do usuário já está cadastrado!';
		exit();
	}
}

if($id == ""){
	$res = $pdo->prepare("INSERT INTO conta SET nome = :nome, num_conta = :num_conta");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":num_conta", $num_conta);
	$res->execute();
}else{
	$res = $pdo->prepare("UPDATE conta SET nome = :nome, num_conta = :num_conta WHERE id = :id");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":num_conta", $num_conta);
	$res->bindValue(":id", $id);
	$res->execute();
//bindValue recebe tanto variáveis como strings
//bindParam -> não
}


echo 'Salvo com Sucesso!';
?>