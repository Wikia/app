<?php

/**
 * SkinTemplate class for p2wiki skin
 * @ingroup Skins
 */
class SkinP2wiki extends SkinTemplate {

	/* Functions */
	var $template = 'P2wikiTemplate', $useHeadElement = true;

	function __construct() {
		$this->skinname = $this->stylename = basename(dirname(__FILE__));
	}

	/**
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ){
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( "skins.{$this->stylename}" );
	}


}

/**
 * QuickTemplate class for p2wiki skin
 * @ingroup Skins
 */
class P2wikiTemplate extends BaseTemplate {

	/* Members */

	/**
	 * @var Cached skin object
	 */
	var $skin;

	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		global $wgRequest, $wgLang;

		$skin = $this->skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		// Generate additional footer links
		$footerlinks = $this->data["footerlinks"];

		// Reduce footer links down to only those which are being used
		$validFooterLinks = array();
		foreach( $footerlinks as $category => $links ) {
			$validFooterLinks[$category] = array();
			foreach( $links as $link ) {
				if( isset( $this->data[$link] ) && $this->data[$link] ) {
					$validFooterLinks[$category][] = $link;
				}
			}
		}

		// Generate additional footer icons
		$footericons = $this->data["footericons"];
		// Unset any icons which don't have an image
		foreach ( $footericons as $footerIconsKey => &$footerIconsBlock ) {
			foreach ( $footerIconsBlock as $footerIconKey => $footerIcon ) {
				if ( !is_string($footerIcon) && !isset($footerIcon["src"]) ) {
					unset($footerIconsBlock[$footerIconKey]);
				}
			}
		}
		// Redo removal of any empty blocks
		foreach ( $footericons as $footerIconsKey => &$footerIconsBlock ) {
			if ( count($footerIconsBlock) <= 0 ) {
				unset($footericons[$footerIconsKey]);
			}
		}

		$isWide = false;
		if ( $this->skin->getTitle()->getNamespace() == NS_SPECIAL )
			$isWide = "extrawide";
		elseif ( $action == "edit" )
			$isWide = "wide";

		// Output HTML Page
		$this->html( 'headelement' ); ?>
<div id="header"<?php if ( $isWide ) { ?> class="<?php echo $isWide; ?>"<?php } ?>>

	<div class="sleeve">
		<h1><a href="<?php echo htmlspecialchars($this->data['nav_urls']['mainpage']['href']) ?>"><?php echo htmlspecialchars($GLOBALS["wgSitename"]); ?></a></h1>
		<small><?php $this->msg( 'tagline' ) ?></small>
		<a class="secondary" href="<?php echo htmlspecialchars($this->data['nav_urls']['mainpage']['href']) ?>"></a>
	</div>

