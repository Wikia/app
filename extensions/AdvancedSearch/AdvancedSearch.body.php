<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright (C) 2008 Roan Kattouw 
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows for searching inside categories
 * Written for MixesDB <http://mixesdb.com> by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see the README file.
 *
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install the AdvancedSearch extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/AdvancedSearch/AdvancedSearch.setup.php" );
EOT;
	exit(1);
}

class AdvancedSearch extends SpecialPage
{
	public function __construct()
	{
		parent::__construct('AdvancedSearch');
	}

	public function execute($par)
	{
		global $wgOut, $wgRequest;
		wfLoadExtensionMessages('AdvancedSearch');
		$this->setHeaders();
		$wgOut->setPageTitle(wfMsg('advancedsearch-title'));
		if($wgRequest->getVal('do') == 'search' || !is_null($par))
			$wgOut->addHTML($this->showResults($par));
		else
			$wgOut->addHTML($this->buildForm());
	}
	
	/**
	 * Generate the HTML for the permanent link to this search result
	 * @param $pager AdvancedSearchPager
	 */
	protected function permaLink($pager)
	{
		global $wgUser;
		$key = $pager->cacheQuery();
		return wfMsg('advancedsearch-permalink',
			$wgUser->getSkin()->makeLinkObj(
				SpecialPage::getTitleFor("AdvancedSearch/$key"),
				wfMsg('advancedsearch-permalink-text')));
	}
	
	protected function showResults($par)
	{
		global $wgRequest;
		$key = $wgRequest->getVal('key', null);
		if(is_null($key))
			$key = $par;
		$searchTitle = $searchContent = true;
		if(!is_null($key))
		{
			$pager = AdvancedSearchPager::newFromKey($key);
			if($pager instanceof AdvancedSearchPager)
			{
				$searchTitle = $pager->getSearchTitle();
				$searchContent = $pager->getSearchContent();
			}
		}
		else
		{
			$searchTitle = $wgRequest->getCheck('searchtitle');
			$searchContent = $wgRequest->getCheck('searchcontent');
			$pager = new AdvancedSearchPager(
				$wgRequest->getVal('content-incl'),
				$wgRequest->getVal('content-excl'),
				$wgRequest->getVal('cat-incl'),
				$wgRequest->getVal('cat-excl'),
				$wgRequest->getArray('speedcats', array()),
				$wgRequest->getVal('scdd'),
				$wgRequest->getArray('namespaces', array()),
				$searchTitle,
				$searchContent);
		}
		$permalink = $body = '';
		$errors  = array(false, false, false, false);
		if(!$pager instanceof AdvancedSearchPager)
		{
			$body = Xml::element('div', array('class' => 'errorbox'),
					wfMsg('advancedsearch-permalink-invalid'));
		}
		else
		{
			$errors = $pager->getParseErrors();
			if($errors !== array(false, false, false, false))
				return $this->buildForm($errors, $searchTitle, $searchContent);

			if($wgRequest->getBool('permalink'))
				$permalink = $this->permaLink($pager);
			if($pager->getNumRows() > 0)
				$body = $pager->getBody();
			else
				$body = Xml::element('div', array('class' => 'errorbox'),
						wfMsg('advancedsearch-empty-result'));
		}
		return 	$body .
			Xml::element('br', array('clear' => 'both')) .
			$permalink . 
			$this->buildForm($errors, $searchTitle, $searchContent);
	}

	protected function inputRow($name)
	{
		global $wgRequest;
		return 	Xml::openElement('tr') .
			Xml::openElement('td') .
			Xml::input($name, 50, $wgRequest->getVal($name, false)) .
			Xml::closeElement('td') .
			Xml::closeElement('tr');
	}

	protected function errorRow($msg)
	{
		return	Xml::openElement('tr') .
			Xml::openElement('td') .
			Xml::openElement('span', array('class' => 'error')) .
			$msg .
			Xml::closeElement('span') .
			Xml::closeElement('td') .
			Xml::closeElement('tr');
	}

