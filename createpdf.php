<?php

/***************************
Download and generate pdf
****************************/
/*if ( !defined( 'FPDM_PATH' ) ) {                
    define( 'FPDM_PATH', dirname(__FILE__).'/fpdm/' );
}
if ( !defined( 'FPDM_FILE_PATH' ) ) {                
    define('FPDM_FILE_PATH', dirname(__FILE__).'/uploads/fpdf/');
}
if ( !defined( 'PDF_FILE_PATH' ) ) {                
    define('PDF_FILE_PATH', dirname(__FILE__).'/uploads/docs/');
}*/

require(FPDM_PATH. 'fpdm.php');

// parse pdf fields
function parsePDFFields($file){
	if(!$file){return false;}

	$txt_file    = file_get_contents($file);
	$rows        = explode("\n", $txt_file);
	array_shift($rows);

	$jsonArr = array();
	foreach($rows as $row => $data)
	{
	    //get row data
	    $row_data = explode(':', $data);

	    if(!strcmp($row_data[0], 'FieldName')){ 	

	    	array_push($jsonArr, trim($row_data[1]));
	    }
	}
	return (!empty($jsonArr)? $jsonArr : false);
}
// mapping with pdf fields and 
function mappingFieldValues($pdf_f, $form_f){
	if(empty($pdf_f) || empty($form_f)){
		return false;
	}
	$arrFinal = array();

	foreach ($pdf_f as $key1 => $fpdf) {
		//$int = intval(preg_replace('/[^0-9]+/', '', $fpdf), 10);
		preg_match_all('!\d+!', $fpdf, $matches);
		$int = implode(' ', $matches[0]);
		
		if(!$int){
			$pdf_key = $fpdf;
		}else{
			$pdf_key = trim($fpdf, $int);
		}		

		foreach ($form_f as $key2 => $form) {
			if(!strcmp($pdf_key, $key2)){ 		// compare the fields of both pdf & form fields
				$arrFinal[$fpdf] = $form; 
		    }
		}		
	}
	
	return (!empty($arrFinal)? $arrFinal : false);
}

function generate_and_download_pdf($fields){

	if(empty($fields)){return false;}
	
	/*********** Fetch PDF Fields ***************/
	$parseTxt = FPDM_FILE_PATH. $fields['form_slug']. '.txt';

	if (!file_exists($parseTxt)) { // for pdf file fields
	    return false;
	} 
	$pdfFields = parsePDFFields($parseTxt);
	
	/*********** Mapping form fields ***************/
	$fieldValues = mappingFieldValues($pdfFields, $fields);

	/*********** Fill UP & Generate PDF ***************/
	$templateUrl = FPDM_FILE_PATH. $fields['form_slug']. '.pdf';
	$download = PDF_FILE_PATH. $fields['file_name'];

	if (!file_exists($templateUrl)) { // for template file fields
	    return false;
	}

	$pdf = new FPDM($templateUrl);  
	$pdf->Load($fieldValues, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
	$pdf->Merge();	
	$pdf->Output('F', $download);

	//exit;
}
?>