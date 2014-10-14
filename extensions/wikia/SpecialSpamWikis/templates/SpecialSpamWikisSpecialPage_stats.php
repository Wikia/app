<!-- s: <?= __FILE__ ?> -->
<?php
/*
 * The template for the stats subpage.
 */

if ( empty( $mData->stats ) ): ?>

<p><?= wfMsg( 'specialspamwikis-no-stats' ); ?></p>
<p><a href="<?= $mAction; ?>"><?= wfMsg( 'specialspamwikis-show-list' ); ?></a></p>

<?php else: ?>

<p><a href="<?= $mAction; ?>"><?= wfMsg( 'specialspamwikis-show-list' ); ?></a></p>

<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="spamwikis-table">
    <thead>
        <tr>
            <th rowspan="2"><?= wfMsg( 'specialspamwikis-date' ); ?></th>
            <th rowspan="2"><?= wfMsg( 'specialspamwikis-all-created' ); ?></th>
            <th colspan="2"><?= wfMsg( 'specialspamwikis-pagetitle' ); ?></th>
            <th colspan="2"><?= wfMsg( 'specialspamwikis-spam-users' ); ?></th>
        </tr>
        <tr>
            <th><?= wfMsg( 'specialspamwikis-spamwikis-amount' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-spamwikis-percent' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-spamwikis-founders' ); ?></th>
            <th><?= wfMsg( 'specialspamwikis-spamwikis-per-founder' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $mData->stats as $k => $v ): ?>
        <tr>
            <td><?= $v->date; ?></td>
            <td><?= $v->cnt_created;  ?></td>
            <td><?= $v->cnt_spamwikis;  ?>
            <td><?= sprintf('%1.2f%%', $v->cnt_spamwikis / $v->cnt_created ); ?></td>
            <td><?= $v->cnt_founders['count']; ?>
            <td><?= $v->cnt_founders['avg']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p><a href="<?= $mAction; ?>"><?= wfMsg( 'specialspamwikis-show-list' ); ?></a></p>

<?php endif; ?>
<!-- e: <?= __FILE__ ?> -->