<?php
//Environmnet
$_['environment_virtual']	= 0;
$_['environment_uat']	= 1;
$_['environment_prod']	= 2;

// Text
$_['text_title']	= 'Vodapay Gateway';
$_['text_testmode']	= 'Warning: The payment gateway is in \'Sandbox Mode\'. Your account will not be charged.';
$_['text_total']	= 'Shipping, Handling, Discounts & Taxes';
$_['text_unable']   = 'Unable to locate or update your order status';
$_['text_declined'] = 'Payment was declined';
$_['text_failed']   = 'Payment Transaction Failed';
$_['text_failed_message']   = '<p>Unfortunately there was an error processing your Payment transaction.</p><p><b>Warning: </b></p>';
$_['text_basket']   = 'Basket';
$_['text_checkout'] = 'Checkout';
$_['text_success']  = 'Success';

//Button
$_['button_confirm']	= 'Continue';

//Repsonses
/* Begin - Good response codes */
$_['r00'] = 'Approved or completed successfully';//RESPONSE_CODE_OK
$_['r08'] = 'Honor with identification';//RESPONSE_CODE_HONOR_WITH_IDENTIFIACTION
$_['r10'] = 'Approved, partial';//RESPONSE_CODE_APPROVED_PARTIAL
$_['r11'] = 'Approved, VIP';//RESPONSE_CODE_APPROVED_VIP
$_['r16'] = 'Approved, update track 3';//RESPONSE_CODE_APPROVED_UPDATE_TRK3
$_['good_response'] = '00'.','.'08'.','.'10'.','.'11'.','.'16';
/* End - Good response codes */

/* Begin - Bad response codes */
$_['r03'] = 'Invalid merchant';//RESPONSE_CODE_INVALID_MERCHANT
$_['r04'] = 'Pick-up card';//RESPONSE_CODE_PICKUP_CARD
$_['r05'] = 'Do not honor';//RESPONSE_CODE_DO_NOT_HONOR
$_['r06'] = 'Error';//RESPONSE_CODE_ERROR
$_['r17'] = 'Customer cancellation';//RESPONSE_CODE_CUSTOMER_CANCELLATION
$_['r26'] = 'Duplicate record';//RESPONSE_CODE_DUPLICATE_RECORD
$_['r51'] = 'Insufficient funds';//RESPONSE_CODE_INSUFFICIENT_FUNDS
$_['r54'] = 'Expired card';//RESPONSE_CODE_EXPIRED_CARD
$_['r56'] = 'No card record';//RESPONSE_CODE_NO_CARD_RECORD
$_['r68'] = 'Response received too late';//RESPONSE_CODE_RESPONSE_RECEIVED_TOO_LATE
$_['r91'] = 'Issuer or switch inoperative';//RESPONSE_CODE_ISSUER_OR_SWITCH_INOPERATIVE
$_['r92'] = 'Routing error';//RESPONSE_CODE_ROUTING_ERROR
$_['r96'] = 'System malfunction';//RESPONSE_CODE_SYSTEM_MALFUNCTION
$_['D1'] = 'Invalid Service Level or level exceeded.';//RESPONSE_CODE_INVALID_SERVICE_LEVEL
$_['D2'] = 'Invalid transaction parameteres usage';//RESPONSE_CODE_INVALID_TRANSACTION_PARAMETERS_USAGE
$_['D3'] = 'Repeat attempted, but certain parameters do not match.';//RESPONSE_CODE_REPEAT_PARAMETER_MISMATCH
$_['D4'] = 'A transaction with the sameparameters is already in progress.';//RESPONSE_CODE_TRANSACTION_IN_PROGRESS
$_['bad_response']    = '03'.','.'04'.','.'05'.','.'06'.','.'17'.','.'26'.','.'51'.','.'54'.','.'56'.','.'68'.','.'91'.','.'92';
/* End - Bad response codes */
