<?php
/**
 * See docs/skin.txt
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * @todo document
 * @ingroup Skins
 */
class SkinCorporateBase extends SkinTemplate {
	
	function initPage( OutputPage $out ) {
		global $wgHooks;
		parent::initPage( $out );
	}
	
	public function buildPersonalUrls(&$obj, &$tpl) {
		global $wgUser, $wgTitle;

		$data = array();
		
		if(!$wgUser->isLoggedIn()) {
			$returnto = "returnto={$this->thisurl}";
			if( $this->thisquery != '' )
				$returnto .= "&returntoquery={$this->thisquery}";

			$signUpHref = Skin::makeSpecialUrl( 'Signup', $returnto );
			$data['login'] = array(
				'text' => wfMsg('login'),
				'href' => $signUpHref
				);

			$data['register'] = array(
				'text' => wfMsg('nologinlink'),
				'href' => $signUpHref
				);
		}
		$data['search'] = array(
			'href' => Skin::makeSpecialUrl('Search')
		);

		$data['createwiki'] = array(
			'href' => Skin::makeSpecialUrl('CreateWiki'),
			'text' => wfMsg('home2-create-button')
		);
						
		return array_merge(parent::buildPersonalUrls(),$data);
	}
}

require_once dirname(__FILE__) . "/../extensions/wikia/AnalyticsEngine/AnalyticsEngine.php";

class CorporateBaseTemplate extends QuickTemplate {
	var $skin;
	var $memc = false;
	/**
	 * Prints the HTML for the <head></head> (inclusive) section.
	 */
	protected function htmlHead(){
?>
	<head>
		<meta charset="<?php $this->text('charset') ?>">
		<!--headlinks-->
		<?php $this->html('headlinks') ?>
		<!--title-->
		<title><?php $this->text('pagetitle') ?></title>
		<!--csslinks-->
		<?php echo $this->getStaticChuteCSS(); ?>
		<?php $this->html('csslinks') ?>
		<!--[if lt IE 8]>
		<link rel="stylesheet" href="/skins/corporate/css/ie.css" type="text/css" media="screen">
		<![endif]-->

		<!--global variables script-->
		<?php print Skin::makeGlobalVariablesScript( $this->data ); ?>

		<!-- headscripts -->
		<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<?php $this->html('wikia_headscripts'); ?>
		<?php echo $this->getStaticChuteJS(); ?>
		<?php $this->html('headscripts') ?>

		<?php	if($this->data['jsvarurl']) { ?>
		<!-- MediaWiki site js -->
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl') ?>"></script>
<?php	} ?>
<?php	if($this->data['pagecss']) { ?>
		<!-- page css -->
		<style><?php $this->html('pagecss') ?></style>
<?php	}
		if($this->data['usercss']) { ?>
		<!-- user css -->
		<style><?php $this->html('usercss') ?></style>
<?php	}
		if($this->data['userjs']) { ?>
		<!-- user js -->
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
<?php	}
		if($this->data['userjsprev']) { ?>
		<!-- user js prev -->
		<script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
<?php	}
		if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
	</head>
<?php
	} // END: function htmlHead()

	/**
	 * Generic <body> element class attribute values for all pages.
	 */
	protected function htmlBodyClassAttributeValues(){
		global $wgUser;
		ob_start(); // next functions want to print but we don't want that yet
		print 'mediawiki ';
		print ' ' . $this->text('dir');
		print ' ' . $this->text('pageclass');
		print ' ' . $this->text('skinnameclass');
		print ( $wgUser->isLoggedIn() ) ? ' loggedin' : ' loggedout';
		ob_end_flush();
	} // END: function htmlBodyClassAttributeValues

