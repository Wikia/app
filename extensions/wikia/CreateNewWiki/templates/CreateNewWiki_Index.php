<?php
	$selectedLang = empty($params['wikiLanguage']) ? $wg->LanguageCode : $params['wikiLanguage'];
?>
<section id="CreateNewWiki">
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
	<h1><?= wfMessage('cnw-title')->text() ?></h1>
	<ol class="steps">
		<li id="NameWiki" class="step">
			<h2><?= wfMessage('cnw-name-wiki-headline')->text() ?></h2>
			<p class="creative"><?= wfMessage('cnw-name-wiki-creative')->text() ?></p>
			<form name="label-wiki-form">
				<label for="wiki-name"><?= wfMessage('cnw-name-wiki-label')->text() ?></label>
				<span class="wiki-name-status-icon status-icon"></span>
				<input type="text" name="wiki-name" value="<?= empty($params['wikiName']) ? '' : $params['wikiName'] ?>"> <?= wfMessage('cnw-name-wiki-wiki')->text() ?>
				<div class="wiki-name-error error-msg"></div>
				<label for="wiki-domain" dir="ltr"><?= wfMessage('cnw-name-wiki-domain-label')->text() ?></label>
				<div class="wiki-domain-container">
					<span class="domain-status-icon status-icon"></span>
					<span class="domain-country"><?= empty($selectedLang) || $selectedLang === 'en' ? '' : $selectedLang.'.' ?></span>
					<?= wfMessage('cnw-name-wiki-language')->text() ?>
					<input type="text" name="wiki-domain" value="<?= empty($params['wikiDomain']) ? '' : $params['wikiDomain'] ?>"> <?= wfMessage('cnw-name-wiki-domain')->text() ?>
				</div>
				<div class="wiki-domain-error error-msg"></div>
				<div class="language-default">
					<?= wfMessage('cnw-desc-default-lang', Language::getLanguageName($selectedLang) )->text() ?> - <a href="#" id="ChangeLang"><?= wfMessage('cnw-desc-change-lang')->text() ?></a>
				</div>
				<div class="language-choice">
					<label for="wiki-language"><?= wfMessage('cnw-desc-lang')->text() ?></label>
					<select name="wiki-language">

					<?php
		$isSelected = false;
		if (!empty($aTopLanguages) && is_array($aTopLanguages)) :
	?>
					<optgroup label="<?= wfMessage('autocreatewiki-language-top', count($aTopLanguages))->text() ?>">
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
					<optgroup label="<?= wfMessage('autocreatewiki-language-all')->text() ?>">
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
					<input type="button" value="<?= wfMessage('cnw-next')->text() ?>" class="next">
				</nav>
			</form>
		</li>
<?php
	if (!$isUserLoggedIn) {
		if($wg->ComboAjaxLogin) {
?>
		<li id="Auth" class="step">
			<h2 class="headline login"><?= wfMessage('cnw-auth-headline')->text() ?></h2>
			<h2 class="headline signup"><?= wfMessage('cnw-auth-headline2')->text() ?></h2>
			<p class="creative login"><?= wfMessage('cnw-auth-creative')->text() ?></p>
			<p class="creative signup"><?= wfMessage('cnw-auth-signup-creative')->text() ?></p>
			<?= AjaxLoginForm::getTemplateForCombinedForms()->render('ComboAjaxLogin') ?>
			<p class="signup-msg">
				<?= wfMessage('cnw-signup-prompt')->text() ?> <a href="#"><?= wfMessage('cnw-call-to-signup')->text() ?></a>
			</p>
			<p class="login-msg">
				<?= wfMessage('cnw-login-prompt')->text() ?> <a href="#"><?= wfMessage('cnw-call-to-login')->text() ?></a>
				<br>
				<?php print '<fb:login-button id="fbAjaxSignupConnect" size="large" length="short"'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'>'.wfMessage('cnw-auth-facebook-signup')->text().'</fb:login-button>'; ?>
			</p>
			<div class="facebook login">
				<span>- <?= wfMessage('cnw-or')->text() ?> -</span>
				<?php print '<fb:login-button id="fbAjaxLoginConnect" size="large" length="short"'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'>'.wfMessage('cnw-auth-facebook-login')->text().'</fb:login-button>'; ?>
			</div>
			<nav class="back-controls">
				<input type="button" value="<?= wfMessage('cnw-back')->text() ?>" class="secondary back">
			</nav>
			<nav class="next-controls">
				<input type="button" value="<?= wfMessage('cnw-login')->text() ?>" class="login">
				<input type="button" value="<?= wfMessage('cnw-signup')->text() ?>" class="signup">
			</nav>
		</li>
<?php
		} // $wgComboAjaxLogin
		else if($wg->EnableUserLoginExt){
?>
	<li id="UserAuth" class="step">
		<h2 class="headline"><?= wfMessage('cnw-userauth-headline')->text() ?></h2>
		<p class="creative"><?= wfMessage('cnw-userauth-creative')->text() ?></p>
		<div class="signup-loginmodal"><?= F::app()->sendRequest('UserLoginSpecial', 'modal') ?></div>
		<div class="signup-marketing">
			<h3><?= wfMessage('cnw-userauth-marketing-heading')->text() ?></h3>
			<p><?= wfMessage('cnw-userauth-marketing-body')->parse() ?></p>
			<form method="post" action="<?= $signupUrl ?>" id="SignupRedirect">
				<input type="hidden" name="returnto" value="">
				<input type="hidden" name="redirected" value="true">
				<input type="hidden" name="uselang" value="<?= $params['wikiLanguage'] ?>">
				<input type="submit" value="<?= wfMessage('cnw-userauth-signup-button')->text() ?>">
			</form>
		</div>
	</li>
<?php
		} // else, UserLogin
	} // if isLoggedIn
