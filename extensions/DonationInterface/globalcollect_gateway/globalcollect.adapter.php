<?php
/**
 * Wikimedia Foundation
 *
 * LICENSE
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 */

/**
 * GlobalCollectAdapter
 *
 */
class GlobalCollectAdapter extends GatewayAdapter {
	const GATEWAY_NAME = 'Global Collect';
	const IDENTIFIER = 'globalcollect';
	const COMMUNICATION_TYPE = 'xml';
	const GLOBAL_PREFIX = 'wgGlobalCollectGateway';

	/**
	 * Add a key to the transaction INSERT_ORDERWITHPAYMENT.
	 *
	 * $this->transactions['INSERT_ORDERWITHPAYMENT']['request']['REQUEST']['PARAMS'][ $key ][] = $value 
	 */
	protected function addKeyToTransaction( $value, $type = 'PAYMENT' ) {

		if ( !in_array( $value, $this->transactions['INSERT_ORDERWITHPAYMENT']['request']['REQUEST']['PARAMS'][ $type ] ) ) {
			$this->transactions['INSERT_ORDERWITHPAYMENT']['request']['REQUEST']['PARAMS'][ $type ][] = $value;
		}
	}

	/**
	 * Define accountInfo
	 */
	public function defineAccountInfo() {
		$this->accountInfo = array(
			'MERCHANTID' => self::getGlobal( 'MerchantID' ),
			//'IPADDRESS' => '', //TODO: Not sure if this should be OUR ip, or the user's ip. Hurm. 
			'VERSION' => "1.0",
		);
	}

	/**
	 * Define dataConstraints
	 *
	 * @todo
	 * - card_type: what do we do about this one? It is also payment_product.
	 *
	 */
	public function defineDataConstraints() {
		
		$this->dataConstraints = array(
			
			// General fields

			//'ACCOUNTHOLDER'		=> 'account_holder',		AN50
			'account_holder'		=> array( 'type' => 'alphanumeric',		'length' => 50, ),
			
			//'ACCOUNTNAME'			=> 'account_name'			AN35
			'account_name'			=> array( 'type' => 'alphanumeric',		'length' => 35, ),
			
			//'ACCOUNTNUMBER'		=> 'account_number'			AN30
			'account_number'		=> array( 'type' => 'alphanumeric',		'length' => 30, ),
			
			//'ADDRESSLINE1E'		=> 'address_line_1e'		AN35
			'address_line_1e'		=> array( 'type' => 'alphanumeric',		'length' => 35, ),

			//'ADDRESSLINE2'		=> 'address_line_2'			AN35
			'address_line_2'		=> array( 'type' => 'alphanumeric',		'length' => 35, ),

			//'ADDRESSLINE3'		=> 'address_line_3'			AN35
			'address_line_3'		=> array( 'type' => 'alphanumeric',		'length' => 35, ),

			//'ADDRESSLINE4'		=> 'address_line_4'			AN35
			'address_line_4'		=> array( 'type' => 'alphanumeric',		'length' => 35, ),

			//'ATTEMPTID'			=> 'attempt_id'				N5
			'attempt_id'			=> array( 'type' => 'numeric',			'length' => 5, ),
			
			// Did not find this one
			//'AUTHORISATIONID'		=> 'authorization_id'		AN18
			'authorization_id'		=> array( 'type' => 'alphanumeric',		'length' => 18, ),
			
			//'AMOUNT'				=> 'amount'					N12
			'amount'				=> array( 'type' => 'numeric',			'length' => 12, ),
			
			//'BANKACCOUNTNUMBER'	=> 'bank_account_number'	AN50
			'bank_account_number'	=> array( 'type' => 'alphanumeric',		'length' => 50, ),
			
			//'BANKAGENZIA'			=> 'bank_agenzia'			AN30
			'bank_agenzia'			=> array( 'type' => 'alphanumeric',		'length' => 30, ),

			//'BANKCHECKDIGIT'		=> 'bank_check_digit'		AN2
			'bank_check_digit'		=> array( 'type' => 'alphanumeric',		'length' => 2, ),
			
			//'BANKCODE'			=> 'bank_code'				N5
			'bank_code'				=> array( 'type' => 'numeric',			'length' => 5, ),
			
			//'BANKFILIALE'			=> 'bank_filiale'			AN30
			'bank_filiale'			=> array( 'type' => 'alphanumeric',		'length' => 30, ),

			//'BANKNAME'			=> 'bank_name'				AN40
			'bank_name'				=> array( 'type' => 'alphanumeric',		'length' => 40, ),
			
			//'BRANCHCODE'			=> 'branch_code'			N5
			'branch_code'			=> array( 'type' => 'numeric',			'length' => 5, ),
			
			//'CITY'				=> 'city'					AN40
			'city'					=> array( 'type' => 'alphanumeric',		'length' => 40, ),
			
			//'COUNTRYCODE'			=> 'country'				AN2
			'country'				=> array( 'type' => 'alphanumeric',		'length' => 2, ),
			
			//'COUNTRYCODEBANK'		=> 'country_code_bank'		AN2
			'country_code_bank'		=> array( 'type' => 'alphanumeric',		'length' => 2, ),
			
			//'COUNTRYDESCRIPTION'	=> 'country_description'	AN50
			'country_description'	=> array( 'type' => 'alphanumeric',		'length' => 50, ),
			
			//'CUSTOMERBANKCITY'	=> 'customer_bank_city'		AN50
			'customer_bank_city'	=> array( 'type' => 'alphanumeric',		'length' => 50, ),

			//'CUSTOMERBANKSTREET'	=> 'customer_bank_street'	AN30
			'customer_bank_street'	=> array( 'type' => 'alphanumeric',		'length' => 30, ),

			//'CUSTOMERBANKNUMBER'	=> 'customer_bank_number'	N5
			'customer_bank_number'	=> array( 'type' => 'numeric',			'length' => 5, ),

			//'CUSTOMERBANKZIP'		=> 'customer_bank_zip'		AN10
			'customer_bank_zip'		=> array( 'type' => 'alphanumeric',		'length' => 10, ),

			//'CREDITCARDNUMBER'	=> 'card_num'				N19
			'card_num'				=> array( 'type' => 'numeric',			'length' => 19, ),
			
			//'CURRENCYCODE'		=> 'currency_code'			AN3
			'currency_code'			=> array( 'type' => 'alphanumeric',		'length' => 3, ),
			
			//'CVV'					=> 'cvv'					N4
			'cvv'					=> array( 'type' => 'numeric',			'length' => 4, ),
			
			//'DATECOLLECT'			=> 'date_collect'			D8	YYYYMMDD
			'date_collect'			=> array( 'type' => 'date',				'length' => 8, ),
			
			//'DIRECTDEBITTEXT'		=> 'direct_debit_text'		AN50
			'direct_debit_text'		=> array( 'type' => 'alphanumeric',		'length' => 50, ),
			
			//'DOMICILIO'			=> 'domicilio'				AN30
			'domicilio'				=> array( 'type' => 'alphanumeric',		'length' => 30, ),

			//'EFFORTID'			=> 'effort_id'				N5
			'effort_id'				=> array( 'type' => 'numeric',			'length' => 5, ),
			
			//'EMAIL'				=> 'email'					AN70
			'email'					=> array( 'type' => 'alphanumeric',		'length' => 70, ),
			
			//'EXPIRYDATE'			=> 'expiration'				N4	MMYY
			'expiration'			=> array( 'type' => 'numeric',			'length' => 4, ),
			
			//'FIRSTNAME'			=> 'fname'					AN15
			'fname'					=> array( 'type' => 'alphanumeric',		'length' => 15, ),
			
			//'IBAN'				=> 'iban'					AN50
			// IBAN is AN21 on direct debit
			'iban'					=> array( 'type' => 'alphanumeric',		'length' => 50, ),
			
			//'IPADDRESS'			=> 'user_ip'				AN32
			'user_ip'				=> array( 'type' => 'alphanumeric',		'length' => 32, ),
			
			//'ISSUERID'			=> 'issuer_id'				N4
			'issuer_id'				=> array( 'type' => 'numeric',			'length' => 4, ),
			
			//'LANGUAGECODE'		=> 'language'				AN2
			'language'				=> array( 'type' => 'alphanumeric',		'length' => 2, ),
			
			//'MERCHANTREFERENCE'	=> 'order_id'				AN50
			'order_id'				=> array( 'type' => 'alphanumeric',		'length' => 50, ),
			
			//'ORDERID'				=> 'order_id'				N10
			'order_id'				=> array( 'type' => 'numeric',			'length' => 10, ),
			
			// This is mapped to other things
			//'PAYMENTPRODUCTID'	=> 'card_type'				AN50
			'card_type'				=> array( 'type' => 'numeric',			'length' => 5, ),
			'payment_product'		=> array( 'type' => 'numeric',			'length' => 5, ),
			
			//'PAYMENTREFERENCE'	=> 'payment_reference'		AN20
			'payment_reference'		=> array( 'type' => 'alphanumeric',		'length' => 20, ),
			
			//'PROVINCIA'			=> 'provincia'				AN30
			'provincia'				=> array( 'type' => 'alphanumeric',		'length' => 30, ),

			//'RETURNURL'			=> 'returnto'				AN512
			'returnto'				=> array( 'type' => 'alphanumeric',		'length' => 512, ),
			
			//'SPECIALID'			=> 'special_id'				AN255
			'special_id'			=> array( 'type' => 'alphanumeric',		'length' => 255, ),
			
			//'STATE'				=> 'state'					AN35
			'state'					=> array( 'type' => 'alphanumeric',		'length' => 35, ),
			
			//'STREET'				=> 'street'					AN50
			'street'				=> array( 'type' => 'alphanumeric',		'length' => 50, ),
			
			//'SURNAME'				=> 'lname'					AN35
			'lname'					=> array( 'type' => 'alphanumeric',		'length' => 35, ),
			
			//'SWIFTCODE'			=> 'swift_code'				AN255
			// This is AN11 for several payment types we are not dealing with yet.
			'swift_code'			=> array( 'type' => 'alphanumeric',		'length' => 255, ),
			
			//'TRANSACTIONTYPE'		=> 'transaction_type'		AN2
			'transaction_type'		=> array( 'type' => 'alphanumeric',		'length' => 2, ),

			//'ZIP'					=> 'zip'					AN10
			'zip'					=> array( 'type' => 'alphanumeric',		'length' => 10, ),
		);
	}

