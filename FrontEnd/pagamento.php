<?php
    echo '<script type="text/javascript">';
    echo 'var alertFlag = 1;';
    echo 'var restStatus = "";';
    echo 'var restMsg = "";';
    echo '</script>';
    function error_message($msg){
        echo '<script type="text/javascript">';
        echo 'if(alertFlag)alert("'.$msg.'");';
        echo 'var alertFlag = 0;';
        echo '</script>';
    }
    if($_SERVER["REQUEST_METHOD"]=='POST'){
    $transaction_id = (isset($_POST['transaction_id']))&&!empty($_POST['transaction_id'])? $_POST['transaction_id'] : error_message("transaction_id not defined");
    $price = (isset($_POST['price']))&&!empty($_POST['price'])? $_POST['price'] : error_message("price not defined");
    $discount = (isset($_POST['discount']))&&!empty($_POST['discount'])? $_POST['discount'] : error_message("discount not defined");
    $product_price = (isset($_POST['product_price']))&&!empty($_POST['product_price'])? $_POST['product_price'] : error_message("product_price not defined");
    $payment_type = (isset($_POST['payment_type']))&&!empty($_POST['payment_type'])? $_POST['payment_type'] : error_message("payment_type not defined");
    $payment_date = (isset($_POST['payment_date']))&&!empty($_POST['payment_date'])? $_POST['payment_date'] : error_message("payment_date not defined");
    $product = (isset($_POST['product']))&&!empty($_POST['product'])? $_POST['product'] : error_message("product not defined");
        
    $service_url = 'localhost/rest/sales/payment';
    $curl = curl_init($service_url);
    $curl_post_data = array(
        'transaction_id' => $transaction_id,
        'price' => $price,
        'discount' => $discount,
        'product_price' => $product_price,
        'payment_type' => $payment_type,
        'payment_date' => $payment_date,
        'product' => $product,
    );
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
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
        echo '<script type="text/javascript">';
        echo 'var restStatus = '.$decoded['status'].';';
        echo 'var restMsg = "'.$decoded['msg'].'";';
        echo '</script>';    
    }
?>
<html>
    <head>
        <title>Pagamento</title>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    </head>
    
    <body class = "bodypagamento">
        <link rel="stylesheet" type="text/css" href="main.css" media="screen" />
        <div id="menu-bar">
            <a class="topnavlogo" href="https://www.casaecafe.com/">Estágio 2018</a color="write">
        <a class="topnavlink" href="produtos.php" style="margin-right:200px">Produtos</a>
        <a class="topnavlink" href="pagamento.php"  >Pagamentos</a>
        </div>
            <div class="caixaPagamento">
                <div class="tituloCaixa">
                    <h3>Novo Pagamento</h3>
                </div>
                
                <form style="margin-left: calc(50% - 81px)" action="" method="post">
                
                    <div class="campo">
                        <div>Produto</div>
                        <input type="text" name="product">  
                    </div>
                    
                    <div class="campo">
                        <div>Preço do Produto</div>
                        <input type="text" name="product_price">
                    </div>
                    
                    <div class="campo">
                        <div>Desconto (0-100)</div>
                        <input type="text" name="discount">
                    </div>
                    
                    <div class="campo">
                        <div>Preço com Desconto</div>
                        <input type="text" name="price">
                    </div>
                    <div class="campo">
                        <div>Código de transação</div>
                        <input type="text" name="transaction_id">
                    </div>
                    <div class="campo">
                        <div>Data e Hora</div>
                        <input type="text" name="payment_date" value="re">
                    </div>
                    <div class="campo">
                        <input type="radio" name = "payment_type" value="cartao">Cartão
                        <input type="radio" name = "payment_type" value="boleto">Boleto
                    </div>
                    <div class="campo">
                        <input class="myButton" type="submit" name = "Enviar">
                    </div>
                    <div class="campo">
                        <div name = "restMessage" id="restMessage" style=""> </div>
                        
                    </div>
                    
                </form>
            </div>
        
    </body>
</html>
<script type="text/javascript">
    function productPriceCalc(){
        var productName = $("input[name=product]").val();
        switch(productName){
            case "gold_plan":
                $("input[name=product_price]").val("59,90");
                break;
            case "platinum_plan":
                $("input[name=product_price]").val("79,90");
                break;   
            case "super_premium_plan":
                $("input[name=product_price]").val("129,90");
                break;   
        }
    }
    $(document).ready(function () {
        $("input[name=product]").keyup(productPriceCalc);
    });
    function calcPrice(){
        var product_price = $("input[name=product_price]").val();
        var discount = $("input[name=discount]").val();
        var product_price = product_price.replace(",", ".");
        var discount = discount.replace(",", ".");
        $("input[name=price]").val(product_price*(1-discount/100));
    }
    $(document).ready(function () {
        $("input[name=product_price],input[name=discount]").keyup(calcPrice);
    });
    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        var ampm = hours >= 12 ? 'pm' : 'am';
       // hours = hours % 12;
        //hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        seconds = seconds < 10 ? '0'+seconds : seconds;
        var strTime = hours + ':' + minutes + ':' + seconds;
        return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
    }
    function setPaymentDate(){
        var date = new Date();
        var dateFormatted = formatDate(date);
        $("input[name=payment_date]").val(dateFormatted);
        setTimeout(setPaymentDate,100);
    }
    
    if(restStatus){
        document.getElementById("restMessage").style= "color:blue;";
        document.getElementById("restMessage").innerHTML= restMsg;
    }else{
        document.getElementById("restMessage").style= "color:red;";
        document.getElementById("restMessage").innerHTML= restMsg;
    }
    setPaymentDate();
    
</script>