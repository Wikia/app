<?php
/**
 * Internationalization file for the AJAX Poll extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Dariusz Siedlecki
 */
$messages['en'] = array(
	'poll-vote-update' => 'Your vote has been updated.',
	'poll-vote-add' => 'Your vote has been added.',
	'poll-vote-error' => 'There was a problem with processing your vote, please try again.',
	'poll-percent-votes' => '$1% of all votes', // $1 is the percentage number of the votes
	'poll-your-vote' => 'You already voted for "$1" on $2, you can change your vote by clicking an answer below.', // $1 is the answer name, $2 is the date when the answer was casted
	'poll-no-vote' => 'Please vote below.', // http://trac.wikia-code.com/changeset/867
	'poll-info' => 'There {{PLURAL:$1|was one vote|were $1 votes}} since the poll was created on $2.', // $1 is the number of votes, $2 is when the poll was started
	'poll-submitting' => 'Please wait, submitting your vote.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'poll-vote-update' => 'U stem is opgedateer.',
	'poll-vote-add' => 'U stem is bygevoeg.',
	'poll-percent-votes' => '$1% van alle stemme',
	'poll-no-vote' => 'Stem asseblief hier onder.',
);

/** Arabic (العربية)
 * @author OsamaK
 */
$messages['ar'] = array(
	'poll-vote-update' => 'تم تحديث صوتك.',
	'poll-vote-add' => 'تم إضافة تصويتك',
	'poll-info' => 'هذه كانت $1 تصويتا منذ بداية التصويت في $2.', // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => 'من فضلك انتظر، يرسل صوتك.',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'poll-vote-update' => 'Hizivaet eo bet ho vot.',
	'poll-vote-add' => 'Ouzhpennet eo bet ho vot.',
	'poll-vote-error' => "Ur gudenn a zo bet pa vezer oc'h ober war-dro ho vot. Mar plij klaskit adarre.",
	'poll-percent-votes' => '$1% eus hollad ar mouezhioù',
	'poll-your-vote' => "Votet ho peus dija evit \"$1\" d'an $2, tu 'zo deoc'h kemmañ ho vot en ur klikañ war unan eus ar respontoù da heul.",
	'poll-no-vote' => 'Mar plij votit amañ dindan.',
	'poll-info' => "$1 vot a zo bet abaoe ma 'z eo bet krouet ar sontadeg war $2.", // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => "Mar plij gortozit, emeur oc'h ober war-dro ho vot.",
);

/** German (Deutsch)
 * @author Tim 'Avatar' Bartel
 */
$messages['de'] = array(
	'poll-vote-update' => 'Deine Stimme wurde aktualisiert.',
	'poll-vote-add' => 'Deine Stimme wurde gezählt.',
	'poll-vote-error' => 'Es gab ein Problem bei der Verarbeitung deiner Stimme. Probiere es bitte noch einmal.',
	'poll-percent-votes' => '$1% aller Stimmen',
	'poll-your-vote' => 'Du hast bereits für "$1" abgestimmt (am $2). Du kannst deine Stimme ändern, indem du eine der untenstehenden Antworten anklickst.',
	'poll-no-vote' => 'Bitte stimme unten ab.',
	'poll-info' => 'Es gab $1 Stimmen, seit der Erstellung der Umfrage am $2.', // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => 'Bitte warte kurz, deine Stimme wird verarbeitet.',
);

/** Greek (Ελληνικά)
 * @author Περίεργος
 */