	/**
	 * Define error_map
	 *
	 * @todo
	 * - Add: Error messages
	 */
	public function defineErrorMap() {
		
		$this->error_map = array(
			0		=> 'globalcollect_gateway-response-default',	
			430452	=> 'globalcollect_gateway-response-default', // Not authorised :: This message was generated when trying to attempt a direct debit transaction from Belgium.	
			430900	=> 'globalcollect_gateway-response-default', // NO VALID PROVIDERS FOUND FOR COMBINATION MERCHANTID: NNNN, PAYMENTPRODUCT: NNN, COUNTRYCODE: XX, CURRENCYCODE: XXX
			
			// Internal messages
			'internal-0000' => 'donate_interface-processing-error', // Failed failed pre-process checks.
			'internal-0001' => 'donate_interface-processing-error', // Transaction could not be processed due to an internal error.
			'internal-0002' => 'donate_interface-processing-error', // Communication failure
			
			// Do bank validation messages
			//'dbv-50'	=> 'globalcollect_gateway-response-dbv-50', // Account number format incorrect
			//'dbv-80'	=> 'globalcollect_gateway-response-dbv-80', // Account details missing
			//'dbv-330'	=> 'globalcollect_gateway-response-dbv-330', // Check digit format is incorrect
			//'dbv-340'	=> 'globalcollect_gateway-response-dbv-340', // Branch code not submitted
			
		);
	}
	
	/**
	 * Define var_map
	 *
	 * @todo
	 * - RETURNURL: Find out where the returnto URL is supposed to be coming from.
	 */
	public function defineVarMap() {
		
		$this->var_map = array(
			'ACCOUNTHOLDER'		=> 'account_holder',
			'ACCOUNTNAME'		=> 'account_name',
			'ACCOUNTNUMBER'		=> 'account_number',
			'ADDRESSLINE1E'		=> 'address_line_1e', //dd:CH
			'ADDRESSLINE2'		=> 'address_line_2', //dd:CH
			'ADDRESSLINE3'		=> 'address_line_3', //dd:CH
			'ADDRESSLINE4'		=> 'address_line_4', //dd:CH
			'ATTEMPTID'			=> 'attempt_id',
			'AUTHORISATIONID'	=> 'authorization_id',
			'AMOUNT'			=> 'amount',
			'BANKACCOUNTNUMBER'	=> 'bank_account_number',
			'BANKAGENZIA'		=> 'bank_agenzia', // dd:IT
			'BANKCHECKDIGIT'	=> 'bank_check_digit',
			'BANKCODE'			=> 'bank_code',
			'BANKFILIALE'		=> 'bank_filiale', // dd:IT
			'BANKNAME'			=> 'bank_name',
			'BRANCHCODE'		=> 'branch_code',
			'CITY'				=> 'city',
			'COUNTRYCODE'		=> 'country',
			'COUNTRYCODEBANK'	=> 'country_code_bank',
			'COUNTRYDESCRIPTION'=> 'country_description',
			'CUSTOMERBANKCITY'	=> 'customer_bank_city', // dd
			'CUSTOMERBANKSTREET'=> 'customer_bank_street', // dd
			'CUSTOMERBANKNUMBER'=> 'customer_bank_number', // dd
			'CUSTOMERBANKZIP'	=> 'customer_bank_zip', // dd
			'CREDITCARDNUMBER'	=> 'card_num',
			'CURRENCYCODE'		=> 'currency_code',
			'CVV'				=> 'cvv',
			'DATECOLLECT'		=> 'date_collect',
			'DESCRIPTOR'		=> 'descriptor', // eWallets
			'DIRECTDEBITTEXT'	=> 'direct_debit_text',
			'DOMICILIO'			=> 'domicilio', // dd:ES
			'EFFORTID'			=> 'effort_id',
			'EMAIL'				=> 'email',
			'EXPIRYDATE'		=> 'expiration',
			'FIRSTNAME'			=> 'fname',
			'IBAN'				=> 'iban',
			'IPADDRESS'			=> 'user_ip',
			'ISSUERID'			=> 'issuer_id',
			'LANGUAGECODE'		=> 'language',
			'MERCHANTREFERENCE'	=> 'order_id',
			'ORDERID'			=> 'order_id',
			'PAYMENTPRODUCTID'	=> 'card_type',
			'PAYMENTREFERENCE'	=> 'payment_reference',
			'PROVINCIA'			=> 'provincia', // dd:ES
			'RETURNURL'			=> 'returnto',
			'SPECIALID'			=> 'special_id',
			'STATE'				=> 'state',
			'STREET'			=> 'street',
			'SURNAME'			=> 'lname',
			'SWIFTCODE'			=> 'swift_code',
			'TRANSACTIONTYPE'	=> 'transaction_type', // dd:GB,NL
			'ZIP'				=> 'zip',
			'FISCALNUMBER'		=> 'fiscal_number', //Boletos
		);
	}
	
	/**
	 * Setting some GC-specific defaults. 
	 * @param array $options These get extracted in the parent.
	 */
	function setPostDefaults( $options = array() ) {
		parent::setPostDefaults( $options );
		$this->postdatadefaults['attempt_id'] = '1';
		$this->postdatadefaults['effort_id'] = '1';
	}