	protected function speedCatTable()
	{
		global $wgAdvancedSearchSpeedCats, $wgRequest;
		$i = $j = $n = 0;
		$cols = 3;
		$scarr = $wgRequest->getArray('speedcats', array());
		$retval = Xml::openElement('table');
		foreach(@$wgAdvancedSearchSpeedCats as $name => $display)
		{
			$close = false;
			if($i == 0)
				$retval .= Xml::openElement('tr');
			if($i == $cols - 1)
			{
				$i = 0;
				$j++;
				$close = true;
			}
			else
				$i++;
			$n++;

			$retval .= Xml::openElement('td');
			$checked = false;
			if(in_array($name, $scarr))
				$checked = true;
			$retval .= Xml::checkLabel($display, 'speedcats[]', "speedcats-$n", $checked, array('value' => $name));
			$retval .= Xml::closeElement('td');
			if($close)
				$retval .= Xml::closeElement('tr');
		}
		if(!$close)
			$retval .= Xml::closeElement('tr');
		$retval .= Xml::openElement('tr');
		$retval .= Xml::openElement('td', array('colspan' => 2));
		$retval .= Xml::element('a', array('href' => 'javascript:caSpeedcats(\'all\');'), wfMsg('advancedsearch-selectall'));
		$retval .= ' / ';
		$retval .= Xml::element('a', array('href' => 'javascript:caSpeedcats(\'none\');'), wfMsg('advancedsearch-selectnone'));
		$retval .= ' / ';
		$retval .= Xml::element('a', array('href' => 'javascript:caSpeedcats(\'invert\');'), wfMsg('advancedsearch-invertselection'));
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');
		$retval .= $this->speedcatDropdownRows();
		$retval .= Xml::closeElement('table');
		return $retval;
	}
	
	protected function speedcatCheckboxes()
	{
		global $wgAdvancedSearchSpeedCats;
		if(!isset($wgAdvancedSearchSpeedCats) || empty($wgAdvancedSearchSpeedCats))
			return array();
		$retval = array();
		$i = 1;
		foreach(@$wgAdvancedSearchSpeedCats as $name => $display)
		{
			$retval[] = "speedcats-{$i}";
			$i++;
		}
		return $retval;
	}

	protected function speedcatDropdownRows()
	{
		global $wgAdvancedSearchSpeedCatDropdown, $wgRequest;
		if(!isset($wgAdvancedSearchSpeedCatDropdown) || empty($wgAdvancedSearchSpeedCatDropdown))
			return '';
		$sel = $wgRequest->getVal('scdd');
		$retval = Xml::openElement('tr');
		$retval .= Xml::openElement('td', array('colspan' => 3));
		$retval .= wfMsg('advancedsearch-speedcat-dropdown');
		$retval .= Xml::openElement('select', array('name' => 'scdd'));
		$retval .= Xml::option('', '', is_null($sel));
		foreach(@$wgAdvancedSearchSpeedCatDropdown as $key => $value)
		{
			if(is_int($key))
				$key = $value;
			$retval .= Xml::option($key, $value, $sel == $value);
		}
		$retval .= Xml::closeElement('select');
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');
		return $retval;
	}
	
	public static function searchableNamespaces()
	{
		global $wgContLang;
		$retval = array();
		foreach($wgContLang->getFormattedNamespaces() as $ns => $value)
			if($ns >= NS_MAIN)
				$retval[$ns] = $value;
		return $retval;
	}