$messages['el'] = array(
	'poll-vote-update' => 'Η ψήφος σας έχει ενημερωθεί.',
	'poll-vote-add' => 'Η ψήφος σας προστέθηκε.',
	'poll-vote-error' => 'Παρουσιάστηκε πρόβλημα κατά την επεξεργασία της ψήφους σας, παρακαλώ ξαναπροσπαθήστε.',
	'poll-percent-votes' => '$1% επί των συνολικών ψήφων',
	'poll-your-vote' => 'Έχετε ήδη ψηφίσει το $1 στο $2, μπορείτε να αλλάξετε τη ψήφο σας πατώντας μια απάντηση παρακάτω.',
	'poll-no-vote' => 'Παρακαλώ ψηφίστε παρακάτω.',
	'poll-info' => 'Υπάρχουν $1 ψήφοι από τότε που δημιουργήθηκε η ψηφοφορία στις $2.', // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => 'Παρακαλώ περιμένετε,η ψήφο σας υποβάλλεται.',
);

/** Spanish (Español)
 * @author Bola
 */
$messages['es'] = array(
	'poll-vote-update' => 'Tu voto ha sido actualizado.',
	'poll-vote-add' => 'Tu voto ha sido añadido.',
	'poll-vote-error' => 'Ha habido un problema cuando comprobábamos tu voto, por favor, inténtalo de nuevo.',
	'poll-percent-votes' => '$1% de todos los votos',
	'poll-your-vote' => 'Ya votaste por "$1" el $2, puedes cambiar tu voto haciendo clic en una respuesta debajo.',
	'poll-no-vote' => 'Por favor, vota debajo.',
	'poll-info' => 'Ha habido {{PLURAL:$1|un voto|$1 votos}} desde que la encuesta fue creada el $2.',
	'poll-submitting' => 'Por favor espera, estamos comprobando tu voto, ten paciencia.',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'poll-vote-update' => 'Äänesi on päivitetty',
	'poll-vote-add' => 'Äänesi on lisätty.',
	'poll-vote-error' => 'Äänesi prosessoimisessa oli ongelma, yritä uudelleen.',
	'poll-percent-votes' => '$1% kaikista äänistä',
	'poll-your-vote' => 'Äänestit jo vaihtoehtoa "$1" $2, voit muuttaa ääntäsi napsauttamalla vastausta alempana',
	'poll-no-vote' => 'Äänestä alempana.',
	'poll-info' => '{{PLURAL:$1|Yksi ääni|$1 ääntä}} on annettu siitä lähtien kun tämä äänestys tehtiin, $2.',
	'poll-submitting' => 'Odota hetki, lähetetään ääntäsi.',
);

/** French (Français)
 * @author Tim 'Avatar' Bartel
 */
$messages['fr'] = array(
	'poll-vote-update' => 'Ta voix est actualisé.',
	'poll-vote-add' => 'Ta voix était compté.',
	'poll-vote-error' => "Il y avait une problème avec le traitement de ta voix. Essaie-cela s'il te plaît encore une fois.",
	'poll-percent-votes' => '$1% de tous voix.',
	'poll-your-vote' => "Tu a déjà voté pour $1 (à $2). Tu peux changer ta voix, si tu cliques à l'une des réponses en bas.",
	'poll-no-vote' => 'Vote en bas.',
	'poll-info' => "Il y avait {{PLURAL:$1|une voix|$1 voix}}, depuis l'élaboration du sondage au $2.",
	'poll-submitting' => 'Attends une moment, ta voix est traité...',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'poll-vote-update' => 'Actualizouse o seu voto.',
	'poll-vote-add' => 'Engadiuse o seu voto.',
	'poll-vote-error' => 'Houbo algún problema co procesamento do seu voto, por favor, inténteo de novo.',
	'poll-percent-votes' => '$1% do total dos votos',
	'poll-your-vote' => 'Xa votou por "$1" o $2, pode cambiar o seu voto premendo nunha resposta das que aparecen a continuación.',
	'poll-no-vote' => 'Por favor, vote a continuación.',
	'poll-info' => 'Recibíronse {{PLURAL:$1|un voto|$1 votos}} des que a enquisa foi creada o $2.',
	'poll-submitting' => 'Por favor, agarde durante o envío do seu voto.',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'poll-vote-update' => 'A szavazatod frissítve.',
	'poll-vote-add' => 'A szavazatod rögzítve.',
	'poll-no-vote' => 'Kérlek szavazz alant.',
	'poll-submitting' => 'Kérlek várj a szavazatod elküldésére.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'poll-vote-update' => 'Tu voto ha essite actualisate.',
	'poll-vote-add' => 'Tu voto ha essite addite.',
	'poll-vote-error' => 'Un problema occurreva durante le tractamento de tu voto. Per favor reproba.',
	'poll-percent-votes' => '$1% de tote le votos',
	'poll-your-vote' => 'Tu ha ja votate pro "$1" in $2. Tu pote cambiar tu voto per cliccar super un responsa hic infra.',
	'poll-no-vote' => 'Per favor vota hic infra.',
	'poll-info' => 'Il habeva $1 votos post le creation del sondage le $2.', // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => 'Un momento, tu voto es submittite.',
);

