<?php
/**
 * Egyptian Arabic language file for the 'StableVersion' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
			'stableversion_this_is_stable' => 'هى دى النسخة المستقرة للمقالة دى. ممكن تبص ل<a href="$1">آخر نسخة مسودة</a>.',
			'stableversion_this_is_stable_nourl' => 'هى دى النسخة المستقرة للمقالة دى.',
			'stableversion_this_is_draft_no_stable' => 'أنت بتبص لنسخة مسودة للمقالة دى؛ مفيش نسخة مستقرة لهذه المقالة بعد.',
			'stableversion_this_is_draft' => 'هى دى نسخة مسودة للمقالة دى. يمكنك أيضا أن تبص ل<a href="$1">النسخة المستقرة</a>.',
			'stableversion_this_is_old' => 'دى نسخة قديمة للمقالة دى. ممكن أيضا أن تبص ل<a href="$1">النسخة المستقرة</a>، أو <a href="$2">آخر نسخة مسودة</a>.',
			'stableversion_reset_stable_version' => 'اضغط <a href="$1">هنا</a> لإزالة هذه كالنسخة المختارة!',
			'stableversion_set_stable_version' => 'اضغط <a href="$1">هنا</a> لضبط هذه كالنسخة المستقرة!',
			'stableversion_set_ok' => 'النسخة المستقرة تم ضبطها بنجاح.',
			'stableversion_reset_ok' => 'النسخة المستقرة تمت إزالتها بنجاح. المقالة دى مفيش فيها نسخة مستقرة حاليا.',
			'stableversion_return' => 'الرجوع إلى <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'النسخة المستقرة تمت إزالتها.',
			'stableversion_logpage' => 'سجل النسخة المستقرة',
			'stableversion_logpagetext' => 'هذا سجل بالتغييرات للنسخ المستقرة',
			'stableversion_logentry' => '',
			'stableversion_log' => 'المراجعة #$1 هى النسخة المستقرة الآن.',
			'stableversion_before_no' => 'لم تكن هناك مراجعة مستقرة قبل كده.',
			'stableversion_before_yes' => 'آخر مراجعة مستقرة كانت #$1.',
			'stableversion_this_is_stable_and_current' => 'هذه هي النسخة المستقرة و آخر نسخة.',
			'stableversion_noset_directional' => '(لا يمكن الضبط أو تغيير الضبط في التاريخ التوجيهى)',
	)

);

