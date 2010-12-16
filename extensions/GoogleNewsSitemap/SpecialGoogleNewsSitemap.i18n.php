<?php
/**
 * Internationalisation file for extension special page GoogleNewsSitemap
 * New version of DynamicPageList extension for use by Wikinews projects
 *
 * @addtogroup Extensions
 **/

$messages= array();

/** English
 * @author Amgine
 **/

$messages['en'] = array(
    'gnsm'                  => 'Google News Sitemap',
    'gnsm-desc'             => 'Outputs an Atom/RSS feed as a Google News Sitemap',
    'gnsm_categorymap'      => '', # Default empty. List of categories to map to keywords. Do not translate.
    'gnsm_toomanycats'      => 'Error: Too many categories!',
    'gnsm_toofewcats'       => 'Error: Too few categories!',
    'gnsm_noresults'        => 'Error: No results!',
    'gnsm_noincludecats'    => 'Error: You need to include at least one category, or specify a namespace!',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'gnsm' => 'Google Nuus Sitemap',
	'gnsm-desc' => 'Eksporteer \'n Atom/RSS-voer as \'n Google "News Sitemap"',
	'gnsm_toomanycats' => 'Fout: Te veel kategorieë!',
	'gnsm_toofewcats' => 'Fout: Te min kategorieë!',
	'gnsm_noresults' => 'Fout: Geen resultate!',
	'gnsm_noincludecats' => "Fout: U moet ten minste een kategorie insluit, of spesifiseer 'n naamspasie!",
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'gnsm' => 'Мапа сайту Google News',
	'gnsm-desc' => 'Выводзіць стужкі Atom/RSS у выглядзе мапы сайту Google News',
	'gnsm_toomanycats' => 'Памылка: зашмат катэгорыяў!',
	'gnsm_toofewcats' => 'Памылка: занадта мала катэгорыяў!',
	'gnsm_noresults' => 'Памылка: няма вынікаў!',
	'gnsm_noincludecats' => 'Памылка: Вам неабходна дадаць хаця б адну катэгорыю, альбо пазначыць прастору назваў!',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'gnsm' => 'Google Keleier Sitemap',
	'gnsm-desc' => 'Krouiñ a ra un Atom/RSS feed evel un tres Sitemap evit Google',
	'gnsm_toomanycats' => 'Fazi : Re a rummadoù !',
	'gnsm_toofewcats' => 'Fazi : Re nebeut a rummadoù !',
	'gnsm_noresults' => "Fazi : Disoc'h ebet !",
	'gnsm_noincludecats' => "Fazi : Rankout a reoc'h lakaat ur rummad d'an nebeutañ, pe menegiñ un esaouenn anv !",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'gnsm' => 'Google News mapa stranice',
	'gnsm-desc' => 'Daje izlaz atom/RSS fida kao Google News mapa stranice',
	'gnsm_toomanycats' => 'Greška: Previše kategorija!',
	'gnsm_toofewcats' => 'Greška: Premalo kategorija!',
	'gnsm_noresults' => 'Greška: Nema rezultata!',
	'gnsm_noincludecats' => 'Greška: Morate uključiti najmanje jednu kategoriju ili navesti imenski prostor!',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'gnsm' => 'Sedłowy pśeglěd Google Nowosći',
	'gnsm-desc' => 'Wudawa kanal Atom/RSS ako sedłowy pśeglěd Google Nowosći',
	'gnsm_toomanycats' => 'Zmólka: Pśewjele kategorijow!',
	'gnsm_toofewcats' => 'Zmólka: Pśemało kategorijow!',
	'gnsm_noresults' => 'Zmólka: Žedne wuslědki!',
	'gnsm_noincludecats' => 'Zmólka: Musyš nanejmjenjej jadnu kategoriju zapśěgnuś abo mjenjowy rum pódaś!',
);

/** Spanish (Español)
 * @author Translationista
 */
