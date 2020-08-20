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
		<?php if( $status === "close" && $forum_migration ): ?>
			<?php echo $answer ?>
		<?php endif ?>
		</div>
		<div class='pollAnswerVotes' onmouseover='span=this.getElementsByTagName("span")[0];tmpPollVar=span.innerHTML;span.innerHTML=span.title;span.title="";' onmouseout='span=this.getElementsByTagName("span")[0];span.title=span.innerHTML;span.innerHTML=tmpPollVar;'>
			<?php
				$percent = isset( $votes[ $nr ][ "percent" ] )
					? $votes[ $nr ][ "percent" ] : 0;
			?>
			<span id="wpPollVote<?php echo $id ?>-<?php echo $nr ?>" title='<?php echo ( isset($votes[ $nr ][ "percent" ]) ? ( wfMsg("ajaxpoll-percentVotes", $votes[ $nr ][ "percent" ]) ): 0 ); ?>'><?php echo isset( $votes[ $nr ][ "value" ] ) ? $votes[ $nr ][ "value" ] : 0 ?></span>
			<div class="wpPollBar<?php echo $id ?>" id="wpPollBar<?php echo $id; ?>-<?php echo $nr; ?>" style="width: <?php echo $percent;?>%;<?php if ($percent) echo " border:0;"; ?>">&nbsp;</div>
		</div>
		</div>
		<?php endforeach ?>
			<br style="clear: both;" />
			<div>
			<?php
				$span = sprintf("<span class=\"total\" id=\"wpPollTotal%s\">%d</span>", $id, $total );
				$summary = wfMsg("ajaxpoll-summary", array( $created_time, $created_date, $span ));
				echo $summary;
			?>
			</div>
		</div>
		<?php if( $status === "open" ): ?>
		<input type="submit" name="wpVote" id="axPollSubmit<?php echo $id ?>" value="<?php echo wfMsg("ajaxpoll-submit") ?>" />
		<span id="pollSubmittingInfo<?php echo $id ?>" style="padding-left: 10px; visibility: hidden;">
			<?php echo wfMsg("ajaxpoll-submitting"); ?>
		</span>
		<?php else: echo wfMsg("ajaxpoll-closed"); endif ?>
	</form>
</div>
<!-- e:poll -->
