<?php
/**
 * MediaWiki page data importer
 * Copyright (C) 2003,2005 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
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
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup SpecialPage
 */

class SpecialAdBulkUpload extends UnlistedSpecialPage {
	
	private $uploadedfile;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'AdBulkUpload');
		global $wgImportTargetNamespace;
		$this->namespace = $wgImportTargetNamespace;
	}
	
	/**
	 * Execute
	 */
	function execute( $par ) {
		global $wgRequest;
		
		$this->setHeaders();
		$this->outputHeader();
		
		if ( wfReadOnly() ) {
			global $wgOut;
			$wgOut->readOnlyPage();
			return;
		}
		
		if ( $wgRequest->wasPosted() && $wgRequest->getVal( 'action' ) == 'submit' ) {
			$this->doImport();
		}
		$this->showForm();
	}
	
	/**
	 * Do the actual import
	 */
	private function doImport() {
		global $wgOut;
		$result = $this->GetUploadeFile();
		if($result !== true){
			$wgOut->addHTML(print_r($result));
		}else{
			$wgOut->addHTML($this->uploadedfile);
		}
		$iserr=false;//error flag
		if(count($this->uploadedfile)>0){
			$ad = new Advertisement();
			//Import file format: TSV file with headers - headers map to advertisement fields
			//ad_id	wiki_db	page_id	page_original_url ad_link_url	ad_link_text	ad_text	ad_price	ad_months	user_email	ad_status last_pay_date
			
			$headers = explode("\t",$this->uploadedfile[0]);

			foreach($headers as $fname){
				if(!array_key_exists(trim($fname),$ad)){
					$wgOut->addHTML("<p>unrecognized field:".$fname."</p>\n");
					$iserr="File not correctly formatted";
				}
			}
		}else{
			$iserr="File not correctly formatted";
		}
		if($iserr === false){
			//process input file
			//remove headers
			unset($this->uploadedfile[0]);
			foreach($this->uploadedfile as $row){
				$entry = explode("\t",$row);
				if(count($entry)>0){
					$ad = new Advertisement();
					foreach($entry as $colnum=>$val){
						$fname = trim( $headers[$colnum] );
						if(is_numeric($val)) $val=$val+0;
						$ad->$fname = $val;
					}
					//remove this for now, so bulk upload will work on central wiki
					//(validate verifies the page_id)
					//$check = $ad->validate();
					$check = true; //temporary
					if($check === true){
						$ad->Save();
						$wgOut->addHTML("<p>Added: ".print_r($ad,1)."</p>\n");
					}else{
						$wgOut->addHTML( "<p><b>Not added, invalid data in row: </b> ".$row."<br />".print_r($check,1)."</p>\n");
					}
				}else{
					$wgOut->addHTML( "<p><b>Not added, bad row: </b> ".$row."</p>\n");
				}
			}
		}else{
			//show error info
		}
	}

	private function showForm() {
		global $wgUser, $wgOut, $wgRequest, $wgTitle, $wgImportSources, $wgExportMaxLinkDepth;

		$action = $wgTitle->getLocalUrl( 'action=submit' );

			$wgOut->addHTML("<p>Upload a file with headers that map to the database field names, ie <br />wiki_db	page_id	ad_link_url	ad_link_text	ad_text	ad_price	ad_months	user_email	ad_status	last_pay_date</p>".
				Xml::openElement( 'form', array( 'enctype' => 'multipart/form-data', 'method' => 'post',
					'action' => $action, 'id' => 'mw-import-upload-form' ) ) .
				Xml::hidden( 'action', 'submit' ) .
				Xml::hidden( 'source', 'upload' ) .
				Xml::openElement( 'table', array( 'id' => 'mw-import-table' ) ) .

				"<tr>
					<td class='mw-label'>" .
						Xml::label( wfMsg( 'import-upload-filename' ), 'xmlimport' ) .
					"</td>
					<td class='mw-input'>" .
						Xml::input( 'xmlimport', 50, '', array( 'type' => 'file' ) ) . ' ' .
					"</td>
				</tr>
				<tr>
					<td></td>
					<td class='mw-submit'>" .
						Xml::submitButton( wfMsg( 'uploadbtn' ) ) .
					"</td>
				</tr>" .
				Xml::closeElement( 'table' ).
				Xml::hidden( 'editToken', $wgUser->editToken() ) .
				Xml::closeElement( 'form' )
			);
	}
	
		private function GetUploadeFile( $fieldname = "xmlimport" ) {
			$upload =& $_FILES[$fieldname];

			if( !isset( $upload ) || !$upload['name'] ) {
				return new WikiErrorMsg( 'importnofile' );
			}
			if( !empty( $upload['error'] ) ) {
				switch($upload['error']){
					case 1: # The uploaded file exceeds the upload_max_filesize directive in php.ini.
						return new WikiErrorMsg( 'importuploaderrorsize' );
					case 2: # The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.
						return new WikiErrorMsg( 'importuploaderrorsize' );
					case 3: # The uploaded file was only partially uploaded
						return new WikiErrorMsg( 'importuploaderrorpartial' );
						case 6: #Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.
							return new WikiErrorMsg( 'importuploaderrortemp' );
						# case else: # Currently impossible
				}
			}
			$fname = $upload['tmp_name'];
			if( is_uploaded_file( $fname ) ) {
				$file = @file( $fname);
				if( !$file ) {
					return new WikiErrorMsg( "importcantopen" );
				}else{
					$this->uploadedfile = $file;
					return true;
				}
			} else {
				return new WikiErrorMsg( 'importnofile' );
			}
		}
	
	
}
