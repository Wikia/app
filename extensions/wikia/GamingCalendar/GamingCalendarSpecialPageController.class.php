<?php

/**
 * Controller for Special page - Gaming Calendar dashboard
 *
 * @author wlee
 */
class GamingCalendarSpecialPageController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('GamingCalendar', 'specialgamingcalendar', false);
	}

	public function index() {
		//@todo move this to init when init supports exceptions
		// Boilerplate special page permissions
		if ($this->wg->user->isBlocked()) {
			$this->wg->out->blockedPage();
			return false;	// skip rendering
		}
		if (!$this->wg->user->isAllowed('specialgamingcalendar')) {
			$this->displayRestrictionError();
			return false;
		}
		if (wfReadOnly() && !wfAutomaticReadOnly()) {
			$this->wg->out->readOnlyPage();
			return false;
		}

		$this->response->addAsset( 'resources/wikia/libraries/jquery-ui/jquery-ui-1.8.14.custom.js' );
		$this->response->addAsset( 'extensions/wikia/GamingCalendar/js/GamingCalendarSpecialPage.js' );
		$this->response->addAsset( 'extensions/wikia/GamingCalendar/css/GamingCalendarSpecialPage.scss' );

		$type = $this->getVal('type', null);
		$year = $this->getVal('year', null);
		$month = $this->getVal('month', null);

		$date = null;
		$entries = array();
		if (!empty($type) && !empty($year) && !empty($month)) {
			// get entries
			$date = date_create();
			date_date_set($date, $year, $month, 1);
			$entries = GamingCalendar::loadEntries(0, 5, $type, date_timestamp_get($date), false);
		}

		$typeName = GamingCalendar::getCalendarName($type);
		$this->setVal('typeName', $typeName);
		$this->setVal('type', $type);
		$this->setVal('year', $year);
		$this->setVal('month', $month);
		$this->setVal('date', $date ? date_timestamp_get($date) : '');
		$this->setVal('types', GamingCalendar::getCalendarTypes());
		$this->setVal('entries', $entries);
	}

	public function getEntriesForDate() {
		global $wgBlankImgUrl;

		$this->response->addAsset( '/resources/wikia/libraries/jquery-ui/jquery-ui-1.8.14.custom.js' );
		$this->response->addAsset( 'extensions/wikia/GamingCalendar/js/GamingCalendarSpecialPage.js' );
		$this->response->addAsset( 'extensions/wikia/GamingCalendar/css/GamingCalendarSpecialPage.scss' );

		//@todo move this to init once it supports exceptions
		// Boilerplate special page permissions
		if ($this->wg->user->isBlocked()) {
			$this->setVal('error', wfMsg('blockedtext'));
			return false;	// skip rendering
		}
		if (!$this->wg->user->isAllowed('specialgamingcalendar')) {
			$this->setVal('error', wfMsg('badaccess-group0'));
			return false;
		}
		if (wfReadOnly() && !wfAutomaticReadOnly()) {
			$this->setVal('error', wfMsg('readonlytext'));
			return false;
		}

		$type = $this->getVal('type');
		$date = $this->getVal('date');
		$year = $this->getVal('year');
		$month = $this->getVal('month');
		$day = $this->getVal('day');

		if (empty($date) && !empty($year) && !empty($month) && !empty($day)) {
			$date = date_timestamp_get(date_create("$year-$month-$day"));
		}

		$entries = array();
		if (!empty($type) && !empty($date) && ctype_digit($date)) {
			$entries = GamingCalendar::loadEntriesForDate($type, $date);
		}

		$typeName = GamingCalendar::getCalendarName($type);
		if (!empty($typeName)) {
			$this->setVal('typeName', $typeName);
		}
		$this->setVal('type', $type);
		$this->setVal('date', $date);
		$this->setVal('entries', $entries);
		$this->setVal('wgBlankImgUrl', $wgBlankImgUrl);
	}

	public function updateCalendarEntriesForDate() {
		global $wgUser;

		//@todo move this to init once it supports exceptions
		// Boilerplate special page permissions
		if ($this->wg->user->isBlocked()) {
			$this->setVal('error', wfMsg('blockedtext'));
			return false;	// skip rendering
		}
		if (!$this->wg->user->isAllowed('specialgamingcalendar')) {
			$this->setVal('error', wfMsg('badaccess-group0'));
			return false;
		}
		if (wfReadOnly() && !wfAutomaticReadOnly()) {
			$this->setVal('error', wfMsg('readonlytext'));
			return false;
		}

		wfProfileIn(__METHOD__);

		$res = array();

		$type = $this->getVal('type', null);
		$date = $this->getVal('date', null);
		$titles = $this->getVal('title', null);
		$subtitles = $this->getVal('subtitle', null);
		$descriptions = $this->getVal('description', null);
		$images = $this->getVal('image', null);
		$systemses = $this->getVal('systems', null);
		$rating = $this->getVal('rating', null);
		$moreInfoUrls = $this->getVal('moreinfourl', null);
		$preorderUrls = $this->getVal('preorderurl', null);

		// input validation
		if (empty($type)) {
			$res = array (
				'success' => false,
				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('gamingcalendar-error-missing-type')))
				);
			$this->setVal('res', $res);
			wfProfileOut(__METHOD__);
			return;
		}

		// create message content
		$content = '';
		foreach ($titles as $i=>$title) {
			if (empty($title)) {
				continue;
			}

			if (!empty($subtitles[$i])) $title = trim($title) . '|' . trim($subtitles[$i]);
			$content .= GamingCalendar::$ENTRY_TITLE_MARKER . ' ' . $title . "\n";
			if (!empty($descriptions[$i])) $content .= GamingCalendar::$ENTRY_ATTRIBUTE_MARKER . ' ' . GamingCalendar::$ENTRY_DESCRIPTION_MARKER . ' ' . $descriptions[$i] . "\n";
			if (!empty($images[$i])) $content .= GamingCalendar::$ENTRY_ATTRIBUTE_MARKER . ' ' . GamingCalendar::$ENTRY_IMAGE_MARKER . ' ' . $images[$i] . "\n";
			if (!empty($systemses[$i])) {
				$systems = explode(',', $systemses[$i]);
				foreach ($systems as &$system) {
					$system = trim($system);
				}
				$content .= GamingCalendar::$ENTRY_ATTRIBUTE_MARKER . ' '. GamingCalendar::$ENTRY_SYSTEMS_MARKER . ' ' . implode(',', $systems) . "\n";
			}
			if (!empty($rating[$i])) $content .= GamingCalendar::$ENTRY_ATTRIBUTE_MARKER . ' ' . GamingCalendar::$ENTRY_RATING_MARKER .  ' ' . $rating[$i] . "\n";
			if (!empty($moreInfoUrls[$i])) $content .= GamingCalendar::$ENTRY_ATTRIBUTE_MARKER . ' ' . GamingCalendar::$ENTRY_MOREINFO_MARKER . ' ' . $moreInfoUrls[$i] . "\n";
			if (!empty($preorderUrls[$i])) $content .= GamingCalendar::$ENTRY_ATTRIBUTE_MARKER . ' ' . GamingCalendar::$ENTRY_PREORDER_MARKER . ' ' . $preorderUrls[$i] . "\n";
		}

		// save message
		$msgTitle = Title::newFromText(GamingCalendar::getEntryKey($type, $date), NS_MEDIAWIKI);
		$article = new Article($msgTitle);
		if ($msgTitle->getArticleID()) {
			$editMsg = 'Message edited';
			$editMode = EDIT_UPDATE;
		}
		else {
			$editMsg = 'Message created';
			$editMode = EDIT_NEW;
		}
		$status = $article->doEdit($content, $editMsg, $editMode, false, $wgUser);
		$title_object = $article->getTitle();
		// @todo check status object
		$res = array (
			'success' => true,
			// TODO: don't hardcode /wiki path
			'url'  => '/wiki/Special:GamingCalendar?type='.$type.'&year='.date('Y', $date).'&month='.date('n', $date)
			);

		$this->setVal('res', $res);
		wfProfileOut(__METHOD__);
	}

}
