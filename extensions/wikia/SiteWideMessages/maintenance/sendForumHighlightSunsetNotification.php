<?php

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class SendForumHighlightSunsetNotification extends Maintenance {

	const MESSAGES_PER_LANG = [
		'en' => 'Highlighting Forum threads is [https://community.wikia.com/wiki/Thread:1565872 no longer possible] after $1. Instead, you can use Announcements to notify your community about important news.',
		'de' => 'Der Hervorheben von Foren-Threads ist ab dem 10. Dezember [http://de.community.wikia.com/wiki/Benutzer_Blog:Mira_Laime/Ab_Mitte_Dezember_k%C3%B6nnen_Foren-Threads_nicht_mehr_hervorgehoben_werden nicht mehr möglich]. Stattdessen kannst du Mitteilungen erstellen, um deine Community über wichtige Neuigkeiten zu informieren.',
		'es' => 'El destacar hilos en el foro será [https://comunidad.wikia.com/wiki/Hilo:151586 retirado] el 10 de diciembre. En su reemplazo, los administradores pueden usar Anuncios para notificar a su comunidad sobre cosas relevantes.',
		'fr' => 'Épingler les fils du Forum ne sera [https://communaute.wikia.com/wiki/Fil:62448 plus possible] après le 10 décembre. À la place, nous vous conseillons d\'utiliser les Annonces pour notifier votre communauté quand vous avez des nouvelles importantes à communiquer.',
		'it' => 'Mettere in evidenza un forum [http://it.community.wikia.com/wiki/Conversazione:18835 non sarà più possibile] dopo il 10 dicembre. Si potranno invece creare degli Annunci per notificare la propria comunità.',
		'ja' => 'フォーラムのハイライト機能は12月10日以降[http://ja.community.wikia.com/wiki/%E3%82%B9%E3%83%AC%E3%83%83%E3%83%89:9887 ご利用できなくなります]。その代わり、お知らせ機能を使ってコミュニティに重要なニュースを告知することができます。',
		'pl' => 'Wyróżnianie wątków na Forum [http://spolecznosc.wikia.com/wiki/W%C4%85tek:51360 nie będzie możliwe] po 10 grudnia. Zamiast tego, możesz użyć Ogłoszeń by poinformować Twoją społeczność o ważnych wydarzeniach.',
		'pt-br' => 'Os artigos de destaques do fórum [https://comunidade.wikia.com/wiki/Conversa:27521 estarão indisponíveis] após o dia 10 de Dezembro. No lugar você pode usar os Anúncios para notificar sua comunidade de notícias importantes.',
		'ru' => 'Функция "Сообщить всем" с форума будет удалена после 10 декабря. [http://ru.community.wikia.com/wiki/%D0%A2%D0%B5%D0%BC%D0%B0:139214 Подробнее см. здесь]. Вы можете использовать Объявления для информирования участников вики.',
		'zh-hans' => '论坛中的突出显示讨论功能将在[http://zh.community.wikia.com/wiki/%E5%B8%96%E5%AD%90:20761 12月10日后停止使用]。管理员可以使用公告功能发布社区消息。',
		'zh-hant' => '論壇中的突出顯示討論功能將在[http://zh.community.wikia.com/wiki/%E5%B8%96%E5%AD%90:20761 12月10日後停止使用]。 管理員可以使用公告功能發佈社群消息。',
	];

	public function execute() {
		$this->notifyAdmins(
			$this->createNotificationsForLanguages()
		);
	}

	private function createNotificationsForLanguages(): array {
		global $wgExternalSharedDB;

		$robot = User::newFromName( Wikia::USER );
		$robotId = $robot->getId();

		$messageIdsPerLang = [];

		$dbw = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );

		foreach ( static::MESSAGES_PER_LANG as $langCode => $message ) {

			$row = [
				'msg_sender_id' => $robotId,
				'msg_text' => $message,
				'msg_mode' => 1,
				'msg_lang' => $langCode
			];

			$dbw->insert( 'messages_text', $row, __METHOD__ );

			$messageIdsPerLang[$langCode] = $dbw->insertId();
		}

		return $messageIdsPerLang;
	}

	private function notifyAdmins( array $messageIdsPerLang ) {
		global $wgExternalSharedDB;

		$rows = [];

		foreach ( $this->getAdminsOnWikis( $this->getWikisWithForumEnabled() ) as $data ) {
			list ( $wikiId, $userId ) = $data;

			$user = User::newFromId( $userId );
			$langCode = $user->getGlobalPreference( 'language' );

			$rows[] = [
				'msg_wiki_id' => $wikiId,
				'msg_recipient_id' => $userId,
				'msg_id' => $messageIdsPerLang[$langCode],
				'msg_status' => 0
			];
		}

		$dbw = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );

		$dbw->insert( 'messages_status', $rows, __METHOD__ );
	}

	private function getAdminsOnWikis( array $wikiIds ) {
		global $wgSpecialsDB;

		$dbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );

		$sysop = $dbr->addQuotes( 'sysop' );
		$sysopWildcard = $dbr->buildLike( $dbr->anyString(), 'sysop', $dbr->anyString() );

		$res = $dbr->select(
			'events_local_users',
			[ 'distinct(user_id) as user_id', 'wiki_id' ],
			[ 'wiki_id' => $wikiIds, "single_group = $sysop OR all_groups $sysopWildcard" ],
			__METHOD__
		);

		foreach ( $res as $row ) {
			yield [ $row->wiki_id, $row->user_id ];
		}
	}

	private function getWikisWithForumEnabled() {
		global $wgExternalSharedDB;

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$res = $dbr->select(
			[ 'city_variables', 'city_variables_pool' ],
			'cv_city_id',
			[ 'cv_name' => 'wgEnableForumExt', 'cv_value' => serialize( true ) ],
			__METHOD__,
			[],
			[ 'city_variables_pool' => [ 'INNER JOIN', 'cv_variable_id = cv_id' ] ]
		);

		$wikiIds = [];

		foreach ( $res as $row ) {
			$wikiIds[] = $row->cv_city_id;
		}

		return $wikiIds;
	}
}

$maintClass = SendForumHighlightSunsetNotification::class;
require_once RUN_MAINTENANCE_IF_MAIN;
