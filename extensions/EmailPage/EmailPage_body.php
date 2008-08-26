<?php
if (!defined('MEDIAWIKI')) die();

class SpecialEmailPage extends SpecialPage {

	var $recipients = array();
	var $title;
	var $subject;
	var $header;
	var $cat;
	var $group;
	var $list;
	var $textonly;
	var $css;

	public function __construct() {
		global $wgEmailPageGroup;
		SpecialPage::SpecialPage('EmailPages', $wgEmailPageGroup);
	}

	/**
	 * Override SpecialPage::execute($param = '')
	 */
	function execute($param) {
		global $wgOut, $wgUser, $wgEmailPageContactsCat, $wgGroupPermissions, $wgSitename, $wgEmailPageCss, $wgEmailPageAllowAllUsers;
		$db =& wfGetDB(DB_SLAVE);
		$param = str_replace('_', ' ', $param);

		wfLoadExtensionMessages( 'EmailPage' );

		$this->setHeaders();

		# Get info from request or set to defaults
		$this->title    = isset($_REQUEST['ea-title'])    ? $_REQUEST['ea-title']    : $param;
		$this->subject  = isset($_REQUEST['ea-subject'])  ? $_REQUEST['ea-subject']  : '' . wfMsg('ea-pagesend', $this->title, $wgSitename );
		$this->header   = isset($_REQUEST['ea-header'])   ? $_REQUEST['ea-header']   : '';
		$this->cat      = isset($_REQUEST['ea-cat'])      ? $_REQUEST['ea-cat']      : '';
		$this->group    = isset($_REQUEST['ea-group'])    ? $_REQUEST['ea-group']    : '';
		$this->list     = isset($_REQUEST['ea-list'])     ? $_REQUEST['ea-list']     : '';
		$this->textonly = isset($_REQUEST['ea-textonly']) ? $_REQUEST['ea-textonly'] : false;
		$this->css      = isset($_REQUEST['ea-css'])      ? $_REQUEST['ea-css']      : $wgEmailPageCss;

		# Bail if no page title to send has been specified
		if ($this->title) $wgOut->addWikiText(wfMsg('ea-heading', $this->title));
		else return $wgOut->addWikiText(wfMsg('ea-nopage'));

		# If the send button was clicked, attempt to send and exit
		if (isset($_REQUEST['ea-send'])) return $this->send();

		# Render form
		$special = Title::makeTitle(NS_SPECIAL, 'EmailPage');
		$wgOut->addHTML(wfElement('form',array(
			'class'  => 'EmailPage',
			'action' => $special->getLocalURL('action=submit'),
			'method' => 'POST'
			),null));
		$wgOut->addHTML('<fieldset><legend>'.wfMsg('ea-selectrecipients').'</legend>');
		$wgOut->addHTML('<table style="padding:0;margin:0;border:none;">');

		# If $wgEmailPageContactsCat is set, create a select list of all categories
		if ($wgEmailPageContactsCat) {
			$cats = '';
			$result = $db->select(
				'categorylinks',
				'cl_from',
				'cl_to = '.$db->addQuotes($wgEmailPageContactsCat),
				__METHOD__,
				array('ORDER BY' => 'cl_sortkey')
			);
			if ($result instanceof ResultWrapper) $result = $result->result;
			if ($result) while ($row = $db->fetchRow($result)) {
				$t = Title::newFromID($row[0]);
				if ($t->getNamespace() == NS_CATEGORY) {
					$cat = $t->getText();
					$selected = $cat == $this->cat ? ' selected' : '';
					$cats .= "<option$selected>$cat</option>";
				}
			}
			if ($cats) $wgOut->addHTML("<tr><td>From category:</td><td><select name=\"ea-cat\"><option/>$cats</select></td></tr>\n");
		}

		# Allow selection of a group
		$groups = '<option/>';
		foreach (array_keys($wgGroupPermissions) as $group) if ($group != '*') {
			$selected = $group == $this->group ? ' selected' : '';
			if ($wgEmailPageAllowAllUsers || $group != 'user') $groups .= "<option$selected>$group</option>";
		}
		$wgOut->addHTML("<tr><td>".wfMsg('ea-fromgroup')."</td><td><select name=\"ea-group\">$groups</select></td></tr>\n");
		$wgOut->addHTML('</table>');

		# Addition of named list
		$wgOut->addWikiText(wfMsg('ea-selectlist'));
		$wgOut->addHTML("<textarea name=\"ea-list\" rows=\"5\">{$this->list}</textarea><br />\n");
		$wgOut->addHTML('</fieldset>');

		$wgOut->addHTML('<fieldset><legend>'.wfMsg('ea-compose').'</legend>');

		# Subject
		$wgOut->addWikiText(wfMsg('ea-subject'));
		$wgOut->addHTML(wfElement('input',array('type' => 'text', 'name' => 'ea-subject', 'value' => $this->subject, 'style' => "width:100%")));

		# Header
		$wgOut->addWikiText(wfMsg('ea-header'));
		$wgOut->addHTML("<textarea name=\"ea-header\" rows=\"5\">{$this->header}</textarea><br />\n");

		# CSS
		$csss = '';
		$result = $db->select(
			'page',
			'page_id',
			'page_title LIKE \'%.css\'',
			__METHOD__,
			array('ORDER BY' => 'page_title')
		);
		if ($result instanceof ResultWrapper) $result = $result->result;
		if ($result) while ($row = $db->fetchRow($result)) {
			$t = Title::newFromID($row[0])->getPrefixedText();
			$selected = $t == $this->css ? ' selected' : '';
			$csss .= "<option$selected>$t</option>";
		}
		if ($csss) {
			$wgOut->addWikiText(wfMsg('ea-selectcss'));
			$wgOut->addHTML("<select name=\"ea-css\"><option/>$csss</select>\n");
		}

		$wgOut->addHTML("</fieldset>");

		# Submit buttons & hidden values
		$wgOut->addHTML(wfElement('input', array('type' => 'submit', 'name' => 'ea-send', 'value' => wfMsg('ea-send'))));
		$wgOut->addHTML(wfElement('input', array('type' => 'submit', 'name' => 'ea-show', 'value' => wfMsg('ea-show'))));
		$wgOut->addHTML(wfElement('input', array('type' => 'hidden', 'name' => 'ea-title', 'value' => $this->title)));

		$wgOut->addHTML('</form>');

		# If the show button was clicked, render the list
		if (isset($_REQUEST['ea-show'])) return $this->send(false);
	}