	<div class="sleeve sleeve_personal"<?php $this->html('userlangattributes') ?>>
<?php
		$first = true;
	 	foreach($this->data['personal_urls'] as $key => $item) {
			if ( !$first ) {
				echo ' | ';
			}
			$first = false; ?>
		<span id="<?php echo Sanitizer::escapeId( "pt-$key" ) ?>"<?php
			if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php
		echo htmlspecialchars($item['href']) ?>"<?php echo $skin->tooltipAndAccesskey('pt-'.$key) ?><?php
		if(!empty($item['class'])) { ?> class="<?php
		echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
		echo htmlspecialchars($item['text']) ?></a></span>
<?php	} ?>
	</div>

</div>

<div id="wrapper"<?php if ( $isWide ) { ?> class="<?php echo $isWide; ?>"<?php } ?>>
	<div id="sidebar">
		<ul>
			<li id='p-search'<?php echo $this->skin->tooltip('p-search') ?>>
				<h2><label for="searchInput"><?php $this->msg('search') ?></label></h2>
				<form role="search" id="searchform" action="<?php $this->text('wgScript') ?>">
					<input type='hidden' name="title" value="<?php $this->text('searchtitle') ?>"/>
					<div>
<?php
						echo Html::input( 'search',
							isset( $this->data['search'] ) ? $this->data['search'] : '', 'search',
							array(
								'id' => 'search-for',
								'title' => $this->skin->titleAttrib( 'search' ),
								'accesskey' => $this->skin->accesskey( 'search' )
							) ); ?>
						<input type='submit' name="go" id="searchsubmit" value="<?php $this->msg('searcharticle') ?>"<?php echo $this->skin->tooltipAndAccesskey( 'search-go' ); ?> />
					</div>
				</form>
			</li>
<?php
	$sidebar = $this->data['sidebar'];
	unset($sidebar['SEARCH']); // we always display this at the top
	if ( !isset( $sidebar['TOOLBOX'] ) ) $sidebar['TOOLBOX'] = true;
	if ( !isset( $sidebar['LANGUAGES'] ) ) $sidebar['LANGUAGES'] = true;
	foreach ($sidebar as $boxName => $cont) {
		if ( $boxName == 'TOOLBOX' ) { ?>
			<li>
				<h2><?php $this->msg('toolbox') ?></h2>
				<ul>
<?php
			foreach ( $this->getToolbox() as $key => $tbitem ): ?>
					<?php echo $this->makeListItem($key, $tbitem); ?>

<?php
			endforeach;
			wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) );
?>
				</ul>
			</li>
<?php
		} elseif ( $boxName == 'LANGUAGES' ) {
			if( $this->data['language_urls'] ) { ?>
			<li>
				<h2<?php $this->html('userlangattributes') ?>><?php $this->msg('otherlanguages') ?></h2>
				<ul>
<?php
				foreach($this->data['language_urls'] as $key => $langlink): ?>
					<?php echo $this->makeListItem($key, $langlink); ?>

<?php
				endforeach; ?>
				</ul>
			</li>
<?php
			}
		} else { ?>
			<li id='<?php echo Sanitizer::escapeId( "p-$boxName" ) ?>'<?php echo $this->skin->tooltip('p-'.$boxName) ?>>
				<h2><?php $out = wfMsg( $boxName ); if (wfEmptyMsg($boxName, $out)) echo htmlspecialchars($boxName); else echo htmlspecialchars($out); ?></h2>
<?php
				if ( is_array( $cont ) ): ?>
				<ul>
<?php
	 				foreach($cont as $key => $val): ?>
					<?php echo $this->makeListItem($key, $val); ?>

<?php
					endforeach; ?>
				</ul>
<?php
				else:
					# allow raw HTML block to be defined by extensions
					print $cont;
				endif; ?>
			</li>
<?php
				}
			} ?>
		</ul>

		<div class="visualClear"></div>

	</div> <!-- // sidebar -->

<div class="sleeve_main">

	<div id="main">
		<?php if ( $this->data['sitenotice'] ): ?>
		<div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
		<?php endif; ?>

		<h2>
			<?php $this->html( 'title' ) ?>
			<span class="controls"<?php $this->html('userlangattributes') ?>>
			<?php
				$first = true;
				foreach($this->data['content_actions'] as $key => $tab) {
					if ( $key != $this->skin->getTitle()->getNamespaceKey() && $key != "talk" ) {
						continue;
					}
					if ( !$first ) {
						echo ' | ';
					}
					$first = false;
					echo '
				 <a id="' . Sanitizer::escapeId( "ca-$key" ) . '"';
					if( $tab['class'] ) {
						echo ' class="'.htmlspecialchars($tab['class']).'"';
					}
					echo ' href="'.htmlspecialchars($tab['href']).'"';
				 	if( in_array( $action, array( 'edit', 'submit' ) )
				 	&& in_array( $key, array( 'edit', 'watch', 'unwatch' ))) {
				 		echo $skin->tooltip( "ca-$key" );
				 	} else {
				 		echo $skin->tooltipAndAccesskey( "ca-$key" );
				 	}
				 	echo '>'.htmlspecialchars($tab['text'])."</a>\n";
				} ?>
			</span>
		</h2>