	protected function namespaceTable()
	{
		global $wgRequest, $wgUser;
		$i = 0;
		$j = 0;
		$cols = 2;
		$retval = Xml::openElement('table');
		$nsarr = $wgRequest->getArray('namespaces', array());
		foreach(self::searchableNamespaces() as $ns => $display)
		{
			$close = false;
			if($i == 0)
				$retval .= Xml::openElement('tr');
			if($i == $cols - 1)
			{
				$i = 0;
				$j++;
				$close = true;
			}
			else
				$i++;
			$retval .= Xml::openElement('td');
			if($display == '')
				$display = wfMsg('blanknamespace');
			$checked = false;
			if(in_array($ns, $nsarr))
				$checked = true;
			else if(empty($nsarr))
				$checked = $wgUser->getOption("searchNs$ns");
			$retval .= Xml::checkLabel($display, 'namespaces[]', "namespaces-$ns",
					$checked, array('value' => $ns));
			$retval .= Xml::closeElement('td');
			if($close)
				$retval .= Xml::closeElement('tr');
		}
		if(!$close)
			$retval .= Xml::closeElement('tr');
		$retval .= Xml::openElement('tr');
		$retval .= Xml::openElement('td', array('colspan' => 2));
		$retval .= Xml::element('a', array('href' => 'javascript:caNamespaces(\'all\');'), wfMsg('advancedsearch-selectall'));
		$retval .= ' / ';
		$retval .= Xml::element('a', array('href' => 'javascript:caNamespaces(\'none\');'), wfMsg('advancedsearch-selectnone'));
		$retval .= ' / ';
		$retval .= Xml::element('a', array('href' => 'javascript:caNamespaces(\'invert\');'), wfMsg('advancedsearch-invertselection'));
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');

		$retval .= Xml::closeElement('table');
		return $retval;
	}
	
	protected function namespaceCheckboxes()
	{
		$retval = array();
		foreach(self::searchableNamespaces() as $ns => $unused)
			$retval[] = "namespaces-$ns";
		return $retval;
	}

	protected function invertJS($func, $checkboxes)
	{
		$retval = "function $func(action)\n{";
		foreach($checkboxes as $c)
			$retval .= "checkboxAction('$c', action);\n";
		$retval .= "}\n";
		return $retval;
	}
	
	protected function checkboxActionJS()
	{
		return <<<ENDOFLINE
function checkboxAction(c, action)
{
	var obj = document.getElementById(c);
	switch(action)
	{
		case 'all':
			obj.checked = true;
			break;
		case 'none':
			obj.checked = false;
			break;
		case 'invert':
			obj.checked = !obj.checked;
	}
}
ENDOFLINE;
	}

