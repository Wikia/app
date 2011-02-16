<?php
////
// Author: Sean Colombo
// Date: 20080331
//
// Special page for demo-ing longtail video uploading and embedding.
////

class VideoUploadPrototype extends SpecialPage
{
	function VideoUploadPrototype(){
		//wfLoadExtensionMessages('VideoUploadPrototype');
		SpecialPage::SpecialPage("VideoUploadPrototype");
	}

	function execute($par){
		$this->setHeaders();	// this is required for 1.7.1 to work
		global $wgRequest, $wgOut;

		$wgOut->setPageTitle("Video Upload Prototype");
	
		$vidUploadAction = $wgRequest->getVal('vidUploadAction');
		switch($vidUploadAction){
			case "longtailStep1":
				$this->showForm_longtail_step2();
				break;
			default:
				//$this->showForm_brightcove();
				//$wgOut->addHTML("<br/><br/><br/>");
				$this->showForm_longtail();
				$this->showVideo_longtail();
				break;
		}
	}
	
	// Embed one of our previously-uploaded videos.
	function showVideo_longtail(){
		global $wgOut;
		wfProfileIn( __METHOD__ );
		
		$wgOut->addHTML("<h1>Playback of an already-uploaded video</h1>");
		$wgOut->addWikitext("<longtail vid='8YVNhJJj'/>");

		wfProfileOut( __METHOD__ );
	}
	
	// Upload form for using Brightcove API.
	function showForm_brightcove(){
		global $wgOut;
		wfProfileIn( __METHOD__ );
	
		$wgOut->addHTML("<h1>Brightcove Upload Form</h1>");
		
		$wgOut->addHTML("Can brightcove do uploads via API?  I don't see how from the docs.");
		// TODO: IMPLEMENT
		// TODO: IMPLEMENT
	
		wfProfileOut( __METHOD__ );
	} // end showForm_brightcove()

	// Upload form for using Longtail Video API.
	function showForm_longtail(){
		global $wgOut;
		wfProfileIn( __METHOD__ );

		$wgOut->addHTML("<h1>Longtail Video Upload Form</h1>");
		
		$wgOut->addHTML("<form method='post' action=''>
			<input type='hidden' name='vidUploadAction' value='longtailStep1'/>
			Title: <input type='text' name='videoTitle' value='What Do You Love?'/><br/>
			Tags: <input type='text' name='tags' value='test,wikia,cool,love'/><br/>
			Description:<br/>
			<textarea name='description'>Wikia staff telling you what they love!  What do you love? What would you do if we gave you $300 to do what you love?</textarea><br/>
			<input type='submit' name='submit' value='Go to upload panel...'/>
		</form>");
	
		wfProfileOut( __METHOD__ );
	} // end showForm_longtail()
	
	function showForm_longtail_step2(){
		global $wgRequest, $wgOut;
		wfProfileIn( __METHOD__ );

		$title = $wgRequest->getVal('videoTitle', "What Do You Love?");
		$tags = $wgRequest->getVal('tags', "test,wikia,cool,love");
		$description = $wgRequest->getVal('description', "Wikia staff telling you what they love!  What do you love? What would you do if we gave you $300 to do what you love?");

		$wgOut->addHTML("<h1>Upload file for \"$title\" using Longtail Video</h1>");
		
		$longtail = new LongtailVideoClient();
		$result = $longtail->videos_create($title, $tags, $description);

		$postUrl = $result["link"]["protocol"] . "://" . $result["link"]["address"] . $result["link"]["path"];
		$postUrl .= "?api_format=php";
		$postUrl .= "&key=" . $result["link"]["query"]["key"];
		$postUrl .= "&token=" . $result["link"]["query"]["token"];

		$wgOut->addHTML("<form method='post' action='$postUrl' enctype='multipart/form-data'>
							  <input type='file' name='file'/>
							  <button type='submit'>Upload</button>
						  </fieldset>
						</form>");

		wfProfileOut( __METHOD__ );
	} // end showForm_longtail_step2()

} // end class VideoUploadPrototype

?>