	/**
	 * The HTML for the Wikia Global header.
	 */
	protected function htmlGlobalHeader(){
		global $wgStylePath, $wgLangToCentralMap, $wgContLang;
		$central_url = !empty($wgLangToCentralMap[$wgContLang->getCode()]) ? $wgLangToCentralMap[$wgContLang->getCode()] : 'http://www.wikia.com/';
?>
		<header id="GlobalHeader">
			<!-- DEV NOTE: This is the white gradient strip at the top. -->
			<div class="shrinkwrap">
				<h1>
					<a href="<?php print $central_url?>" title=""><img id="wikia-logo" src="<?php echo $wgStylePath; ?>/corporate/images/logo.blue.wikia.140x35.png" alt="Wikia&reg;" width="140" height="35"></a>
				</h1>

				<div id="wikia-tools">
					<p id="wikia-account-tools">
						<?php if($this->isAnon()): ?>
							<a id="wikia-login-link" href="<?php echo $this->data['personal_urls']['login']['href']; ?>"><?php print wfMsg('login'); ?></a>/
							<a id="wikia-create-account-link" href="<?php echo $this->data['personal_urls']['register']['href']; ?>"><?php print wfMsg('nologinlink'); ?></a>
						<?php else: ?>
							<strong><?php echo $this->data['username']; ?></strong>
							<a href="<?php echo $this->data['personal_urls']['watchlist']['href']; ?>"><?php echo wfMsg('home2-watchlist'); ?></a>
							<a id="wikia-login-link" href="<?php echo $this->data['personal_urls']['logout']['href']; ?>"><?php print wfMsg('logout'); ?></a>
						<?php endif;?>
					</p>
					<form id="wikia-search-form" name="wikia_search_form" action="<?php echo $this->data['personal_urls']['search']['href']; ?>" method="get">
						<fieldset>
							<legend><?php print wfMsg('home2-find-a-wiki') ?></legend>
							<input type="text" class="SearchField<?php print (wfMsg('home2-find-a-wiki') === $this->getSearchValue()) ? ' placeholder' : '' ;?>" id="wikia-search" name="search" title="<?php print wfMsg("home2-search-title"); ?>" value="<?php print $this->getSearchValue(); ?>">
							<input type="submit" id="wikia-search-submit" name="wikia_search_submit" value="Search">
						</fieldset>
					</form>
				</div><!-- END #wikia-tools -->
			</div><!-- END .shrinkwrap -->
		</header>
<?php
	}

	protected function htmlGlobalNav(){
?>
		<nav id="GlobalNav">
			<div class="shrinkwrap">
				<h1 id="globalnav-headline"><?php print wfMsg('home2-global-nav-headline'); ?></h1>
				<ul class="nav-top-level">
					<?php foreach ($this->getGlobalNav() as $key => $value): ?>
						<li<?php print $value['islast'] ? ' class="last"':'';?> <?php print $value['isfirst'] ? ' class="first"':'';?>>
							<a class="nav-link" href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a>
							<ul class="nav-sub-level">
								<?php foreach ($value['sub'] as $key2 => $value2): ?>
									<li<?php print ($key2 == 0) ? ' class="first"':'';?> <?php print ($key2 == (count($value['sub'])-1)) ? ' class="last"':'';?> >
										<?php if (!empty($value2['favicon'])) { ?><img src="<?php print $value2['favicon'] ?>" alt=""><?php } ?>
										<a id="nav_sub_link_<?php print $key + 1 ?>_<?php print $key2 + 1 ?>" class="nav-sub-link" href="<?php print $value2['href'] ?>">
											<?php print $value2['title'] ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endforeach; ?>
				</ul><!-- END #GlobalNav -->
			</div>
		</nav>
<?php
	} // END: function htmlGlobalNav

	protected function htmlMainArticleContents(){
?>
			<div class="shrinkwrap">
				<h1><?php print $this->data['title']?></h1>
				<?php $this->html('bodytext'); ?>
			</div>
<?php
	} // END: function htmlMainArticleContents

