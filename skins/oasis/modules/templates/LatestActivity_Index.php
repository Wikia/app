<section class="rail-module activity-module" id="wikia-recent-activity">

    <h2 class="has-icon"><?= $activityIcon ?><?= $moduleHeader ?></h2>

    <? if ( $renderTriviaQuizzes ): ?>
        <p>Here's a box and stuff and if you click it you can spawn a quiz it's pretty cool</p>
    <? else: ?>
        <? if ( !empty( $changeList ) ): ?>
            <ul class="activity-items">
                <? foreach ( $changeList as $item ): ?>
                    <li class="activity-item">
                        <div class="page-title">
                            <a href="<?= $item['page_url'] ?>" class="page-title-link" data-tracking="activity-title" ><?= $item['page_title'] ?></a>
                        </div>
                        <div class="edit-info">
                            <a class="edit-info-user" data-tracking="activity-username" href="<?= $item['user_profile_url'] ?>">
                                <?= User::isIP( $item['user_name'] ) ? wfMessage( 'oasis-anon-user' )->escaped() : htmlspecialchars( $item['user_name'] ) ?>
                            </a>
                            <? if ( !empty( $item['time_ago'] ) ): ?>
                                <span class="edit-info-time"> • <?=  wfTimeFormatAgo( $item['time_ago'] ) ?></span>
                            <? endif ?>
                        </div>
                    </li>
                <? endforeach; ?>
            </ul>
        <? endif; ?>

        <? if ( $renderCommunityEntryPoint ): ?>
            <?= F::app()->renderView( 'CommunityPageEntryPoint', 'Index' ) ?>
        <? endif; ?>
    <? endif; ?>
</section>
