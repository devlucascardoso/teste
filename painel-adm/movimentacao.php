<?php 

$pag = 'movimentacao';

require_once('../conexao.php');
?>


<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-secondary mt-2">Realizar Transação</a>

<div class="mt-4" style="margin-right:25px">
  <?php 
  $query = $pdo->query("SELECT * from movimentacao order by id desc");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_reg = @count($res);
  //quando é SELECT é passado Fetchall, se passar execute vai dar erro de sintaxe!
  //prepare -> params -> execute!
  if($total_reg > 0){ 
    ?>

    <small>
      <table id="example" class="table table-hover my-4" style="width:100%">
        <thead>
          <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Número da Conta</th>
            <th>Saldo</th>
            <th>Extrato</th>
            <th>Editar</th>
            <th>Deletar</th>
          </tr>
        </thead>
        <tbody>

          <?php 
          for($i=0; $i < $total_reg; $i++){
            foreach ($res[$i] as $key => $value){ }

          //BUSCAR OS DADOS DO CLIENTE
              $id_nome = $res[$i]['nome'];
            $query_f = $pdo->query("SELECT * from usuarios where id = '$id_nome'");
            $res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
            $total_reg_f = @count($res_f);
            if($total_reg_f > 0){ 
              $usuario_nome = $res_f[0]['nome'];
              $cpf_nome = $res_f[0]['cpf'];
            }
            //BUSCAR OS DADOS DA CONTA
            $id_conta = $res[$i]['num_conta'];
            $query_f = $pdo->query("SELECT * from conta where id = '$id_conta'");
            $res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
            $total_reg_f = @count($res_f);
            if($total_reg_f > 0){ 
              $usuario_conta = $res_f[0]['num_conta'];
            }
            ?>

            <tr>
              <td><?php echo $usuario_nome ?></td>
              <td><?php echo $cpf_nome ?></td>
              <td><?php echo $usuario_conta ?></td>
              <td><?php echo $res[$i]['valor'] ?></td>
              <td>
                <a href="index.php?pagina=<?php echo $pag ?>&funcao=extrato&id=<?php echo $res[$i]['id'] ?>" title="Extrato">
                  <i class="bi bi-pencil-square text-primary"></i>
                </a>
              </td>
              <td>
                <a href="index.php?pagina=<?php echo $pag ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>" title="Editar Registro">
                  <i class="bi bi-pencil-square text-primary"></i>
                </a>
              </td> 

              <td>
                <a href="index.php?pagina=<?php echo $pag ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>" title="Excluir Registro">
                  <i class="bi bi-archive text-danger mx-1"></i>
                </a>
              </td>
            </tr>

          <?php } ?>

        </tbody>

      </table>
      </small>  <?php }else{
        echo '<p>Não existem dados para serem exibidos!!';
      } ?>
    </div>


    <?php 
    if(@$_GET['funcao'] == "editar"){
      $titulo_modal = 'Editar Registro';
      $query = $pdo->query("SELECT * from movimentacao where id = '$_GET[id]'");
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
      $total_reg = @count($res);
      if($total_reg > 0){ 
        $nome = $res[0]['nome'];
        $num_conta = $res[0]['num_conta'];
        $valor = $res[0]['valor'];
        $tipo = $res[0]['tipo'];
        $id = $res[0]['id'];


      }
    }else{
      $titulo_modal = 'Inserir Registro';
    }
    ?>


    <div class="modal fade" tabindex="-1" id="modalCadastrar" data-bs-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" id="form">
            <div class="modal-body">

              <div class="row">
                <div class="col-md">
                  <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nome</label>  
                    <select class="form-select mt-1" aria-label="Default select example" name="nome">
                      <?php 
                      $query = $pdo->query("SELECT * from usuarios order by nome asc");
                      $res = $query->fetchAll(PDO::FETCH_ASSOC);
                      $total_reg = @count($res);
                      if($total_reg > 0){ 

                        for($i=0; $i < $total_reg; $i++){
                          foreach ($res[$i] as $key => $value){ }
                            ?>

                          <option <?php if(@$nome == $res[$i]['id']){ ?> selected <?php } ?>  value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?> - <?php echo $res[$i]['cpf'] ?></option>

                        <?php }

                      }else{ 
                        echo '<option value="">Cadastre um Usuário</option>';

                      } ?>
                    </select>
                  </div> 
                </div>
              </div>

              <div class="row">
                <div class="col-md">
                  <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Número da Conta</label>  
                    <select class="form-select mt-1" aria-label="Default select example" name="num_conta">
                      <?php 
                      $query = $pdo->query("SELECT * from conta order by num_conta asc");
                      $res2 = $query->fetchAll(PDO::FETCH_ASSOC);
                      $total_reg = @count($res2);
                      if($total_reg > 0){ 

                        for($i=0; $i < $total_reg; $i++){
                          foreach ($res2[$i] as $key => $value){ }
                            
                            //RECUPERAR DADOS DA CONTA E SOMAR VALORES
                            $conta = $res2[$i]['num_conta'];
                          $valor_Conta = "0";
                          $total_Conta = "0";
                          $res_Conta = $pdo->query("SELECT * FROM movimentacao where num_conta = '$conta' order by id asc");
                          $dados_Conta = $res_Conta->fetchAll(PDO::FETCH_ASSOC);
                          for ($j=0; $j < @count($dados_Conta); $j++) { 
                            foreach ($dados_Conta[$j] as $key => $value) {
                            }
                            $vlr_Conta = $dados_Conta[$j]['valor'];
                            $total_Conta = $vlr_Conta + $total_Conta;
                          } 
                          ?>

                          <option <?php if(@$num_conta == $res2[$i]['id']){ ?> selected <?php } ?>  value="<?php echo $res2[$i]['id'] ?>"><?php echo $res2[$i]['num_conta'] ?> - <?php echo $total_Conta ?></option>

                        <?php }

                      }else{ 
                        echo '<option value="">Cadastre um Usuário</option>';

                      } ?>
                    </select>
                  </div> 
                </div>
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Valor</label>
                <input type="text" class="form-control"  id="1money" name="valor" placeholder="Valor da Transação" required="" value="<?php echo @$valor ?>">
              </div>

              <div class="row">
                <div class="col-md">
                  <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Tipo de Transação</label>  
                    <select class="form-select mt-1" aria-label="Default select example" name="tipo">
                      <option value="depositar">Depositar</option>
                      <option value="retirar">Retirar</option>
                    </select>
                  </div> 
                </div>
              </div>

              <small><div align="center" class="mt-1" id="mensagem">

              </div></small>

            </div>
            <div class="modal-footer">
              <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar </button>
              <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">
            </div>
          </form>
        </div>
      </div>
    </div>



    <div class="modal fade" tabindex="-1" id="modalDeletar" >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Excluir Registro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" id="form-excluir">
            <div class="modal-body">

              <p>Deseja Realmente Excluir o Registro?</p>

              <small><div align="center" class="mt-1" id="mensagem-excluir">

              </div> </small>

            </div>
            <div class="modal-footer">
              <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

              <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalExtrato" >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Extrato</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="mt-4" style="margin-right:25px">
              <?php 
              $query = $pdo->query("SELECT * from movimentacao order by id desc");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $total_reg = @count($res);
                //quando é SELECT é passado Fetchall, se passar execute vai dar erro de sintaxe!
                //prepare -> params -> execute!
              if($total_reg > 0){ 
                ?>

                <small>
                  <table id="example" class="table table-hover my-4" style="width:100%">
                    <thead>
                      <tr>
                        <th>Data & Hora</th>
                        <th>Saldo</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php 
                      for($i=0; $i < $total_reg; $i++){
                        foreach ($res[$i] as $key => $value){ }
                          //RECUPERAR DADOS DA CONTA E SOMAR VALORES
                          $conta_rec = $res[$i]['num_conta'];
                        $valor_ContaRec = "0";
                        $total_ContaRec = "0";
                        $res_ContaRec = $pdo->query("SELECT * FROM movimentacao where num_conta = '$conta_rec' order by id asc");
                        $dados_ContaRec = $res_ContaRec->fetchAll(PDO::FETCH_ASSOC);
                        for ($j=0; $j < @count($dados_ContaRec); $j++) { 
                          foreach ($dados_ContaRec[$j] as $key => $value) {
                          }
                          $vlr_ContaRec = $dados_ContaRec[$j]['valor'];
                          $total_ContaRec = $vlr_ContaRec + $total_ContaRec;
                        }

                            //Formatar Data
                        $dataRec = implode('/', array_reverse(explode('-', $res[$i]['data'])));
                        
                            //Cor do Texto
                        if($res[$i]['tipo'] == "retirar"){
                          $cor_texto = 'text-danger';
                        }
                        ?>

                        <tr>
                          <td><?php echo $dataRec ?> <?php echo $res[$i]['hora'] ?></td>
                          <td class="<?php echo $cor_texto ?>"><?php echo $res[$i]['valor'] ?></td>
                        </tr>

                      <?php } ?>

                    </tbody>

                  </table>
                  </small>  <?php }else{
                    echo '<p>Não existem dados para serem exibidos!!';
                  } ?>
                </div>
              </div>

              <div class="modal-footer">
                <p>Saldo: R$ <?php echo $total_ContaRec ?></p>
              </div>
            </div>
          </div>
        </div>



        <?php 
        if(@$_GET['funcao'] == "novo"){ ?>
          <script type="text/javascript">
            var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
              backdrop: 'static'
            });

            myModal.show();
          </script>
        <?php } ?>

        <?php 
        if(@$_GET['funcao'] == "editar"){ ?>
          <script type="text/javascript">
            var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
              backdrop: 'static'
            });

            myModal.show();
          </script>
        <?php } ?>

        <?php 
        if(@$_GET['funcao'] == "deletar"){ ?>
          <script type="text/javascript">
            var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {

            })

            myModal.show();
          </script>
        <?php } ?>

        <?php 
        if(@$_GET['funcao'] == "extrato"){ ?>
          <script type="text/javascript">
            var myModal = new bootstrap.Modal(document.getElementById('modalExtrato'), {

            })

            myModal.show();
          </script>
        <?php } ?>


        <!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
        <script type="text/javascript">
          $("#form").submit(function () {
            var pag = "<?=$pag?>";
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
              url: pag + "/inserir.php",
              type: 'POST',
              data: formData,

              success: function (mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!") {

                  $('#nome').val('');
                  $('#num_conta').val('');
                  $('#valor').val('');
              //$('#tipo_trans').val('');
              $('#btn-fechar').click();
              window.location = "index.php?pagina="+pag;

            } else {

              $('#mensagem').addClass('text-danger')
            }

            $('#mensagem').text(mensagem)

          },

          cache: false,
          contentType: false,
          processData: false,
            xhr: function () {  // Custom XMLHttpRequest
              var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                  myXhr.upload.addEventListener('progress', function () {
                    /* faz alguma coisa durante o progresso do upload */
                  }, false);
                }
                return myXhr;
              }
            });
          });
        </script>



        <!--AJAX PARA EXCLUIR DADOS -->
        <script type="text/javascript">
          $("#form-excluir").submit(function () {
            var pag = "<?=$pag?>";
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
              url: pag + "/excluir.php",
              type: 'POST',
              data: formData,

              success: function (mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Excluído com Sucesso!") {

                  $('#mensagem-excluir').addClass('text-success')

                  $('#btn-fechar').click();
                  window.location = "index.php?pagina="+pag;

                } else {

                  $('#mensagem-excluir').addClass('text-danger')
                }

                $('#mensagem-excluir').text(mensagem)

              },

              cache: false,
              contentType: false,
              processData: false,

            });
          });
        </script>


        <script type="text/javascript">
          $(document).ready(function() {
            $('#example').DataTable({
              "ordering": false
            });
          } );
        </script>