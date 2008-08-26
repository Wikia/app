<?php
/**
 * Internationalisation file for Language Manager extension.
 *
 * @addtogroup Extensions
 */

$wdMessages = array();

/** English
 */
$wdMessages['en'] = array(
	'datasearch'                            => 'Wikidata: Data search',
	'langman_title'                         => 'Language manager',
	'languages'                             => 'Wikidata: Language manager',
	'ow_save'                               => 'Save',
	'ow_history'                            => 'History',
	'ow_datasets'                           => 'Data-set selection',
	'ow_noedit_title'                       => 'No permission to edit',
	'ow_noedit'                             => 'You are not permitted to edit pages in the dataset "$1".
Please see [[{{MediaWiki:Ow editing policy url}}|our editing policy]].',
	'ow_editing_policy_url'                 => 'Project:Permission policy',
	'ow_uipref_datasets'                    => 'Default view',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<None selected>',
	'ow_conceptmapping_help'                => '<p>possible actions: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  insert a mapping</li>
<li>&action=get&concept=<concept_id>  read a mapping back</li>
<li>&action=list_sets  return a list of possible data context prefixes and what they refer to.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> for one defined meaning in a concept, return all others</li>
<li>&action=help   Show helpful help.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Concept Mapping allows you to identify which defined meaning in one dataset is identical	to defined meanings in other datasets.</p>',
	'ow_conceptmapping_no_action_specified' => 'Apologies, I do not know how to "$1".',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'not entered',
	'ow_dm_not_found'                       => 'not found in database or malformed',
	'ow_mapping_successful'                 => 'Mapped all fields marked with [OK]<br />',
	'ow_mapping_unsuccessful'               => 'Need to have at least two defined meanings before I can link them.',
	'ow_will_insert'                        => 'Will insert the following:',
	'ow_contents_of_mapping'                => 'Contents of mapping',
	'ow_available_contexts'                 => 'Available contexts',
	'ow_add_concept_link'                   => 'Add link to other concepts',
	'ow_concept_panel'                      => 'Concept Panel',
	'ow_dm_badtitle'                        => 'This page does not point to any DefinedMeaning (concept).
Please check the web address.',
	'ow_dm_missing'                         => 'This page seems to point to a non-existent DefinedMeaning (concept).
Please check the web address.',
	'ow_AlternativeDefinition'              => 'Alternative definition',
	'ow_AlternativeDefinitions'             => 'Alternative definitions',
	'ow_Annotation'                         => 'Annotation',
	'ow_ApproximateMeanings'                => 'Approximate meanings',
	'ow_ClassAttributeAttribute'            => 'Attribute',
	'ow_ClassAttributes'                    => 'Class attributes',
	'ow_ClassAttributeLevel'                => 'Level',
	'ow_ClassAttributeType'                 => 'Type',
	'ow_ClassMembership'                    => 'Class membership',
	'ow_Collection'                         => 'Collection',
	'ow_CollectionMembership'               => 'Collection membership',
	'ow_Definition'                         => 'Definition',
	'ow_DefinedMeaningAttributes'           => 'Annotation',
	'ow_DefinedMeaning'                     => 'Defined meaning',
	'ow_DefinedMeaningReference'            => 'Defined meaning',
	'ow_ExactMeanings'                      => 'Exact meanings',
	'ow_Expression'                         => 'Expression',
	'ow_ExpressionMeanings'                 => 'Expression meanings',
	'ow_Expressions'                        => 'Expressions',
	'ow_IdenticalMeaning'                   => 'Identical meaning?',
	'ow_IncomingRelations'                  => 'Incoming relations',
	'ow_GotoSource'                         => 'Go to source',
	'ow_Language'                           => 'Language',
	'ow_LevelAnnotation'                    => 'Annotation',
	'ow_OptionAttribute'                    => 'Property',
	'ow_OptionAttributeOption'              => 'Option',
	'ow_OptionAttributeOptions'             => 'Options',
	'ow_OptionAttributeValues'              => 'Option values',
	'ow_OtherDefinedMeaning'                => 'Other defined meaning',
	'ow_PopupAnnotation'                    => 'Annotation',
	'ow_Relations'                          => 'Relations',
	'ow_RelationType'                       => 'Relation type',
	'ow_Spelling'                           => 'Spelling',
	'ow_Synonyms'                           => 'Synonyms',
	'ow_SynonymsAndTranslations'            => 'Synonyms and translations',
	'ow_Source'                             => 'Source',
	'ow_SourceIdentifier'                   => 'Source identifier',
	'ow_TextAttribute'                      => 'Property',
	'ow_Text'                               => 'Text',
	'ow_TextAttributeValues'                => 'Plain texts',
	'ow_TranslatedTextAttribute'            => 'Property',
	'ow_TranslatedText'                     => 'Translated text',
	'ow_TranslatedTextAttributeValue'       => 'Text',
	'ow_TranslatedTextAttributeValues'      => 'Translatable texts',
	'ow_LinkAttribute'                      => 'Property',
	'ow_LinkAttributeValues'                => 'Links',
	'ow_Property'                           => 'Property',
	'ow_Value'                              => 'Value',
	'ow_meaningsoftitle'                    => 'Meanings of "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Wiki link:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>Permission denied</h2>',
	'ow_copy_no_action_specified'           => 'Please specify an action',
	'ow_copy_help'                          => 'Someday, we might help you.',
	'ow_please_proved_dmid'                 => 'It seems your input is missing a "?dmid=<ID>" (dmid=Defined Meaning ID)<br />
Please contact a server administrator.',
	'ow_please_proved_dc1'                  => 'It seems your input is missing a "?dc1=<something>" (dc1=dataset context 1, dataset to copy FROM)<br />
Please contact a server administrator.',
	'ow_please_proved_dc2'                  => 'It seems your input is missing a "?dc2=<something>" (dc2=dataset context 2, dataset to copy TO)<br />
Please contact a server administrator.',
	'ow_copy_successful'                    => "<h2>Copy successful</h2>
Your data appears to have been copied successfully.
Do not forget to doublecheck to make sure!",
	'ow_copy_unsuccessful'                  => '<h3>Copy unsuccessful</h3>
No copy operation has taken place.',
	'ow_no_action_specified'                => "<h3>No action was specified</h3>
Perhaps you came to this page directly? Normally you do not need to be here.",
	'ow_db_consistency_not_found'          => "<h2>Error</h2>
There is an issue with database consistency, wikidata cannot find valid data connected to this defined meaning ID.
It might be lost.
Please contact the server operator or administrator.",
);

/** Karelian (Karjala)
 * @author Flrn
 */
