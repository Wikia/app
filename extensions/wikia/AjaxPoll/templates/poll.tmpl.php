<!-- s:poll -->
<div class="ajax-poll" id="ajax-poll-<?php echo $id ?>" >
    <div class="header">
		<?php echo $question ?>
	</div>
	<div id="wpPollStatus<?php echo $id ?>" class="center">
		&nbsp;
	</div>
    <form action="#" method="post" id="axPoll<?php echo $id ?>">
		<input type="hidden" name="wpPollId" value="<?php echo $id ?>" />
		<div id="ajax-poll-area">
			<?php foreach( $answers as $nr => $answer ): ?>
			<div class="row" <?php echo ($nr%2) ? 'style="background-color: #e5e5e5;"' : '' ?> >
				<div>
					<?php if( $status === "open" ): ?>
					<input type="radio" name="wpPollRadio<?php echo $id ?>" value="<?php echo $nr ?>" />
					<?php endif ?>
					<label for="wpPollRadio<?php echo $id ?>"><?php echo $answer ?></label>
				</div>
				<span class="wpPollBar<?php echo $id ?>" id="wpPollBar<?php echo $id ?>-<?php echo $nr ?>" style="float: left; width: <?php echo isset( $votes[ $nr ][ 'pixels' ] ) ? $votes[ $nr ][ 'pixels' ] : 0; ?>px; background: <?php echo $colors[ $nr ] ?>;">
					&nbsp;
				</span>
				<span style="float: left; margin-left: 1em;">
					<span id="wpPollVote<?php echo $id ?>-<?php echo $nr ?>">
					<?php echo isset( $votes[ $nr ][ "value" ] ) ? $votes[ $nr ][ "value" ] : 0 ?>
					</span>
					&nbsp;
					<em>
						(
						<span id="wpPollPercent<?php echo $id ?>-<?php echo $nr ?>">
							<?php echo ( isset( $votes[ $nr ][ "percent" ] ) ? $votes[ $nr ][ "percent" ] : 0 ) ?>
						</span>%&nbsp;
						<?php echo wfMsg("ajaxpoll_PercentVotes"); ?>
						)
					</em>
				</span>
				<br style="clear: both;" />
			</div>
			<?php endforeach ?>
			<div>
				<?php echo wfMsg("ajaxpoll_Created")." {$created}" ?>
				<?php echo wfMsg("ajaxpoll_Total") ?>
				<span class="total" id="wpPollTotal<?php echo $id ?>"><?php echo $total ?></span>&nbsp;
				<?php echo wfMsg("ajaxpoll_Voted") ?>
			</div>
		</div>
		<?php if( $status === "open" ): ?>
		<input type="submit" name="wpVote" id="axPollSubmit<?php echo $id ?>" value="<?php echo wfMsg("ajaxpoll_Submit") ?>" />
		<script type="text/javascript">
		if( typeof( AjaxPollSubmitsArray == "undefined" ) ) {
			var AjaxPollSubmitsArray = [];
		}
		AjaxPollSubmitsArray.push({"submit":"axPollSubmit<?php echo $id ?>", "id":"axPoll<?php echo $id ?>", "url":"<?php echo $title->getFullURL( "action=ajax&rs=axAjaxPollSubmit" ) ?>"});
		</script>
		<?php else: echo wfMsg("ajaxpoll_Closed"); endif ?>
    </form>
</div>
<!-- e:poll -->
