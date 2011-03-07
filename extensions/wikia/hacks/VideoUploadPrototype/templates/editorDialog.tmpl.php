<div id="VideoUploadEditorPagesWrapper">
	<div class="VideoUploadEditorPage">
		<h1>Upload video</h1>

		<div class="form">
			<form method="post" id="VideoUploadFormData">
				<label><span>Title:</span><input type="text" name="videoTitle" value="Your title here"></label>
				<label><span>Tags:</span><input type="text" name="tags" value="your, tags, here"></label>
				<label><span>Description:</span><textarea name="description">Your description here</textarea></label>
			</form>

			<form method="post" enctype="multipart/form-data" id="VideoUploadFormFile">
				<label><span>File:</span><input type="file" name="file"><img src="<?= $wgStylePath ?>/common/images/ajax.gif" class="throbber" style="display:none"></label>
				<label><span>Progress:</span><span class="progress-outer"><span id="progressInner">&nbsp;</span></span></label>
			</form>

			<button type="submit" class="wikia-button" id="VideoUploadFormSubmit">Upload</button>
		</div>

		<div class="image">
			<img src="<?= $wgExtensionsPath ?>/wikia/hacks/VideoUploadPrototype/images/movie-noPlay.png">
		</div>
	</div>
</div>