	protected function htmlCompanyInfo(){
?>
		<section id="CompanyInfo">
			<div class="shrinkwrap">
			<h1 id="company-info-headline"><?php print wfMsg('home2-company-info-headline') ;?> </h1>
				<section id="wikia-international">
					<h1><?php print wfMsg('home2-wikia-international') ?></h1>
					<ul>
					<?php foreach ($this->getFooterLeftcolumn() as $key => $value): ?>
						<li id="wikia-international-<?php print $key;?>"<?php print $value['islast'] ? ' class="last"':'';?> <?php print $value['isfirst'] ? ' class="first"':'';?>>
							<a href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a>
						</li>
					<?php endforeach; ?>
					</ul>
				</section>

				<section id="wikia-in-the-know">
					<h1><?php print wfMsg('home2-in-the-know') ?></h1>
					<ul>
					<?php foreach($this->parseMsgImg('home2-footer-middlecolumn') as $key => $value): ?>
						<li id="wikia-in-the-know-<?php print $key;?>">
							<a href="<?php echo $value['href']; ?>" style="background-image:url(<?php print $value['imagename'] ?>);"><?php echo $value['title']; ?></a>
						</li>
					<?php endforeach; ?>
					</ul>
				</section>

				<section id="wikia-more-links">
					<h1><?php print wfMsg('home2-more-link') ?></h1>
					<ul>
					<?php foreach ($this->getFooterRightcolumn() as $key => $value): ?>
						<li id="wikia-more-links-<?php print $key;?>"><a href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a></li>
					<?php endforeach; ?>
					</ul>
				</section>
			</div><!-- END .shrinkwrap -->
		</section><!-- END #CompanyInfo -->
<?php
	} // END: function htmlCompanyInfo

	protected function htmlGlobalFooter(){
?>
		<!-- Begin Analytics -->
		<?php
		// Note, these were placed above the Ad calls intentionally because ad code screws with analytics
		echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
		echo AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory());
		global $wgCityId;
		echo AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId));
		echo AnalyticsEngine::track('GA_Urchin', 'pagetime', array('lean_monaco'));
		if (43339 == $wgCityId) echo AnalyticsEngine::track("GA_Urchin", "lyrics");
		?>
		<!-- End Analytics -->
		<footer>
			<div class="shrinkwrap">
				<p id="wikia-create-wiki">
					<?php print wfMsg('home2-create-your-own-wiki') ?>
					<a href="<?php echo $this->data['personal_urls']['createwiki']['href']; ?>" class="wikia_button secondary">
						<span><?php echo $this->data['personal_urls']['createwiki']['text']; ?></span>
					</a>
				</p>

				<p id="copyright"><?php print wfMsg('home2-rights',date('Y')) ?> </p>

				<ul id="SupplementalNav">
					<?php $footerBottom = $this->getFooterBottom(); ?>
					<?php foreach ($footerBottom as $key => $value): ?>
						<li <?php print $value['islast'] ? 'class="first"':'';?> <?php print $value['isfirst'] ? 'class="first"':'';?>>
							<?php if((count($footerBottom) - $key) <= 4 ): ?>
								<a class="last4" id="footer_bottom_<?php echo (  $key - (count($footerBottom) - 5)); ?>" href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a>
							<?php else: ?>
								<a href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>

			</div><!-- END .shrinkwrap -->

		</footer>
