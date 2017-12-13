<?php
	/********************************************************
	Fill Out pdf form with posted data and download that pdf
	********************************************************/
	if ( !defined( 'FPDM_PATH' ) ) {                
	    define( 'FPDM_PATH', dirname(__FILE__).'/' );
	}
	if ( !defined( 'FPDM_FILE_PATH' ) ) {                
	    define('FPDM_FILE_PATH', dirname(__FILE__).'/uploads/fpdf/');
	}
	if ( !defined( 'PDF_FILE_PATH' ) ) {                
	    define('PDF_FILE_PATH', dirname(__FILE__).'/uploads/docs/');
	}

	require(FPDM_PATH. 'createpdf.php');

	// this will mention like we can pass dynamic template file name of pdf to fill up data
/*	if (empty( $_POST) ) {
		return false;
	}
	$formdata = $_POST;*/	
	$formdata = array('form_slug' => 'termination-agreement', 
					'date_original_agreement' => '10',
					'year_original_agreement' => '16',
					'subject_original_agreement' => 'Termination',
					'date_signing' => '25',
					'month_signing' => 'OCT',
					'party_name_sec' => 'Deo',
					'party_name_first'	=> 'John'); 

	//random num generated for file name
	$current = 3;//rand(1,10); 
	$formdata['file_name'] = $current.'-'. $formdata['form_slug']. '.pdf';

	// Generate PDF
 	generate_and_download_pdf($formdata);

 	// Check filepath of pdf file exists or not
	$download_url = (file_exists(PDF_FILE_PATH))? PDF_FILE_PATH. $formdata['file_name'] : '';
	if(!file_exists($download_url)){
		return false;
	}
	$url = "http://".$_SERVER['HTTP_HOST']."/Github/fpdm/uploads/docs/".$formdata['file_name'];
	
	echo '<script type="text/javascript">
	           window.location = "'.$url.'"
	      </script>';
	//exit;
?>