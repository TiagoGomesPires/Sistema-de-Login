<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./Css/style.css" />

    <title>Área de Registro</title>
</head>

<body>


<?php
//DEFINE A TIME ZONE
date_default_timezone_set("America/Sao_Paulo");

if(isset($_POST['enviar-formulario'])){
    $flagerros = 0;

    $nome = $_POST['nome_completo'];
    if(!is_string($nome)){
        echo "<div id='mensagem2'><h1>NOME INVÁLIDO</h1></div>";
        $flagerros = 1;         
    }

    if(!$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)){
        echo "<div id='mensagem2'><h1>EMAIL INVÁLIDO</h1></div>";
        $flagerros = 1; 
    }

    $senhaInicial = $_POST['senha'];
    $senhaConfirm = $_POST['senhaConfirm'];
    if(strcmp($senhaInicial, $senhaConfirm)){
        echo "<div id='mensagem2'><h1>SENHA INVÁLIDA</h1></div>";
        $flagerros = 1; 
    }

    $flaglogin = 0;

    if( $flagerros == 0 ){

    $arquivoAbrir = fopen("Usuários.txt", "a+");
    $dados = "$nome|";
    $dados .= "$email|";
    $dados .= md5($senhaConfirm)."|\n";


    while(!feof($arquivoAbrir)){
        $tentativa = fgets($arquivoAbrir, 2048);
        if ($tentativa == null) break;

        $dadosUsuario = explode("|", $tentativa);

        $emailRegistrado = $dadosUsuario['1'];
        $senhaRegistrada = $dadosUsuario['2'];
        if( $emailRegistrado == $email){
            $flaglogin = 1;
            echo "<div id='mensagem2'><h1 id='mensagemerro'>Este Email já foi Cadastrado</h1></div>"; 
            }
    }
        if($flaglogin == 0){
                if(fwrite($arquivoAbrir,$dados)){
                    echo "<script> window.location.replace('index.php') </script>";
                }else{
                    echo "Erro no Envio!";
                } 
        }

     fclose($arquivoAbrir);
    }
}

?>
    <h1 id="titulo"> SEU CADASTRO </h1>
    <p id="msg"><a href="index.php">Logar</a></p>

    <form id="area" method="POST" enctype="multipart/form-data">
        
        <label for="nome">Informe o seu Nome</label><br>
        <input class="campos" type="text" required="required" name="nome_completo" pattern="^[^-\s][a-zA-ZÀ-ú ]*"><br>
   
        <label for="email">Informe o seu Email</label><br>
        <input class="campos" type="email" required="required" name="email"><br>
  
        <label for="senha">Informe a sua senha</label><br>
        <input class="campos" type="password" required="required" name="senha"  minlength="8"><br>

        <label for="senha">Confirme a sua senha</label><br>
        <input class="campos" type="password" required="required" name="senhaConfirm"  minlength="8"><br>
 
        <input id="inpSubmit" type="submit" name="enviar-formulario">
        

    </form>
        
    

</body>
</html>