	/**
	 * Define return_value_map
	 */
	public function defineReturnValueMap() {
		$this->return_value_map = array(
			'OK' => true,
			'NOK' => false,
		);
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'pending', 0, 70 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'failed', 100, 180 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'pending', 200 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'failed', 220, 280 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'pending', 300 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'failed', 310, 350 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'revised', 400 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'pending-poke', 525 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'pending', 550, 650 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'complete', 800, 975 ); //these are all post-authorized, but technically pre-settled...
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'complete', 1000, 1050 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'failed', 1100, 99999 );
		$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'failed', 100000, 999999 ); // 102020 - ACTION 130 IS NOT ALLOWED FOR MERCHANT NNN, IPADDRESS NNN.NNN.NNN.NNN
		
		
		$this->defineGoToThankYouOn();
	}

	/**
	 * Define goToThankYouOn
	 *
	 * The statuses defined in @see GlobalCollectAdapter::$goToThankYouOn will
	 * allow a completed form to go to the Thank you page.
	 *
	 * Allowed:
	 * - complete
	 * - pending
	 * - pending-poke
	 * - revised
	 *
	 * Denied:
	 * - failed
	 * - Any thing else not defined in $goToThankYouOn
	 *
	 */
	public function defineGoToThankYouOn() {
		
		$this->goToThankYouOn = array(
			'complete',
			'pending',
			'pending-poke',
			'revised',
		);
	}
	
	/**
	 * Define transactions
	 *
	 * Please do not add more transactions to this array.
	 *
	 * @todo
	 * - Does  need IPADDRESS? What about the other transactions. Is this the user's IPA?
	 * - Does DO_BANKVALIDATION need HOSTEDINDICATOR?
	 *
	 * This method should define:
	 * - DO_BANKVALIDATION: used prior to INSERT_ORDERWITHPAYMENT for direct debit
	 * - INSERT_ORDERWITHPAYMENT: used for payments
	 * - TEST_CONNECTION: testing connections - is this still valid?
	 * - GET_ORDERSTATUS
	 */
	public function defineTransactions() {

		// Define the transaction types and groups
		$this->definePaymentMethods();
		$this->definePaymentSubmethods();
		
		$this->transactions = array( );

		$this->transactions['DO_BANKVALIDATION'] = array(
			'request' => array(
				'REQUEST' => array(
					'ACTION',
					'META' => array(
						'MERCHANTID',
						'IPADDRESS',
						'VERSION'
					),
					'PARAMS' => array(
						'GENERAL' => array(
							'ACCOUNTNAME',
							'ACCOUNTNUMBER',
							'AUTHORISATIONID',
							'BANKCHECKDIGIT',
							'BANKCODE',
							'BANKNAME',
							'BRANCHCODE',
							'COUNTRYCODEBANK',
							'DATECOLLECT', // YYYYMMDD
							'DIRECTDEBITTEXT',
							'IBAN',
							'MERCHANTREFERENCE',
							'TRANSACTIONTYPE',
						),
					)
				)
			),
			'values' => array(
				'ACTION' => 'DO_BANKVALIDATION',
			),
		);

		$this->transactions['INSERT_ORDERWITHPAYMENT'] = array(
			'request' => array(
				'REQUEST' => array(
					'ACTION',
					'META' => array(
						'MERCHANTID',
						'IPADDRESS',
						'VERSION'
					),
					'PARAMS' => array(
						'ORDER' => array(
							'ORDERID',
							'AMOUNT',
							'CURRENCYCODE',
							'LANGUAGECODE',
							'COUNTRYCODE',
							'MERCHANTREFERENCE',
						),
						'PAYMENT' => array(
							'PAYMENTPRODUCTID',
							'AMOUNT',
							'CURRENCYCODE',
							'LANGUAGECODE',
							'COUNTRYCODE',
							'HOSTEDINDICATOR',
							'RETURNURL',
//							'CVV',
//							'EXPIRYDATE',
//							'CREDITCARDNUMBER',
							'FIRSTNAME',
							'SURNAME',
							'STREET',
							'CITY',
							'STATE',
							'ZIP',
							'EMAIL',
						)
					)
				)
			),
			'values' => array(
				'ACTION' => 'INSERT_ORDERWITHPAYMENT',
				'HOSTEDINDICATOR' => '1',
			),
		);

		$this->transactions['TEST_CONNECTION'] = array(
			'request' => array(
				'REQUEST' => array(
					'ACTION',
					'META' => array(
						'MERCHANTID',
							'IPADDRESS',
						'VERSION'
					),
					'PARAMS' => array( )
				)
			),
			'values' => array(
				'ACTION' => 'TEST_CONNECTION'
			)
		);

		$this->transactions['GET_ORDERSTATUS'] = array(
			'request' => array(
				'REQUEST' => array(
					'ACTION',
					'META' => array(
						'MERCHANTID',
						'IPADDRESS',
						'VERSION'
					),
					'PARAMS' => array(
						'ORDER' => array(
							'ORDERID',
						),
					)
				)
			),
			'values' => array(
				'ACTION' => 'GET_ORDERSTATUS',
				'VERSION' => '2.0'
			),
//			'loop_for_status' => array(
//				//'pending',
//				'pending-poke',
//				'complete',
//				'failed',
//				'revised',
//			)
		);
		
		$this->transactions['CANCEL_PAYMENT'] = array(
			'request' => array(
				'REQUEST' => array(
					'ACTION',
					'META' => array(
						'MERCHANTID',
						'IPADDRESS',
						'VERSION'
					),
					'PARAMS' => array(
						'PAYMENT' => array(
							'ORDERID',
							'EFFORTID',
							'ATTEMPTID',
						),
					)
				)
			),
			'values' => array(
				'ACTION' => 'CANCEL_PAYMENT',
				'VERSION' => '1.0'
			),
		);
		
		$this->transactions['SET_PAYMENT'] = array(
			'request' => array(
				'REQUEST' => array(
					'ACTION',
					'META' => array(
						'MERCHANTID',
						'IPADDRESS',
						'VERSION'
					),
					'PARAMS' => array(
						'PAYMENT' => array(
							'ORDERID',
							'EFFORTID',
							'PAYMENTPRODUCTID',
						),
					)
				)
			),
			'values' => array(
				'ACTION' => 'SET_PAYMENT',
				'VERSION' => '1.0'
			),
		);
	}
	
	/**
	 * Define payment methods
	 *
	 * The credit card group has a catchall for unspecified payment types.
	 */
	protected function definePaymentMethods() {
		
		$this->payment_methods = array();
		
		// Bank Transfers
		$this->payment_methods['bt'] = array(
			'label'	=> 'Bank transfer',
			'types'	=> array( 'bt', ),
			'validation' => array( 'creditCard' => false, )
		);
		
		// Credit Cards
		$this->payment_methods['cc'] = array(
			'label'	=> 'Credit Cards',
			'types'	=> array( '', 'visa', 'mc', 'amex', 'discover', 'maestro', 'solo', 'laser', 'jcb', 'cb', ),
		);
		
		// Direct Debit
		$this->payment_methods['dd'] = array(
			'label'	=> 'Direct Debit',
			'types'	=> array( 'dd_at', 'dd_be', 'dd_ch', 'dd_de', 'dd_es','dd_fr', 'dd_gb', 'dd_it', 'dd_nl', ),
			'validation' => array( 'creditCard' => false, )
		);
		
		// eWallets
		$this->payment_methods['ew'] = array(
			'label'	=> 'eWallets',
			'types'	=> array( 'ew_cashu', 'ew_moneybookers', 'ew_paypal', 'ew_webmoney', ),
			'validation' => array( 'address' => false, 'creditCard' => false, )
		);
		
		// Bank Transfers
		$this->payment_methods['obt'] = array(
			'label'	=> 'Online bank transfer',
			'types'	=> array( 'bpay', ),
			'validation' => array( 'creditCard' => false, )
		);
		
		// Real Time Bank Transfers
		$this->payment_methods['rtbt'] = array(
			'label'	=> 'Real time bank transfer',
			'types'	=> array( 'rtbt_ideal', 'rtbt_eps', 'rtbt_sofortuberweisung', 'rtbt_nordea_sweden', 'rtbt_enets', ),
		);

		// Cash payments
		$this->payment_meathods['cash'] = array(
			'label' => 'Cash payments',
			'types' => array( 'cash_boleto', ),
		);

	}

	/**
	 * Define payment submethods
	 *
	 */
	protected function definePaymentSubmethods() {
		
		$this->payment_submethods = array();

		/*
		 * Default => Credit Card
		 *
		 * Every payment_method should have a payment_submethod.
		 * This is just a catch to sure some validation happens. 
		 */
		 
		// None specified - This is a catchall to validate all options for credit cards.
		$this->payment_submethods[''] = array(
			'paymentproductid'	=> 0,
			'label'	=> 'Any',
			'group'	=> 'cc',
			'validation' => array( 'address' => true, 'amount' => true, 'email' => true, 'name' => true, ),
			'keys' => array(),
		);

		/*
		 * Bank transfers
		 */
		 
		// Bank Transfer
		$this->payment_submethods['bt'] = array(
			'paymentproductid'	=> 11,
			'label'	=> 'Bank Transfer',
			'group'	=> 'bt',
			'validation' => array(),
			'keys' => array(),
		);

		/*
		 * Credit Card
		 */
		 
		// Visa
		$this->payment_submethods['visa'] = array(
			'paymentproductid'	=> 1,
			'label'	=> 'Visa',
			'group'	=> 'cc',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// MasterCard
		$this->payment_submethods['mc'] = array(
			'paymentproductid'	=> 3,
			'label'	=> 'MasterCard',
			'group'	=> 'cc',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// American Express
		$this->payment_submethods['amex'] = array(
			'paymentproductid'	=> 2,
			'label'	=> 'American Express',
			'group'	=> 'cc',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// Maestro
		$this->payment_submethods['maestro'] = array(
			'paymentproductid'	=> 117,
			'label'	=> 'Maestro',
			'group'	=> 'cc',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// Solo
		$this->payment_submethods['solo'] = array(
			'paymentproductid'	=> 118,
			'label'	=> 'Solo',
			'group'	=> 'cc',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// Laser
		$this->payment_submethods['laser'] = array(
			'paymentproductid'	=> 124,
			'label'	=> 'Laser',
			'group'	=> 'cc',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// JCB
		$this->payment_submethods['jcb'] = array(
			'paymentproductid'	=> 125,
			'label'	=> 'JCB',
			'group'	=> 'cc',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// Discover
		$this->payment_submethods['discover'] = array(
			'paymentproductid'	=> 128,
			'label'	=> 'Discover',
			'group'	=> 'cc',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// CB
		$this->payment_submethods['cb'] = array(
			'paymentproductid'	=> 130,
			'label'	=> 'CB', // Carte Bancaire OR Carte Bleue
			'group'	=> 'cc',
			'validation' => array(),
			'keys' => array(),
		);


		/*
		 * Direct debit
		 *
		 * See: WebCollect 7.1 Technical guide: Appendix H Country-specific direct debit keys
		 *
		 * - keys: These values, which can be found in $this->var_map, will only be put in the request, if they are populated from the form or staging.
		 */
		 
		// Direct debit: AT
		$this->payment_submethods['dd_at'] = array(
			'paymentproductid'	=> 713,
			'label'	=> 'Direct debit: AT',
			'group'	=> 'dd',
			'validation' => array(),
			'keys' => array( 'ACCOUNTNAME', 'ACCOUNTNUMBER', 'BANKCODE', /*'BANKNAME',*/ 'DIRECTDEBITTEXT', ),
		);
		 
		// Direct debit: BE
		$this->payment_submethods['dd_be'] = array(
			'paymentproductid'	=> 716,
			'label'	=> 'Direct debit: BE',
			'group'	=> 'dd',
			'validation' => array(),
			'keys' => array( 'ACCOUNTNAME', 'ACCOUNTNUMBER', 'AUTHORISATIONID', 'BANKCHECKDIGIT', 'BANKCODE', 'BANKNAME', 'DIRECTDEBITTEXT', ),
			//'keys' => array( /*'ACCOUNTNAME',*/ 'ACCOUNTNUMBER', 'AUTHORISATIONID', /*'BANKCHECKDIGIT',*/ 'BANKCODE', /*'BANKNAME',*/ 'DIRECTDEBITTEXT', ),
		);
		 
		// Direct debit: CH
		$this->payment_submethods['dd_ch'] = array(
			'paymentproductid'	=> 717,
			'label'	=> 'Direct debit: CH',
			'group'	=> 'dd',
			'validation' => array(),
			'keys' => array( 'ACCOUNTNAME', 'ACCOUNTNUMBER', 'ADDRESSLINE1E', 'ADDRESSLINE2', 'ADDRESSLINE3', 'ADDRESSLINE4', 'BANKCODE', /*'BANKNAME',*/ /*'CUSTOMERBANKCITY', 'CUSTOMERBANKNUMBER', 'CUSTOMERBANKSTREET', 'CUSTOMERBANKZIP',*/ 'DIRECTDEBITTEXT', 'IBAN', ),
		);
		 
		// Direct debit: DE
		$this->payment_submethods['dd_de'] = array(
			'paymentproductid'	=> 712,
			'label'	=> 'Direct debit: DE',
			'group'	=> 'dd',
			'validation' => array(),
			'keys' => array( 'ACCOUNTNAME', 'ACCOUNTNUMBER', 'BANKCODE', /*'BANKNAME',*/ 'DIRECTDEBITTEXT', ),
		);
		 
		// Direct debit: ES
		$this->payment_submethods['dd_es'] = array(
			'paymentproductid'	=> 719,
			'label'	=> 'Direct debit: ES',
			'group'	=> 'dd',
			'validation' => array(),
			'keys' => array( 'ACCOUNTNAME', 'ACCOUNTNUMBER', 'BANKCODE', /*'BANKNAME',*/ 'BRANCHCODE', 'BANKCHECKDIGIT', /*'CUSTOMERBANKCITY', 'CUSTOMERBANKSTREET', 'CUSTOMERBANKZIP',*/ 'DIRECTDEBITTEXT', /*'DOMICILIO', 'PROVINCIA',*/ ),
		);
		 
		// Direct debit: FR
		$this->payment_submethods['dd_fr'] = array(
			'paymentproductid'	=> 714,
			'label'	=> 'Direct debit: FR',
			'group'	=> 'dd',
			'validation' => array(),
			'keys' => array( 'ACCOUNTNAME', 'ACCOUNTNUMBER', 'BANKCODE', /*'BANKNAME',*/ 'BRANCHCODE', 'BANKCHECKDIGIT', 'DIRECTDEBITTEXT', ),
		);
		 
		// Direct debit: GB
		$this->payment_submethods['dd_gb'] = array(
			'paymentproductid'	=> 715,
			'label'	=> 'Direct debit: GB',
			'group'	=> 'dd',
			'validation' => array(),
			'keys' => array( 'ACCOUNTNUMBER', 'AUTHORISATIONID', 'BANKCODE', /*'BANKNAME',*/ 'DIRECTDEBITTEXT', 'TRANSACTIONTYPE', ),
		);
		 
		// Direct debit: IT
		$this->payment_submethods['dd_it'] = array(
			'paymentproductid'	=> 718,
			'label'	=> 'Direct debit: IT',
			'group'	=> 'dd',
			'validation' => array(),
			'keys' => array( 'ACCOUNTNAME', 'ACCOUNTNUMBER', 'BANKCODE', /*'BANKNAME',*/ 'BRANCHCODE', 'BANKAGENZIA', 'BANKCHECKDIGIT', /*'BANKFILIALE',*/ /*'CUSTOMERBANKCITY', 'CUSTOMERBANKNUMBER', 'CUSTOMERBANKSTREET', 'CUSTOMERBANKZIP',*/ 'DIRECTDEBITTEXT', ),
		);
		 
		// Direct debit: NL
		$this->payment_submethods['dd_nl'] = array(
			'paymentproductid'	=> 711,
			'label'	=> 'Direct debit: NL',
			'group'	=> 'dd',
			'validation' => array(),
			'keys' => array( 'ACCOUNTNAME', 'ACCOUNTNUMBER', /*'BANKNAME',*/ 'DIRECTDEBITTEXT', 'TRANSACTIONTYPE', ),
		);

		/*
		 * eWallets
		 */
		 
		// eWallets PayPal
		$this->payment_submethods['ew_paypal'] = array(
			'paymentproductid'	=> 840,
			'label'	=> 'eWallets: PayPal',
			'group'	=> 'ew',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// eWallets WebMoney
		$this->payment_submethods['ew_webmoney'] = array(
			'paymentproductid'	=> 841,
			'label'	=> 'eWallets: WebMoney',
			'group'	=> 'ew',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// eWallets Moneybookers
		$this->payment_submethods['ew_moneybookers'] = array(
			'paymentproductid'	=> 843,
			'label'	=> 'eWallets: Moneybookers',
			'group'	=> 'ew',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// eWallets cashU
		$this->payment_submethods['ew_cashu'] = array(
			'paymentproductid'	=> 845,
			'label'	=> 'eWallets: cashU',
			'group'	=> 'ew',
			'validation' => array(),
			'keys' => array(),
		);

		/*
		 * Online bank transfers
		 */
		 
		// Online Bank Transfer Bpay
		$this->payment_submethods['bpay'] = array(
			'paymentproductid'	=> 500,
			'label'	=> 'Online Bank Transfer: Bpay',
			'group'	=> 'obt',
			'validation' => array(),
			'keys' => array(),
		);

		/*
		 * Real time bank transfers
		 */
		 
		// Nordea (Sweden)
		$this->payment_submethods['rtbt_nordea_sweden'] = array(
			'paymentproductid'	=> 805,
			'label'	=> 'Nordea (Sweden)',
			'group'	=> 'rtbt',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// Ideal
		$this->payment_submethods['rtbt_ideal'] = array(
			'paymentproductid'	=> 809,
			'label'	=> 'Ideal',
			'group'	=> 'rtbt',
			'validation' => array(),
			'keys' => array(),
			'issuerids' => array( 
				771	=> 'SNS Regio Bank',
				161	=> 'Van Lanschot Bankiers',
				31	=> 'ABN AMRO',
				761	=> 'ASN Bank',
				21	=> 'Rabobank',
				511	=> 'Triodos Bank',
				721	=> 'ING',
				751	=> 'SNS Bank',
				91	=> 'Friesland Bank',
			)
		);
		 
		// eNETS
		$this->payment_submethods['rtbt_enets'] = array(
			'paymentproductid'	=> 810,
			'label'	=> 'eNETS',
			'group'	=> 'rtbt',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// Sofortuberweisung/DIRECTebanking
		$this->payment_submethods['rtbt_sofortuberweisung'] = array(
			'paymentproductid'	=> 836,
			'label'	=> 'Sofortuberweisung/DIRECTebanking',
			'group'	=> 'rtbt',
			'validation' => array(),
			'keys' => array(),
		);
		 
		// eps Online-Überweisung
		$this->payment_submethods['rtbt_eps'] = array(
			'paymentproductid'	=> 856,
			'label'	=> 'eps Online-Überweisung',
			'group'	=> 'rtbt',
			'validation' => array(),
			'keys' => array(),
			'issuerids' => array( 
				824	=> 'Bankhaus Spängler',
				825	=> 'Hypo Tirol Bank',
				822	=> 'NÖ HYPO',
				823	=> 'Voralberger HYPO',
				828	=> 'P.S.K.',
				829	=> 'Easy',
				826	=> 'Erste Bank und Sparkassen',
				827	=> 'BAWAG',
				820	=> 'Raifeissen',
				821	=> 'Volksbanken Gruppe',
				831	=> 'Sparda-Bank',
			)
		);

		// Cash Payments - Boletos

		$this->payment_submethods['cash_boleto'] = array(
			'paymentproductid'	=> 1503,
			'label' => 'Boleto Bancario Brazil',
			'group' => 'cash',
			'validation' => array(),
			'keys' => array(),
		);
	}

	/**
	 * Get payment method meta
	 *
	 * @todo
	 * - These may need to move to the parent class
	 *
	 * @param	string	$payment_method	Payment methods contain payment submethods
	 */
	public function getPaymentMethodMeta( $payment_method ) {
		
		if ( isset( $this->payment_methods[ $payment_method ] ) ) {
			
			return $this->payment_methods[ $payment_method ];
		}
		else {
			$message = 'The payment method [ ' . $payment_method . ' ] was not found.';
			throw new Exception( $message );
		}
	}
	
	/**
	 * Get payment submethod meta
	 *
	 * @todo
	 * - These may need to move to the parent class
	 *
	 * @param	string	$payment_submethod	Payment submethods are mapped to paymentproductid
	 */
	public function getPaymentSubmethodMeta( $payment_submethod, $options = array() ) {
		
		extract( $options );
		
		$log = isset( $log ) ? (boolean) $log : false ;
		
		if ( isset( $this->payment_submethods[ $payment_submethod ] ) ) {
			
			if ( $log ) {
				$this->log( 'Getting payment submethod: ' . ( string ) $payment_submethod );
			}
			
			// Ensure that the validation index is set.
			if ( !isset( $this->payment_submethods[ $payment_submethod ]['validation'] ) ) {
				$this->payment_submethods[ $payment_submethod ]['validation'] = array();
			}
			
			return $this->payment_submethods[ $payment_submethod ];
		}
		else {
			$message = 'The payment submethod [ ' . $payment_submethod . ' ] was not found.';
			throw new Exception( $message );
		}
	}
	
	/**
	 * Get payment submethod form validation options
	 *
	 * @todo
	 * - These may need to move to the parent class
	 *
	 * @return	array
	 */
	public function getPaymentSubmethodFormValidation( $options = array() ) {
		
		$meta = $this->getPaymentSubmethodMeta( $this->getPaymentSubmethod() );
		
		return $meta['validation'];
	}
	
	/**
	 * Because GC has some processes that involve more than one do_transaction 
	 * chained together, we're catching those special ones in an overload and 
	 * letting the rest behave normally. 
	 */
	public function do_transaction( $transaction ){
		switch ( $transaction ){
			case 'Confirm_CreditCard' :
				$this->getStopwatch( 'Confirm_CreditCard', true );
				$result = $this->transactionConfirm_CreditCard();
				$this->saveCommunicationStats( 'Confirm_CreditCard', $transaction );
				return $result;
				break;
			default:
				return parent::do_transaction( $transaction );
		}
	}
	
	
	private function transactionConfirm_CreditCard(){
		global $wgRequest; //this is for pulling vars straight from the querystring
		$pull_vars = array(
			'CVVRESULT' => 'cvv_result',
			'AVSRESULT' => 'avs_result',
		);
		$addme = array();
		foreach ( $pull_vars as $theirkey => $ourkey) {
			$tmp = $wgRequest->getVal( $theirkey, null );
			if ( !is_null( $tmp ) ) { 
				$addme[$ourkey] = $tmp;
			}
		}
		
		$is_orphan = false;
		if ( count( $addme ) ){ //nothing unusual here. 
			$this->addData( $addme );
			$logmsg = $this->getData_Unstaged_Escaped( 'contribution_tracking_id' ) . ': ';
			$logmsg .= 'CVV Result: ' . $this->getData_Unstaged_Escaped( 'cvv_result' );
			$logmsg .= ', AVS Result: ' . $this->getData_Unstaged_Escaped( 'avs_result' );
			self::log( $logmsg );
		} else { //this is an orphan transaction. 
			$this->staged_data['order_id'] = $this->staged_data['i_order_id'];
			$is_orphan = true;
			//have to change this code range: All these are usually "pending" and 
			//that would still be true...
			//...aside from the fact that if the user has gotten this far, they left 
			//the part where they could add more data. 
			//By now, "incomplete" definitely means "failed" for 0-70. 
			$this->addCodeRange( 'GET_ORDERSTATUS', 'STATUSID', 'failed', 0, 70 );
		}
		
		$status_result = $this->do_transaction( 'GET_ORDERSTATUS' );
		
		$cancelflag = false; //this will denote the thing we're trying to do with the donation attempt
		$problemflag = false; //this will get set to true, if we can't continue and need to give up and just log the hell out of it. 
		$problemmessage = ''; //to be used in conjunction with the flag.
		$add_antimessage = false; //this tells us if we should add an antimessage when we are done or not.

		if ( $is_orphan ){
			if ( array_key_exists('data', $status_result) ) {
				foreach ( $pull_vars as $theirkey => $ourkey) {
					if ( array_key_exists($theirkey, $status_result['data']) ) {
						$addme[$ourkey] = $status_result['data'][$theirkey];
					}
				}
			}
			$gotCVV = false;
			if ( count( $addme ) ){
				$gotCVV = true;
				$this->addData( $addme );
				$this->staged_data['order_id'] = $this->staged_data['i_order_id'];
				$logmsg = $this->getData_Unstaged_Escaped( 'contribution_tracking_id' ) . ': ';
				$logmsg .= 'CVV Result: ' . $this->getData_Unstaged_Escaped( 'cvv_result' );
				$logmsg .= ', AVS Result: ' . $this->getData_Unstaged_Escaped( 'avs_result' );
				self::log( $logmsg );
				$this->runPreProcessHooks();
				$status_result['action'] = $this->getValidationAction();
			} 
		}
		
		//we filtered
		if ( array_key_exists( 'action', $status_result ) && $status_result['action'] != 'process' ){
			$cancelflag = true;
		} elseif ( array_key_exists( 'status', $status_result ) && $status_result['status'] === false ) {
		//can't communicate or internal error
			$problemflag = true;
		}
		
		$order_status_results = false;
		if ( !$cancelflag && !$problemflag ) {
			$order_status_results = $this->getTransactionWMFStatus();
			$txn_data = $this->getTransactionData();
			$original_status_code = isset( $txn_data['STATUSID']) ? $txn_data['STATUSID'] : 'NOT SET';
			if ( $is_orphan ){
				//save stats. 
				if (!isset($this->orphanstats) || !isset( $this->orphanstats[$original_status_code] ) ){
					$this->orphanstats[$original_status_code] = 1;
				} else {
					$this->orphanstats[$original_status_code] += 1;
				}				
			}
			if (!$order_status_results){
				$problemflag = true;
				$problemmessage = "We don't have a Transaction WMF Status after doing a GET_ORDERSTATUS.";
			}
			switch ( $order_status_results ){
				case 'failed' : 			
				case 'revised' :  
					$add_antimessage = true;
					$cancelflag = true; //makes sure we don't try to confirm.
					break;
				case 'complete' :
					$problemflag = true; //nothing to be done.
					$problemmessage = "GET_ORDERSTATUS reports that the payment is already complete.";
					$add_antimessage = true;
					break;
				case 'pending' :
					if ( $is_orphan && !$gotCVV ){
						$problemflag = true; 
						$problemmessage = "Unable to retrieve orphan cvv/avs results (Communication problem?).";
					} 
			}	
		}
		
		//if we got here with no problemflag, 
		//confirm or cancel the payment based on $cancelflag 
		if ( !$problemflag ){
			if ( isset( $status_result['data'] ) && is_array( $status_result['data'] ) ){
				//if they're set, get CVVRESULT && AVSRESULT
				$pull_vars['EFFORTID'] = 'effort_id';
				$pull_vars['ATTEMPTID'] = 'attempt_id';
				$addme = array();
				foreach ( $pull_vars as $theirkey => $ourkey) {
					if ( array_key_exists( $theirkey, $status_result['data'] ) ){
						$addme[$ourkey] = $status_result['data'][$theirkey];
					}
				}

				if ( count( $addme ) ){
					$this->addData( $addme );
				}
			}
			
			if ( !$cancelflag ){
				$final = $this->do_transaction( 'SET_PAYMENT' );
				if ( isset( $final['status'] ) && $final['status'] === true ) {
					$this->setTransactionWMFStatus( 'complete' );
					//get the old status from the first txn, and add in the part where we set the payment. 
					$this->setTransactionResult( "Original Response Status (pre-SET_PAYMENT): " . $original_status_code, 'txn_message' );
					$this->runPostProcessHooks();  //stomp is in here
					$this->unsetAllSessionData();
					$add_antimessage = true;
				} else {
					$problemflag = true;
					$problemmessage = "SET_PAYMENT couldn't communicate properly!";
				}
			} else {
				if ($order_status_results === false){
					//we didn't do the check, because we're going to fail the thing. 
					$final = $this->do_transaction( 'CANCEL_PAYMENT' );
					if ( isset( $final['status'] ) && $final['status'] === true ) {
						$this->setTransactionWMFStatus( 'failed' );
						$this->unsetAllSessionData();
						$add_antimessage = true;
					} else {
						$problemflag = true;
						$problemmessage = "CANCEL_PAYMENT couldn't communicate properly!";
					}
				} else {
					//in case we got wiped out, set the final status to what it was before. 
					$this->setTransactionWMFStatus( $order_status_results );
				}
			}
		}
		
		if ( $add_antimessage && !$is_orphan ) {
			//As it happens, we can't remove things from the queue here: It 
			//takes way too dang long. (~5 seconds!)
			//So, instead, I'll add an anti-message and deal with it later. (~.01 seconds) 
			$this->doLimboStompTransaction( true );
		}
		
		if ( $problemflag ){
			//we have probably had a communication problem that could mean stranded payments. 
			$problemmessage = $this->getData_Unstaged_Escaped( 'contribution_tracking_id' ) . ':' . $this->getData_Unstaged_Escaped( 'order_id' ) . ' ' . $problemmessage;
			self::log( $problemmessage );
			//hurm. It would be swell if we had a message that told the user we had some kind of internal error. 
			$ret = array(
				'status' => false,
				//TODO: appropriate messages. 
				'message' => $problemmessage,
				'errors' => array(
					'1000000' => 'Transaction could not be processed due to an internal error.'
				),
				'action' => $this->getValidationAction(),
			);
			return $ret;
		}
		
//		return something better... if we need to!
		return $status_result;
	}
	
	/**
	 * Take the entire response string, and strip everything we don't care about.
	 * For instance: If it's XML, we only want correctly-formatted XML. Headers must be killed off. 
	 * return a string.
	 *
	 * @param string	$rawResponse	The raw response a string of XML.
	 */
	public function getFormattedResponse( $rawResponse ) {
		$xmlString = $this->stripXMLResponseHeaders( $rawResponse );
		$displayXML = $this->formatXmlString( $xmlString );
		$realXML = new DomDocument( '1.0' );
		self::log( $this->getData_Unstaged_Escaped( 'contribution_tracking_id' ) . ": Raw XML Response:\n" . $displayXML ); //I am apparently a huge fibber.
		$realXML->loadXML( trim( $xmlString ) );
		return $realXML;
	}

	/**
	 * Parse the response to get the status. Not sure if this should return a bool, or something more... telling.
	 *
	 * @param array	$response	The response array
	 */
	public function getResponseStatus( $response ) {

		$aok = true;

		foreach ( $response->getElementsByTagName( 'RESULT' ) as $node ) {
			if ( array_key_exists( $node->nodeValue, $this->return_value_map ) && $this->return_value_map[$node->nodeValue] !== true ) {
				$aok = false;
			}
		}

		return $aok;
	}

	/**
	 * Parse the response to get the errors in a format we can log and otherwise deal with.
	 * return a key/value array of codes (if they exist) and messages. 
	 *
	 * If the site has $wgDonationInterfaceDisplayDebug = true, then the real
	 * messages will be sent to the client. Messages will not be translated or
	 * obfuscated. 
	 *
	 * @param array	$response	The response array
	 */
	public function getResponseErrors( $response ) {
		$errors = array( );
		foreach ( $response->getElementsByTagName( 'ERROR' ) as $node ) {
			$code = '';
			$message = '';
			foreach ( $node->childNodes as $childnode ) {
				if ( $childnode->nodeName === "CODE" ) {
					$code = $childnode->nodeValue;
				}
				if ( $childnode->nodeName === "MESSAGE" ) {
					$message = $childnode->nodeValue;
				}
			}

			$errors[ $code ] = ( $this->getGlobal( 'DisplayDebug' ) ) ? '*** ' . $message : $this->getErrorMapByCodeAndTranslate( $code );
		}
		return $errors;
	}

	/**
	 * Harvest the data we need back from the gateway. 
	 * return a key/value array
	 *
	 * When we set lookup error code ranges, we use GET_ORDERSTATUS as the key for search
	 * because they are only defined for that transaction type.
	 *
	 * @param DOMDocument	$response	The response object
	 */
	public function getResponseData( $response ) {
		$data = array( );

		$transaction = $this->getCurrentTransaction();

		switch ( $transaction ) {
			case 'INSERT_ORDERWITHPAYMENT':
				$data = $this->xmlChildrenToArray( $response, 'ROW' );
				$data['ORDER'] = $this->xmlChildrenToArray( $response, 'ORDER' );
				$data['PAYMENT'] = $this->xmlChildrenToArray( $response, 'PAYMENT' );
		
				// WMFStatus will already be set if the transaction was unable to communicate properly.
				if ( $this->getTransactionStatus() ) {
					$this->setTransactionWMFStatus( $this->findCodeAction( 'GET_ORDERSTATUS', 'STATUSID', $data['STATUSID'] ) );
				}

				break;
			case 'DO_BANKVALIDATION':
				$data = $this->xmlChildrenToArray( $response, 'RESPONSE' );
				unset( $data['META'] );
				$data['errors'] = array();
				$data['CHECKSPERFORMED'] = $this->xmlGetChecks( $response );
				$data['VALIDATIONID'] = $this->xmlChildrenToArray( $response, 'VALIDATIONID' );

				// WMFStatus will already be set if the transaction was unable to communicate properly.
				if ( $this->getTransactionStatus() ) {
					$this->setTransactionWMFStatus( $this->checkDoBankValidation( $data ) );
				}

				break;
			case 'GET_ORDERSTATUS':
				$data = $this->xmlChildrenToArray( $response, 'STATUS' );
				if (isset($data['STATUSID'])){
					$this->setTransactionWMFStatus( $this->findCodeAction( 'GET_ORDERSTATUS', 'STATUSID', $data['STATUSID'] ) );
				}
				$data['ORDER'] = $this->xmlChildrenToArray( $response, 'ORDER' );
				break;
		}

		return $data;
	}

	/**
	 * Parse the response object for the checked validations 
	 *
	 * @param DOMDocument	$response	The response object
	 */
	protected function xmlGetChecks( $response ) {
		
		$data = array(
			'CHECKS' => array(),
		);

		$checks = $response->getElementsByTagName( 'CHECK' );

		foreach ( $checks as $check ) {
			
			// Get the check code
			$checkCode = $check->getElementsByTagName('CHECKCODE')->item(0)->nodeValue;
			
			// Remove zero paddding
			$checkCode = ltrim( $checkCode, '0');
			
			// Convert it too an integer
			settype( $checkCode, 'integer' );
			
			$data['CHECKS'][ $checkCode ] = $check->getElementsByTagName('CHECKRESULT')->item(0)->nodeValue;
		}
		
		// Sort the error codes
		ksort( $data['CHECKS'] );

		return $data;
	}

	/**
	 * Interpret DO_BANKVALIDATION checks performed.
	 *
	 * The check results are returned as follows:
	 * 
	 * 	 <code>
	 * 		<RESPONSE>
	 * 			<RESULT>OK</RESULT>
	 * 			<META>
	 * 			<REQUESTID>207326</REQUESTID>
	 * 			<RESPONSEDATETIME>20111106054547</RESPONSEDATETIME>
	 * 			<CHECKSPERFORMED>
	 * 				<CHECK>
	 * 					<CHECKCODE>0030</CHECKCODE>
	 * 					<CHECKRESULT>NOTCHECKED</CHECKRESULT></CHECK>
	 * 				<CHECK>
	 * 					<CHECKCODE>0050</CHECKCODE>
	 * 					<CHECKRESULT>ERROR</CHECKRESULT></CHECK>
	 * 				<CHECK>
	 * 					<CHECKCODE>0051</CHECKCODE>
	 * 					<CHECKRESULT>NOTCHECKED</CHECKRESULT>
	 * 				</CHECK>
	 * 			</CHECKSPERFORMED>
	 * 		</RESPONSE>
	 * 	 </code>
	 *
	 * This will use the error map.
	 *
	 * PASSED is a successful validation.
	 *
	 * ERROR is a validation failure.
	 *
	 * WARNING: For now, this will be treated as failed.
	 *
	 * NOTCHECKED does not need to be worried about in the check results. These
	 * are supposed to appear if a validation failed, rendering the other
	 * validations pointless to check.
	 *
	 * @todo
	 * - There is a problem with the manual for DO_BANKVALIDATION. Failure should return NOK. Is this only on development?
	 * - Messages are not being translated by the provider.
	 * - What do we do about WARNING? For now, it is fail?
	 * - Get the validation id
	 *
	 * @param array	$data	The data array
	 *
	 * @return boolean
	 */
	public function checkDoBankValidation( &$data ) {
		
		$checks = &$data['CHECKSPERFORMED'];
		
		$hasValidationId = false;
		$isPass = 0;
		$isError = 0;
		$isWarning = 0;
		$isNotChecked = 0;
		
		$return = 'failed';
		
		if ( !is_array( $checks['CHECKS'] ) ) {
		
			// Should we trigger an error if no checks are performed?
			// For now, just return failed.
			return $return;
		}

		// We only mark validation as a failure if we have warnings or errors.
		$return = 'complete';
		
		foreach ( $checks['CHECKS'] as $checkCode => $checkResult ) {
			
			// Prefix error codes with dbv for DO_BANKVALIDATION
			$code = 'dbv-' . $checkCode;
			
			if ( $checkResult == 'ERROR' ) {
				$isError++;

				// Message might need to be put somewhere else.
				$data['errors'][ $code ] = $this->getErrorMap( $code );

			} elseif ( $checkResult == 'NOTCHECKED' ) {

				$isNotChecked++;

			} elseif ( $checkResult == 'PASSED' ) {

				$isPass++;

			} elseif ( $checkResult == 'WARNING' ) {

				$isWarning++;

				// Message might need to be put somewhere else.
				$data['errors'][ $code ] = $this->getErrorMap( $code );

			} else {
				
				$message = 'Unknown check result: (' . $checkResult . ')';
				
				throw new MWException( $message );
			}
		}
		
		// The return text needs to match something in @see $this->defineGoToThankYouOn()
		if ( $isPass ) {
			$return = 'complete';
		}
		
		if ( $isWarning ) {
			// This should be logged.
			$return = 'failed';
		}
		
		if ( $isError ) {
			$return = 'failed';
		}

		// Check to see if a validation id exists
		$hasValidationId = isset( $data['VALIDATIONID'] ) ? (boolean) $data['VALIDATIONID'] : false;
		
		// Do we have a validation ID?
		//$return = $hasValidationId ? $return : 'failed';
		
		return $return;
	}
	
	/**
	 * Set the bank validation error messages for the client.
	 *
	 * @todo
	 * - Only the first message will be returned. The reason is there are no translations for DO_BANKVALIDATION
	 *
	 * The messages have already been generated at this point. The purpose of
	 * this method is to pass them to the view.
	 */
	public function setBankValidationErrors() {

		$results = $this->getTransactionAllResults();

		$checks = $results['data'];

		$errors = isset( $checks['errors'] ) ? $checks['errors'] : array();

		$errorsToBeDisplayed = array();
		foreach ( $errors as $code => $error ) {
			$errorsToBeDisplayed[ $code ] = $this->getErrorMapByCodeAndTranslate( $code );
			
			// This break is temporary. All errors will have the same message. Only display it once.
			break;
		}

		$this->setTransactionResult( $errorsToBeDisplayed, 'errors' );
	}
	
	/**
	 * Gets all the currency codes appropriate for this gateway
	 * @return array of currency codes
	 */
	function getCurrencies() {
		// If you update this list, also update the list in the exchange_rates drupal module.
		$currencies = array(
			'AED', // UAE dirham
			'ARS', // Argentinian peso
			'AUD', // Australian dollar
			'BBD', // Barbadian dollar
			'BDT', // Bagladesh taka
			'BGN', // Bulgarian lev
			'BHD', // Bahraini dinar
			'BMD', // Bermudian dollar
			'BND', // Brunei dollar
			'BOB', // Bolivia boliviano
			'BRL', // Brazilian real
			'BSD', // Bahamian dollar
			'BZD', // Belize dollar
			'CAD', // Canadian dollar
			'CHF', // Swiss franc
			'CLP', // Chilean deso
			'CNY', // Chinese yuan renminbi
			'COP', // Colombia columb
			'CRC', // Costa Rican colon
			'CZK', // Czech koruna
			'DKK', // Danish krone
			'DOP', // Dominican peso
			'DZD', // Algerian dinar
			'EEK', // Estonian kroon
			'EGP', // Egyptian pound
			'EUR', // Euro
			'GBP', // British pound
			'GTQ', // Guatemala quetzal
			'HKD', // Hong Kong dollar
			'HNL', // Honduras lempira
			'HRK', // Croatian kuna
			'HUF', // Hungarian forint
			'IDR', // Indonesian rupiah
			'ILS', // Israeli shekel
			'INR', // Indian rupee
			'JMD', // Jamaican dollar
			'JOD', // Jordanian dinar
			'JPY', // Japanese yen
			'KES', // Kenyan shilling
			'KRW', // South Korean won
			'KYD', // Cayman Islands dollar
			'KZT', // Kazakhstani tenge
			'LBP', // Lebanese pound
			'LKR', // Sri Lankan rupee
			'LTL', // Lithuanian litas
			'LVL', // Latvian lats
			'MAD', // Moroccan dirham
			'MKD', // Macedonia denar
			'MUR', // Mauritius rupee
			'MVR', // Maldives rufiyaa
			'MXN', // Mexican peso
			'MYR', // Malaysian ringgit
			'NOK', // Norwegian krone
			'NZD', // New Zealand dollar
			'OMR', // Omani rial
			'PAB', // Panamanian balboa
			'PEN', // Peru nuevo sol
			'PHP', // Philippine peso
			'PKR', // Pakistani rupee
			'PLN', // Polish złoty
			'PYG', // Paraguayan guaraní
			'QAR', // Qatari rial
			'RON', // Romanian leu
			'RUB', // Russian ruble
			'SAR', // Saudi riyal
			'SEK', // Swedish krona
			'SGD', // Singapore dollar
			'SVC', // Salvadoran colón
			'THB', // Thai baht
			'TJS', // Tajikistani Somoni
			'TND', // Tunisan dinar
			'TRY', // Turkish lira
			'TTD', // Trinidad and Tobago dollar
			'TWD', // New Taiwan dollar
			'UAH', // Ukrainian hryvnia
			'UYU', // Uruguayan peso
			'USD', // U.S. dollar
			'UZS', // Uzbekistani som
			'VND', // Vietnamese dong
			'XAF', // Central African CFA franc
			'XCD', // East Caribbean dollar
			'XOF', // West African CFA franc
			'ZAR', // South African rand
		);
		return $currencies;
	}

	/**
	 * Process the response
	 *
	 * @param array	$response	The response array
	 */
	public function processResponse( $response ) {
		//set the transaction result message
		$responseStatus = isset( $response['STATUSID'] ) ? $response['STATUSID'] : '';
		$this->setTransactionResult( "Response Status: " . $responseStatus, 'txn_message' ); //TODO: Translate for GC. 
		$this->setTransactionResult( $this->getData_Unstaged_Escaped( 'order_id' ), 'gateway_txn_id' );
	}

	/**
	 * The default section of the switch will be hit on first time forms. This
	 * should be okay, because we are only concerned with staged_vars that have
	 * been posted.
	 *
	 * Credit cards staged_vars are set to ensure form failures on validation in
	 * the default case. This should prevent accidental form submission with
	 * unknown transaction types. 
	 */
	public function defineStagedVars() {
		//OUR field names. 
		$this->staged_vars = array(
			'amount',
			'card_type',
			//'card_num',
			'returnto',
			'payment_method',
			'payment_submethod',
			'issuer_id',
			'order_id', //This may or may not oughta-be-here...
			'language',
			'recurring'
		);
	}
	
	protected function stage_language( $type = 'request' ) {
		$language = strtolower( $this->staged_data['language'] );
		
		switch ( $type ) {
			case 'request':
				$count = 0;
				//Count's just there making sure we don't get stuck here. 
				while ( !in_array( $language, $this->getAvailableLanguages() ) && $count < 3 ){
					// Get the fallback language
					$language = Language::getFallbackFor( $language );
					$count += 1;
				}

				if ( !in_array( $language, $this->getAvailableLanguages() ) ){
					$language = 'en';
				}

				if ( $language === 'zh' ) { //Handles GC's mutant Chinese code.
					$language = 'sc';
				}

				break;
			case 'response':
				if ( $language === 'sc' ){
					$language = 'zh';
				}
				break;
		}
		
		$this->staged_data['language'] = $language;
			
	}
	
	/**
	 * OUR language codes which are available to use in GlobalCollect. 
	 * @return string 
	 */
	function getAvailableLanguages(){
		$languages = array(
			'ar', //Arabic
			'cz', //Czech
			'da', //Danish
			'nl', //Dutch
			'en', //English
			'fa', //Farsi
			'fi', //Finish
			'fr', //French
			'de', //German
			'he', //Hebrew
			'hi', //Hindi
			'hu', //Hungarian
			'it', //Italian
			'ja', //Japanese
			'ko', //Korean
			'no', //Norwegian
			'po', //Polish
			'pt', //Portuguese
			'ro', //Romanian
			'sl', //Slovene
			'es', //Spanish
			'sw', //Swahili
			'sv', //Swedish
			'th', //Thai
			'tr', //Turkish
			'ur', //Urdu
			'vi', //Vietnamese
			'zh', //the REAL chinese code. 
		);
		return $languages;
	}
	
	/**
	 * Stage: amount
	 *
	 * For example: JPY 1000.05 get changed to 100005. This need to be 100000.
	 * For example: JPY 1000.95 get changed to 100095. This need to be 100000.
	 *
	 * @param string	$type	request|response
	 */
	protected function stage_amount( $type = 'request' ) {
		switch ( $type ) {
			case 'request':
				
				// JPY cannot have cents.
				$floorCurrencies = array ( 'JPY' );
				if ( in_array( $this->staged_data['currency_code'], $floorCurrencies ) ) {
					$this->staged_data['amount'] = floor( $this->staged_data['amount'] );
				}
				
				$this->staged_data['amount'] = $this->staged_data['amount'] * 100;

				break;
			case 'response':
				$this->staged_data['amount'] = $this->staged_data['amount'] / 100;
				break;
		}
	}

	/**
	 * Stage: card_num
	 *
	 * @param string	$type	request|response
	 */
	protected function stage_card_num( $type = 'request' ) {
		//I realize that the $type isn't used. Voodoo.
		if ( array_key_exists( 'card_num', $this->staged_data ) ) {
			$this->staged_data['card_num'] = str_replace( ' ', '', $this->staged_data['card_num'] );
		}
	}

	/**
	 * Stage: card_type
	 *
	 * @param string	$type	request|response
	 */
	protected function stage_card_type( $type = 'request' ) {

		$types = array(
			'visa' => '1',
			'american' => '2',
			'amex' => '2',
			'american express' => '2',
			'mastercard' => '3',
			'mc' => '3',
			'maestro' => '117',
			'solo' => '118',
			'laser' => '124',
			'jcb' => '125',
			'discover' => '128',
			'cb' => '130',
		);

		if ( $type === 'response' ) {
			$types = array_flip( $types );
		}

		$card_type = $this->getData_Staged('card_type');
		if ( ( !is_null( $card_type ) ) && array_key_exists( $card_type, $types ) ) {
			$this->staged_data['card_type'] = $types[$card_type];
		} else {
			//$this->staged_data['card_type'] = '';
			//iono: maybe nothing? 
		}
	}

	/**
	 * Stage: setupStagePaymentMethodForDirectDebit
	 *
	 * @param string	$payment_submethod
	 * @param string	$type	request|response
	 */
	protected function setupStagePaymentMethodForDirectDebit( $payment_submethod, $type = 'request' ) {

		// DATECOLLECT is required on all Direct Debit
		$this->addKeyToTransaction('DATECOLLECT');

		$this->staged_data['date_collect'] = gmdate('Ymd');
		$this->staged_data['direct_debit_text'] = 'Wikimedia Foundation';
		
		$this->staged_data['payment_product'] = $this->payment_submethods[ $payment_submethod ]['paymentproductid'];
		$this->var_map['PAYMENTPRODUCTID'] = 'payment_product';
		$this->var_map['COUNTRYCODEBANK'] = 'country';

		$this->dataConstraints['iban']['length'] = 21;

		// Direct debit has different required fields for each paymentproductid.
		$this->addKeysToTransactionForSubmethod( $payment_submethod );
	}

	/**
	 * Stage: setupStagePaymentMethodForEWallets
	 *
	 * @param string	$payment_submethod
	 * @param string	$type	request|response
	 */
	protected function setupStagePaymentMethodForEWallets( $payment_submethod, $type = 'request' ) {

		// DESCRIPTOR is required on WebMoney, assuming it is required for all.
		$this->addKeyToTransaction('DESCRIPTOR');

		$this->staged_data['descriptor'] = 'Wikimedia Foundation/Wikipedia';

		$this->var_map['PAYMENTPRODUCTID'] = 'payment_product';
		$this->var_map['COUNTRYCODEBANK'] = 'country';
		
		$this->staged_data['payment_product'] = $this->payment_submethods[ $payment_submethod ]['paymentproductid'];

		// eWallets custom keys
		$this->addKeysToTransactionForSubmethod( $payment_submethod );
	}
	
	/**
	 * Stage: payment_method
	 *
	 * @param string	$type	request|response
	 *
	 * @todo
	 * - Need to implement this for credit card if necessary
	 * - ISSUERID will need to provide a dropdown for rtbt_eps and rtbt_ideal.
	 * - COUNTRYCODEBANK will need it's own dropdown for country. Do not map to 'country'
	 * - DATECOLLECT is using gmdate('Ymd')
	 * - DIRECTDEBITTEXT will need to be translated. This is what appears on the bank statement for donations for a client. This is hardcoded to: Wikimedia Foundation
	 */
	protected function stage_payment_method( $type = 'request' ) {
		
		$payment_method = array_key_exists( 'payment_method', $this->staged_data ) ? $this->staged_data['payment_method']: false;
		$payment_submethod = array_key_exists( 'payment_submethod', $this->staged_data ) ? $this->staged_data['payment_submethod']: false;

		// These will be grouped and ordred by payment product id
		switch ( $payment_submethod )  {
			
			/* Bank transfer */
			case 'bt':
				
				// Brazil
				if ( $this->staged_data['country'] == 'BR' ) {
					$this->dataConstraints['direct_debit_text']['city'] = 50;
				}

				// Korea - Manual does not specify North or South
				if ( $this->staged_data['country'] == 'KR' ) {
					$this->dataConstraints['direct_debit_text']['city'] = 50;
				}
				$this->staged_data['payment_product'] = $this->payment_submethods[ $payment_submethod ]['paymentproductid'];
				$this->var_map['PAYMENTPRODUCTID'] = 'payment_product';
				break;

			/* Direct Debit */
			case 'dd_nl':
				$this->dataConstraints['direct_debit_text']['length'] = 32;
				
				$this->setupStagePaymentMethodForDirectDebit( $payment_submethod, $type);
				break;
			case 'dd_gb':
				$this->staged_data['transaction_type'] = '01';
				
				$this->setupStagePaymentMethodForDirectDebit( $payment_submethod, $type);
				break;
			case 'dd_at':
				$this->dataConstraints['direct_debit_text']['length'] = 28;
				
				$this->setupStagePaymentMethodForDirectDebit( $payment_submethod, $type);
				break;
			case 'dd_be':
				
				$this->setupStagePaymentMethodForDirectDebit( $payment_submethod, $type);
				break;
			case 'dd_ch':
				
				$this->setupStagePaymentMethodForDirectDebit( $payment_submethod, $type);
				break;
			case 'dd_de':
				
				$this->setupStagePaymentMethodForDirectDebit( $payment_submethod, $type);
				break;
			case 'dd_es':
				$this->dataConstraints['direct_debit_text']['length'] = 40;
				
				$this->setupStagePaymentMethodForDirectDebit( $payment_submethod, $type);
				break;
			case 'dd_fr':
				$this->dataConstraints['direct_debit_text']['length'] = 18;
				
				$this->setupStagePaymentMethodForDirectDebit( $payment_submethod, $type);
				break;
			case 'dd_it':
				$this->dataConstraints['bank_check_digit']['length'] = 1;
				$this->dataConstraints['direct_debit_text']['length'] = 32;
				
				$this->setupStagePaymentMethodForDirectDebit( $payment_submethod, $type);
				break;
			
			/* eWallets */
			case 'ew_cashu':
			case 'ew_moneybookers':
			case 'ew_paypal':
			case 'ew_webmoney':
				$this->setupStagePaymentMethodForEWallets( $payment_submethod, $type);
				break;

			/* Cash payments */
			 case 'cash_boleto':
				$this->staged_data['payment_product'] = $this->payment_submethods[ $payment_submethod ]['paymentproductid'];
				$this->var_map['PAYMENTPRODUCTID'] = 'payment_product';

				$this->addKeyToTransaction('FISCALNUMBER');
				break;

			/* Online bank transfer */
			case 'bpay':
				$this->staged_data['payment_product'] = $this->payment_submethods[ $payment_submethod ]['paymentproductid'];
				$this->var_map['PAYMENTPRODUCTID'] = 'payment_product';
				break;
			
			/* Real time bank transfer */
			case 'rtbt_nordea_sweden':
			case 'rtbt_enets':
			case 'rtbt_sofortuberweisung':
				$this->staged_data['payment_product'] = $this->payment_submethods[ $payment_submethod ]['paymentproductid'];
				$this->var_map['PAYMENTPRODUCTID'] = 'payment_product';
				break;
			
			case 'rtbt_eps':
			case 'rtbt_ideal':
				$this->staged_data['payment_product'] = $this->payment_submethods[ $payment_submethod ]['paymentproductid'];
				$this->var_map['PAYMENTPRODUCTID'] = 'payment_product';

				$this->addKeysToTransactionForSubmethod( $payment_submethod );
				
				$this->addKeyToTransaction('ISSUERID');
				break;
				
			/* Default Case */
			default:
				
				// Nothing is done in the default case.
				break;
		}
	}
	
	/**
	 * Stage: recurring
	 * Adds the recurring payment pieces to the structure of 
	 * INSERT_ORDERWITHPAYMENT if the recurring field is populated.
	 *
	 * @param string	$type	request|response
	 */
	protected function stage_recurring( $type = 'request' ){
		if ( ! $this->getData_Staged( 'recurring' ) ){
			return;
		} else {
			$this->transactions['INSERT_ORDERWITHPAYMENT']['request']['REQUEST']['PARAMS']['ORDER'][] = 'ORDERTYPE';
			$this->transactions['INSERT_ORDERWITHPAYMENT']['values']['ORDERTYPE'] = '4';
		}
	}
	
	/**
	 * Add keys to transaction for submethod
	 *
	 */
	protected function addKeysToTransactionForSubmethod( $payment_submethod ) {

		// If there are no keys to add, do not proceed.
		if ( !is_array( $this->payment_submethods[ $payment_submethod ]['keys'] ) ) {
			
			return;
		}
		
		foreach ( $this->payment_submethods[ $payment_submethod ]['keys'] as $key ) {

			$this->addKeyToTransaction( $key );
		}
	}
	
	/**
	 * Stage: returnto
	 *
	 * @param string	$type	request|response
	 */
	protected function stage_returnto( $type = 'request' ) {
		
		if ( $type === 'request' ) {

			// Get the default returnto
			$returnto = $this->getData_Staged( 'returnto' );
			
			if ( $this->getData_Unstaged_Escaped( 'payment_method' ) === 'cc' ){
				
				// Add order ID to the returnto URL, only if it's not already there. 
				//TODO: This needs to be more robust (like actually pulling the 
				//qstring keys, resetting the values, and putting it all back)
				//but for now it'll keep us alive. 
				if ( !is_null( $returnto ) && !strpos( $returnto, 'order_id' ) ){
					$queryArray = array( 'order_id' => $this->staged_data['order_id'] );
					$this->staged_data['returnto'] = wfAppendQuery( $returnto, $queryArray );
				}
				
			} else {
				
				// Do we want to set this here?
				$this->staged_data['returnto'] = $this->getThankYouPage();
			}
		}
	}
	
	protected function pre_process_insert_orderwithpayment(){
		$this->incrementNumAttempt();
		if ( $this->getData_Unstaged_Escaped( 'payment_method' ) === 'cc' ){
			$this->addDonorDataToSession();
		}
	}
	
	/**
	 * post-process function for INSERT_ORDERWITHPAYMENT. 
	 * This gets called by executeIfFunctionExists, in do_transaction. 
	 */
	protected function post_process_insert_orderwithpayment(){
		//yeah, we absolutely want to do this for every one of these. 
		if ( $this->getTransactionStatus() === true ) {
			$data = $this->getTransactionData();
			$action = $this->findCodeAction( 'GET_ORDERSTATUS', 'STATUSID', $data['STATUSID'] );
			if ($action != 'failed'){
				$this->doLimboStompTransaction();
			}
		}
	}
	
	protected function pre_process_get_orderstatus(){
		if  ( $this->getData_Unstaged_Escaped( 'payment_method' ) === 'cc' ){
			$this->runPreProcessHooks();
		}
	}
	
	/**
	 * getCVVResult is intended to be used by the functions filter, to 
	 * determine if we want to fail the transaction ourselves or not. 
	 */
	public function getCVVResult(){
		if ( is_null( $this->getData_Unstaged_Escaped( 'cvv_result' ) ) ){
			return null;
		}
		
		$cvv_map = $this->getGlobal( 'CvvMap' );
		
		$result = $cvv_map[$this->getData_Unstaged_Escaped( 'cvv_result' )];
		return $result;

	}	
	
	/**
	 * getAVSResult is intended to be used by the functions filter, to 
	 * determine if we want to fail the transaction ourselves or not. 
	 */
	public function getAVSResult(){
		if ( is_null( $this->getData_Unstaged_Escaped( 'avs_result' ) ) ){
			return null;
		}
		//Best guess here: 
		//Scale of 0 - 100, of Problem we think this result is likely to cause.

		$avs_map = $this->getGlobal( 'AvsMap' );

		$result = $avs_map[$this->getData_Unstaged_Escaped( 'avs_result' )];
		return $result;
	}
	
}