$wdMessages['krl'] = array(
	'ow_LinkAttributeValues' => 'Viippaukset',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$wdMessages['mhr'] = array(
	'ow_save'                => 'Аралаш',
	'ow_LinkAttributeValues' => 'Ссылке-влак',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$wdMessages['niu'] = array(
	'ow_history' => 'Liu onoono atu ki tua',
);

/** Afrikaans (Afrikaans)
 * @author SPQRobin
 * @author Arnobarnard
 * @author Naudefj
 */
$wdMessages['af'] = array(
	'langman_title'                    => 'Taalbestuurder',
	'ow_save'                          => 'Stoor',
	'ow_history'                       => 'Geskiedenis',
	'ow_noedit_title'                  => 'Geen regte om te wysig',
	'ow_dm_OK'                         => 'OK',
	'ow_dm_not_present'                => 'nie ingevoer',
	'ow_AlternativeDefinition'         => 'Alternatiewe definisie',
	'ow_AlternativeDefinitions'        => 'Alternatiewe definisies',
	'ow_Annotation'                    => 'Annotasie',
	'ow_ClassAttributeType'            => 'Tipe',
	'ow_Collection'                    => 'Versameling',
	'ow_Definition'                    => 'Definisie',
	'ow_DefinedMeaningAttributes'      => 'Annotasie',
	'ow_Expression'                    => 'Uitdrukking',
	'ow_Expressions'                   => 'Uitdrukkings',
	'ow_GotoSource'                    => 'Gaan na bron',
	'ow_Language'                      => 'Taal',
	'ow_LevelAnnotation'               => 'Annotasie',
	'ow_OptionAttributeOption'         => 'Opsie',
	'ow_OptionAttributeOptions'        => 'Opsies',
	'ow_PopupAnnotation'               => 'Annotasie',
	'ow_Spelling'                      => 'Spelling',
	'ow_Synonyms'                      => 'Sinonieme',
	'ow_Source'                        => 'Bron',
	'ow_Text'                          => 'Teks',
	'ow_TranslatedText'                => 'Vertaalde teks',
	'ow_TranslatedTextAttributeValue'  => 'Teks',
	'ow_TranslatedTextAttributeValues' => 'Vertaalbare teks',
	'ow_LinkAttributeValues'           => 'Skakels',
	'ow_Value'                         => 'Waarde',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$wdMessages['an'] = array(
	'datasearch' => 'Wikidata: Mirar datos',
);

/** Arabic (العربية)
 * @author Meno25
 */
$wdMessages['ar'] = array(
	'datasearch'                            => 'Wikidata: بحث البيانات',
	'langman_title'                         => 'مدير اللغة',
	'languages'                             => 'Wikidata: مدير اللغة',
	'ow_save'                               => 'حفظ',
	'ow_history'                            => 'تاريخ',
	'ow_datasets'                           => 'اختيار مجموعة البيانات',
	'ow_noedit_title'                       => 'لا سماح للتعديل',
	'ow_noedit'                             => 'أنت غير مسموح لك بتعديل الصفحات في مجموعة البيانات "$1". من فضلك انظر [[{{MediaWiki:Ow editing policy url}}|سياسة التحرير الخاصة بنا]].',
	'ow_uipref_datasets'                    => 'عرض افتراضي',
	'ow_uiprefs'                            => 'ويكي داتا',
	'ow_none_selected'                      => '<لا شيء تم اختياره>',
	'ow_conceptmapping_help'                => '<p>الأفعال الممكنة: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  إدراج رابطة</li>
<li>&action=get&concept=<concept_id>  قراءة رابطة</li>
<li>&action=list_sets عرض قائمة لبوادىء سياقات البيانات الممكنة وما الذي تشير إليه.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> لمعنى معرف واحد في مبدأ، يعرض الآخرون كلهم</li>
<li>&action=help  عرض مساعدة مفيدة.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>ربط المبدأ يسمح لك بتعرف أي معنى معرف في مجموعة بيانات مطابق لمعاني معرفة في مجموعات بيانات أخرى.</p>',
	'ow_conceptmapping_no_action_specified' => 'عذرا، أنا لا أعرف كيف "$1".',
	'ow_dm_OK'                              => 'موافق',
	'ow_dm_not_present'                     => 'غير مدخل',
	'ow_dm_not_found'                       => 'غير موجود في قاعدة البيانات أو لم يتم عمله بطريقة صحيحة',
	'ow_mapping_successful'                 => 'ربط كل الحقول المعلمة ب [OK]<br />',
	'ow_mapping_unsuccessful'               => 'أحتاج إلى معنيين معرفين قبل أن أستطيع وصلهما.',
	'ow_will_insert'                        => 'سيدرج التالي:',
	'ow_contents_of_mapping'                => 'محتويات الربط',
	'ow_available_contexts'                 => 'السياقات المتوفرة',
	'ow_add_concept_link'                   => 'أضف وصلة إلى مبادىء أخرى',
	'ow_concept_panel'                      => 'لوحة المبدأ',
	'ow_dm_badtitle'                        => 'هذه الصفحة لا تشير إلى أي معنى معرف (مبدأ). من فضلك تحقق من عنوان الويب.',
	'ow_dm_missing'                         => 'هذه الصفحة على ما يبدو تشير إلى معنى معرف غير موجود (مبدأ). من فضلك تحقق من عنوان الويب.',
	'ow_AlternativeDefinition'              => 'تعريف بديل',
	'ow_AlternativeDefinitions'             => 'تعريفات بديلة',
	'ow_Annotation'                         => 'هامش',
	'ow_ApproximateMeanings'                => 'معاني تقريبية',
	'ow_ClassAttributeAttribute'            => 'نسب',
	'ow_ClassAttributes'                    => 'نسب الرتبة',
	'ow_ClassAttributeLevel'                => 'مستوى',
	'ow_ClassAttributeType'                 => 'نوع',
	'ow_ClassMembership'                    => 'عضوية الرتبة',
	'ow_Collection'                         => 'مجموعة',
	'ow_CollectionMembership'               => 'عضوية المجموعة',
	'ow_Definition'                         => 'تعريف',
	'ow_DefinedMeaningAttributes'           => 'هامش',
	'ow_DefinedMeaning'                     => 'معنى معرف',
	'ow_DefinedMeaningReference'            => 'معنى معرف',
	'ow_ExactMeanings'                      => 'معاني مطابقة',
	'ow_Expression'                         => 'تعبير',
	'ow_ExpressionMeanings'                 => 'معاني التعبير',
	'ow_Expressions'                        => 'تعبيرات',
	'ow_IdenticalMeaning'                   => 'معنى مطابق؟',
	'ow_IncomingRelations'                  => 'علاقات داخلة',
	'ow_GotoSource'                         => 'اذهب إلى المصدر',
	'ow_Language'                           => 'اللغة',
	'ow_LevelAnnotation'                    => 'هامش',
	'ow_OptionAttribute'                    => 'خاصية',
	'ow_OptionAttributeOption'              => 'خيار',
	'ow_OptionAttributeOptions'             => 'خيارات',
	'ow_OptionAttributeValues'              => 'قيم الخيار',
	'ow_OtherDefinedMeaning'                => 'معنى معرف آخر',
	'ow_PopupAnnotation'                    => 'هامش',
	'ow_Relations'                          => 'علاقات',
	'ow_RelationType'                       => 'نوع العلاقة',
	'ow_Spelling'                           => 'إملاء',
	'ow_Synonyms'                           => 'متقاربات',
	'ow_SynonymsAndTranslations'            => 'متقاربات وترجمات',
	'ow_Source'                             => 'مصدر',
	'ow_SourceIdentifier'                   => 'معرف المصدر',
	'ow_TextAttribute'                      => 'خاصية',
	'ow_Text'                               => 'نص',
	'ow_TextAttributeValues'                => 'نصوص صريحة',
	'ow_TranslatedTextAttribute'            => 'خاصية',
	'ow_TranslatedText'                     => 'نص مترجم',
	'ow_TranslatedTextAttributeValue'       => 'نص',
	'ow_TranslatedTextAttributeValues'      => 'نصوص قابلة للترجمة',
	'ow_LinkAttribute'                      => 'خاصية',
	'ow_LinkAttributeValues'                => 'وصلات',
	'ow_Property'                           => 'خاصية',
	'ow_Value'                              => 'قيمة',
	'ow_meaningsoftitle'                    => 'معاني "$1"',
	'ow_meaningsofsubtitle'                 => '<em>وصلة ويكي:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>السماح مرفوض</h2>',
	'ow_copy_no_action_specified'           => 'من فضلك حدد فعلا',
	'ow_copy_help'                          => 'يوما ما، ربما نساعدك.',
	'ow_please_proved_dmid'                 => 'على ما يبدو دخلك يفقد ?dmid=<something>  (dmid=رقم المعنى المعرف)<br />من فضلك اتصل بإداري خادم.',
	'ow_please_proved_dc1'                  => 'على ما يبدو دخلك يفقد ?dc1=<something>  (dc1=سياق مجموعة البيانات 1، مجموعة البيانات للنسخ منها)<br />من فضلك اتصل بإداري خادم.',
	'ow_please_proved_dc2'                  => 'على ما يبدو فدخلك يفقد ?dc2=<something>  (dc2=سياق مجموعة البيانات 2، مجموعة البيانات للنسخ منها)<br />من فضلك اتصل بإداري خادم.',
	'ow_copy_successful'                    => '<h2>النسخ نجح</h2>بياناتك يبدو أنها قد تم نسخها بنجاح. لا تنس أن تتحقق ثانية للتأكد!',
	'ow_copy_unsuccessful'                  => '<h3>النسخ لم ينجح</h3> لم تحدث أية عملية نسخ.',
	'ow_no_action_specified'                => '<h3>لا فعل تم تحديده</h3> ربما أتيت إلى هذه الصفحة مباشرة؟ عادة أنت لا تحتاج إلى أن تكون هنا.',
	'ow_db_consistency_not_found'           => '<h2>خطأ</h2>توجد مشكلة في ثبات قاعدة البيانات، ويكي داتا لا يمكنها العثور على بيانات صحيحة تتصل برقم المعنى المعرف هذا، ربما يكون قد ضاع. من فضلك اتصل بمشغل أو إداري الخادم.',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 * @author Sab
 */
$wdMessages['avk'] = array(
	'datasearch'                            => 'Wikidata : Origaneyara',
	'langman_title'                         => 'Avapofesiki',
	'languages'                             => 'Wikidata : avapofesiki',
	'ow_save'                               => 'Giwara',
	'ow_history'                            => 'Izvot',
	'ow_datasets'                           => 'Rebara va origlospa',
	'ow_noedit_title'                       => 'Me betararictara',
	'ow_noedit'                             => 'Rin me zorictal ta bubetara koe "$1" origlospa. Va [[{{MediaWiki:Ow editing policy url}}|betaraverteem]] vay wil !',
	'ow_uipref_datasets'                    => 'Omavawira',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<Mecoba rebana>',
	'ow_conceptmapping_help'                => '<p>rotisa tegira se : <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  walbura va skura</li>
<li>&action=get&concept=<concept_id>  sutera va dimskura</li>
<li>&action=list_sets  va vexala dem rotisa orkafa osta yo is sinafa vuestera buldar.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> tori tanoya tentunafa sugdala ke envaks, va kotar buldar</li>
<li>&action=help  Nedira va pomapara.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Envaksskura pu rin rictal da inde tentunafa sugdala koe tanoya origlospa tir milkafa gu tentunafa sugdala se koe ara origlospa yo ropilkomodal.</p>',
	'ow_conceptmapping_no_action_specified' => 'Skalewé ! Jin me grupaskí inde "$1".',
	'ow_dm_OK'                              => 'Ená !',
	'ow_dm_not_present'                     => 'me geltsuteyen',
	'ow_dm_not_found'                       => 'me trasiyin koe origak ok tazukajayan',
	'ow_mapping_successful'                 => 'Kota rapta tcalayana kan [OK] skuyuna <br />',
	'ow_mapping_unsuccessful'               => 'Abdi gluyara icle toloya tentunafa sugdala tid adrafa.',
	'ow_will_insert'                        => 'Batcoba walbutur va :',
	'ow_contents_of_mapping'                => 'Skuracek',
	'ow_available_contexts'                 => 'Roderaykana orka se',
	'ow_add_concept_link'                   => 'Loplekura va gluyasiki ben ar envaks',
	'ow_concept_panel'                      => 'Envaksspert',
	'ow_dm_badtitle'                        => 'Batu bu va mek DefinedMeaning (envaks) eckindar. Va internetmane vay stujel !',
	'ow_dm_missing'                         => 'Batu bu va metis DefinedMeaning (envaks) nuvelason eckindar. Va internetmane vay stujel !',
	'ow_AlternativeDefinition'              => 'Okafa tentura',
	'ow_AlternativeDefinitions'             => 'Okafa tentura se',
	'ow_Annotation'                         => 'Stragara',
	'ow_ApproximateMeanings'                => 'Vanpokefa sugdala se',
	'ow_ClassAttributeAttribute'            => 'Pilkovoy',
	'ow_ClassAttributes'                    => 'Pulapilkovoyeem',
	'ow_ClassAttributeLevel'                => 'Eka',
	'ow_ClassAttributeType'                 => 'Ord',
	'ow_ClassMembership'                    => 'Pulolkeem',
	'ow_Collection'                         => 'Dotay',
	'ow_CollectionMembership'               => 'Dotayolkeem',
	'ow_Definition'                         => 'Tentura',
	'ow_DefinedMeaningAttributes'           => 'Stragara',
	'ow_DefinedMeaning'                     => 'Tentunafa sugdala',
	'ow_DefinedMeaningReference'            => 'Tentunafa sugdala',
	'ow_ExactMeanings'                      => 'Tageltafa sugdala se',
	'ow_Expression'                         => 'Muxaks',
	'ow_ExpressionMeanings'                 => 'Muxarasugdala se',
	'ow_Expressions'                        => 'Muxaks yo',
	'ow_IdenticalMeaning'                   => 'Milkafa sugdala ?',
	'ow_IncomingRelations'                  => 'Kofa skedara se',
	'ow_GotoSource'                         => 'Lanira ko klita',
	'ow_Language'                           => 'Ava',
	'ow_LevelAnnotation'                    => 'Stragara',
	'ow_OptionAttribute'                    => 'Pilkaca',
	'ow_OptionAttributeOption'              => 'Rotisaca',
	'ow_OptionAttributeOptions'             => 'Rotisaceem',
	'ow_OptionAttributeValues'              => 'Rotisacavodeem',
	'ow_OtherDefinedMeaning'                => 'Ara tentunafa sugdala',
	'ow_PopupAnnotation'                    => 'Straga',
	'ow_Relations'                          => 'Skedareem',
	'ow_RelationType'                       => 'Skedarord',
	'ow_Spelling'                           => 'Suteka',
	'ow_Synonyms'                           => 'Milsugdalaca yo',
	'ow_SynonymsAndTranslations'            => 'Se milsugdalaca is kalavaks',
	'ow_Source'                             => 'Klita',
	'ow_SourceIdentifier'                   => 'Klitavrutasiki',
	'ow_TextAttribute'                      => 'Pilkaca',
	'ow_Text'                               => 'Krent',
	'ow_TextAttributeValues'                => 'Opelaf krent yo',
	'ow_TranslatedTextAttribute'            => 'Pilkaca',
	'ow_TranslatedText'                     => 'Kalavayan krent',
	'ow_TranslatedTextAttributeValue'       => 'Krent',
	'ow_TranslatedTextAttributeValues'      => 'Romalavan krent yo',
	'ow_LinkAttribute'                      => 'Pilkaca',
	'ow_LinkAttributeValues'                => 'Gluyasikieem',
	'ow_Property'                           => 'Pilkaca',
	'ow_Value'                              => 'Voda',
	'ow_meaningsoftitle'                    => 'Sugdala se ke "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Wiki gluyasiki :</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>VEWANA RICTARA</h2>',
	'ow_copy_no_action_specified'           => 'Va tegira vay bazel !',
	'ow_copy_help'                          => 'Konviele va rin rotir pomatav.',
	'ow_please_proved_dmid'                 => 'Nuvelar da "?dmid=<ID>" (dmid=Defined Meaning ID) koe rinafa geltsutera gracer<br /> Va ristusik va zanisiko vay uzeral !',
	'ow_please_proved_dc1'                  => 'Nuvelar da "?dc1=<koncoba>" (dc1=dataset context 1, origlospa ta MALksudara) koe rinafa geltsutera gracer<br />Va ristusik va zanisiko vay uzeral !',
	'ow_please_proved_dc2'                  => 'Nuvelar da "?dc2=<koncoba>" (dc2=dataset context 2, origlospa ta KALksudara) koe rinafa geltsutera gracer<br />Va ristusik va zanisiko vay uzeral !',
	'ow_copy_successful'                    => '<h2>Ksudanhara !</h2>Rinaf origeem su zo ksudanhayar. Me vulkul da lanon tolstujel !',
	'ow_copy_unsuccessful'                  => '<h3>Ksudajara</h3> Ksudaraskura metuwadayana.',
	'ow_no_action_specified'                => '<h3>Meka tegira zo bazeyer</h3> Rotir ko batu bu rontion artpil ? Nelkon batlize vol co-til.',
	'ow_db_consistency_not_found'           => '<h2>Rokla</h2>Tir uum icde duga ke origak, Wikidata va wadaf orig skedas va bata ID tentunafa sugdala me rotrasir. Rotir batcoba tir griawiyisa. Va ristusik va zanisiko vay uzeral !',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$wdMessages['bcl'] = array(
	'datasearch' => 'Wikidata: Data search',
	'languages'  => 'Wikidata: Manager kan tataramon',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$wdMessages['bg'] = array(
	'datasearch'                      => 'Уикиданни: Търсене на данни',
	'ow_save'                         => 'Съхранение',
	'ow_history'                      => 'История',
	'ow_noedit_title'                 => 'Необходими са права за редактиране',
	'ow_uiprefs'                      => 'Уикиданни',
	'ow_none_selected'                => '<Нищо не е избрано>',
	'ow_dm_OK'                        => 'Добре',
	'ow_will_insert'                  => 'Ще бъде вмъкнато следното:',
	'ow_AlternativeDefinition'        => 'Алтернативно определение',
	'ow_AlternativeDefinitions'       => 'Алтернативни определения',
	'ow_Annotation'                   => 'Анотация',
	'ow_ClassAttributeAttribute'      => 'Атрибут',
	'ow_ClassAttributeLevel'          => 'Ниво',
	'ow_ClassAttributeType'           => 'Вид',
	'ow_Definition'                   => 'Определение',
	'ow_DefinedMeaningAttributes'     => 'Анотация',
	'ow_ExactMeanings'                => 'Точни значения',
	'ow_Expression'                   => 'Израз',
	'ow_Expressions'                  => 'Изрази',
	'ow_IncomingRelations'            => 'Входящи релации',
	'ow_Language'                     => 'Език',
	'ow_LevelAnnotation'              => 'Анотация',
	'ow_OptionAttributeOptions'       => 'Настройки',
	'ow_PopupAnnotation'              => 'Анотация',
	'ow_Relations'                    => 'Релации',
	'ow_RelationType'                 => 'Тип релация',
	'ow_Synonyms'                     => 'Синоними',
	'ow_SynonymsAndTranslations'      => 'Синоними и преводи',
	'ow_Source'                       => 'Източник',
	'ow_Text'                         => 'Текст',
	'ow_TranslatedText'               => 'Преведен текст',
	'ow_TranslatedTextAttributeValue' => 'Текст',
	'ow_LinkAttributeValues'          => 'Препратки',
	'ow_Value'                        => 'Стойност',
	'ow_meaningsofsubtitle'           => '<em>Уики-препратка:</em> [[$1]]',
	'ow_Permission_denied'            => '<h2>ДОСТЪПЪТ Е ОТКАЗАН</h2>',
	'ow_copy_no_action_specified'     => 'Необходимо е да се посочи действие',
	'ow_copy_successful'              => '<h2>Копирането беше успешно</h2>Данните изглежда са копирани успешно. Уверите, че това наистина е така!',
	'ow_no_action_specified'          => '<h3>Не е посочено действие</h3> Вероятно сте попаднали тук директно? Обикновено не се налага да идвате тук.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$wdMessages['bn'] = array(
	'datasearch'    => 'Wikidata: তথ্য অনুসন্ধান',
	'langman_title' => 'ভাষা ব্যবস্থাপক',
	'languages'     => 'Wikidata: ভাষা ব্যবস্থাপক',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$wdMessages['br'] = array(
	'datasearch'                            => 'Wikidata: Klask roadennoù',
	'langman_title'                         => 'Merer yezhoù',
	'languages'                             => 'Wikidata: Merer yezhoù',
	'ow_save'                               => 'Enrollañ',
	'ow_history'                            => 'Istor',
	'ow_datasets'                           => 'Dibab an diaz',
	'ow_noedit_title'                       => "N'oc'h ket aotreet da zegas kemmoù",
	'ow_noedit'                             => 'N\'oc\'h ket aotreet da zegas kemmoù war pajennoù an diaz "$1". Sellit ouzh [[{{MediaWiki:Ow editing policy url}}|ar reolennoù kemmañ]].',
	'ow_uipref_datasets'                    => 'Gwel dre ziouer',
	'ow_uiprefs'                            => 'Roadennoù wiki',
	'ow_none_selected'                      => '<Netra diuzet>',
	'ow_conceptmapping_help'                => "<p>oberoù posupl : <ul> <li>&action=insert&<data_context_prefix>=<defined_id>&... ensoc'hañ ul liamm</li> <li>&action=get&concept=<concept_id> adkavout ul liamm</li> <li>&action=list_sets degas ur rollad rakgerioù eus kendestennoù roadennoù posupl, hag ar pezh a reont dave dezhañ.</li> <li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> evit ur ster termenet en ur gendestenn, degas an holl re all</li> <li>&action=help Diskouez ar skoazell.</li> </ul></p>",
	'ow_conceptmapping_uitext'              => "<p>Dre liammañ ar meizadoù e c'haller lakaat war wel sterioù termenet ur strobad roadennoù heñvel ouzh sterioù termenet strobadoù roadennoù all.</p>",
	'ow_conceptmapping_no_action_specified' => 'Fazi, dibosupl ober "$1"',
	'ow_dm_OK'                              => 'Mat eo',
	'ow_dm_not_present'                     => "n'emañ ket e-barzh",
	'ow_dm_not_found'                       => "n'eo ket bet kavet en diaz titouroù, pe stummet fall eo",
	'ow_mapping_successful'                 => 'Liammet eo bet an holl vaeziennoù merket gant [Mat eo]<br />',
	'ow_mapping_unsuccessful'               => 'Ret eo kaout da nebeutañ daou ster termenet a-raok gellout liammañ anezho.',
	'ow_will_insert'                        => 'a verko an destenn-mañ :',
	'ow_contents_of_mapping'                => 'Hollad al liammoù',
	'ow_available_contexts'                 => 'Kendestennoù hegerzh',
	'ow_add_concept_link'                   => 'Ouzhpennañ liammoù war-du meizadoù all',
	'ow_concept_panel'                      => 'Merañ ar Meizadoù',
	'ow_dm_badtitle'                        => "Ne gas ket ar bajenn-mañ da SterTermenet ebet (meizad). Gwiriit chomlec'h an URL mar plij.",
	'ow_dm_missing'                         => 'Evit doare ne gas ar bajenn-mañ da SterTermenet ebet (meizad). Gwiriit an URL mar plij.',
	'ow_AlternativeDefinition'              => 'Termenadur all',
	'ow_AlternativeDefinitions'             => 'Termenadurioù all',
	'ow_Annotation'                         => 'Notennadur',
	'ow_ApproximateMeanings'                => 'Sterioù damheñvel',
	'ow_ClassAttributeAttribute'            => 'Perzh',
	'ow_ClassAttributes'                    => 'Perzhioù ar rummad',
	'ow_ClassAttributeLevel'                => 'Live',
	'ow_ClassAttributeType'                 => 'Seurt',
	'ow_ClassMembership'                    => 'Rummadoù',
	'ow_Collection'                         => 'Dastumad',
	'ow_CollectionMembership'               => 'Dastumadoù',
	'ow_Definition'                         => 'Termenadur',
	'ow_DefinedMeaningAttributes'           => 'Notennadur',
	'ow_DefinedMeaning'                     => 'Ster termenet',
	'ow_DefinedMeaningReference'            => 'Ster termenet',
	'ow_ExactMeanings'                      => 'Talvoudegezh rik',
	'ow_Expression'                         => 'Termen',
	'ow_ExpressionMeanings'                 => 'Sterioù an termen',
	'ow_Expressions'                        => 'Termenoù',
	'ow_IdenticalMeaning'                   => 'Termen kevatal-rik ?',
	'ow_IncomingRelations'                  => 'Darempredoù o tont tre',
	'ow_GotoSource'                         => "Mont d'ar vammenn",
	'ow_Language'                           => 'Yezh',
	'ow_LevelAnnotation'                    => 'Notennadur',
	'ow_OptionAttribute'                    => 'Perzh',
	'ow_OptionAttributeOption'              => 'Dibarzh',
	'ow_OptionAttributeOptions'             => 'Dibaboù',
	'ow_OptionAttributeValues'              => 'Talvoudegezh an dibarzhioù',
	'ow_OtherDefinedMeaning'                => 'Ster termenet all',
	'ow_PopupAnnotation'                    => 'Notennadur',
	'ow_Relations'                          => 'Darempredoù',
	'ow_RelationType'                       => 'Seurt darempred',
	'ow_Spelling'                           => 'Reizhskrivañ',
	'ow_Synonyms'                           => 'Heñvelsterioù',
	'ow_SynonymsAndTranslations'            => 'Heñvelsterioù ha troidigezhioù',
	'ow_Source'                             => 'Mammenn',
	'ow_SourceIdentifier'                   => 'Daveer ar vammenn',
	'ow_TextAttribute'                      => 'Perzh',
	'ow_Text'                               => 'Testenn',
	'ow_TextAttributeValues'                => 'Skrid plaen',
	'ow_TranslatedTextAttribute'            => 'Perzh',
	'ow_TranslatedText'                     => 'Testenn troet',
	'ow_TranslatedTextAttributeValue'       => 'Testenn',
	'ow_TranslatedTextAttributeValues'      => 'Testennoù da dreiñ',
	'ow_LinkAttribute'                      => 'Perzh',
	'ow_LinkAttributeValues'                => 'Liammoù',
	'ow_Property'                           => 'Perzh',
	'ow_Value'                              => 'Talvoudenn',
	'ow_meaningsoftitle'                    => 'Sterioù "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Liamm Wiki :</em> [[$1]]',
	'ow_Permission_denied'                  => "<h2>AOTRE NAC'HET</h2>",
	'ow_copy_no_action_specified'           => 'Spisait un ober mar plij',
	'ow_copy_help'                          => "Un deiz bennak e vimp gouest d'o skoazellañ...",
	'ow_please_proved_dmid'                 => 'Mankout a ra un ?dmid=<...> (dmid=SterTermenet ID)<br />Kit e darempred gant merour ar servijer.',
	'ow_please_proved_dc1'                  => 'Mankout a ra un ?dc1=<...> (dc1=kendestenn an diaz 1, diaz a eiler ADAL dezhañ)<br />Kit e darempred gant merour ar servijer.',
	'ow_please_proved_dc2'                  => 'Mankout a ra un ?dc2=<...> (dc1=kendestenn an diaz 2, diaz a eiler ADAL dezhañ)<br />Kit e darempred gant merour ar servijer.',
	'ow_copy_successful'                    => '<h2>Eilskrid aet da benn vat</h2>Evit doare eo bet eilet mat ho roadennoù (gwiriit memes tra).',
	'ow_copy_unsuccessful'                  => "<h3>C'hwitet eo an eiladenn</h3> N'eus bet graet eiladenn ebet.",
	'ow_no_action_specified'                => "<h3>N'eus bet spisaet oberiadenn ebet</h3> Marteze oc'h deuet war-eeun war ar bajenn-mañ ? N'oc'h ket sañset dont amañ koulskoude.",
	'ow_db_consistency_not_found'           => "<h2>Fazi</h2>Evit doare eo brein an diaz titouroù, n'hall ket wikidata kavout roadennoù reizh liammet ouzh ar ster termenet-mañ (ID). Marteze eo bet kollet. Kit e darempred gant oberiataer pe merer ar servijer.",
);

/** Catalan (Català)
 * @author Jordi Roqué
 */
$wdMessages['ca'] = array(
	'ow_Language' => 'Idioma',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$wdMessages['cs'] = array(
	'ow_save'                               => 'Uložit',
	'ow_history'                            => 'Historie',
	'ow_datasets'                           => 'Výběr množiny dat',
	'ow_noedit_title'                       => 'Nemáte povolení upravovat',
	'ow_uipref_datasets'                    => 'Standardní zobrazení',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_conceptmapping_no_action_specified' => 'Omlouvám se, ale nevím jak „$1“.',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'nezadané',
	'ow_will_insert'                        => 'Vloží následující:',
	'ow_contents_of_mapping'                => 'Obsah mapování',
	'ow_available_contexts'                 => 'Dostupné kontexty',
	'ow_add_concept_link'                   => 'Přidat odkaz na ostatní pojmy',
	'ow_concept_panel'                      => 'Panel pojmu',
	'ow_AlternativeDefinition'              => 'Alternativní definice',
	'ow_AlternativeDefinitions'             => 'Alternativní definice',
	'ow_Annotation'                         => 'Poznámka',
	'ow_ApproximateMeanings'                => 'Přibližné významy',
	'ow_ClassAttributeAttribute'            => 'Atribut',
	'ow_ClassAttributes'                    => 'Atributy třídy',
	'ow_ClassAttributeLevel'                => 'Úroveň',
	'ow_ClassAttributeType'                 => 'Typ',
	'ow_ClassMembership'                    => 'Členství ve třídě',
	'ow_Collection'                         => 'Kolekce',
	'ow_CollectionMembership'               => 'Členství v kolekci',
	'ow_Definition'                         => 'Definice',
	'ow_DefinedMeaningAttributes'           => 'Poznámka',
	'ow_DefinedMeaning'                     => 'Definovaný význam',
	'ow_DefinedMeaningReference'            => 'Definovaný význam',
	'ow_ExactMeanings'                      => 'Přesné významy',
	'ow_Expression'                         => 'Výraz',
	'ow_ExpressionMeanings'                 => 'Významy výrazu',
	'ow_Expressions'                        => 'Výrazy',
	'ow_IdenticalMeaning'                   => 'Shodný význam?',
	'ow_IncomingRelations'                  => 'Vstupující vztahy',
	'ow_GotoSource'                         => 'Přejít na zdroj',
	'ow_Language'                           => 'Jazyk',
	'ow_LevelAnnotation'                    => 'Poznámka',
	'ow_OptionAttribute'                    => 'Vlastnost',
	'ow_OptionAttributeOption'              => 'Možnost',
	'ow_OptionAttributeOptions'             => 'Možnosti',
	'ow_OptionAttributeValues'              => 'Hodnoty možností',
	'ow_OtherDefinedMeaning'                => 'Jiný definovaný význam',
	'ow_PopupAnnotation'                    => 'Poznámka',
	'ow_Relations'                          => 'Vztahy',
	'ow_RelationType'                       => 'Typ vztahu',
	'ow_Spelling'                           => 'Pravopis',
	'ow_Synonyms'                           => 'Synonyma',
	'ow_SynonymsAndTranslations'            => 'Synonyma a překlady',
	'ow_Source'                             => 'Zdroj',
	'ow_SourceIdentifier'                   => 'Identifikátor zdroje',
	'ow_TextAttribute'                      => 'Vlastnost',
	'ow_Text'                               => 'Text',
	'ow_TextAttributeValues'                => 'Prostý text',
	'ow_TranslatedTextAttribute'            => 'Vlastnost',
	'ow_TranslatedText'                     => 'Přeložený text',
	'ow_TranslatedTextAttributeValue'       => 'Text',
	'ow_TranslatedTextAttributeValues'      => 'Přeložený text',
	'ow_LinkAttribute'                      => 'Vlastnost',
	'ow_LinkAttributeValues'                => 'Odkazy',
	'ow_Property'                           => 'Vlastnost',
	'ow_Value'                              => 'Hodnota',
	'ow_meaningsoftitle'                    => 'Významy „$1“',
	'ow_meaningsofsubtitle'                 => '<em>Wikiodkaz:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>NEMÁTE POTŘEBNÉ OPRÁVNĚNÍ</h2>',
	'ow_copy_no_action_specified'           => 'Prosím, zadejte činnost',
	'ow_copy_help'                          => 'Jednoho dne vám možná pomůžeme.',
	'ow_copy_successful'                    => '<h2>Kopírování proběhlo úspěšně</h2>
Zdá se, že vaše data byla zkopírována úspěšně. Nezapomeňte to pro jistotu ještě jednou zkontrolovat!',
	'ow_copy_unsuccessful'                  => '<h3>Kopírování neúspěšné</h3>
Operace kopírování se neuskutečnila.',
	'ow_no_action_specified'                => '<h3>Nebyla uvedena činnost</h3>
Možná jste se snažili na tuto stránku přistupovat přímo. Běžně se sem nemůžete dostat.',
	'ow_db_consistency_not_found'           => '<h2>Chyba</h2>
Nastal problém s konzistencí databáze. Wikidata nemůže najít platné údaje spojené s tímto ID definovaného významu. Je možné, že jsou ztracené. Prosím kontaktujte správce serveru.',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$wdMessages['cu'] = array(
	'ow_Language'            => 'ѩꙁꙑ́къ',
	'ow_LinkAttributeValues' => 'съвѧ́ꙁи',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$wdMessages['da'] = array(
	'ow_history'                      => 'Historik',
	'ow_dm_OK'                        => 'OK',
	'ow_Language'                     => 'Sprog',
	'ow_Source'                       => 'Kilde',
	'ow_Text'                         => 'Tekst',
	'ow_TranslatedTextAttributeValue' => 'Tekst',
);

/** German (Deutsch) */
$wdMessages['de'] = array(
	'datasearch'                            => 'Wikidata: Datensuche',
	'langman_title'                         => 'Sprachmanager',
	'languages'                             => 'Wikidata: Sprachen-Manager',
	'ow_save'                               => 'Speichern',
	'ow_history'                            => 'Versionen/Autoren',
	'ow_datasets'                           => 'Auswahl des Datasets',
	'ow_noedit'                             => 'Du hast nicht die Erlaubnis Seiten im Dataset "$1" zu editieren. Siehe [[{{MediaWiki:Ow editing policy url}}|unsere Richtlinien]].',
	'ow_noedit_title'                       => 'Keine Editiererlaubnis',
	'ow_noedit'                             => 'Du hast nicht die Erlaubnis Seiten im Dataset "$1" zu editieren. Siehe [[{{MediaWiki:Ow editing policy url}}|unsere Richtlinien]].',
	'ow_uipref_datasets'                    => 'Standardansicht',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<nichts ausgewählt>',
	'ow_conceptmapping_help'                => '<p>Mögliche Aktionen: <ul> <li>&action=insert&<data_context_prefix>=<defined_id>&... Eine Verknüpfung hinzufügen</li> <li>&action=get&concept=<concept_id> Eine Verknüpfung abrufen</li> <li>&action=list_sets Zeige eine Liste von möglichen Datenkontextpräfixen und auf was sie sich beziehen</li> <li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> für eine DefinedMeaning in einem Kontext, zeige alle anderen</li> <li>&action=help Hilfe anzeigen.</li> </ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Mit Concept Mapping kann festgelegt werden, welche DefinedMeaning in einem Dataset mit anderen DefinedMeanings aus anderen Datasets identisch ist.</p>',
	'ow_conceptmapping_no_action_specified' => 'Entschuldigung, ich kann nicht "$1".',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'nicht eingegeben',
	'ow_dm_not_found'                       => 'nicht in der Datenbank gefunden oder fehlerhaft',
	'ow_mapping_successful'                 => 'Alle mit [OK] markierten Felder wurden zugeordnet<br />',
	'ow_mapping_unsuccessful'               => 'Es werden mindestens zwei DefinedMeanings zum Verknüpfen benötigt.',
	'ow_will_insert'                        => 'Folgendes wird eingesetzt:',
	'ow_contents_of_mapping'                => 'Inhalte der Verknüpfung',
	'ow_available_contexts'                 => 'Verfügbare Kontexte',
	'ow_add_concept_link'                   => 'Link zu anderen Konzepten hinzufügen',
	'ow_concept_panel'                      => 'Konzeptschaltfläche',
	'ow_dm_badtitle'                        => 'Diese Seite weist nicht zu einer DefinedMeaning (Konzept). Bitte überprüfe die Webadresse.',
	'ow_dm_missing'                         => 'Diese Seite weist zu einer nicht existierenden DefinedMeaning (Konzept). Bitte überprüfe die Webadresse.',
	'ow_AlternativeDefinition'              => 'Alternative Definition',
	'ow_AlternativeDefinitions'             => 'Alternative Definitionen',
	'ow_Annotation'                         => 'Annotation',
	'ow_ApproximateMeanings'                => 'Ungefähre Bedeutungen',
	'ow_ClassAttributeAttribute'            => 'Attribut',
	'ow_ClassAttributes'                    => 'Klassenattribute',
	'ow_ClassAttributeLevel'                => 'Level',
	'ow_ClassAttributeType'                 => 'Typ',
	'ow_ClassMembership'                    => 'Klassenzugehörigkeit',
	'ow_Collection'                         => 'Sammlung',
	'ow_CollectionMembership'               => 'Sammlungszugehörigkeit',
	'ow_Definition'                         => 'Definition',
	'ow_DefinedMeaningAttributes'           => 'Annotation',
	'ow_DefinedMeaning'                     => 'DefinedMeaning',
	'ow_DefinedMeaningReference'            => 'DefinedMeaning',
	'ow_ExactMeanings'                      => 'Exakte Bedeutungen',
	'ow_Expression'                         => 'Ausdruck',
	'ow_ExpressionMeanings'                 => 'Ausdrucksbedeutungen',
	'ow_Expressions'                        => 'Ausdrücke',
	'ow_IdenticalMeaning'                   => 'Identische Bedeutung?',
	'ow_IncomingRelations'                  => 'Eingehende Relationen',
	'ow_GotoSource'                         => 'Gehe zur Quelle',
	'ow_Language'                           => 'Sprache',
	'ow_LevelAnnotation'                    => 'Annotation',
	'ow_OptionAttribute'                    => 'Eigenschaft',
	'ow_OptionAttributeOption'              => 'Option',
	'ow_OptionAttributeOptions'             => 'Optionen',
	'ow_OptionAttributeValues'              => 'Optionswerte',
	'ow_OtherDefinedMeaning'                => 'Andere DefinedMeaning',
	'ow_PopupAnnotation'                    => 'Annotation',
	'ow_Relations'                          => 'Relationen',
	'ow_RelationType'                       => 'Relationstyp',
	'ow_Spelling'                           => 'Schreibweise',
	'ow_Synonyms'                           => 'Synonyme',
	'ow_SynonymsAndTranslations'            => 'Synonyme und Übersetzungen',
	'ow_Source'                             => 'Quelle',
	'ow_SourceIdentifier'                   => 'Quellenbezeichner',
	'ow_TextAttribute'                      => 'Eigenschaft',
	'ow_Text'                               => 'Text',
	'ow_TextAttributeValues'                => 'Plaintext',
	'ow_TranslatedTextAttribute'            => 'Eigenschaft',
	'ow_TranslatedText'                     => 'Übersetzter Text',
	'ow_TranslatedTextAttributeValue'       => 'Text',
	'ow_TranslatedTextAttributeValues'      => 'Übersetzbarer Text',
	'ow_LinkAttribute'                      => 'Eigenschaft',
	'ow_LinkAttributeValues'                => 'Links',
	'ow_Property'                           => 'Eigenschaft',
	'ow_Value'                              => 'Wert',
	'ow_meaningsoftitle'                    => 'Bedeutungen von "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Wikilink:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>ERLAUBNIS VERWEIGERT</h2>',
	'ow_copy_no_action_specified'           => 'Bitte lege eine Aktion fest.',
	'ow_copy_help'                          => 'Eines Tages können wir dir helfen.',
	'ow_please_proved_dmid'                 => 'Oje, deiner Eingabe fehlt ?dmid=<something> (dmid=Defined Meaning ID)<br />Ups, bitte kontaktiere den Serveradminstrator.',
	'ow_please_proved_dc1'                  => 'Oje, deiner Eingabe fehlt ?dc1=<something> (dc1=dataset context 1, dataset to copy FROM)<br />Ups, bitte kontaktiere den Serveradminstrator.',
	'ow_please_proved_dc2'                  => 'Oje, deiner Eingabe fehlt ?dc2=<something> (dc2=dataset context 2, dataset to copy TO) <br />Ups, bitte kontaktiere den Serveradminstrator.',
	'ow_copy_successful'                    => '<h2>Kopieren erfolgreich</h2>Deine Daten scheinen erfolgreich kopiert worden zu sein. Bitte vergiss nicht nochmals zu prüfen um sicherzugehen!',
	'ow_copy_unsuccessful'                  => '<h3>Kopieren nicht erfolgreich</h3> Es hat keine Kopieraktion stattgefunden.',
	'ow_no_action_specified'                => '<h3>Es wurde keine Aktion angegeben</h3> Vielleicht kamst du direkt zu dieser Seite?.',
	'ow_db_consistency_not_found'           => '<h2>Fehler</h2>Die Datenbank ist nicht mehr konsistent. Wikidate kann keine gültigen Daten zu der ID finden. Bitte kontaktiere den Server-Administrator.',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$wdMessages['el'] = array(
	'datasearch'                      => 'Βικιδεδομένα: Αναζήτηση δεδομένων',
	'langman_title'                   => 'Διαχειριστής γλώσσας',
	'languages'                       => 'Wikidata: Διαχειριστής γλώσσας',
	'ow_uiprefs'                      => 'Βικιδεδομένα',
	'ow_ClassAttributeLevel'          => 'Επίπεδο',
	'ow_ClassAttributeType'           => 'Τύπος',
	'ow_Collection'                   => 'Συλλογή',
	'ow_Language'                     => 'Γλώσσα',
	'ow_OptionAttribute'              => 'Ιδιότητα',
	'ow_OptionAttributeOption'        => 'Επιλογή',
	'ow_OptionAttributeOptions'       => 'Επιλογές',
	'ow_Relations'                    => 'Σχέσεις',
	'ow_Synonyms'                     => 'Συνώνυμα',
	'ow_SynonymsAndTranslations'      => 'Συνώνυμα και μεταφράσεις',
	'ow_Source'                       => 'Πηγή',
	'ow_TextAttribute'                => 'Ιδιότητα',
	'ow_Text'                         => 'Κείμενο',
	'ow_TranslatedTextAttribute'      => 'Ιδιότητα',
	'ow_TranslatedText'               => 'Μεταφρασμένο κείμενο',
	'ow_TranslatedTextAttributeValue' => 'Κείμενο',
	'ow_LinkAttribute'                => 'Ιδιότητα',
	'ow_LinkAttributeValues'          => 'Σύνδεσμοι',
	'ow_Property'                     => 'Ιδιότητα',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$wdMessages['eo'] = array(
	'langman_title'                         => 'Lingva administrilo',
	'languages'                             => 'Vikidatenoj: Lingva administrilo',
	'ow_save'                               => 'Konservi',
	'ow_history'                            => 'Historio',
	'ow_noedit_title'                       => 'Neniu permeso por redakti',
	'ow_uipref_datasets'                    => 'Defaŭlta vido',
	'ow_uiprefs'                            => 'Vikidatenoj',
	'ow_none_selected'                      => '<Nenio elektita>',
	'ow_conceptmapping_no_action_specified' => 'Bedaŭrinde, mi ne scias kiel "$1".',
	'ow_dm_OK'                              => 'Ek!',
	'ow_dm_not_present'                     => 'ne enigita',
	'ow_will_insert'                        => 'Enmetos la jenajn:',
	'ow_contents_of_mapping'                => 'Enhavo de mapado',
	'ow_available_contexts'                 => 'Haveblaj kuntekstoj',
	'ow_AlternativeDefinition'              => 'Alternativa difino',
	'ow_AlternativeDefinitions'             => 'Alternativaj difinoj',
	'ow_Annotation'                         => 'Prinotado',
	'ow_ApproximateMeanings'                => 'Similaj signifoj',
	'ow_ClassAttributeAttribute'            => 'Atribuo',
	'ow_ClassAttributes'                    => 'Klasaj atribuoj',
	'ow_ClassAttributeLevel'                => 'Nivelo',
	'ow_ClassAttributeType'                 => 'Tipo',
	'ow_ClassMembership'                    => 'Klasa membreco',
	'ow_Collection'                         => 'Kolekto',
	'ow_Definition'                         => 'Difino',
	'ow_DefinedMeaningAttributes'           => 'Prinotado',
	'ow_DefinedMeaning'                     => 'Difinita signifo',
	'ow_DefinedMeaningReference'            => 'Difinita signifo',
	'ow_ExactMeanings'                      => 'Precizaj signifoj',
	'ow_Expression'                         => 'Esprimo',
	'ow_ExpressionMeanings'                 => 'Esprimaj signifoj',
	'ow_Expressions'                        => 'Esprimoj',
	'ow_IdenticalMeaning'                   => 'Identa signifo?',
	'ow_GotoSource'                         => 'Iri al fonto',
	'ow_Language'                           => 'Lingvo',
	'ow_LevelAnnotation'                    => 'Prinotado',
	'ow_OptionAttribute'                    => 'Eco',
	'ow_OptionAttributeOption'              => 'Opcio',
	'ow_OptionAttributeOptions'             => 'Preferoj',
	'ow_OptionAttributeValues'              => 'Valutoj de opcioj',
	'ow_OtherDefinedMeaning'                => 'Alia difinita signifo',
	'ow_PopupAnnotation'                    => 'Prinotado',
	'ow_Relations'                          => 'Rilatoj',
	'ow_Spelling'                           => 'Literumado',
	'ow_Synonyms'                           => 'Sinonimoj',
	'ow_SynonymsAndTranslations'            => 'Sinonimoj kaj tradukoj',
	'ow_Source'                             => 'Fonto',
	'ow_SourceIdentifier'                   => 'Identigilo de fontoj',
	'ow_TextAttribute'                      => 'Eco',
	'ow_Text'                               => 'Teksto',
	'ow_TextAttributeValues'                => 'Ordinaraj tekstoj',
	'ow_TranslatedTextAttribute'            => 'Eco',
	'ow_TranslatedText'                     => 'Tradukita teksto',
	'ow_TranslatedTextAttributeValue'       => 'Teksto',
	'ow_TranslatedTextAttributeValues'      => 'Tradukeblaj tekstoj',
	'ow_LinkAttribute'                      => 'Eco',
	'ow_LinkAttributeValues'                => 'Ligiloj',
	'ow_Property'                           => 'Eco',
	'ow_Value'                              => 'Valuto',
	'ow_meaningsoftitle'                    => 'Signifoj de "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Vikiligilo:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>PERMESO NEITA</h2>',
	'ow_copy_no_action_specified'           => 'Bonvolu specifigi agon',
	'ow_copy_help'                          => 'Iutage, ne eble helpos vin.',
);

/** Spanish (Español)
 * @author Ascánder
 */
$wdMessages['es'] = array(
	'datasearch'                            => 'Wikidata: Búsqueda de datos',
	'langman_title'                         => 'Gestor de lenguas',
	'languages'                             => 'Wikidata: Gestor de lenguas',
	'ow_save'                               => 'Guardar',
	'ow_history'                            => 'Historial',
	'ow_datasets'                           => 'Selección de la base',
	'ow_noedit_title'                       => 'No se permite modificar',
	'ow_noedit'                             => 'No tienes permiso de modificar las páginas de la base "$1". Mira [[{{MediaWiki:Ow editing policy url}}|nuestras reglas de modificación]].',
	'ow_uipref_datasets'                    => 'Vista por defecto',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<No hay nada seleccionado>',
	'ow_conceptmapping_help'                => '<p>acciones posibles: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  insertar una correspondencia</li>
<li>&action=get&concept=<concept_id>  leer una correspondencia almacenada</li>
<li>&action=list_sets  devuelve una lista de posibles prefijos de contexto de datos y a qué se pueden referir</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> para un sentido definido en un concepto, devuelve todos los otros</li>
<li>&action=help  Muestra un mensaje de ayuda.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Ligar los conceptos permite identificar los sentidos definidos en un juego de datos que son idénticos a sentidos definidos en otros juegos de datos.</p>',
	'ow_conceptmapping_no_action_specified' => 'Sentimos no saber hacer "$1".',
	'ow_dm_not_present'                     => 'Ausente',
	'ow_dm_not_found'                       => 'No encontrado en la base de datos o con errores de representación',
	'ow_mapping_successful'                 => 'Todos los campos marcados con [OK] fueron enlazados',
	'ow_mapping_unsuccessful'               => 'Deben haber dos sentidos definidos para poder ligarlos.',
	'ow_will_insert'                        => 'Insertará el texto siguiente:',
	'ow_available_contexts'                 => 'Conceptos disponibles',
	'ow_add_concept_link'                   => 'Enlazar otros conceptos',
	'ow_concept_panel'                      => 'Tablero de conceptos',
	'ow_dm_badtitle'                        => 'Esta pagina no enlaza ningún SentidoDefinido (concepto). Verifica el RUL.',
	'ow_dm_missing'                         => 'Esta página se dirige hacia un SentidoDefinido (concepto) inexistente. Verifica el URL.',
	'ow_AlternativeDefinition'              => 'Definición alterna',
	'ow_AlternativeDefinitions'             => 'Definiciones alternas',
	'ow_Annotation'                         => 'Anotación',
	'ow_ApproximateMeanings'                => 'Sentidos aproximados',
	'ow_ClassAttributeAttribute'            => 'Atributo',
	'ow_ClassAttributes'                    => 'Atributos de clase',
	'ow_ClassAttributeLevel'                => 'Nivel',
	'ow_ClassAttributeType'                 => 'Tipo',
	'ow_ClassMembership'                    => 'Clases',
	'ow_Collection'                         => 'Colección',
	'ow_CollectionMembership'               => 'Colecciones',
	'ow_Definition'                         => 'Definición',
	'ow_DefinedMeaningAttributes'           => 'Notas',
	'ow_DefinedMeaning'                     => 'Sentido definido',
	'ow_DefinedMeaningReference'            => 'Sentido definido',
	'ow_ExactMeanings'                      => 'Sentidos exactos',
	'ow_Expression'                         => 'Expresión',
	'ow_ExpressionMeanings'                 => 'Significados de expresión',
	'ow_Expressions'                        => 'Expresiones',
	'ow_IdenticalMeaning'                   => '¿Idéntico sentido?',
	'ow_IncomingRelations'                  => 'Relaciones entrantes',
	'ow_GotoSource'                         => 'Ir a la fuente',
	'ow_Language'                           => 'Lengua',
	'ow_LevelAnnotation'                    => 'Nota',
	'ow_OptionAttribute'                    => 'Propiedad',
	'ow_OptionAttributeOption'              => 'Opción',
	'ow_OptionAttributeOptions'             => 'Opciones',
	'ow_OptionAttributeValues'              => 'Valores',
	'ow_OtherDefinedMeaning'                => 'Otro sentido definido',
	'ow_PopupAnnotation'                    => 'Nota',
	'ow_Relations'                          => 'Relaciones',
	'ow_RelationType'                       => 'Tipo de relación',
	'ow_Spelling'                           => 'Ortografía',
	'ow_Synonyms'                           => 'Sinónimos',
	'ow_SynonymsAndTranslations'            => 'Sinónimos y traducciones',
	'ow_Source'                             => 'Fuente',
	'ow_SourceIdentifier'                   => 'Fuente',
	'ow_TextAttribute'                      => 'Propiedad',
	'ow_Text'                               => 'Texto',
	'ow_TextAttributeValues'                => 'Textos libres',
	'ow_TranslatedTextAttribute'            => 'Propiedad',
	'ow_TranslatedText'                     => 'Texto traducido',
	'ow_TranslatedTextAttributeValue'       => 'Texto',
	'ow_TranslatedTextAttributeValues'      => 'Textos traducibles',
	'ow_LinkAttribute'                      => 'Propiedad',
	'ow_LinkAttributeValues'                => 'Enlaces',
	'ow_Property'                           => 'Propiedad',
	'ow_Value'                              => 'Valor',
	'ow_meaningsoftitle'                    => 'Significado de "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Wiki enlace:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>PERMISO NEGADO</h2>',
	'ow_copy_no_action_specified'           => 'Especifique una acción por favor',
	'ow_copy_help'                          => 'Esperamos tener la ayuda disponible en poco tiempo.',
	'ow_please_proved_dmid'                 => 'Falta un ?dmid=<...> (dmid=Id de SentidoDefinido)
Favor contactar al administrador.',
	'ow_please_proved_dc1'                  => 'Falta un ?dc1=<...> (dc1=contexto de la base DESDE la cual se copia)<br />Contacta a un administrador.',
	'ow_please_proved_dc2'                  => 'Falta un ?dc2=<...> (dc1=Contexto de la segunda base, hacia la cual se copia)
Favor contactar al administrador.',
	'ow_copy_successful'                    => '<h2>Copia exitosa</h2>Sus datos han sido copiados exitosamente (Favor verificar de todas formas).',
	'ow_copy_unsuccessful'                  => '<h3>Copia fallida</h3> La copia no se realizó.',
	'ow_no_action_specified'                => '<h3>No se especificó ninguna acción</h3> ¿Puede que hayas llegado a esta página directamente? Normalmente, no necesitas venir hasta aquí.',
);

/** Finnish (Suomi)
 * @author Nike
 */
$wdMessages['fi'] = array(
	'ow_AlternativeDefinition'         => 'Vaihtoehtoinen määritelmä',
	'ow_AlternativeDefinitions'        => 'Vaihtoehtoiset määritelmät',
	'ow_Annotation'                    => 'Annotaatiot',
	'ow_ClassAttributeAttribute'       => 'Ominaisuus',
	'ow_ClassAttributes'               => 'Luokkaominaisuudet',
	'ow_ClassAttributeLevel'           => 'Taso',
	'ow_ClassAttributeType'            => 'Tyyppi',
	'ow_Definition'                    => 'Määritelmä',
	'ow_ExactMeanings'                 => 'Tarkat merkityset',
	'ow_Expression'                    => 'Ilmaisu',
	'ow_Expressions'                   => 'Ilmaisut',
	'ow_IdenticalMeaning'              => 'Identtinen merkitys',
	'ow_Language'                      => 'Kieli',
	'ow_LevelAnnotation'               => 'Annotaatio',
	'ow_Spelling'                      => 'Kirjoitusasu',
	'ow_SynonymsAndTranslations'       => 'Synonyymit ja käännökset',
	'ow_Source'                        => 'Lähde',
	'ow_SourceIdentifier'              => 'Lähdetunnus',
	'ow_Text'                          => 'Teksti',
	'ow_TranslatedText'                => 'Käännetty teksti',
	'ow_TranslatedTextAttributeValue'  => 'Teksti',
	'ow_TranslatedTextAttributeValues' => 'Käännettävä teksti',
	'ow_Property'                      => 'Ominaisuus',
);

/** French (Français)
 * @author Grondin
 * @author Sherbrooke
 * @author Urhixidur
 * @author Meithal
 * @author Siebrand
 */
$wdMessages['fr'] = array(
	'datasearch'                            => 'Wikidata: Recherche de données',
	'langman_title'                         => 'Gestion des langues',
	'languages'                             => 'Wikidata: Gestion des langues',
	'ow_save'                               => 'Sauvegarder',
	'ow_history'                            => 'Historique',
	'ow_datasets'                           => 'Sélection des données définies',
	'ow_noedit_title'                       => "Aucune permission d'éditer.",
	'ow_noedit'                             => "Vous n'êtes pas autorisé d'éditer les pages dans les données préétablies « $1 ».
Veuillez voir [[{{MediaWiki:Ow editing policy url}}|nos règles d'édition]].",
	'ow_uipref_datasets'                    => 'Vue par défaut',
	'ow_uiprefs'                            => 'Données wiki',
	'ow_none_selected'                      => '<Aucune sélection>',
	'ow_conceptmapping_help'                => '<p>actions possibles : <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  insérer une correspondance</li>
<li>&action=get&concept=<concept_id>  revoir une correspondance</li>
<li>&action=list_sets  retourner une liste des préfixes de contextes possibles et à quoi ils réfèrent.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> pour une définition d’un concept, retourner toutes les autres.</li>
<li>&action=help  Voir l’aide complète.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => "<p>Le carte des concepts vous permet d'identifier quel sens défini d'un ensemble de données est identique aux sens définis pour les autres ensembles de données.</p>",
	'ow_conceptmapping_no_action_specified' => 'Désolé, je ne sais pas comment exécuter « $1 ».',
	'ow_dm_OK'                              => 'Valider',
	'ow_dm_not_present'                     => 'non inscrit',
	'ow_dm_not_found'                       => 'non trouvé dans la base de données ou mal rédigé',
	'ow_mapping_successful'                 => 'Tous les champs marqués avec [OK] ont été insérés<br />',
	'ow_mapping_unsuccessful'               => 'Il faut qu’au moins deux sens soient définis avant qu’ils ne puissent être reliés.',
	'ow_will_insert'                        => 'Insèrera les suivants :',
	'ow_contents_of_mapping'                => 'Correspondances',
	'ow_available_contexts'                 => 'Contextes disponibles',
	'ow_add_concept_link'                   => 'Ajouter un lien aux autres concepts',
	'ow_concept_panel'                      => 'Éventail de concepts',
	'ow_dm_badtitle'                        => "Cette page ne pointe sur aucun concept ou sens défini. Veuillez vérifier l'adresse internet.",
	'ow_dm_missing'                         => "Cette page semble pointer vers un concept ou un sens inexistant. Veuillez vérifier l'adresse Web.",
	'ow_AlternativeDefinition'              => 'Définition alternative',
	'ow_AlternativeDefinitions'             => 'Définitions alternatives',
	'ow_Annotation'                         => 'Annotation',
	'ow_ApproximateMeanings'                => 'Sens approximatifs',
	'ow_ClassAttributeAttribute'            => 'Attribut',
	'ow_ClassAttributes'                    => 'Attributs de classe',
	'ow_ClassAttributeLevel'                => 'Niveau',
	'ow_ClassAttributeType'                 => 'Type',
	'ow_ClassMembership'                    => 'Classes',
	'ow_Collection'                         => 'Collection',
	'ow_CollectionMembership'               => 'Collections',
	'ow_Definition'                         => 'Définition',
	'ow_DefinedMeaningAttributes'           => 'Annotation',
	'ow_DefinedMeaning'                     => 'Sens défini',
	'ow_DefinedMeaningReference'            => 'Sens défini',
	'ow_ExactMeanings'                      => 'Sens exacts',
	'ow_Expression'                         => 'Expression',
	'ow_ExpressionMeanings'                 => 'Sens des expressions',
	'ow_Expressions'                        => 'Expressions',
	'ow_IdenticalMeaning'                   => 'Sens identique ?',
	'ow_IncomingRelations'                  => 'Relations entrantes',
	'ow_GotoSource'                         => 'Voir la source',
	'ow_Language'                           => 'Langue',
	'ow_LevelAnnotation'                    => 'Annotation',
	'ow_OptionAttribute'                    => 'Propriété',
	'ow_OptionAttributeOption'              => 'Option',
	'ow_OptionAttributeOptions'             => 'Options',
	'ow_OptionAttributeValues'              => 'Valeurs des options',
	'ow_OtherDefinedMeaning'                => 'Autre sens défini',
	'ow_PopupAnnotation'                    => 'Annotation',
	'ow_Relations'                          => 'Relations',
	'ow_RelationType'                       => 'Type de relation',
	'ow_Spelling'                           => 'Orthographe',
	'ow_Synonyms'                           => 'Synonymes',
	'ow_SynonymsAndTranslations'            => 'Synonymes et traductions',
	'ow_Source'                             => 'Source',
	'ow_SourceIdentifier'                   => 'Identificateur de source',
	'ow_TextAttribute'                      => 'Propriété',
	'ow_Text'                               => 'Texte',
	'ow_TextAttributeValues'                => 'Texte libre',
	'ow_TranslatedTextAttribute'            => 'Propriété',
	'ow_TranslatedText'                     => 'Texte traduit',
	'ow_TranslatedTextAttributeValue'       => 'Texte',
	'ow_TranslatedTextAttributeValues'      => 'Textes traduisibles',
	'ow_LinkAttribute'                      => 'Attribut',
	'ow_LinkAttributeValues'                => 'Liens',
	'ow_Property'                           => 'Propriété',
	'ow_Value'                              => 'Valeur',
	'ow_meaningsoftitle'                    => 'Sens de « $1 »',
	'ow_meaningsofsubtitle'                 => '<em>lien wiki :</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>PERMISSION REFUSÉE</h2>',
	'ow_copy_no_action_specified'           => 'Merci de spécifier une action',
	'ow_copy_help'                          => 'Aide à venir...',
	'ow_please_proved_dmid'                 => 'Il manque un ?dmid=<...> (dmid=SensDéfini ID)<br />Contactez l’administrateur.',
	'ow_please_proved_dc1'                  => 'Il manque un ?dc1=<...> (dc1=contexte de la base 1, base DEPUIS laquelle on copie)<br />Contactez l’administrateur.',
	'ow_please_proved_dc2'                  => 'Il manque un ?dc2=<...> (dc1=contexte de la base 2, base VERS laquelle on copie)<br />Contactez l’administrateur.',
	'ow_copy_successful'                    => "<h2>Succès de la copie</h2>Vos données ont été copiées avec succès. Veuillez vérifiez que c'est bien le cas.",
	'ow_copy_unsuccessful'                  => "<h3>Copie infructueuse</h3> Aucune opération de copie n'a pris place.",
	'ow_no_action_specified'                => "<h3>Aucune action n'a été spécifiée</h3> Peut-être êtes-vous venu sur cette page directement ? Vous n'avez pas, en principe, à être ici.",
	'ow_db_consistency_not_found'           => "<h2>Erreur</h2>La base de données semble corrompue, wikidata ne peut trouver des données valides liées à l'identificateur (ID) du sens défini. Il pourrait être détruit. Veuillez contacter l'opérateur ou l'administrateur du serveur.",
);

/** Irish (Gaeilge)
 * @author Alison
 */
$wdMessages['ga'] = array(
	'datasearch'                 => 'Vicísonraí: Cuardaigh sonraí',
	'langman_title'              => 'Bainisteoir teangacha',
	'languages'                  => 'Vicísonraí: Bainisteoir teangacha',
	'ow_save'                    => 'Sábháil',
	'ow_history'                 => 'Stair',
	'ow_uiprefs'                 => 'Vicísonraí',
	'ow_Annotation'              => 'Anótáil',
	'ow_ClassAttributeLevel'     => 'Leibhéal',
	'ow_ClassAttributeType'      => 'Cineál',
	'ow_Language'                => 'Teanga',
	'ow_Spelling'                => 'Litriú',
	'ow_Synonyms'                => 'Comhchiallaigh',
	'ow_SynonymsAndTranslations' => 'Comhchiallaigh agus aistriúcháin',
	'ow_Text'                    => 'Téacs',
	'ow_TextAttributeValues'     => 'Gnáth-théacs',
	'ow_LinkAttributeValues'     => 'Naisc',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$wdMessages['gl'] = array(
	'datasearch'                            => 'Wikidata: Procura de datos',
	'langman_title'                         => 'Xestor de linguas',
	'languages'                             => 'Wikidata: Xestor de linguas',
	'ow_save'                               => 'Gardar',
	'ow_history'                            => 'Historial',
	'ow_datasets'                           => 'Selección de datos fixados',
	'ow_noedit_title'                       => 'Non ten permisos para editar',
	'ow_noedit'                             => 'Non ten permiso para editar páxinas de datos fixados "$1".
Por favor, vexa [[{{MediaWiki:Ow editing policy url}}|a nosa política de edición]].',
	'ow_uipref_datasets'                    => 'Vista por defecto',
	'ow_uiprefs'                            => 'Wikidatos',
	'ow_none_selected'                      => '<Ningún seleccionado>',
	'ow_conceptmapping_help'                => '<p>accións posibles: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  inserir un mapa</li>
<li>&action=get&concept=<concept_id>  ler un mapa</li>
<li>&action=list_sets  devolver unha lista cos prefixos de contexto posibles e a que se refiren.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> para unha definición dun concepto, devolver todo o demais</li>
<li>&action=help  Amosar a axuda útil.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>O mapa de conceptos permítelle identificar cal é a definición nun conxunto de datos que é idéntico ás definicións noutros conxuntos.</p>',
	'ow_conceptmapping_no_action_specified' => 'Síntoo, non sei como "$1".',
	'ow_dm_OK'                              => 'De acordo',
	'ow_dm_not_present'                     => 'non introducido',
	'ow_dm_not_found'                       => 'non atopado na base de datos ou malformado',
	'ow_mapping_successful'                 => 'Mapeados todos os campos marcados con [OK]<br />',
	'ow_mapping_unsuccessful'               => 'Precísase ter, polo menos, dúas definición antes de que poida ligalas.',
	'ow_will_insert'                        => 'Insertará o seguinte:',
	'ow_contents_of_mapping'                => 'Contidos do trazado dun mapa',
	'ow_available_contexts'                 => 'Contextos dispoñíbeis',
	'ow_add_concept_link'                   => 'Engadir ligazón a outros conceptos',
	'ow_concept_panel'                      => 'Panel de conceptos',
	'ow_dm_badtitle'                        => 'Esta páxina non sinala cara a ningunha definición (concepto).
Por favor, comprobe a dirección da páxina web.',
	'ow_dm_missing'                         => 'Esta páxina parece que sinala cara a ningunha definición (concepto) que non existe.
Por favor, comprobe a dirección da páxina web.',
	'ow_AlternativeDefinition'              => 'Definición alternativa',
	'ow_AlternativeDefinitions'             => 'Definicións alternativas',
	'ow_Annotation'                         => 'Anotación',
	'ow_ApproximateMeanings'                => 'Significados aproximados',
	'ow_ClassAttributeAttribute'            => 'Atributo',
	'ow_ClassAttributes'                    => 'Clase de atributos',
	'ow_ClassAttributeLevel'                => 'Nivel',
	'ow_ClassAttributeType'                 => 'Tipo',
	'ow_ClassMembership'                    => 'Clase de membros',
	'ow_Collection'                         => 'Recompilación',
	'ow_CollectionMembership'               => 'Recompilación dos membros',
	'ow_Definition'                         => 'Definición',
	'ow_DefinedMeaningAttributes'           => 'Anotación',
	'ow_DefinedMeaning'                     => 'Significado definido',
	'ow_DefinedMeaningReference'            => 'Significado definido',
	'ow_ExactMeanings'                      => 'Significados exactos',
	'ow_Expression'                         => 'Expresión',
	'ow_ExpressionMeanings'                 => 'Significados da expresión',
	'ow_Expressions'                        => 'Expresións',
	'ow_IdenticalMeaning'                   => 'significado idéntico?',
	'ow_IncomingRelations'                  => 'Relacións entrantes',
	'ow_GotoSource'                         => 'Ir á orixe',
	'ow_Language'                           => 'Lingua',
	'ow_LevelAnnotation'                    => 'Anotación',
	'ow_OptionAttribute'                    => 'Característica',
	'ow_OptionAttributeOption'              => 'Opción',
	'ow_OptionAttributeOptions'             => 'Opcións',
	'ow_OptionAttributeValues'              => 'Valores de opción',
	'ow_OtherDefinedMeaning'                => 'Outro significado definido',
	'ow_PopupAnnotation'                    => 'Anotación',
	'ow_Relations'                          => 'Relacións',
	'ow_RelationType'                       => 'Tipo de relación',
	'ow_Spelling'                           => 'Ortografía',
	'ow_Synonyms'                           => 'Sinónimos',
	'ow_SynonymsAndTranslations'            => 'Sinónimos e traducións',
	'ow_Source'                             => 'Orixe',
	'ow_SourceIdentifier'                   => 'Identificador da Orixe',
	'ow_TextAttribute'                      => 'Característica',
	'ow_Text'                               => 'Texto',
	'ow_TextAttributeValues'                => 'Textos sinxelos',
	'ow_TranslatedTextAttribute'            => 'Característica',
	'ow_TranslatedText'                     => 'Texto traducido',
	'ow_TranslatedTextAttributeValue'       => 'Texto',
	'ow_TranslatedTextAttributeValues'      => 'Textos traducíbeis',
	'ow_LinkAttribute'                      => 'Propiedade',
	'ow_LinkAttributeValues'                => 'Ligazóns',
	'ow_Property'                           => 'Propiedade',
	'ow_Value'                              => 'Valor',
	'ow_meaningsoftitle'                    => 'Significados de "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Ligazón Wiki:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>PERMISO DENEGADO</h2>',
	'ow_copy_no_action_specified'           => 'Precisar unha acción',
	'ow_copy_help'                          => 'Algún día, nós poderemos axudalo.',
	'ow_please_proved_dmid'                 => 'Parace que na súa contribución falta "?dmid=<ID>" (dmid=Definición ID)<br />
Por favor, póñase en contacto cun administrador do servidor.',
	'ow_please_proved_dc1'                  => 'Parace que na súa contribución falta "?dc1=<algo>" (dc1=contexto do conxunto de datos 1, conxunto de datos DO cual copiar)<br />
Por favor, póñase en contacto cun administrador do servidor.',
	'ow_please_proved_dc2'                  => 'Parace que na súa contribución falta "?dc2=<algo>" (dc2=contexto do conxunto de datos 2, conxunto de datos AO cual copiar)<br />
Por favor, póñase en contacto cun administrador do servidor.',
	'ow_copy_successful'                    => '<h2>Copia exitosa</h2>
Parece que os seus datos foron copiados con éxito.
Non esqueza volvelos comprobar para asegurarse!',
	'ow_copy_unsuccessful'                  => '<h3>Copia sen éxito</h3> Ningunha operación de copiado tivo lugar.',
	'ow_no_action_specified'                => '<h3>Non foi especificada ningunha acción</h3> Quizais veu a esta páxina directamente? Normalmente non precisa estar aquí.',
	'ow_db_consistency_not_found'           => '<h2>Erro</h2>
Hai un erro coa constancia da base de datos e os datos wiki non poden atopar datos válidos conectados con esta definición ID.
Pode que se perderan.
Por favor, póñase en contacto cun operador ou administrador do servidor.',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$wdMessages['gv'] = array(
	'langman_title'                   => 'Reireyder çhengey',
	'languages'                       => 'Wikidata: Reireyder çhengey',
	'ow_save'                         => 'Sauail',
	'ow_history'                      => 'Shennaghys',
	'ow_uiprefs'                      => 'Wikidata',
	'ow_dm_OK'                        => 'OK',
	'ow_ClassAttributeLevel'          => 'Corrym',
	'ow_ClassAttributeType'           => 'Sorçh',
	'ow_Language'                     => 'Çhengey',
	'ow_Text'                         => 'Teks',
	'ow_TranslatedTextAttributeValue' => 'Teks',
	'ow_LinkAttributeValues'          => 'Kianglaghyn',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 * @author Kalani
 */
$wdMessages['haw'] = array(
	'ow_history' => 'Mo‘olelo',
	'ow_dm_OK'   => 'Hiki nō',
);

/** Hebrew (עברית) */
$wdMessages['he'] = array(
	'langman_title' => 'מנהל שפות',
);

/** Hindi (हिन्दी)
 * @author Ashishbhatnagar72
 * @author Kaustubh
 */
$wdMessages['hi'] = array(
	'datasearch'                => 'Wikidata: आंकडा़ खोज',
	'langman_title'             => 'भाषा प्रबंधक',
	'languages'                 => 'Wikidata: भाषा प्रबंधक',
	'ow_save'                   => 'संजोयें',
	'ow_history'                => 'इतिहास',
	'ow_noedit_title'           => 'संपादन की अनुमति नहीं है',
	'ow_noedit'                 => 'आपको डाटासेट "$1" में पन्ने संपादन करने की अनुमति नहीं है. कृपया हमारी [[{{MediaWiki:Ow editing policy url}}|संपादन नीति]] देखें.',
	'ow_none_selected'          => '<कुछ चयनित नहीं>',
	'ow_dm_OK'                  => 'ओके',
	'ow_dm_not_present'         => 'प्रवेश नहीं किया गया',
	'ow_will_insert'            => 'निम्न को अन्तर्निविष्ट करेगा:',
	'ow_AlternativeDefinition'  => 'वैकल्पिक परिभाषा',
	'ow_AlternativeDefinitions' => 'वैकल्पिक परिभाषाएं',
	'ow_ApproximateMeanings'    => 'सन्निकट अर्थ',
	'ow_ClassAttributeLevel'    => 'स्तर',
	'ow_ClassAttributeType'     => 'प्रकार',
	'ow_Collection'             => 'कलेक्शन',
	'ow_Definition'             => 'परिभाषा',
	'ow_Language'               => 'भाषा',
	'ow_OptionAttributeOption'  => 'विकल्प',
	'ow_OptionAttributeOptions' => 'विकल्प',
	'ow_Relations'              => 'संबन्ध',
	'ow_Source'                 => 'स्रोत',
	'ow_Permission_denied'      => '<h2>अनुमति नहीं दी</h2>',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$wdMessages['hil'] = array(
	'ow_history' => 'Saysay',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$wdMessages['hsb'] = array(
	'datasearch'                            => 'Wikidata: Pytanje datow',
	'langman_title'                         => 'Zrjadowak rěčow',
	'languages'                             => 'Wikidata: Zrjadowak rěčow',
	'ow_save'                               => 'Składować',
	'ow_history'                            => 'Stawizny',
	'ow_datasets'                           => 'Mnóstwo datow wubrać',
	'ow_noedit_title'                       => 'Žana dowolnosć za wobdźěłowanje',
	'ow_noedit'                             => 'Njesměš strony w sadźbje datow "$1" wobdźěłować. Prošu hlej [[{{MediaWiki:Ow editing policy url}}|naše směrnicy za wobdźěłowanje]].',
	'ow_uipref_datasets'                    => 'Standardny napohlad',
	'ow_uiprefs'                            => 'Wikidaty',
	'ow_none_selected'                      => '<Ničo wubrane>',
	'ow_conceptmapping_help'                => '<p>Móžne akcije: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  Zwjazanje zasunyć</li>
<li>&action=get&concept=<concept_id>  Zwjazanje wotwołać</li>
<li>&action=list_sets  Lisćinu móžnych prefiksow konteksta datow pokazać  a na štož so poćahuja.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> Za definowany woznam w konteksće wšě druhe pokazać</li>
<li>&action=help  Wužitnu pomoc pokazać.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Concept mapping ći dowola identifikować, kotry definowany woznam en sadźbje datow je identiski z definowanymi woznami w druhich sadźbach datow.</p>',
	'ow_conceptmapping_no_action_specified' => 'Wodaj, njewěm, kak mam "$1".',
	'ow_dm_OK'                              => 'W porjadku',
	'ow_dm_not_present'                     => 'njezapodaty',
	'ow_dm_not_found'                       => 'w datowej bance njenamakany abo ze zmylkami',
	'ow_mapping_successful'                 => 'Wšě pola markěrowane z [OK] přirjadowane<br />',
	'ow_mapping_unsuccessful'               => 'Su znajmjeńša dwaj definowanej woznamej za wotkazowanje trjeba.',
	'ow_will_insert'                        => 'Slědowace so zasunje:',
	'ow_contents_of_mapping'                => 'Wobsah zwjazanja',
	'ow_available_contexts'                 => 'K dispoziciji stejace konteksty',
	'ow_add_concept_link'                   => 'Wotkazy k druhim konceptam přidać',
	'ow_concept_panel'                      => 'Konceptowy panel',
	'ow_dm_badtitle'                        => 'Tuta strona njepokazuje na DefinedMeaning (koncept). Prošu přepruwuj webadresu.',
	'ow_dm_missing'                         => 'Tuta strona pokazuje po wšěm zdaću na njeeksistowacy DefinedMeaning (koncept). Prošu přepruwuj webadresu.',
	'ow_AlternativeDefinition'              => 'Alternatiwna definicija',
	'ow_AlternativeDefinitions'             => 'Alternatiwne definicije',
	'ow_Annotation'                         => 'Anotacija',
	'ow_ApproximateMeanings'                => 'Přibližne woznamy',
	'ow_ClassAttributeAttribute'            => 'Atribut',
	'ow_ClassAttributes'                    => 'Klasowe atributy',
	'ow_ClassAttributeLevel'                => 'Runina',
	'ow_ClassAttributeType'                 => 'Typ',
	'ow_ClassMembership'                    => 'Klasowa přisłušnosć',
	'ow_Collection'                         => 'Zběrka',
	'ow_CollectionMembership'               => 'Přisłušnosć zběrki',
	'ow_Definition'                         => 'Definicija',
	'ow_DefinedMeaningAttributes'           => 'Anotacija',
	'ow_DefinedMeaning'                     => 'Definowany woznam',
	'ow_DefinedMeaningReference'            => 'Definowany woznam',
	'ow_ExactMeanings'                      => 'Eksaktne woznamy',
	'ow_Expression'                         => 'Wuraz',
	'ow_ExpressionMeanings'                 => 'Wurazowe woznamy',
	'ow_Expressions'                        => 'Wurazy',
	'ow_IdenticalMeaning'                   => 'Identiski woznam?',
	'ow_IncomingRelations'                  => 'Dochadźace poćahi',
	'ow_GotoSource'                         => 'Dźi k žórłu',
	'ow_Language'                           => 'Rěč',
	'ow_LevelAnnotation'                    => 'Anotacija',
	'ow_OptionAttribute'                    => 'Kajkosć',
	'ow_OptionAttributeOption'              => 'Opcija',
	'ow_OptionAttributeOptions'             => 'Opcije',
	'ow_OptionAttributeValues'              => 'Opciske hódnoty',
	'ow_OtherDefinedMeaning'                => 'Druhi definowany woznam',
	'ow_PopupAnnotation'                    => 'Anotacija',
	'ow_Relations'                          => 'Poćahi',
	'ow_RelationType'                       => 'Poćahowy typ',
	'ow_Spelling'                           => 'Prawopis',
	'ow_Synonyms'                           => 'Synonymy',
	'ow_SynonymsAndTranslations'            => 'Synonymy a přełožki',
	'ow_Source'                             => 'Žórło',
	'ow_SourceIdentifier'                   => 'Žóřłowy identifikator',
	'ow_TextAttribute'                      => 'Kajkosć',
	'ow_Text'                               => 'Tekst',
	'ow_TextAttributeValues'                => 'Lute teksty',
	'ow_TranslatedTextAttribute'            => 'Kajkosć',
	'ow_TranslatedText'                     => 'Přełoženy tekst',
	'ow_TranslatedTextAttributeValue'       => 'Tekst',
	'ow_TranslatedTextAttributeValues'      => 'Přełožujomny tekst',
	'ow_LinkAttribute'                      => 'Kajkosć',
	'ow_LinkAttributeValues'                => 'Wotkazy',
	'ow_Property'                           => 'Kajkosć',
	'ow_Value'                              => 'Hódnota',
	'ow_meaningsoftitle'                    => 'Woznamy za "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Wikiwotkaz:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>DOWOLNOSĆ ZAPOWĚDŹENA</h2>',
	'ow_copy_no_action_specified'           => 'Podaj prošu akciju',
	'ow_copy_help'                          => 'Jednoho dnja móžemy ći pomhać.',
	'ow_please_proved_dmid'                 => 'Zda so, zo w twojim zapodaću "?dmid=<ID>" (dmid=Defined Meaning ID) faluje.<br />Prošu skontaktuj serweroweho administratora.',
	'ow_please_proved_dc1'                  => 'Zda so, zo w twojim zapodaću "?dc1=<something>" (dc1=dataset context 1, dataset to copy FROM)<br />Prošu skontaktuj serweroweho administratora.',
	'ow_please_proved_dc2'                  => 'Zda so, zo w twojim zapodaću "?dc2=<something>" (dc2=dataset context 2, dataset to copy TO)<br />Prošu skontaktuj serweroweho administratora.',
	'ow_copy_successful'                    => '<h2>Kopěrowanje wuspěšne</h2>Zda so, zo twoje daty su so wušpěšnje kopěrowali. Njezabudź hišće raz pruwować, zo by zawěsće był.',
	'ow_copy_unsuccessful'                  => '<h3>Kopěrowanje njewuspěšne</h3> Žana kopěrowanska operacija njeje so wotměła.',
	'ow_no_action_specified'                => '<h3>Žana akcija podata</h3> Sy ty snano direktnje k tutej stronje přišoł? W normalny padźe njetrjebaš tu być.',
	'ow_db_consistency_not_found'           => '<h2>Zmylk</h2>Je problem z konsistencu datoweje banki, wikidata njemóže płaćiwe daty namakać, kotrež su z tutym ID definedMeaning zwjazane. Snano su so zhubili. Prošu skontaktuj serweroweho operatora abo administratora.',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$wdMessages['hu'] = array(
	'ow_save'                          => 'Mentés',
	'ow_uipref_datasets'               => 'Alapértelmezett nézet',
	'ow_dm_OK'                         => 'OK',
	'ow_ClassAttributeLevel'           => 'Szint',
	'ow_ClassAttributeType'            => 'Típus',
	'ow_ExactMeanings'                 => 'Pontos jelentések',
	'ow_Expression'                    => 'Kifejezés',
	'ow_Expressions'                   => 'Kifejezések',
	'ow_Language'                      => 'Nyelv',
	'ow_Relations'                     => 'Relációk',
	'ow_RelationType'                  => 'Reláció típusa',
	'ow_Spelling'                      => 'Kiejtés',
	'ow_Synonyms'                      => 'Szinonímák',
	'ow_Source'                        => 'Forrás',
	'ow_SourceIdentifier'              => 'Forrásazonosító',
	'ow_TextAttribute'                 => 'Tulajdonság',
	'ow_Text'                          => 'Szöveg',
	'ow_TranslatedTextAttribute'       => 'Tulajdonság',
	'ow_TranslatedText'                => 'Lefordított szöveg',
	'ow_TranslatedTextAttributeValue'  => 'Szöveg',
	'ow_TranslatedTextAttributeValues' => 'Fordítandó szöveg',
	'ow_LinkAttribute'                 => 'Tulajdonság',
	'ow_Property'                      => 'Tulajdonság',
	'ow_Value'                         => 'Érték',
	'ow_meaningsoftitle'               => '„$1” jelentései',
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$wdMessages['ia'] = array(
	'ow_save'                => 'Immagazinar',
	'ow_none_selected'       => '<Nihil seligite>',
	'ow_dm_OK'               => 'OK',
	'ow_Language'            => 'Lingua',
	'ow_LinkAttributeValues' => 'Ligamines',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 * @author Rex
 */
$wdMessages['id'] = array(
	'datasearch'                            => 'Wikidata: Pencarian data',
	'langman_title'                         => 'Pengelola bahasa',
	'languages'                             => 'Wikidata: Pengelola bahasa',
	'ow_save'                               => 'Simpan',
	'ow_history'                            => 'Versi',
	'ow_datasets'                           => 'Pemilihan set-data',
	'ow_noedit_title'                       => 'Tidak memiliki hak untuk menyunting',
	'ow_noedit'                             => 'Anda tidak diizinkan menyunting halaman-halaman di set data "$1".
Lihat: [[{{MediaWiki:Ow editing policy url}}|Kebijakan penyuntingan kami]].',
	'ow_uipref_datasets'                    => 'Tampilan baku',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<Belum dipilih>',
	'ow_conceptmapping_no_action_specified' => 'Maaf, sistem tidak mengerti untuk "$1".',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'tidak dimasukkan',
	'ow_Language'                           => 'Bahasa',
	'ow_OptionAttributeOptions'             => 'Pilihan',
);

/** Ido (Ido)
 * @author Malafaya
 */
$wdMessages['io'] = array(
	'ow_save'                               => 'Registragar',
	'ow_history'                            => 'Versionaro',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_conceptmapping_no_action_specified' => 'Pardonez! Me ne savas quale "$1".',
	'ow_Annotation'                         => 'Noto',
	'ow_ClassAttributeAttribute'            => 'Atributo',
	'ow_ClassAttributes'                    => 'Atributi di klaso',
	'ow_ClassAttributeType'                 => 'Tipo',
	'ow_ClassMembership'                    => 'Klaso-membrari',
	'ow_Collection'                         => 'Kolektajo',
	'ow_CollectionMembership'               => 'Kolektajo-membrari',
	'ow_Definition'                         => 'Defino',
	'ow_DefinedMeaningAttributes'           => 'Noto',
	'ow_IdenticalMeaning'                   => 'Identa senco?',
	'ow_GotoSource'                         => 'Irar al fonto',
	'ow_Language'                           => 'Linguo',
	'ow_LevelAnnotation'                    => 'Noto',
	'ow_OptionAttribute'                    => 'Proprajo',
	'ow_OptionAttributeOption'              => 'Selekto',
	'ow_OptionAttributeOptions'             => 'Selekti',
	'ow_PopupAnnotation'                    => 'Noto',
	'ow_Relations'                          => 'Relati',
	'ow_Spelling'                           => 'Espelado',
	'ow_Synonyms'                           => 'Sinonimi',
	'ow_SynonymsAndTranslations'            => 'Sinonimi e tradukuri',
	'ow_Source'                             => 'Fonto',
	'ow_TextAttribute'                      => 'Proprajo',
	'ow_Text'                               => 'Texto',
	'ow_TranslatedTextAttribute'            => 'Proprajo',
	'ow_TranslatedTextAttributeValue'       => 'Texto',
	'ow_LinkAttribute'                      => 'Proprajo',
	'ow_LinkAttributeValues'                => 'Ligili',
	'ow_Property'                           => 'Proprajo',
	'ow_Value'                              => 'Valoro',
	'ow_meaningsoftitle'                    => 'Senci di "$1"',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$wdMessages['is'] = array(
	'ow_save'            => 'Vista',
	'ow_uipref_datasets' => 'Sjálfgefið útlit',
	'ow_uiprefs'         => 'Wikigögn',
	'ow_dm_OK'           => 'Í lagi',
);

/** Japanese (日本語)
 * @author JtFuruhata
 */
$wdMessages['ja'] = array(
	'datasearch'                            => 'ウィキデータ: データ検索',
	'langman_title'                         => '言語マネージャ',
	'languages'                             => 'ウィキデータ: 言語マネージャ',
	'ow_save'                               => '保存',
	'ow_history'                            => '履歴',
	'ow_datasets'                           => 'データセット',
	'ow_noedit_title'                       => '編集権限がありません',
	'ow_noedit'                             => 'データセット "$1" の編集権限がありません。[[{{MediaWiki:Ow editing policy url}}|編集方針]]をご覧ください。',
	'ow_uipref_datasets'                    => 'デフォルト表示',
	'ow_uiprefs'                            => 'ウィキデータ',
	'ow_none_selected'                      => '（選択なし）',
	'ow_conceptmapping_help'                => '<p>可能な操作: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  関連付けを作成</li>
<li>&action=get&concept=<concept_id>  関連する内容を取得</li>
<li>&action=list_sets  取得可能なデータの接頭辞とその関連項目の一覧を取得</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> ある概念に対する意味定義の一つから他の意味定義すべてを取得</li>
<li>&action=help  ヘルプの表示</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>コンセプトマップでは、あるデータセットに登録されている意味定義と他のデータセットにある同一概念の意味定義を関連付けることが可能です。</p>',
	'ow_conceptmapping_no_action_specified' => '申し訳ありません、"$1" という操作は定義されていません。',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => '指定がありません',
	'ow_dm_not_found'                       => 'データベースに存在しないか、不正な指定です',
	'ow_mapping_successful'                 => '関連する全てのフィールドを[OK]とマークしました<br />',
	'ow_mapping_unsuccessful'               => '関連付けを作成するには、少なくとも意味定義が2つ登録されている必要があります。',
	'ow_will_insert'                        => '以下の内容で作成します:',
	'ow_contents_of_mapping'                => '関連付けの内容',
	'ow_available_contexts'                 => '有効な関連内容',
	'ow_add_concept_link'                   => '他の概念とのリンクを作成',
	'ow_concept_panel'                      => '概念パネル',
	'ow_dm_badtitle'                        => 'このページが指し示す意味定義（概念）は何もありません。URLの指定が正しいか確認してください。',
	'ow_dm_missing'                         => 'このページは存在しない意味定義（概念）を指し示しているように見えます。URLの指定が正しいか確認してください。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$wdMessages['jv'] = array(
	'datasearch'                            => 'Wikidata: Panggolèkan data',
	'langman_title'                         => 'Pangurus basa',
	'languages'                             => 'Wikidata: Pangurus basa',
	'ow_save'                               => 'Simpen',
	'ow_history'                            => 'Sajarah',
	'ow_datasets'                           => 'Sèlèksi data-set',
	'ow_noedit_title'                       => 'Ora ana idin kanggo nyunting',
	'ow_noedit'                             => 'Panjenengan ora diparengaké nyunting kaca-kaca ing dataset "$1".
Mangga mirsani [[{{MediaWiki:Ow editing policy url}}|kawicaksanan panyuntingan kita]].',
	'ow_uipref_datasets'                    => 'Pamandhangan baku',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<Ora ana sing disèlèksi>',
	'ow_conceptmapping_no_action_specified' => 'Nuwun sèwu, aku ora ngerti carané "$1".',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'ora dilebokaké',
	'ow_dm_not_found'                       => 'ora ditemokaké ing basis data utawa rusak',
	'ow_will_insert'                        => 'Bakal nyisipaké:',
	'ow_available_contexts'                 => 'Kontèks sing ana',
	'ow_add_concept_link'                   => 'Nambah pranala menyang konsèp liyané',
	'ow_concept_panel'                      => 'Panèl Konsèp',
	'ow_AlternativeDefinition'              => 'Définisi alternatif',
	'ow_AlternativeDefinitions'             => 'Définisi alternatif',
	'ow_Annotation'                         => 'Anotasi',
	'ow_ClassAttributeLevel'                => 'Tingkatan',
	'ow_ClassAttributeType'                 => 'Jenis',
	'ow_Collection'                         => 'Kolèksi',
	'ow_CollectionMembership'               => 'Kaanggotan kolèksi',
	'ow_Definition'                         => 'Définisi',
	'ow_DefinedMeaningAttributes'           => 'Anotasi',
	'ow_DefinedMeaning'                     => 'Arti sing didéfinisi',
	'ow_DefinedMeaningReference'            => 'Arti sing didéfinisi',
	'ow_Expression'                         => 'Èksprèsi',
	'ow_Expressions'                        => 'Èksprèsi',
	'ow_IdenticalMeaning'                   => 'Tegesé mèmper?',
	'ow_IncomingRelations'                  => 'Rélasi sing teka mlebu',
	'ow_GotoSource'                         => 'Menyang sumber',
	'ow_Language'                           => 'Basa',
	'ow_LevelAnnotation'                    => 'Anotasi',
	'ow_OptionAttribute'                    => 'Sifat',
	'ow_OptionAttributeOption'              => 'Opsi',
	'ow_OptionAttributeOptions'             => 'Opsi',
	'ow_OptionAttributeValues'              => 'Bijih opsi',
	'ow_PopupAnnotation'                    => 'Anotasi',
	'ow_Relations'                          => 'Relasi',
	'ow_RelationType'                       => 'Jenis rélasi',
	'ow_Spelling'                           => 'Pasang aksara (éjaan)',
	'ow_Synonyms'                           => 'Sinonim',
	'ow_SynonymsAndTranslations'            => 'Sinonim lan jarwa',
	'ow_Source'                             => 'Sumber',
	'ow_SourceIdentifier'                   => 'Idèntifikator sumber',
	'ow_TextAttribute'                      => 'Sifat',
	'ow_Text'                               => 'Tèks',
	'ow_TextAttributeValues'                => 'Tèks-tèks prasaja',
	'ow_TranslatedTextAttribute'            => 'Sifat',
	'ow_TranslatedText'                     => 'Tèks sing wis dipertal',
	'ow_TranslatedTextAttributeValue'       => 'Tèks',
	'ow_TranslatedTextAttributeValues'      => 'Tèks sing bisa dipertal',
	'ow_LinkAttribute'                      => 'Sifat',
	'ow_LinkAttributeValues'                => 'Pranala',
	'ow_Property'                           => 'Sifat',
	'ow_Value'                              => 'Bijih',
	'ow_meaningsoftitle'                    => 'Arti saka "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Pranala wiki:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>IDIN DITOLAK</h2>',
	'ow_copy_no_action_specified'           => 'Tulung rincèkna sawijining aksi',
	'ow_copy_help'                          => 'Ing sawijining dina ing tembé, kita mbok-menawa bisa nulungi panjenengan.',
	'ow_copy_successful'                    => '<h2>Kopi suksès</h2>
Data panjenengan katoné wis dikopi sacara suksès.
Aja lali mriksa manèh supaya pasti!',
	'ow_copy_unsuccessful'                  => '<h3>Kopi ora suksès</h3>
Ora ana operasi kopi sing wis dumadi.',
	'ow_no_action_specified'                => '<h3>Ora ana aksi sing dispésifikasi</h3>
Mbok-menawa panjenengan langsung tekan kaca iki? Biasané panjenengan ora perlu ing kéné.',
);

/** Georgian (ქართული)
 * @author Sopho
 * @author Malafaya
 */
$wdMessages['ka'] = array(
	'datasearch'                            => 'ვიკიდატა: მონაცემთა ძიება',
	'langman_title'                         => 'ენების მენეჯერი',
	'languages'                             => 'ვიკიდატა: ენების მენეჯერი',
	'ow_save'                               => 'შენახვა',
	'ow_history'                            => 'ისტორია',
	'ow_datasets'                           => 'მონაცემთა ნაკრების შერჩევა',
	'ow_noedit_title'                       => 'თქვენ არ გაქვთ რედაქტირების უფლება',
	'ow_noedit'                             => 'თქვენ არ გაქვთ მონაცემთა ნაკრებში "$1" გვერდების რედაქტირების ნებართვა. იხილეთ [[{{MediaWiki:Ow editing policy url}}|ჩვენი სარედაქციო პოლიტიკა]].',
	'ow_uipref_datasets'                    => 'სტანდარტული ჩვენება',
	'ow_uiprefs'                            => 'ვიკიდატა',
	'ow_none_selected'                      => '<არაფერია შერჩეული>',
	'ow_conceptmapping_uitext'              => '<p>ცნებათა შესაბამისობა (Concept Mapping) საშუალებას გაძლევთ დაადგინოთ, ამა თუ იმ მონაცემთა ნაკრებში რომელი განსაზღვრული მნიშვნელობაა სხვა მონაცემთა ნაკრებებში არსებულ განსაზღვრულ მნიშვნელობათა იდენტური.</p>',
	'ow_conceptmapping_no_action_specified' => 'ბოდიში, არ ვიცი როგორ "$1".',
	'ow_dm_not_present'                     => 'არ არის შეტანილი',
	'ow_mapping_unsuccessful'               => 'საჭიროა მინიმუმ ორი განსაზღვრული მნიშვნელობა იმისათვის, რათა მოხდეს მათი ერთმანეთთან დაკავშირება.',
	'ow_will_insert'                        => 'დაემატება შემდეგი:',
	'ow_available_contexts'                 => 'არსებული კონტექსტები',
	'ow_concept_panel'                      => 'ცნებების პანელი',
	'ow_dm_badtitle'                        => 'ეს გვერდი არ უთითებს არცერთ განსაზღვრულ მნიშვნელობას (ცნებას). თუ შეიძლება, შეამოწმეთ ვებ-მისამართი.',
	'ow_dm_missing'                         => 'ეს გვერდი, როგორც ჩანს, უთითებს არარსებულ განსაზღვრულ მნიშვნელობას (ცნებას). თუ შეიძლება, შეამოწმეთ ვებ-მისამართი.',
	'ow_AlternativeDefinition'              => 'ალტერნატიული განსაზღვრება',
	'ow_AlternativeDefinitions'             => 'ალტერნატიული განსაზღვრებები',
	'ow_Annotation'                         => 'შენიშვნა',
	'ow_ApproximateMeanings'                => 'მიახლოებითი მნიშვნელობები',
	'ow_ClassAttributeAttribute'            => 'ატრიბუტი',
	'ow_ClassAttributes'                    => 'კლასის ატრიბუტები',
	'ow_ClassAttributeLevel'                => 'დონე',
	'ow_ClassAttributeType'                 => 'ტიპი',
	'ow_ClassMembership'                    => 'გაერთიანებული კლასებში',
	'ow_Collection'                         => 'კოლექცია',
	'ow_CollectionMembership'               => 'გაერთიანებული კოლექციებში',
	'ow_Definition'                         => 'განსაზღვრება',
	'ow_DefinedMeaningAttributes'           => 'შენიშვნა',
	'ow_DefinedMeaning'                     => 'განსაზღვრული მნიშვნელობა',
	'ow_DefinedMeaningReference'            => 'განსაზღვრული მნიშვნელობა',
	'ow_ExactMeanings'                      => 'ზუსტი მნიშვნელობები',
	'ow_Expression'                         => 'გამოთქმა',
	'ow_ExpressionMeanings'                 => 'გამოთქმის მნიშვნელობა',
	'ow_Expressions'                        => 'გამოთქმები',
	'ow_IdenticalMeaning'                   => 'იდენტური მნიშვნელობა?',
	'ow_IncomingRelations'                  => 'შემომავალი ურთიერთობები',
	'ow_GotoSource'                         => 'იხილეთ წყარო',
	'ow_Language'                           => 'ენა',
	'ow_LevelAnnotation'                    => 'შენიშვნა',
	'ow_OptionAttribute'                    => 'თვისება',
	'ow_OptionAttributeOption'              => 'პარამეტრი',
	'ow_OptionAttributeOptions'             => 'პარამეტრები',
	'ow_OptionAttributeValues'              => 'პარამეტრების მნიშვნელობები',
	'ow_OtherDefinedMeaning'                => 'სხვა განსაზღვრული მნიშვნელობა',
	'ow_PopupAnnotation'                    => 'შენიშვნა',
	'ow_Relations'                          => 'ურთიერთობები',
	'ow_RelationType'                       => 'ურთიერთობის ტიპი',
	'ow_Spelling'                           => 'ორთოგრაფია',
	'ow_Synonyms'                           => 'სინონიმები',
	'ow_SynonymsAndTranslations'            => 'სინონიმები და თარგმანი',
	'ow_Source'                             => 'წყარო',
	'ow_SourceIdentifier'                   => 'წყაროს იდენტიფიკატორი',
	'ow_TextAttribute'                      => 'თვისება',
	'ow_Text'                               => 'ტექსტი',
	'ow_TextAttributeValues'                => 'უბრალო ტექსტები',
	'ow_TranslatedTextAttribute'            => 'თვისება',
	'ow_TranslatedText'                     => 'თარგმნილი ტექსტი',
	'ow_TranslatedTextAttributeValue'       => 'ტექსტი',
	'ow_TranslatedTextAttributeValues'      => 'თარგმნადი ტექსტები',
	'ow_LinkAttribute'                      => 'თვისება',
	'ow_LinkAttributeValues'                => 'ბმულები',
	'ow_Property'                           => 'თვისება',
	'ow_Value'                              => 'მნიშვნელობა',
	'ow_meaningsoftitle'                    => '"$1"-ის მნიშვნელობები',
	'ow_meaningsofsubtitle'                 => '<em>ვიკი ბმული:</em> [[$1]]',
	'ow_copy_no_action_specified'           => 'თუ შეიძლება, მიუთითეთ მოქმედება',
	'ow_copy_help'                          => 'ოდესმე იქნებ დაგეხმაროთ.',
	'ow_please_proved_dmid'                 => 'როგორც ჩანს, თქვენს მიერ შეტანილ მონაცემებს აკლია "?dmid=<ID>" (dmid=განსაზღვრული მნიშვნელობის იდენტიფიკატორი)<br />თუ შეიძლება დაუკავშირდით სერვერის ადმინისტრატორს.',
	'ow_please_proved_dc1'                  => 'როგორც ჩანს, თქვენს მიერ შეტანილ მონაცემებს აკლია "?dc1=<რაღაცა>" (dc1=მონაცემთა ნაკრების კონტექსტი 1, მონაცემთა ნაკრები, საიდანაც უნდა მოხდეს კოპირება)<br />თუ შეიძლება დაუკავშირდით სერვერის ადმინისტრატორს.',
	'ow_please_proved_dc2'                  => 'როგორც ჩანს, თქვენს მიერ შეტანილ მონაცემებს აკლია "?dc2=<რაღაცა>" (dc2=მონაცემთა ნაკრების კონტექსტი 2, მონაცემთა ნაკრები, სადაც უნდა მოხდეს კოპირება)<br />თუ შეიძლება დაუკავშირდით სერვერის ადმინისტრატორს.',
	'ow_no_action_specified'                => '<h3>მოქმედება არ იყო მითითებული</h3> იქნებ ამ გვერდზე პირდაპირ შემოხვედით? ნორმალური მუშაობის პირობებში აქ არ უნდა აღმოჩენილიყავით.',
);

/** Kazakh (China) (‫قازاقشا (جۇنگو)‬) */
$wdMessages['kk-cn'] = array(
	'langman_title' => 'تٴىلدەردٴى مەڭگەرۋ',
);

/** Kazakh (Kazakhstan) (‪Қазақша (Қазақстан)‬) */
$wdMessages['kk-kz'] = array(
	'langman_title' => 'Тілдерді меңгеру',
);

/** Kazakh (Turkey) (‪Qazaqşa (Türkïya)‬) */
$wdMessages['kk-tr'] = array(
	'langman_title' => 'Tilderdi meñgerw',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author គីមស៊្រុន
 * @author Lovekhmer
 */
$wdMessages['km'] = array(
	'datasearch'                            => 'Wikidata: ស្វែងរក​ទិន្នន័យ',
	'langman_title'                         => 'អ្នកគ្រប់គ្រង​ភាសា',
	'languages'                             => 'Wikidata: អ្នកគ្រប់គ្រង​ភាសា',
	'ow_save'                               => 'រក្សាទុក',
	'ow_history'                            => 'ប្រវត្តិ',
	'ow_noedit_title'                       => 'មិនអនុញ្ញាត​អោយ​កែប្រែទេ',
	'ow_uipref_datasets'                    => 'បង្ហាញ​តាមលំនាំដើម',
	'ow_uiprefs'                            => 'ទិន្នន័យ​វិគី',
	'ow_none_selected'                      => '<គ្មានអ្វីត្រូវបានជ្រើសយកទេ>',
	'ow_conceptmapping_no_action_specified' => 'អភ័យទោស, ខ្ញុំមិនដឹងពីរបៀប "$1" ទេ។',
	'ow_dm_OK'                              => 'យល់ព្រម',
	'ow_dm_not_present'                     => 'មិនបានបញ្ចូល',
	'ow_AlternativeDefinition'              => 'និយមន័យ​ឆ្លាស់',
	'ow_AlternativeDefinitions'             => 'និយមន័យ​ឆ្លាស់',
	'ow_Annotation'                         => 'ចំណារពន្យល់',
	'ow_ApproximateMeanings'                => 'អត្ថន័យ​ប្រហាក់ប្រហែល',
	'ow_ClassAttributeAttribute'            => 'សេចក្តីកំណត់',
	'ow_ClassAttributeLevel'                => 'កំរិត',
	'ow_ClassAttributeType'                 => 'ប្រភេទ',
	'ow_Collection'                         => 'ការប្រមូលផ្តុំ',
	'ow_Definition'                         => 'និយមន័យ',
	'ow_DefinedMeaningAttributes'           => 'ចំណារពន្យល់',
	'ow_IdenticalMeaning'                   => 'អត្ថន័យដូចគ្នា ?',
	'ow_Language'                           => 'ភាសា',
	'ow_LevelAnnotation'                    => 'ចំណារពន្យល់',
	'ow_OptionAttributeOption'              => 'ជំរើស',
	'ow_OptionAttributeOptions'             => 'ជំរើស​នានា',
	'ow_OptionAttributeValues'              => 'តំលៃ នានា នៃ ជំរើស',
	'ow_PopupAnnotation'                    => 'ចំណារពន្យល់',
	'ow_Relations'                          => 'ទំនាក់ទំនង',
	'ow_RelationType'                       => 'ប្រភេទ​ទំនាក់ទំនង',
	'ow_Spelling'                           => 'ការប្រកប',
	'ow_Synonyms'                           => 'វេវចនៈស័ព្ទ',
	'ow_Source'                             => 'ប្រភព',
	'ow_Text'                               => 'អត្ថបទ',
	'ow_TextAttributeValues'                => 'អត្ថបទធម្មតា',
	'ow_TranslatedText'                     => 'អត្ថបទ ត្រូវបានប្រែសំរួល',
	'ow_TranslatedTextAttributeValue'       => 'អត្ថបទ',
	'ow_TranslatedTextAttributeValues'      => 'អត្ថបទដែលអាចបកប្រែបាន',
	'ow_LinkAttributeValues'                => 'តំណភ្ជាប់ នានា',
	'ow_Value'                              => 'តំលៃ',
	'ow_meaningsoftitle'                    => 'និយមន័យ របស់ "$1"',
	'ow_meaningsofsubtitle'                 => '<em>តំណភ្ជាប់វិគី៖</em> [[$1]]',
	'ow_copy_no_action_specified'           => 'សូម សំដៅ មួយសកម្មភាព',
	'ow_copy_help'                          => 'យើង​អាចជួយអ្នក​នៅ​ថ្ងៃណាមួយ',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$wdMessages['krj'] = array(
	'ow_history' => 'Kasaysayan',
	'ow_dm_OK'   => 'OK dun',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$wdMessages['ksh'] = array(
	'ow_Language'            => 'Sproch',
	'ow_LinkAttributeValues' => 'Links',
);

/** Kurdish (Latin) (Kurdî / كوردی (Latin))
 * @author Bangin
 */
$wdMessages['ku-latn'] = array(
	'ow_history' => 'Dîrok',
	'ow_Source'  => 'Çavkanî',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$wdMessages['lb'] = array(
	'datasearch'                            => 'Wikidata: Date sichen',
	'langman_title'                         => 'Sproochmanager',
	'languages'                             => 'Wikidata: Sproochmanager',
	'ow_save'                               => 'Späicheren',
	'ow_history'                            => 'Versiounen',
	'ow_datasets'                           => 'Auswiel vun den Donnéeën',
	'ow_noedit_title'                       => "Keng Erlabniss fir z'änneren",
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<Näischt ausgewielt>',
	'ow_conceptmapping_no_action_specified' => 'Ëntschëllegt, ech wees net wéi een "$1".',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'net aginn',
	'ow_AlternativeDefinition'              => 'Alternativ Definitioun',
	'ow_AlternativeDefinitions'             => 'Alternativ Definitiounen',
	'ow_Annotation'                         => 'Notiz',
	'ow_ApproximateMeanings'                => 'Ongeféier Bedeitungen',
	'ow_ClassAttributeLevel'                => 'Niveau',
	'ow_ClassAttributeType'                 => 'Typ',
	'ow_Collection'                         => 'Sammlung',
	'ow_Definition'                         => 'Definitioun',
	'ow_DefinedMeaningAttributes'           => 'Notiz',
	'ow_ExactMeanings'                      => 'Genee Bedeitungen',
	'ow_Expression'                         => 'Ausdrock',
	'ow_Expressions'                        => 'Ausdréck',
	'ow_IdenticalMeaning'                   => 'Déi selwescht Bedeitung?',
	'ow_Language'                           => 'Sprooch',
	'ow_LevelAnnotation'                    => 'Notiz',
	'ow_OptionAttribute'                    => 'Eegeschaft',
	'ow_OptionAttributeOption'              => 'Optioun',
	'ow_OptionAttributeOptions'             => 'Optiounen',
	'ow_PopupAnnotation'                    => 'Notiz',
	'ow_Relations'                          => 'Relatiounen',
	'ow_Spelling'                           => 'Schreifweis',
	'ow_Synonyms'                           => 'Synonymen',
	'ow_SynonymsAndTranslations'            => 'Synonymer an Iwwersetzungen',
	'ow_Source'                             => 'Quell',
	'ow_TextAttribute'                      => 'Eegeschaft',
	'ow_Text'                               => 'Text',
	'ow_TranslatedTextAttribute'            => 'Eegeschaft',
	'ow_TranslatedText'                     => 'Iwwersatenen Text',
	'ow_TranslatedTextAttributeValue'       => 'Text',
	'ow_TranslatedTextAttributeValues'      => 'Iwwersetzbaren Text',
	'ow_LinkAttribute'                      => 'Eegeschaft',
	'ow_LinkAttributeValues'                => 'Linken',
	'ow_Property'                           => 'Eegeschaft',
	'ow_Value'                              => 'Wert',
	'ow_meaningsoftitle'                    => 'Bedeitung vun "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Wiki-Link:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>ERLAABNIS REFUSÉIERT</h2>',
	'ow_copy_no_action_specified'           => 'Gitt w.e.g. eng Aktioun un',
	'ow_copy_help'                          => 'Fréier oder spéider kënne mir iech hëllefen.',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$wdMessages['lfn'] = array(
	'ow_save'                         => 'Fisa',
	'ow_history'                      => 'Istoria',
	'ow_dm_OK'                        => 'Oce',
	'ow_Annotation'                   => 'Nota',
	'ow_ClassAttributeLevel'          => 'Nivel',
	'ow_ClassAttributeType'           => 'Tipo',
	'ow_Collection'                   => 'Colieda',
	'ow_Definition'                   => 'Defini',
	'ow_DefinedMeaningAttributes'     => 'Nota',
	'ow_Language'                     => 'Lingua',
	'ow_LevelAnnotation'              => 'Nota',
	'ow_OptionAttribute'              => 'Propria',
	'ow_PopupAnnotation'              => 'Nota',
	'ow_Relations'                    => 'Relatas',
	'ow_RelationType'                 => 'Tipo de relata',
	'ow_Spelling'                     => 'Spele',
	'ow_Synonyms'                     => 'Sinonimes',
	'ow_SynonymsAndTranslations'      => 'Sinonimes e traduis',
	'ow_TextAttribute'                => 'Propria',
	'ow_Text'                         => 'Testo',
	'ow_TranslatedTextAttribute'      => 'Propria',
	'ow_TranslatedTextAttributeValue' => 'Testo',
	'ow_LinkAttribute'                => 'Propria',
	'ow_LinkAttributeValues'          => 'Lias',
	'ow_Property'                     => 'Propria',
	'ow_Value'                        => 'Valua',
	'ow_meaningsoftitle'              => 'Sinifias de "$1"',
	'ow_meaningsofsubtitle'           => '<em>Lia vici:</em> [[$1]]',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$wdMessages['li'] = array(
	'ow_save' => 'Opslaon',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$wdMessages['lt'] = array(
	'datasearch' => 'Wikidata: Duomenų paieška',
);

/** Maithili (मैथिली)
 * @author Ggajendra
 */
$wdMessages['mai'] = array(
	'datasearch'    => 'विकी सूचनाकोष: सूचनाकोष ताकू',
	'langman_title' => 'भाषा प्रबंधक',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$wdMessages['ml'] = array(
	'langman_title'                         => 'ഭാഷാ പരിപാലകന്‍',
	'ow_save'                               => 'സേവ് ചെയ്യുക',
	'ow_history'                            => 'നാള്‍വഴി',
	'ow_noedit_title'                       => 'തിരുത്തുവാനുള്ള അനുമതി ഇല്ല',
	'ow_uipref_datasets'                    => 'സ്വതവെയുള്ള കാഴ്ച',
	'ow_uiprefs'                            => 'വിക്കിഡാറ്റ',
	'ow_none_selected'                      => '<ഒന്നും തിരഞ്ഞെടുത്തിട്ടില്ല>',
	'ow_conceptmapping_no_action_specified' => 'ക്ഷമിക്കുക, എനിക്ക് "$1" ചെയ്യുന്നതു എങ്ങനെയെന്നു അറിയില്ല.',
	'ow_dm_OK'                              => 'ശരി',
	'ow_AlternativeDefinition'              => 'വേറൊരു നിര്‍‌വചനം',
	'ow_AlternativeDefinitions'             => 'മറ്റ് നിര്‍‌വചനങ്ങള്‍',
	'ow_ClassAttributeType'                 => 'തരം',
	'ow_Collection'                         => 'ശേഖരം',
	'ow_Definition'                         => 'നിര്‍‌വചനം',
	'ow_DefinedMeaning'                     => 'നിര്‍‌വചിച്ച അര്‍‌ത്ഥം',
	'ow_DefinedMeaningReference'            => 'നിര്‍‌വചിച്ച അര്‍‌ത്ഥം',
	'ow_ExactMeanings'                      => 'ശരിക്കുള്ള അര്‍‌ത്ഥം',
	'ow_IdenticalMeaning'                   => 'സമാനമായ അര്‍ത്ഥങ്ങള്‍?',
	'ow_Language'                           => 'ഭാഷ',
	'ow_Source'                             => 'സ്രോതസ്സ്',
	'ow_Value'                              => 'മൂല്യം',
	'ow_meaningsoftitle'                    => '"$1"ന്റെ അര്‍ത്ഥങ്ങള്‍',
	'ow_Permission_denied'                  => '<h2>പ്രവേശനം നിഷേധിച്ചിരിക്കുന്നു</h2>',
);

/** Marathi (मराठी)
 * @author Mahitgar
 * @author Kaustubh
 */
$wdMessages['mr'] = array(
	'datasearch'                            => 'विकिविदा:विदा शोध',
	'langman_title'                         => 'भाषा प्रबंधक',
	'languages'                             => 'विकिविदा:भाषाप्रबंधक',
	'ow_save'                               => 'जतन करा',
	'ow_history'                            => 'इतिहास',
	'ow_datasets'                           => 'विदा-संच निवड',
	'ow_noedit_title'                       => 'संपादनाकरिता परवानगी नाही',
	'ow_noedit'                             => 'विदासंच "$1"मधील पाने संपादीत करण्याची तुम्हाला परवानगी नाही.कृपया [[{{MediaWiki:Ow editing policy url}}|आमची संपादन निती]]पहा.',
	'ow_uipref_datasets'                    => 'अविचल दृश्य',
	'ow_uiprefs'                            => 'विकिविदा',
	'ow_none_selected'                      => '<कोणतेही निवडले नाही>',
	'ow_conceptmapping_help'                => '<p>शक्य क्रिया: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  एक मॅपिंग टाका</li>
<li>&action=get&concept=<concept_id>  एक मॅपिंग वाचा</li>
<li>&action=list_sets  शक्य असलेले डाटा कन्टेक्स्ट उपपदांची यादी व ती काय दर्शवितात त्याच्यासकट द्या.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> एखाद्या विशिष्ट अर्थासाठी, इतर सर्व द्या</li>
<li>&action=help  माहितीपूर्ण मदत दाखवा.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>कन्सेप्ट मॅपिंग मुळे तुम्हाला एखाद्या डाटाबेस मध्ये असणारा अर्थ दुसर्‍या डाटाबेस मधल्या कुठल्या अर्थाशी तंतोतंत जुळतो हे कळते.</p>',
	'ow_conceptmapping_no_action_specified' => '"$1" कसे करावे मला ठावूक नाही,क्षमस्व',
	'ow_dm_OK'                              => 'ठीक',
	'ow_dm_not_present'                     => 'भरले नाही',
	'ow_dm_not_found'                       => 'विदेत सापडले नाही अथवा बरोबर नाही',
	'ow_mapping_successful'                 => '[OK] लिहिलेले सर्व रकाने जोडले<br />',
	'ow_mapping_unsuccessful'               => 'जोडण्यापूर्वी कमीतकमी दोन अर्थ असणे आवश्यक आहे.',
	'ow_will_insert'                        => 'खालील भर घातली जाईल',
	'ow_contents_of_mapping'                => 'मॅपिंगचे कंटेन्ट्स',
	'ow_available_contexts'                 => 'उपलब्ध संदर्भ',
	'ow_add_concept_link'                   => 'इतर कन्सेप्ट्सना दुवा द्या',
	'ow_concept_panel'                      => 'संकल्पना दल',
	'ow_dm_badtitle'                        => 'हे पान कुठल्याही DefinedMeaning (कन्सेप्ट) कडे निर्देश देत नाही.
कृपया संकेतस्थळाचा पत्ता तपासा.',
	'ow_dm_missing'                         => 'हे पान अस्तित्वात नसलेल्या DefinedMeaning (कन्सेप्ट) कडे निर्देश देते.
कृपया संकेतस्थळाचा पत्ता तपासा.',
	'ow_AlternativeDefinition'              => 'दुसरी व्याख्या',
	'ow_AlternativeDefinitions'             => 'दुसर्‍या व्याख्या',
	'ow_Annotation'                         => 'टीका-टिप्पणी',
	'ow_ApproximateMeanings'                => 'जवळजवळ अर्थ',
	'ow_ClassAttributeAttribute'            => 'एट्रिब्यूट',
	'ow_ClassAttributes'                    => 'क्लास एट्रिब्यूट',
	'ow_ClassAttributeLevel'                => 'पातळी',
	'ow_ClassAttributeType'                 => 'प्रकार',
	'ow_ClassMembership'                    => 'क्लास सदस्यत्व',
	'ow_Collection'                         => 'कलेक्शन',
	'ow_CollectionMembership'               => 'कलेक्शन सदस्यत्व',
	'ow_Definition'                         => 'व्याख्या',
	'ow_DefinedMeaningAttributes'           => 'टीका-टिप्पणी',
	'ow_DefinedMeaning'                     => 'दिलेला अर्थ',
	'ow_DefinedMeaningReference'            => 'दिलेला अर्थ',
	'ow_ExactMeanings'                      => 'नेमका अर्थ',
	'ow_Expression'                         => 'एक्स्प्रेशन',
	'ow_ExpressionMeanings'                 => 'एक्स्प्रेशन अर्थ',
	'ow_Expressions'                        => 'एक्स्प्रेशन्स',
	'ow_IdenticalMeaning'                   => 'सारखा अर्थ?',
	'ow_IncomingRelations'                  => 'येते संबध',
	'ow_GotoSource'                         => 'स्रोताकडे जा',
	'ow_Language'                           => 'भाषा',
	'ow_LevelAnnotation'                    => 'टीका-टिप्पणी',
	'ow_OptionAttribute'                    => 'वैशिष्ट्य',
	'ow_OptionAttributeOption'              => 'पर्याय',
	'ow_OptionAttributeOptions'             => 'पर्याय',
	'ow_OptionAttributeValues'              => 'पर्याय मुल्ये',
	'ow_OtherDefinedMeaning'                => 'इअतर व्यक्त अर्थ',
	'ow_PopupAnnotation'                    => 'टीका-टिप्पणी',
	'ow_Relations'                          => 'नाते',
	'ow_RelationType'                       => 'नाते प्रकार',
	'ow_Spelling'                           => 'स्पेलींग',
	'ow_Synonyms'                           => 'समानार्थी शब्द',
	'ow_SynonymsAndTranslations'            => 'समानार्थी शब्द आणि भाषांतरे',
	'ow_Source'                             => 'स्रोत',
	'ow_SourceIdentifier'                   => 'स्रोत जाणकार',
	'ow_TextAttribute'                      => 'मालमत्ता',
	'ow_Text'                               => 'मसुदा',
	'ow_TextAttributeValues'                => 'केवळ साधा मजकुर',
	'ow_TranslatedTextAttribute'            => 'वैशिष्ट्य',
	'ow_TranslatedText'                     => 'भाषांतरीत मजकुर',
	'ow_TranslatedTextAttributeValue'       => 'मजकुर',
	'ow_TranslatedTextAttributeValues'      => 'भाशांतरकरण्या योग्य मजकुर',
	'ow_LinkAttribute'                      => 'वैशिष्ट्य',
	'ow_LinkAttributeValues'                => 'दुवे',
	'ow_Property'                           => 'मालमत्ता',
	'ow_Value'                              => 'मुल्य',
	'ow_meaningsoftitle'                    => '"$1"चे अर्थ',
	'ow_meaningsofsubtitle'                 => '<em>विकिदुवा:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>परवानगी नाकारली</h2>',
	'ow_copy_no_action_specified'           => 'कृपया कृती निर्देशीत करा',
	'ow_copy_help'                          => 'एकदिवस आम्ही तुम्हाला मदत करु शकु',
	'ow_please_proved_dmid'                 => 'असं दिसतंय की तुमच्या इनपुट मध्ये एक "?dmid=<ID>" (dmid=दिलेल्या अर्थाचा क्र) दिलेला नाही<br />
कृपया सर्व्हर प्रबंधकाशी संपर्क करा.',
	'ow_please_proved_dc1'                  => 'असं दिसतंय की तुमच्या इनपुट मध्ये एक "?dc1=<something>" (dc1=डाटासेट कन्टेक्स्ट 1, डाटासेट कुठून प्रत करायचा ते ठिकाण) दिलेले नाही<br />
कृपया सर्व्हर प्रबंधकाशी संपर्क करा.',
	'ow_please_proved_dc2'                  => 'असं दिसतंय की तुमच्या इनपुट मध्ये एक "?dc2=<something>" (dc2=डाटासेट कन्टेक्स्ट 2, डाटासेट कुठे प्रत करायचा ते ठिकाण) दिलेले नाही<br />
कृपया सर्व्हर प्रबंधकाशी संपर्क करा.',
	'ow_copy_successful'                    => '<h2>नक्कल यशस्वी</h2>तुमची विदा यशस्वीपणे नकलली गेल्याचे दिसते.निश्चित करण्यासाठी पुन्हाएकदा पडताळून पहा!',
	'ow_copy_unsuccessful'                  => '<h3>नक्कल अयशस्वी</h3> नकलण्याचे कोणतेही काम झाले नाही.',
	'ow_no_action_specified'                => '<h3>कोणतीही कृती सांगीतली नाही</h3>काय तुम्ही या पानापाशी सरळच पोहचले आहात? सर्वसाधारणता तुम्ही येथे पोहचण्याची आवशकता नाही.',
	'ow_db_consistency_not_found'           => '<h2>त्रूटी</h2>विदेच्या सुरळीतपणाचा प्रश्न आहे ,विकिविदा या व्यक्त ID शी संबधीत सुयोग्य विदा शोधूशकत नाही.ती हरवली असण्याची शक्यता आहे.कृपया प्रचालक अथवा प्रबंधकांशी संपर्क करा.',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 */
$wdMessages['ms'] = array(
	'ow_dm_OK' => 'OK',
);

/** Mirandese (Mirandés)
 * @author Malafaya
 */
$wdMessages['mwl'] = array(
	'ow_Language' => 'Lhéngua',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$wdMessages['nah'] = array(
	'ow_save'     => 'Ticpiyāz',
	'ow_history'  => 'Tlahcuilōlloh',
	'ow_dm_OK'    => 'Cualli',
	'ow_Language' => 'Tlahtōlli',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$wdMessages['nds'] = array(
	'ow_save'                          => 'Spiekern',
	'ow_history'                       => 'Historie',
	'ow_uiprefs'                       => 'Wikidata',
	'ow_dm_OK'                         => 'OK',
	'ow_dm_not_present'                => 'nich ingeven',
	'ow_dm_not_found'                  => 'nich funnen in de Datenbank oder fehlerhaft',
	'ow_ClassAttributeType'            => 'Typ',
	'ow_DefinedMeaning'                => 'Defineert Bedüden',
	'ow_DefinedMeaningReference'       => 'Defineert Bedüden',
	'ow_ExactMeanings'                 => 'Exakt Bedüden',
	'ow_Expression'                    => 'Utdruck',
	'ow_ExpressionMeanings'            => 'Utdrucksbedüden',
	'ow_Expressions'                   => 'Utdrück',
	'ow_GotoSource'                    => 'Na’n Born gahn',
	'ow_Language'                      => 'Spraak',
	'ow_OptionAttribute'               => 'Egenschop',
	'ow_Synonyms'                      => 'Synonymen',
	'ow_Source'                        => 'Born',
	'ow_TextAttribute'                 => 'Egenschop',
	'ow_Text'                          => 'Text',
	'ow_TranslatedTextAttribute'       => 'Egenschop',
	'ow_TranslatedText'                => 'Översett Text',
	'ow_TranslatedTextAttributeValue'  => 'Text',
	'ow_TranslatedTextAttributeValues' => 'Översettbor Text',
	'ow_LinkAttribute'                 => 'Egenschop',
	'ow_Property'                      => 'Egenschop',
	'ow_meaningsoftitle'               => 'Bedüden vun „$1“',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author GerardM
 */
$wdMessages['nl'] = array(
	'datasearch'                            => 'Wikidata: Gegevens zoeken',
	'langman_title'                         => 'Taalmanager',
	'languages'                             => 'Wikidata: Taalmanager',
	'ow_save'                               => 'Opslaan',
	'ow_history'                            => 'Geschiedenis',
	'ow_datasets'                           => 'Gegevenssetselectie',
	'ow_noedit_title'                       => 'Geen toestemming om te bewerken',
	'ow_noedit'                             => 'U hebt geen rechten om pagina\'s te bewerken in de dataset "$1".
Zie [[{{MediaWiki:Ow editing policy url}}|ons bewerkingsbeleid]].',
	'ow_uipref_datasets'                    => 'Standaard overzicht',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<Geen selectie>',
	'ow_conceptmapping_help'                => '<p>mogelijke handelingen:<ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  een mapping toevoegen</li>
<li>&action=get&concept=<concept_id>  een mapping teruglezen</li>
<li>&action=list_sets  geeft een lijst met mogelijke gegevenscontextvoorvoegsels terug en waar ze naar verwijzen.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> voor een bepaalde betekenis in een concept, geeft alle overige weer</li>
<li>&action=help  Zinvolle hulptekst weergeven.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>ConceptMapping maakt het mogelijk om bepaalde betekenissen in meerdere gegevenssets als identiek te markeren.</p>',
	'ow_conceptmapping_no_action_specified' => 'Sorry, maar ik weet niet hoe ik kan "$1".',
	'ow_dm_OK'                              => 'Ok',
	'ow_dm_not_present'                     => 'niet ingevoegd',
	'ow_dm_not_found'                       => 'niet aangetroffen in de database of verminkt',
	'ow_mapping_successful'                 => 'Wat met [OK] gemarkeerd is, is gemapt.<br />',
	'ow_mapping_unsuccessful'               => 'Minstens twee bepaalde betekenissen zijn nodig voordat er gelinkt kan worden.',
	'ow_will_insert'                        => 'Zal het volgende toevoegen:',
	'ow_contents_of_mapping'                => 'Inhoud van de mapping',
	'ow_available_contexts'                 => 'Beschikbare contexten',
	'ow_add_concept_link'                   => 'Link toevoegen aan andere concepten',
	'ow_concept_panel'                      => 'Conceptpaneel',
	'ow_dm_badtitle'                        => 'Deze pagina wijst niet naar enige BepaaldeBetekenis (concept). Controleer aub het webadres.',
	'ow_dm_missing'                         => 'Deze pagina lijkt te wijzen naar een niet-bestaande DefinedMeaning (concept). Controleer alstublieft het webadres.',
	'ow_AlternativeDefinition'              => 'Alternatieve definitie',
	'ow_AlternativeDefinitions'             => 'Alternatieve definities',
	'ow_Annotation'                         => 'Annotatie',
	'ow_ApproximateMeanings'                => 'Niet exacte betekenissen',
	'ow_ClassAttributeAttribute'            => 'Attribuut',
	'ow_ClassAttributes'                    => 'Klasseattributen',
	'ow_ClassAttributeLevel'                => 'Niveau',
	'ow_ClassAttributeType'                 => 'Type',
	'ow_ClassMembership'                    => 'Klasselidmaatschap',
	'ow_Collection'                         => 'Verzameling',
	'ow_CollectionMembership'               => 'Verzamelingslidmaatschap',
	'ow_Definition'                         => 'Definitie',
	'ow_DefinedMeaningAttributes'           => 'Annotatie',
	'ow_DefinedMeaning'                     => 'Bepaalde betekenis',
	'ow_DefinedMeaningReference'            => 'Bepaalde betekenis',
	'ow_ExactMeanings'                      => 'Exacte betekenissen',
	'ow_Expression'                         => 'Uitdrukking',
	'ow_ExpressionMeanings'                 => 'Uitdrukkingsbetekenissen',
	'ow_Expressions'                        => 'Uitdrukkingen',
	'ow_IdenticalMeaning'                   => 'Identieke betekenis?',
	'ow_IncomingRelations'                  => 'Binnenkomende relaties',
	'ow_GotoSource'                         => 'Naar bron gaan',
	'ow_Language'                           => 'Taal',
	'ow_LevelAnnotation'                    => 'Annotatie',
	'ow_OptionAttribute'                    => 'Eigenschap',
	'ow_OptionAttributeOption'              => 'Optie',
	'ow_OptionAttributeOptions'             => 'Opties',
	'ow_OptionAttributeValues'              => 'Optiewaarden',
	'ow_OtherDefinedMeaning'                => 'Andere bepaalde betekenis',
	'ow_PopupAnnotation'                    => 'Annotatie',
	'ow_Relations'                          => 'Relaties',
	'ow_RelationType'                       => 'Relatietype',
	'ow_Spelling'                           => 'Spelling',
	'ow_Synonyms'                           => 'Synoniemen',
	'ow_SynonymsAndTranslations'            => 'Synoniemen en vertalingen',
	'ow_Source'                             => 'Bron',
	'ow_SourceIdentifier'                   => 'Bronidentificatie',
	'ow_TextAttribute'                      => 'Eigenschap',
	'ow_Text'                               => 'Tekst',
	'ow_TextAttributeValues'                => 'Platte tekst',
	'ow_TranslatedTextAttribute'            => 'Eigenschap',
	'ow_TranslatedText'                     => 'Vertaalde tekst',
	'ow_TranslatedTextAttributeValue'       => 'Tekst',
	'ow_TranslatedTextAttributeValues'      => 'Vertaalbare tekst',
	'ow_LinkAttribute'                      => 'Eigenschap',
	'ow_LinkAttributeValues'                => 'Verwijzingen',
	'ow_Property'                           => 'Eigenschap',
	'ow_Value'                              => 'Waarde',
	'ow_meaningsoftitle'                    => 'Betekenissen van "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Wikilink:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>TOESTEMMING GEWEIGERD</h2>',
	'ow_copy_no_action_specified'           => 'Geef alstublieft een handeling aan',
	'ow_copy_help'                          => 'Misschien helpen we je ooit.',
	'ow_please_proved_dmid'                 => 'Uw invoer mist een "?dmid=<ID>" (dmid=Defined Meaning-ID)<br />Neem alstublieft contact op met een systeembeheerder.',
	'ow_please_proved_dc1'                  => 'Uw invoer mist een "?dc1=<iets>" (dc1=datasetcontext 1, dataset WAARVAN te kopiëren)<br />Neem alstublieft contact op met een systeembeheerder.',
	'ow_please_proved_dc2'                  => 'Uw invoer mist een "?dc2==<iets>" (dc2=datasetcontext 2, dataset WAARNAAR te kopiëren)<br />Neem alstublieft contact op met een systeembeheerder.',
	'ow_copy_successful'                    => '<h2>Kopiëren succesvol</h2>Het lijkt erop dat het kopiëren van de gegevens goed gegaan is. Vergeet niet om dit te controleren!',
	'ow_copy_unsuccessful'                  => '<h3>Kopiëren mislukt</h3> Er is niets gekopieerd.',
	'ow_no_action_specified'                => '<h3>Er is geen handeling opgegeven</h3> Mogelijk bent u direct naar deze pagina gekomen. Normaliter hoort dat niet te gebeuren.',
	'ow_db_consistency_not_found'           => '<h2>Fout</h2>Er is een probleem met de consistentie van de database. Wikidata kan geen valide gegevens vinden die met dit Defined Meaning-ID zijn verbonden. Wellicht zijn die gegevens verloren gegaan. Neem alstublieft contact op met een systeembeheerder.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 */
$wdMessages['nn'] = array(
	'datasearch'                            => 'Wikidata: Datasøk',
	'langman_title'                         => 'Språkhandsamar',
	'languages'                             => 'Wikidata: Språkhandsamar',
	'ow_save'                               => 'Lagre',
	'ow_history'                            => 'Historikk',
	'ow_datasets'                           => 'Val for vising av data',
	'ow_noedit_title'                       => 'Du har ikkje tilgang til å endre',
	'ow_noedit'                             => 'Du har ikkje tilgang til å endre sider i datavalet «$1». Ver venleg og sjå [[{{MediaWiki:Ow editing policy url}}|retningslinene våre for endring]].',
	'ow_uipref_datasets'                    => 'Standardvising',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<Ingen er valde>',
	'ow_conceptmapping_help'                => '<p>moglege handlingar: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  set inn eit kart</li>
<li>&action=get&concept=<concept_id>  sjå att eit kart</li>
<li>&action=list_sets  viser ei liste over moglege datakontekst-prefiks og kva dei refererer til.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> viser alle andre for ei definert tyding i eit konsept</li>
<li>&action=help  Viser hjelp.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Kart over konsept lèt deg finne ut kva definert tyding i ei datavising som er lik definerte tydingar i andre datavisingar.</p>',
	'ow_conceptmapping_no_action_specified' => 'Beklagar, kan ikkje «$1».',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'ikkje oppgjeve',
	'ow_dm_not_found'                       => 'ikkje funne i databasen eller feillaga',
	'ow_mapping_successful'                 => 'La alle felta som var merka med [OK] til kart<br />',
	'ow_mapping_unsuccessful'               => 'Ein må oppgje minst to definerte tydingar dersom dei skal lenkast.',
	'ow_will_insert'                        => 'Legg til dette:',
	'ow_contents_of_mapping'                => 'Innhaldet i kartet',
	'ow_available_contexts'                 => 'Tilgjengelege kontekstar',
	'ow_add_concept_link'                   => 'Legg til lenkje til andre konsept',
	'ow_concept_panel'                      => 'Konseptpanel',
	'ow_dm_badtitle'                        => 'Denne sida viser ikkje til nokon «DefinedMeaning» (definerte tydingar, konsept). Ver venleg og sjekk nettadressa.',
	'ow_dm_missing'                         => 'Denne sida ser ut til å vise til ei «DefinedMeaning» (definerte tydingar, konsept) som ikkje finst. Ver venleg og sjekk nettadressa.',
	'ow_AlternativeDefinition'              => 'Alternativ definisjon',
	'ow_AlternativeDefinitions'             => 'Alternative definisjonar',
	'ow_Annotation'                         => 'Merknad',
	'ow_ApproximateMeanings'                => 'Omtrentlege tydingar',
	'ow_ClassAttributeAttribute'            => 'Attributt',
	'ow_ClassAttributes'                    => 'Klasseattributt',
	'ow_ClassAttributeLevel'                => 'Nivå',
	'ow_ClassAttributeType'                 => 'Type',
	'ow_ClassMembership'                    => 'Medlemsskap i klasse',
	'ow_Collection'                         => 'Samling',
	'ow_CollectionMembership'               => 'Medlemsskap i samling',
	'ow_Definition'                         => 'Definisjon',
	'ow_DefinedMeaningAttributes'           => 'Merknad',
	'ow_DefinedMeaning'                     => 'Definert tyding',
	'ow_DefinedMeaningReference'            => 'Definert tyding',
	'ow_ExactMeanings'                      => 'Nøyaktig tyding',
	'ow_Expression'                         => 'Uttrykk',
	'ow_ExpressionMeanings'                 => 'Tydingar av uttrykk',
	'ow_Expressions'                        => 'Uttrykk',
	'ow_IdenticalMeaning'                   => 'Same tyding?',
	'ow_IncomingRelations'                  => 'Innkomande slektskap',
	'ow_GotoSource'                         => 'Gå til kjelda',
	'ow_Language'                           => 'Språk',
	'ow_LevelAnnotation'                    => 'Merknad',
	'ow_OptionAttribute'                    => 'Eigedom',
	'ow_OptionAttributeOption'              => 'Innstilling',
	'ow_OptionAttributeOptions'             => 'Innstillingar',
	'ow_OptionAttributeValues'              => 'Innstillingsverdiar',
	'ow_OtherDefinedMeaning'                => 'Anna definert tyding',
	'ow_PopupAnnotation'                    => 'Merknad',
	'ow_Relations'                          => 'Slektskap',
	'ow_RelationType'                       => 'Slektskapstype',
	'ow_Spelling'                           => 'Staving',
	'ow_Synonyms'                           => 'Synonym',
	'ow_SynonymsAndTranslations'            => 'Synonym og omsetjingar',
	'ow_Source'                             => 'Kjelde',
	'ow_SourceIdentifier'                   => 'Kjeldeidentifiserar',
	'ow_TextAttribute'                      => 'Eigedom',
	'ow_Text'                               => 'Tekst',
	'ow_TextAttributeValues'                => 'Enkle tekstar',
	'ow_TranslatedTextAttribute'            => 'Eigedom',
	'ow_TranslatedText'                     => 'Omsett tekst',
	'ow_TranslatedTextAttributeValue'       => 'Tekst',
	'ow_TranslatedTextAttributeValues'      => 'Omsettbare tekstar',
	'ow_LinkAttribute'                      => 'Eigedom',
	'ow_LinkAttributeValues'                => 'Lenkjer',
	'ow_Property'                           => 'Eigedom',
	'ow_Value'                              => 'Verdi',
	'ow_meaningsoftitle'                    => 'Tydingar av «$1»',
	'ow_meaningsofsubtitle'                 => '<em>Wikilenkje:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>TILGANG FORBODE</h2>',
	'ow_copy_no_action_specified'           => 'Ver venleg og oppgje ei handling',
	'ow_copy_help'                          => 'Ein dag kan vi hjelpe deg.',
	'ow_please_proved_dmid'                 => 'Det ser ut som bidraget ditt manglar ein «?dmid=<ID>» (dmid=Defined Meaning ID, nummer på definert tyding)<br />Ver venleg og ta kontakt med ein administrator på tenaren.',
	'ow_please_proved_dc1'                  => 'Det ser ut som bidraget ditt manglar ein «?dc1=<noko>» (dc1=dataset context 1, dataval å kopiere FRÅ)<br />Ver venleg og ta kontakt med ein administrator på tenaren.',
	'ow_please_proved_dc2'                  => 'Det ser ut som bidraget ditt manglar ein «?dc2=<noko>» (dc2=dataset context 2, dataval å kopiere TIL)<br />Ver venleg og ta kontakt med ein administrator på tenaren.',
	'ow_copy_successful'                    => '<h2>Kopiering fullført</h2>Dei data du oppgav ser ut til å vere kopierte. Ikkje gløym å dobbelsjekke for å vere sikker!',
	'ow_copy_unsuccessful'                  => '<h3>Kopiering feila</h3> Inga kopiering har funne stad.',
	'ow_no_action_specified'                => '<h3>Inga handling vart oppgjeve</h3> Kanskje kom du direkte til denne sida? Normalt skal du ikkje kome hit.',
	'ow_db_consistency_not_found'           => '<h2>Feil</h2>Det er noko gale med oppbygginga av databasen, wikidata finn ikkje gyldige data som er knytte til dette nummeret på ei definert tyding. Ho kan vere tapt. Ver venleg og ta kontakt med ein administrator på tenaren.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author SPQRobin
 */
$wdMessages['no'] = array(
	'datasearch'                            => 'Wikidata: Datasøk',
	'langman_title'                         => 'Språkbehandler',
	'languages'                             => 'Wikidata: Språkbehandler',
	'ow_save'                               => 'Lagre',
	'ow_history'                            => 'Historikk',
	'ow_datasets'                           => 'Valg av datasett',
	'ow_noedit_title'                       => 'Ingen tilgang til å redigere',
	'ow_noedit'                             => 'Du har ikke tilgang til å redigere sider i datasettet «$1». Se [[{{MediaWiki:Ow editing policy url}}|våre retningslinjer for redigering]].',
	'ow_uipref_datasets'                    => 'Standardvisning',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<Ingen valgt>',
	'ow_conceptmapping_help'                => '<p>mulige handlinger: <ul>
<li>&action=insert&<datakontekstprefiks>=<definert_id>&... sett inn et kart</li>
<li>&action=get&concept=<konsept-id> se igjen et kart</li>
<li>&action=list_sets viser en liste over mulige datakontekstprefiks og hva de refererer til.</li>
<li>&action=get_associated&dm=<definert_betydnings-ID>&dc=<datavisningskontekstprefiks> viser alle andre for en definert betydning i et konspet</li>
<li>&action=help Viser hjelp.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Kart over konsept lar deg finne ut hvilken definert betydning i en datavisning som er lik definerte betydninger i andre datavisninger.</p>',
	'ow_conceptmapping_no_action_specified' => 'Beklager, jeg vet ikke hvordan man «$1».',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'ikke skrevet inn',
	'ow_dm_not_found'                       => 'ikke funnet i databasen, eller misformet',
	'ow_mapping_successful'                 => 'La alle feltene være merket med [OK] til kart<br />',
	'ow_mapping_unsuccessful'               => 'Må ha minst to definerte betydninger før jeg kan lenke dem til hverandre.',
	'ow_will_insert'                        => 'Vil sette inn følgende:',
	'ow_contents_of_mapping'                => 'Innholdet i kartet',
	'ow_available_contexts'                 => 'Tilgjengelige kontekster',
	'ow_add_concept_link'                   => 'Legg til lenke til andre konsepter',
	'ow_concept_panel'                      => 'Konseptpanel',
	'ow_dm_badtitle'                        => 'Denne siden viser ikke til noen definert betydning (konsept). Vennligst sjekk internettadressen.',
	'ow_dm_missing'                         => 'Denne siden viser til en ikke-eksisterende definert mening (konsept). Vennligst sjekk internettadressen.',
	'ow_AlternativeDefinition'              => 'Alternativ definisjon',
	'ow_AlternativeDefinitions'             => 'Alternative definisjoner',
	'ow_Annotation'                         => 'Merknad',
	'ow_ApproximateMeanings'                => 'Tilnærmede betydninger',
	'ow_ClassAttributeAttribute'            => 'Attributt',
	'ow_ClassAttributes'                    => 'Klasseattributter',
	'ow_ClassAttributeLevel'                => 'Nivå',
	'ow_ClassAttributeType'                 => 'Type',
	'ow_ClassMembership'                    => 'Klassemedlemskap',
	'ow_Collection'                         => 'Samling',
	'ow_CollectionMembership'               => 'Samlingsmedlemskap',
	'ow_Definition'                         => 'Definisjon',
	'ow_DefinedMeaningAttributes'           => 'Merknad',
	'ow_DefinedMeaning'                     => 'Definert betydning',
	'ow_DefinedMeaningReference'            => 'Definert betydning',
	'ow_ExactMeanings'                      => 'Eksakt betydning',
	'ow_Expression'                         => 'Uttrykk',
	'ow_ExpressionMeanings'                 => 'Utrykksbetydninger',
	'ow_Expressions'                        => 'Uttrykk',
	'ow_IdenticalMeaning'                   => 'Identisk betydning?',
	'ow_IncomingRelations'                  => 'Innkommende relasjoner',
	'ow_GotoSource'                         => 'Gå til kilde',
	'ow_Language'                           => 'Språk',
	'ow_LevelAnnotation'                    => 'Merknad',
	'ow_OptionAttribute'                    => 'Egenskap',
	'ow_OptionAttributeOption'              => 'Valg',
	'ow_OptionAttributeOptions'             => 'Alternativer',
	'ow_OptionAttributeValues'              => 'Valgverdier',
	'ow_OtherDefinedMeaning'                => 'Annen definert betydning',
	'ow_PopupAnnotation'                    => 'Merknad',
	'ow_Relations'                          => 'Relasjoner',
	'ow_RelationType'                       => 'Relasjonstype',
	'ow_Spelling'                           => 'Staving',
	'ow_Synonyms'                           => 'Synonymer',
	'ow_SynonymsAndTranslations'            => 'Synonymer og oversettelser',
	'ow_Source'                             => 'Kilde',
	'ow_SourceIdentifier'                   => 'Kildeidentifikator',
	'ow_TextAttribute'                      => 'Egenskap',
	'ow_Text'                               => 'Tekst',
	'ow_TextAttributeValues'                => 'Rene tekster',
	'ow_TranslatedTextAttribute'            => 'Egenskap',
	'ow_TranslatedText'                     => 'Oversatt tekst',
	'ow_TranslatedTextAttributeValue'       => 'Tekst',
	'ow_TranslatedTextAttributeValues'      => 'Oversettelige tekster',
	'ow_LinkAttribute'                      => 'Egenskap',
	'ow_LinkAttributeValues'                => 'Lenker',
	'ow_Property'                           => 'Egenskap',
	'ow_Value'                              => 'Verdi',
	'ow_meaningsoftitle'                    => 'Betydninger av «$1»',
	'ow_meaningsofsubtitle'                 => '<em>Wikilenke:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>TILGANG NEKTET</h2>',
	'ow_copy_no_action_specified'           => 'Vennligst angi en handling',
	'ow_copy_help'                          => 'En dag vil vi kunne hjelpe deg.',
	'ow_please_proved_dmid'                 => 'Det virker som om teksten din mangler en «?dmid=<ID>» (dmid=ID for definert betydning)<br />Vennligst kontakt en systemadministrator.',
	'ow_please_proved_dc1'                  => 'Det virker som om teksten din mangler en «?dc1=<noe>» (dc1=datasettkontekst 1, datasett det skal kopieres FRA)<br />Vennligst kontakt en systemadministrator.',
	'ow_please_proved_dc2'                  => 'Det virker som om teksten din mangler en «?dc2=<noe>» (dc2=datasettkontekst 2, datasett å kopiere TIL)<br />Vennligst kontakt en systemadministrator.',
	'ow_copy_successful'                    => '<h2>Kopiering fullført</h2>Dataene dine er kopiert. Ikke glem å dobbeltsjekke for å være sikker!',
	'ow_copy_unsuccessful'                  => '<h3>Kopiering ikke fullført</h3> Ingen kopiering har funnet sted.',
	'ow_no_action_specified'                => '<h3>Ingen handling ble angitt</h3> Kanskje du kom direkte til denne siden? Vanligvis trenger du ikke å være her.',
	'ow_db_consistency_not_found'           => '<h2>Feil</h2>Det er noe galt med oppbygningen av databasen, wikidata finner ikke gyldige data som er tilknyttet dette nummeret på en definert betydning. Dataene kan være tapt. Vennligst kontakt en administrtor på tjeneren.',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$wdMessages['nso'] = array(
	'ow_GotoSource'                   => 'Eya go mothopo',
	'ow_Language'                     => 'Polelo',
	'ow_Spelling'                     => 'Mopeleto',
	'ow_Synonyms'                     => 'Mahlalošêtšagotee',
	'ow_Source'                       => 'Mothopo',
	'ow_Text'                         => 'Dihlaka',
	'ow_TranslatedTextAttributeValue' => 'Dihlaka',
	'ow_LinkAttributeValues'          => 'Hlomaganyo',
	'ow_meaningsoftitle'              => 'Hlaloso tša "$1"',
	'ow_meaningsofsubtitle'           => '<em>Hlomaganyo ya Wiki:</em> [[$1]]',
	'ow_Permission_denied'            => '<h2>TUMELLO E LATOTŠWE</h2>',
	'ow_copy_no_action_specified'     => 'Ka kgopela kgetha seo o nyakago gose phetha',
	'ow_copy_help'                    => 'Ka tšatši le lengwe, re ka go thuša.',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author Siebrand
 */
$wdMessages['oc'] = array(
	'datasearch'                            => 'Wikidata: Recèrca de donadas',
	'langman_title'                         => 'Gestion de las lengas',
	'languages'                             => 'Wikidata: Gestion de las lengas',
	'ow_save'                               => 'Salvar',
	'ow_history'                            => 'Istoric',
	'ow_datasets'                           => 'Seleccion de las donadas definidas',
	'ow_noedit_title'                       => "Cap de permission d'editar.",
	'ow_noedit'                             => "Sètz pas autorizat a editar las paginas dins las donadas preestablidas « $1 ».
Vejatz [[{{MediaWiki:Ow editing policy url}}|nòstras règlas d'edicion]].",
	'ow_uipref_datasets'                    => 'Vista per defaut',
	'ow_uiprefs'                            => 'Donadas wiki',
	'ow_none_selected'                      => '<Cap de seleccion>',
	'ow_conceptmapping_help'                => "<p>accions possiblas : <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  inserir una mapa</li>
<li>&action=get&concept=<concept_id>  tornar veire una mapa</li>
<li>&action=list_sets  retorna una lista dels prefixes de contèxtes possibles e sus qué se referisson.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> per un definit dins lo sens d'un concèpte, retorna totes los autres.</li>
<li>&action=help  Vejatz l’ajuda completa.</li>
</ul></p>",
	'ow_conceptmapping_uitext'              => "<p>La mapa dels concèptes vos permet d'identificar
que lo sens definit dins una donada siá identic
als senses definits dins las autras donadas.</p>",
	'ow_conceptmapping_no_action_specified' => 'Desencusatz, comprèni pas « $1 ».',
	'ow_dm_OK'                              => 'Validar',
	'ow_dm_not_present'                     => 'pas inscrich',
	'ow_dm_not_found'                       => 'pas trobat dins la banca de donadas o mal redigit',
	'ow_mapping_successful'                 => 'Planifica totes los camps marcats amb [Validar]<br />',
	'ow_mapping_unsuccessful'               => 'Necessita almens dos senses definits abans que los pòsque religar.',
	'ow_will_insert'                        => 'Inserirà los seguents :',
	'ow_contents_of_mapping'                => 'Contengut de la planificacion',
	'ow_available_contexts'                 => 'Contèxtes disponibles',
	'ow_add_concept_link'                   => 'Apondís un ligam als autres concèptes',
	'ow_concept_panel'                      => 'Ventalh de concèptes',
	'ow_dm_badtitle'                        => "Aquesta pagina punta pas sus cap de concèpte o sens definit. Verificatz l'adreça internet.",
	'ow_dm_missing'                         => "Aquesta pagina sembla pas puntar vèrs un concèpte o sens inexistent. Verificatz l'adreça internet.",
	'ow_AlternativeDefinition'              => 'Definicion alternativa',
	'ow_AlternativeDefinitions'             => 'Definicions alternativas',
	'ow_Annotation'                         => 'Anotacion',
	'ow_ApproximateMeanings'                => 'Senses aproximatius',
	'ow_ClassAttributeAttribute'            => 'Atribut',
	'ow_ClassAttributes'                    => 'Atributs de classa',
	'ow_ClassAttributeLevel'                => 'Nivèl',
	'ow_ClassAttributeType'                 => 'Tipe',
	'ow_ClassMembership'                    => 'Classas',
	'ow_Collection'                         => 'Colleccion',
	'ow_CollectionMembership'               => 'Colleccions',
	'ow_Definition'                         => 'Definicion',
	'ow_DefinedMeaningAttributes'           => 'Anotacion',
	'ow_DefinedMeaning'                     => 'Sens definit',
	'ow_DefinedMeaningReference'            => 'Sens definit',
	'ow_ExactMeanings'                      => 'Senses exactes',
	'ow_Expression'                         => 'Expression',
	'ow_ExpressionMeanings'                 => 'Sens de las expressions',
	'ow_Expressions'                        => 'Expressions',
	'ow_IdenticalMeaning'                   => 'Sens identic ?',
	'ow_IncomingRelations'                  => 'Relacions entrantas',
	'ow_GotoSource'                         => 'Veire la font',
	'ow_Language'                           => 'Lenga',
	'ow_LevelAnnotation'                    => 'Anotacion',
	'ow_OptionAttribute'                    => 'Proprietat',
	'ow_OptionAttributeOption'              => 'Opcion',
	'ow_OptionAttributeOptions'             => 'Opcions',
	'ow_OptionAttributeValues'              => 'Valors de las opcions',
	'ow_OtherDefinedMeaning'                => 'Autre sens definit',
	'ow_PopupAnnotation'                    => 'Anotacion',
	'ow_Relations'                          => 'Relacions',
	'ow_RelationType'                       => 'Tipe de relacion',
	'ow_Spelling'                           => 'Ortografia',
	'ow_Synonyms'                           => 'Sinonims',
	'ow_SynonymsAndTranslations'            => 'Sinonims e traduccions',
	'ow_Source'                             => 'Font',
	'ow_SourceIdentifier'                   => 'Identificador de font',
	'ow_TextAttribute'                      => 'Proprietat',
	'ow_Text'                               => 'Tèxt',
	'ow_TextAttributeValues'                => 'Tèxt liure',
	'ow_TranslatedTextAttribute'            => 'Proprietat',
	'ow_TranslatedText'                     => 'Tèxt traduch',
	'ow_TranslatedTextAttributeValue'       => 'Tèxt',
	'ow_TranslatedTextAttributeValues'      => 'Tèxtes tradusibles',
	'ow_LinkAttribute'                      => 'Proprietat',
	'ow_LinkAttributeValues'                => 'Ligams',
	'ow_Property'                           => 'Proprietat',
	'ow_Value'                              => 'Valor',
	'ow_meaningsoftitle'                    => 'Sens de "$1"',
	'ow_meaningsofsubtitle'                 => '<em>ligam wiki :</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>PERMISSION REFUSADA</h2>',
	'ow_copy_no_action_specified'           => "Mercé d'especificar una accion",
	'ow_copy_help'                          => 'Ajuda de venir...',
	'ow_please_proved_dmid'                 => 'Sembla que manca un "?dmid=<...>" (dmid=SensDefinit ID)<br />Contactatz l’administrator del servidor.',
	'ow_please_proved_dc1'                  => 'Sèmbla que manca un "?dc1=<quicòm>" (dc1=contèxt de la banca 1, banca DEMPUÈI laquala òm copia)<br />
Contactatz l’administrator.',
	'ow_please_proved_dc2'                  => 'Sembla que manca un "?dc2=<quicòm>" (dc2=contèxt de la banca 2, banca VÈRS laquala òm copia)<br />
Contactatz l’administrator.',
	'ow_copy_successful'                    => '<h2>Capitada de la còpia</h2>Vòstras donadas son estadas copiadas amb succès (verificatz çaquelà).',
	'ow_copy_unsuccessful'                  => "<h3>Còpia infructuosa</h3> Cap d'operacion de còpia a pas pres plaça.",
	'ow_no_action_specified'                => "<h3>Cap d'accion es pas estada especificada</h3> Benlèu, seriatz vengut sus aquesta pagina dirèctament ? Avètz pas besonh, en principi, d'èsser aicí.",
	'ow_db_consistency_not_found'           => "<h2>Error</h2> Un problèma es estat trobat dins la banca de donadas. Wikidata pòt pas trobar de donadas validas ligadas al numèro de sens definit. Poiriá èsser perdut. Contactatz l'operator o l'administrator del servidor.",
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$wdMessages['os'] = array(
	'ow_dm_OK'               => 'Афтæ уæд!',
	'ow_Language'            => 'Æвзаг',
	'ow_LinkAttributeValues' => 'Æрвитæнтæ',
);

/** Polish (Polski)
 * @author Wpedzich
 * @author Sp5uhe
 * @author Derbeth
 * @author Masti
 */
$wdMessages['pl'] = array(
	'datasearch'                            => 'Wikidata: Wyszukiwanie danych',
	'langman_title'                         => 'Menadżer języków',
	'languages'                             => 'Wikidata: Menadżer języków',
	'ow_save'                               => 'Zapisz',
	'ow_history'                            => 'Historia',
	'ow_datasets'                           => 'Wybór zbioru danych',
	'ow_noedit_title'                       => 'Brak uprawnień do wykonania edycji',
	'ow_noedit'                             => 'Nie masz uprawnień do wykonania edycji w zbiorze danych „$1”. Zobacz [[{{MediaWiki:Ow editing policy url}}|zasady nadawania uprawnień do edycji]].',
	'ow_uipref_datasets'                    => 'Widok domyślny',
	'ow_uiprefs'                            => 'Dane wiki',
	'ow_none_selected'                      => '<Nic nie zaznaczono>',
	'ow_conceptmapping_help'                => '<p>możliwe działania: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  wstawia mapowanie</li>
<li>&action=get&concept=<concept_id>  odczytuje mapowanie</li>
<li>&action=list_sets  zwraca listę możliwych prefiksów kontekstu danych i ich odnośników</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> w odniesieniu do  jednego zdefiniowanego znaczenia w pojęciu zwraca pozostałe definicje</li>
<li>&action=help  pokazuje pomoc</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Odwzorowywanie pojęć pozwala na identyfikację tego, które ze zdefiniowanych w jednym zestawie danych znaczeń są identyczne do znaczeń zdefiniowanych w drugim zestawie danych.</p>',
	'ow_conceptmapping_no_action_specified' => 'Przykro mi, nie wiem, jak zrobić „$1”.',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'nie wprowadzono',
	'ow_dm_not_found'                       => 'obiektu nie odnaleziono w bazie lub jest nieprawidłowo uformowany',
	'ow_mapping_successful'                 => 'Odwzorowano wszystkie pola oznaczone jako [OK]<br />',
	'ow_mapping_unsuccessful'               => 'Zanim nastąpi połączenie dwóch zdefiniowanych znaczeń, muszą zostać one podane.',
	'ow_will_insert'                        => 'Wstawia nastepujące dane:',
	'ow_contents_of_mapping'                => 'Zawartość odwzorowania',
	'ow_available_contexts'                 => 'Dostępne konteksty',
	'ow_add_concept_link'                   => 'Dodaj linki do innych pojęć',
	'ow_concept_panel'                      => 'Panel pojęć',
	'ow_dm_badtitle'                        => 'Ta strona nie prowadzi do żadnego obiektu typu DefinedMeaning. Sprawdź poprawność adresu.',
	'ow_dm_missing'                         => 'Ta strona prowadzi do nieistniejącego obiektu DefinedMeaning. Sprawdź poprawność adresu.',
	'ow_AlternativeDefinition'              => 'Inna defnicja',
	'ow_AlternativeDefinitions'             => 'Alternatywne definicje',
	'ow_Annotation'                         => 'Adnotacja',
	'ow_ApproximateMeanings'                => 'Zbliżone znaczenia',
	'ow_ClassAttributeAttribute'            => 'Atrybut',
	'ow_ClassAttributes'                    => 'Atrybuty klas',
	'ow_ClassAttributeLevel'                => 'Poziom',
	'ow_ClassAttributeType'                 => 'Typ',
	'ow_ClassMembership'                    => 'Członkostwo w klasie',
	'ow_Collection'                         => 'Kolekcja',
	'ow_CollectionMembership'               => 'Członkostwo w kolekcji',
	'ow_Definition'                         => 'Definicja',
	'ow_DefinedMeaningAttributes'           => 'Adnotacja',
	'ow_DefinedMeaning'                     => 'Zdefiniowane znaczenie',
	'ow_DefinedMeaningReference'            => 'Zdefiniowane znaczenie',
	'ow_ExactMeanings'                      => 'Dokładne znaczenia',
	'ow_Expression'                         => 'Wyrażenie',
	'ow_ExpressionMeanings'                 => 'Znaczenia wyrażenia',
	'ow_Expressions'                        => 'Wyrażenia',
	'ow_IdenticalMeaning'                   => 'Takie samo znaczenie?',
	'ow_IncomingRelations'                  => 'Zależności wchodzące',
	'ow_GotoSource'                         => 'Idź do źródła',
	'ow_Language'                           => 'Język',
	'ow_LevelAnnotation'                    => 'Adnotacja',
	'ow_OptionAttribute'                    => 'Właściwość',
	'ow_OptionAttributeOption'              => 'Opcja',
	'ow_OptionAttributeOptions'             => 'Opcje',
	'ow_OptionAttributeValues'              => 'Wartość opcji',
	'ow_OtherDefinedMeaning'                => 'Inaczej zdefiniowane pojęcie',
	'ow_PopupAnnotation'                    => 'Adnotacja',
	'ow_Relations'                          => 'Zależności',
	'ow_RelationType'                       => 'Typ zależności',
	'ow_Spelling'                           => 'Ortografia',
	'ow_Synonyms'                           => 'Snonimy',
	'ow_SynonymsAndTranslations'            => 'Synonimy i tłumaczenia',
	'ow_Source'                             => 'Źródło',
	'ow_SourceIdentifier'                   => 'Identyfikator źródła',
	'ow_TextAttribute'                      => 'Właściwość',
	'ow_Text'                               => 'Tekst',
	'ow_TextAttributeValues'                => 'Tekst bez formatowania',
	'ow_TranslatedTextAttribute'            => 'Właściwość',
	'ow_TranslatedText'                     => 'Przetłumaczony tekst',
	'ow_TranslatedTextAttributeValue'       => 'Tekst',
	'ow_TranslatedTextAttributeValues'      => 'Teksty możliwe do przetłumaczenia',
	'ow_LinkAttribute'                      => 'Właściwość',
	'ow_LinkAttributeValues'                => 'Linki',
	'ow_Property'                           => 'Właściwość',
	'ow_Value'                              => 'Wartość',
	'ow_meaningsoftitle'                    => 'Znaczenia „$1”',
	'ow_meaningsofsubtitle'                 => '<em>Link wiki:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>DOSTĘP ZABRONIONY</h2>',
	'ow_copy_no_action_specified'           => 'Określ akcję',
	'ow_copy_help'                          => 'Kiedyś może Ci pomożemy.',
	'ow_please_proved_dmid'                 => 'We wprowadzonych danych nie odnaleziono wpisu „?dmid=<ID>” (dmid=Defined Meaning ID)<br />Skontaktuj się z administratorem serwera.',
	'ow_please_proved_dc1'                  => 'We wprowadzonych danych nie odnaleziono wpisu „?dc1=<jakieś_dane>” (dc1=dataset context 1, zestaw danych Z KTÓREGO ma nastąpić kopiowanie)<br />Skontaktuj się z administratorem serwera.',
	'ow_please_proved_dc2'                  => 'We wprowadzonych danych nie odnaleziono wpisu „?dc2=<jakieś_dane>” (dc2=dataset context 2, zestaw danych DO KTÓREGO ma nastąpić kopiowanie)<br />Skontaktuj się z administratorem serwera.',
	'ow_copy_successful'                    => '<h2>Kopiowanie powiodło się</h2>Dane najprawdopodobniej udało się bezpiecznie skopiować. Zalecane jest jednak sprawdzenie poprawności wykonania kopii.',
	'ow_copy_unsuccessful'                  => '<h3>Kopiowanie nie powiodło się</h3>Nie przeprowadzono operacji kopiowania.',
	'ow_no_action_specified'                => '<h3>Nie podano działania</h3>Może przeszedłeś do tej strony bezpośrednio? Zazwyczaj użytkownicy nie muszą tu zaglądać.',
	'ow_db_consistency_not_found'           => '<h2>Błąd</h2>Wystąpił błąd spójności bazy danych. Dane wiki nie są w stanie odnaleźć odpowiednich danych skojarzonych z określonym identyfikatorem. Dane mogły zostać utracone. Skontaktuj sie z operatorem serwera, lub jego administratorem.',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$wdMessages['pms'] = array(
	'datasearch'                      => 'Wikidata: Arsërca antra ij dat',
	'langman_title'                   => 'Gestor dle lenghe',
	'languages'                       => 'Wikidata: Gestor dle lenghe',
	'ow_save'                         => 'Salvé',
	'ow_datasets'                     => 'Base dat',
	'ow_AlternativeDefinition'        => 'Definission alternativa',
	'ow_AlternativeDefinitions'       => 'Definission alternative',
	'ow_Annotation'                   => 'Nòta',
	'ow_ApproximateMeanings'          => 'Sust a truch e branca',
	'ow_ClassMembership'              => 'Part ëd la class',
	'ow_Collection'                   => 'Colession',
	'ow_CollectionMembership'         => 'Part ëd la colession',
	'ow_Definition'                   => 'Sust',
	'ow_DefinedMeaningAttributes'     => 'Nòta',
	'ow_DefinedMeaning'               => 'Sust definì',
	'ow_DefinedMeaningReference'      => 'Sust definì',
	'ow_ExactMeanings'                => 'Àutri sust daspërlor',
	'ow_Expression'                   => 'Espression',
	'ow_Expressions'                  => 'Espression',
	'ow_IdenticalMeaning'             => 'Istess sust?',
	'ow_IncomingRelations'            => "Relassion ch'a rivo",
	'ow_Language'                     => 'Lenga',
	'ow_LevelAnnotation'              => 'Nòta',
	'ow_OtherDefinedMeaning'          => 'Àutri sust',
	'ow_PopupAnnotation'              => 'Nòta',
	'ow_Relations'                    => 'Relassion',
	'ow_RelationType'                 => 'Sòrt ëd relassion',
	'ow_Spelling'                     => 'Forma',
	'ow_Synonyms'                     => 'Sinònim',
	'ow_SynonymsAndTranslations'      => 'Sinònim e viragi',
	'ow_Source'                       => 'Sorgiss',
	'ow_SourceIdentifier'             => 'Identificativ dla sorgiss',
	'ow_Text'                         => 'Test',
	'ow_TranslatedTextAttributeValue' => 'Test',
	'ow_Property'                     => 'Proprietà',
	'ow_Value'                        => 'Valor',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$wdMessages['ps'] = array(
	'langman_title'                         => 'د ژبې سمبالګر',
	'languages'                             => 'Wikidata: د ژبې سمبالګر',
	'ow_save'                               => 'خوندي کول',
	'ow_history'                            => 'پېښليک',
	'ow_none_selected'                      => '<هېڅ هم نه دی ټاکل شوی>',
	'ow_conceptmapping_no_action_specified' => 'بښنه غواړم، زه نه پوهېږم چې څنګه "$1".',
	'ow_dm_not_present'                     => 'نه دی ورکړ شوی',
	'ow_ApproximateMeanings'                => 'نژدې ماناګانې',
	'ow_ClassAttributeLevel'                => 'کچه',
	'ow_ClassAttributeType'                 => 'ډول',
	'ow_Collection'                         => 'غونډ',
	'ow_Definition'                         => 'پېژند',
	'ow_GotoSource'                         => 'سرچينې ته ورځه',
	'ow_Language'                           => 'ژبه',
	'ow_OptionAttribute'                    => 'ځانتيا',
	'ow_Synonyms'                           => 'هممانيزونه',
	'ow_SynonymsAndTranslations'            => 'هممانيزونه او ژباړې',
	'ow_Source'                             => 'سرچينه',
	'ow_TextAttribute'                      => 'ځانتيا',
	'ow_Text'                               => 'متن',
	'ow_TranslatedTextAttribute'            => 'ځانتيا',
	'ow_TranslatedText'                     => 'ژباړل شوی متن',
	'ow_TranslatedTextAttributeValue'       => 'متن',
	'ow_TranslatedTextAttributeValues'      => 'د ژباړلو وړ متن',
	'ow_LinkAttribute'                      => 'ځانتيا',
	'ow_LinkAttributeValues'                => 'تړنې',
	'ow_Property'                           => 'ځانتيا',
	'ow_Value'                              => 'ارزښت',
	'ow_meaningsoftitle'                    => 'د "$1" ماناګانې',
	'ow_Permission_denied'                  => '<h2>د اجازې غوښتنه مو رد شوه</h2>',
	'ow_copy_no_action_specified'           => 'لطفاً يوه کړنه ځانګړې کړی',
	'ow_copy_help'                          => 'يوه ورځ به موږ ستاسو سره مرسته وکړو.',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$wdMessages['pt'] = array(
	'datasearch'                            => 'Wikidata: Pesquisa de dados',
	'langman_title'                         => 'Gestor de línguas',
	'languages'                             => 'Wikidata: Gestor de línguas',
	'ow_save'                               => 'Salvar',
	'ow_history'                            => 'História',
	'ow_datasets'                           => 'Selecção do conjunto de dados',
	'ow_noedit_title'                       => 'Não tem permissões para editar',
	'ow_noedit'                             => 'Não está autorizado a editar páginas no conjunto de dados "$1". Por favor, veja [[{{MediaWiki:Ow editing policy url}}|a nossa política de edição]].',
	'ow_uipref_datasets'                    => 'Vista padrão',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<Nenhum seleccionado>',
	'ow_conceptmapping_help'                => '<p>acções possíveis:
<ul>
 <li>&action=insert&<data_context_prefix>=<defined_id>&... inserir um mapeamento</li>
 <li>&action=get&concept=<concept_id> ler um mapeamento de volta</li>
 <li>&action=list_sets retornar uma lista de prefixos de contexto de dados possíveis e a que se referem.</li>
 <li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> para um significado definido num conceito, retornar todos os outros</li>
 <li>&action=help Mostrar ajuda preciosa.</li>
</ul>
</p>',
	'ow_conceptmapping_uitext'              => '<p>O Mapeamento de Conceitos permite-lhe identificar que significado definido num conjunto de dados é idêntico a outros significados definidos noutro conjunto de dados.</p>',
	'ow_conceptmapping_no_action_specified' => 'Desculpe, não sei como "$1".',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'não introduzido',
	'ow_dm_not_found'                       => 'não encontrado na base de dados ou mal formado',
	'ow_mapping_successful'                 => 'Mapeados todos os campos marcados com [OK]<br />',
	'ow_mapping_unsuccessful'               => 'É necessário ter dois significados definidos antes de poder ligá-los.',
	'ow_will_insert'                        => 'Será inserido o seguinte:',
	'ow_contents_of_mapping'                => 'Conteúdo de mapeamento',
	'ow_available_contexts'                 => 'Contextos disponíveis',
	'ow_add_concept_link'                   => 'Adicionar ligação para outros conceitos',
	'ow_concept_panel'                      => 'Painel de Conceitos',
	'ow_dm_badtitle'                        => 'Esta página não aponta para nenhum Significado Definido (conceito). Por favor, verifique o endereço web.',
	'ow_dm_missing'                         => 'Esta página parece apontar para um Significado Definido (conceito) inexistente. Por favor, verifique o endereço web.',
	'ow_AlternativeDefinition'              => 'Definição alternativa',
	'ow_AlternativeDefinitions'             => 'Definições alternativas',
	'ow_Annotation'                         => 'Anotação',
	'ow_ApproximateMeanings'                => 'Significados aproximados',
	'ow_ClassAttributeAttribute'            => 'Atributo',
	'ow_ClassAttributes'                    => 'Atributos de classe',
	'ow_ClassAttributeLevel'                => 'Nível',
	'ow_ClassAttributeType'                 => 'Tipo',
	'ow_ClassMembership'                    => 'Associação a classes',
	'ow_Collection'                         => 'Colecção',
	'ow_CollectionMembership'               => 'Associação a colecções',
	'ow_Definition'                         => 'Definição',
	'ow_DefinedMeaningAttributes'           => 'Anotação',
	'ow_DefinedMeaning'                     => 'Significado definido',
	'ow_DefinedMeaningReference'            => 'Significado definido',
	'ow_ExactMeanings'                      => 'Significados exactos',
	'ow_Expression'                         => 'Expressão',
	'ow_ExpressionMeanings'                 => 'Significados da expressão',
	'ow_Expressions'                        => 'Expressões',
	'ow_IdenticalMeaning'                   => 'Significado idêntico?',
	'ow_IncomingRelations'                  => 'Relações afluentes',
	'ow_GotoSource'                         => 'Ir para fonte',
	'ow_Language'                           => 'Língua',
	'ow_LevelAnnotation'                    => 'Anotação',
	'ow_OptionAttribute'                    => 'Propriedade',
	'ow_OptionAttributeOption'              => 'Opção',
	'ow_OptionAttributeOptions'             => 'Opções',
	'ow_OptionAttributeValues'              => 'Valores da opção',
	'ow_OtherDefinedMeaning'                => 'Outro significado definido',
	'ow_PopupAnnotation'                    => 'Anotação',
	'ow_Relations'                          => 'Relações',
	'ow_RelationType'                       => 'Tipo de relação',
	'ow_Spelling'                           => 'Ortografia',
	'ow_Synonyms'                           => 'Sinónimos',
	'ow_SynonymsAndTranslations'            => 'Sinónimos e traduções',
	'ow_Source'                             => 'Fonte',
	'ow_SourceIdentifier'                   => 'Identificador da fonte',
	'ow_TextAttribute'                      => 'Propriedade',
	'ow_Text'                               => 'Texto',
	'ow_TextAttributeValues'                => 'Textos simples',
	'ow_TranslatedTextAttribute'            => 'Propriedade',
	'ow_TranslatedText'                     => 'Texto traduzido',
	'ow_TranslatedTextAttributeValue'       => 'Texto',
	'ow_TranslatedTextAttributeValues'      => 'Textos traduzíveis',
	'ow_LinkAttribute'                      => 'Propriedade',
	'ow_LinkAttributeValues'                => 'Ligações',
	'ow_Property'                           => 'Propriedade',
	'ow_Value'                              => 'Valor',
	'ow_meaningsoftitle'                    => 'Significados de "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Ligação Wiki:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>PERMISSÃO NEGADA</h2>',
	'ow_copy_no_action_specified'           => 'Por favor, especifique uma acção',
	'ow_copy_help'                          => 'Um dia pode ser que possamos ajudá-lo.',
	'ow_please_proved_dmid'                 => 'Epá, parece que está a faltar um "?dmid=<qualquercoisa>" (dmid=ID do Significado Definido) aos dados introduzidos<br />
Por favor, contacte um administrador do servidor.',
	'ow_please_proved_dc1'                  => 'Epá, parece que está a faltar um "?dc1=<qualquercoisa>" (dc1=contexto de conjunto de dados 1, conjunto de dados DO qual copiar) aos dados introduzidos<br />
Por favor, contacte um administrador do servidor.',
	'ow_please_proved_dc2'                  => 'Epá, parece que está a faltar um "?dc2=<qualquercoisa>" (dc2=contexto de conjunto de dados 2, conjunto de dados PARA o qual copiar) aos dados introduzidos<br />
Por favor, contacte um administrador do servidor.',
	'ow_copy_successful'                    => '<h2>Cópia com Sucesso</h2>
Os seus dados aparentam ter sido copiados com sucesso. Não se esqueça de verificar para ter a certeza!',
	'ow_copy_unsuccessful'                  => '<h3>Cópia sem sucesso</h3> Não houve lugar a nenhuma operação de cópia.',
	'ow_no_action_specified'                => '<h3>Nenhuma acção foi especificada</h3> Talvez tenha vindo a esta página directamente? Em condições normais, não precisaria de estar aqui.',
	'ow_db_consistency_not_found'           => '<h2>Erro</h2>Há um problema com a consistência da base de dados, wikidata não consegue encontrar dados válidos relacionados com o ID deste significado definido, poderá ter-se perdido. Por favor, contacte o operador ou administrador do servidor.',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$wdMessages['rif'] = array(
	'ow_history'             => 'Amzruy',
	'ow_LinkAttributeValues' => 'Tiẓdyin',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$wdMessages['ro'] = array(
	'datasearch'                => 'Wikidata: Căutare de date',
	'ow_save'                   => 'Salvează',
	'ow_history'                => 'Istoric',
	'ow_dm_OK'                  => 'OK',
	'ow_ClassAttributeType'     => 'Tip',
	'ow_Language'               => 'Limbă',
	'ow_OptionAttributeOptions' => 'Opţiuni',
	'ow_Source'                 => 'Sursă',
	'ow_Value'                  => 'Valoare',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author Kaganer
 */
$wdMessages['ru'] = array(
	'datasearch'                            => 'Викиданные: Поиск данных',
	'langman_title'                         => 'Языковой менеджер',
	'languages'                             => 'Викиданные: Языковой менеджер',
	'ow_save'                               => 'Сохранить',
	'ow_history'                            => 'История',
	'ow_datasets'                           => 'Выбор набора данных',
	'ow_noedit_title'                       => 'Нет прав для редактирования',
	'ow_noedit'                             => 'Вам не разрешено редактировать страницы в наборе данных «$1». Обратите внимание на [[{{MediaWiki:Ow editing policy url}}|наши правила редактирования]].',
	'ow_uipref_datasets'                    => 'Вид по умолчанию',
	'ow_uiprefs'                            => 'Викиданные',
	'ow_none_selected'                      => '<Ничего не выбрано>',
	'ow_conceptmapping_help'                => '<p>возможные действия: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  вставить соответствие</li>
<li>&action=get&concept=<concept_id>  прочитать соответствие</li>
<li>&action=list_sets  вывести список возможных приставок контекстов данных и мест, куда они ссылаются.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> для одного определённого значения в концепте вывести все остальные</li>
<li>&action=help  вывести спрвочную информацию.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Установка соответствий концептов позволяет вам указать какое определённое значение в одном наборе данных тождественно определённым значениям в других наборах данных.</p>',
	'ow_conceptmapping_no_action_specified' => 'Извините, я не знаю что такое «$1».',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'не введено',
	'ow_dm_not_found'                       => 'не найдено в базе данных или неформат',
	'ow_mapping_successful'                 => 'Подключенны все поля, помеченные [OK]<br />',
	'ow_mapping_unsuccessful'               => 'Нужно иметь по крайней мере два определённых значения, прежде чем я смогу связать их.',
	'ow_will_insert'                        => 'Будет добавлено следующее:',
	'ow_contents_of_mapping'                => 'Содержание отображения',
	'ow_available_contexts'                 => 'Доступные контексты',
	'ow_add_concept_link'                   => 'Добавить ссылку на другие концепты',
	'ow_concept_panel'                      => 'Панель концептов',
	'ow_dm_badtitle'                        => 'Эта страница не указывает ни на одно ОпределённоеЗначение (концепт). Пожалуйста, проверьте веб-адрес.',
	'ow_dm_missing'                         => 'По видимому, эта страница указывает на несуществующее ОпределённоеЗначение (концепт). Пожалуйста, проверьте веб-адрес.',
	'ow_AlternativeDefinition'              => 'Альтернативное определение',
	'ow_AlternativeDefinitions'             => 'Альтернативные определения',
	'ow_Annotation'                         => 'Аннотация',
	'ow_ApproximateMeanings'                => 'Приблизительные значения',
	'ow_ClassAttributeAttribute'            => 'Свойство',
	'ow_ClassAttributes'                    => 'Свойства класса',
	'ow_ClassAttributeLevel'                => 'Уровень',
	'ow_ClassAttributeType'                 => 'Тип',
	'ow_ClassMembership'                    => 'Членство в классах',
	'ow_Collection'                         => 'Коллекция',
	'ow_CollectionMembership'               => 'Присутствует в коллекциях',
	'ow_Definition'                         => 'Определение',
	'ow_DefinedMeaningAttributes'           => 'Аннотация',
	'ow_DefinedMeaning'                     => 'Определённое значение',
	'ow_DefinedMeaningReference'            => 'Определённое значение',
	'ow_ExactMeanings'                      => 'Точные значения',
	'ow_Expression'                         => 'Выражение',
	'ow_ExpressionMeanings'                 => 'Значения выражений',
	'ow_Expressions'                        => 'Выражения',
	'ow_IdenticalMeaning'                   => 'тождественное значение?',
	'ow_IncomingRelations'                  => 'Входящие отношения',
	'ow_GotoSource'                         => 'Перейти к исходнику',
	'ow_Language'                           => 'Язык',
	'ow_LevelAnnotation'                    => 'Аннотация',
	'ow_OptionAttribute'                    => 'Свойство',
	'ow_OptionAttributeOption'              => 'Параметр',
	'ow_OptionAttributeOptions'             => 'Параметры',
	'ow_OptionAttributeValues'              => 'Значения параметров',
	'ow_OtherDefinedMeaning'                => 'Другое определённое значение',
	'ow_PopupAnnotation'                    => 'Аннотация',
	'ow_Relations'                          => 'Отношения',
	'ow_RelationType'                       => 'Тип отношения',
	'ow_Spelling'                           => 'Правописание',
	'ow_Synonyms'                           => 'Синонимы',
	'ow_SynonymsAndTranslations'            => 'Синонимы и переводы',
	'ow_Source'                             => 'Источник',
	'ow_SourceIdentifier'                   => 'Идентификатор источника',
	'ow_TextAttribute'                      => 'Свойство',
	'ow_Text'                               => 'Текст',
	'ow_TextAttributeValues'                => 'Простые тексты',
	'ow_TranslatedTextAttribute'            => 'Свойство',
	'ow_TranslatedText'                     => 'Переведённый текст',
	'ow_TranslatedTextAttributeValue'       => 'Текст',
	'ow_TranslatedTextAttributeValues'      => 'Переводимые тексты',
	'ow_LinkAttribute'                      => 'Свойство',
	'ow_LinkAttributeValues'                => 'Ссылки',
	'ow_Property'                           => 'Свойство',
	'ow_Value'                              => 'Значение',
	'ow_meaningsoftitle'                    => 'Значение «$1»',
	'ow_meaningsofsubtitle'                 => '<em>Вики-ссылка:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>ДОСТУП ЗАПРЕЩЁН</h2>',
	'ow_copy_no_action_specified'           => 'Пожалуйста, укажите действие',
	'ow_copy_help'                          => 'Когда-нибудь, мы вам поможем.',
	'ow_please_proved_dmid'                 => 'Похоже, что во входных данных отсутствует «?dmid=<ID>» (dmid — идентификатор определённого значения)<br /> Пожалуйста, свяжитесь с администратором сервера.',
	'ow_please_proved_dc1'                  => 'Похоже, что во входных данных отсутствует «?dc1=<something>» (dc1 — контекст набора данных; набор данных, откуда копировать)<br /> Пожалуйста, свяжитесь с администратором сервера.',
	'ow_please_proved_dc2'                  => 'Похоже, что во входных данных отсутствует «dc2=<something>» (dc2 — контекст набора данных; набор данных куда копировать)<br /> Пожалуйста, свяжитесь с администратором сервера.',
	'ow_copy_successful'                    => '<h2>Копирование успешно выполнено</h2>Похоже, что ваши данные были успешно скопированы. Но будет нелишним проверить это ещё раз.',
	'ow_copy_unsuccessful'                  => '<h3>Копирование неудачно</h3> Не было выполнено операции копирования.',
	'ow_no_action_specified'                => '<h3>Не было указано действие</h3> Возможно, вы зашли непосредственно на эту страницу? В ходе нормальной работы вы не должны были здесь очутиться.',
	'ow_db_consistency_not_found'           => '<h2>Ошибка</h2>В связи с нарушением целостности базы данных, Викиданные не могут найти верных данных, связанных с этим значением идентификатора. Возможно, они потеряны. Пожалуйста, свяжитесь с оператором сервера или администратором.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Siebrand
 */
$wdMessages['sk'] = array(
	'datasearch'                            => 'Wikidata: Hľadanie údajov',
	'langman_title'                         => 'Správca jazykov',
	'languages'                             => 'Wikidata: Správca jazykov',
	'ow_save'                               => 'Uložiť',
	'ow_history'                            => 'História',
	'ow_datasets'                           => 'Výber množiny dát',
	'ow_noedit_title'                       => 'Nemáte povolenie upravovať',
	'ow_noedit'                             => 'Nemáte oprávnenie upravovať stránky v množine dát „$1“.
Prosím, pozrite si [[{{MediaWiki:Ow editing policy url}}|našu politiku ohľadne upravovania]].',
	'ow_uipref_datasets'                    => 'Štandardné zobrazenie',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<žiadne vybrané>',
	'ow_conceptmapping_help'                => '<p>možné činnosti: <ul>
<li>&action=insert&<data_context_prefix>=<defined_id>&...  vložiť mapovanie</li>
<li>&action=get&concept=<concept_id>  prečítať mapovanie</li>
<li>&action=list_sets  vrátiť zoznam možných predpon dátových kontextov a na čo odkazujú.</li>
<li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> pre jeden Definovaný význam v rámci pojmu, vrátiť všetky ostatné</li>
<li>&action=help  Zobraziť pomocníka.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Mapovanie pojmov vám umožňuje určiť, ktorý Definovaný význam v jednej množine dát je zhodný s Definovanými významami v ostatných množinách dát.</p>',
	'ow_conceptmapping_no_action_specified' => 'Ospravedlňujem sa, neviem ako „$1“.',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'nezadané',
	'ow_dm_not_found'                       => 'nenájdené v databáze alebo v zlom tvare',
	'ow_mapping_successful'                 => 'Všetky polia označené [OK] boli namapované<br />',
	'ow_mapping_unsuccessful'               => 'Potrebujem aspoň dva Definované významy aby som ich mohol spojiť.',
	'ow_will_insert'                        => 'Vloží nasledovné:',
	'ow_contents_of_mapping'                => 'Obsah mapovania',
	'ow_available_contexts'                 => 'Dostupné kontexty',
	'ow_add_concept_link'                   => 'Pridať odkaz na ostatné pojmy',
	'ow_concept_panel'                      => 'Panel pojmu',
	'ow_dm_badtitle'                        => 'Táto stránka neukazuje na žiadny Definovaný význam (pojem). Prosím, skontrolujte URL.',
	'ow_dm_missing'                         => 'Zdá sa, že táto stránka ukazuje na neexistujúci Definovaný význam (pojem). Prosím, skontrolujte URL.',
	'ow_AlternativeDefinition'              => 'Alternatívna definícia',
	'ow_AlternativeDefinitions'             => 'Alternatívne definície',
	'ow_Annotation'                         => 'Poznámka',
	'ow_ApproximateMeanings'                => 'Približné významy',
	'ow_ClassAttributeAttribute'            => 'Atribút',
	'ow_ClassAttributes'                    => 'Atribúty triedy',
	'ow_ClassAttributeLevel'                => 'Úroveň',
	'ow_ClassAttributeType'                 => 'Typ',
	'ow_ClassMembership'                    => 'Členstvo v triede',
	'ow_Collection'                         => 'Kolekcia',
	'ow_CollectionMembership'               => 'Členstvo v kolekcii',
	'ow_Definition'                         => 'Definícia',
	'ow_DefinedMeaningAttributes'           => 'Poznámka',
	'ow_DefinedMeaning'                     => 'Definovaný význam',
	'ow_DefinedMeaningReference'            => 'Definovaný význam',
	'ow_ExactMeanings'                      => 'Presné významy',
	'ow_Expression'                         => 'Výraz',
	'ow_ExpressionMeanings'                 => 'Významy výrazu',
	'ow_Expressions'                        => 'Výrazy',
	'ow_IdenticalMeaning'                   => 'Zhodný význam?',
	'ow_IncomingRelations'                  => 'Vstupujúce vzťahy',
	'ow_GotoSource'                         => 'Prejsť na zdroj',
	'ow_Language'                           => 'Jazyk',
	'ow_LevelAnnotation'                    => 'Poznámka',
	'ow_OptionAttribute'                    => 'Vlastnosť',
	'ow_OptionAttributeOption'              => 'Možnosť',
	'ow_OptionAttributeOptions'             => 'Možnosti',
	'ow_OptionAttributeValues'              => 'Hodnoty možností',
	'ow_OtherDefinedMeaning'                => 'Iný definovaný význam',
	'ow_PopupAnnotation'                    => 'Poznámka',
	'ow_Relations'                          => 'Vzťahy',
	'ow_RelationType'                       => 'Typ vzťahu',
	'ow_Spelling'                           => 'Pravopis',
	'ow_Synonyms'                           => 'Synonymá',
	'ow_SynonymsAndTranslations'            => 'Synonymá a preklady',
	'ow_Source'                             => 'Zdroj',
	'ow_SourceIdentifier'                   => 'Identifikátor zdroja',
	'ow_TextAttribute'                      => 'Vlastnosť',
	'ow_Text'                               => 'Text',
	'ow_TextAttributeValues'                => 'Čistý text',
	'ow_TranslatedTextAttribute'            => 'Vlastnosť',
	'ow_TranslatedText'                     => 'Preložený text',
	'ow_TranslatedTextAttributeValue'       => 'Text',
	'ow_TranslatedTextAttributeValues'      => 'Preložiteľný text',
	'ow_LinkAttribute'                      => 'Vlastnosť',
	'ow_LinkAttributeValues'                => 'Odkazy',
	'ow_Property'                           => 'Vlastnosť',
	'ow_Value'                              => 'Hodnota',
	'ow_meaningsoftitle'                    => 'Významy „$1“',
	'ow_meaningsofsubtitle'                 => '<em>Wiki odkaz:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>NEMÁTE POTREBNÉ OPRÁVNENIE</h2>',
	'ow_copy_no_action_specified'           => 'Prosím, zadajte činnosť',
	'ow_copy_help'                          => 'Jedného dňa vám možno pomôžeme.',
	'ow_please_proved_dmid'                 => 'Zdá sa, že vo vašom vstupe chýba „?dmid=<ID>“ (dmid=ID Definovaného významu)<br />Prosím kontaktujte správcu servera.',
	'ow_please_proved_dc1'                  => 'Zdá sa, že ste zabudli zadať „?dc1=<niečo>“ (dcl=kontext množiny dát 1, z ktorej sa kopíruje)<br />Prosím, kontaktujte správcu servera.',
	'ow_please_proved_dc2'                  => 'Zdá sa že ste zabudli zadať „?dc2=<niečo>“ (dcl=kontext množiny dát 2, do ktorej sa kopíruje)<br />Prosím kontaktujte správcu servera.',
	'ow_copy_successful'                    => '<h2>Kopírovanie prebehlo úspešne</h2>Zdá sa, že vaše dáta boli skopírované úspešne. Nezabudnite to pre istotu ešte raz skontrolovať!',
	'ow_copy_unsuccessful'                  => '<h3>Kopírovanie neúspešné</h3> Operácia kopírovania sa neuskutočnila.',
	'ow_no_action_specified'                => '<h3>Nebola uvedená činnosť</h3> Možno ste sa snažili na túto stránku pristupovať priamo. Bežne sa sem nemáte dostať.',
	'ow_db_consistency_not_found'           => '<h2>Chyba</h2>Nastal problém s konzistenciou databázy. Wikidata nemôže nájsť platné údaje spojené s týmto ID Definovaného významu. Je možné, že sú stratené. Prosím kontaktujte správcu servera.',
);

/** Somali (Soomaaliga)
 * @author Yariiska
 */
$wdMessages['so'] = array(
	'ow_save'    => 'Kaydi',
	'ow_history' => 'Taariikh',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 */
$wdMessages['sr-ec'] = array(
	'ow_save'                               => 'Сачувај',
	'ow_history'                            => 'Историја',
	'ow_datasets'                           => 'Одабир скупа података',
	'ow_noedit_title'                       => 'Без дозволе за уређивање',
	'ow_noedit'                             => 'Није ти дозвољено да мењаш стране у скупу података "$1". Види [[{{MediaWiki:Ow editing policy url}}|нашу уређивачку политику]].',
	'ow_uipref_datasets'                    => 'Подразумевани поглед',
	'ow_uiprefs'                            => 'Викидата',
	'ow_none_selected'                      => '<Ништа није означено>',
	'ow_conceptmapping_help'                => '<p>могуће акције: <ul> <li>&action=insert&<data_context_prefix>=<defined_id>&... унеси мапирање</li> <li>&action=get&concept=<concept_id> поново прочитај мапирање</li> <li>&action=list_sets врати листу могућих контекстуалних префикса и оног на шта упућују.</li> <li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> за једно дефинисано значење у концепту врати сва остала</li> <li>&action=help Прикажи помоћ.</li> </ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Мапирање концепата ти омогућава да установиш које је дефинисано значење у једном скупу података истоветно с дефинисаним значењима у другим скуповима података.</p>',
	'ow_conceptmapping_no_action_specified' => 'Извињавам се, не знам како да урадим "$1".',
	'ow_dm_OK'                              => 'Уреду',
	'ow_dm_not_present'                     => 'није унесено',
	'ow_dm_not_found'                       => 'није пронађено у бази података или је лоше обликовано',
	'ow_mapping_successful'                 => 'Сва поља означена са [Уреду]<br />',
	'ow_mapping_unsuccessful'               => 'Потребна су бар два дефинисана значења пре него што их могу повезати.',
	'ow_will_insert'                        => 'Унеће се следеће:',
	'ow_contents_of_mapping'                => 'Садржај мапирања',
	'ow_available_contexts'                 => 'Могући контексти',
	'ow_add_concept_link'                   => 'Додај линк у друге концепте',
	'ow_concept_panel'                      => 'Табла концепата',
	'ow_dm_badtitle'                        => 'Ова страна не показује на ДефинисаноЗначење (концепт). Провери веб адресу.',
	'ow_dm_missing'                         => 'Ова страна показује на непостојеће ДефинисаноЗначење (концепт). Провери веб адресу.',
	'ow_AlternativeDefinition'              => 'Алтернативна дефиниција',
	'ow_AlternativeDefinitions'             => 'Алтернативне дефиниције',
	'ow_Annotation'                         => 'Коментар',
	'ow_ApproximateMeanings'                => 'Приближна значења',
	'ow_ClassAttributeAttribute'            => 'Особина',
	'ow_ClassAttributes'                    => 'Класа особина',
	'ow_ClassAttributeLevel'                => 'Ниво',
	'ow_ClassAttributeType'                 => 'Тип',
	'ow_ClassMembership'                    => 'Класа чланство',
	'ow_Collection'                         => 'Збирка',
	'ow_CollectionMembership'               => 'Збирка чланство',
	'ow_Definition'                         => 'Дефиниција',
	'ow_DefinedMeaningAttributes'           => 'Коментар',
	'ow_DefinedMeaning'                     => 'Дефинисано значење',
	'ow_DefinedMeaningReference'            => 'Дефинисано значење',
	'ow_ExactMeanings'                      => 'Тачна значења',
	'ow_Expression'                         => 'Израз',
	'ow_ExpressionMeanings'                 => 'Значења израза',
	'ow_Expressions'                        => 'Значења',
	'ow_IdenticalMeaning'                   => 'Истоветно значење',
	'ow_IncomingRelations'                  => 'Долазеће релације',
	'ow_GotoSource'                         => 'Иди на извор',
	'ow_Language'                           => 'Језик',
	'ow_LevelAnnotation'                    => 'Коментар',
	'ow_OptionAttribute'                    => 'Особина',
	'ow_OptionAttributeOption'              => 'Опција',
	'ow_OptionAttributeOptions'             => 'Опције',
	'ow_OptionAttributeValues'              => 'Вредности опције',
	'ow_OtherDefinedMeaning'                => '(Неко) друго дефинисано значење',
	'ow_PopupAnnotation'                    => 'Коментар',
	'ow_Relations'                          => 'Релације',
	'ow_RelationType'                       => 'Тип релације',
	'ow_Spelling'                           => 'Правопис',
	'ow_Synonyms'                           => 'Синоними',
	'ow_SynonymsAndTranslations'            => 'Синоними и преводи',
	'ow_Source'                             => 'Извор',
	'ow_SourceIdentifier'                   => 'Означавалац извора',
	'ow_TextAttribute'                      => 'Особина',
	'ow_Text'                               => 'Текст',
	'ow_TextAttributeValues'                => 'Равни текстови',
	'ow_TranslatedTextAttribute'            => 'Особина',
	'ow_TranslatedText'                     => 'Преведен текст',
	'ow_TranslatedTextAttributeValue'       => 'Текст',
	'ow_TranslatedTextAttributeValues'      => 'Текстови за превођење',
	'ow_LinkAttribute'                      => 'Особина',
	'ow_LinkAttributeValues'                => 'Линкови',
	'ow_Property'                           => 'Особина',
	'ow_Value'                              => 'Вредност',
	'ow_meaningsoftitle'                    => 'Значења "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Вики линк:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>ПРИСТУП НИЈЕ ДОЗВОЉЕН</h2>',
	'ow_copy_no_action_specified'           => 'Одреди акцију',
	'ow_copy_help'                          => 'Можда ћемо моћи да ти помогнемо једног дана.',
	'ow_please_proved_dmid'                 => 'Ух, изгледа да у твом уносу недостаје ?dmid=<something> (dmid=Defined Meaning ID)<br />Хмм... Контактирај администратора сервера.',
	'ow_please_proved_dc1'                  => 'Ух, изгледа да у твом уносу недостаје ?dc1=<something> (dc1=dataset context 1, dataset to copy FROM)<br />Хмм... Контактирај администратора сервера.',
	'ow_please_proved_dc2'                  => 'Ух, изгледа да у твом уносу недостаје ?dc2=<something> (dc2=dataset context 2, dataset to copy TO)<br />Хмм... Контактирај администратора сервера.',
	'ow_copy_successful'                    => '<h2>Умножавање успешно</h2>Чини се да су твоји подаци успешно умножени. Не заборави два пута да провериш!',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$wdMessages['stq'] = array(
	'datasearch'                            => 'Wikidata: Doatensäike',
	'langman_title'                         => 'Sproakmanager',
	'languages'                             => 'Wikidata: Sproakmanager',
	'ow_save'                               => 'Spiekerje',
	'ow_history'                            => 'Versione/Autore',
	'ow_datasets'                           => 'Uutwoal fon dän Doataset',
	'ow_noedit_title'                       => 'Neen Ferlof toun Edierjen',
	'ow_noedit'                             => 'Du hääst nit dät Ferlof Sieden in dän Dataset "$1" tou editierjen. Sjuch [[{{MediaWiki:Ow editing policy url}}|uus Gjuchtlienjen]].',
	'ow_uipref_datasets'                    => 'Standoardansicht',
	'ow_uiprefs'                            => 'Wikidoata',
	'ow_none_selected'                      => '<niks uutwääld>',
	'ow_conceptmapping_help'                => '<p>Muugelke Aktione: <ul> <li>&action=insert&<data_context_prefix>=<defined_id>&... Ne Ferknättenge bietoutouföigjen</li> <li>&action=get&concept=<concept_id> Ne Ferknättenge ouroupe</li> <li>&action=list_sets Wies ne Lieste fon muugelke Doatenkontextpräfixe un ap wät jo sik beluuke</li> <li>&action=get_associated&dm=<defined_meaning_id>&dc=<dataset_context_prefix> foar ne DefinedMeaning in n Kontext, wies aal uur</li> <li>&action=help Hälpe anwiese.</li> </ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Mäd Concept Mapping kon fäästlaid wäide, wäkke DefinedMeaning in n Doataset mäd uur DefinedMeanings uut uur Doatasets identisk is.</p>',
	'ow_conceptmapping_no_action_specified' => 'Äntscheeldenge, iek kon nit "$1".',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'nit ienroat',
	'ow_dm_not_found'                       => 'nit in ju Doatenboank fuunen of failerhaft',
	'ow_mapping_successful'                 => 'Aal do mäd [OK] markierde Fäildere wuuden tou-oardend<br />',
	'ow_mapping_unsuccessful'               => 'Deer sunt mindestens two DefinedMeanings toun Ferknätten nöödich.',
	'ow_will_insert'                        => 'Dät Foulgjende wäd iensät:',
	'ow_contents_of_mapping'                => 'Inhoolde fon ju Ferknättenge',
	'ow_available_contexts'                 => 'Ferföigboare Kontexte',
	'ow_add_concept_link'                   => 'Link tou uur Konzepte bietouföigje',
	'ow_concept_panel'                      => 'Konzeptschaltfläche',
	'ow_dm_badtitle'                        => 'Disse Siede wiest nit ätter ne DefinedMeaning (Konzept). Wröich ju Webadresse.',
	'ow_dm_missing'                         => 'Disse Siede wiest ätter ne nit existierjende DefinedMeaning (Konzept). Wröich ju Webadresse.',
	'ow_AlternativeDefinition'              => 'Alternative Definition',
	'ow_AlternativeDefinitions'             => 'Alternative Definitione',
	'ow_Annotation'                         => 'Annotation',
	'ow_ApproximateMeanings'                => 'Uungefääre Betjuudengen',
	'ow_ClassAttributeAttribute'            => 'Attribut',
	'ow_ClassAttributes'                    => 'Klassenattribute',
	'ow_ClassAttributeLevel'                => 'Level',
	'ow_ClassAttributeType'                 => 'Typ',
	'ow_ClassMembership'                    => 'Klassentouheeregaid',
	'ow_Collection'                         => 'Sammelenge',
	'ow_CollectionMembership'               => 'Sammelengstouheeregaid',
	'ow_Definition'                         => 'Definition',
	'ow_DefinedMeaningAttributes'           => 'Annotation',
	'ow_DefinedMeaning'                     => 'DefinedMeaning',
	'ow_DefinedMeaningReference'            => 'DefinedMeaning',
	'ow_ExactMeanings'                      => 'Exakte Betjuudengen',
	'ow_Expression'                         => 'Uutdruk',
	'ow_ExpressionMeanings'                 => 'Uutdruksbetjuudengen',
	'ow_Expressions'                        => 'Uutdrukke',
	'ow_IdenticalMeaning'                   => 'Identiske Betjuudenge?',
	'ow_IncomingRelations'                  => 'Iengungende Relatione',
	'ow_GotoSource'                         => 'Gung ätter ju Wälle',
	'ow_Language'                           => 'Sproake',
	'ow_LevelAnnotation'                    => 'Annotation',
	'ow_OptionAttribute'                    => 'Oainskup',
	'ow_OptionAttributeOption'              => 'Option',
	'ow_OptionAttributeOptions'             => 'Optione',
	'ow_OptionAttributeValues'              => 'Optionswäide',
	'ow_OtherDefinedMeaning'                => 'Uur DefinedMeaning',
	'ow_PopupAnnotation'                    => 'Annotation',
	'ow_Relations'                          => 'Relatione',
	'ow_RelationType'                       => 'Relationstyp',
	'ow_Spelling'                           => 'Schrieuwwiese',
	'ow_Synonyms'                           => 'Synonyme',
	'ow_SynonymsAndTranslations'            => 'Synonyme un Uursättengen',
	'ow_Source'                             => 'Wälle',
	'ow_SourceIdentifier'                   => 'Wällenbeteekener',
	'ow_TextAttribute'                      => 'Oainskup',
	'ow_Text'                               => 'Text',
	'ow_TextAttributeValues'                => 'Plaintext',
	'ow_TranslatedTextAttribute'            => 'Oainskup',
	'ow_TranslatedText'                     => 'Uursätten Text',
	'ow_TranslatedTextAttributeValue'       => 'Text',
	'ow_TranslatedTextAttributeValues'      => 'Uursätboaren Text',
	'ow_LinkAttribute'                      => 'Oainskup',
	'ow_LinkAttributeValues'                => 'Links',
	'ow_Property'                           => 'Oainskup',
	'ow_Value'                              => 'Wäid',
	'ow_meaningsoftitle'                    => 'Betjuudengen fon "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Wikilink:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>FERLOF FERWÄIGERD</h2>',
	'ow_copy_no_action_specified'           => 'Lääs ne Aktion fääst.',
	'ow_copy_help'                          => 'Ap n Dai konnen wie die hälpe.',
	'ow_please_proved_dmid'                 => 'Dät lät, dät an dien Iengoawe failt "?dmid=<ID>" (dmid=Defined Meaning ID)<br />
Kontaktier dän Serveradminstrator.',
	'ow_please_proved_dc1'                  => 'Dät lät, as wan an dien Iengoawe  failt "?dc1=<something>" (dc1=dataset context 1, dataset to copy FROM)<br />
Kontaktier dän Serveradminstrator.',
	'ow_please_proved_dc2'                  => 'Dät lät, as wan an dien Iengoawe failt "?dc2=<something>" (dc2=dataset context 2, dataset to copy TO) <br />
Kontaktier dän Serveradminstrator.',
	'ow_copy_successful'                    => '<h2>Kopierjen mäd Ärfoulch</h2>Dien Doaten schiene mäd Ärfoulch kopierd wuuden tou weesen. Ferjät nit noch moal tou wröigjen uum sichertougungen!',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$wdMessages['su'] = array(
	'ow_save'     => 'Simpen',
	'ow_history'  => 'Jujutan',
	'ow_Language' => 'Basa',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Sannab
 * @author Lokal Profil
 */
$wdMessages['sv'] = array(
	'datasearch'                            => 'Wikidata: Datasökning',
	'langman_title'                         => 'Språkhanterare',
	'languages'                             => 'Wikidata: Språkhanterare',
	'ow_save'                               => 'Spara',
	'ow_history'                            => 'Historia',
	'ow_datasets'                           => 'Val av data-set',
	'ow_noedit_title'                       => 'Ingen tillåtelse till redigering',
	'ow_noedit'                             => 'Du är inte tillåten till att redigera sidor i datasetet "$1". Var god se [[{{MediaWiki:Ow editing policy url}}|våra redigerings riktlinjer]].',
	'ow_uipref_datasets'                    => 'Standardvisning',
	'ow_uiprefs'                            => 'Wikidata',
	'ow_none_selected'                      => '<Ingen vald>',
	'ow_conceptmapping_help'                => '<p>möjliga handlingar: <ul>
<li>&action=insert&<datakontextprefix>=<definerad_id>&... sätta in en karta</li>
<li>&action=get&concept=<koncept-id> läsa en karta igen</li>
<li>&action=list_sets visar en lista över möjliga datakontextprefix och vad dom refererar till.</li>
<li>&action=get_associated&dm=<definerat_betydnings-ID>&dc=<datavisningskontextprefix> visar alla andra för en definerad betydning i ett koncept</li>
<li>&action=help Visar hjälp.</li>
</ul></p>',
	'ow_conceptmapping_uitext'              => '<p>Karta över koncept låter dig hitta vilken definierad betydelse i en datavisning som är lik definierade betydelser i andra datavisningar.</p>',
	'ow_conceptmapping_no_action_specified' => 'Beklagar, jag vet inte hur man "$1".',
	'ow_dm_OK'                              => 'OK',
	'ow_dm_not_present'                     => 'inte angivet',
	'ow_dm_not_found'                       => 'inte hittat i databasen eller missformat',
	'ow_mapping_successful'                 => 'Alla fälten märkta med [OK] till kartan<br />',
	'ow_mapping_unsuccessful'               => 'Måste ha minst två definierade betydelser före jag kan länka till dom.',
	'ow_will_insert'                        => 'Kommer sätta in följande:',
	'ow_contents_of_mapping'                => 'Innehållet i kartan',
	'ow_available_contexts'                 => 'Tillgängliga sammanhang',
	'ow_add_concept_link'                   => 'Lägg till länk till andra koncept',
	'ow_concept_panel'                      => 'Konceptpanel',
	'ow_dm_badtitle'                        => 'Den här sidan visar inte till några definierade betydelser (koncept).
Var god kolla webbadressen.',
	'ow_dm_missing'                         => 'Den här sidan visar en ej existerande definierad mmening (koncept).
Var god kolla webbadressen.',
	'ow_AlternativeDefinition'              => 'Alternativ definition',
	'ow_AlternativeDefinitions'             => 'Alternativa definitioner',
	'ow_Annotation'                         => 'Notering',
	'ow_ApproximateMeanings'                => 'Ungefärliga betydelser',
	'ow_ClassAttributeAttribute'            => 'Attribut',
	'ow_ClassAttributes'                    => 'Klassattributer',
	'ow_ClassAttributeLevel'                => 'Nivå',
	'ow_ClassAttributeType'                 => 'Typ',
	'ow_ClassMembership'                    => 'Klassmedlemskap',
	'ow_Collection'                         => 'Samling',
	'ow_CollectionMembership'               => 'Samlingsmedlemskap',
	'ow_Definition'                         => 'Definition',
	'ow_DefinedMeaningAttributes'           => 'Notering',
	'ow_DefinedMeaning'                     => 'Definierad betydelse',
	'ow_DefinedMeaningReference'            => 'Definierad betydelse',
	'ow_ExactMeanings'                      => 'Exakt betydelse',
	'ow_Expression'                         => 'Uttryck',
	'ow_ExpressionMeanings'                 => 'Uttrycksbetydelser',
	'ow_Expressions'                        => 'Uttryck',
	'ow_IdenticalMeaning'                   => 'Identisk betydelse?',
	'ow_IncomingRelations'                  => 'Inkommande släktskap',
	'ow_GotoSource'                         => 'Gå till källa',
	'ow_Language'                           => 'Språk',
	'ow_LevelAnnotation'                    => 'Notering',
	'ow_OptionAttribute'                    => 'Attribut',
	'ow_OptionAttributeOption'              => 'Alternativ',
	'ow_OptionAttributeOptions'             => 'Alternativ',
	'ow_OptionAttributeValues'              => 'Alternativvärden',
	'ow_OtherDefinedMeaning'                => 'Annan definierad betydelse',
	'ow_PopupAnnotation'                    => 'Notering',
	'ow_Relations'                          => 'Släktskap',
	'ow_RelationType'                       => 'Släktskapstyp',
	'ow_Spelling'                           => 'Stavning',
	'ow_Synonyms'                           => 'Synonymer',
	'ow_SynonymsAndTranslations'            => 'Synonymer och översättningar',
	'ow_Source'                             => 'Källa',
	'ow_SourceIdentifier'                   => 'Källidentifierare',
	'ow_TextAttribute'                      => 'Attribut',
	'ow_Text'                               => 'Text',
	'ow_TextAttributeValues'                => 'Klara texter',
	'ow_TranslatedTextAttribute'            => 'Attribut',
	'ow_TranslatedText'                     => 'Översatt text',
	'ow_TranslatedTextAttributeValue'       => 'Text',
	'ow_TranslatedTextAttributeValues'      => 'Översättbara texter',
	'ow_LinkAttribute'                      => 'Attribut',
	'ow_LinkAttributeValues'                => 'Länkar',
	'ow_Property'                           => 'Attribut',
	'ow_Value'                              => 'Värde',
	'ow_meaningsoftitle'                    => 'Betydelser av "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Wiki länk:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>TILLTRÄDE NEKAS</h2>',
	'ow_copy_no_action_specified'           => 'Var god ange en handling',
	'ow_copy_help'                          => 'Vi kanske kommer att hjälpa dig någon dag.',
	'ow_please_proved_dmid'                 => 'Det verkar som att din text har missat en "?dmid=<ID>" (dmid=ID för definierad betydelse)<br />
Var god kontakta en administratör på servern.',
	'ow_please_proved_dc1'                  => 'Det verkar som att din text har missat en "?dc1=<något>" (dc1=datasättkontext 1, datasättet ska kopieras FRÅN)<br />
Var god kontakta en administratör på servern.',
	'ow_please_proved_dc2'                  => 'Det verkar som att din text har missat en "?dc2=<något>" (dc2=datasättkontext 2, datasätt att kopiera TILL)<br />
Var god kontakta en systemadministratör.',
	'ow_copy_successful'                    => '<h2>Kopiering slutförd</h2>
Dina datan är kopierade.
Glöm inte att dubbelkolla för att vara säker!',
	'ow_copy_unsuccessful'                  => '<h3>Kopiering inte slutförd</h3>
Ingen kopiering har tagit plats.',
	'ow_no_action_specified'                => '<h3>Ingen hanndling angedd</h3>
Kanske kom du direkt till den här sidan? Vanligtvis ska du inte vara här.',
	'ow_db_consistency_not_found'           => '<h2>Fel</h2>
Det är något fel med uppbyggningen av databasen, wikidata hittar inte giltig data som är knytet till detta nummer på en definierad betydelse.
Datan kan vara förlorad.
Var god kontakta systemadministratören.',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$wdMessages['szl'] = array(
	'ow_history' => 'Historjo',
	'ow_dm_OK'   => 'OK',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$wdMessages['ta'] = array(
	'ow_save' => 'சேமி',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author Mpradeep
 */
$wdMessages['te'] = array(
	'datasearch'                            => 'వికీడాటా: డాటా అన్వేషణ',
	'langman_title'                         => 'భాషా నిర్వహణ',
	'languages'                             => 'వికీడాటా: భాషా నిర్వహణ',
	'ow_save'                               => 'భద్రపరచు',
	'ow_history'                            => 'చరిత్ర',
	'ow_datasets'                           => 'డాటాసెట్ ఎంపిక',
	'ow_noedit_title'                       => 'మార్చడానికి అనుమతి లేదు',
	'ow_uiprefs'                            => 'వికీడాటా',
	'ow_none_selected'                      => '<ఏమీ ఎంచుకోలేదు>',
	'ow_conceptmapping_no_action_specified' => 'క్షమాపణలు, "$1"ని ఎలా చేయాలో నాకు తెలియదు.',
	'ow_dm_OK'                              => 'సరే',
	'ow_available_contexts'                 => 'అందుబాటులో ఉన్న సందర్భాలు',
	'ow_add_concept_link'                   => 'ఇతర భావనలకు లింకు చేర్చండి',
	'ow_AlternativeDefinition'              => 'ప్రత్యామ్నాయ నిర్వచనం',
	'ow_AlternativeDefinitions'             => 'ప్రత్యామ్నాయ నిర్వచనాలు',
	'ow_ApproximateMeanings'                => 'సమానార్థాలు',
	'ow_ClassAttributeLevel'                => 'స్థాయి',
	'ow_ClassAttributeType'                 => 'రకం',
	'ow_Collection'                         => 'సేకరణ',
	'ow_CollectionMembership'               => 'సేకరణ సభ్యత్వం',
	'ow_Definition'                         => 'నిర్వచనం',
	'ow_DefinedMeaning'                     => 'నిర్వచిత అర్థం',
	'ow_DefinedMeaningReference'            => 'నిర్వచిత అర్థం',
	'ow_ExactMeanings'                      => 'ఖచ్చిత అర్థాలు',
	'ow_Expression'                         => 'వ్యక్తీకరణ',
	'ow_ExpressionMeanings'                 => 'వ్యక్తీకరణ అర్ధాలు',
	'ow_Expressions'                        => 'వ్యక్తీకరణలు',
	'ow_GotoSource'                         => 'మూలానికి వెళ్ళు',
	'ow_Language'                           => 'భాష',
	'ow_OptionAttribute'                    => 'లక్షణం',
	'ow_OptionAttributeOption'              => 'ఎంపిక',
	'ow_OptionAttributeOptions'             => 'ఎంపికలు',
	'ow_OptionAttributeValues'              => 'ఎంపిక విలువలు',
	'ow_OtherDefinedMeaning'                => 'ఇతర నిర్వచిత అర్థం',
	'ow_Relations'                          => 'సంబంధాలు',
	'ow_RelationType'                       => 'సంబంధ రకం',
	'ow_Spelling'                           => 'వర్ణక్రమం',
	'ow_Synonyms'                           => 'సమానార్థాలు',
	'ow_SynonymsAndTranslations'            => 'సమానార్థాలు మరియు అనువాదాలు',
	'ow_Source'                             => 'మూలం',
	'ow_TextAttribute'                      => 'లక్షణం',
	'ow_Text'                               => 'పాఠ్యం',
	'ow_TextAttributeValues'                => 'సాదా పాఠ్యాలు',
	'ow_TranslatedTextAttribute'            => 'లక్షణం',
	'ow_TranslatedText'                     => 'అనువాదిత పాఠ్యం',
	'ow_TranslatedTextAttributeValue'       => 'పాఠ్యం',
	'ow_TranslatedTextAttributeValues'      => 'అనువదించదగ్గ పాఠ్యాలు',
	'ow_LinkAttribute'                      => 'లక్షణం',
	'ow_LinkAttributeValues'                => 'లింకులు',
	'ow_Property'                           => 'లక్షణం',
	'ow_Value'                              => 'విలువ',
	'ow_meaningsoftitle'                    => '"$1" యొక్క అర్థాలు',
	'ow_meaningsofsubtitle'                 => '<em>వికీ లింకు:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>అనుమతి నిరాకరించాం</h2>',
	'ow_copy_no_action_specified'           => 'దయచేసి ఒక చర్యని స్పష్టంచెయ్యండి',
	'ow_copy_help'                          => 'ఏదో ఒక రోజు, మీకు సహాయపడగలం.',
	'ow_copy_successful'                    => '<h2>కాపీ విజయవంతం</h2>మీ భోగట్టా విజయవంతంగా కాపీ అయింది. కానీ మరోసారి సరిచూచుకోవడం మర్చిపోకండి!',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$wdMessages['tet'] = array(
	'ow_dm_OK' => 'OK',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$wdMessages['tg-cyrl'] = array(
	'datasearch'                            => 'Викидода: Ҷустуҷӯи дода',
	'langman_title'                         => 'Идоракуни забон',
	'languages'                             => 'Викидода: Идоракуни забон',
	'ow_save'                               => 'Захира кардан',
	'ow_history'                            => 'Таърих',
	'ow_noedit_title'                       => 'Барои вироиш иҷозат нест',
	'ow_uipref_datasets'                    => 'Намуди пешфарз',
	'ow_uiprefs'                            => 'Викидода',
	'ow_conceptmapping_no_action_specified' => 'Бахшиш, ман чӣ тавр "$1" карданро намедонам.',
	'ow_dm_not_found'                       => 'дар пойгоҳи додаҳо ёфт нашуд ё ноқис аст',
	'ow_will_insert'                        => 'Зеринро хоҳад ҷой дод:',
	'ow_available_contexts'                 => 'Матнҳои дастрас',
	'ow_Annotation'                         => 'Тафсир',
	'ow_ApproximateMeanings'                => 'Маъниҳои тақрибӣ',
	'ow_ClassAttributeLevel'                => 'Сатҳ',
	'ow_ClassAttributeType'                 => 'Навъ',
	'ow_Collection'                         => 'Гирдовард',
	'ow_CollectionMembership'               => 'Узвияти гирдоварӣ',
	'ow_Definition'                         => 'Таъриф',
	'ow_DefinedMeaningAttributes'           => 'Тафсир',
	'ow_DefinedMeaning'                     => 'Мазмуни мушаххасшуда',
	'ow_DefinedMeaningReference'            => 'Мазмуни мушаххасшуда',
	'ow_ExactMeanings'                      => 'Маъниҳои дақиқ',
	'ow_IncomingRelations'                  => 'Робитаи воридшаванда',
	'ow_GotoSource'                         => 'Рафтан ба манбаъ',
	'ow_Language'                           => 'Забон',
	'ow_LevelAnnotation'                    => 'Тафсир',
	'ow_OptionAttribute'                    => 'Хосият',
	'ow_OptionAttributeOption'              => 'Ихтиёр',
	'ow_OptionAttributeOptions'             => 'Ихтиёрот',
	'ow_OptionAttributeValues'              => 'Қиматҳои ихтиёр',
	'ow_PopupAnnotation'                    => 'Тафсир',
	'ow_Relations'                          => 'Равобит',
	'ow_RelationType'                       => 'Навъи робита',
	'ow_Spelling'                           => 'Имло',
	'ow_Synonyms'                           => 'Синонимҳо',
	'ow_SynonymsAndTranslations'            => 'Синонимҳо ва тарҷумаҳо',
	'ow_Source'                             => 'Манбаъ',
	'ow_SourceIdentifier'                   => 'Ташхискунандаи манбаъ',
	'ow_TextAttribute'                      => 'Хосият',
	'ow_Text'                               => 'Матн',
	'ow_TextAttributeValues'                => 'Матнҳои ҳамвор',
	'ow_TranslatedTextAttribute'            => 'Хосият',
	'ow_TranslatedText'                     => 'Матни тарҷумашуда',
	'ow_TranslatedTextAttributeValue'       => 'Матн',
	'ow_TranslatedTextAttributeValues'      => 'Матнҳои қобили тарҷума',
	'ow_LinkAttribute'                      => 'Хосият',
	'ow_LinkAttributeValues'                => 'Пайвандҳо',
	'ow_Property'                           => 'Хосият',
	'ow_Value'                              => 'Қимат',
	'ow_meaningsoftitle'                    => 'Маъниҳои "$1"',
	'ow_meaningsofsubtitle'                 => '<em>Вики пайванд:</em> [[$1]]',
	'ow_Permission_denied'                  => '<h2>ИҶОЗА РАД ШУД</h2>',
	'ow_copy_no_action_specified'           => 'Лутфан амалеро мушаххас кунед',
	'ow_copy_help'                          => 'Рӯзе, мо битавонем ба шумо кӯмак кунем.',
	'ow_copy_successful'                    => '<h2>Нусхабардории Муваффақ</h2>
Додаҳои шум ба назар мерасанд, ки бо муваффақият нусхабардорӣ шуданд.
Барои мутмаин будна дубора барраси карданро фаромӯш накунед!',
	'ow_copy_unsuccessful'                  => '<h3>Нусхабардории номуваффақ</h3>
Ҳеҷ амалӣ нусхабардорӣ иҷро нашуд.',
	'ow_no_action_specified'                => '<h3>Ҳеҷ амале мушаххас нашудааст</h3>
Шояд шумо бевосита ба ин саҳифа омадед? Маъмулан шумо ниёз дар инҷо буданро надоред.',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$wdMessages['th'] = array(
	'ow_save'    => 'บันทึก',
	'ow_history' => 'ประวัติ',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$wdMessages['tr'] = array(
	'langman_title'                   => 'Lisan idarecisi',
	'languages'                       => 'Wikidata: Lisan idarecisi',
	'ow_save'                         => 'Kaydet',
	'ow_history'                      => 'Geçmiş',
	'ow_dm_OK'                        => 'Tamam',
	'ow_ClassAttributeLevel'          => 'Seviye',
	'ow_Collection'                   => 'Koleksiyon',
	'ow_Language'                     => 'Dil',
	'ow_Synonyms'                     => 'Eş anlamlılar',
	'ow_Source'                       => 'Kaynak',
	'ow_Text'                         => 'Metin',
	'ow_TranslatedTextAttributeValue' => 'Metin',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author AS
 */
$wdMessages['uk'] = array(
	'ow_dm_OK'    => 'Гаразд',
	'ow_Language' => 'Мова',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$wdMessages['vi'] = array(
	'datasearch'                      => 'Wikidata: Tìm kiếm cho dữ liệu',
	'langman_title'                   => 'Quản lý ngôn ngữ',
	'languages'                       => 'Wikidata: Quản lý ngôn ngữ',
	'ow_save'                         => 'Lưu',
	'ow_history'                      => 'Lịch sử',
	'ow_noedit_title'                 => 'Không có quyền sửa đổi',
	'ow_dm_OK'                        => 'Được',
	'ow_AlternativeDefinition'        => 'Định nghĩa khác',
	'ow_AlternativeDefinitions'       => 'Các định nghĩa khác',
	'ow_Annotation'                   => 'Chú thích',
	'ow_ApproximateMeanings'          => 'Ý nghĩa gần',
	'ow_ClassAttributeLevel'          => 'Cấp',
	'ow_ClassAttributeType'           => 'Loại',
	'ow_Collection'                   => 'Tập hợp',
	'ow_Definition'                   => 'Định nghĩa',
	'ow_DefinedMeaningAttributes'     => 'Chú thích',
	'ow_DefinedMeaning'               => 'Định nghĩa',
	'ow_DefinedMeaningReference'      => 'Định nghĩa',
	'ow_Language'                     => 'Ngôn ngữ',
	'ow_LevelAnnotation'              => 'Chú thích',
	'ow_OptionAttributeOptions'       => 'Tùy chọn',
	'ow_PopupAnnotation'              => 'Chú thích',
	'ow_Relations'                    => 'Các mối quan hệ',
	'ow_Spelling'                     => 'Chính tả',
	'ow_Synonyms'                     => 'Từ đồng âm',
	'ow_SynonymsAndTranslations'      => 'Từ đồng âm và cách dịch',
	'ow_Source'                       => 'Nguồn',
	'ow_Text'                         => 'Văn bản',
	'ow_TranslatedText'               => 'Văn bản dịch',
	'ow_TranslatedTextAttributeValue' => 'Văn bản',
	'ow_Value'                        => 'Giá trị',
	'ow_meaningsoftitle'              => 'Các ý nghĩa của “$1”',
	'ow_meaningsofsubtitle'           => '<em>Liên kết wiki:</em> [[$1]]',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$wdMessages['vo'] = array(
	'ow_save'                               => 'Dakipolöd',
	'ow_history'                            => 'Jenotem',
	'ow_conceptmapping_no_action_specified' => 'Liedo no fägob ad "$1".',
	'ow_add_concept_link'                   => 'Läükön yümi tikädes votik',
	'ow_concept_panel'                      => 'Tikädafremül',
	'ow_Annotation'                         => 'Penet',
	'ow_Collection'                         => 'Konlet',
	'ow_Definition'                         => 'Miedet',
	'ow_DefinedMeaningAttributes'           => 'Penet',
	'ow_Expression'                         => 'Notod',
	'ow_Expressions'                        => 'Notods',
	'ow_Language'                           => 'Pük',
	'ow_LevelAnnotation'                    => 'Penet',
	'ow_OptionAttributeOption'              => 'Välot',
	'ow_OptionAttributeOptions'             => 'Välots',
	'ow_PopupAnnotation'                    => 'Penet',
	'ow_Spelling'                           => 'Tonatam',
	'ow_Source'                             => 'Fonät',
	'ow_Text'                               => 'Vödem',
	'ow_TranslatedTextAttributeValue'       => 'Vödem',
	'ow_LinkAttributeValues'                => 'Liuds',
);

/** Simplified Chinese (‪中文(简体)‬) */
$wdMessages['zh-hans'] = array(
	'datasearch'    => 'Wikidata: 数据搜寻',
	'langman_title' => '语言管理员',
	'languages'     => 'Wikidata: 语言管理员',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$wdMessages['zh-hant'] = array(
	'datasearch'    => 'Wikidata: 資料搜尋',
	'langman_title' => '語言管理員',
	'languages'     => 'Wikidata: 語言管理員',
);

$wdMessages['de-formal'] = $wdMessages['de'];
$wdMessages['kk'] = $wdMessages['kk-kz'];
$wdMessages['yue'] = $wdMessages['zh-hant'];
$wdMessages['zh'] = $wdMessages['zh-hans'];
$wdMessages['zh-cn'] = $wdMessages['zh-hans'];
$wdMessages['zh-hk'] = $wdMessages['zh-hant'];
$wdMessages['zh-sg'] = $wdMessages['zh-hans'];
$wdMessages['zh-tw'] = $wdMessages['zh-hant'];
$wdMessages['zh-yue'] = $wdMessages['yue'];