<?php
	} // END: function GlobalFooter

	protected function isAnon(){
		global $wgUser;
		return $wgUser->isAnon();
	}

	protected function getGlobalNav(){
		$message = $this->parseMsg('home2-sidebar',true);
		return $message;
	}

	protected function getFooterLeftcolumn(){
		$message = $this->parseMsg('home2-footer-leftcolumn');
		return $message;
	}

	protected function getFooterRightcolumn(){
		$message = $this->parseMsg('home2-footer-rightcolumn');
		return $message;
	}

	protected function getFooterMiddlecolumn(){
		$message = $this->parseMsg('home2-footer-middlecolumn');
		return $message;
	}

	protected function getFooterBottom(){
		$message = $this->parseMsg('home2-footer-bottom');
		return $message;
	}

	protected function getSearchValue(){
		global $wgRequest;
		$x = $wgRequest->getVal( 'search', '' );
		return ( !empty( $x ) ) ? $x : wfMsg('home2-find-a-wiki') ;
	}

	protected function parseMsg($msg,$favicon = false){
		global $wgMemc,$wgLang;
		$mcKey = wfMemcKey( "hp_msg_parser", $msg, $wgLang->getCode() );
		$out = $wgMemc->get( $mcKey, null);
		if ($this->memc && $out != null){
			return $out;
		}
		$message = wfMsg($msg);
		$lines = explode("\n",$message);
		$out = array();
		foreach($lines as $v){
			if (preg_match("/^([\*]+)([^|]+)\|(.*)$/",trim($v),$matches)){
				if (strlen($matches[1]) == 1){
					$out[] = array("title" => trim($matches[3]), 'href' => trim($matches[2]),'sub' => array());
				}

				if (strlen($matches[1]) == 2){
					if (count($out) > 0){
						if ($favicon){
							$id = (int) WikiFactory::UrlToID(trim($matches[2]));
							$favicon = "";
							if ($id > 0){
								$favicon = WikiFactory::getVarValueByName( "wgFavicon", $id );
							}
						}
						$out[count($out) - 1]['sub'][] = array("favicon" => $favicon, "title" => trim($matches[3]), 'href' => trim($matches[2]));
					}
				}
			}
		}
		if (count($out) >0){
			$out[0]['isfirst'] = true;
			$out[count($out)-1]['islast'] = true;
		}
		$wgMemc->set( $mcKey ,$out,60*60);
		return $out;
	}

	protected function parseMsgImg($msg,$descThumb = false){
		global $wgMemc,$wgLang;
		$mcKey = wfMemcKey( "hp_msg_parser", $msg, $wgLang->getCode());
		$out = $wgMemc->get( $mcKey, null);
		if ($this->memc && $out != null){
			return $out;
		}
		$message = wfMsg($msg);
		$lines = explode("\n",$message);
		$out = array();
		foreach($lines as $v){
			if ($descThumb){
				$str = "/^([\*]+)([^|]+)\|([^|]+)\|([^|]+)\|([^|]+)\|(.*)$/";
			} else {
				$str = "/^([\*]+)([^|]+)\|([^|]+)\|(.*)$/";
			}
			if (preg_match($str,trim($v),$matches)){
				if (strlen($matches[1]) == 1){
					if ($descThumb){
						$imageName = $this->getImageName($matches[5]);
						$thumbName = $this->getImageName($matches[6]);
						$out[] = array("desc" => $matches[4],"imagethumb" => $thumbName,"imagename" => $imageName, "title" => trim($matches[3]), 'href' => trim($matches[2]),'sub' => array());
					} else {
						$imageName = $this->getImageName($matches[4]);
						$out[] = array("imagename" => $imageName, "title" => trim($matches[3]), 'href' => trim($matches[2]),'sub' => array());
					}
				}
			}
		}
		$wgMemc->set( $mcKey, $out,60*60);
		return $out;
	}

	private function getImageName($name){
		global $wgStylePath;
		$image = Title::newFromText($name);
		$image = wfFindFile($image);
		$imageName = $wgStylePath."/common/dot.gif";
		if (($image) && ($image->exists())){
			$imageName = $image->getViewURL();
		}
		return $imageName;
	}

	protected function isManager(){
		global $wgUser;
		return $wgUser->isAllowed( 'CorporatePageManager' );
	}

	protected function getStaticChuteJS(){
		$StaticChute = new StaticChute('js');
		$StaticChute->useLocalChuteUrl();
		return $StaticChute->getChuteHtmlForPackage('corporate_page_js');
	}

	protected function getStaticChuteCSS(){
		$StaticChute = new StaticChute('css');
		$StaticChute->useLocalChuteUrl();
		return $StaticChute->getChuteHtmlForPackage('corporate_page_css');
	}

} // end of class
