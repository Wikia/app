<?php

class FlickrImport{
	
	private $flickr_api_key;

	var $credits_template = 'flickr'; // use this to format the image content with some key parameters

	var $results_per_page = 10;
	var $results_per_row = 5;
	
	// see the flickr api page for more information on these params
	// for licnese info http://www.flickr.com/services/api/flickr.photos.licenses.getInfo.html
	// default 4 is CC Attribution License
	var $flickr_license = "4,5";
	var $flickr_sort = "interestingness-desc";
	var $flickr_searchBy = "tags"; // Can be tags or text. See http://www.flickr.com/services/api/flickr.photos.search.html

	
	function __construct($api_key) {
		$this->flickr_api_key = $api_key;
	}
	
	public function getPhotos( $page=1, $q ){
		global $wgUser, $wgOut;
                global $wgHTTPProxy;
		
        	$f = new phpFlickr($this->flickr_api_key);
		 
		// TODO: get the right licenses

                $proxyArr = explode(':', $wgHTTPProxy);
                $f->setProxy($proxyArr[0], $proxyArr[1]);

        	$photos = $f->photos_search( array(
				"{$this->flickr_searchBy}"=>"$q", "tag_mode"=>"any", 
				"page" => $page, 
				"per_page" => $this->results_per_page+1, "license" => $this->flickr_license, 
				"sort" => $this->flickr_sort  ));
	
		if ($photos == null || !is_array($photos) || sizeof($photos) == 0 || !isset($photos['photo']) ) {
			$wgOut->addWikiMsg( "importfreeimages_nophotosfound", $q );
			return;
		}
	 
		$output = "<div id=\"flickr-images\" class=\"flickr-images\">";
		if( count($photos['photo']) == 0  ){
			$output .= wfMsgExt("importfreeimages_nophotosfound","parse", $q);
		}
		
		$x = 1;
        	foreach ($photos['photo'] as $photo) {
			if($x <= $this->results_per_page){
				$owner = $f->people_getInfo($photo['owner']);
				$image_tag = "<img src=\"http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_t.jpg\">";
				$image_url= "http://www.flickr.com/photos/" . $photo['owner'] . "/" . $photo['id'] . "/";
				$image_url_farm = "http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_t.jpg";
				
				$title = $photo['title'];
				if(strlen($title) > 15){
					$title = substr($photo['title'],0,15) . "...";
				}
				
				$exists = false;
				if( $title ){
					$image_title = Image::newFromName( $title );
					if( is_object( $image_title ) ){
						$exists = $image_title->exists();
					}
				}
				
				$real_count = ((count($photos['photo'])==($this->results_per_page+1))?$this->results_per_page:count($photos['photo']));
				
				$output .= "<div class=\"flickr-image-container".(($x==$real_count)?" no-border":"")."\">
					<div class=\"flickr-checkbox\">
							<input onclick=toggle_photo({$photo['id']},'{$image_url_farm}',this) onmouseup=toggle_photo({$photo['id']},'{$image_url_farm}',this) type=\"checkbox\" name=\"flickr_image_{$photo['id']}\"  value=\"{$photo['id']}\"  /> " . wfMsg('importfreeimages_importthis')  . "
						</div>
						<div class=\"flickr-image\">
							<a href=\"{$image_url}\">{$image_tag}</a>
						</div>
						<div class=\"flickr-image-info\">
							<p><b>" . wfMsg("importfreeimages_title") . "</b>: <b><input type=\"text\" name=\"title-{$photo['id']}\" id=\"title-{$photo['id']}\" onblur=update_title('{$photo['id']}',this.value) onchange=update_title('{$photo['id']}',this.value) size=\"25\" value=\"" . htmlspecialchars($title, ENT_QUOTES) . "\"></b> </p><p>" . (( $exists )? "<span style='color:red'>".wfMsg("importfreeimages_rename")."</span>":"" ) . "</p>
							<p>" . wfMsg('importfreeimages_owner').": <a href=\"http://www.flickr.com/people/" . $photo['owner'] . "/'\">{$owner['username']}</a></p>
						 </div>
						 <div class=\"cleared\"></div>
					</div>";
						
				 
				if($x==count($photos['photo']) || $x!=1 && $x%$this->results_per_row ==0) {
					$output .= "<div class=\"cleared\"></div>";
				}
			}
			$x++;
		}
		$output .= "</div>";
		
		$output .= "<div class=\"flickr-import-navigation\">";
		
		if($page!=1){
			$output .= "<a href=\"javascript:get_results_page(" . ($page-1) . ",'" . urlencode($q) . "')\">".wfMsgForContent( 'importfreeimages_previouspage')."</a>";
		}
			
		//We purposely sent $this->results_per_page+1 to the search via the API
		//If the results returned are greater than the results per page, we know there is a next page
		if( count($photos['photo']) > $this->results_per_page){
			$output .= "<a href=\"javascript:get_results_page(" . ($page+1) . ",'" . urlencode($q) . "')\">".wfMsgForContent( 'importfreeimages_nextpage')."</a>";
		
		}
		
		$output .= "</div>";
		
		return $output;
	}
	

	
	public function importPhoto( $id, $search_term, $title = "" ){
		global $wgOut, $wgTmpDirectory, $wgRequest, $wgUser;
                global $wgHTTPProxy;
		
		$f = new phpFlickr($this->flickr_api_key);
		$proxyArr = explode(':', $wgHTTPProxy);
                $f->setProxy($proxyArr[0], $proxyArr[1]);

                $photo = $f->photos_getInfo($id);
		$url = "http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_t.jpg";
		 
		//make sure its a valid flickr URL
		if (!preg_match('/^http:\/\/farm[0-9]+.static.flickr.com/', $url)) {
			$wgOut->errorpage('error', 'importfreeimages_invalidurl');           
		 	return;
		}

		$sizes = $f->photos_getSizes($id);
		$original = '';
		foreach ($sizes as $size) {
			if ($size['label'] == 'Original') {
				$original = $size['source'];
				$import = $size['source'];
			} else if ($size['label'] == 'Large') {
				$large = $size['source'];
			}
		}
		
		//somtimes Large is returned but no Original!
		if ($original == '' && $large != ''){
			$import = $large;
		}
		
		// store the contents of the file
		$pageContents = file_get_contents($import); 
		$tempname = tempnam( $wgTmpDirectory, "flickr-" . rand(0,999999) );
		$r = fopen( $tempname, 'wb' );
		if( $r === FALSE ) {
			# Could not open temporary file to write in
			$wgOut->errorPage( 'upload-file-error', 'upload-file-error-text' );
			return true;
		}
     
		$name = $tempname;
	 
		$r = fopen($name, "w");
	
		$size = fwrite ( $r, $pageContents);	
		fclose($r);
		chmod( $name, 0777 );
	
		$caption = "{{" . $this->credits_template . $photo['license'] . "|{$id}|" .  $photo['owner']['username'] . "|" . $photo['title']. "}}";
		$caption = trim($caption);
		
		// handle duplicate filenames
		$i = strrpos($import, "/");
		if ($i !== false) {
			$import = substr($import, $i + 1);
		}

		// pretty dumb way to make sure we're not overwriting previously uploaded images
		$c = 0;
		$nt =& Title::makeTitle( NS_IMAGE, $import);
		$fname = $import;
		while( $nt->getArticleID() && $c < 20) {
			$fname = $c . "_" . $import;
			$nt =& Title::makeTitle( NS_IMAGE, $fname);
			$c++;
		}
		$import = $fname;
		
		if(!$search_term)$search_term="flickr-import";
		
		$filename = $title;
		
		//$filename = urldecode("{$search_term}-" . time() . "-" . rand(0, 999) . ".jpg");
		//$filename = str_replace("?", "", $filename);
		//$filename = str_replace(":", "", $filename);
		//$filename = preg_replace('/ [ ]*/', ' ', $filename);
		
		//Set up Mediawiki upload class
		if (!class_exists("UploadForm")){
			require_once('includes/SpecialUpload.php');
		}
		$u = new UploadForm($wgRequest);
		
		$u->mSrcName = $filename;
		$u->mTempPath = $tempname;
		$u->mUploadTempName = $name;
		$u->mUploadSize     = $size; 
		$u->mUploadDescription = $caption;
		$u->mRemoveTempFile = true;
		$u->mUpload =  true;
		$u->mIgnoreWarning =  true;
		$u->mOname = $filename;
		 
		$t = Title::newFromText($filename, NS_IMAGE);
		if ($t->getArticleID() > 0) {
			$sk = $wgUser->getSkin();
			$dlink = $sk->makeKnownLinkObj( $t );
			$warning .= '<li>'.wfMsgHtml( 'fileexists', $dlink ).'</li>';
			
			// use our own upload warning as we dont have a 'reupload' feature
			wfIIF_uploadWarning($u);
			return;
		}else {
			$this->uploadImage(&$u);
		}
		
		return $u->mDestName;

	}
	
