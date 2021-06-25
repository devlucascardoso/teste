<?php 
require_once("../../conexao.php");

$nome = $_POST['nome'];
$num_conta = $_POST['num_conta'];
$valor = $_POST['valor'];
$tipo = $_POST['tipo'];
$id = $_POST['id'];

if ($tipo == "retirar"){
	$valor = $valor * (-1);
}

if($id == ""){
	$res = $pdo->prepare("INSERT INTO movimentacao SET data = curDate(), hora = curTime(), nome = :nome, num_conta = :num_conta, valor = :valor, tipo = :tipo");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":num_conta", $num_conta);
	$res->bindValue(":valor", $valor);
	$res->bindValue(":tipo", $tipo);
	$res->execute();
}else{
	$res = $pdo->prepare("UPDATE movimentacao SET data = curDate(), hora = curTime(), nome = :nome, num_conta = :num_conta, valor = :valor, tipo = :tipo WHERE id = :id");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":num_conta", $num_conta);
	$res->bindValue(":valor", $valor);
	$res->bindValue(":tipo", $tipo);
	$res->bindValue(":id", $id);
	$res->execute();
//bindValue recebe tanto variáveis como strings
//bindParam -> não
}


echo 'Salvo com Sucesso!';
?>