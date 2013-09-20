<li id=<?=$commentId?> class=comment data-user="<?=$comment['username']?>">
	<div class=avatar>
		<a href=<?= $comment['userurl'] ?>><?= $comment['avatar'] ?></a>
	</div>
	<blockquote class=msg>
		<div class=by>
			<?= $comment['sig'] ;?>
			<? if( !empty( $comment['isStaff'] ) ) :?>
			<img class=staff src=<?=wfReplaceImageServer('/extensions/wikia/StaffSig/images/WikiaStaff.png')?> alt=@wikia/></span>
			<? endif ;?>
		</div>
		<div class=txt><?= $comment['text'] ?></div>
		<div class=date><?= $comment['timestamp'] ;?></div>
	</blockquote>
<?php
	if($level == 1) {
		$reply = '';
		$count = 0;
		if ( !empty( $lvl2 ) ) {
			echo "<ul class=sub-comments>";
			foreach ($lvl2 as $commId => $reply) {
				if ($reply instanceof ArticleComment) {
					$comment = $reply->getData($useMaster);
					echo $app->getView( 'ArticleComments', 'WikiaMobileComment', array( 'comment' => $comment, 'commentId' => $commId, 'level' => 2 ) )->render();
				}
			}
			echo "</ul>";
			$count = count( $lvl2 );
			$reply = "<span class=viewAll>".wfMsg('wikiamobile-article-comments-view')." ({$count})</span>";
		}

		echo "<div class=rpl data-replies={$count}><span class=cmnRpl>".wfMsg('article-comments-reply')."</span>{$reply}</div>";
	}
?>
</li>
