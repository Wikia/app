<ul id="article-comments-ul" class="comments">
	<? if ( count( $commentListRaw ) ): ?>
		<? $odd = true ?>
		<? $id = 1 ?>
		<? foreach ( $commentListRaw as $commentId => $commentArr ): ?>
			<? $rowClass = $odd ? 'odd' : 'even' ?>
			<? $odd = !$odd ?>

			<? if ( isset( $commentArr[ 'level1' ] ) && $commentArr[ 'level1' ] instanceof ArticleComment ): ?>
				<?= $app->getView( 'ArticleComments', 'Comment', [
						'comment' => $commentArr[ 'level1' ]->getData( $useMaster ),
						'commentId' => $commentId,
						'rowClass' => $rowClass,
						'level' => 1,
						'page' => $page,
						'id' => $id++
				] )
				?>
			<? endif ?>
			<? if ( isset( $commentArr[ 'level2' ] ) ): ?>
				<ul class="sub-comments">
					<? foreach ( $commentArr[ 'level2' ] as $commentId => $reply ): ?>
						<? if ( $reply instanceof ArticleComment ): ?>
							<?= $app->getView( 'ArticleComments', 'Comment', [
									'comment' => $reply->getData( $useMaster ),
									'commentId' => $commentId,
									'rowClass' => $rowClass,
									'level' => 2
							] )
							?>
						<? endif ?>
					<? endforeach ?>
				</ul>
			<? endif ?>
		<? endforeach ?>
	<? endif ?>
</ul>