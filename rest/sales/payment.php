<?php
	
	
    require("..\connect.php");


function insert_product()
	{
		global $connection;
		$transaction_id=$_POST["transaction_id"];
		$price=$_POST["price"];
		$discount=$_POST["discount"];
		$product_price=$_POST["product_price"];
        $payment_type=$_POST["payment_type"];
        $payment_date=$_POST["payment_date"];
        
        $query="INSERT INTO payment SET transaction_id='{$transaction_id}', price={$price}, discount={$discount}, product_price='{$product_price}', payment_type='{$payment_type}',payment_date='{$payment_date}'";
  
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Product Added Successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Product Addition Failed.'
			);
		}
		header('Content-Type: application/json');
   
		echo json_encode($response);
	}

	$request_method=$_SERVER["REQUEST_METHOD"];
	switch($request_method)
	{
		
		case 'POST':
			// Insert Product
			insert_product();
			break;
		
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
    php?>