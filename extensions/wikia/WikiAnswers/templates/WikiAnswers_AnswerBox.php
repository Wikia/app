<?php
global $wgBlankImgUrl, $wgTitle, $wgStylePath, $wgUser, $wgScriptPath;
?>
			<div id="answer_level">
			<div id="answer_box" class="accent">
			<h1 id="answer_heading"><?= wfMessage( 'answer_this_question' )->escaped(); ?></h1>
			<?php
			$title = $wgTitle;
		// check whether current user is blocked (RT #48058)
		if ( !$wgUser->isBlocked( true ) ) {
			?>	<script>var wgScriptPath = "<?= $wgScriptPath ?>"; </script>
				<script src="<?=$wgStylePath?>/../extensions/wikia/JavascriptAPI/Mediawiki.js"></script>
				<form onsubmit="return handleEditForm(this)">
				<textarea name="article" class="answer-input" rows="7" id="article_textarea"></textarea><br />
				<script>document.getElementById("article_textarea").focus();</script>
					<span style="float:right"><input type="submit" value="<?= wfMessage( 'wiki-answers-save' )->escaped(); ?>" id="article_save_button"/></span>
				</form>

				<script>
				function handleEditForm() {
					<?php
						global $wgReadOnly;
					if ($wgReadOnly){?>
						alert("<?= Xml::escapeJsString( $wgReadOnly ); ?>");
						return false;
						<?php } ?>
							try {
								$("#article_save_button").val($("#article_save_button").val() + "...");
								$("#article_save_button").attr("disabled","disabled");
								Mediawiki.editArticle({
										"title": "<?= Xml::escapeJsString( $title->getText() ); ?>",
										"prependtext": $("#article_textarea").val()}, editArticleSuccess, apiFailed);
							} catch (e) {
								alert(Mediawiki.print_r(e));
							}
						return false; // Return false so that the form doesn't submit
				}

			function editArticleSuccess(){
				window.location.href = "<?= Xml::escapeJsString( $title->getFullUrl() );?>?cb=<?=mt_rand(1, 10420)?>";
			}
			function apiFailed(e){
				alert(Mediawiki.print_r(e));
			}

			</script>
				<?php
		}
		?>
			</div>
			</div><!-- answer_level -->
