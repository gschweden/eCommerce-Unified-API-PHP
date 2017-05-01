<?php

require "../../mpgClasses.php";

/**************************** Request Variables *******************************/

$store_id='moneris';
$api_token='hurgle';
//$status = 'false';

/************************* Transactional Variables ****************************/

$type='axracompletion';
$order_id='ord-210916-12:48:35';
$comp_amount='62.37';
$txn_number = '18930-0_11';
$crypt = '7';

$airline_process_id = "000"; 	//Airline three-digit IATA code, Mandatory, Alphanumberic/3

$mpgAxRaLevel23 = new mpgAxRaLevel23();
$mpgAxRaLevel23->setAirlineProcessId($airline_process_id);
$mpgAxRaLevel23->setInvoiceBatch($invoice_batch);
$mpgAxRaLevel23->setEstablishmentName($establishment_name);
$mpgAxRaLevel23->setCarrierName($carrier_name);
$mpgAxRaLevel23->setTicketId($ticket_id);
$mpgAxRaLevel23->setIssueCity($issue_city);
$mpgAxRaLevel23->setEstablishmentState($establishment_state);
$mpgAxRaLevel23->setNumberInParty($number_in_party);
$mpgAxRaLevel23->setPassengerName($passenger_name);
$mpgAxRaLevel23->setTaaRouting($taa_routing);
$mpgAxRaLevel23->setCarrierCode($carrier_code);
$mpgAxRaLevel23->setFareBasis($fare_basis);
$mpgAxRaLevel23->setDocumentType($document_type);
$mpgAxRaLevel23->setDocNumber($doc_number);
$mpgAxRaLevel23->setDepartureDate($departure_date);

/*********************** Transactional Associative Array **********************/

$txnArray=array('type'=>$type,
     		    'order_id'=>$order_id,
     		    'comp_amount'=>$comp_amount,
				'txn_number'=>$txn_number,
				'crypt_type'=>$crypt
   		       );

/**************************** Transaction Object *****************************/

$mpgTxn = new mpgTransaction($txnArray);
$mpgTxn->setLevel23Data($mpgAxRaLevel23);

/****************************** Request Object *******************************/

$mpgRequest = new mpgRequest($mpgTxn);
$mpgRequest->setProcCountryCode("CA"); //"US" for sending transaction to US environment
$mpgRequest->setTestMode(true); //false or comment out this line for production transactions

/***************************** HTTPS Post Object *****************************/

$mpgHttpPost  =new mpgHttpsPost($store_id,$api_token,$mpgRequest);

//Status check example
//$mpgHttpPost = new mpgHttpsPostStatus($store_id,$api_token,$status,$mpgRequest);

/******************************* Response ************************************/

$mpgResponse=$mpgHttpPost->getMpgResponse();

print("\nCardType = " . $mpgResponse->getCardType());
print("\nTransAmount = " . $mpgResponse->getTransAmount());
print("\nTxnNumber = " . $mpgResponse->getTxnNumber());
print("\nReceiptId = " . $mpgResponse->getReceiptId());
print("\nTransType = " . $mpgResponse->getTransType());
print("\nReferenceNum = " . $mpgResponse->getReferenceNum());
print("\nResponseCode = " . $mpgResponse->getResponseCode());
print("\nISO = " . $mpgResponse->getISO());
print("\nMessage = " . $mpgResponse->getMessage());
print("\nAuthCode = " . $mpgResponse->getAuthCode());
print("\nComplete = " . $mpgResponse->getComplete());
print("\nTransDate = " . $mpgResponse->getTransDate());
print("\nTransTime = " . $mpgResponse->getTransTime());
print("\nTicket = " . $mpgResponse->getTicket());
print("\nTimedOut = " . $mpgResponse->getTimedOut());
//print("\nStatusCode = " . $mpgResponse->getStatusCode());
//print("\nStatusMessage = " . $mpgResponse->getStatusMessage());

?>
