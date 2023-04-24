<?php
// Heading
$_['heading_title'] = 'VodaPay Gateway';

//Environment
$_['environment_virtual']	= 0;
$_['environment_uat']	= 1;
$_['environment_prod']	= 2;

// Text
$_['text_extension'] = 'Extensions';
$_['text_success'] = 'Success: You have modified VodaPay Gateway!';
$_['text_edit'] = 'Edit VodaPay Gateway';
$_['text_authorization'] = 'Authorization';
$_['text_evironment_virtual'] = 'Virtual Testing';
$_['text_evironment_uat'] = 'UAT Testing';
$_['text_evironment_prod'] = 'Production Testing';
$_['text_vpg'] = '<a href="https://docs.vodapaygateway.vodacom.co.za/docs/category/plugins" target="_blank"><img src="view/image/payment/vpg.svg" alt="VPG" title="VPG" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_api'] = 'API Key';
$_['text_sale'] = 'Sale';


// Entry
$_['entry_debug'] = 'Debug Mode';
$_['entry_notification'] = 'Notification URL';
$_['entry_merchant_image_url'] = 'Merchant Image URL';
$_['entry_merchant_message_url'] = 'Merchant Message URL';
$_['entry_total'] = 'Total';
$_['entry_status'] = 'Status';
$_['entry_sort_order'] = 'Sort Order';
$_['entry_environment'] = 'Environment';
$_['entry_api'] = 'API Key';

// Tab
$_['tab_general'] = 'General';
$_['tab_order_status'] = 'Order Status';

// Help
$_['help_test'] = 'Which server must be used to process transactions?';
$_['help_debug'] = 'Logs additional information to the system log';
$_['help_notification'] = 'A HTTPS URL to notify transaction status (Max. 255 characters long)';
$_['help_merchant_image_url'] = 'The merchant Logo URL';
$_['help_merchant_message_url'] = 'The merchant message';
$_['help_total'] = 'The checkout total the order must reach before this payment method becomes active';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify payment VodaPay Gateway!';
$_['error_api'] = 'API is required!';

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