<?php
/** Internationalization file for /extensions/wikia/ImageReview/ImageReview extension. */
$messages = [];

$messages['en'] = [
	'imagereview-desc' => 'Internal tool to help review images post-upload and remove Terms of Use violations',
	'imagereview-reason' => 'Violation of FANDOM\'s [[wikia:Terms of Use|Terms of Use]]',
	'imagereview-header' => 'Images awaiting review',
	'imagereview-header-questionable' => 'Questionable images awaiting staff review',
	'imagereview-header-rejected' => 'Rejected images awaiting staff review',
	'imagereview-header-invalid' => 'Invalid images awaiting staff review',
	'imagereview-noresults' => 'No images found.',
	'imagereview-state-0' => 'Unreviewed',
	'imagereview-state-1' => 'In review',
	'imagereview-state-2' => 'Approved',
	'imagereview-state-3' => 'Deleted',
	'imagereview-state-4' => 'Rejected',
	'imagereview-state-5' => 'Questionable',
	'imagereview-label-ok' => 'Mark as OK',
	'imagereview-label-delete' => 'Delete',
	'imagereview-label-questionable' => 'Questionable',
	'imagereview-gotoimage' => 'Go to image page',
	'imagereview-option-ok' => 'OK',
	'imagereview-option-delete' => 'Del',
	'imagereview-option-questionable' => 'Q',
	'imagereview-imagepage-header' => 'Image Review history',
	'imagereview-imagepage-not-in-queue' => 'Warning: this image has not been added to the review queue.',
	'imagereview-imagepage-table-header-reviewer' => 'Reviewer',
	'imagereview-imagepage-table-header-state' => 'State',
	'imagereview-imagepage-table-header-time' => 'Time',
	'right-imagereview' => 'Allows access to Special:ImageReview',
	'right-imagereviewstats' => 'Allows access to Special:ImageReview/stats',
	'right-questionableimagereview' => 'Allows access to Special:ImageReview/questionable',
	'right-rejectedimagereview' => 'Allows access to Special:ImageReview/rejected',
	'right-imagereviewcontrols' => 'Allows access to image review controls',
	'right-promoteimagereview' => 'Allows access to Special:PromoteImageReview',
	'right-promoteimagereviewquestionableimagereview' => 'Allows access to Special:PromoteImageReview/questionable',
	'right-promoteimagereviewrejectedimagereview' => 'Allows access to Special:PromoteImageReview/rejected',
	'right-promoteimagereviewstats' => 'Allows access to Special:PromoteImageReview/stats',
	'right-promoteimagereviewcontrols' => 'View controls on images uploaded through Special:Promote',
];

$messages['qqq'] = [
	'imagereview-desc' => '{{desc}}',
	'imagereview-label-ok' => 'Label tooltip content for option to mark an image as OK.',
	'imagereview-label-delete' => 'Label tooltip content for option to mark an image for deletion.',
	'imagereview-label-questionable' => 'Label tooltip content for option to mark an image as questionable.',
	'imagereview-gotoimage' => 'Tooltip for link to go to image page',
	'imagereview-option-ok' => 'Text of option to mark an image as OK.',
	'imagereview-option-delete' => 'Text of option to mark an image for deletion.',
	'imagereview-option-questionable' => 'Text of option to mark an image as questionable.',
	'imagereview-reason' => 'Missing documentation',
];

$messages['pl'] = [
	'imagereview-reason' => 'Naruszenie [[wikia:Terms of Use|Regulaminu]] portalu FANDOM',
	'imagereview-header-questionable' => 'Wątpliwe obrazy czekające na przegląd',
	'imagereview-header-rejected' => 'Odrzucone obrazy czekające na przegląd',
	'imagereview-header' => 'Obrazy oczekujące na przegląd',
	'imagereview-imagepage-header' => 'Historia przeglądu obrazów',
	'imagereview-imagepage-not-in-queue' => 'Uwaga: ten obraz nie został dodany do kolejki obrazów oczekujących na przegląd.',
	'imagereview-imagepage-table-header-reviewer' => 'Przeglądający',
	'imagereview-imagepage-table-header-state' => 'Status',
	'imagereview-imagepage-table-header-time' => 'Data',
	'imagereview-noresults' => 'Nie znaleziono obrazów.',
	'imagereview-state-0' => 'Nie przejrzany',
	'imagereview-state-1' => 'W trakcie przeglądu',
	'imagereview-state-2' => 'Zatwierdzony',
	'imagereview-state-3' => 'Usunięty',
	'imagereview-state-4' => 'Odrzucony',
	'imagereview-state-5' => 'Wątpliwy',
];

