<?php 
    function restCall(){
        $service_url = 'localhost/rest/sales/plans';
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response,true);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        return  $decoded;
    }
?>

<html>
    <head>
        <title>Pagamento</title>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    </head>
    
    <body class = "bodyplanos">
        <link rel="stylesheet" type="text/css" href="main.css" media="screen" />
        <div id="menu-bar">
            <a class="topnavlogo" href="https://www.casaecafe.com/">Estágio 2018</a color="write">
        <a class="topnavlink" href="produtos.php" style="margin-right:200px">Produtos</a>
        <a class="topnavlink" href="pagamento.php"  >Pagamentos</a>
        </div>
        
        <div class="tituloCaixa">
            <h3>Planos</h3>
        </div>
        
        <table border="1" >
            <tr>
                <th>Nome</th>    
                <th>Produto</th>
                <th>Valor</th>
                <th>Descrição</th>
            </tr>
            
            <?php
                $planos = restCall();
                foreach ($planos as $plano){
                    echo '<tr>';
                    echo '<td>';
                    echo $plano['name'];
                    echo '</td>';
                    echo '<td>';
                    echo $plano['product'];
                    echo '</td>';
                    echo '<td>';
                    echo $plano['price'];
                    echo '</td>';
                    echo '<td>';
                    echo $plano['description'];
                    echo '</td>';
                    echo '</tr>';
                }
            ?>

        </table>
        
    </body>
</html>