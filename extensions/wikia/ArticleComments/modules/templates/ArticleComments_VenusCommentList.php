<ul id="article-comments-ul" class="comments">
	<? if ( count( $commentListRaw ) ): ?>
		<? foreach ( $commentListRaw as $commentId => $commentArr ): ?>
			<? if ( isset( $commentArr[ 'level1' ] ) && $commentArr[ 'level1' ] instanceof ArticleComment ): ?>
				<?= $app->getView( 'ArticleComments', 'VenusComment', [
						'comment' => $commentArr[ 'level1' ]->getData( $useMaster ),
						'commentId' => $commentId,
						'level' => 1,
						'page' => $page,
					])
				?>
			<? endif ?>
			<? if ( isset( $commentArr[ 'level2' ] ) ): ?>
				<ul class="sub-comments">
					<? foreach ( $commentArr[ 'level2' ] as $commentId => $reply ): ?>
						<? if ( $reply instanceof ArticleComment ): ?>
							<?= $app->getView( 'ArticleComments', 'VenusComment', [
									'comment' => $reply->getData( $useMaster ),
									'commentId' => $commentId,
									'level' => 2
								])
							?>
						<? endif ?>
					<? endforeach ?>
				</ul>
			<? endif ?>
		<? endforeach ?>
	<? endif ?>
</ul>