/** Japanese (日本語)
 * @author Shun Fukuzawa
 */
$messages['ja'] = array(
	'poll-vote-update' => '投票を更新しました。',
	'poll-vote-add' => '投票が追加されました。',
	'poll-vote-error' => '問題が発生しました。少ししてから再度投票してください。',
	'poll-percent-votes' => '全体の$1%',
	'poll-your-vote' => '$2について、$1に投票しています。以下の回答をクリックすると、投票を変更できます。',
	'poll-no-vote' => 'さあ、投票しよう!',
	'poll-submitting' => '投票を処理しています。少しお待ちください。',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'poll-vote-update' => 'Вашиот глас е подновен.',
	'poll-vote-add' => 'Вашиот глас е додаден.',
	'poll-vote-error' => 'Се појави проблем при обработката на вашиот глас. Обидете се повторно.',
	'poll-percent-votes' => '$1% од вкупниот број на гласови',
	'poll-your-vote' => 'Веќе имате гласано за „$1“ на $2; можете да го промените гласот со кликнување на еден од одговорите подолу.',
	'poll-no-vote' => 'Гласајте подолу.',
	'poll-info' => 'Откако е создадена анкетата ($2) гласано е $1 пати.', // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => 'Почекајте, го заведувам вашиот глас.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'poll-vote-update' => 'Uw stem is bijgewerkt.',
	'poll-vote-add' => 'Uw stem is toegevoegd.',
	'poll-vote-error' => 'Er is een probleem opgetreden tijdens het verwerken van uw stem. Probeer het opnieuw.',
	'poll-percent-votes' => '$1% van alle stemmen',
	'poll-your-vote' => 'U hebt al voor "$1" gestemd op $2. U kunt uw stem wijzigen door hieronder op een antwoord te klikken.',
	'poll-no-vote' => 'Stem hieronder.',
	'poll-info' => 'Er zijn {{PLURAL:$1|een stem|$1 stemmen}} uitgebracht sinds de peiling op $2 is aangemaakt.',
	'poll-submitting' => 'Even geduld alstublieft. Uw stem wordt opgeslagen...',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'poll-vote-update' => 'Din stemme har blitt oppdatert.',
	'poll-vote-add' => 'Din stemme har blitt lagt til.',
	'poll-vote-error' => 'Det oppstod et problem med behandlingen av din stemme, vennligst prøv igjen.',
	'poll-percent-votes' => '$1% av alle stemmer',
	'poll-your-vote' => 'Du har allerede stemt på «$1» den $2, du kan endre din stemme ved å klikke på et svar nedenfor.',
	'poll-no-vote' => 'Vennligst stem nedenfor.',
	'poll-info' => 'Det var $1 stemmer siden spørreundersøkelsen ble opprettet den $2.', // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => 'Vennligst vent, sender inn stemmen din.',
);

/** Polish (Polskie)
 * @author Dariusz Siedlecki
 */
