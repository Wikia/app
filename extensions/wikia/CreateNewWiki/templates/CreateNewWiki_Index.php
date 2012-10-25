<?php
	$selectedLang = empty($params['wikiLanguage']) ? $wg->LanguageCode : $params['wikiLanguage'];
?>
<section id="CreateNewWiki">
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
	<h1><?= wfMsg('cnw-title') ?></h1>
	<ol class="steps">
		<li id="NameWiki" class="step">
			<h2><?= wfMsg('cnw-name-wiki-headline') ?></h2>
			<p class="creative"><?= wfMsg('cnw-name-wiki-creative') ?></p>
			<form name="label-wiki-form">
				<label for="wiki-name"><?= wfMsg('cnw-name-wiki-label') ?></label>
				<span class="wiki-name-status-icon status-icon"></span>
				<input type="text" name="wiki-name" value="<?= empty($params['wikiName']) ? '' : $params['wikiName'] ?>"> <?= wfMsg('cnw-name-wiki-wiki') ?>
				<div class="wiki-name-error error-msg"></div>
				<label for="wiki-domain"><?= wfMsg('cnw-name-wiki-domain-label') ?></label>
				<div class="wiki-domain-container">
					<span class="domain-status-icon status-icon"></span>
					<span class="domain-country"><?= empty($selectedLang) || $selectedLang === 'en' ? '' : $selectedLang.'.' ?></span>
					<?= wfMsg('cnw-name-wiki-language') ?>
					<input type="text" name="wiki-domain" value="<?= empty($params['wikiDomain']) ? '' : $params['wikiDomain'] ?>"> <?= wfMsg('cnw-name-wiki-domain') ?>
				</div>
				<div class="wiki-domain-error error-msg"></div>
				<div class="language-default">
					<?= wfMsg('cnw-desc-default-lang', Language::getLanguageName($selectedLang) ) ?> - <a href="#" id="ChangeLang"><?= wfMsg('cnw-desc-change-lang') ?></a>
				</div>
				<div class="language-choice">
					<label for="wiki-language"><?= wfMsg('cnw-desc-lang') ?></label>
					<select name="wiki-language">

					<?php
		$isSelected = false;
		if (!empty($aTopLanguages) && is_array($aTopLanguages)) :
	?>
					<optgroup label="<?= wfMsg('autocreatewiki-language-top', count($aTopLanguages)) ?>">
	<?php foreach ($aTopLanguages as $sLang) :
			$selected = '';
			if ( empty($isSelected) && $sLang == $selectedLang ) {
				$isSelected = true;
				$selected = ' selected="selected"';
			}
	?>
					<option value="<?=$sLang?>" <?=$selected?>><?=$sLang?>: <?=$aLanguages[$sLang]?></option>
	<?php endforeach ?>
					</optgroup>
	<?php endif ?>
					<optgroup label="<?= wfMsg('autocreatewiki-language-all') ?>">
	<?php if (!empty($aLanguages) && is_array($aLanguages)) : ?>
	<?php
		ksort($aLanguages);
		foreach ($aLanguages as $sLang => $sLangName) :
			$selected = "";
			if ( empty($isSelected) && ( ( isset($params['wiki-language'] ) && ( $sLang == $params['wiki-language'] ) ) || ( !isset($params['wiki-language']) && ( $sLang == $selectedLang ) ) ) ) :
				$isSelected = true;
				$selected = ' selected="selected"';
			endif;
	?>
					<option value="<?=$sLang?>" <?=$selected?>><?=$sLang?>: <?=$sLangName?></option>
	<?php endforeach ?>
					</optgroup>
	<?php endif ?>

					</select>
				</div>
				<nav class="next-controls">
					<span class="submit-error error-msg"></span>
					<input type="button" value="<?= wfMsg('cnw-next') ?>" class="next">
				</nav>
			</form>
		</li>
<?php
	if (!$isUserLoggedIn) {
		if($wg->ComboAjaxLogin) {
?>
		<li id="Auth" class="step">
			<h2 class="headline login"><?= wfMsg('cnw-auth-headline') ?></h2>
			<h2 class="headline signup"><?= wfMsg('cnw-auth-headline2') ?></h2>
			<p class="creative login"><?= wfMsg('cnw-auth-creative') ?></p>
			<p class="creative signup"><?= wfMsg('cnw-auth-signup-creative') ?></p>
			<?= AjaxLoginForm::getTemplateForCombinedForms()->render('ComboAjaxLogin') ?>
			<p class="signup-msg">
				<?= wfMsg('cnw-signup-prompt') ?> <a href="#"><?= wfMsg('cnw-call-to-signup') ?></a>
			</p>
			<p class="login-msg">
				<?= wfMsg('cnw-login-prompt') ?> <a href="#"><?= wfMsg('cnw-call-to-login') ?></a>
				<br>
				<?php print '<fb:login-button id="fbAjaxSignupConnect" size="large" length="short"'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'>'.wfMsg('cnw-auth-facebook-signup').'</fb:login-button>'; ?>
			</p>
			<div class="facebook login">
				<span>- <?= wfMsg('cnw-or') ?> -</span>
				<?php print '<fb:login-button id="fbAjaxLoginConnect" size="large" length="short"'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'>'.wfMsg('cnw-auth-facebook-login').'</fb:login-button>'; ?>
			</div>
			<nav class="back-controls">
				<input type="button" value="<?= wfMsg('cnw-back') ?>" class="secondary back">
			</nav>
			<nav class="next-controls">
				<input type="button" value="<?= wfMsg('cnw-login') ?>" class="login">
				<input type="button" value="<?= wfMsg('cnw-signup') ?>" class="signup">
			</nav>
		</li>
<?php
		} // $wgComboAjaxLogin
		else if($wg->EnableUserLoginExt){
?>
	<li id="UserAuth" class="step">
		<h2 class="headline"><?= wfMsg('cnw-userauth-headline') ?></h2>
		<p class="creative"><?= wfMsg('cnw-userauth-creative') ?></p>
		<div class="signup-loginmodal"><?= F::app()->sendRequest('UserLoginSpecial', 'modal') ?></div>
		<div class="signup-marketing">
			<h3><?= wfMsg('cnw-userauth-marketing-heading') ?></h3>
			<p><?= wfMsgExt('cnw-userauth-marketing-body', array('parse')) ?></p>
			<form method="post" action="<?= $signupUrl ?>" id="SignupRedirect">
				<input type="hidden" name="returnto" value="">
				<input type="hidden" name="redirected" value="true">
				<input type="hidden" name="uselang" value="<?= $params['wikiLanguage'] ?>">
				<input type="submit" value="<?= wfMsg('cnw-userauth-signup-button') ?>">
			</form>
		</div>
	</li>
<?php
		} // else, UserLogin
	} // if isLoggedIn
