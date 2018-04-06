<?php

use Swagger\Client\SiteAttribute\Api\SiteAttributeInternalApi;
use Swagger\Client\SiteAttribute\Api\SiteAttributeApi;
use Wikia\Factory\ServiceFactory;

/**
 * Delete one or more revisions by moving them to the archive table.
 *
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class UpdateMissingGuidelines extends Maintenance {

	const SERVICE_NAME = "site-attribute";
	const TIMEOUT = 60;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Update missing guidelines and language attributes";
	}

	public function execute() {
		global $wgTheSchwartzSecretToken;

		$wikiId = $this->getOption( 'wikiId', '' );
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();
		$api = $apiProvider->getApi(self::SERVICE_NAME, SiteAttributeApi::class);
		$api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

		$internalApi = $apiProvider->getApi(self::SERVICE_NAME, SiteAttributeInternalApi::class);
		$internalApi->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

		$wikia = WikiFactory::getWikiByID( $wikiId );
		$lang = $wikia->city_lang;

		$this->output( "Wiki id: $wikia->city_id \n" );
		$this->output( "Wiki lang: $lang \n" );
		$guidelinesText = empty( $this->langMap[ $lang ] ) ? $this->langMap[ 'en' ] : $this->langMap[ $lang ];
		$existingLangAttr = $api->getAttribute($wikiId, "languageCode")->getValue();
		$existingGuidelines = $api->getAttribute($wikiId, "guidelines")->getValue();

		$this->output( "Site lang: $existingLangAttr\n" );
		$this->output( "Site guidelines: \n$existingGuidelines\n" );
		$this->output( "New guidelines: \n$guidelinesText\n" );

		if ( empty( $existingGuidelines ) ) {
			$internalApi->internallySaveAttribute( $wikiId, "guidelines", $wgTheSchwartzSecretToken, $guidelinesText );

			$this->output( "Updated guidelines for $wikiId\n" );
		} else {
			$this->output( "Guidelines for $wikiId exists, skipping\n" );
		}
	}

	private $langMap = array(
		'de' => "1. Sei höflich und respektvoll im Umgang mit anderen Benutzern. Übe Toleranz und sorge dafür, dass die Diskussionen zivilisiert bleiben.\n\n2. Diskussionsfäden und Beiträge, in denen „Zustimmungen” gefordert werden, werden entfernt.\n\n3. Diskussionen, die nichts mit dem Thema zu tun haben, werden gelöscht.\n\n4. Wir tolerieren es nicht, wenn du dich als einen anderen Benutzer oder eine prominente Person ausgibst. Wenn wir dich gesperrt haben und du daraufhin ein neues Konto erstellst, wirst du wieder gesperrt und deine Beiträge werden gelöscht.\n\n5. Spammen, Trollen und Vandalismus jeder Art werden nicht toleriert. Die Beiträge werden gelöscht und dein Benutzerkonto gesperrt.\n\n6. Du hast etwas beobachtet, das nicht in Ordnung ist? Oder du hast eine Frage? \nSchreibe einem Fandom-Mitarbeiter mit diesem Link http://de.community.wikia.com/wiki/Spezial:Kontakt, oder über die Einstellungen in deiner App.",
		'en' => "1. Be nice and treat people with respect. Keep discussions civil and be open-minded about differing opinions.\n\n2. Threads and posts that solicit upvotes will be deleted.\n\n3. Off-topic conversations will be deleted.\n\n4. Impersonation of other users or famous people will not be tolerated. If you have been banned and return on a new account, your posts will be deleted and your new account(s) will be banned.\n\n5. Spamming, trolling, or vandalizing of any kind will be deleted and will lead to your account being banned.\n\n6. Ask for help. Notice something that doesn't seem right? Or do you just have a question? Contact Fandom staff through \"Give feedback\" on your app's Settings screen, or via http://community.wikia.com/wiki/Special:Contact.",
		'es' => "1. Sé amable y trata a las personas con respeto. Mantén discusiones de forma civilizada y ten la mente abierta sobre las opiniones de los demás.\n\n2. Se eliminarán los hilos y las discusiones en los que se soliciten votos.\n\n3. Se eliminarán las conversaciones fuera del tema.\n\n4. No será tolerada la suplantación de otros usuarios o personas famosas. Si has sido bloqueado y regresas con una nueva cuenta, se eliminarán tus mensajes y tu(s) nueva(s) cuenta(s) será(n) bloqueada(s).\n\n5. El spamming, el trolling, o el vandalismo de cualquier tipo será eliminado y conllevará a que la cuenta sea bloqueada.\n\n6. Pide ayuda. ¿Ves algo que no te parece bien? ¿O simplemente tienes una pregunta? Ponte en contacto con el staff de Fandom través de \"Comentarios y sugerencias\" en la pantalla de Configuración, o a través de http://comunidad.wikia.com/wiki/Especial:Contactar.",
		'fr' => "1. Soyez gentils et traitez les gens avec respect. Veillez à ce que les discussions restent courtoises et acceptez les divergences d'opinions.\n\n2. Les fils et les publications sollicitant des votes seront supprimés.\n\n3. Les conversations hors-sujet seront supprimées.\n\n4. Il est interdit de se faire passer pour un autre utilisateur ou une personne célèbre. Si vous avez été banni et que vous revenez avec un autre compte, vos publications seront supprimées et votre nouveau compte sera lui aussi banni.\n\n5. Il est interdit de spammer, troller ou vandaliser, sous peine d'être banni.\n\n6. N'hésitez pas à demander de l'aide si vous ne comprenez pas quelque chose ou si vous avez des questions. Contactez le staff de Fandom via le bouton « Envoyer des commentaires » dans les Paramètres de votre application ou via http://communaute.wikia.com/wiki/Special:Contact.",
		'it' => "1. Sii gentile e tratta gli altri con rispetto. Mantieni la discussione civile e cerca di essere tollerante verso opinioni differenti.\n\n2. Post con il solo scopo di chiedere voti saranno eliminati.\n\n3. Discussioni fuori tema saranno cancellate.\n\n4. Impersonare altri utenti o persone famose non è tollerato. Se sei stato bannato e sei tornato con un nuovo account, i tuoi post saranno rimossi e il tuo account sarà bannato assieme ad eventuali altri.\n\n5. Spam, trolling e vandalismi di qualsiasi tipo saranno rimossi e comporteranno il tuo ban.\n\n6. Chiedi aiuto. Hai notato qualcosa che non sembra apposto? O hai semplicemente una domanda? Contatta lo staff di Fandom tramite \"Dicci cosa ne pensi\" nella schermata delle impostazioni della tua app o tramite http://it.community.wikia.com/wiki/Speciale:Contatta.",
		'ja' => "1. 健全な交流の場となるように、他者の意見にも敬意を持って接しましょう。\n\n2. 「イイね！」をせがむようなスレッドは一律削除対象になります。\n\n3. コミュニティと関係のない内容を含むスレッドは一律削除対象になります。\n\n4. なりすまし行為は厳重な処罰の対象となります。スレッドの削除の後、該当アカウントはブロックされます。新規アカウントを獲得し新規にスレッドを作成した場合も、削除の対象となり該当アカウントはブロックされます。\n\n5. スパム・煽り・荒らしとみなされる投稿は全て削除され、該当するアカウントはブロックされます。\n\n6. 何かおかしいと感じたり、わからないことがあるときには、設定メニューの「フィードバックを送る」のセクションか、 ja.community.wikia.com/wiki/Special:Contact から、お気軽にFandom スタッフまでご連絡ください。",
		'pl' => "1. Bądź miły i odnoś się do innych z szacunkiem. Otwieraj się na różnorodne opinie.\n\n2. Posty mające na celu zbieranie okejek będą usuwane.\n\n3. Dyskusje bez związku z tematem wiki będą usuwane.\n\n4. Podszywanie się pod innych użytkowników lub sławne osoby nie będzie tolerowane. Jeśli zostałeś zablokowany i powrócisz na innym koncie, twoje posty zostaną usunięte, a nowe konto zablokowane.\n\n5. Spamowanie, trollowanie i wandalizowanie w jakikolwiek sposób będzie usuwane i doprowadzi do blokady na twoim koncie.\n\n6. Pytaj o pomoc. Zauważyłeś coś, co nie działa tak jak powinno? Masz pytanie? Skontaktuj się z personelem Fandomu przez opcję „Przekaż nam swoją opinię” na ekranie ustawień twojej aplikacji lub poprzez stronę http://community.wikia.com/wiki/Special:Contact.",
		'pt-br' => "1. Seja cordial e trate as pessoas com respeito. Mantenhas as discussões civilizadas e tolerantes às opiniões diferentes.\n\n2. Conversas e postagens que pedem por \\\"votos\\\" serão deletadas.\n\n3. Conversas fora do tópico serão deletadas.\n\n4. Personificação de outros usuários e pessoas famosas não serão toleradas. Se você foi banido e voltou com outra conta, os seus posts serão deletados e a sua nova conta será banida.\n\n5. Spam, trolagem e vandalismo de qualquer forma serão deletados e a sua conta será banida.\n\n6. Peça ajuda. Você viu algo que não parece estar certo? Ou você tem uma pergunta? Entre em contato com um membro do staff via \\\"Enviar feedback\\\" na tela de configurações, ou via http://comunidade.wikia.com/wiki/Especial:Contact.",
		'ru' => "1. Будьте вежливы друг к другу. Не грубите участникам и относитесь непредвзято к чужим мнениям.\n\n2. Сообщения и ответы, которые настойчиво требуют оценок, будут удалены.\n\n3. Явный офтопик будет удалён.\n\n4. Попытки выдать себя за другого пользователя или известного человека будут наказаны. Если вас заблокировали, но вы создали новый аккаунт, то все ваши сообщения будут удалены, а ваш новый аккаунт — заблокирован.\n\n5. Спам, троллинг и вандализм будут удалены, а ваша учётная запись, скорее всего, будет заблокирована.\n\n6. Не бойтесь спрашивать, если вам что-то непонятно. Хотите сообщить о нарушении? Просто есть вопрос? Вы можете связаться с сотрудниками Фэндома с помощью опции «Оставьте свой отзыв» в меню Настроек или через форму http://ru.community.wikia.com/wiki/Special:Contact.",
		'zh-cn' => "1. 请尊重并友善对待其他用户。让论坛能文明且容纳不同的意见。 \n\n2. 纯粹用于要求其他人点赞的帖子会被删除。\n\n3. 离题的讨论会被删除。 \n\n4. 不允许假装成其他用户或名人。如果你被封禁却又使用新的帐户来发言，你的文章会被删除，你的帐户都会被封禁。 \n\n5. 各种破坏、扰乱、发布垃圾讯息的内容会被删除，且会导致你的帐户被封禁。\n\n6. 寻求协助。发现有不对的地方？或是有任何疑问？请使用设定窗口中的“发送反馈”联络Fandom的工作人员或者通过http://zh.community.wikia.com/wiki/Special:Contact进行联络。",
		'zh-tw' => "1. 請尊重並友善對待其他使用者。讓討論版能文明且容納不同的意見。\n\n2. 純粹用於要求其他人點讚的文章會被刪除。\n\n3. 離題的討論會被刪除。\n\n4. 不允許假裝成其他用戶或有名的人。如果你被封禁卻又使用新的帳號來發言，你的文章會被刪除，你的帳號都會被封禁。\n\n5. 各種破壞、擾亂的內容和垃圾訊息會被刪除，且會導致你的帳號被封禁。\n\n6. 尋求協助。注意到什麼錯誤嗎？或你只是有一些疑問？使用App中的設定視窗中的「反饋」或者通过http://zh.community.wikia.com/wiki/Special:Contact 來聯繫Fandom工作人員。"
	);
}

$maintClass = "UpdateMissingGuidelines";
require_once( RUN_MAINTENANCE_IF_MAIN );
