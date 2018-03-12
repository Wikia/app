<?php
/** Serbian (Српски / Srpski)
 *
 * @ingroup Language
 * @file
 *
 * @author Misos
 * @author Terik
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */

$fallback = 'sr-ec';
$linkTrail = '/^([abvgdđežzijklljmnnjoprstćufhcčdžšабвгдђежзијклљмнњопрстћуфхцчџш]+)(.*)$/usD';
$pluralRules = [
	"v = 0 and i % 10 = 1 and i % 100 != 11 or f % 10 = 1 and f % 100 != 11",
	"v = 0 and i % 10 = 2..4 and i % 100 != 12..14 or f % 10 = 2..4 and f % 100 != 12..14",
];
