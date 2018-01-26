<?= $header ?>
<section id="WikiaPage" class="WikiaPage">
	<article id="WikiaMainContent" class="WikiaMainContent">
		<!--<header id="EditPageHeader" class="EditPageHeader">-->
		<!--	<span class="wordmark --><?//= $wordmark['wordmarkSize'] ?><!-- --><?//= $wordmark['wordmarkType'] ?><!-- font---><?//= $wordmark['wordmarkFont'] ?><!--">-->
		<!--		<a accesskey="z" href="--><?//= htmlspecialchars($wordmark['mainPageURL']) ?><!--" title="--><?//= htmlspecialchars($wordmark['wordmarkText']) ?><!--">-->
		<!--			--><?php //if ( !empty( $wordmark['wordmarkUrl'] ) ): ?>
		<!--				<img src="--><?//= $wordmark['wordmarkUrl'] ?><!--" alt="--><?//= htmlspecialchars($wordmark['wordmarkText']) ?><!--">-->
		<!--			--><?php //elseif ( mb_substr( $wordmark['wordmarkText'], 0, 10 ) == $wordmark['wordmarkText'] ): ?>
		<!--					--><?//= htmlspecialchars( $wordmark['wordmarkText'] ) ?>
		<!--			--><?php //else: ?>
		<!--				--><?//= htmlspecialchars( mb_substr( $wordmark['wordmarkText'], 0, 10 ) ) . '&hellip;' ?>
		<!--			--><?php //endif ?>
		<!--		</a>-->
		<!--	</span>-->
		<!--	<h2>--><?//= $editing ?><!--</h2>-->
		<!--	<h1>-->
		<!--		<a href="--><?//= htmlspecialchars($title->getLocalUrl()) ?><!--" class="--><?//= $hideTitle ? 'hiddenTitle' : '' ?><!--" title="--><?//= htmlspecialchars($titleText) ?><!--">--><?//= htmlspecialchars($titleText) ?><!--</a>-->
		<!--	</h1>-->
		<!--	<a id="EditPageTitle" class="EditPageTitle" title="--><?//= wfMessage('editpagelayout-edit-title')->escaped() ?><!--">-->
		<!--		<img class="sprite edit-pencil-small" src="--><?//= $wg->BlankImgUrl ?><!--">-->
		<!--	</a>-->
		<!--	--><?php //if ( !empty( $extraHeaderHtml ) ) : ?>
		<!--		<div class="editpage-extra-header-html">-->
		<!--			--><?//= $extraHeaderHtml ?>
		<!--		</div>-->
		<!--	--><?php //endif; ?>
		<!--	<nav id="EditPageTabs" class="EditPageTabs editpage-tabs" data-space-type="tabs" data-space-autoshow="true"></nav>-->
		<!--	<aside id="HelpLink" class="HelpLink">--><?//= $helpLink ?><!--</aside>-->
		<!--	<aside id="NotificationsLink" class="NotificationsLink"><a href="#">--><?//= $notificationsLink ?><!--</a></aside>-->
		<!--</header>-->
		<?= $app->renderView( 'CommunityHeaderService', 'index' ) ?>
		<?= $app->renderView('Wikia\PageHeader\PageHeader', 'index') ?>
		<nav id="EditPageTabs" class="EditPageTabs editpage-tabs" data-space-type="tabs" data-space-autoshow="true"></nav>
		<form id="editform" class="editform" name="editform" method="post" action="<?= htmlspecialchars($editFormAction) ?>" enctype="multipart/form-data">
			<section id="EditPage" class="EditPage">
				<div id="EditPageMain" class="EditPageMain">
					<div id="EditPageMainContainer" class="EditPageMainContainer">
						<div id="EditPageToolbar" class="EditPageToolbar editpage-toolbar" data-space-type="toolbar"></div>
						<div id="EditPageEditorWrapper" class="EditPageEditorWrapper <?= empty($editPagePreloads) ? 'noPreloads' : 'hasPreloads' ?>" data-space-type="editor">
							<div id="EditPageEditor" class="EditPageEditor editpage-content">
								<!-- basic support for users with JS disabled -->
								<noscript>
									<style>
										.editpage-notices {
											display: block;
										}

										#EditPageCallbackFields {
											display: block !important;
										}
									</style>
								</noscript>
								<div class="editpage-notices" data-space-type="notices-short">
									<span class="splotch"><?= count($notices) ?></span>
									<ul>
										<?php foreach ( $notices as $hash => $notice ): ?>
											<li class="notice-item" data-hash="<?= $hash ?>"><?= $notice ?></li>
										<?php endforeach ?>
									</ul>
								</div>
								<div class="editpage-notices-html" data-space-type="notices-html" style="display:none"><?= $noticesHtml?></div>
								<?php if ( !empty( $editPagePreloads ) ): ?>
									<?php foreach( $editPagePreloads as $preloadId => $preload ): ?>
										<div id="<?= $preloadId ?>" class="editpage-intro">
											<div class="editpage-intro-wrapper">
												<div class="<?= $preload['class'] ?>">
													<?= $preload['content'] ?>
												</div>
											</div>
											<a class="expand">
												<label><?= wfMessage('editpagelayout-more')->escaped() ?></label>
												<span>+</span>
											</a>
										</div>
									<?php endforeach ?>
								<?php endif ?>
								<!-- edit form content -->
								<?= $bodytext ?>
							</div>
						</div>
					</div>
				</div>
				<div class="editpage-widemode-trigger">
					<span class="arrow"></span>
				</div>
				<div id="EditPageRail" class="EditPageRail editpage-rail" data-space-type="rail">
					<noscript>
						<style>
							.module_page_controls .wikia-menu-button {
								display: none;
							}
						</style>
					</noscript>
					<div class="module module_page_controls">
						<div class="module_content">
							<div class="wpSummaryFields">
								<div class="checkboxes">
									<?php foreach ( $customCheckboxes as $i => $checkbox ): ?>
										<label class="<?= $checkbox['name'] ?>">
											<input type="checkbox" name="<?= $checkbox['name'] ?>" tabindex="<?= $i + 2 ?>" id="<?= $checkbox['name'] ?>" <?= $checkbox['checked'] ? ' checked="checked"' : '' ?> />
											<?= $checkbox['label'] ?>
										</label>
									<?php endforeach ?>
									<?php if ( $canMinorEdit ): ?>
										<label class="wpMinoredit">
											<input type="checkbox" tabindex="21" name="wpMinoredit" id="wpMinoredit" accesskey="<?=wfMessage('accesskey-minoredit')->escaped() ;?>"<?= $minorEditCheckbox ? ' checked="checked"' : '' ?> />
											<span><?= wfMessage('editpagelayout-pageControls-minorEdit')->escaped() ?></span>
										</label>
									<?php endif ?>
								</div>
								<label <?php if ( $canMinorEdit ): ?>class="wpSummary_canMinorEdit"<?php endif ?> for="wpSummary"><?= $wpSummaryLabelText ?></label>
								<div id="wpSummaryLabel">
									<?= $summaryBox ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</form>
	</article>

	<? if ( $isLoggedIn ): ?>
		<?php if ( !$wg->EnableWikiaBarExt ): ?>
			<footer id="WikiaFooter" class="WikiaFooter">
				<div class="toolbar">
					<ul class="tools">
						<?= $app->renderView('Footer','Toolbar') ?>
					</ul>
					<img src="<?= $wg->BlankImgUrl; ?>" class="banner-corner-left" height="0" width="0">
					<img src="<?= $wg->BlankImgUrl; ?>" class="banner-corner-right" height="0" width="0">
				</div>
			</footer>
		<?php endif ?>
	<? endif ?>
</section>

<?php if( $wg->EnableWikiaBarExt ): ?>
	<?= $app->renderView('WikiaBar', 'Index') ?>
<?php endif ?>
