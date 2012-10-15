<!-- s: <?= __FILE__ ?> -->
<?php
/*
 * The template for the view to be displayed after the form submission.
 * 
 * A list of wikis marked to close with the status of each operation (success or failure).
 */

if ( empty( $mData->close ) ): ?>

<p><?= wfMsg( 'specialspamwikis-no-wikis-to-close' ); ?></p>
<p><a href="<?= $mAction; ?>"><?= wfMsg( 'specialspamwikis-show-list' ); ?></a></p>

<?php else: ?>

<p><a href="<?= $mAction; ?>"><?= wfMsg( 'specialspamwikis-show-list' ); ?></a></p>
<p><?= wfMsgExt( 'specialspamwikis-stafflog-summary', array('parsemag'), $mData->summary['sum'], $mData->summary['count'], $mData->summary['avg'] ); ?></p>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="spamwikis-table">
    <thead>
        <tr>
            <th><?= wfMsg( 'specialspamwikis-wiki' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-status' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $mData->close as $k => $v ): ?>
        <tr>
            <td><?= $v['city']; ?></td>
            <td><?php echo ( $v['status'] ) ? wfMsg( 'specialspamwikis-success' ) : wfMsg( 'specialspamwikis-failed' );  ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?= wfMsg( 'specialspamwikis-wiki' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-status' ); ?></th>
        </tr>
    </tfoot>
</table>
<p><a href="<?= $mAction; ?>"><?= wfMsg( 'specialspamwikis-show-list' ); ?></a></p>

<?php endif; ?>
<!-- e: <?= __FILE__ ?> -->