<?php
  require_once 'header.php';
?>
  

</main> <!-- fecha o main iniciado na página header.php-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Sweet Alert para confirmar saída do sistema. Os cdn estão no header.php -->
<script>
      document.getElementById("logoutButton").addEventListener("click", function(event) {
        event.preventDefault(); // Impede o redirecionamento imediato

        swal.fire({
          title: 'Sair do sistema',
          text: "Você tem certeza?",
          icon: 'warning',
          iconColor: "#ffa500",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            // Se o usuário confirmar, redireciona para a página de logout
            window.location.href = "sair.php";
          }
        });
      });
    </script>

<!-- Sweet Alert para informar usuário cadastrado com sucesso e ir para a tela de login
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const formNovoUsuario = document.getElementById('formNovoUsuario');
    const btnNovoUsuario = document.getElementById('btnNovoUsuario');

    if (formNovoUsuario && btnNovoUsuario) {
      btnNovoUsuario.addEventListener('click', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            Swal.fire({
                title: 'Cadastro efetuado com sucesso!',
                text: "Faça seu primeiro login",
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                }).then((result) => {
                if (result.isConfirmed) {
                    // Envia o formulário programaticamente
                    //formNovoUsuario.submit();
                    window.location.href = "index.php";
                }
      })
    })}
  });
    </script>
    -->

    <!-- Os 3 links script abaixo servem para criar paginação -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script>
        //toda tabela que eu quero que tenha paginação eu uso os 3 links script acima e o código abaixo
        var table = new DataTable('#tabela', {
    language: {
                url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/pt-BR.json',
              }, //este link acima converte o idioma do código js para o Português BR
              });
    </script>
    <p class="text-center mt-4 mb-3" style="color: #083b6e;">&copy; <?= date("Y") ?> - SGP - Todos os direitos reservados.</p>
</body> <!-- fecha o body da página principal.php -->
</html>

