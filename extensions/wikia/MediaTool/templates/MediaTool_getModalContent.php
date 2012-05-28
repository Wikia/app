<section id="mediaToolDialog">
<ul class="tabs">
	<li data-tab="find-media" class="selected">
		<a>Find Media</a>
	</li>
	<li data-tab="edit-media">
		<a>Edit Media</a>
	</li>
</ul>

<div class="MediaToolContainer">

	<div data-tab-body="find-media" class="tabBody selected border">

		<div class="mediatool-left-bar">

			<ul class="tabs minor-tabs">
				<li data-tab="find-media-wiki" class="selected">
					<a>Wiki</a>
				</li>
				<li data-tab="find-media-online">
					<a>Online</a>
				</li>
				<li data-tab="find-media-computer">
					<a>Computer</a>
				</li>
			</ul>

			<div data-tab-body="find-media-wiki" class="tabBody selected">
				<input type="radio" id="source-recently-added" checked="checked"> <label for="source-recently-added"> Recently added media </label>
			</div>
			<div data-tab-body="find-media-online" class="tabBody">
			</div>
			<div data-tab-body="find-media-computer" class="tabBody">
			</div>

		</div>
		<div class="mediatool-content">
			<div class="mediatool-basket">
			<?= $app->getView( 'MediaTool', 'basket', array()); ?>
			</div>
			<div class="mediatool-thumbnail-browser">
				<div class="float-title">Recently added to the wiki</div>

				thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />thumbnails <br />
			</div>
		</div>

	</div>
	<div data-tab-body="edit-media" class="tabBody border">

		<div class="mediatool-left-bar">

			<ul class="tabs minor-tabs">
				<li data-tab="edit-media-options" class="selected">
					<a>Photo options</a>
				</li>
			</ul>

			<div data-tab-body="edit-media-options" class="tabBody selected">

				<div id="VideoEmbedSlider" class="WikiaSlider"></div>
				<span id="VideoEmbedInputWidth">
					<input type="text" id="VideoEmbedManualWidth" name="VideoEmbedManualWidth" value="" onchange="" onkeyup="" /> px
				<span>
			</div>

		</div>
		<div class="mediatool-content">
			<div class="mediatool-preview">

			</div>
		</div>

	</div>
</div>


<div class="MediaTool-buttons">
	<button class="secondary" name="cancel">Cancel</button>
	<button  name="continue">Continue</button>
</div>
</section>