		<div id="bodyContent">
			<div class="actions">
			<?php
				$first = true;
				foreach($this->data['content_actions'] as $key => $tab) {
					if ( $key == $this->skin->getTitle()->getNamespaceKey() || $key == "talk" ) {
						continue;
					}
					if ( !$first ) {
						echo ' | ';
					}
					$first = false;
					echo '
				 <a id="' . Sanitizer::escapeId( "ca-$key" ) . '"';
					if( $tab['class'] ) {
						echo ' class="'.htmlspecialchars($tab['class']).'"';
					}
					echo ' href="'.htmlspecialchars($tab['href']).'"';
				 	if( in_array( $action, array( 'edit', 'submit' ) )
				 	&& in_array( $key, array( 'edit', 'watch', 'unwatch' ))) {
				 		echo $skin->tooltip( "ca-$key" );
				 	} else {
				 		echo $skin->tooltipAndAccesskey( "ca-$key" );
				 	}
				 	echo '>'.htmlspecialchars($tab['text'])."</a>\n";
				} ?>
			</div>
			<div id="content">
				<!-- bodytext -->
				<?php $this->html( 'bodytext' ) ?>
				<!-- /bodytext -->
				<?php if ( $this->data['catlinks'] ): ?>
				<!-- catlinks -->
				<?php $this->html( 'catlinks' ); ?>
				<!-- /catlinks -->
				<?php endif; ?>
				<?php if ( $this->data['dataAfterContent'] ): ?>
				<!-- dataAfterContent -->
				<?php $this->html( 'dataAfterContent' ); ?>
				<!-- /dataAfterContent -->
				<?php endif; ?>
			</div>
			<div class="bottom_of_entry">&#160;</div>
			<div class="visualClear"></div>
		</div>

	</div> <!-- main -->

</div> <!-- sleeve -->

	<div class="visualClear"></div>
</div> <!-- // wrapper -->

<div id="footer"<?php if ( $isWide ) { ?> class="<?php echo $isWide; ?>"<?php } ?><?php $this->html('userlangattributes') ?>>
<?php
	if ( count( $footericons ) > 0 ): ?>
		<p id="footer-icons" class="noprint">
<?php
		foreach ( $footericons as $blockName => $footerIcons ): ?>
			<span id="footer-<?php echo htmlspecialchars($blockName); ?>ico">
<?php
			foreach ( $footerIcons as $icon ): ?>
				<?php echo $this->skin->makeFooterIcon( $icon ); ?>
<?php
			endforeach; ?>
			</span>
<?php
		endforeach; ?>
		</p>
<?php
	endif;
	foreach( $validFooterLinks as $category => $links ):
		if ( count( $links ) > 0 ): ?>
		<p id="footer-<?php echo $category ?>">
<?php
			foreach( $links as $link ):
				if( isset( $this->data[$link] ) && $this->data[$link] ): ?>
			<span id="footer-<?php echo $category ?>-<?php echo $link ?>"><?php $this->html( $link ) ?></span>
<?php
				endif;
			endforeach; ?>
		</p>
<?php
		endif;
	endforeach; ?>
	</p>
	<div class="visualClear"></div>
</div>

		<?php $this->html( 'bottomscripts' ); /* JS call to runBodyOnloadHook */ ?>
		<!-- fixalpha -->
		<script type="<?php $this->text('jsmimetype') ?>"> if ( window.isMSIE55 ) fixalpha(); </script>
		<!-- /fixalpha -->
		<?php $this->html( 'reporttime' ) ?>
		<?php if ( $this->data['debug'] ): ?>
		<!-- Debug output: <?php $this->text( 'debug' ); ?> -->
		<?php endif; ?>
	</body>
</html>
<?php
		wfRestoreWarnings();
	}

}

