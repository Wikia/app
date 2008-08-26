<?php
/**
 * Indonesian language file for the 'StableVersion' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
			'stableversion_this_is_stable' => 'Ini adalah versi stabil dari artikel ini. Anda juga dapat melihat <a href="$1">versi draf terakhir</a>.',
			'stableversion_this_is_stable_nourl' => 'Ini adalah versi stabil dari artikel ini.',
			'stableversion_this_is_draft_no_stable' => 'Anda sedang melihat versi draf artikel ini; belum ada versi stabil dari artikel ini.',
			'stableversion_this_is_draft' => 'Ini adalah versi draf dari artikel ini. Anda juga dapat melihat <a href="$1">versi stabil</a>.',
			'stableversion_this_is_old' => 'Ini adalah versi lama dari artikel ini. Anda juga dapat melihat <a href="$1">versi stabil</a>, atau <a href="$2">versi draf terakhir</a>.',
			'stableversion_reset_stable_version' => 'Klik <a href="$1">di sini</a> untuk membuang versi stabil ini!',
			'stableversion_set_stable_version' => 'Klik <a href="$1">di sini</a> untuk membuat ini menjadi versi stabil!',
			'stableversion_set_ok' => 'Versi stabil berhasil diset.',
			'stableversion_reset_ok' => 'Versi stabil berhasil dibuang. Artikel ini tidak lagi memiliki versi stabil.',
			'stableversion_return' => 'Kembali ke <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'Versi stabil berhasil dibuang.',
			'stableversion_logpage' => 'Log versi stabil',
			'stableversion_logpagetext' => 'Berikut ini adalah log perubahan versi stabil',
			'stableversion_logentry' => '',
			'stableversion_log' => 'Revisi #$1 saat ini adalah versi stabil.',
			'stableversion_before_no' => 'Sebelumnya tidak ada versi stabil.',
			'stableversion_before_yes' => 'Versi stabil terakhir adalah #$1.',
			'stableversion_this_is_stable_and_current' => 'Ini adalah versi stabil dan terakhir.',
			'stableversion_noset_directional' => '(Tidak dapat mengeset atau mereset pada riwayat arah)',
	)
);

