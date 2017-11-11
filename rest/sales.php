<?php
	
	
require("connect.php");

function error_message($message){
    echo $message;
    exit();
}
function insert_product()
	{
		global $connection;
        $transaction_id = (isset($_POST['transaction_id']))&&!empty($_POST['transaction_id'])? $_POST['transaction_id'] : error_message("transaction_id not defined");
        $price = (isset($_POST['price']))&&!empty($_POST['price'])? $_POST['price'] : error_message("price not defined");
        $discount = (isset($_POST['discount']))&&!empty($_POST['discount'])? $_POST['discount'] : error_message("discount not defined");
        $product_price = (isset($_POST['product_price']))&&!empty($_POST['product_price'])? $_POST['product_price'] : error_message("product_price not defined");
        $payment_type = (isset($_POST['payment_type']))&&!empty($_POST['payment_type'])? $_POST['payment_type'] : error_message("payment_type not defined");
        $payment_date = (isset($_POST['payment_date']))&&!empty($_POST['payment_date'])? $_POST['payment_date'] : error_message("payment_date not defined");
        $product = (isset($_POST['product']))&&!empty($_POST['product'])? $_POST['product'] : error_message("product not defined");
        
        if($discount>50)error_message("discount must be less than 50");
    
        $productNames=array('gold_plan','platinum_plan','super_premium_plan');
        if(!in_array($product,$productNames))error_message("product name not found");
    
        $query="INSERT INTO payment SET transaction_id='{$transaction_id}', price={$price}, discount={$discount}, product_price='{$product_price}', payment_type='{$payment_type}',payment_date='{$payment_date}',product='{$product}'";
  
		if(mysqli_query($connection, $query))
		{
			echo 'Product Added Successfully.';
		}
		else
		{	
			echo 'Product Addition Failed.';
		}  

	}
    
//*********************************************************//
function list_product(){
    global $connection;
    $query = "SELECT * FROM product";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            unset($row['0']);
            unset($row['1']);
            unset($row['2']);
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo "no results found";
    }
    
}
//*********************************************************//
    $request_method=$_SERVER["REQUEST_METHOD"];
    $cmd = (isset($_GET['cmd']))&&!empty($_GET["cmd"])? $_GET["cmd"] : "empty";
    
    switch($request_method)
	{
        
        case 'POST': 
            if($cmd !="payment")
            {   echo("Method Not Allowed for payment");
                break;
            }
			insert_product();
			break;
        case 'GET':
            if($cmd !="plans")
            {   echo("Method Not Allowed for plans");
                break;
            }
			list_product();
			break;
		default:
			// Invalid Request Method
			echo("Method Not Allowed");
			break;
	}
    ?>