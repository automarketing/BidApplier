<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autoscript extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('paypal_payment'));
		$this->load->database();
		$this->load->model('basic');

	}

	/**
	*	This function is for subscriber's auto payment
	*/
	public function subscriber_auto_payment(){
		$autopayAttempt = 5;

		// getting all subscribers from database
		$select = array("uid", "first_name", "last_name", "plan_id");
		$where = array("where"=>array("active_status"=>0));
		$subscriberDataResult = $this->basic->get_data("subscriber",$where,$select);

		foreach($subscriberDataResult as $subscriberData){
			$subscriberID = $subscriberData['uid'];
			$subscriberFirstName = $subscriberData['first_name'];
			$subscriberLastName = $subscriberData['last_name'];
			$subscriberPlanID = $subscriberData['plan_id'];

			// getting subscriber's last payment to decide to get payment autometically
			$where = array("where"=>array("s_id"=>$subscriberID, "enddate >= "=>date("Y-m-d")));
			$paymentDataResult = $this->basic->get_data("payment",$where,$select="",$join='',$limit=1,$start=NULL,$order_by='uid DESC',$group_by='',$num_rows=1,$csv='');
			$paymentCount = $paymentDataResult['extra_index']['num_rows'];
			
			if($paymentCount < 1){
				// getting subscriber's card details
				$where = array("where"=>array("s_id"=>$subscriberID));
				$cardDataResult = $this->basic->get_data("card",$where);
				$cardID = $cardDataResult[0]['uid'];
				$cardType = $cardDataResult[0]['type'];
				$cardNumber = $cardDataResult[0]['card_no'];
				$cardCvv = $cardDataResult[0]['cvv'];
				$cardExpDate = $cardDataResult[0]['exp_date'];
				$cardExpDateArr = explode("-", $cardExpDate);
				$cardExpYear = $cardExpDateArr[0];
				$cardExpMonth = $cardExpDateArr[1];


				// getting subscriber's using plan details 
				$where = array("where"=>array("uid"=>$subscriberPlanID));
				$planDataResult = $this->basic->get_data("subscriber_plan",$where);
				$planType = $planDataResult[0]['type'];
				$planDuration = $planDataResult[0]['duration'];
				$planPrice = $planDataResult[0]['price'];

				$payment_data = array(
					"payment_action" => "Sale",
					"first_name" => $subscriberFirstName,
					"last_name" => $subscriberLastName,
					"card_type" => $cardType,
					"card_number" => $cardNumber,
					"exp_date_month" => $cardExpMonth,
					"exp_date_year" => $cardExpYear,
					"card_cvv_number" => $cardCvv,
					"amount" => $planPrice,
					"currency_code" => "USD",
					"country_code" => "US"
				);

				$resDataArray = $this->paypal_payment->payment_process("card", $payment_data);

				if($resDataArray['ACK'] == "Success" || $resDataArray['ACK'] == "SuccessWithWarning"){
					$transactionID = $resDataArray['TRANSACTIONID'];
					$transactionAmount = $resDataArray['AMT'];
					$data = array(
						"s_id" => $subscriberID,
						"plan_id" => $subscriberPlanID,
						"transaction_id" => $transactionID,
						"card_id" => $cardID,
						"price" => $transactionAmount,
						"date" => date('Y-m-d H:i:s'),
						"autopay" => 1,
						"startdate" => date('Y-m-d'),
						"enddate" => date('Y-m-d', strtotime("+".$planDuration." days"))
					);
					$this->basic->insert_data("payment",$data);
				}
				else{
					// getting subscriber's autopay attempt details 
					$where = array("where"=>array("s_id"=>$subscriberID));
					$autopayAttemptDataResult = $this->basic->get_data("autopay_attempt",$where,$select='',$join='',$limit='',$start=NULL,$order_by='',$group_by='',$num_rows=1);
					if($autopayAttemptDataResult['extra_index']['num_rows'] == 0){
						// inserting subscriber's autopay attempt data 
						$data = array("s_id"=>$subscriberID, "attempt"=>1);
						$this->basic->insert_data("autopay_attempt",$data);
					}
					else{
						$autopayAttemptId = $autopayAttemptDataResult[0]['uid'];
						$autopayAttemptNum = $autopayAttemptDataResult[0]['attempt'];
						if($autopayAttemptNum < $autopayAttempt){

							// updating subscriber's autopay attempt data 
							$where = array("uid"=>$autopayAttemptId, "s_id"=>$subscriberID);
							$data = array("attempt"=>($autopayAttemptNum+1));
							$this->basic->update_data("autopay_attempt",$where,$data);

						}
						else{

							// updating subscriber's autopay attempt data 
							$where = array("uid"=>$autopayAttemptId, "s_id"=>$subscriberID);
							$data = array("attempt"=>0);
							$this->basic->update_data("autopay_attempt",$where,$data);

							// updating subscriber's active_status data 
							$where = array("uid"=>$subscriberID);
							$data = array("active_status"=>1);
							$this->basic->update_data("subscriber",$where,$data);							
						}
					}
				}

			}
		}
	}
}