?>
		<li id="DescWiki" class="step">
			<h2><?= wfMsg('cnw-desc-headline') ?></h2>
			<p class="creative"><?= wfMsg('cnw-desc-creative') ?></p>
			<form name="desc-form">
				<textarea id="Description" placeholder="<?= wfMsg('cnw-desc-placeholder') ?>"></textarea>
				<ol>
					<li>
						<?= wfMsg('cnw-desc-tip1') ?>
						<div class="tip-creative"><?= wfMsg('cnw-desc-tip1-creative') ?></div>
					</li>
					<li>
						<?= wfMsg('cnw-desc-tip2') ?>
						<div class="tip-creative"><?= wfMsg('cnw-desc-tip2-creative') ?></div>
					</li>
					<li>
						<?= wfMsg('cnw-desc-tip3') ?>
						<div class="tip-creative"><?= wfMsg('cnw-desc-tip3-creative') ?></div>
					</li>
				</ol>
				<label for="wiki-category"><?= wfMsg('cnw-desc-choose') ?></label>
				<select name="wiki-category">
					<option value=""><?=wfMsg('cnw-desc-select-one')?></option>
	<?php
		foreach ($aCategories as $iCat => $catData) {
			$sCatName = $catData["name"];
			if( in_array( $sCatName, array( 'Wikia', 'Wikianswers' ) ) )
				continue;
	?>
					<option value="<?php echo $iCat ?>"><?php echo $sCatName?></option>
	<?php
		}
	?>
					<option value="3"><?=wfMsg('autocreatewiki-category-other')?></option>
				</select>
				<nav class="back-controls">
					<input type="button" value="<?= wfMsg('cnw-back') ?>" class="secondary back">
				</nav>
				<nav class="next-controls">
					<span class="submit-error error-msg"></span>
					<input type="button" value="<?= wfMsg('cnw-next') ?>" class="next">
				</nav>
			</form>
		</li>
		<li id="ThemeWiki" class="step">
			<h2><?= wfMsg('cnw-theme-headline') ?></h2>
			<p class="creative"><?= wfMsg('cnw-theme-creative') ?></p>
			<?= F::app()->renderView('ThemeDesigner', 'ThemeTab') ?>
			<p class="instruction creative"><?= wfMsg('cnw-theme-instruction') ?></p>
			<nav class="next-controls">
				<span class="submit-error finish-status"></span>
				<input type="button" value="<?= wfMsg('cnw-next') ?>" class="next" disabled>
			</nav>
		</li>
	</ol>
	<ul id="StepsIndicator">
		<?php
			$steps = $isUserLoggedIn ? 4 : 5;
			$active = empty($currentStep) ? 1 : 3;
			for($i = 0; $i < $steps; $i++) {
		?>
			<li class="step<?= $active > 0 ? ' active' : '' ?>"></li>
		<?php
				$active--;
			}
		?>
	</ul>
	<img class="awesome-box" src="<?= $wg->ExtensionsPath ?>/wikia/CreateNewWiki/images/box_art.png">
</section>
<script>
	WikiBuilderCfg = {
		'name-wiki-submit-error':'<?= wfMsg('cnw-name-wiki-submit-error') ?>',
		'desc-wiki-submit-error':'<?= wfMsg('cnw-desc-wiki-submit-error') ?>',
		'currentstep':'<?= $currentStep ?>',
		'skipwikiaplus':'<?= $skipWikiaPlus ?>',
		'descriptionplaceholder':'<?= wfMsg('cnw-desc-placeholder') ?>',
		'cnw-error-general':'<?= wfMsg('cnw-error-general') ?>',
		'cnw-error-general-heading':'<?= wfMsg('cnw-error-general-heading') ?>',
		'cnw-keys': <?= json_encode($keys) ?>
	};
	var themes = <?= json_encode($wg->OasisThemes) ?>;
</script>
