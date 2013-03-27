<div class="wam-header">
	<ul class="wam-tabs">
		<li>
			<a href="#">1</a>
		</li>
		<li>
			<a href="#">2</a>
		</li>
		<li>
			<a href="#">3</a>
		</li>
		<li>
			<a href="#">4</a>
		</li>
		<li>
			<a href="#">5</a>
		</li>
		<li>
			<a href="#">6</a>
		</li>
	</ul>

	<div class="wam-cards">
		<a href="#" class="wam-card">
			<figure class="wam-img">
				<span class="wam-img-info">Lorem ipsum</span>
			</figure>
			<div class="wam-score">4.18</div>
			<span class="wam-vertical">Lifestyle</span>
		</a>
        <a href="#" class="wam-card">
            <figure class="wam-img">
                <span class="wam-img-info">Lorem ipsum</span>
            </figure>
            <div class="wam-score">4.18</div>
            <span class="wam-vertical">Lifestyle</span>
        </a>
    	<a href="#" class="wam-card">
            <figure class="wam-img">
                <span class="wam-img-info">Lorem ipsum</span>
            </figure>
            <div class="wam-score">4.18</div>
            <span class="wam-vertical">Lifestyle</span>
    	</a>
        <a href="#" class="wam-card">
            <figure class="wam-img">
                <span class="wam-img-info">Lorem ipsum</span>
            </figure>
            <div class="wam-score">4.18</div>
            <span class="wam-vertical">Lifestyle</span>
        </a>
	</div>
	
    <h2><?= wfMessage('wampage-header')->text(); ?></h2>
</div>

<div class="wam-progressbar"></div>
<div class="wam-content">
	<?= wfMessage(
		'wampage-content',
		$faqPage
	)->parse(); ?>
</div>

<? var_dump($visualizationWikis); ?>
