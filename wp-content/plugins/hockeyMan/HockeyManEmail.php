<?php
require_once 'HockeyManConstants.php';
/**
 * A class with which to build emails to send out.
 */
class HockeyManEmail {

	private $mailText = "";
	public $letterComplete = FALSE;

	public function __construct() {

		$this->mailText = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			    <head>
			        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			        <meta name="viewport" content="width=device-width, initial-scale=1.5"/>
			        <title>'.PRODUCT_NAME.'</title>

			        <style type="text/css">
						/*////// RESET STYLES //////*/
						body, #bodyTable, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;}
						table{border-collapse:collapse;}
						img, a img{border:0; outline:none; text-decoration:none;}
						h1, h2, h3, h4, h5, h6{margin:0; padding:0;}
						p{margin: 1em 0;}

						/*////// CLIENT-SPECIFIC STYLES //////*/
						.ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail/Outlook.com to display emails at full width. */
						.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} /* Force Hotmail/Outlook.com to display line heights normally. */
						table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up. */
						#outlook a{padding:0;} /* Force Outlook 2007 and up to provide a "view in browser" message. */
						img{-ms-interpolation-mode: bicubic;} /* Force IE to smoothly render resized images. */
						body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;} /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */

						/*////// FRAMEWORK STYLES //////*/
						.flexibleContainerCell{padding-top:20px; padding-Right:20px; padding-Left:20px;}
						.flexibleImage{height:auto;}
						.bottomShim{padding-bottom:20px;}
						.imageContent, .imageContentLast{padding-bottom:20px;}
						.nestedContainerCell{padding-top:20px; padding-Right:20px; padding-Left:20px;}

						/*////// GENERAL STYLES //////*/
						body, #bodyTable{background-color:#F5F5F5;}
						#bodyCell{padding-top:40px; padding-bottom:40px;}
						#emailBody{background-color:#FFFFFF; border:1px solid #DDDDDD; border-collapse:separate; border-radius:4px;}
						h1, h2, h3, h4, h5, h6{color:#202020; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left;}
						.textContent, .textContentLast{color:#404040; font-family:Helvetica; font-size:16px; line-height:125%; text-align:Left; padding-bottom:20px;}
						.textContent a, .textContentLast a{color:#2C9AB7; text-decoration:underline;}
						.nestedContainer{background-color:#E5E5E5; border:1px solid #CCCCCC;}
						.emailButton{background-color:#2C9AB7; border-collapse:separate; border-radius:4px;}
						.buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}
						.buttonContent a{color:#FFFFFF; display:block; text-decoration:none;}
						.emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}
						.emailCalendarMonth{background-color:#2C9AB7; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}
						.emailCalendarDay{color:#2C9AB7; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}

						/*////// MOBILE STYLES //////*/
						@media only screen and (max-width: 480px){			
							/*////// CLIENT-SPECIFIC STYLES //////*/
							body{width:100% !important; min-width:100% !important;} /* Force iOS Mail to render the email at full width. */

							/*////// FRAMEWORK STYLES //////*/
							/*
								CSS selectors are written in attribute
								selector format to prevent Yahoo Mail
								from rendering media query styles on
								desktop.
							*/
							/*table[id="emailBody"]{width:100% !important;}*/
							table[class="flexibleContainer"]{width:100% !important;}
							img[class="flexibleImage"]{width:100% !important;}
							/*table[class="emailButton"]{width:100% !important;}*/
							td[class="buttonContent"]{padding:0 !important;}
							td[class="buttonContent"] a{padding:15px !important;}
							td[class="textContentLast"], td[class="imageContentLast"]{padding-top:20px !important;}

							/*////// GENERAL STYLES //////*/
							td[id="bodyCell"]{padding-top:10px !important; padding-Right:10px !important; padding-Left:10px !important;}
						}
					</style>
			        <!--[if mso 12]>
			            <style type="text/css">
			            	.flexibleContainer{display:block !important; width:100% !important;}
			            </style>
			        <![endif]-->
			        <!--[if mso 14]>
			            <style type="text/css">
			            	.flexibleContainer{display:block !important; width:100% !important;}
			            </style>
			        <![endif]-->
			    </head>
			    <body>
			    	<center>
			        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
			            	<tr>
			                	<td align="center" valign="top" id="bodyCell">
			                    	<!-- EMAIL CONTAINER // -->
			                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="emailBody">
		';

	}

	public function addFullWidthRow($title, $body) {
		$this->mailText .= '
			<!-- MODULE ROW // -->
			<tr>
            	<td align="center" valign="top">
                	<!-- CENTERING TABLE // -->
                	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                    	<tr>
                        	<td align="center" valign="top">
                            	<!-- FLEXIBLE CONTAINER // -->
                            	<table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer">
                                	<tr>
                                    	<td align="center" valign="top" width="600" class="flexibleContainerCell">
                                            <!-- CONTENT TABLE // -->
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td valign="top" class="textContent">
                                                        <h3>'.$title.'</h3>
                                                        <br />
                                                        '.$body.'
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // CONTENT TABLE -->
                                        </td>
                                    </tr>
                                </table>
                                <!-- // FLEXIBLE CONTAINER -->
                            </td>
                        </tr>
                    </table>
                    <!-- // CENTERING TABLE -->
                </td>
            </tr>
            <!-- // MODULE ROW -->
		';
	}

	public function addTwoColumnRow($titleLeft, $bodyLeft, $titleRight, $bodyRight) {

		$this->mailText .= '
			<!-- MODULE ROW // -->
			<tr>
            	<td align="center" valign="top">
                	<!-- CENTERING TABLE // -->
                	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                    	<tr>
                        	<td align="center" valign="top">
                            	<!-- FLEXIBLE CONTAINER // -->
                            	<table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer">
                                	<tr>
                                    	<td valign="top" width="600" class="flexibleContainerCell">
                                            <!-- CONTENT TABLE // -->
                                            <table align="Left" border="0" cellpadding="0" cellspacing="0" width="260" class="flexibleContainer">
                                                <tr>
                                                    <td valign="top" class="textContent">
                                                        <h3>'.$titleLeft.'</h3>
                                                        <br />
                                                        '.$bodyLeft.'
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // CONTENT TABLE -->


                                            <!-- CONTENT TABLE // -->
                                            <table align="Right" border="0" cellpadding="0" cellspacing="0" width="260" class="flexibleContainer">
                                                <tr>
                                                    <td valign="top" class="textContentLast">
                                                        <h3>'.$titleRight.'</h3>
                                                        <br />
                                                        '.$bodyRight.'
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // CONTENT TABLE -->
                                        </td>
                                    </tr>
                                </table>
                                <!-- // FLEXIBLE CONTAINER -->
                            </td>
                        </tr>
                    </table>
                    <!-- // CENTERING TABLE -->
                </td>
            </tr>
            <!-- // MODULE ROW -->
		';
	}

	public function addCallToActionButton($buttonText, $link, $width = 260) {
		$this->mailText .= '
			<!-- MODULE ROW // -->
			<tr>
            	<td align="center" valign="top">
                	<!-- CENTERING TABLE // -->
                	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                    	<tr>
                        	<td align="center" valign="top">
                            	<!-- FLEXIBLE CONTAINER // -->
                            	<table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer">
                                	<tr>
                                    	<td align="center" valign="top" width="600" class="flexibleContainerCell bottomShim">
                                            <!-- CONTENT TABLE // -->
                                            <table border="0" cellpadding="0" cellspacing="0" width="'.$width.'" class="emailButton">
                                                <tr>
                                                    <td align="center" valign="middle" class="buttonContent">
                                                        <a href="'.$link.'" target="_blank">'.$buttonText.'</a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // CONTENT TABLE -->
                                        </td>
                                    </tr>
                                </table>
                                <!-- // FLEXIBLE CONTAINER -->
                            </td>
                        </tr>
                    </table>
                    <!-- // CENTERING TABLE -->
                </td>
            </tr>
            <!-- // MODULE ROW -->
		';
	}

	public function addCalloutRow($title, $body) {
		$this->mailText .= '

			<!-- MODULE ROW // -->
			<tr>
            	<td align="center" valign="top">
                	<!-- CENTERING TABLE // -->
                	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                    	<tr>
                        	<td align="center" valign="top">
                            	<!-- FLEXIBLE CONTAINER // -->
                            	<table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer">
                                	<tr>
                                    	<td align="center" valign="top" width="600" class="flexibleContainerCell bottomShim">
                                        	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="nestedContainer">
                                            	<tr>
                                                	<td align="center" valign="top" class="nestedContainerCell">
                                                        <!-- CONTENT TABLE // -->
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td valign="top" class="textContent">
                                                                    <h3>'.$title.'</h3>
			                                                        <br />
			                                                        '.$body.'
			                                                    </td>
                                                            </tr>
                                                        </table>
                                                        <!-- // CONTENT TABLE -->
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <!-- // FLEXIBLE CONTAINER -->
                            </td>
                        </tr>
                    </table>
                    <!-- // CENTERING TABLE -->
                </td>
            </tr>
            <!-- // MODULE ROW -->

		';
	}

	public function addFooter() {

		$this->addFullWidthRow("Brought To You By Incite Social Promotion",
			'This email was auto-generated by the Incite Team Manager Software, 
			if you have any problems please contact <a href="mailto:teammanager@incitepromo.com">TeamManager@incitepromo.com</a>');

		$this->mailText .= '

					</table>
		                    	<!-- // EMAIL CONTAINER -->
		                    </td>
		                </tr>
		            </table>
		        </center>
		    </body>
		</html>

		';

		$this->letterComplete = TRUE;
	}

	public function returnEmail() {
		if($this->letterComplete){
			$pre = Premailer::html($this->mailText);
			return $pre['html'];
		}
		else 
			return $this->letterComplete;
	}

}

/**
 * Premailer API PHP class
 * Premailer is a library/service for making HTML more palatable for various inept email clients, in particular GMail
 * Primary function is to convert style tags into equivalent inline styles so styling can survive <head> tag removal
 * Premailer is owned by Dialect Communications group
 * @link http://premailer.dialect.ca/api
 * @author Marcus Bointon <marcus@synchromedia.co.uk>
 */
 
class Premailer {
	/**
	 * The Premailer API URL
	 */
	const ENDPOINT = 'http://premailer.dialect.ca/api/0.1/documents';
	static $CI ;
	public function __construct()
	{
		self::$CI =& get_instance();
		self::$CI->load->library('my_curl');
		
	}
	/**
	 * Central static method for submitting either an HTML string or a URL, optionally retrieving converted versions
	 * @static
	 * @throws Exception
	 * @param string $html Raw HTML source
	 * @param string $url URL of the source file
	 * @param bool $fetchresult Whether to also fetch the converted output
	 * @param string $adaptor Which document handler to use (hpricot (default) or nokigiri)
	 * @param string $base_url Base URL for converting relative links
	 * @param int $line_length Length of lines in the plain text version (default 65)
	 * @param string $link_query_string Query string appended to links
	 * @param bool $preserve_styles Whether to preserve any link rel=stylesheet and style elements
	 * @param bool $remove_ids Remove IDs from the HTML document?
	 * @param bool $remove_classes Remove classes from the HTML document?
	 * @param bool $remove_comments Remove comments from the HTML document?
	 * @return array Either a single strclass object containing the decoded JSON response, or a 3-element array containing result, html and plain parts if $fetchresult is set
	 */
	protected static function convert(	$html = '',
										$url = '',
										$fetchresult = true,
										$adaptor = 'hpricot',
										$base_url = '',
										$line_length = 65,
										$link_query_string = '',
										$preserve_styles = true,
										$remove_ids = false,
										$remove_classes = false,
										$remove_comments = true) {
		$params = array();
		if (!empty($html)) {
			$params['html'] = $html;
		} elseif (!empty($url)) {
			$params['url'] = $url;
		} else {
			throw new Exception('Must supply an html or url value');
		}
		if ($adaptor == 'hpricot' or $adaptor == 'nokigiri') {
			$params['adaptor'] = $adaptor;
		}
		if (!empty($base_url)) {
			$params['base_url'] = $base_url;
		}
		$params['line_length'] = (integer)$line_length;
		if (!empty($link_query_string)) {
			$params['link_query_string'] = $link_query_string;
		}
		$params['preserve_styles'] = ($preserve_styles?'true':'false');
		$params['remove_ids'] = ($remove_ids?'true':'false');
		$params['$remove_classes'] = ($remove_classes?'true':'false');
		$params['$remove_comments'] = ($remove_comments?'true':'false');
		$options = array(
			'timeout' => 15,
			'connecttimeout' => 15,
			'useragent' => 'PHP Premailer',
			'ssl' => array('verifypeer' => false, 'verifyhost' => false)
		);
	//	$h = new HttpRequest(self::ENDPOINT, HttpRequest::METH_POST, $options);
		
	
		$conf = array(
				'url'	=> self::ENDPOINT,
				'timeout' => 15,
				'useragent' => 'PHP Premailer',
				'ssl_verifyhost'	=> 0,
				'SSL_VERIFYPEER'	=> 0,
				'post'		=> 1,
				'postfields' => $params,
				'returntransfer' => true,
				'httpheader' => array("Expect:")
			);
		
		foreach($conf as $key => $value){
			$name = constant('CURLOPT_'.strtoupper($key));
			$val  = $value;
			$data_conf[$name] = $val;
		}
		$cu = curl_init();
		curl_setopt_array($cu, $data_conf);
		$exec = curl_exec($cu);	
		$_res			= json_decode($exec);
		$_res_info 	= json_decode(json_encode(curl_getinfo($cu))); 	
		curl_close($cu);
		if($_res_info->http_code != 201){
			$code = $_res_info->http_code;
			switch ($code) {
				case 400:
					throw new Exception('Content missing', 400);
					break;
				case 403:
					throw new Exception('Access forbidden', 403);
					break;
				case 500:
				default:
					throw new Exception('Error', $code);
			}
			
		}
		$return = array('result' => $_res);
		if ($fetchresult) {
			$html = curl_init();
			curl_setopt_array(
					$html, array(
						CURLOPT_URL 			=> $_res->documents->html,
						CURLOPT_TIMEOUT 		=> 15,
						CURLOPT_USERAGENT 		=> 'PHP Premailer',
						CURLOPT_SSL_VERIFYHOST	=> 0,
						CURLOPT_SSL_VERIFYPEER	=> 0,
						CURLOPT_HTTPHEADER 		=> array("Expect:"),
						CURLOPT_RETURNTRANSFER 	=> true
					)
				);
			$return['html'] = curl_exec($html);
			curl_close($html);
			
			$plain = curl_init();
			curl_setopt_array(
					$plain, array(
						CURLOPT_URL 			=> $_res->documents->txt,
						CURLOPT_TIMEOUT 		=> 15,
						CURLOPT_USERAGENT 		=> 'PHP Premailer',
						CURLOPT_SSL_VERIFYHOST	=> 0,
						CURLOPT_SSL_VERIFYPEER	=> 0,
						CURLOPT_HTTPHEADER 		=> array("Expect:"),
						CURLOPT_RETURNTRANSFER 	=> true
					)
				);
			$return['plain'] = curl_exec($plain);
			curl_close($plain);
		
			return $return;
		}
		return $result;
		
	}
 
	/**
	 * Central static method for submitting either an HTML string or a URL, optionally retrieving converted versions
	 * @static
	 * @throws Exception
	 * @param string $html Raw HTML source
	 * @param bool $fetchresult Whether to also fetch the converted output
	 * @param string $adaptor Which document handler to use (hpricot (default) or nokigiri)
	 * @param string $base_url Base URL for converting relative links
	 * @param int $line_length Length of lines in the plain text version (default 65)
	 * @param string $link_query_string Query string appended to links
	 * @param bool $preserve_styles Whether to preserve any link rel=stylesheet and style elements
	 * @param bool $remove_ids Remove IDs from the HTML document?
	 * @param bool $remove_classes Remove classes from the HTML document?
	 * @param bool $remove_comments Remove comments from the HTML document?
	 * @return array Either a single element array containing the 'result' object, or three elements containing result, html and plain if $fetchresult is set
	 */
	public static function html($html, $fetchresult = true, $adaptor = 'hpricot', $base_url = '', $line_length = 65, $link_query_string = '', $preserve_styles = true, $remove_ids = false, $remove_classes = false, $remove_comments = false) {
		return self::convert($html, '', $fetchresult, $adaptor, $base_url, $line_length, $link_query_string, $preserve_styles, $remove_ids, $remove_classes, $remove_comments);
	}
 
	/**
	 * Central static method for submitting either an HTML string or a URL, optionally retrieving converted versions
	 * @static
	 * @throws Exception
	 * @param string $url URL of the source file
	 * @param bool $fetchresult Whether to also fetch the converted output
	 * @param string $adaptor Which document handler to use (hpricot (default) or nokigiri)
	 * @param string $base_url Base URL for converting relative links
	 * @param int $line_length Length of lines in the plain text version (default 65)
	 * @param string $link_query_string Query string appended to links
	 * @param bool $preserve_styles Whether to preserve any link rel=stylesheet and style elements
	 * @param bool $remove_ids Remove IDs from the HTML document?
	 * @param bool $remove_classes Remove classes from the HTML document?
	 * @param bool $remove_comments Remove comments from the HTML document?
	 * @return array Either a single element array containing the 'result' object, or three elements containing result, html and plain if $fetchresult is set
	 */
	public static function url($url, $fetchresult = true, $adaptor = 'hpricot', $base_url = '', $line_length = 65, $link_query_string = '', $preserve_styles = true, $remove_ids = false, $remove_classes = false, $remove_comments = false) {
		return self::convert('', $url, $fetchresult, $adaptor, $base_url, $line_length, $link_query_string, $preserve_styles, $remove_ids, $remove_classes, $remove_comments);
	}
}