	protected function buildForm($parseErrors = null, $searchTitle = true, $searchContent = true)
	{
		global $wgScript, $wgOut;
		$wgOut->addInlineScript(
			$this->checkboxActionJS() .
			$this->invertJS('caNamespaces', $this->namespaceCheckboxes()) .
			$this->invertJS('caSpeedcats', $this->speedcatCheckboxes()));
		$retval = wfMsgExt('advancedsearch-toptext', array('parse'));
		$retval .= Xml::openElement('form', array('method' => 'GET', 'action' => $wgScript));
		$retval .= Xml::hidden('title', $this->getTitle()->getPrefixedDbKey());
		$retval .= Xml::hidden('do', 'search');
		
		// The big table everything is in
		$retval .= Xml::openElement('table');
		
		// The fieldset+table for searching page content
		$retval .= Xml::openElement('tr');
		$retval .= Xml::openElement('td', array('valign' => 'top'));
		$retval .= Xml::openElement('fieldset', array('class' => 'nested'));
		$retval .= Xml::element('legend', array('class' => 'advancedsearchLegend'), wfMsg('advancedsearch-contentsearch'));
		$retval .= Xml::openElement('table');

		// title/content checkboxes
		$retval .= Xml::openElement('tr');
		$retval .= Xml::openElement('td');
		$retval .= wfMsg('advancedsearch-searchin');
		$retval .= Xml::checkLabel(wfMsg('advancedsearch-searchin-title'), 'searchtitle',
				'searchtitle', $searchTitle);
		$retval .= Xml::checkLabel(wfMsg('advancedsearch-searchin-content'), 'searchcontent',
				'searchcontent', $searchContent);
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');

		// Include fieldset
		$retval .= Xml::openElement('tr');
		$retval .= Xml::openElement('td', array('valign' => 'top'));
		$retval .= Xml::openElement('fieldset', array('class' => 'nested'));
		$retval .= Xml::element('legend', array('class' => 'advancedsearchLegend'), wfMsg('advancedsearch-content-include'));
		$retval .= Xml::openElement('table');
		$retval .= $this->inputRow('content-incl');
		if(is_array($parseErrors) && $parseErrors[0] !== false)
			$retval .= $this->errorRow($parseErrors[0]);
		$retval .= Xml::closeElement('table');
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');
		
		// Exclude fieldset
		$retval .= Xml::openElement('tr');
		$retval .= Xml::openElement('td', array('valign' => 'top'));
		$retval .= Xml::openElement('fieldset', array('class' => 'nested'));
		$retval .= Xml::element('legend', array('class' => 'advancedsearchLegend'), wfMsg('advancedsearch-content-exclude'));
		$retval .= Xml::openElement('table');
		$retval .= $this->inputRow('content-excl');
		if(is_array($parseErrors) && $parseErrors[1] !== false)
			$retval .= $this->errorRow($parseErrors[1]);
		$retval .= Xml::closeElement('table');
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');

		$retval .= Xml::closeElement('table');
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('td');
		
		// The namespace fieldset
		$retval .= Xml::openElement('td', array('valign' => 'top'));
		$retval .= Xml::openElement('fieldset', array('class' => 'nested'));
		$retval .= Xml::element('legend', array('class' => 'advancedsearchLegend'), wfMsg('advancedsearch-namespaces'));
		$retval .= $this->namespaceTable();
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');

		// The category fieldset				
		$retval .= Xml::openElement('tr');
		$retval .= Xml::openElement('td', array('valign' => 'top'));
		$retval .= Xml::openElement('fieldset', array('class' => 'nested'));
		$retval .= Xml::element('legend', array('class' => 'advancedsearchLegend'), wfMsg('advancedsearch-categorysearch'));
		$retval .= Xml::openElement('table');
		
		// The include fieldset
		$retval .= Xml::openElement('tr');
		$retval .= Xml::openElement('td', array('valign' => 'top'));
		$retval .= Xml::openElement('fieldset', array('class' => 'nested'));
		$retval .= Xml::element('legend', array('class' => 'advancedsearchLegend'), wfMsg('advancedsearch-category-include'));
		$retval .= Xml::openElement('table');
		$retval .= $this->inputRow('cat-incl');
		if(is_array($parseErrors) && $parseErrors[2] !== false)
			$retval .= $this->errorRow($parseErrors[2]);
		$retval .= Xml::closeElement('table');
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');
		
		// The exclude fieldset
		$retval .= Xml::openElement('tr');
		$retval .= Xml::openElement('td', array('valign' => 'top'));
		$retval .= Xml::openElement('fieldset', array('class' => 'nested'));
		$retval .= Xml::element('legend', array('class' => 'advancedsearchLegend'), wfMsg('advancedsearch-category-exclude'));
		$retval .= Xml::openElement('table');
		$retval .= $this->inputRow('cat-excl');
		if(is_array($parseErrors) && $parseErrors[3] !== false)
			$retval .= $this->errorRow($parseErrors[3]);
		$retval .= Xml::closeElement('table');
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');
		
		$retval .= Xml::closeElement('table');
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('td');
		$retval .= Xml::openElement('td', array('valign' => 'top'));
		$retval .= Xml::openElement('table');

		// The speedcat fieldset
		global $wgAdvancedSearchSpeedCats;
		if(!empty($wgAdvancedSearchSpeedCats))
		{
			$retval .= Xml::openElement('td', array('valign' => 'top'));
			$retval .= Xml::openElement('fieldset', array('class' => 'nested'));
			$retval .= Xml::element('legend', array('class' => 'advancedsearchLegend'), wfMsg('advancedsearch-speedcats'));
			$retval .= $this->speedCatTable();
			$retval .= Xml::closeElement('fieldset');
			$retval .= Xml::closeElement('td');
		}

		$retval .= Xml::closeElement('table');
		$retval .= Xml::closeElement('td');
		$retval .= Xml::closeElement('tr');
		$retval .= Xml::closeElement('table');
		$retval .= Xml::checkLabel(wfMsg('advancedsearch-permalink-check'), 'permalink', 'permalink');
		$retval .= Xml::element('br');
		$retval .= Xml::submitButton(wfMsg('advancedsearch-submit'));
		$retval .= Xml::closeElement('form');	 
		return $retval;
	}
}