	//Had to re-do the upload process ($upload->ProcessUpload()) otherwise $upload->ShowSuccess was going to be called
	//also removed some unncessary things, like checking the file extension etc
	function uploadImage($u){
		global $wgOut, $wgOut, $wgUploadDirectory;
		
		/** Check if the image directory is writeable, this is a common mistake */
		if( !is_writeable( $wgUploadDirectory ) ) {
			$wgOut->addWikiMsg( 'upload_directory_read_only', $wgUploadDirectory );
			return;
		}
		
		if( !wfRunHooks( 'UploadForm:BeforeProcessing', array( $u ) ) ) {
			wfDebug( "Hook 'UploadForm:BeforeProcessing' broke processing the file." );
			return false;
		}
		
		
		$basename = wfBaseName( $u->mOname );
		
		/**
		 * Filter out illegal characters, and try to make a legible name
		 * out of it. We'll strip some silently that Title would die on.
		 */
		$filtered = preg_replace ( "/[^".Title::legalChars()."]|:/", '-', $basename );
		$nt = Title::newFromText( $filtered );
		if( is_null( $nt ) ) {
			$u->uploadError( wfMsgWikiHtml( 'illegalfilename', htmlspecialchars( $filtered ) ) );
			return;
		}
		$nt =& Title::makeTitle( NS_IMAGE, $nt->getDBkey() );
		
		//$u->mDestName = $nt->getDBkey();
		
		$u->mLocalFile = wfLocalFile( $nt );
		$u->mDestName = $u->mLocalFile->getName();
		
		/**
		 * Try actually saving the thing...
		 * It will show an error form on failure.
		 */
		$status = $u->mLocalFile->upload( $u->mTempPath, $u->mComment, $pageText,
			File::DELETE_SOURCE, $u->mFileProps );
			
		
		if ( $status->isGood() ) {
			wfRunHooks( 'UploadComplete', array( &$img ) );
		} else {
			// Image::recordUpload() fails if the image went missing, which is
			// unlikely, hence the lack of a specialised message
			$wgOut->showFileNotFoundError( $u->mDestName );
		}
		
		$u->cleanupTempFile();
		 
	}
}
?>
