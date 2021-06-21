<?php 

$pag = 'conta';

require_once('../conexao.php');
?>


<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-secondary mt-2">Cadastrar Conta</a>

<div class="mt-4" style="margin-right:25px">
  <?php 
  $query = $pdo->query("SELECT * from conta order by id desc");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_reg = @count($res);
  //para SELECT uso Fetchall 
  //Caso use EXECUTE vai dar erro de sintaxe
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
            ?>

            <tr>
              <td><?php echo $usuario_nome ?></td>
              <td><?php echo $cpf_nome ?></td>
              <td><?php echo $res[$i]['num_conta'] ?></td>
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
      $query = $pdo->query("SELECT * from conta where id = '$_GET[id]'");
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
      $total_reg = @count($res);
      if($total_reg > 0){ 
        $nome = $res[0]['nome'];
        $num_conta = $res[0]['num_conta'];
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
                
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Número da Conta</label>
                  <input type="text" class="form-control"  id="num_conta" name="num_conta" placeholder="Número da Conta" required="" value="<?php echo @$num_conta ?>">
                </div> 
              </div>

              <small><div align="center" class="mt-1" id="mensagem">

              </div></small>

            </div>
            <div class="modal-footer">
              <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar </button>
              <input name="antigo" type="hidden" value="<?php echo @$_GET['num_conta'] ?>">
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
            <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
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