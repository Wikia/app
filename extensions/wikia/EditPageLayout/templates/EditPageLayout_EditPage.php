<?= $header ?>
<section id="WikiaPage" class="WikiaPage">
	<article id="WikiaMainContent" class="WikiaMainContent">
		<header id="EditPageHeader" class="EditPageHeader">
			<span class="wordmark <?= $wordmark['wordmarkSize'] ?> <?= $wordmark['wordmarkType'] ?> font-<?= $wordmark['wordmarkFont'] ?>">
				<a accesskey="z" href="<?= htmlspecialchars($wordmark['mainPageURL']) ?>" title="<?= htmlspecialchars($wordmark['wordmarkText']) ?>">
					<?php if ( !empty( $wordmark['wordmarkUrl'] ) ): ?>
						<img src="<?= $wordmark['wordmarkUrl'] ?>" alt="<?= htmlspecialchars($wordmark['wordmarkText']) ?>">
					<?php elseif ( mb_substr( $wordmark['wordmarkText'], 0, 10 ) == $wordmark['wordmarkText'] ): ?>
							<?= htmlspecialchars( $wordmark['wordmarkText'] ) ?>
					<?php else: ?>
						<?= htmlspecialchars( mb_substr( $wordmark['wordmarkText'], 0, 10 ) ) . '&hellip;' ?>
					<?php endif ?>
				</a>
			</span>
			<h2><?= $editing ?></h2>
			<h1>
				<a href="<?= htmlspecialchars($title->getLocalUrl()) ?>" class="<?= $hideTitle ? 'hiddenTitle' : '' ?>" title="<?= htmlspecialchars($titleText) ?>"><?= htmlspecialchars($titleText) ?></a>
			</h1>
			<a id="EditPageTitle" class="EditPageTitle" title="<?= wfMessage('editpagelayout-edit-title')->escaped() ?>">
				<img class="sprite edit-pencil-small" src="<?= $wg->BlankImgUrl ?>">
			</a>
			<?php if ( !empty( $extraHeaderHtml ) ) : ?>
				<div class="editpage-extra-header-html">
					<?= $extraHeaderHtml ?>
				</div>
			<?php endif; ?>
			<nav id="EditPageTabs" class="EditPageTabs editpage-tabs" data-space-type="tabs" data-space-autoshow="true"></nav>
			<aside id="HelpLink" class="HelpLink"><?= $helpLink ?></aside>
			<aside id="NotificationsLink" class="NotificationsLink"><a href="#"><?= $notificationsLink ?></a></aside>
		</header>

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
							<?php if ( $showMobilePreview ): ?>
								<div class="preview_box">
									<h3 class="preview-header"><?= wfMessage( 'preview' )->escaped() ?></h3>
									<a id="wpPreviewMobile" class="preview_mobile preview_icon" href="#">
										<svg xmlns="http://www.w3.org/2000/svg" version="1.0" x="0px" y="0px" viewBox="0 0 32 48" xml:space="preserve">
											<path d="M28 0C26.5 0 5.4 0 4 0C2.1 0 0 2.2 0 4c0 37.9 0 2.6 0 40c0 2 2.2 4 4 4c2 0 22.2 0 24 0 c1.8 0 3.9-2 3.9-4C31.9 30.2 32 5.2 32 4C32 1.9 29.8 0 28 0z M16 46c-1.1 0-2-0.9-2-2c0-1.1 0.9-2 2-2s2 0.9 2 2 C18 45.1 17.1 46 16 46z M28 40H4c0 0 0-25.7 0-36c7.1 0 24 0 24 0V40z"/>
										</svg>
										<p><?= wfMessage('editpagelayout-preview-label-mobile')->escaped() ?></p>
									</a>
									<a accesskey="e" id="wpPreview" class="preview_desktop preview_icon" href="#">
										<svg xmlns="http://www.w3.org/2000/svg" version="1.0" x="0px" y="0px" viewBox="0 0 48 40" xml:space="preserve">
											<path d="M48 34V0H0.1L0 34h18v4h-8v2h28v-2c0 0-8 0.3-8 0v-4H48z M2 30 V2h44v28H2z"/>
										</svg>
										<p><?= wfMessage('editpagelayout-preview-label-desktop')->escaped() ?></p>
									</a>
								</div>
							<?php endif ?>
							<nav class="buttons">
								<?php if ( $showPreview ): ?>
									<?= $app->renderView( 'EditPageLayout', 'Buttons', [ 'showMobilePreview' => $showMobilePreview ]); ?>
								<?php else: ?>
									<?= $app->renderView( 'EditPageLayout', 'CodeButtons'); ?>
								<?php endif ?>
							</nav>
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
