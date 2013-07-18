<section class="AdminDashboard" id="AdminDashboard">
	<section class="admin-dashboard-content ">
		<div id="AdminDashboardGeneral" style="display:<?= $tab == 'general' ? 'block' : 'none'?>">
			<section class="control-section wiki">
				<header>
					<h1><?= wfMessage("admindashboard-controls-wiki-header")->text(); ?></h1><span class="dashboard-tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-theme-designer-tooltip")->text(); ?>">
						<a href="<?= $urlThemeDesigner ?>" class="set" data-tracking="general/themedesigner">
							<span class="representation">
								<span class="icon themedesigner"></span>
							</span>
							<?= wfMessage("admindashboard-control-theme-designer-label")->text(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-recent-changes-tooltip")->text(); ?>">
						<a href="<?= $urlRecentChanges ?>" class="set" data-tracking="general/recentchagnes">
							<span class="representation">
								<span class="icon recentchanges"></span>
							</span>
							<?= wfMessage("admindashboard-control-recent-changes-label")->text(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-top-navigation-tooltip")->text(); ?>">
						<a href="<?= $urlTopNavigation ?>" class="set" data-tracking="general/topnavigation">
							<span class="representation">
								<span class="icon topnavigation"></span>
							</span>
							<?= wfMessage("admindashboard-control-top-navigation-label")->text(); ?>
						</a>
					</li>
					<? if ($displayWikiFeatures) { ?>
						<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-wiki-features-tooltip")->text(); ?>">
							<a href="<?= $urlWikiFeatures ?>" class="set" data-tracking="general/wikifeatures">
								<span class="representation">
									<span class="icon wikifeatures"></span>
								</span>
								<?= wfMessage("admindashboard-control-wiki-features-label")->text(); ?>
							</a>
						</li>
					<? } ?>
					<? if ($displayPageLayoutBuilder) { ?>
						<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-page-layout-builder-tooltip")->text(); ?>">
							<a href="<?= $urlPageLayoutBuilder ?>" class="set" data-tracking="general/pagelayoutbuilder">
								<span class="representation">
									<span class="icon pagelayoutbuilder"></span>
								</span>
								<?= wfMessage("admindashboard-control-page-layout-builder-label") ?>
							</a>
						</li>
					<? } ?>
					<? if ($displaySpecialPromote) { ?>
						<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-admin-upload-tool-tooltip")->text(); ?>">
							<a href="<?= $urlGetPromoted ?>" class="set" data-tracking="general/promoteimagetool">
								<span class="representation">
									<span class="icon promoteimagetool"></span>
								</span>
								<?= wfMessage("admindashboard-control-admin-upload-tool-label")->text(); ?>
							</a>
						</li>
					<? } ?>
					<? if ($displaySpecialCss) { ?>
						<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-special-css-tooltip")->text(); ?>">
							<a href="<?= $urlSpecialCss ?>" class="set" data-tracking="general/specialcss">
								<span class="representation">
									<span class="icon specialcsstool"></span>
								</span>
								<?= wfMessage("admindashboard-control-special-css-label")->text(); ?>
							</a>
						</li>
					<? } ?>
				</ul>
			</section>
			<section class="control-section community">
				<header>
					<h1><?= wfMessage("admindashboard-controls-community-header")->text(); ?></h1><span class="dashboard-tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-user-list-tooltip")->text(); ?>">
						<a href="<?= $urlListUsers ?>" class="set" data-tracking="general/userlist">
							<span class="representation">
								<span class="icon userlist"></span>
							</span>
							<?= wfMessage("admindashboard-control-user-list-label")->text(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-user-rights-tooltip")->text(); ?>">
						<a href="<?= $urlUserRights ?>" class="set" data-tracking="general/userrights">
							<span class="representation">
								<span class="icon userrights"></span>
							</span>
							<?= wfMessage("admindashboard-control-user-rights-label")->text(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-community-corner-tooltip")->text(); ?>">
						<a href="<?= $urlCommunityCorner ?>" class="set" data-tracking="general/communitycorner">
							<span class="representation">
								<span class="icon communitycorner"></span>
							</span>
							<?= wfMessage("admindashboard-control-community-corner-label")->text(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-help-tooltip")->text(); ?>">
						<a href="<?= wfMessage('admindashboard-control-help-url')->text(); ?>" class="set" data-tracking="general/help">
							<span class="representation">
								<span class="icon help"></span>
							</span>
							<?= wfMessage("admindashboard-control-help-label")->text(); ?>
						</a>
					</li>
					<!--
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-group-rights-tooltip")->text(); ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMessage("admindashboard-control-group-rights-label")->text(); ?>
					</li>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-invite-tooltip")->text(); ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMessage("admindashboard-control-invite-label")->text(); ?>
					</li>
					-->
				</ul>
			</section>
			<section class="control-section content">
				<header>
					<h1><?= wfMessage("admindashboard-controls-content-header")->text(); ?></h1><span class="dashboard-tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-categories-list-tooltip")->text(); ?>">
						<a href="<?= $urlAllCategories ?>" class="set" data-tracking="general/categories">
							<span class="representation">
								<span class="icon categories"></span>
							</span>
							<?= wfMessage("admindashboard-control-categories-list-label")->text(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-add-page-tooltip")->text() ?>" data-modal="AddPage">
						<a href="<?= $urlAddPage ?>" class="set" data-tracking="general/addpage">
							<span class="representation">
								<span class="icon addpage"></span>
							</span>
							<?= wfMessage("admindashboard-control-add-page-label")->text() ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-add-photo-tooltip")->text() ?>" data-modal="AddPhoto">
						<a href="<?= $urlAddPhoto ?>" class="set" data-tracking="general/addphoto">
							<span class="representation">
								<span class="icon addphoto"></span>
							</span>
							<?= wfMessage("admindashboard-control-add-photo-label")->text() ?>
						</a>
					</li>
					<? if( $showVideoLink ) { ?>
						<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-add-video-tooltip")->text() ?>">
							<a href="<?= $urlAddVideo ?>" class="set addVideoButton" data-return-url="<?= $urlAddVideoReturnUrl ?>" data-tracking="general/addvideo">
								<span class="representation">
									<span class="icon addvideo"></span>
								</span>
								<?= wfMessage("admindashboard-control-add-video-label")->text() ?>
							</a>
						</li>
					<? } ?>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-add-blog-tooltip")->text() ?>">
						<a href="<?= $urlCreateBlogPage ?>" class="set" data-tracking="general/createblog">
							<span class="representation">
								<span class="icon createblog"></span>
							</span>
							<?= wfMessage("admindashboard-control-add-blog-label")->text() ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage("admindashboard-control-multiple-upload-tooltip")->text() ?>">
						<a href="<?= $urlMultipleUpload ?>" class="set" data-tracking="general/multipleupload">
							<span class="representation">
								<span class="icon multipleupload"></span>
							</span>
							<?= wfMessage("admindashboard-control-multiple-upload-label")->text() ?>
						</a>
					</li>
				</ul>
			</section>
		</div>
		<section id="AdminDashboardAdvanced" style="display:<?= $tab == 'advanced' ? 'block' : 'none'?>">
			<?= $advancedSection ?>
		</section>
		<section id="AdminDashboardContentArea">
			<?= wfMessage( 'admindashboard-loading' )->text() ?>
		</section>
	</section>
</section>
