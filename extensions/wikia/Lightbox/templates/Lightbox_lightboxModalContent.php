<? //  Important: If you change this template, update lightboxVersion in LightboxLoader.js to bust browser cache  ?>

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

	<? if($showAds) { ?>
		<div id="MODAL_INTERSTITIAL" class="wikia-ad noprint modal_interstitial">
			<?= AdEngine::getInstance()->getAd('MODAL_INTERSTITIAL', array('ghostwriter'=>true)); ?>
		</div>
	<? } ?>

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
		<? if($showAds) { ?>
			<div id="MODAL_RECTANGLE" class="wikia-ad noprint">
				<?= AdEngine::getInstance()->getAd('MODAL_RECTANGLE', array('ghostwriter'=>true)); ?>
			</div>
		<? } ?>
	</div>

	<div class="more-info">
	</div>

	<div class="share">
	</div>

	<script id="LightboxPhotoTemplate" class="template" type="text/template">
		<img src="{{imageUrl}}" height="{{imageHeight}}" >
	</script>

	<script id="LightboxVideoTemplate" class="template" type="text/template">
		{{{videoEmbedCode}}}
	</script>

	<script id="LightboxHeaderTemplate" class="template" type="text/template">
		<button class="share-button secondary"><?= wfMsg('lightbox-header-share-button') ?></button>
		<button class="more-info-button secondary"><?= wfMsg('lightbox-header-more-info-button') ?></button>
		<h1><a href="{{fileUrl}}" target="_blank">{{fileTitle}}</a></h1>
		<a href="{{rawImageUrl}}" class="see-full-size-link" target="_blank"><?= wfMsg('lightbox-header-see-full-size-image') ?></a>
		<span class="video-views">{{{views}}}</span>
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
			<li{{#liClass}} class="{{liClass}}"{{/liClass}}>
				{{{playButtonSpan}}}
				<img src="<?= $wg->BlankImgUrl ?>" data-src="{{thumbUrl}}" data-caption="{{caption}}" width="90" height="55">
			</li>
		{{/thumbs}}
	</script>

	<script id="LightboxCarouselMore" type="text/template">
		<li class="more-items disabled">
			<p class="subtle">{{{text}}}</p>
		</li>
	</script>

	<script id="LightboxCarouselProgressTemplate" type="text/template">
		<?= wfMsg('lightbox-carousel-progress', array("{{idx1}}", "{{idx2}}", "{{{total}}}")); ?>
	</script>

	<script id="LightboxMoreInfoTemplate" type="text/template">
		<button class="more-info-close secondary"><?= wfMsg('lightbox-more-info-back-button') ?></button>
		<div class="content">
			<div class="hero">
				<div class="hero-inner">
					<img src="{{imageUrl}}">
				</div>
			</div>
			<div class="more-info-details">
				<h1><a href="{{fileUrl}}" target="_blank">{{fileTitle}}</a></h1>
				<span class="video-views">{{{views}}}</span>
				<div class="user-details">
					<img class="avatar" src="{{userThumbUrl}}">
					<?= wfMsg('lightbox-header-added-by', '<a href="{{userPageUrl}}" target="_blank">{{userName}}</a>') ?>
				</div>
				<h2><?= wfMsg('lightbox-more-info-filelinks-heading') ?></h2>
				<ul>
				{{#articles}}
					<li><a href="{{url}}" target="_blank">{{titleText}}</a></li>
				{{/articles}}
				</ul>
			</div>
		</div>
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
				<?= F::app()->renderView('WikiaForm', 'Index', array('form' => $form)); ?>
				<div class="social-links">
					<ul>
						{{#networks}}
							<li><a href="{{url}}" target="_blank" class="{{id}}"></a></li>
						{{/networks}}
					</ul>
				</div>
			</div>
			<div class="bottom-forms">
				<div class="more-links">
					<?php
						$formHeader = array (
						    'inputs' => array (
						    	array(
						    		'type' => 'custom',
						    		'output' => '<h2>'. wfMsg('lightbox-urls-form-header') .'</h2>',
						    	),
						    ),
						);
					?>
					<?php
						$formEmbed = array (
							'inputs' => array (
						        array(
						            'label' => wfMsg('lightbox-embed-url'),
						            'type' => 'text',
						            'name' => 'lightbox-embed-url',
					                'value' => "{{embedMarkup}}",
						        ),
						    ),
						);
					?>
					<?php
						$formFilePage = array (
							'inputs' => array (
						        array(
						            'label' => wfMsg('lightbox-file-page-url'),
						            'type' => 'text',
						            'name' => 'lightbox-file-page-url',
					                'value' => "{{fileUrl}}",
						        )
						    )
						);
					?>
					<?= F::app()->renderView('WikiaForm', 'Index', array('form' => $formHeader)); ?>
					{{#embedMarkup}}
						<?= F::app()->renderView('WikiaForm', 'Index', array('form' => $formEmbed)); ?>
					{{/embedMarkup}}
					<?= F::app()->renderView('WikiaForm', 'Index', array('form' => $formFilePage)); ?>
				</div>
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
					<?= F::app()->renderView('WikiaForm', 'Index', array('form' => $form)); ?>
				</div>
			</div>
		</div>
	</script>


</div>
