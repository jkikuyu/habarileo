<?php
class class_exports{
	public function extract_textfile($spot_select_user, $select_user, $MYSQL){
			require "lang/en.php";
		if($MYSQL->count_results($spot_select_user) > 0){
		foreach($select_user AS $result_row){

			$Fullname = str_pad($result_row["Fullname"], 40, " ", STR_PAD_RIGHT);
			$Username = str_pad($result_row["Username"], 7, " ", STR_PAD_RIGHT);
			$Emailaddress = str_pad($result_row["Emailaddress"], 40, " ", STR_PAD_RIGHT);
			$Lastaccess = str_pad(date("jS F Y H:i:s", strtotime($result_row["Lastaccess"])), 25, " ", STR_PAD_RIGHT);

				$user_data = $Username.$Fullname.$Emailaddress.$Lastaccess;

				date_default_timezone_set($lang["timezone"]);
				$static_local_date = date("H_i_s", time());

				$datafile = fopen("textfiles/".$_SESSION["table_name"]."$static_local_date.txt", "a") or die("Unable to open file!");

				$txtdata = $user_data."\n";
				fwrite($datafile, $txtdata);
			}
		fclose($datafile);
		}
		header("Location: textfiles/".$_SESSION["table_name"]."$static_local_date.txt");
	}
	public function extract_excel($spot_select_user, $select_user, $MYSQL){
		require "lang/en.php";
	$header = '';
	$data = '';
	$fetch_field = $MYSQL->fetch_field($spot_select_user);
	 /* Get field information for all fields */
	foreach($fetch_field AS $finfo){
		$header .= $finfo->name . "\t";
	}
	foreach($select_user AS $row ){
		$line = '';
			foreach( $row as $value ){            
				if ( ( !isset( $value ) ) || ( $value == "" ) ){
					$value = "\t";
				}else{
					$value = str_replace( '"' , '""' , $value );
					$value = '"' . $value . '"' . "\t";
				}
				$line .= $value;
			}
		$data .= trim( $line ) . "\n";
	}
	$data = str_replace( "\r" , "" , $data );
	if ( $data == "" ){
		$data = "\nNo Record(s) Found!\n";
	}
	date_default_timezone_set($lang["timezone"]);
	$static_local_date = date("H_i_s", time());
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$_SESSION["table_name"]."$static_local_date.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$data";
	}
	public function extract_pdf($select_user, $MYSQL){

// Include the main TCPDF library (search for installation path).

require_once('tcpdf/tcpdf.php');
require "lang/en.php";

//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('BBIT3104');
$pdf->SetTitle($lang["table_title"]);
$pdf->SetSubject('BBIT3104');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'BBIT3104 2017 ', 'Strathmore FIT');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, $lang["table_title"], PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, $lang["table_title"], PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->Write(0, $lang["table_title"], '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);
$tbl = '';
$tbl .= '
<table border = "1" align = "center" style = "width: 80%; border-collapse: collapse; border: 1px solid #373737;">
		<tr>
			<td width = "70px"><span style = "font-weight: bold; color: #dd0000;">' . ucwords($lang["username"]) . '</span></td>
			<td width = "200px"><span style = "font-weight: bold;">' . ucwords($lang["fullname"]) . '</span></td>
			<td width = "200px"><span style = "font-weight: bold;">' . ucwords($lang["fullname"]) . '</span></td>
			<td width = "150px"><span style = "font-weight: bold;">' . ucwords($lang["lastaccess"]) . '</span></td>
		</tr>
';

	foreach($select_user AS $result_row){
$tbl .= '
		<tr>
			<td>' . $result_row["Username"] . '</td>
			<td>' . $result_row["Fullname"] . '</td>
			<td>' . $result_row["Emailaddress"] . '</td>
			<td>' . date("jS F Y H:i:s", strtotime($result_row["Lastaccess"])) . '</td>
		</tr>
';
	}
$tbl .= '
		<tr>
			<td width = "70px">' . ucwords($lang["username"]) . '</td>
			<td width = "200px">' . ucwords($lang["fullname"]) . '</td>
			<td width = "200px">' . ucwords($lang["fullname"]) . '</td>
			<td width = "150px">' . ucwords($lang["lastaccess"]) . '</td>
		</tr>
</table>
';
$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($lang["table_title"] . '_' . date("Y") . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}
}
?>