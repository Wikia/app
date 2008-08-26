<?php

$wgExtensionFunctions[] = 'wfSpecialAddEvent';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'AddEvent',
	'description' => 'easily add events to the calendar (see the New Calendar parser extension).'
);

function wfSpecialAddEvent() {
	SpecialPage::addPage( new AddEvent() );
}

class AddEvent extends SpecialPage {
	const specialPageName = 'AddEvent';
	
	protected static $messages = array(
		'av_invalid_request' => "There are required variables missing from the request. Your script is broken.",
		'av_title_exists' => 'There is already an article with that title. Try another.',
		'av_page_title' => 'Add an Event',
		'av_date_field_label' => 'Date (yyyy/mm/dd):',
		'av_title_field_label' => 'Title:',
		'av_description_field_label' => 'Description (wikitext):',
		'av_add_button_label' => 'Add',
		'av_invalid_date' => 'Remember to enter a DATE in year/month/day format.',
		'av_no_title' => 'Remember to enter a TITLE.',
		'av_help' => '
		If you want to make an existing page into an event, edit it and add the
		following to the end, substituting the correct date for "YYYY/MM/DD":
		<pre id="upload_form_category_example">
[[Category:$1|YYYY/MM/DD]]
		</pre>
		To rename an event, go to its article and use the \'Move\' tab. To delete
		an event, either delete the article itself, or remove it from
		the \'$1\' category. You must be logged in to do these things.',
		
		);

	var $title;

	var $cameFrom;
	var $dateCategory;
	var $calendarCategory;
	var $description;
	var $eventTitle;
	var $errorMessage;
	
	function __construct() {
		global $wgMessageCache;
		SpecialPage::SpecialPage(self::specialPageName, '', false);
		$this->title = Title::makeTitle(NS_SPECIAL, self::specialPageName);
		$wgMessageCache->addMessages(self::$messages);
	}
	
	function execute() {
		global $wgRequest;
		
		// Before we can even check permissions, we need to know what
		// page the calendar is on.
		$cameFromText = $wgRequest->getText( 'came_from', false );
		if( $cameFromText ) {
			$this->cameFrom = Title::newFromURL( $cameFromText );
		} else {
			$this->invalidRequest();
			return;
		}
		
		// userHasPermission shows the correct error page as a side-effect.
		if ( $this->userHasPermission() ) {
			$this->slurpFromRequest();
			if( $wgRequest->wasPosted() ) {
				$this->saveEvent();
			} else {
				$this->showForm();
			}
		}
	}

	function invalidRequest() {
		global $wgOut;
		$wgOut->addHTML(wfMsg('av_invalid_request'));
	}

	function slurpFromRequest($request = null) {
		if (!$request) {
			global $wgRequest;
			$request = $wgRequest;
		}
		$this->dateCategory     = $request->getText("monolithic_date");
		$this->calendarCategory = $request->getText("category");
		$this->description      = $request->getText("description");
		$tmp = $request->getText("event_title", null);
		$this->eventTitle = $tmp? Title::newFromText($tmp) : null;
		
		$tmp = $request->getText("error_message", false);
		$this->errorMessage = $tmp? wfMsg($tmp) : null;
	}
	
	protected function redirectToForm($error_message) {
		// TODO, store these in an array so we can grab them all at once?
		$title_text = $this->eventTitle ?
		              $this->eventTitle->getPartialURL() : "";
		$query = "came_from={$this->cameFrom->getPrefixedURL()}" .
		         "&error_message=$error_message" . 
		         "&description={$this->description}" .
		         "&category={$this->calendarCategory}" .
		         "&monolithic_date={$this->dateCategory}" .
		         "&event_title=$title_text";
		$t = Title::makeTitle(NS_SPECIAL, self::specialPageName);
		$this->redirect( $t, $query );
	}
	
	protected function redirect($title, $query="") {
	    global $wgRequest, $wgOut;
	    $wgOut->setSquidMaxage( 1200 ); // XXX what does this mean?
	    $wgOut->redirect($title->getFullURL( $query ), '301');
	}
	
	protected function isValidDateCategory($str) {
		// TDOO check if month and day are in range.
		return preg_match('/\d{4}\/\d{2}\/\d{2}/', $str);
	}
	
	function saveEvent() {
		if( ! $this->eventTitle ) {
			$this->redirectToForm( 'av_no_title' );
			return;
		}
		if( $this->eventTitle->exists() ) {
			$this->redirectToForm( 'av_title_exists' );
			return;
		}
		if( ! $this->isValidDateCategory($this->dateCategory) ) {
			$this->redirectToForm( 'av_invalid_date' );
			return;
		}
		if( $this->calendarCategory == '' ) {
			$this->invalidRequset();
			return;
		}
		
		$text = <<<END
{$this->description}

[[Category:{$this->calendarCategory}|{$this->dateCategory}]]
END;
		$summary="Created new event on calendar\"{$this->calendarCategory}\".";

		$a = new Article( $this->eventTitle );
		$status = $a->doEdit( $text, $summary, EDIT_NEW );
		
		$this->redirect( $this->cameFrom );
	}
	
	function userHasPermission() {
		global $wgOut, $wgUser;
		
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}
		if( ! $wgUser->isAllowed('createpage') ) {
			$wgOut->permissionRequired( 'createpage' );
			return false;
		}
		// TODO check if the user can edit the came_from page;
		// this would require cryptography. Also if came_from is protected,
		// an attacker could find an unprotected page, add a calendar, and 
		// modify that. Etc.
		
		return true;
	}
	
	function showForm() {
		global $wgScript, $wgOut, $wgStylePath;
		
		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\"
			href=\"{$wgStylePath}/common/calendar_extension.css\" />\n" );
			
		$wgOut->setPageTitle( wfMsg('av_page_title') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		
		if( $this->errorMessage ) {
			$error_html = "<div id=\"add_event_form_error\">{$this->errorMessage}</div>";
		} else {
			$error_html = "";
		}
		
		$action = $this->title->getFullURL();
		$titletext = $this->eventTitle ? $this->eventTitle->getPrefixedText()
		                               : "";
		
		/* if you can think of a non-pathological way to do this, please share.
		   time to form a lynch mob against the php people. */
		$msg_date = wfMsg('av_date_field_label');
		$msg_title = wfMsg('av_title_field_label');
		$msg_description = wfMsg('av_description_field_label');
		$msg_add_button = wfMsg('av_add_button_label');
		$msg_help = wfMsg('av_help', $this->calendarCategory);
	
		$createform=<<<ENDFORM
$error_html
<form id="add_event_form" name="add_event_form" action="$action" method="post">

<input type="hidden" name="came_from"
       value="{$this->cameFrom->getPrefixedURL()}">
<input type="hidden" name="category" value="{$this->calendarCategory}">

<label for="monolithic_date">$msg_date</label><br />
<input name="monolithic_date" id="monolithic_date"
       value="{$this->dateCategory}" /><br />
<p class="help_text">(To change the date later, go to the event page, click the 'edit' tab, and you'll find the date at the bottom of the page.)</p>

<label for="event_title">$msg_title</label><br />
<input name="event_title" id="event_title"
       value="$titletext"/><br />
<p class="help_text">(To change the title later, please login and use the 'move' tab at the top of the page.)</p>

<label style="clear: both;" for="description">$msg_description</label><br />
<textarea name="description" rows="20" >{$this->description}</textarea><br />

<input type='submit' name="create" id="submit" value="$msg_add_button" />

</form>
<hr />
<p id="upload_form_help">
$msg_help
</p>
ENDFORM;

		$wgOut->addHTML($createform);
		
	}
}

?>
