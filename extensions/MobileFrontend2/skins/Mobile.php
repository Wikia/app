<?php

class SkinMobile extends SkinTemplate {
	var $skinname = 'mobile',
		$stylename = 'mobile',
		$template = 'MobileTemplate',
		$useHeadElement = false;

	/**
	 * Overridden to make changes to resource loader
	 *
	 * @param null|OutputPage $out
	 */
	function outputPage( OutputPage $out = null ) {
		global $wgScript, $wgMobileFrontend2Logo;

		$out = $this->getOutput();
		$request = $this->getRequest();
		$user = $this->getUser();
		$title = $this->getTitle();

		// We need to disable all the default RL modules, do that like this
		$out->clearAllModules();

		// Add the mobile js
		$out->addModules( 'ext.mobileFrontend2' );

		// TODO: Hook for adding modules

		Profiler::instance()->setTemplated( true );

		$this->initPage( $out );
		$tpl = $this->setupTemplate( $this->template, 'skins' );

		// Give the skin (us) to the template
		$tpl->setRef( 'skin', $this );

		// Language stuff
		$lang = $this->getLanguage();
		$userlang = $lang->getHtmlCode();
		$userdir  = $lang->getDir();

		$tpl->set( 'lang', $userlang );
		$tpl->set( 'dir', $userdir );

		// Title
		$tpl->set( 'title', $out->getPageTitle() );
		$tpl->set( 'pagetitle', $out->getHTMLTitle() );

		// Scriptpath (Used for search and forms)
		$tpl->setRef( 'wgScript', $wgScript );

		// Mobile stuff
		$tpl->setRef( 'mobilelogopath', $wgMobileFrontend2Logo );

		# Add a <div class="mw-content-ltr/rtl"> around the body text
		# not for special pages or file pages AND only when viewing AND if the page exists
		# (or is in MW namespace, because that has default content)
		if( !in_array( $title->getNamespace(), array( NS_SPECIAL, NS_FILE ) ) &&
			in_array( $request->getVal( 'action', 'view' ), array( 'view', 'historysubmit' ) ) &&
			( $title->exists() || $title->getNamespace() == NS_MEDIAWIKI ) ) {
			$pageLang = $title->getPageLanguage();
			$realBodyAttribs = array( 'lang' => $pageLang->getHtmlCode(), 'dir' => $pageLang->getDir(),
				'class' => 'mw-content-'.$pageLang->getDir() );
			$out->mBodytext = Html::rawElement( 'div', $realBodyAttribs, $out->mBodytext );
		}

		$tpl->setRef( 'bodycontent', MobileFrontend2_PostParse::mangle( $out->mBodytext ) );

		// CSS & JS
		// Make these last
		$tpl->set( 'headscripts', $this->getHeadScripts( $out ) );
		$tpl->set( 'csslinks', $out->buildCssLinks() );
		$tpl->set( 'bottomscripts', $this->bottomScripts() );

		// Debug comments and stuff
		$tpl->set( 'debughtml', $this->generateDebugHTML() );


		// Output
		$res = $tpl->execute();
		// result may be an error
		$this->printOrError( $res );
	}

	/**
	 * Skin CSS
	 *
	 * @param OutputPage $out
	 */
	function setupSkinUserCss( OutputPage $out ) {
		$out->addModuleStyles( 'ext.mobileFrontend2.common' );
	}

	/**
	 * We're too cool for edit links, don't output them. Instead, output the
	 * section toggle button.
	 *
	 * @param Title $nt
	 * @param $section
	 * @param null $tooltip
	 * @param bool $lang
	 * @return string
	 */
	public function doEditSectionLink( Title $nt, $section, $tooltip = null, $lang = false ) {
		return '<button>' . wfMessage( 'mobile-frontend2-show-button' )->escaped() .  '</button>';
	}

	/**
	 * More minimal version of getHeadScripts from OutputPage
	 *
	 * @param OutputPage $out
	 * @return string
	 */
	protected function getHeadScripts( OutputPage $out ) {
		$scripts = $out->makeResourceLoaderLink( 'startup', ResourceLoaderModule::TYPE_SCRIPTS, true, array( 'mobile' => true ) );

		$scripts .= Html::inlineScript(
			ResourceLoader::makeLoaderConditionalScript(
				ResourceLoader::makeConfigSetScript( $out->getJSVars() )
			)
		);

		return $scripts;
	}
}

class MobileTemplate extends BaseTemplate {

	/**
	 * Main function, used by classes that subclass QuickTemplate
	 * to show the actual HTML output
	 */
	public function execute() {
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html lang="<?php $this->text( 'lang' ) ?>" dir="<?php $this->text( 'dir' ) ?>" xml:lang="<?php $this->text( 'lang' ) ?>" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php $this->text( 'pagetitle' ) ?></title>

		<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
		<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php $this->html( 'csslinks' ) ?>
		<?php $this->html( 'headscripts' ) ?>
	</head>
	<body>

	<?php if ( !MobileFrontend2_Options::getHideSearch() ): ?>
	<!-- search/header -->
	<div id="results"></div>
	<div id="header">
		<div id="searchbox">
			<?php if ( !MobileFrontend2_Options::getHideLogo() ): ?>
			<img src="<?php $this->text( 'mobilelogopath' ) ?>" alt="Logo" id="logo" width="35" height="22" />
			<?php endif ?>
			<form action="<?php $this->text( 'wgScript' ) ?>" class="search_bar" method="get">
				<input type="hidden" name="title" value="Special:Search" />

				<div id="sq" class="divclearable">
					<input type="text" name="search" id="search" size="22" value="" autocorrect="off" autocomplete="off" autocapitalize="off" maxlength="1024" />
					<div class="clearlink" id="clearsearch"></div>
				</div>
				<button id="goButton" type="submit"></button>
			</form>
		</div>
	</div>
	<?php endif ?>

	<!-- content -->
	<div class="show" id="content_wrapper">
		<!-- firstHeading -->
		<h1 id="firstHeading" class="firstHeading">
			<span dir="auto"><?php $this->html( 'title' ) ?></span>
		</h1>
		<!-- /firstHeading -->
		<!-- bodyContent -->
		<div id="bodyContent">
			<?php $this->html( 'bodycontent' ) ?>
			<!-- debughtml -->
			<?php $this->html( 'debughtml' ); ?>
			<!-- /debughtml -->
		</div>
		<!-- /bodyContent -->
	</div>

	<?php if ( !MobileFrontend2_Options::getHideFooter() ): ?>
	<!-- footer -->
	<div id="footer">
		<div class="nav" id="footmenu">
			<div class="mwm-notice">
				<a href="#"><?php $this->msg( 'mobile-frontend2-regular-site' ) ?></a> | <a href="#"><?php $this->msg( 'mobile-frontend2-disable-images' ) ?></a>

				<div id="perm">
					<a href="#"><?php $this->msg( 'mobile-frontend2-perm-stop-redirect' ) ?></a>
				</div>
			</div>
			<div id="copyright">
				<?php $this->msg( 'mobile-frontend2-copyright' ) ?>
			</div>
		</div>
	</div>
	<?php endif ?>

	<?php $this->html( 'bottomscripts' ) ?>

	</body>
	</html>
<?php
	}
}