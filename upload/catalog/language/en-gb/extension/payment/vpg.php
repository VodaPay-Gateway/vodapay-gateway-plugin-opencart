<?php
//Environmnet
$_['environment_virtual']	= 0;
$_['environment_uat']	= 1;
$_['environment_prod']	= 2;

// Text
$_['text_title']	= 'Vodapay Gateway';
$_['text_testmode']	= 'Warning: The payment gateway is in \'Sandbox Mode\'. Your account will not be charged.';
$_['text_total']	= 'Shipping, Handling, Discounts & Taxes';

//Button
$_['button_confirm']	= 'Continue';

//Repsonses
/* Begin - Good response codes */
$_['00'] = 'Approved or completed successfully';//RESPONSE_CODE_OK
$_['08'] = 'Honor with identification';//RESPONSE_CODE_HONOR_WITH_IDENTIFIACTION
$_['10'] = 'Approved, partial';//RESPONSE_CODE_APPROVED_PARTIAL
$_['11'] = 'Approved, VIP';//RESPONSE_CODE_APPROVED_VIP
$_['16'] = 'Approved, update track 3';//RESPONSE_CODE_APPROVED_UPDATE_TRK3
$_['good_response'] = '00'.','.'08'.','.'10'.','.'11'.','.'16';
/* End - Good response codes */

/* Begin - Bad response codes */
$_['03'] = 'Invalid merchant';//RESPONSE_CODE_INVALID_MERCHANT
$_['04'] = 'Pick-up card';//RESPONSE_CODE_PICKUP_CARD
$_['05'] = 'Do not honor';//RESPONSE_CODE_DO_NOT_HONOR
$_['06'] = 'Error';//RESPONSE_CODE_ERROR
$_['17'] = 'Customer cancellation';//RESPONSE_CODE_CUSTOMER_CANCELLATION
$_['26'] = 'Duplicate record';//RESPONSE_CODE_DUPLICATE_RECORD
$_['51'] = 'Insufficient funds';//RESPONSE_CODE_INSUFFICIENT_FUNDS
$_['54'] = 'Expired card';//RESPONSE_CODE_EXPIRED_CARD
$_['56'] = 'No card record';//RESPONSE_CODE_NO_CARD_RECORD
$_['68'] = 'Response received too late';//RESPONSE_CODE_RESPONSE_RECEIVED_TOO_LATE
$_['91'] = 'Issuer or switch inoperative';//RESPONSE_CODE_ISSUER_OR_SWITCH_INOPERATIVE
$_['92'] = 'Routing error';//RESPONSE_CODE_ROUTING_ERROR
$_['96'] = 'System malfunction';//RESPONSE_CODE_SYSTEM_MALFUNCTION
$_['D1'] = 'Invalid Service Level or level exceeded.';//RESPONSE_CODE_INVALID_SERVICE_LEVEL
$_['D2'] = 'Invalid transaction parameteres usage';//RESPONSE_CODE_INVALID_TRANSACTION_PARAMETERS_USAGE
$_['D3'] = 'Repeat attempted, but certain parameters do not match.';//RESPONSE_CODE_REPEAT_PARAMETER_MISMATCH
$_['D4'] = 'A transaction with the sameparameters is already in progress.';//RESPONSE_CODE_TRANSACTION_IN_PROGRESS
$_['bad_response']    = '03'.','.'04'.','.'05'.','.'06'.','.'17'.','.'26'.','.'51'.','.'54'.','.'56'.','.'68'.','.'91'.','.'92';
/* End - Bad response codes */