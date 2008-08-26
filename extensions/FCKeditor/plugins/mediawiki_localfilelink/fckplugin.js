// localFileLink MediaWiki Extention
// Created by  Doru Moisa, Optaros Inc.
// Rwrite the link command to use our link_dialog.html.
FCKCommands.RegisterCommand( 'Link',
                            new FCKDialogCommand( 'Link',
                                                 FCKLang.DlgLnkWindowTitle,
                                                 FCKConfig.PluginsPath + 'mediawiki_localfilelink/link_dialog.html',
                                                 400,
                                                 250 )
                            ) ;
