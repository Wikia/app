/**
 * version 2011.12.09
 * @since 2011.11.23
 * @author Kaseluris-Nikos-1959 (http://users.otenet.gr/~nikkas/)
 * @license GNU GPLv3
 *
 * To create the expandable-tree I studied, used and modified the code from
 * http://www.dhtmlgoodies.com/
 *
 * To create the splitter I studied, used and modified the code from
 * http://krikus.com/js/splitter
 */
jQuery(document).ready(function() {

    /* Header menu */
    $('.classSngMenu li').has('ul').hover(function() {
        $(this).children('ul').fadeIn();
    }, function() {
        $(this).children('ul').hide();
    });

    /* Creates the toc pane */
    jQuery.fn.funJqTocSplit = function() {
    return this.each(function() {
        var tocPosSplitCur = 116;
        var tocPosSplitPrev = 0;
        var divSngSplitter = $(this);
        var tocElmSplitChildren = divSngSplitter.children();
        var divSngSplitLeft = tocElmSplitChildren.first();
        var divSngSplitRight = tocElmSplitChildren.next();
        var divSngSplitBar = $('<div></div>');
        var divSngSplitBarGhost;
        var divSngSplitButton = $('<div></div>');
        // toc-tree variables
        var tocImgFolder = mw.config.get( 'stylepath' ) + "/synagonism/images/";
        var imgTocLeaf = 'toc-img-leaf.png';
        var imgTocCollapsed = 'toc-img-collapsed.png';
        var imgTocExpanded = 'toc-img-expanded.png';
        var imgTocAllExp = 'toc-img-all-exp.png';
        var imgTocAllCol = 'toc-img-all-col.png';
        // splitter processing
        divSngSplitBar.attr({"id": "idSngSplitBar"});
        divSngSplitBar.bind("mousedown", funSngDragStart);
        divSngSplitBar.insertAfter(divSngSplitLeft);
        divSngSplitButton.attr({"id": "idSngSplitButton"});
        divSngSplitBar.append(divSngSplitButton);
        divSngSplitButton.mousedown(function(e){
            if (e.target !== this) {
                return;
            }
            funSngSplitToPos((tocPosSplitCur === 0) ? tocPosSplitPrev : 0);
            tocPosSplitPrev = tocPosSplitCur;
            tocPosSplitCur = divSngSplitBar.position().left;
            return false;
        });
        // toc processing
        // takes the toc from right-pane and inserts it on left-pane
        divSngSplitLeft.html( $("#toc").find("ul:first") );
        // do processing only if we have toc, otherwise split to zero
        if (divSngSplitLeft.children().length !== 0) {
            divSngSplitLeft.find("ul:first")
                .prepend("<li><a href='#idTop'>0 Top</a></li>");
            divSngSplitLeft.find("ul:first").attr('id','idSngToc');
            // insert collaplse-button
            var elmImgAllCol = $("<img />")
                .css({"margin":"0px 5px 0 20px",
                      "cursor":"pointer"})
                .attr({"src":tocImgFolder + imgTocAllCol,
                       "title": "Collapse-All"})
                .click( function(event){
                    funSngTreeCollapseAll();})
                .insertBefore("#idSngSplitLeft ul:first");
            // insert expand-button
            var elmImgAllExp = $("<img />")
                .css({"margin":"0px 0px 0 5px",
                      "cursor":"pointer"})
                .attr({"src":tocImgFolder + imgTocAllExp,
                       "title": "Expand-All"})
                .click( function(event){
                    funSngTreeExpandAll();})
                .insertAfter(elmImgAllCol);
            // toc: link targets
            divSngSplitLeft.find("a").each( function() {
                $(this).click( function(event){
                    var id = $(this).attr("href").split('#')[1];
                    if (id) {
                        funSngTreeGotoId(id);
                    }
                    funSngTreeHighlightItem($(this));
                });
                // sets as title-attribute the text of a-element
                var txt = $(this).text();
                $(this).attr('title',txt);
            });
            // clicking on content
            $("#content").find(":header").each( function() {
                $(this).click( function(event){funSngClickHeader($(this));});
            });
            $("#content").find("p, ul, table").each( function() {
                $(this).click( function(event){
                    var elmH = $(this).prevAll(":header:first");
                    if (elmH.length > 0) {
                        funSngClickHeader(elmH);
                    } else {
                        funSngTreeCollapseAll();
                        funSngTreeHighlightItem(divSngSplitLeft.find("a:first"));
                    }
                });
            });
            funSngSplitToPos(tocPosSplitCur);
        } else {
            funSngSplitToPos(0);
        }

        funSngTreeInit();
        // go to existing-address
        var sUrl = document.URL;
        if (sUrl.indexOf("#")>=0) {
            location.href="#"+sUrl.split('#')[1];
        }

        /* By clicking on a heading-element on the right-pane,
         * highlights and expand the corresponding item on toc. */
        function funSngClickHeader(elmH) {
            var sID = "";
            sID = "#" + elmH.children(".mw-headline").attr("id");
            // expand toc on this id
            divSngSplitLeft.find("a").each( function() {
                if ($(this).attr('href') === sID) {
                    funSngTreeCollapseAll();
                    funSngTreeHighlightItem($(this));
                    funSngTreeExpandParent($(this));
                    // scroll to this element
                    //this.scrollIntoView(true);
                }
            });
        }

        function funSngDragStart(e) {
            if (e.target !== this) {
                return;
            }
            divSngSplitBarGhost = divSngSplitBar.clone(false)
                .insertAfter(divSngSplitLeft);
            divSngSplitBarGhost.css({
                    'position': 'absolute',
                    'background-color': '#DDDDDD',
                    'z-index': '250',
                    '-webkit-user-select': 'none',
                    'left':divSngSplitBar.position().left
                });
            tocElmSplitChildren.css({
                    "-webkit-user-select": "none",
                    "-khtml-user-select": "none",
                    "-moz-user-select": "none"});
            $(divSngSplitter).bind("mousemove", funSngDragPerform)
                .bind("mouseup", funSngDragEnd);
            return false; //IE does not select text with this line
        }

        function funSngDragPerform(e) {
            var incr = e.pageX;
            divSngSplitBarGhost.css("left", incr);
        }

        function funSngDragEnd(e){
            var p = divSngSplitBarGhost.position();
            divSngSplitBarGhost.remove();
            divSngSplitBarGhost = null;
            tocElmSplitChildren.css("-webkit-user-select", "text");
            $(divSngSplitter).unbind("mousemove", funSngDragPerform)
                .unbind("mouseup", funSngDragEnd);
            tocPosSplitPrev = tocPosSplitCur;
            tocPosSplitCur = p.left;
            funSngSplitToPos(p.left);
        }

        function funSngSplitToPos(pos) {
            var sizeB = divSngSplitter.width() - pos - divSngSplitBar.width();
            divSngSplitLeft.css({"width":pos+'px'});
            divSngSplitBar.css({"left":pos});
            divSngSplitRight.css({"width":sizeB + 'px',
                                  "left":pos + divSngSplitBar.width()});

            divSngSplitter.queue(function() {
                setTimeout(function() {
                    divSngSplitter.dequeue();
                    tocElmSplitChildren.trigger("resize");
                }, 22);
            });
        }

        /* Makes "display: none" of ul-elements. */
        function funSngTreeCollapseAll() {
            $("#idSngToc li").each( function() {
                var elmUl = $(this).find("ul:first");
                if ( elmUl.length > 0 && (elmUl.css("display") === "block") ) {
                    $(this).find("img:first").attr({'src':tocImgFolder+imgTocCollapsed});
                    elmUl.css({'display': 'none'});
                }
            });
        }

        /* Makes the display-style: block. */
        function funSngTreeExpandAll() {
            $("#idSngToc li").each( function() {
                var elmUl = $(this).find("ul:first");
                if ( elmUl.length > 0 && (elmUl.css("display") === "none") ) {
                    $(this).find("img:first").attr({'src':tocImgFolder+imgTocExpanded});
                    elmUl.css({'display': 'block'});
                }
            });
        }

        /* expands all the parents only, of an element */
        function funSngTreeExpandParent(elmA){
            var elmImg;
            // the parent of a-elm is li-elm with parent a ul-elm.
            var elmUl = elmA.parent().parent();
            while (elmUl.get(0).nodeName === "UL"){
                elmUl.css({'display': 'block'});
                // the parent is li-elm, its first-child is img
                elmImg = elmUl.parent().children().first();
                if ( elmImg.get(0).nodeName === "IMG" ) {
                    if ( elmImg.attr('src').indexOf(imgTocAllCol) == -1) {
                        elmImg.attr({'src': tocImgFolder + imgTocExpanded});
                    }
                }
                elmUl = elmUl.parent().parent();
            }
        }

        /* Goes to Id, and blinks it. From HTML5-Outliner */
        function funSngTreeGotoId(id){
            location.href = '#'+id;
            var el = document.getElementById(id);
            var currentOpacity = window.getComputedStyle(el).opacity,
                currentTransition = window.getComputedStyle(el).webkitTransition;
            var duration = 200,
                itr = 0;
            el.style.webkitTransitionProperty="opacity";
            el.style.webkitTransitionDuration = duration+"ms";
            el.style.webkitTransitionTimingFunction="ease";
            var blink = function() {
                el.style.opacity=(itr % 2 === 0 ? 0 : currentOpacity);
                if (itr < 3) {
                    itr++;
                    setTimeout(blink, duration);
                } else {
                    el.style.webkitTransition = currentTransition;
                }
            };
            blink();
        }

        /* Highlights ONE item in toc-list */
        function funSngTreeHighlightItem(elmA){
            // removes existing highlighting
            divSngSplitLeft.find("a").each(
                function() {
                    $(this).removeAttr("class");
                });
            elmA.attr('class','classTocTreeHighlight');
        }

        /* Inserts images with onclick events, before a-elements. Sets id on li */
        function funSngTreeInit() {
            $("#idSngToc li").each( function() {
                var elmA = $(this).find("a:first");
                var elmUl = $(this).find("ul:first");
                if (elmUl.length > 0) {
                    elmUl.css({'display': 'none'});
                }
                // create img-elm before a-elm
                var elmImg = $("<img />")
                    .css({"margin":"0 4px 0 3px",
                          "cursor":"default"})
                    .attr({"src":tocImgFolder + imgTocLeaf})
                    .click( function(event){
                        if (elmUl.length > 0) {
                            $(this).css({'cursor': 'pointer'});
                            if ( $(this).attr('src').indexOf(imgTocCollapsed) >= 0) {
                                $(this).attr({"src":tocImgFolder+imgTocExpanded});
                                elmUl.css({'display': 'block'});
                            } else {
                                $(this).attr({"src":tocImgFolder+imgTocCollapsed});
                                elmUl.css({'display': 'none'});
                            }
                        }
                    })
                    .insertBefore(elmA);
                if (elmUl.length > 0) {
                    elmImg.css({'cursor': 'pointer'});
                    elmImg.attr({"src":tocImgFolder+imgTocCollapsed});
                }
            });
        }
    });
    };

    $("#idSngSplitter").funJqTocSplit();

});