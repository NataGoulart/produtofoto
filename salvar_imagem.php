<?php
        // ATENÇÃO: o tipo da coluna na tabela deve ser MEDIUMBLOB
        include("conecta.php");

        $produto = $_POST["login"];
        $codigo = $_POST["senha"];

        // Lê o conteúdo do arquivo de imagem e armazena na variável $imagem
		$imagem = file_get_contents($_FILES["imagem"]["tmp_name"]);
		
		$comando = $pdo->prepare("INSERT INTO codigos(produto,codigo,foto) VALUES(:produto,:codigo,:foto)");
        $comando->bindParam(":produto", $produto);
        $comando->bindParam(":codigo", $codigo);
        $comando->bindParam(":foto", $imagem, PDO::PARAM_LOB);
		$resultado = $comando->execute();



        
        // As linhas abaixo você usará sempre que quiser mostrar a imagem

        $comando = $pdo->prepare("SELECT * FROM codigos");
		$resultado = $comando->execute();
        while( $linhas = $comando->fetch() )
        {
            $dados_imagem = $linhas["foto"];
            $i = base64_encode($dados_imagem);

            $produto =  $linhas["produto"];
            $codigo =  $linhas["codigo"];

            echo("Produto: $produto Codigo: $codigo  <br>");
            echo(" <img src='data:image/jpeg;base64,$i' width='100px'> <br> <br> ");
        }
		
?>