	# Send the message to the recipients (or just list them if arg = false)
	function send($send = true) {
		global $wgOut, $wgUser, $wgParser, $wgServer, $wgScript, $wgArticlePath, $wgScriptPath,
			$wgEmailPageCss, $wgEmailPageGroup, $wgEmailPageAllowRemoteAddr, $wgEmailPageAllowAllUsers;

		# Set error and bail if user not in postmaster group, and request not from trusted address
		if ($wgEmailPageGroup && !in_array($wgEmailPageGroup, $wgUser->getGroups()) && !in_array($_SERVER['REMOTE_ADDR'], $wgEmailPageAllowRemoteAddr)) {
			$denied = wfMsg('ea-denied');
			$wgOut->addWikiText(wfMsg('ea-error', $this->title, $denied ));
			return false;
		}

		$db       = &wfGetDB(DB_SLAVE);
		$title    = Title::newFromText($this->title);
		$opt      = new ParserOptions;

		# Get contact page titles from selected cat
		if ($this->cat) {
			$result = $db->select(
				'categorylinks',
				'cl_from',
				'cl_to = '.$db->addQuotes($this->cat),
				__METHOD__,
				array('ORDER BY' => 'cl_sortkey')
			);
			if ($result instanceof ResultWrapper) $result = $result->result;
			if ($result) while ($row = $db->fetchRow($result)) $this->addRecipient(Title::newFromID($row[0]));
		}

		# Get email addresses from users in selected group
		if ($this->group && ($wgEmailPageAllowAllUsers || $this->group != 'user')) {
			$group = $db->addQuotes($this->group);
			$result = $this->group == 'user'
				? $db->select('user', 'user_email', 'user_email != \'\'', __METHOD__)
				: $db->select(array('user', 'user_groups'), 'user_email', "ug_user = user_id AND ug_group = $group", __METHOD__);
			if ($result instanceof ResultWrapper) $result = $result->result;
			if ($result) while ($row = $db->fetchRow($result)) $this->addRecipient($row[0]);
		}

		# Recipients from list (expand templates in wikitext)
		$list = $wgParser->preprocess($this->list, $title, $opt);
		foreach (preg_split("/[\\x00-\\x1f,;*]+/", $list) as $item) $this->addRecipient($item);

		# Compose the wikitext content of the page to send
		$page = new Article($title);
		$message = $page->getContent();
		if ($this->header) $message = "{$this->header}\n\n$message";

		# Convert the message text to html unless textonly
		if ($this->textonly == '') {

			# Parse the wikitext using absolute URL's for local page links
			$tmp           = array($wgArticlePath, $wgScriptPath, $wgScript);
			$wgArticlePath = $wgServer.$wgArticlePath;
			$wgScriptPath  = $wgServer.$wgScriptPath;
			$wgScript      = $wgServer.$wgScript;
			$message       = $wgParser->parse($message, $title, $opt, true, true)->getText();
			list($wgArticlePath,$wgScriptPath,$wgScript) = $tmp;

			# Get CSS content if any
			if ($this->css) {
				$page = new Article(Title::newFromText($this->css));
				$css = '<style type="text/css">'.$page->getContent().'</style>';
				}

			# Create a html wrapper for the message
			$head    = "<head>$css</head>";
			$message = "<html>$head<body style=\"margin:10px\"><div id=\"#bodyContent\">$message</div></body></html>";

		}

		# Send message or list recipients
		$count = count($this->recipients);
		if ($count > 0) {

			# Set up new mailer instance if sending
			if ($send) {
				$mail           = new PHPMailer();
				$mail->From     = $wgUser->isValidEmailAddr($wgUser->getEmail()) ? $wgUser->getEmail() : "wiki@$wgServer";
				$mail->FromName = User::whoIsReal($wgUser->getId());
				$mail->Subject  = $this->subject;
				$mail->Body     = $message;
				$mail->IsHTML(!$this->textonly);
			}
			else $msg = wfMsg('ea-listrecipients', $count);

			# Loop through recipients sending or adding to list
			foreach ($this->recipients as $recipient) $send ? $mail->AddAddress($recipient) : $msg .= "\n*[mailto:$recipient $recipient]";

			if ($send) {
				if ($state = $mail->Send()) $msg = wfMsg('ea-sent', $this->title, $count, $wgUser->getName());
				else $msg = wfMsg('ea-error', $this->title, $mail->ErrorInfo);
			}
			else $state = $count;
		}
		else $msg = wfMsg('ea-error', $this->title, wfMsg('ea-norecipients'));

		$wgOut->addWikiText($msg);
		return $state;
	}

	/**
	 * Add a recipient the list
	 * - accepts title objects for page containing email address, or string of actual address
	 */
	function addRecipient($recipient) {
		if (is_object($recipient) && $recipient->exists()) {
			$page = new Article($recipient);
			if (preg_match('/[a-z0-9_.-]+@[a-z0-9_.-]+/i', $page->getContent(), $emails)) $recipient = $emails[0];
			else $recipient = '';
		}
		if ($valid = User::isValidEmailAddr($recipient)) $this->recipients[] = $recipient;
		return $valid;
	}
}
