<header class="AdminDashboardHeader" id="AdminDashboardHeader">
	<h1>
		<a href="<?= Sanitizer::encodeAttribute( $adminDashboardUrl ) ?>" data-tracking="header/admindashboard">
			<?= wfMessage( 'admindashboard-header' )->escaped() ?>
		</a>
	</h1>
	<nav class="AdminDashboardTabs<?= $isAdminDashboard ? '' : ' expanded' ?>" id="AdminDashboardTabs">
		<a href="<?= Sanitizer::encodeAttribute( $adminDashboardUrlAdvanced ) ?>" class="tab <?= $tab == 'advanced' ? 'active' : '' ?>" data-section="advanced" data-tracking="header/advanced"><?= wfMessage( 'admindashboard-tab-advanced' )->escaped() ?></a>
		<a href="<?= Sanitizer::encodeAttribute( $adminDashboardUrlGeneral ) ?>" class="tab <?= $tab == 'general' ? 'active' : '' ?>" data-section="general" data-tracking="header/general"><?= wfMessage( 'admindashboard-tab-general' )->escaped() ?></a>
	</nav>
</header>