$messages['pl'] = array(
	'poll-vote-update' => 'Twój głos został zmieniony.',
	'poll-vote-add' => 'Twój głos został dodany.',
	'poll-vote-error' => 'Wystąpił błąd w czasie dodawania głosu, proszę spróbować później.',
	'poll-percent-votes' => '$1% wszystkich głosów',
	'poll-your-vote' => 'Zagłosowałeś juz na "$1" $2, możesz zaktualizować swój głos klikając na odpowiedź poniżej.',
	'poll-no-vote' => 'Podaj swój głos poniżej.',
	'poll-info' => 'Oddano już $1 głosy/ów od założenia ankiety dnia $2.', // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => 'Proszę czekać, trwa dodawanie głosu.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'poll-vote-update' => "Tò vot a l'é stàit modificà.",
	'poll-vote-add' => "Tò vot a l'é stàit giontà.",
	'poll-vote-error' => "A l'é staje un problema an tratand sò vot, për piasì ch'a preuva torna.",
	'poll-percent-votes' => '$1% ëd tùit ij vot',
	'poll-your-vote' => 'A l\'ha già votà për "$1" su $2; a peul cangé sò vot an sgnacand su na rispòsta sì-sota.',
	'poll-no-vote' => 'Për piasì, voté sì-sota.',
	'poll-info' => "A son staje $1 vot da quand ël sondagi a l'é stàit creà su $2.", // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => "Për piasì ch'a speta, sò vot a l'é an camin ch'a riva.",
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Daemorris
 */
$messages['pt-br'] = array(
	'poll-vote-update' => 'Seu voto foi atualizado.',
	'poll-vote-add' => 'Seu voto foi adicionado.',
	'poll-vote-error' => 'Houve um problema com o processamento de seu voto, por favor tente novamente.',
	'poll-percent-votes' => '$1% de todos votos',
	'poll-your-vote' => 'Vocâ já votou para "$1" em $2, você pode alterar seu voto clicando em uma opção abaixo.',
	'poll-no-vote' => 'Por favor vote abaixo.',
	'poll-info' => '{{PLURAL:$1|Um voto|$1 votos}} desde a criação da votação em $2.',
	'poll-submitting' => 'Por favor aguarde, enviando sua opção.',
);

/** Russian (Русский)
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'poll-vote-add' => 'Ваш голос добавлен.',
	'poll-vote-update' => 'Ваш голос обновлён.',
	'poll-vote-error' => 'Возникла проблема с обработкой вашего голоса, пожалуйста, попробуйте ещё раз.',
	'poll-percent-votes' => '$1% от всех голосов',
	'poll-your-vote' => 'Вы уже проголосовали «$1» $2. Вы можете изменить свой выбор, нажав на один из представленных ниже ответов.',
	'poll-no-vote' => 'Пожалуйста, проголосуйте ниже.',
	'poll-info' => 'С момента создания голосования $2 поступило $1 голосов.', // @todo FIXME: out of date, needs PLURAL
	'poll-submitting' => 'Пожалуйста, подождите, ваш голос обрабатывается.',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Sasa Stefanovic
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'poll-vote-update' => 'аш глас је био урачунат.',
	'poll-vote-add' => 'Ваш галс је додан',
	'poll-percent-votes' => '$1% од свих гласова',
	'poll-no-vote' => 'Молимо гласајте испод.',
	'poll-submitting' => 'Чекајте, шаљемо ваш глас.',
);

/** Chinese (中文)
 * @author 許瑜真 (Yuchen Hsu/KaurJmeb)
 */
$messages['zh'] = array(
	'poll-no-vote' => '請於下方投票',
	'poll-percent-votes' => '$1%',
	'poll-submitting' => '正在處理您的投票，請稍候。',
	'poll-vote-add' => '您的投票已計入',
	'poll-vote-error' => '投票過程發生問題，請再試一次',
	'poll-vote-update' => '你的投票已更新',
);