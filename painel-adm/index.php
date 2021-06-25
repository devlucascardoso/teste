<?php

require_once('../config.php');

//VARIAVEIS DO MENU
$menu1 = 'usuarios';
$menu2 = 'conta';
$menu3 = 'movimentacao';

?>

<!DOCTYPE html>
<html>
<head>
  <title>Prova PHP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <link rel="stylesheet" type="text/css" href="../vendor/DataTabels/datatables.min.css"/>

  <script type="text/javascript" src="../vendor/DataTabels/datatables.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php?pagina=<?php echo $menu1 ?>">Usuário</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?pagina=<?php echo $menu2 ?>">Conta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?pagina=<?php echo $menu3 ?>">Movimentações</a>
          </li>
        </div>
      </div>
    </nav>

    <div class="container-fluid mt-2">
      <?php 

      if(@$_GET['pagina'] == $menu1){
        require_once($menu1. '.php');
      }

      else if(@$_GET['pagina'] == $menu2){
        require_once($menu2. '.php');
      }

      else if(@$_GET['pagina'] == $menu3){
        require_once($menu3. '.php');
      }

      else{
        require_once($menu1. '.php');
      }

      ?>
    </div>

  </body>
  </html>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
  <script type="text/javascript" src="../vendor/js/mascaras.js"></script>