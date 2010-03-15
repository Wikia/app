                                        <h1 id="hub-name">Wikia Entertainment Hub</h1>

                                        <div id="hub-featured-box">

                                                <section id="spotlight-slider">
                                                <ul>
                                                        <?php //TODO: PROVIDE DATA ?>
                                                        <?php foreach($data['slider'] as $key => $value): ?>
                                                        <li id="spotlight-slider-<?php echo $key; ?>">
                                                                <a href="<?php echo $value['href'] ?>">
                                                                <img width="620" height="250" src="<?php echo $value['imagename'] ?>" class="spotlight-slider"></a>
                                                                <div class="description">
                                                                        <h2><?php echo $value['title'] ?></h2>
                                                                        <p><?php echo $value['desc'] ?></p>
                                                                        <a href="<?php echo $value['href'] ?>" class="wikia_button secondary">
                                                                                <span><?php echo wfMsg('corporatepage-go-to-wiki',$value['title']); ?></span>
                                                                        </a>
                                                                </div>
                                                                <p class="nav">
                                                                        <img width="50" height="25" alt="" src="<?php echo $value['imagethumb'] ?>">
                                                                </p>
                                                        </li>
                                                        <?php endforeach;?>
                                                </ul>
                                                </section><!-- END: #spotlight-slider -->

                                                <section id="hub-top-wikis">
                                                        <h1>Top Entertainment Wikis</h2>

                                                        <div id="top-wiki-info">
                                                          <div class="shrinkwrap">
                                                            <div id="stuff-it">&nbsp;</div>
                                                            <div class="clearfix">
                                                                <img src="" />
    
                                                                <ul id="top-wiki-meta">
                                                                        <li><span>Twilight Wiki</span></li>
                                                                        <li>815 articles</li>
                                                                        <li>5,489 pageviews</li>
                                                                </ul>                                                     
                                                            </div>
                                                          </div>
                                                        </div><!-- END: #top-wiki-meta -->

                                                        <div id="top-wikis-lists-box" class="clearfix">
                                                                <ul id="top-wikis-list-1">
                                                    <?php foreach ($data['topWikis1'] as $value): ?>
                                                    <li class="clearfix">
                                                      <span class="green-box">1</span>
                                                        <div class="top-wiki-data">
                                                        <h2><a href="#"><?php echo $value['city_title'] ?></a></h2>
                                                        <p><?php echo $value['count'] ?> weekly pageviews</p>
                                                                                                                        </div>
                                                    </li>
                                                    <?php endforeach ;?>
                                                                </ul>
                                        
                                                                <ul id="top-wikis-list-2" start="11">
                                                    <?php foreach ($data['topWikis2'] as $value): ?>
                                                    <li class="clearfix">
                                                      <span class="green-box">11</span>
                                                        <div class="top-wiki-data">
                                                        <h2><a href="#"><?php echo $value['city_title'] ?></a></h2>
                                                        <p><?php echo $value['count'] ?> weekly pageviews</p>
                                                                                                                        </div>
                                                    </li>
                                                    <?php endforeach ;?>
                                                                </ul>

                                                        </section><!-- END: #hub-top-wikis -->
                                                </div><!-- END: #top-wikis-lists-box -->
                                        </div><!-- END: #hub-featured-box -->

                                        <div id="hub-side-box">
                                                <section id="hub-blogs">
                                                        <h1>Entertainment Blogs</h1>
                                                        <ul id="hub-blog-articles">
                                                        <?php foreach( $data['topBlogs'] as $value ): ?>
                                                                <li class="clearfix">
                                                                        <h2><a href="<?php echo $value['page_url'] ?>"><?php echo $value['page_name'] ?></a></h2>
                                                                        <cite>February 23, 2010 <span class="user-info"><a href="#">Someuser</a></span></cite>
                                                                        <div class="clearfix">
                                                                                <img src="<?php echo $value['logo'] ?>" class="blog-image" />
                                                                                <p>Need some opinions, but PLEASE don't be rude... Just a little curious as to when Jacob's friends originally inhabited the Temple. If they've always been afraid of MIB/Smokey, how (...)</p>
                                                                        </div>
                                                                        <p class="blog-jump"><a href=""><img class="blog-jump-icon" src="http://images.wikia.com/common/skins/monaco/images/sprite.png?20100128"> <?php echo $value['tb_count'] ?> <span>Comments</span></a> | <a href="<?php echo $value['page_url'] ?>">Continue Reading</a></p>
                                                                </li>
                                                        <?php endforeach; ?>
                                                        </ul>
                                                </section><!-- END: #hub-blogs -->

                                                <section id="wikia-global-hot-spots">
                                                        <h1>Entertainment Hot Spots</h1>
                                                        <p>These are the hottest pages this week, ranked by most editors.</p>
                                                        <ol>
                                                        <?php   $first_hot = true;
                                                                $dspl_type = 'hilite';
                                                                foreach( $data['hotSpots'] as $value ):
                                                                        $first_hot ? $first_hot = false : $dspl_type = '';
                                                                ?>
                                                                <li class="<?php echo $dspl_type ?>">
                                                                        <div class="page-activity-badge">
                                                                                <div class="page-activity-level-<?php echo $value['level']; ?>">
                                                                                        <strong><?php echo $value['all_count']; ?></strong>
                                                                                        <span>editors</span>
                                                                                </div>
                                                                        </div>
                                                                        <span class="page-activity-sources">
                                                                                <a class="wikia-page-link" href="<?php echo $value['page_url'] ?>"><?php echo $value['page_name'] ?></a>
                                                                                <span>
                                                                                        <span>from</span>
                                                                                        <a class="wikia-wiki-link" href="<?php echo $value['wikiurl'] ?>"><?php echo $value['wikiname'] ?></a>
                                                                                </span>
                                                                        </span>
                                                                </li>
                                                        <?php endforeach; ?>
                                                        </ol>
                                                </section><!-- END: #hub-blogs -->
                                                <section id="hub-top-contributors">
                                                        <h1>Entertainment Top Contributors</h1>
                                                        <ul>
                                                                <?php foreach( $data['topEditors'] as $value ): ?>
                                                                  <li class="clearfix">
                                                                    <?php echo $value['avatar'] ?>
                                                                    <a href="" class="h2"><?php echo $value['username'];  ?></a>
                                                                    <div class="userEditPoints"><nobr><span class="userPoints"><?php echo $value['all_count'];  ?></span> <span class="txt">edit points</span></nobr></div>
                                                                  </li>
                                                                <?php endforeach; ?>
                                                        </ul>
                                                </section><!-- END: #hub-blogs -->
                                        </div><!-- END: #hub-side-box -->