$messages['es'] = array(
	'gnsm' => 'Mapa del sitio Google Noticias',
	'gnsm-desc' => 'Genera una fuenteAtom/RSS como un mapa de sitio de Google Noticias',
	'gnsm_toomanycats' => 'Error: ¡Demasiadas categorías!',
	'gnsm_toofewcats' => 'Error: ¡Muy pocas categorías!',
	'gnsm_noresults' => 'Error: ¡No hay resultados!',
	'gnsm_noincludecats' => 'Error: ¡Es necesario incluir al menos una categoría o especificar un espacio de nombres!',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'gnsm' => 'Google News Gunearen mapa',
	'gnsm-desc' => 'Atom/RSS iturria zehazten du Google News Gunearen maparentzat',
	'gnsm_toomanycats' => 'Errorea: Kategoria gehiegi!',
	'gnsm_toofewcats' => 'Errorea: Kategoria gutxiegi!',
	'gnsm_noresults' => 'Errorea: Emaitzarik ez!',
	'gnsm_noincludecats' => 'Errorea: Gutxienez kategoria bat gehitu edo izen bat zehaztu behar duzu!',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 */
$messages['fi'] = array(
	'gnsm' => 'Google News -sivukartta',
	'gnsm-desc' => 'Tulostaa Atom/RSS-syötteen Google-uutissivukarttana',
	'gnsm_toomanycats' => 'Virhe: Liian monta luokkaa.',
	'gnsm_toofewcats' => 'Virhe: Liian vähän luokkia.',
	'gnsm_noresults' => 'Virhe: Ei tuloksia.',
	'gnsm_noincludecats' => 'Error: Lisää vähintään yksi luokka tai määritä nimiavaruus.',
);

/** French (Français)
 * @author Amgine
 * @author McDutchie
 */
$messages['fr'] = array(
	'gnsm' => 'Google nouvelles Sitemap',
	'gnsm-desc' => 'Cre un Atom ou RSS feed comme un plan Sitemap pour Google',
	'gnsm_toomanycats' => 'Erreur: Trop de nombreuses catégories!',
	'gnsm_toofewcats' => 'Erreur: Trop peu de catégories!',
	'gnsm_noresults' => 'Erreur: Pas de résultats!',
	'gnsm_noincludecats' => 'Erreur: Vous devez inclure au moins une catégorie, ou spécifier un espace de noms !',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'gnsm' => 'Mapa do sitio das novas do Google',
	'gnsm-desc' => 'Dá como resultado unha fonte de novas Atom/RSS como un mapa do sitio das novas do Google',
	'gnsm_toomanycats' => 'Erro: hai moitas categorías!',
	'gnsm_toofewcats' => 'Erro: moi poucas categorías!',
	'gnsm_noresults' => 'Erro: non hai resultados!',
	'gnsm_noincludecats' => 'Erro: debe incluír, polo menos, unha categoría ou especificar un espazo de nomes!',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'gnsm' => 'Google Nejigkeite Sytenibersicht',
	'gnsm-desc' => 'Liferet e Atom/RSS-feed as Google Nejigkeite Sytenibersicht',
	'gnsm_toomanycats' => 'Fähler: z vil Kategorie!',
	'gnsm_toofewcats' => 'Fähler: z wenig Kategorie!',
	'gnsm_noresults' => 'Fähler: kei Ergebnis!',
	'gnsm_noincludecats' => 'Fähler: muesch zmindescht ei Kategorii aagee oder e Namensruum feschtlege!',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'gnsm' => 'Sydłowa přehlad Google Nowinki',
	'gnsm-desc' => 'Wudawa kanal Atom/RSS jako sydłowy přehlad Google Nowinki',
	'gnsm_toomanycats' => 'Zmylk: Přewjele kategorijow!',
	'gnsm_toofewcats' => 'Zmylk: Přemało kategorijow!',
	'gnsm_noresults' => 'Zmylk: Žane wuslědki!',
	'gnsm_noincludecats' => 'Zmylk: Dyrbiš znajmjeńša jednu kategoriju zapřijeć abo mjenowy rum podać!',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'gnsm_toomanycats' => 'Hiba: túl sok kategória!',
	'gnsm_toofewcats' => 'Hiba: túl kevés kategória!',
	'gnsm_noresults' => 'Hiba: nincs találat!',
	'gnsm_noincludecats' => 'Hiba: legalább egy kategóriát vagy névteret meg kell adnod!',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'gnsm' => 'Sitemap de Google News',
	'gnsm-desc' => 'Converte un syndication Atom/RSS in un Sitemap de Google News',
	'gnsm_toomanycats' => 'Error: Troppo de categorias!',
	'gnsm_toofewcats' => 'Error: Non satis de categorias!',
	'gnsm_noresults' => 'Error: Nulle resultato!',
	'gnsm_noincludecats' => 'Error: Tu debe includer al minus un categoria, o specificar un spatio de nomines!',
);

/** Indonesian (Bahasa Indonesia)
 * @author Kenrick95
 */
$messages['id'] = array(
	'gnsm' => 'Google News Sitemap',
	'gnsm_toomanycats' => 'Kesalahan: Terlalu banyak kategori!',
	'gnsm_toofewcats' => 'Kesalahan: Terlalu sedikit kategori!',
	'gnsm_noresults' => 'Kesalahan: Tidak ada hasil!',
	'gnsm_noincludecats' => 'Kesalahan: Anda perlu mencantumkan paling sedikit satu kategori, atau menyebutkan satu ruang nama!',
);

/** Japanese (日本語)
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'gnsm' => 'Google ニュース サイトマップ',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'gnsm' => 'Google News Plang vum Site',
	'gnsm-desc' => 'Produzéiert en Atom/RSS feed als Google News Sitemap',
	'gnsm_toomanycats' => 'Feeler: Zevill Kategorien!',
	'gnsm_toofewcats' => 'Feeler: Ze wéineg Kategorien!',
	'gnsm_noresults' => 'Feeler: Keng Resultater!',
	'gnsm_noincludecats' => 'Feeler: Dir musst mindestens eng Kategorie oder een Nummraum drasetzen!',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'gnsm' => 'План на страницата Google Вести',
	'gnsm-desc' => 'Дава Atom/RSS канал како план на страницата Google Вести',
	'gnsm_toomanycats' => 'Грешка: Премногу категории!',
	'gnsm_toofewcats' => 'Грешка: Премалку категории!',
	'gnsm_noresults' => 'Грешка: Нема резултати!',
	'gnsm_noincludecats' => 'Грешка: Треба да вклучите барем една категорија, или да назначите именски простор!',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'gnsm' => 'Google Nieuws Sitemap',
	'gnsm-desc' => 'Levert een Atom/RSS-feed als Google Nieuws Sitemap',
	'gnsm_toomanycats' => 'Fout: te veel categorieën!',
	'gnsm_toofewcats' => 'Fout: te weinig categorieën!',
	'gnsm_noresults' => 'Fout: geen resultaten!',
	'gnsm_noincludecats' => 'Fout: u moet tenminste een categorie of naamruimte opgeven!',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'gnsm_toomanycats' => 'Feil: For mange kategoriar.',
	'gnsm_toofewcats' => 'Feil: For få kategoriar.',
	'gnsm_noresults' => 'Feil: Ingen resultat',
	'gnsm_noincludecats' => 'Feil: Du lyt inkludera minst éin kategori eller oppgje eit namnerom.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'gnsm_toomanycats' => 'Feil: For mange kategorier!',
	'gnsm_toofewcats' => 'Feil: For få kategorier!',
	'gnsm_noresults' => 'Feil: Ingen resultat!',
	'gnsm_noincludecats' => 'Feil: Du må inkludere minst én kategori eller oppgi et navnerom!',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'gnsm' => 'Pian dël sit dle Neuve ëd Google',
	'gnsm-desc' => 'A scriv un fluss Atom/RSS com pian dël Sit ëd le Neuve ëd Google',
	'gnsm_toomanycats' => 'Eror: Tròpe categorìe!',
	'gnsm_toofewcats' => 'Eror: Tròp pòche categorìe!',
	'gnsm_noresults' => 'Eror: pa gnun arzultà!',
	'gnsm_noincludecats' => 'Eror: A deuv anserì almanch na categorìa, o spessifiché në spassi nominal!',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'gnsm' => 'Google News Sitemap',
	'gnsm-desc' => 'Converte um feed Atom/RSS para um Google News Sitemap',
	'gnsm_toomanycats' => 'Erro: Categorias a mais!',
	'gnsm_toofewcats' => 'Erro: Categorias a menos!',
	'gnsm_noresults' => 'Erro: Não há resultados!',
	'gnsm_noincludecats' => 'Erro: Tem de incluir pelo menos uma categoria, ou especificar um espaço nominal!',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Daemorris
 */
$messages['pt-br'] = array(
	'gnsm' => 'Mapa de Site de Notícias Google',
	'gnsm-desc' => 'Produz um alimentador Atom/RSS como um Mapa de Site de Notícias Google',
	'gnsm_toomanycats' => 'Erro: Categorias demais!',
	'gnsm_toofewcats' => 'Erro: Categorias de menos!',
	'gnsm_noresults' => 'Erro: Sem resultados!',
	'gnsm_noincludecats' => 'Erro: Você precisa incluir pelo menos uma categoria, ou especificar um espaço nominal!',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'gnsm' => 'Карта сайта для Google News',
	'gnsm-desc' => 'Подготавливает канал Atom/RSS в виде карты сайта для Google News',
	'gnsm_toomanycats' => 'Ошибка. Слишком много категорий!',
	'gnsm_toofewcats' => 'Ошибка. Слишком мало категорий!',
	'gnsm_noresults' => 'Ошибка. Нет данных!',
	'gnsm_noincludecats' => 'Ошибка. Вы должны включить по меньшей мере одну категорию, или указать пространство имён!',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'gnsm_toomanycats' => 'Fel: För många kategorier!',
	'gnsm_toofewcats' => 'Fel: För få kategorier!',
	'gnsm_noresults' => 'Fel: Inget resultat!',
	'gnsm_noincludecats' => 'Fel: Du måste inkludera minst en kategori eller specificera en namnrymd!',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'gnsm' => 'గూగుల్ వార్తల సైటుపటం',
	'gnsm_toomanycats' => 'పొరపాటు: చాలా ఎక్కువ వర్గాలు!',
	'gnsm_toofewcats' => 'పొరపాటు: చాలా తక్కువ వర్గాలు!',
	'gnsm_noresults' => 'పొరపాటు: ఫలితాలు లేవు!',
);

/** Thai (ไทย)
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'gnsm_toomanycats' => 'เกิดความผิดพลาด: เลือกประเภทมากเกินไป!',
	'gnsm_toofewcats' => 'เกิดความผิดพลาด: เลือกประเภทน้อยเกินไป!',
	'gnsm_noresults' => 'เกิดความผิดพลาด: ไม่พบข้อมูล!',
	'gnsm_noincludecats' => 'เกิดความผิดพลาด: คุณต้องเลือกอย่างน้อยหนึ่งประเภท หรือกำหนด Namespace!',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'gnsm' => 'Google Haberler Site haritası',
	'gnsm-desc' => 'Bir Atom/RSS beslemesini Google Haberler Site haritası olarak çıktılar',
	'gnsm_toomanycats' => 'Hata: Çok fazla kategori!',
	'gnsm_toofewcats' => 'Hata: Çok az kategori!',
	'gnsm_noresults' => 'Hata: Sonuç yok!',
	'gnsm_noincludecats' => 'Hata: En az bir kategori girmeli, ya da bir ad alanı belirtmelisiniz!',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 */
$messages['zh-hans'] = array(
	'gnsm' => 'Google 资讯站点地图',
	'gnsm-desc' => '输出一个Google 资讯站点地图的Atom/RSS文件',
	'gnsm_toomanycats' => '错误：分类过多！',
	'gnsm_toofewcats' => '错误：分类过少！',
	'gnsm_noresults' => '错误：没有结果！',
	'gnsm_noincludecats' => '错误：您需要包含至少一个分类，或者指定一个名称空间！',
);

