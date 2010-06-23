<?php
/*
 * @author Sean Colombo
 */

/*
 * Not a valid entry pointx, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/**
 * FBConnectLanguage.i18n.php
 * 
 * Contains a message which represents a mapping of MediaWiki language codes to Facebook Locales.
 */


$messages = array();

/** English */
$messages['en'] = array(

	'fbconnect-mediawiki-lang-to-fb-locale' => "
aa,          # Qafár af -  Afar
ab,          # Аҧсуа -  Abkhaz, should possibly add ' бысжѡа'
ace,          # Acèh -  Aceh
af, af_ZA          # Afrikaans -  Afrikaans
ak,          # Akan -  Akan
aln,          # Gegë -  Gheg Albanian
als,          # Alemannisch -  Alemannic -- not a valid code, for compatibility. See gsw.
am,          # አማርኛ -  Amharic
an,          # Aragonés -  Aragonese
ang,          # Anglo-Saxon -  Old English
ar, ar_AR          # العربية -  Arabic
arc,          # ܐܪܡܝܐ -  Aramaic
arn,          # Mapudungun -  Mapuche, Mapudungu, Araucanian (Araucano)
arz,          # مصرى -  Egyptian Spoken Arabic
as,          # অসমীয়া -  Assamese
ast,          # Asturianu -  Asturian
av,          # Авар -  Avar
avk,          # Kotava - Kotava
ay, ay_BO          # Aymar aru -  Aymara
az,          # Azərbaycan -  Azerbaijani
ba,          # Башҡорт -  Bashkir
bar,          # Boarisch -  Bavarian (Austro-Bavarian and South Tyrolean)
bat-smg,          # Žemaitėška - Samogitian
bcc,          # بلوچی مکرانی - Southern Balochi
bcl,          # Bikol Central - Bikol: Central Bicolano language
be, be_BY          # Беларуская -   Belarusian normative
be-tarask, be_BY          # Беларуская (тарашкевіца) -  Belarusian in Taraskievica orthography
be-x-old, be_BY          # Беларуская (тарашкевіца) -  Belarusian in Taraskievica orthography; compat link
bg, bg_BG          # Български -  Bulgarian
bh,          # भोजपुरी -  Bhojpuri
bi,          # Bislama -  Bislama
bm,          # Bamanankan -  Bambara
bn, bn_IN          # বাংলা -  Bengali
bo,          # བོད་ཡིག -  Tibetan
bpy,          # ইমার ঠার/বিষ্ণুপ্রিয়া মণিপুরী -  Bishnupriya Manipuri
bqi,          # بختياري -  Bakthiari
br,          # Brezhoneg -  Breton
bs, bs_BA          # Bosanski -  Bosnian
bto,          # Iriga Bicolano -  Iriga Bicolano/Rinconada Bikol
bug,          # ᨅᨔ ᨕᨘᨁᨗ -  Bugis
bxr,          # Буряад -  Buryat (Russia)
ca, ca_ES         # Català -  Catalan
cbk-zam,          # Chavacano de Zamboanga -  Zamboanga Chavacano
cdo,          # Mìng-dĕ̤ng-ngṳ̄ -  Min Dong
ce,          # Нохчийн -  Chechen
ceb,          # Cebuano -  Cebuano
ch,          # Chamoru -  Chamorro
cho,          # Choctaw -  Choctaw
chr, ck_US         # ᏣᎳᎩ - Cherokee
chy,          # Tsetsêhestâhese -  Cheyenne
co,          # Corsu -  Corsican
cr,          # Nēhiyawēwin / ᓀᐦᐃᔭᐍᐏᐣ -  Cree
crh,          # Qırımtatarca -  Crimean Tatar
crh-latn,          # \"\xE2\x80\xAAQırımtatarca (Latin)\xE2\x80\xAC\" - Crimean Tatar (Latin)
crh-cyrl,          # \"\xE2\x80\xAAКъырымтатарджа (Кирилл)\xE2\x80\xAC\" - Crimean Tatar (Cyrillic)
cs, cs_CZ          # Česky -  Czech
csb,          # Kaszëbsczi -  Cassubian
cu,          # Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ -  Old Church Slavonic (ancient language)
cv,          # Чăвашла -  Chuvash
cy, cy_GB          # Cymraeg -  Welsh
da, da_DK         # Dansk -  Danish
de, de_DE          # Deutsch -  German (\"Du\")
de-at,          # Österreichisches Deutsch -  Austrian German
de-ch,          # Schweizer Hochdeutsch -  Swiss Standard German
de-formal,          # Deutsch (Sie-Form) -  German - formal address (\"Sie\")
de-weigsbrag,          # Deutsch (Weigsbrag) - German - (\"Weigsbrag\")
diq,          # Zazaki -  Zazaki
dk,          # Dansk (deprecated:da) -  Unused code currently falls back to Danish, 'da' is correct for the language
dsb,          # Dolnoserbski - Lower Sorbian
dv,          # ދިވެހިބަސް -  Dhivehi
dz,          # ཇོང་ཁ -  Bhutani
ee,          # Eʋegbe -  Éwé
el, el_GR          # Ελληνικά -  Greek
eml,          # Emiliàn e rumagnòl -  Emiliano-Romagnolo / Sammarinese
en, en_US         # English -  English
en-gb, en_GB          # British English -  British English
eo, eo_EO          # Esperanto -  Esperanto
es, es_ES          # Español -  Spanish
et, et_EE          # Eesti -  Estonian
eu, eu_ES         # Euskara -  Basque
ext,          # Estremeñu - Extremaduran
fa, fa_IR          # فارسی -  Persian
ff,          # Fulfulde -  Fulfulde, Maasina
fi, fi_FI          # Suomi -  Finnish
fiu-vro,          # Võro -  Võro (deprecated code, 'vro' in ISO 639-3 since 2009-01-16)
fj,          # Na Vosa Vakaviti -  Fijian
fo, fo_FO          # Føroyskt -  Faroese
fr, fr_FR          # Français -  French
frc,          # Français cadien - Cajun French
frp,          # Arpetan -  Franco-Provençal/Arpitan
fur,          # Furlan -  Friulian
fy,          # Frysk -  Frisian
ga, ga_IE          # Gaeilge -  Irish
gag,          # Gagauz -  Gagauz
gan,          # 贛語 -  Gan-hant
gan-hans,          # 赣语(简体) -  Gan-hans
gan-hant,          # 贛語(繁體) -  Gan-hant
gd,          # Gàidhlig -  Scots Gaelic
gl, gl_ES          # Galego -  Galician
glk,          # گیلکی -  Gilaki
gn, gn_PY          # Avañe\'ẽ -  Guaraní, Paraguayan
got,          # 𐌲𐌿𐍄𐌹𐍃𐌺 -  Gothic
grc,          # Ἀρχαία ἑλληνικὴ - Ancient Greek
gsw,          # Alemannisch -  Alemannic
gu, gu_IN          # ગુજરાતી -  Gujarati
gv,          # Gaelg -  Manx
ha,          # هَوُسَ -  Hausa
hak,          # Hak-kâ-fa -  Hakka
haw,          # Hawai`i -  Hawaiian
he, he_IL          # עברית -  Hebrew
hi, hi_IN          # हिन्दी -  Hindi
hif,          # Fiji Hindi -  Fijian Hindi (falls back to hif-latn)
hif-deva,          # फ़ीजी हिन्दी -  Fiji Hindi (devangari)
hif-latn,          # Fiji Hindi -  Fiji Hindi (latin)
hil,          # Ilonggo -  Hiligaynon
ho,          # Hiri Motu -  Hiri Motu
hr, hr_HR          # Hrvatski -  Croatian
hsb,          # Hornjoserbsce -  Upper Sorbian
ht,          # Kreyòl ayisyen -  Haitian Creole French
hu, hu_HU          # Magyar -  Hungarian
hy, hy_AM          # Հայերեն -  Armenian
hz,          # Otsiherero -  Herero
ia,          # Interlingua -  Interlingua (IALA)
id, id_ID          # Bahasa Indonesia -  Indonesian
ie,          # Interlingue -  Interlingue (Occidental)
ig,          # Igbo -  Igbo
ii,          # ꆇꉙ -  Sichuan Yi
ik,          # Iñupiak -  Inupiak (Inupiatun, Northwest Alaska / Inupiatun, North Alaskan)
ike-cans,          # ᐃᓄᒃᑎᑐᑦ -  Inuktitut, Eastern Canadian/Eastern Canadian \"Eskimo\"/\"Eastern Arctic Eskimo\"/Inuit (Unified Canadian Aboriginal Syllabics)
ike-latn,          # inuktitut -  Inuktitut, Eastern Canadian (Latin script)
ilo,          # Ilokano -  Ilokano
inh,          # ГІалгІай Ğalğaj -  Ingush
io,          # Ido -  Ido
is, is_IS          # Íslenska -  Icelandic
it, it_IT         # Italiano -  Italian
iu,          # ᐃᓄᒃᑎᑐᑦ/inuktitut -  Inuktitut (macro language - do no localise, see ike/ikt - falls back to ike-cans)
ja, ja_JP          # 日本語 -  Japanese
jbo,          # Lojban -  Lojban
jut,          # Jysk -  Jutish / Jutlandic
jv, jv_ID          # Basa Jawa -  Javanese
ka, ka_GE          # ქართული -  Georgian
kaa,          # Qaraqalpaqsha -  Karakalpak
kab,          # Taqbaylit -  Kabyle
kg,          # Kongo -  Kongo, (FIXME!) should probaly be KiKongo or KiKoongo
ki,          # Gĩkũyũ -  Gikuyu
kj,          # Kwanyama -  Kwanyama
kk, kk_KZ          # Қазақша -  Kazakh
kk-arab,          # \"\xE2\x80\xABقازاقشا (تٴوتە)\xE2\x80\xAC\" - Kazakh Arabic
kk-cyrl,          # \"\xE2\x80\xAAҚазақша (кирил)\xE2\x80\xAC\" - Kazakh Cyrillic
kk-latn,          # \"\xE2\x80\xAAQazaqşa (latın)\xE2\x80\xAC\" - Kazakh Latin
kk-cn,          # \"\xE2\x80\xABقازاقشا (جۇنگو)\xE2\x80\xAC\" - Kazakh (China)
kk-kz,          # \"\xE2\x80\xAAҚазақша (Қазақстан)\xE2\x80\xAC\" - Kazakh (Kazakhstan)
kk-tr,          # \"\xE2\x80\xAAQazaqşa (Türkïya)\xE2\x80\xAC\" - Kazakh (Turkey)
kl,          # Kalaallisut -  Inuktitut, Greenlandic/Greenlandic/Kalaallisut (kal)
km, km_KH          # ភាសាខ្មែរ -  Khmer, Central
kn, kn_IN          # ಕನ್ನಡ -  Kannada
ko, ko_KR         # 한국어 -  Korean
kr,          # Kanuri -  Kanuri, Central
kri,          # Krio - Krio
krj,          # Kinaray-a - Kinaray-a
ks,          # कश्मीरी - (كشميري) -  Kashmiri
ksh,          # Ripoarisch -  Ripuarian 
ku, ku_TR          # Kurdî / كوردی -  Kurdish
ku-latn,          # \"\xE2\x80\xAAKurdî (latînî)\xE2\x80\xAC\" - Northern Kurdish Latin script
ku-arab,          # \"\xE2\x80\xABكوردي (عەرەبی)\xE2\x80\xAC\" - Northern Kurdish Arabic script
kv,          # Коми -  Komi-Zyrian, cyrillic is common script but also written in latin script
kw,          # Kernewek -  Cornish
ky,          # Кыргызча -  Kirghiz
la, la_VA          # Latina -  Latin
lad,          # Ladino -  Ladino
lb,          # Lëtzebuergesch -  Luxemburguish
lbe,          # Лакку -  Lak
lez,          # Лезги -  Lezgi
lfn,          # Lingua Franca Nova -  Lingua Franca Nova
lg,          # Luganda -  Ganda
li, li_NL          # Limburgs -  Limburgian
lij,          # Líguru -  Ligurian
lld,          # Ladin -  Ladin
lmo,          # Lumbaart -  Lombard
ln,          # Lingála -  Lingala
lo,          # ລາວ',# Laotian
loz,          # Silozi - Lozi
lt, lt_LT          # Lietuvių -  Lithuanian
lv, lv_LV          # Latviešu -  Latvian
lzh,          # 文言 -  Literary Chinese -- (bug 8217) lzh instead of zh-classical, http://www.sil.org/iso639-3/codes.asp?order=639_3&letter=l
lzz,          # Lazuri Nena - Laz
mai,          # मैथिली - Maithili
map-bms,          # Basa Banyumasan - Banyumasan 
mdf,          # Мокшень -  Moksha
mg, mg_MG          # Malagasy -  Malagasy
mh,          # Ebon -  Marshallese
mhr,          # Олык Марий -  Eastern Mari
mi,          # Māori -  Maori
mk, mk_MK          # Македонски -  Macedonian
ml, ml_IN          # മലയാളം -  Malayalam
mn, mn_MN          # Монгол -  Halh Mongolian (Cyrillic) (ISO 639-3: khk)
mo,          # Молдовеняскэ -  Moldovan
mr, mr_IN          # मराठी -  Marathi
ms, ms_MY          # Bahasa Melayu -  Malay
mt, mt_MT          # Malti -  Maltese
mus,          # Mvskoke -  Muskogee/Creek
mwl,          # Mirandés -  Mirandese
my,          # Myanmasa -  Burmese
myv,          # Эрзянь -  Erzya
mzn,          # مَزِروني -  Mazanderani
na,          # Dorerin Naoero -  Nauruan
nah,          # Nāhuatl -  Nahuatl, en:Wikipedia writes Nahuatlahtolli, while another form is Náhuatl
nan,          # Bân-lâm-gú - Min-nan -- (bug 8217) nan instead of zh-min-nan, http://www.sil.org/iso639-3/codes.asp?order=639_3&letter=n
nap,          # Nnapulitano -  Neapolitan
nb, nb_NO          # \"\xE2\x80\xAANorsk (bokmål)\xE2\x80\xAC\" - Norwegian (Bokmal)
nds,          # Plattdüütsch -  Low German ''or'' Low Saxon
nds-nl,          # Nedersaksisch -  Dutch Low Saxon
ne, ne_NP          # नेपाली -  Nepali
new,          # नेपाल भाषा -  Newar / Nepal Bhasa
ng,          # Oshiwambo -  Ndonga
niu,          # Niuē -  Niuean
nl, nl_NL          # Nederlands -  Dutch
nn, nn_NO          # \"\xE2\x80\xAANorsk (nynorsk)\xE2\x80\xAC\" - Norwegian (Nynorsk)
no,           # \"\xE2\x80\xAANorsk (bokmål)\xE2\x80\xAC\" - Norwegian
nov,          # Novial -  Novial
nrm,          # Nouormand -  Norman
nso,          # Sesotho sa Leboa -  Northern Sotho
nv,          # Diné bizaad -  Navajo
ny,          # Chi-Chewa -  Chichewa
oc,          # Occitan -  Occitan
om,          # Oromoo -  Oromo
or,          # ଓଡ଼ିଆ -  Oriya
os,          # Иронау - Ossetic
pa, pa_IN          # ਪੰਜਾਬੀ - Eastern Punjabi (pan)
pag,          # Pangasinan -  Pangasinan
pam,          # Kapampangan -  Pampanga
pap,          # Papiamentu -  Papiamentu
pdc,          # Deitsch -  Pennsylvania German
pdt,          # Plautdietsch -  Plautdietsch/Mennonite Low German
pfl,          # Pfälzisch -  Palatinate German
pi,          # पािऴ -  Pali
pih,          # Norfuk / Pitkern - Norfuk/Pitcairn/Norfolk
pl, pl_PL          # Polski -  Polish
plm,          # Palembang -  Palembang
pms,          # Piemontèis -  Piedmontese
pnb,          # پنجابی -  Western Punjabi
pnt,          # Ποντιακά -  Pontic/Pontic Greek
ps, ps_AF          # پښتو -  Pashto, Northern/Paktu/Pakhtu/Pakhtoo/Afghan/Pakhto/Pashtu/Pushto/Yusufzai Pashto
pt, pt_PT          # Português -  Portuguese
pt-br, pt_BR          # Português do Brasil -  Brazilian Portuguese
qu, qu_PE          # Runa Simi -  Quechua
rif,          # Tarifit -  Tarifit
rm,          # Rumantsch -  Raeto-Romance
rmy,          # Romani -  Vlax Romany
rn,          # Kirundi -  Rundi/Kirundi/Urundi
ro, ro_RO          # Română -  Romanian
roa-rup,          # Armãneashce - Aromanian
roa-tara,          # Tarandíne -  Tarantino
ru, ru_RU          # Русский -  Russian
ruq,          # Vlăheşte -  Megleno-Romanian (falls back to ruq-latn)
ruq-cyrl,          # Влахесте -  Megleno-Romanian (Cyrillic script)
ruq-grek,          # Βλαεστε -  Megleno-Romanian (Greek script)
ruq-latn,          # Vlăheşte -  Megleno-Romanian (Latin script)
rw,          # Kinyarwanda -  Kinyarwanda, should possibly be Kinyarwandi
sa, sa_IN          # संस्कृत -  Sanskrit
sah,          # Саха тыла - Sakha
sc,          # Sardu -  Sardinian
scn,          # Sicilianu -  Sicilian
sco,          # Scots -  Scots
sd,          # سنڌي -  Sindhi
sdc,          # Sassaresu -  Sassarese
se, se_NO          # Sámegiella -  Northern Sami
sei,          # Cmique Itom -  Seri
sg,          # Sängö -  Sango/Sangho
sh,          # Srpskohrvatski / Српскохрватски - Serbocroatian
shi,          # Tašlḥiyt -  Tachelhit
si,          # සිංහල -  Sinhalese
simple,          # Simple English -  Simple English
sk, sk_SK          # Slovenčina -  Slovak
sl, sl_SI          # Slovenščina -  Slovenian
sm,          # Gagana Samoa -  Samoan
sma,          # Åarjelsaemien -  Southern Sami
sn,          # chiShona -  Shona
so, so_SO          # Soomaaliga -  Somali
sq, sq_AL          # Shqip -  Albanian
sr, sr_RS          # Српски / Srpski -  Serbian
sr-ec,          # ћирилица -  Serbian cyrillic ekavian
sr-el,          # latinica -  Serbian latin ekavian
srn,          # Sranantongo -  Sranan Tongo
ss,          # SiSwati -  Swati
st,          # Sesotho -  Southern Sotho
stq,          # Seeltersk -  Saterland Frisian
su,          # Basa Sunda -  Sundanese
sv, sv_SE          # Svenska -  Swedish
sw, sw_KE          # Kiswahili -  Swahili
szl,          # Ślůnski -  Silesian
ta, ta_IN          # தமிழ் -  Tamil
tcy,          # ತುಳು - Tulu
te, te_IN          # తెలుగు -  Telugu
tet,          # Tetun -  Tetun
tg, tg_TJ          # Тоҷикӣ -  Tajiki (falls back to tg-cyrl)
tg-cyrl,          # Тоҷикӣ -  Tajiki (Cyrllic script) (default)
tg-latn,          # tojikī -  Tajiki (Latin script)
th, th_TH          # ไทย -  Thai
ti,          # ትግርኛ -  Tigrinya
tk,          # Türkmençe -  Turkmen
tl, tl_PH          # Tagalog -  Tagalog
	#tlh, tl_ST          # - tlhIngan-Hol -  Klingon - no interlanguage links allowed
tn,          # Setswana -  Setswana
to,          # lea faka-Tonga -  Tonga (Tonga Islands)
tokipona,          # Toki Pona -  Toki Pona
tp,          # Toki Pona (deprecated:tokipona) -  Toki Pona - non-standard language code
tpi,          # Tok Pisin -  Tok Pisin
tr, tr_TR          # Türkçe -  Turkish
ts,          # Xitsonga -  Tsonga
tt, tt_RU          # Tatarça/Татарча -  Tatar (multiple scripts - defaults to Latin)
tt-cyrl,          # Татарча -  Tatar (Cyrillic script)
tt-latn,          # Tatarça -  Tatar (Latin script)
tum,          # chiTumbuka -  Tumbuka
tw,          # Twi -  Twi, (FIXME!)
ty,          # Reo Mā`ohi -  Tahitian
tyv,          # Тыва дыл -  Tyvan
tzm,          # ⵜⴰⵎⴰⵣⵉⵖⵜ -  (Central Morocco) Tamazight
udm,          # Удмурт -  Udmurt
ug,          # Uyghurche‎ / ئۇيغۇرچە -  Uyghur (multiple scripts - defaults to Latin)
	#'ug-arab,          # ئۇيغۇرچە - Uyghur (Arabic script). Disabled until sufficient localisation can be committed
ug-latn,          # Uyghurche‎ - Uyghur (Latin script - default)
uk, uk_UA          # Українська -  Ukrainian
ur, ur_PK          # اردو -  Urdu
uz, uz_UZ          # O\'zbek -  Uzbek
val,          # Valencià -  Valencian
ve,          # Tshivenda -  Venda
vec,          # Vèneto -  Venetian
vep,          # Vepsan kel\' -  Veps
vi, vi_VN          # Tiếng Việt -  Vietnamese
vls,          # West-Vlams - West Flemish
vo,          # Volapük -  Volapük
vro,          # Võro -  Võro
wa,          # Walon -  Walloon
war,          # Winaray - Waray-Waray
wo,          # Wolof -  Wolof
wuu,          # 吴语 -  Wu Chinese
xal,          # Хальмг -  Kalmyk-Oirat (Kalmuk, Kalmuck, Kalmack, Qalmaq, Kalmytskii Jazyk, Khal:mag, Oirat, Volga Oirat, European Oirat, Western Mongolian)
xh, xh_ZA          # isiXhosa -  Xhosan
xmf,          # მარგალური -  Mingrelian
ydd,          # מיזרח־ייִדיש - Eastern Yiddish
yi, yi_DE          # ייִדיש -  Yiddish
yo,          # Yorùbá -  Yoruba
yue,          # 粵語 -  Cantonese -- (bug 8217) yue instead of zh-yue, http://www.sil.org/iso639-3/codes.asp?order=639_3&letter=y
za,          # Sawcuengh -  Zhuang
zea,          # Zeêuws -  Zeeuws/Zeaws
zh,          # 中文 -  (Zhōng Wén) - Chinese
zh-classical,          # 文言 -  Classical Chinese/Literary Chinese -- (see bug 8217)
zh-cn,          # \"\xE2\x80\xAA中文(中国大陆)\xE2\x80\xAC\" -  Chinese (PRC)
zh-hans, zh_CN          # \"\xE2\x80\xAA中文(简体)\xE2\x80\xAC\" - Chinese written using the Simplified Chinese script
zh-hant,          # \"\xE2\x80\xAA中文(繁體)\xE2\x80\xAC\" - Chinese written using the Traditional Chinese script
zh-hk, zh_HK          # \"\xE2\x80\xAA中文(香港)\xE2\x80\xAC\" - Chinese (Hong Kong)
zh-min-nan,          # Bân-lâm-gú -  Min-nan -- (see bug 8217)
zh-mo,          # \"\xE2\x80\xAA中文(澳門)\xE2\x80\xAC\" - Chinese (Macau)
zh-my,          # \"\xE2\x80\xAA中文(马来西亚)\xE2\x80\xAC\" - Chinese (Malaysia)
zh-sg,          # \"\xE2\x80\xAA中文(新加坡)\xE2\x80\xAC\" - Chinese (Singapore)
zh-tw, zh_TW          # \"\xE2\x80\xAA中文(台灣)\xE2\x80\xAC\" - Chinese (Taiwan)
zh-yue,          # 粵語 -  Cantonese -- (see bug 8217)
zu, zu_ZA          # isiZulu -  Zulu
	# Custom 'languages' for various wikis, each with ticket reference
kh,          # Kingdom Hearts - Kingdom Hearts for de.finalfantasy, trac          #2968
kp,          # Kamelopedia - Kamelopedia for de.uncyclopedia, trec          #801
mu,          # Mirror Universe - Mirror Universe for Memory-Alpha, trac          #2788
			"
);

/**
 * Message documentation.
 */
$messages['qqq'] = array(
	'fbconnect-mediawiki-lang-to-fb-locale' => 'Do not translate this message.  It is a representation of a mapping from MediaWiki language codes to corresponding Facebook locales.
		Visit http://www.facebook.com/translations/FacebookLocales.xml for a list of all available Facebook Locales.
		The mapping is expected to be one mapping per line with commas separating the MediaWiki language code on the left and the best Facebook Locale mapping on the right (if available).
		On each line, anything after the first hash (#) is considered a comment.  If no good match for a locale is found, the MediaWiki language code should still be left there (along with the comma) to indicate
		that this is a spot that needs to be worked on. Any spaces on either side of the comma will be trimmed so spaces are just for readability.'
);
