<?php
if ( count( $commentListRaw ) ) {
	$id = 1;
	foreach ($commentListRaw as $commentId => $commentArr) {
		if (isset ($commentArr['level1']) && $commentArr['level1'] instanceof ArticleComment) {
			$comment = $commentArr['level1']->getData($useMaster);
			$lvl2 = !empty( $commentArr['level2'] ) ? $commentArr['level2'] : '';
			echo $app->getView( 'ArticleComments', 'WikiaMobileComment', [ 'comment' => $comment, 'commentId' => $commentId, 'level' => 1, 'id' => $id++, 'lvl2' => $lvl2, 'useMaster' => $useMaster ] )->render();
		}
	}
}
