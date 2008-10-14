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
    <div class='pollAnswer' id='pollAnswer<?php echo $nr ?>'>
     <div class='pollAnswerName'>
					<?php if( $status === "open" ): ?>
	    	<label for='pollAnswerRadio<?php echo $id ?>'>
							<input type='radio' name='wpPollRadio<?php echo $id ?>' id='wpPollRadio<?php echo $id ?>' value='<?php echo $nr ?>' /><?=$answer; ?>
						</label>
					<?php endif ?>
					</div>
					<div class='pollAnswerVotes' onmouseover='span=this.getElementsByTagName("span")[0];tmpPollVar=span.innerHTML;span.innerHTML=span.title;span.title="";' onmouseout='span=this.getElementsByTagName("span")[0];span.title=span.innerHTML;span.innerHTML=tmpPollVar;'>
					 <span id="wpPollVote<?php echo $id ?>-<?php echo $nr ?>" title='<?php echo ( isset($votes[ $nr ][ "percent" ]) ? ($votes[ $nr ][ "percent" ] . "%&nbsp;" . wfMsg("ajaxpoll-percentVotes") ): 0 ); ?>'><?php echo isset( $votes[ $nr ][ "value" ] ) ? $votes[ $nr ][ "value" ] : 0 ?></span>
						<div class="wpPollBar<?php echo $id ?>" id="wpPollBar<?php echo $id ?>-<?php echo $nr ?>" style='width: <?php echo ( isset( $votes[ $nr ][ "percent" ] ) ? $votes[ $nr ][ "percent" ] : 0 );?>%;<?php echo ($votes[ $nr ][ "percent" ] == 0?" border:0;":""); ?>'>&nbsp;</div> 
					</div>
				</div>
			<?php endforeach ?>
			<br style="clear: both;" />
			<div>
				<?php echo wfMsg("ajaxpoll-created")." {$created}" ?>
				<?php echo wfMsg("ajaxpoll-total") ?>
				<span class="total" id="wpPollTotal<?php echo $id ?>"><?php echo $total ?></span>&nbsp;
				<?php echo wfMsg("ajaxpoll-voted") ?>
			</div>
		</div>
		<?php if( $status === "open" ): ?>
		<input type="submit" name="wpVote" id="axPollSubmit<?php echo $id ?>" value="<?php echo wfMsg("ajaxpoll-submit") ?>" />
		<span id="pollSubmittingInfo<?php echo $id ?>" style="padding-left: 10px; visibility: hidden;">
			<?php echo wfMsg("ajaxpoll-submitting"); ?>
		</span>
		<script type="text/javascript">
		if( typeof( AjaxPollSubmitsArray ) == "undefined" ) {
			var AjaxPollSubmitsArray = [];
		}
		AjaxPollSubmitsArray.push({"submit":"axPollSubmit<?php echo $id ?>", "id":"axPoll<?php echo $id ?>", "pollId":"<?php echo $id ?>", "url":"<?php echo $title->getFullURL( "action=ajax&rs=axAjaxPollSubmit" ) ?>"});
		</script>
		<?php else: echo wfMsg("ajaxpoll-closed"); endif ?>
	</form>
</div>
<!-- e:poll -->
