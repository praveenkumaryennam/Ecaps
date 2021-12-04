<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// organization
$route['company'] 						= 			'organization/company'; 
$route['locations'] 					= 			'organization/locations'; 
$route['departments'] 					= 			'organization/departments'; 
$route['designations'] 					= 			'organization/designations'; 
$route['roles'] 						= 			'organization/roles'; 
$route['labdepartments'] 				= 			'organization/labdepartments'; 
$route['countries'] 					= 			'organization/countries'; 
$route['states'] 						= 			'organization/states'; 
$route['cities'] 						= 			'organization/cities'; 
$route['stations'] 						= 			'organization/stations'; 
$route['zones'] 						= 			'organization/zones'; 
$route['source'] 						= 			'organization/source'; 
$route['qualifications'] 				= 			'organization/qualifications'; 
$route['correctiontemplate'] 			= 			'organization/correctiontemplate'; 
// END organization

// jobmaster
$route['shades'] 						= 			'jobmaster/shade';
$route['shade-guide'] 					= 			'jobmaster/shadeguide';
// END jobmaster
$route['product-category'] 				= 			'productmaster/category';
$route['product-brand'] 				= 			'productmaster/brand';
$route['product-warranty'] 				=	 		'productmaster/warranty';
$route['product-group'] 				= 			'productmaster/group';
$route['product-type'] 					= 			'productmaster/type';
$route['products'] 						= 			'productmaster/product';
$route['employees'] 					= 			'employee/index';
$route['view'] 							= 			'targets/view';
$route['attendance'] 					= 			'attendance';
$route['parent'] 						= 			'clients/parent';
$route['category'] 						= 			'clients/category';
$route['clients'] 						= 			'clients/index';
$route['blocked_list'] 					= 			'clients/blocked_list';
$route['doctor_capping'] 				= 			'clients/doctor_capping';

$route['new-order'] 					= 			'orders/clients';
$route['orders'] 						= 			'orders/index';

$route['invoices'] 						= 			'orders/invoices';

$route['creditnote'] 					= 			'payment/creditnote';
$route['case_details/(:any)'] 			=	 		'productmaster/case_details/$1';
$route['shade_info/(:any)'] 			=	 		'productmaster/shade_info/$1';
$route['case_details/(:any)/(:any)/(:any)'] 			=	 		'productmaster/case_details/$1/$2/$3';
$route['case_info/(:any)/(:any)/(:any)'] 			=	 		'productmaster/case_info/$1/$2/$3';
$route['warranty_card'] 				= 			'productmaster/warranty_card';
$route['warrantycards'] 				= 			'productmaster/warrantycards';
$route['note'] 							= 			'shipment/note';
$route['challans'] 						= 			'shipment/challans';
$route['shipingtoday'] 					= 			'shipment/shipingtoday';
$route['shipingreport'] 				= 			'shipment/shipingreport';
$route['bulkchallan'] 					= 			'shipment/bulkchallan';
$route['getorders'] 					= 			'orders/getorders';
$route['printinvoices'] 				= 			'orders/printinvoices';
$route['payment'] 						= 			'payment';
$route['order-sales-report'] 			= 			'reports/index';
$outer['zonewisesalesreport'] 			= 			'reports/zonewisesalesreport';
$outer['labslipreport']					= 			'reports/labslipreport';
$route['processtree'] 					= 			'reports/processtree';
$route['processdata'] 					= 			'reports/processdata';
$route['reports'] 						= 			'reports/index';
$route['payments'] 						= 			'reports/payments';
$route['invoicesummary']				= 			'reports/invoicesummary';
$route['dailyproductivitydata'] 		= 			'reports/dailyproductivitydata';
$route['challanreport'] 				= 			'reports/challanreport';
$route['citywiseclients']				= 			'reports/citywiseclients';
$route['zonewiseclients']				= 			'reports/zonewiseclients';
$route['redoreports'] 					= 			'reports/redoreports';
$route['correctionorders'] 				= 			'reports/correctionorders';
$route['zonewisesalesreport']			= 			'reports/zonewisesalesreport';
$route['citywisesalesreport'] 			= 			'reports/citywisesalesreport';
$route['labslipreport'] 				= 			'reports/labslipreport';
$route['target_arhive'] 				= 			'reports/target_arhive';
$route['daywise_target_arhive'] 		= 			'reports/daywise_target_arhive';
$route['monthly_target_arhive'] 		= 			'reports/monthly_target_arhive';
$route['rawdata'] 						= 			'reports/rawdata';
$route['attendance'] 					= 			'reports/attendance';
$route['clientslastorders']     		= 			'reports/clientslastorders';
$route['lmsd-report']     				= 			'reports/lmsd';
$route['outstanding-report']     		= 			'reports/outstandingreport';
$route['orcp-report']		     		= 			'reports/orcp';
$route['pending-challans']		     		= 			'reports/pendingchallans';



$route['refer_by']		     		= 			'organization/refer_by';


$route['analysereports'] 				= 			'analysereports/index';
$route['dispatchreport'] 				= 			'analysereports/dispatchreport';
$route['daily_analyse_report'] 			= 			'analysereports/daily_analyse_report';
$route['monthly_analyse_report']		= 			'analysereports/monthly_analyse_report';
$route['stations_analyse_report']		= 			'analysereports/stations_analyse_report';
$route['technitialproductivitydata'] 	= 			'analysereports/technitialproductivitydata';
$route['monthlyproductivitydata'] 		= 			'analysereports/monthlyproductivitydata';
$route['productanalyzereport'] 			= 			'analysereports/productanalyzereport';
$route['clientrankingreport'] 			= 			'analysereports/clientrankingreport';
$route['sourcewisereport'] 				= 			'analysereports/sourcewisereport';
$route['benchmarkreport'] 				= 			'analysereports/benchmarkreport';

//Vuew Invoice
$route['invoice/(:any)'] 				= 			'orders/bulkinvoice/$1';
$route['invoice/edit/(:any)'] 			= 			'orders/editinvoice/$1';


$route['change-password/(:any)'] 	    =             'login/changepassword/$1';

$route['offer-master'] 	    			=             'offer';



$route['logout'] = 'login/logout';


$route['attendance/(:any)'] = 'attendance/index/$1';
$route['newpassword'] = 'login/changepassword';
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