$messages['de'] = [
	'imagereview-reason' => 'Verletzung der [http://de.wikia.com/Nutzungsbedingungen Nutzungsbedingungen] von FANDOM',
	'imagereview-header-questionable' => 'Fragwürdige Bilder, die von den Mitarbeitern noch geprüft werden müssen',
	'imagereview-header-rejected' => 'Zurückgewiesene Bilder, die von Mitarbeitern noch überprüft werden müssen',
	'imagereview-header' => 'Bilder, die noch nicht überprüft wurden',
	'imagereview-imagepage-header' => 'Bilderüberprüfungsversionsgeschichte',
	'imagereview-imagepage-not-in-queue' => 'Warnung: Dieses Bild wurde noch nicht zur Überprüfung durch einen Mitarbeiter übermittelt',
	'imagereview-imagepage-table-header-reviewer' => 'Prüfer',
	'imagereview-imagepage-table-header-state' => 'Status',
	'imagereview-imagepage-table-header-time' => 'Datum',
	'imagereview-noresults' => 'Keine Bilder gefunden.',
	'imagereview-state-0' => 'Noch nicht überprüft',
	'imagereview-state-1' => 'Wird überprüft',
	'imagereview-state-2' => 'Zugelassen',
	'imagereview-state-3' => 'Gelöscht',
	'imagereview-state-4' => 'Zurückgewiesen',
	'imagereview-state-5' => 'Fragwürdig',
];

$messages['fr'] = [
	'imagereview-reason' => 'Infraction aux [[wikia:Terms of Use|Conditions d\'utilisation]] de FANDOM',
	'imagereview-header-questionable' => 'Images discutables en attente de vérification par le staff',
	'imagereview-header-rejected' => 'Images rejetées en attente de vérification par le staff',
	'imagereview-header' => 'Images en attente de vérification',
	'imagereview-imagepage-header' => 'Historique des vérifications d\'image',
	'imagereview-imagepage-not-in-queue' => 'Attention : cette image n\'a pas été ajoutée à la file des vérifications.',
	'imagereview-imagepage-table-header-reviewer' => 'Vérifiée par',
	'imagereview-imagepage-table-header-state' => 'Statut',
	'imagereview-imagepage-table-header-time' => 'Date',
	'imagereview-noresults' => 'Aucune image trouvée.',
	'imagereview-state-0' => 'Non vérifiée',
	'imagereview-state-1' => 'En cours de vérification',
	'imagereview-state-2' => 'Approuvée',
	'imagereview-state-3' => 'Supprimée',
	'imagereview-state-4' => 'Rejetée',
	'imagereview-state-5' => 'Discutable',
];

$messages['ru'] = [
	'imagereview-reason' => 'Нарушение [[w:c:ru.community:Викия:Условия_использования|Условий использования]] Фэндома',
	'imagereview-noresults' => 'Изображения не найдены.',
];

$messages['es'] = [
	'imagereview-reason' => 'Violación de los [[w:c:es:Términos de uso|Términos de uso]] de FANDOM',
];

$messages['it'] = [
	'imagereview-reason' => 'Violazione dei [[w:it:Project:Termini di utilizzo|Termini di utilizzo]] di FANDOM',
];

$messages['ja'] = [
	'imagereview-reason' => 'Fandomの[[w:c:ja:利用規約|利用規約]]違反',
];

$messages['pt'] = [
	'imagereview-reason' => 'Violação dos [[w:c:comunidade:Termos_de_uso|Termos de uso]] do FANDOM',
];

$messages['zh-hans'] = [
	'imagereview-reason' => '违反Fandom[http://zh.wikia.com/wiki/%E4%BD%BF%E7%94%A8%E6%9D%A1%E6%AC%BE 使用条款]',
	'imagereview-imagepage-header' => '图片检查历史',
	'imagereview-imagepage-table-header-state' => '状态',
];

$messages['zh-hant'] = [
	'imagereview-reason' => '違反Fandom[http://zh-tw.wikia.com/wiki/%E4%BD%BF%E7%94%A8%E6%A2%9D%E6%AC%BE 使用條款]',
	'imagereview-imagepage-header' => '圖片檢查歷史',
	'imagereview-imagepage-table-header-state' => '狀態',
];

$messages['zh'] = [
	'imagereview-imagepage-header' => '图片检查历史',
	'imagereview-imagepage-table-header-state' => '状态',
];

$messages['zh-hk'] = [
	'imagereview-imagepage-header' => '圖片檢查歷史',
	'imagereview-imagepage-table-header-state' => '狀態',
];

$messages['zh-tw'] = [
	'imagereview-imagepage-header' => '圖片檢查歷史',
	'imagereview-imagepage-table-header-state' => '狀態',
];

