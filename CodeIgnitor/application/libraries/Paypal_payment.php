<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 *
 * @package			Paypal_payment
 * @author			Bipul
 * @copyright		Copyright © 2017
 * @since			Version 1.0.0
 * @updated			02.11.2017
 * @filesource
*/

class Paypal_payment
{
	/*
	 	these parameters will be change depends on your sandbox transaction or live transaction.
		we are using sandbox username, password and signature for testing purpose
	*/

	private $api_username = 'imdev9-facilitator_api1.gmail.com';
	private $api_password = 'LHYSN738QR8WCZRA';
	private $api_signature = 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-Abyh0HdalqatbZ3eByMhsD-UK6ax';

	/*
	   For sandbox URL is   :  https://api-3t.sandbox.paypal.com/nvp
	   For live URL is  	:  https://api-3t.paypal.com/nvp
	*/
	private $api_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

	/*
	   For sandbox URL is   :  https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
	   For live URL is  	:  https://www.paypal.com/webscr&cmd=_express-checkout&token=
	*/
	private $paypal_url = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';

	/*
		$use_proxy: Set this variable to TRUE to route all the API requests through proxy.
		like $use_proxy =TRUE;
	*/
	private $use_proxy = FALSE;

	/*
	$proxy_host: Set the host name or the IP address of proxy server.
	$proxy_port: Set proxy port.

	$proxy_host and $proxy_port will be read only if $use_proxy is set to TRUE
	*/
	private $proxy_host = '127.0.0.1';
	private $proxy_port = '80';

	private $version = '204.0';

	function __construct(){
		set_time_limit(0);
		$CI =& get_instance();
	}

	/**
	  * payment_process: Function to process PayPal payment
	  * @payment_through will be "card" or "paypal".
	  * @payment_data will be payment and user data.
	  * returns an associtive array containing the response data from the server.
	*/
	public function payment_process($payment_through="card", $payment_data=array()){
		$responseDataArray = array();

		if($payment_through == "card"){
			$paymentAction = urlencode($payment_data['payment_action']);
			$firstName = urlencode($payment_data['first_name']);
			$lastName = urlencode($payment_data['last_name']);
			$cardType = urlencode($payment_data['card_type']);
			$cardNumber = urlencode($payment_data['card_number']);
			$expDateMonth = urlencode($payment_data['exp_date_month']);

			//Month must be padded with leading zero
			$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

			$expDateYear = urlencode($payment_data['exp_date_year']);
			$cardCvvNumber = urlencode($payment_data['card_cvv_number']);
			$amount = urlencode($payment_data['amount']);
			$currencyCode = urlencode($payment_data['currency_code']);
			$countryCode = urlencode($payment_data['country_code']);

			/* Construct the request string that will be sent to PayPal.
			   The variable $nvpstr contains all the variables and is a
			   name value pair string with & as a delimiter */
			$nvpstr = "&PAYMENTACTION=$paymentAction&AMT=$amount&CREDITCARDTYPE=$cardType&ACCT=$cardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cardCvvNumber&FIRSTNAME=$firstName&COUNTRYCODE=$countryCode&CURRENCYCODE=$currencyCode";

			/* Make the API call to PayPal, using API signature.
			   The API response is stored in an associative array called $responseDataArray */
			$responseDataArray = $this->hash_call("doDirectPayment",$nvpstr);

		}

		return $responseDataArray;
	}

	/**
	  * hash_call: Function to perform the API call to PayPal using API signature
	  * @methodName is name of API  method.
	  * @nvpStr is nvp string.
	  * returns an associtive array containing the response from the server.
	*/
	private function hash_call($methodName,$nvpStr){
		//declaring of global variables
		// global $API_Endpoint,$version,$API_UserName,$API_Password,$API_Signature,$nvp_Header;

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->api_endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
	    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
		if($this->use_proxy)
			curl_setopt ($ch, CURLOPT_PROXY, $this->proxy_host.":".$this->proxy_port); 

		//NVPRequest for submitting to server
		$nvpreq="METHOD=".urlencode($methodName)."&VERSION=".urlencode($this->version)."&PWD=".urlencode($this->api_password)."&USER=".urlencode($this->api_username)."&SIGNATURE=".urlencode($this->api_signature).$nvpStr;

		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

		//getting response from server
		$response = curl_exec($ch);

		//convrting NVPResponse to an Associative Array
		$nvpResArray=$this->deformatNVP($response);
		$nvpReqArray=$this->deformatNVP($nvpreq);
		$_SESSION['nvpReqArray']=$nvpReqArray;

		if (curl_errno($ch)) {
			// moving to display page to display curl errors
			$_SESSION['curl_error_no']=curl_errno($ch);
			$_SESSION['curl_error_msg']=curl_error($ch);
			
			// echo "<pre>";
			// print_r($ch);
			// print_r(curl_errno($ch));
			// print_r(curl_error($ch));
			// echo "<pre>";

			// $location = "APIError.php";
			// header("Location: $location");
		} else {
			 //closing the curl service
			curl_close($ch);
		}

		return $nvpResArray;
	}

	/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  * It is usefull to search for a particular key and displaying arrays.
	  * @nvpstr is NVPString.
	  * @nvpArray is Associative Array.
	*/
	private function deformatNVP($nvpstr){

		$intial=0;
	 	$nvpArray = array();

		while(strlen($nvpstr)){
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	     }
		return $nvpArray;
	}

}