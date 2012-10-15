<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class SearchTemplate extends MobileFrontendTemplate {

	public function getHTML() {

		$searchField = htmlspecialchars( $this->data['searchField'] );
		$mainPageUrl = $this->data['mainPageUrl'];
		$randomPageUrl = $this->data['randomPageUrl'];
		$homeButton = $this->data['messages']['mobile-frontend-home-button'];
		$randomButton = $this->data['messages']['mobile-frontend-random-button'];

		$scriptUrl = wfScript();
		$searchBoxDisplayNone = ( $this->data['hideSearchBox'] ) ? ' style="display: none;" ' : '';

		$logoDisplayNone = ( $this->data['hideLogo'] ) ? ' style="display: none;" ' : '';

		$openSearchResults = '<div id="results"></div>';

		$languageSelection = $this->data['buildLanguageSelection'] . '<br/>';
		$languageSelectionText = '<b>' . $this->data['messages']['mobile-frontend-language'] . ':</b><br/>';
		$languageSelectionDiv = '<div id="languageselectionsection">' . $languageSelectionText . $languageSelection . '</div>';

		$logoOnClick = ( $this->data['device']['supports_javascript'] ) ? 'onclick="javascript:logoClick();"' : '';

		$searchWebkitHtml = <<<HTML
			{$openSearchResults}
		<div id='header'>
			<div id='searchbox' {$logoDisplayNone}>
			<img width="35" height="22" alt='Logo' id='logo' src='{$this->data['wgMobileFrontendLogo']}' {$logoOnClick} {$logoDisplayNone} />
			<form action='{$scriptUrl}' class='search_bar' method='get' {$searchBoxDisplayNone}>
			  <input type="hidden" value="Special:Search" name="title" />
				<div id="sq" class="divclearable">
					<input type="text" name="search" id="search" size="22" value="{$searchField}" autocorrect="off" autocomplete="off" autocapitalize="off" maxlength="1024" />
					<div class="clearlink" id="clearsearch"></div>
				</div>
			  <button id='goButton' type='submit'></button>
			</form>
			</div>
			<div class='nav' id='nav' {$logoDisplayNone}>
			{$languageSelectionDiv}
			<button onclick="javascript:location.href='{$mainPageUrl}';" type="submit" id="homeButton">{$homeButton}</button>
			<button onclick="javascript:location.href='{$randomPageUrl}';" type="submit" id="randomButton">{$randomButton}</button>
		  </div>
		</div>
HTML;
		return $searchWebkitHtml;
	}
}
