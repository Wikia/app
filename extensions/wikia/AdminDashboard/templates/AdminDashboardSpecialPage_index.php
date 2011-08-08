<section class="AdminDashboard" id="AdminDashboard">
	<section class="admin-dashboard-content ">
		<div id="AdminDashboardGeneral" style="display:<?= $tab == 'general' ? 'block' : 'none'?>">
			<section class="control-section wiki">
				<header>
					<h1><?= wfMsg("admindashboard-controls-wiki-header") ?></h1><span class="dashboard-tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-theme-designer-tooltip") ?>">
						<a href="<?= $urlThemeDesigner ?>" class="set" data-tracking="general/themedesigner">
							<span class="representation">
								<span class="icon themedesigner"></span>
							</span>
							<?= wfMsg("admindashboard-control-theme-designer-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-recent-changes-tooltip") ?>" data-control="RecentChanges">
						<a href="<?= $urlRecentChanges ?>" class="set" data-tracking="general/recentchagnes">
							<span class="representation">
								<span class="icon recentchanges"></span>
							</span>
							<?= wfMsg("admindashboard-control-recent-changes-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-top-navigation-tooltip") ?>">
						<a href="<?= $urlTopNavigation ?>" class="set" data-tracking="general/topnavigation">
							<span class="representation">
								<span class="icon topnavigation"></span>
							</span>
							<?= wfMsg("admindashboard-control-top-navigation-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-wikia-labs-tooltip") ?>">
						<a href="<?= $urlWikiaLabs ?>" class="set" data-tracking="general/wikialabs">
							<span class="representation">
								<span class="icon wikialabs"></span>
							</span>
							<?= wfMsg("admindashboard-control-wikia-labs-label") ?>
						</a>
					</li>
					<? if ($displayPageLayoutBuilder) { ?>
						<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-page-layout-builder-tooltip") ?>">
							<a href="<?= $urlPageLayoutBuilder ?>" class="set" data-tracking="general/pagelayoutbuilder">
								<span class="representation">
									<span class="icon pagelayoutbuilder"></span>
								</span>
								<?= wfMsg("admindashboard-control-page-layout-builder-label") ?>
							</a>
						</li>
					<? } ?>
				</ul>
			</section>
			<section class="control-section community">
				<header>
					<h1><?= wfMsg("admindashboard-controls-community-header") ?></h1><span class="dashboard-tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-user-list-tooltip") ?>" data-control="ListUsers">
						<a href="<?= $urlListUsers ?>" class="set" data-tracking="general/userlist">
							<span class="representation">
								<span class="icon userlist"></span>
							</span>
							<?= wfMsg("admindashboard-control-user-list-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-user-rights-tooltip") ?>" data-control="UserRights">
						<a href="<?= $urlUserRights ?>" class="set" data-tracking="general/userrights">
							<span class="representation">
								<span class="icon userrights"></span>
							</span>
							<?= wfMsg("admindashboard-control-user-rights-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-community-corner-tooltip") ?>">
						<a href="<?= $urlCommunityCorner ?>" class="set" data-tracking="general/communitycorner">
							<span class="representation">
								<span class="icon communitycorner"></span>
							</span>
							<?= wfMsg("admindashboard-control-community-corner-label") ?>
						</a>
					</li>
					<!--
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-group-rights-tooltip") ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMsg("admindashboard-control-group-rights-label") ?>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-invite-tooltip") ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMsg("admindashboard-control-invite-label") ?>
					</li>
					-->
				</ul>
			</section>
			<section class="control-section content">
				<header>
					<h1><?= wfMsg("admindashboard-controls-content-header") ?></h1><span class="dashboard-tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-categories-list-tooltip") ?>" data-control="Categories">
						<a href="<?= $urlAllCategories ?>" class="set" data-tracking="general/categories">
							<span class="representation">
								<span class="icon categories"></span>
							</span>
							<?= wfMsg("admindashboard-control-categories-list-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-add-page-tooltip") ?>" data-modal="AddPage">
						<a href="<?= $urlAddPage ?>" class="set" data-tracking="general/addpage">
							<span class="representation">
								<span class="icon addpage"></span>
							</span>
							<?= wfMsg("admindashboard-control-add-page-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-add-photo-tooltip") ?>" data-modal="AddPhoto">
						<a href="<?= $urlAddPhoto ?>" class="set" data-tracking="general/addphoto">
							<span class="representation">
								<span class="icon addphoto"></span>
							</span>
							<?= wfMsg("admindashboard-control-add-photo-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-add-blog-tooltip") ?>">
						<a href="<?= $urlCreateBlogPage ?>" class="set" data-tracking="general/createblog">
							<span class="representation">
								<span class="icon createblog"></span>
							</span>
							<?= wfMsg("admindashboard-control-add-blog-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("admindashboard-control-multiple-upload-tooltip") ?>" data-control="MultipleUpload">
						<a href="<?= $urlMultipleUpload ?>" class="set" data-tracking="general/multipleupload">
							<span class="representation">
								<span class="icon multipleupload"></span>
							</span>
							<?= wfMsg("admindashboard-control-multiple-upload-label") ?>
						</a>
					</li>
				</ul>
			</section>
		</div>
		<section id="AdminDashboardAdvanced" style="display:<?= $tab == 'advanced' ? 'block' : 'none'?>">
			<?= $advancedSection ?>
		</section>
		<section id="AdminDashboardContentArea">
			Loading...
		</section>
	</section>
</section>