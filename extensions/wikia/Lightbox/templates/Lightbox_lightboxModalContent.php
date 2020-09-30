<div class="WikiaLightbox">
	<!-- Keep media at the top so everything stacks on top of this, without the need to mess with z-index -->
	<div class="media">
	</div>

	<header class="LightboxHeader">
	</header>

	<div class="lightbox-arrows">
		<span id="LightboxNext" class="arrow next"></span>
		<span id="LightboxPrevious" class="arrow previous"></span>
	</div>

	<div id="LightboxCarousel" class="LightboxCarousel">
		<div id="LightboxCarouselInner" class="LightboxCarouselInner">
			<div class="content">
				<ul class="toolbar">
					<li><span class="icon pin button secondary" title="<?= wfMsg('lightbox-pin-carousel-tooltip') ?>" data-pinned-title="<?= wfMsg('lightbox-unpin-carousel-tooltip') ?>" data-pin-title="<?= wfMsg('lightbox-pin-carousel-tooltip') ?>" ></span></li>
				</ul>
				<p id="LightboxCarouselProgress" class="progress"></p>
				<span class="carousel-arrow next button secondary"></span>
				<span class="carousel-arrow previous button secondary"></span>
	 			<div id="LightboxCarouselContainer" class="LightboxCarouselContainer">
	 				<div>
	 					<ul class="carousel">
	 					</ul>
	 				</div>
	 			</div>
			</div>
		</div>
	</div>

	<div class="more-info">
	</div>

	<div class="share">
	</div>

	<script id="LightboxPhotoTemplate" class="template" type="text/template">
		<img src="{{imageUrl}}" height="{{imageHeight}}" >
	</script>

	<script id="LightboxHeaderTemplate" class="template" type="text/template">
		<a href="#" class="wikia-button share-button secondary"><?= wfMsg('lightbox-header-share-button') ?></a>
		{{#isUserAnon}}
		{{#imageDescription}}
		<div class="more-info-dropdown more-info-right wds-dropdown">
			<div class="wds-dropdown__toggle push-dropdown-down">
				<?= DesignSystemHelper::renderSvg( 'wds-icons-question', 'wds-icon wds-icon-small' ); ?>
				<span><?= wfMessage('lightbox-header-more-info-button')->escaped() ?></span>
			</div>
			<div class="wds-dropdown__content wds-is-right-aligned more-info-container">
				{{{imageDescription}}}
			</div>
		</div>
		{{/imageDescription}}
		{{^imageDescription}}
			{{#externalUrl}}
			<a href="{{externalUrl}}" class="wikia-button more-info-button secondary">
				<?= wfMessage('lightbox-header-more-info-button')->escaped() ?>
			</a>
			{{/externalUrl}}
		{{/imageDescription}}
		{{/isUserAnon}}
		{{^isUserAnon}}
		<a href="{{fileUrl}}" class="wikia-button more-info-button secondary"><?= wfMessage('lightbox-header-more-info-button')->escaped() ?></a>
		{{/isUserAnon}}
		<div id="lightbox-add-to-article" class="lightbox-add-to-article">
			<button class="article-add-button secondary"><?= wfMessage('lightbox-header-add-video-button')->escaped() ?></button>
			<input class="lightbox-article-input" />
		</div>

		{{#isUserAnon}}
		{{#imageDescription}}
		<div class="more-info-dropdown more-info-left wds-dropdown">
			<div class="wds-dropdown__toggle push-dropdown-down">
				<h1>{{fileTitle}}</h1>
			</div>
			<div class="wds-dropdown__content wds-is-left-aligned more-info-container">
				{{{imageDescription}}}
			</div>
		</div>
		{{/imageDescription}}
		{{^imageDescription}}
		<h1>{{fileTitle}}</h1>
		{{/imageDescription}}
		{{/isUserAnon}}
		{{^isUserAnon}}
		<h1><a href="{{fileUrl}}">{{fileTitle}}</a></h1>
		{{/isUserAnon}}
		<a href="{{rawImageUrl}}" class="see-full-size-link"><?= wfMsg('lightbox-header-see-full-size-image') ?></a>
		<div class="user-details caption">
			{{#caption}}<p>{{caption}}</p>{{/caption}}
			<img class="avatar" src="{{userThumbUrl}}">
			<?= wfMsg('lightbox-header-added-by', '<a href="{{userPageUrl}}" target="_blank">{{userName}}</a>') ?>
			{{#isPostedIn}}
				<span class="posted-in">
					<?= wfMsg('lightbox-header-posted-in', '{{#smallerArticleList}}<span class="posted-in-article"><a href="{{url}}" target="_blank">{{titleText}}</a></span>{{/smallerArticleList}}{{#articleListIsSmaller}}&hellip;{{/articleListIsSmaller}}') ?>
				</span>
			{{/isPostedIn}}
		</div>
	</script>

	<script id="LightboxHeaderAdTemplate" class="template" type="text/template">
		<h1><?= wfMsg('Fast-adv') ?></h1>
	</script>

	<script id="LightboxCarouselThumbs" type="text/template">
		{{#thumbs}}
			<li data-backfill="{{backfill}}">
				<a class="{{thumbWrapperClass}}">
					{{{playButtonSpan}}}
					<img class="thumb" src="<?= $wg->BlankImgUrl ?>" data-src="{{thumbUrl}}" data-caption="{{caption}}" width="90" height="55">
				</a>
			</li>
		{{/thumbs}}
	</script>

	<script id="LightboxCarouselMore" type="text/template">
		<li class="more-items disabled">
			<p class="subtle">{{{text}}}</p>
		</li>
	</script>

	<script id="LightboxCarouselProgressTemplate" type="text/template">
		<?= wfMessage( 'lightbox-carousel-progress' )->rawParams( '{{idx1}}', '{{idx2}}', '{{{total}}}' )->parse(); ?>
	</script>

	<script id="LightboxShareTemplate" type="text/template">
		<button class="more-info-close secondary"><?= wfMsg('lightbox-more-info-back-button') ?></button>
		<div class="content">
			<div class="hero">
				<div class="hero-inner">
					<img src="{{imageUrl}}">
				</div>
			</div>
			<div class="share-form">
				<h1><a href="{{fileUrl}}" target="_blank">{{fileTitle}}</a></h1>
				<?php
					$form = array (
					    'inputs' => array (
					        array(
					            'label' => wfMsg('lightbox-standard-link'),
					            'type' => 'text',
					            'name' => 'lightbox-standard-link',
				                'value' => "{{shareUrl}}",
				                'attributes' => array(
				                	'class' => 'share-input',
				                ),
					        )
					    )
					);
				?>
				<?= F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form)); ?>
				<div class="social-links">
					<ul>
						{{#networks}}
							<li><a href="{{url}}" target="_blank" class="{{id}}"></a></li>
						{{/networks}}
					</ul>
				</div>
			</div>
			<div class="bottom-forms">
				{{^isUserAnon}}
				<div class="more-links">
					<?php
						$formHeader = array (
							'inputs' => array (
								array(
									'type' => 'custom',
									'output' => '<h2>'. wfMessage('lightbox-urls-form-header')->parse() .'</h2>',
								),
							),
						);
					?>
					<?php
						$formFilePage = array (
							'inputs' => array (
								array(
									'label' => wfMessage('lightbox-file-page-url')->parse(),
									'type' => 'text',
									'name' => 'lightbox-file-page-url',
									'value' => "{{fileUrl}}",
								)
							)
						);
					?>
					<?= F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $formHeader)); ?>
					<?= F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $formFilePage)); ?>
				</div>
				{{/isUserAnon}}
				<div class="email">
					<?php
						$form = array (
							'id' => 'shareEmailForm',
						    'inputs' => array (
						    	array(
						    		'type' => 'custom',
						    		'output' => '<h2>'.wfMsg('lightbox-email-form-header').'</h2>',
						    	),
						        array(
						            // Main input attributes
						            'label' => wfMsg('lightbox-email-label'),
						            'type' => 'text',
						            'name' => 'lightbox-email',
						            // extra attributes
						            'attributes' => array(
						                'placeholder' => wfMsg('lightbox-email-placeholder'),
						            )
						        )
						    ),
							'submits' => array(
								array(
							    	'value' => wfMsg('lightbox-email-submit')
								)
							)
						);
					?>
					<?= F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form)); ?>
				</div>
			</div>
		</div>
	</script>

	<script id="LightboxErrorMessage" type="text/template">
		<p><?= wfMsg('lightbox-no-media-error-header') ?> <?= wfMsg('lightbox-no-media-error', $wg->Sitename) ?></p>
	</script>


</div>
