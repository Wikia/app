<section class="AdminDashboard" id="AdminDashboard">
	<section class="admin-dashboard-content ">
		<div id="AdminDashboardGeneral" style="display:<?= $tab == 'general' ? 'block' : 'none'?>">
			<section class="control-section wiki">
				<header>
					<h1><?= wfMessage( "admindashboard-controls-wiki-header" )->escaped(); ?></h1><span class="dashboard-tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-theme-designer-tooltip" )->escaped(); ?>">
						<a href="<?= $urlThemeDesigner ?>" class="set" data-tracking="theme-designer">
							<span class="representation">
								<span class="icon themedesigner"></span>
							</span>
							<?= wfMessage( "admindashboard-control-theme-designer-label" )->escaped(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-recent-changes-tooltip" )->escaped(); ?>">
						<a href="<?= $urlRecentChanges ?>" class="set" data-tracking="recent-chagnes">
							<span class="representation">
								<span class="icon recentchanges"></span>
							</span>
							<?= wfMessage( "admindashboard-control-recent-changes-label" )->escaped(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-top-navigation-tooltip" )->escaped(); ?>">
						<a href="<?= $urlTopNavigation ?>" class="set" data-tracking="top-navigation">
							<span class="representation">
								<span class="icon topnavigation"></span>
							</span>
							<?= wfMessage( "admindashboard-control-top-navigation-label" )->escaped(); ?>
						</a>
					</li>
					<? if ($displayWikiFeatures) { ?>
						<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-wiki-features-tooltip" )->escaped(); ?>">
							<a href="<?= $urlWikiFeatures ?>" class="set" data-tracking="wiki-features">
								<span class="representation">
									<span class="icon wikifeatures"></span>
								</span>
								<?= wfMessage( "admindashboard-control-wiki-features-label" )->escaped(); ?>
							</a>
						</li>
					<? } ?>
					<? if ($displaySpecialCss) { ?>
						<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-special-css-tooltip" )->escaped(); ?>">
							<a href="<?= $urlSpecialCss ?>" class="set" data-tracking="special-css">
								<span class="representation">
									<span class="icon specialcsstool"></span>
								</span>
								<?= wfMessage( "admindashboard-control-special-css-label" )->escaped(); ?>
							</a>
						</li>
					<? } ?>
				</ul>
			</section>
			<section class="control-section community">
				<header>
					<h1><?= wfMessage( "admindashboard-controls-community-header" )->escaped(); ?></h1><span class="dashboard-tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-user-list-tooltip" )->escaped(); ?>">
						<a href="<?= $urlListUsers ?>" class="set" data-tracking="user-list">
							<span class="representation">
								<span class="icon userlist"></span>
							</span>
							<?= wfMessage( "admindashboard-control-user-list-label" )->escaped(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-user-rights-tooltip" )->escaped(); ?>">
						<a href="<?= $urlUserRights ?>" class="set" data-tracking="user-rights">
							<span class="representation">
								<span class="icon userrights"></span>
							</span>
							<?= wfMessage( "admindashboard-control-user-rights-label" )->escaped(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-community-corner-tooltip" )->escaped(); ?>">
						<a href="<?= $urlCommunityCorner ?>" class="set" data-tracking="community-corner">
							<span class="representation">
								<span class="icon communitycorner"></span>
							</span>
							<?= wfMessage( "admindashboard-control-community-corner-label" )->escaped(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-help-tooltip" )->escaped(); ?>">
						<a href="<?= wfMessage( 'admindashboard-control-help-url' )->escaped(); ?>" class="set" data-tracking="help">
							<span class="representation">
								<span class="icon help"></span>
							</span>
							<?= wfMessage( "admindashboard-control-help-label" )->escaped(); ?>
						</a>
					</li>
					<!--
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-group-rights-tooltip" )->escaped(); ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMessage( "admindashboard-control-group-rights-label" )->escaped(); ?>
					</li>
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-invite-tooltip" )->escaped(); ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMessage( "admindashboard-control-invite-label" )->escaped(); ?>
					</li>
					-->
				</ul>
			</section>
			<section class="control-section content">
				<header>
					<h1><?= wfMessage( "admindashboard-controls-content-header" )->escaped(); ?></h1><span class="dashboard-tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-categories-list-tooltip" )->escaped(); ?>">
						<a href="<?= $urlAllCategories ?>" class="set" data-tracking="categories">
							<span class="representation">
								<span class="icon categories"></span>
							</span>
							<?= wfMessage( "admindashboard-control-categories-list-label" )->escaped(); ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-add-page-tooltip" )->escaped() ?>" data-modal="AddPage">
						<a href="<?= $urlAddPage ?>" class="set" data-tracking="add-page">
							<span class="representation">
								<span class="icon addpage"></span>
							</span>
							<?= wfMessage( "admindashboard-control-add-page-label" )->escaped() ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-add-photo-tooltip" )->escaped() ?>" data-modal="AddPhoto">
						<a href="<?= $urlAddPhoto ?>" class="set" data-tracking="add-photo">
							<span class="representation">
								<span class="icon addphoto"></span>
							</span>
							<?= wfMessage( "admindashboard-control-add-photo-label" )->escaped() ?>
						</a>
					</li>
					<? if( $showVideoLink ) { ?>
						<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-add-video-tooltip" )->escaped() ?>">
							<a href="<?= $urlAddVideo ?>" class="set addVideoButton" data-return-url="<?= $urlAddVideoReturnUrl ?>" data-tracking="add-video">
								<span class="representation">
									<span class="icon addvideo"></span>
								</span>
								<?= wfMessage( "admindashboard-control-add-video-label" )->escaped() ?>
							</a>
						</li>
					<? } ?>
					<? if( $showNewBlogLink ) { ?>
						<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-add-blog-tooltip" )->escaped() ?>">
							<a href="<?= $urlCreateBlogPage ?>" class="set" data-tracking="create-blog">
								<span class="representation">
									<span class="icon createblog"></span>
								</span>
								<?= wfMessage( "admindashboard-control-add-blog-label" )->escaped() ?>
							</a>
						</li>
					<? } ?>
					<li class="control" data-tooltip="<?= wfMessage( "admindashboard-control-multiple-upload-tooltip" )->escaped() ?>">
						<a href="<?= $urlMultipleUpload ?>" class="set" data-tracking="multiple-upload">
							<span class="representation">
								<span class="icon multipleupload"></span>
							</span>
							<?= wfMessage( "admindashboard-control-multiple-upload-label" )->escaped() ?>
						</a>
					</li>
				</ul>
			</section>
		</div>
		<section id="AdminDashboardAdvanced" style="display:<?= $tab == 'advanced' ? 'block' : 'none'?>">
			<?= $advancedSection ?>
		</section>
		<section id="AdminDashboardContentArea">
			<?= wfMessage( 'admindashboard-loading' )->escaped() ?>
		</section>
	</section>
</section>