?>
		<li id="DescWiki" class="step">
			<h2><?= wfMessage('cnw-desc-headline') ?></h2>
			<p class="creative"><?= wfMessage('cnw-desc-creative')->text() ?></p>
			<form name="desc-form">
				<textarea id="Description" placeholder="<?= wfMessage('cnw-desc-placeholder')->text() ?>"></textarea>
				<ol>
					<li>
						<?= wfMessage('cnw-desc-tip1')->text() ?>
						<div class="tip-creative"><?= wfMessage('cnw-desc-tip1-creative')->text() ?></div>
					</li>
					<li>
						<?= wfMessage('cnw-desc-tip2')->text() ?>
						<div class="tip-creative"><?= wfMessage('cnw-desc-tip2-creative')->text() ?></div>
					</li>
					<li>
						<?= wfMessage('cnw-desc-tip3')->text() ?>
						<div class="tip-creative"><?= wfMessage('cnw-desc-tip3-creative')->text() ?></div>
					</li>
				</ol>
				<label for="wiki-category"><?= wfMessage('cnw-desc-choose')->text() ?></label>
				<select name="wiki-category">
					<option value=""><?= wfMessage('cnw-desc-select-one')->text() ?></option>
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
					<option value="3"><?= wfMessage('autocreatewiki-category-other')->text() ?></option>
				</select>
				<div class="checkbox">
					<input type="checkbox" name="all-ages" value="1">
					<?= $app->renderView(
						'WikiaStyleGuideTooltipIcon',
						'index',
						array(
							'text' => wfMessage('cnw-desc-all-ages')->text(),
							'tooltipIconTitle' => wfMessage('cnw-desc-tip-all-ages')->text(),
						)
					);
					?>
				</div>

				<nav class="back-controls">
					<input type="button" value="<?= wfMessage('cnw-back')->text() ?>" class="secondary back">
				</nav>
				<nav class="next-controls">
					<span class="submit-error error-msg"></span>
					<input type="button" value="<?= wfMessage('cnw-next')->text() ?>" class="next">
				</nav>
			</form>
		</li>
		<li id="ThemeWiki" class="step">
			<h2><?= wfMessage('cnw-theme-headline')->text() ?></h2>
			<p class="creative"><?= wfMessage('cnw-theme-creative')->text() ?></p>
			<?= F::app()->renderView('ThemeDesigner', 'ThemeTab') ?>
			<p class="instruction creative"><?= wfMessage('cnw-theme-instruction')->text() ?></p>
			<nav class="next-controls">
				<span class="submit-error finish-status"></span>
				<input type="button" value="<?= wfMessage('cnw-next')->text() ?>" class="next" disabled>
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
		'name-wiki-submit-error':'<?= wfMessage('cnw-name-wiki-submit-error')->text() ?>',
		'desc-wiki-submit-error':'<?= wfMessage('cnw-desc-wiki-submit-error')->text() ?>',
		'currentstep':'<?= $currentStep ?>',
		'skipwikiaplus':'<?= $skipWikiaPlus ?>',
		'descriptionplaceholder':'<?= wfMessage('cnw-desc-placeholder')->text() ?>',
		'cnw-error-general':'<?= wfMessage('cnw-error-general')->text() ?>',
		'cnw-error-general-heading':'<?= wfMessage('cnw-error-general-heading')->text() ?>',
		'cnw-keys': <?= json_encode($keys) ?>
	};
	var themes = <?= json_encode($wg->OasisThemes) ?>;
	var applicationThemeSettings = <?= json_encode($applicationThemeSettings) ?>;
</script>
