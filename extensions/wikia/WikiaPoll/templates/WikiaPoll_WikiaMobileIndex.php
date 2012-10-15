<aside class=WikiaPoll data-id="<?= $poll->getId() ?>"><div class=pollHeader><?= htmlspecialchars( $wf->Msg( 'wikiapoll-question', $poll->getTitle() ) ); ?></div>
<ul>
<?php foreach( $data['answers'] as $n => $answer ) { ?>
<li><div class=answer><?= htmlspecialchars( $answer['text'] ) ?></div>
<div class=bar><div class=percentage style=width:<?= $answer['percentage']; ?>%></div></div><span class=perc><?= $answer['percentage']; ?>%</span></li>
<?php } ?>
</ul><? if( $showButton ) { ?><button class="wkBtn openPoll"><?= $wf->Msg('wikiamobile-wikiapoll-open-poll'); ?></button>
<? } else { ?><div class=userVoted><?= $wf->Msg('wikiamobile-wikiapoll-user-voted', $data['answers'][$answerNum]['text']);?></div><? } ?>
<div class=votes><?= $wf->MsgExt( 'wikiapoll-people-voted', array( 'parsemag' ), $wg->Lang->formatNum( $data['votes'] ) ); ?></aside>