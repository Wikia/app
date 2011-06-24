<section class="ControlCenter" id="ControlCenter">
	<section class="control-center-content ">
		<div id="ControlCenterGeneral" style="display:<?= $tab == 'general' ? 'block' : 'none'?>">
			<section class="control-section wiki">
				<header>
					<h1><?= wfMsg("controlcenter-controls-wiki-header") ?></h1><span class="tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-theme-designer-tooltip") ?>">
						<a href="<?= $urlThemeDesigner ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-theme-designer-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-recent-changes-tooltip") ?>" data-control="RecentChanges">
						<a href="<?= $urlRecentChanges ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-recent-changes-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-top-navigation-tooltip") ?>">
						<a href="<?= $urlTopNavigation ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-top-navigation-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-wikia-labs-tooltip") ?>">
						<a href="<?= $urlWikiaLabs ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-wikia-labs-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-page-layout-builder-tooltip") ?>">
						<a href="<?= $urlPageLayoutBuilder ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-page-layout-builder-label") ?>
						</a>
					</li>
				</ul>
			</section>
			<section class="control-section community">
				<header>
					<h1><?= wfMsg("controlcenter-controls-community-header") ?></h1><span class="tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-user-list-tooltip") ?>" data-control="ListUsers">
						<a href="<?= $urlListUsers ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-user-list-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-user-rights-tooltip") ?>" data-control="UserRights">
						<a href="<?= $urlUserRights ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-user-rights-label") ?>
						</a>
					</li>
					<!--
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-group-rights-tooltip") ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMsg("controlcenter-control-group-rights-label") ?>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-invite-tooltip") ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMsg("controlcenter-control-invite-label") ?>
					</li>
					-->
				</ul>
			</section>
			<section class="control-section content">
				<header>
					<h1><?= wfMsg("controlcenter-controls-content-header") ?></h1><span class="tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-community-corner-tooltip") ?>">
						<a href="<?= $urlCommunityCorner ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-community-corner-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-categories-list-tooltip") ?>" data-control="Categories">
						<a href="<?= $urlAllCategories ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-categories-list-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-add-page-tooltip") ?>" data-modal="AddPage">
						<a href="<?= $urlAddPage ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-add-page-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-add-photo-tooltip") ?>" data-modal="AddPhoto">
						<a href="<?= $urlAddPhoto ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-add-photo-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-add-blog-tooltip") ?>">
						<a href="<?= $urlCreateBlogPage ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-add-blog-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-multiple-upload-tooltip") ?>" data-control="MultipleUpload">
						<a href="<?= $urlMultipleUpload ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-multiple-upload-label") ?>
						</a>
					</li>
				</ul>
			</section>
		</div>
		<section id="ControlCenterAdvanced" style="display:<?= $tab == 'advanced' ? 'block' : 'none'?>">
			Advanced section here
		</section>
		<section id="ControlCenterContentArea">
			Loading...
		</section>
	</section>
</section>