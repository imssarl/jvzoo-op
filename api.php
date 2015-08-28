<?php
  $config = array(
			'app_id' => 'ONTRAPORT_APP_ID',
			'app_key' => 'ONTRAPORT API KEY'
			);
$products = array(
				'1' => 'Stealth Video Profits - Main Offer',
				'2' => 'Stealth Video Profits - Expert Level',
				'3' => 'Stealth Video Profits - Platinum Level',
				'4' => 'Stealth Video Profits - DFY Video Production Business',
				'5' => 'Stealth Video Profits - DFY Video Production Business - Agency',
				'6' => 'Stealth Video Profits - DFY Video Production Business - Payment Plan',
				'7' => 'Stealth Video Profits - DFY Video Production Business - Agency Payment Plan',
				'8' => 'Instant FB Traffic',
				'9' => 'Instant FB Traffic PRO Access',
				'10' => 'Instant FB Traffic ELITE Groups',
			);
			
			======= THESE ARE THE ONTRAPORT PRODUCT NAMES YOU'RE SELLING THROUGH VZOO =======

function search_contact($config = false ,$email = false){
	if(!$email) die('No email exists');
	$data = <<<STRING
<search><equation>
	<field>Email</field>
	<op>e</op>
	<value>$email</value>
	</equation>
</search>
STRING;
			
			$data = urlencode(urlencode($data));

			
			$reqType = "search";
			$postargs = "appid=".$config['app_id']."&key=".$config['app_key']."&reqType=".$reqType."&data=".$data."&return_id=2";
			$request = "https://api.ontraport.com/cdata.php";
			
			$session = curl_init($request);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
			curl_setopt ($session, CURLOPT_HEADER, false);
			curl_setopt ($session, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($session);
			curl_close($session);
			//header("Content-Type: text/xml");
			$result = new SimpleXMLElement($response);
			$result = json_encode($result);
			$records = json_decode($result);
			$key = '@attributes';
			if(!empty($records->contact->$key->id)){
				return $records->contact->$key->id;
			}else { 
				return FALSE;
			}
			
}


function create_contact($config = false ,$user = false){
	if(!$user) die('No data exists');
	$name = $user['ccustname'];
	$email = $user['ccustemail'];
	$data = <<<STRING
<contact>
<Group_Tag name="Contact Information">
<field name="First Name">$name</field>
<field name="Last Name"></field>
<field name="Email">$email</field>
</Group_Tag>
</contact>
STRING;
			
			$data = urlencode(urlencode($data));

			
			$reqType = "add";
			$postargs = "appid=".$config['app_id']."&key=".$config['app_key']."&reqType=".$reqType."&data=".$data."&return_id=2";
			$request = "https://api.ontraport.com/cdata.php";
			
			$session = curl_init($request);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
			curl_setopt ($session, CURLOPT_HEADER, false);
			curl_setopt ($session, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($session);
			curl_close($session);
			$result = new SimpleXMLElement($response);
			$result = json_encode($result);
			$records = json_decode($result);
			$key = '@attributes';
			if(!empty($records->contact->$key->id)){
				return $records->contact->$key->id;
			}else { 
				return FALSE;
			}
			
}

function add_sale($config = false ,$user = false){
	if(!$user) die('No data exists');
	$contact_id = $user['contact_id'];
	$product_id = $user['product_id'];
	$price = $user['ctransamount'];
$data = <<<STRING
<purchases contact_id="$contact_id" product_id='$product_id'>
<field name="Price">$price</field> //Override the standard price of the product
</purchases>
STRING;
			
			$data = urlencode(urlencode($data));

			
			$reqType = "sale";
			$postargs = "appid=".$config['app_id']."&key=".$config['app_key']."&reqType=".$reqType."&data=".$data."&return_id=2";
			$request = "https://api.ontraport.com/pdata.php";
			
			$session = curl_init($request);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
			curl_setopt ($session, CURLOPT_HEADER, false);
			curl_setopt ($session, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($session);
			curl_close($session);
			$result = new SimpleXMLElement($response);
			$result = json_encode($result);
			$records = json_decode($result);
			return $records->status;
			
}



function refund($config = false ,$user = false){
	if(!$user) die('No data exists');
	$purchase_id = $user['purchase_id'];
	$price = $user['ctransamount'];
$data = <<<STRING
<purchases id='$purchase_id'>
<refund>$price</refund> //optional data to issue partial refund
</purchases>
STRING;
			
			$data = urlencode(urlencode($data));

			
			$reqType = "refund";
			$postargs = "appid=".$config['app_id']."&key=".$config['app_key']."&reqType=".$reqType."&data=".$data."&return_id=2";
			$request = "https://api.ontraport.com/pdata.php";
			
			$session = curl_init($request);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
			curl_setopt ($session, CURLOPT_HEADER, false);
			curl_setopt ($session, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($session);
			curl_close($session);
			$result = new SimpleXMLElement($response);
			$result = json_encode($result);
			$records = json_decode($result);
			return $records->status;
			
}


function product_id($title = false, $products){
	if (strpos($user['cprodtitle'],'Main Offer') !== false) {
    	return '1';
	}
	if (strpos($user['cprodtitle'],'Expert Level') !== false) {
    	return '2';
	}
	if (strpos($user['cprodtitle'],'Platinum Level') !== false) {
    	return '3';
	}
	if (strpos($user['cprodtitle'],'DFY Video Production Business') !== false) {
    	return '4';
	}
	if (strpos($user['cprodtitle'],'DFY Video Production Business - Agency') !== false) {
    	return '5';
	}
	if (strpos($user['cprodtitle'],'DFY Video Production Business - Payment Plan') !== false) {
    	return '6';
	}
	if (strpos($user['cprodtitle'],'DFY Video Production Business - Agency Payment Plan') !== false) {
    	return '7';
	}
	if (strpos($user['cprodtitle'],'Instant FB Traffic') !== false) {
    	return '8';
	}
	if (strpos($user['cprodtitle'],'Instant FB Traffic PRO Access') !== false) {
    	return '9';
	}
	if (strpos($user['cprodtitle'],'Instant FB Traffic ELITE Groups') !== false) {
    	return '10';
	}
	
	foreach($products as $key => $prod){
		if($prod == $title) return 	$key;
	}
	return '1';
}
======== UPDATE ABOVE WITH THE JVZOO PRODUCT NAMES AND MATCH THEM TO AN ONTRAPORT PRODUCT ===========

function search_purchase($config = false ,$user= false){
	 $contact_id = $user['contact_id'];
	 $product_title = $user['product_title'];
 $data = <<<STRING
<search><equation>
		<field>Contact ID</field>
        <op>e</op>
        <value>$contact_id</value>
        </equation>
		<equation>
		<field>name</field>
        <op>e</op>
        <value>$product_title</value>
        </equation>
</search>
STRING;
			
			$data = urlencode(urlencode($data));

			
			$reqType = "search_purchase";
			 $postargs = "appid=".$config['app_id']."&key=".$config['app_key']."&reqType=".$reqType."&data=".$data."&return_id=2";
			$request = "https://api.ontraport.com/pdata.php";
			
			$session = curl_init($request);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
			curl_setopt ($session, CURLOPT_HEADER, false);
			curl_setopt ($session, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($session);
			curl_close($session);
			//header("Content-Type: text/xml");
			$result = new SimpleXMLElement($response);
			$result = json_encode($result);
			$records = json_decode($result);
			
			if(!empty($records->purchases->purchase)){
				if(count($records->purchases->purchase)>1){
				 $product = end($records->purchases->purchase);
				}else{
				$product = 	$records->purchases->purchase;
				}
			
			 }
			else{
				die('no Purchase found');
			}
			$key = '@attributes';
			if(!empty($product->$key->id)){
				return  $product->$key->id;
			}else { 
				return FALSE;
			}
			
}

$user = $_POST;
switch($user['ctransaction']){
	case 'SALE':
		if(!$user['contact_id'] = search_contact($config, $user['ccustemail'])){
			$user['contact_id'] = create_contact($config, $user);	
		};
		
		$user['product_id'] = product_id($user['cprodtitle'], $products);
		echo add_sale($config, $user);
	break;
	case 'BILL':
		if(!$user['contact_id'] = search_contact($config, $user['ccustemail'])){
			$user['contact_id'] = create_contact($config, $user);	
		};
		
		$user['product_id'] = product_id($user['cprodtitle'], $products);
		echo add_sale($config, $user);
	break;
	case 'RFND':
		if(!$user['contact_id'] = search_contact($config, $user['ccustemail'])){
			die('No Contact Exists');	
		};
		
		$user['product_title'] = $user['cprodtitle'];
		if($user['purchase_id'] = search_purchase($config, $user)){
			
			
			echo refund($config, $user);
		}
		
	break;	
}
?>
