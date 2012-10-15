/**
 * PEG.js grammar for reading MediaWiki parser tests files
 * 2011-07-20 Brion Vibber <brion@pobox.com>
 */

testfile =
    chunk+



eol = "\n"

whitespace = [ \t]+

ws = whitespace

rest_of_line = c:([^\n]*) eol
{
    return c.join('');
}

line = (!"!!") line:rest_of_line
{
    return line;
}

text = lines:line*
{
    return lines.join('\n');
}

chunk =
    comment /
    article /
    test /
    line /
    hooks



comment =
    "#" text:rest_of_line
{
    return {
        type: 'comment',
        comment: text
    }
}

empty =
    eol /
    ws eol
{
    return {
        type: 'empty'
    }
}



article =
    start_article title:line start_text text:text end_article
{
    return {
        type: 'article',
        title: title,
        text: text
    }
}

start_article =
    "!!" ws? "article" ws? eol

start_text =
    "!!" ws? "text" ws? eol

end_article =
    "!!" ws? "endarticle" ws? eol


test =
    start_test
    title:text
    sections:section*
    end_test
{
    var test = {
        type: 'test',
        title: title
    };
    for (var i = 0; i < sections.length; i++) {
        var section = sections[i];
        test[section.name] = section.text;
    }
	return test;
}

section =
    "!!" ws? (!"end") name:(c:[a-zA-Z0-9]+ { return c.join(''); }) rest_of_line
    text:text
{
    return {
        name: name,
        text: text
    };
}

/* the : is for a stray one, not sure it should be there */

start_test =
    "!!" ws? "test" ":"? ws? eol

end_test =
    "!!" ws? "end" ws? eol


hooks =
    start_hooks text:text end_hooks
{
    return {
        type: 'hooks',
        text: text
    }
}

start_hooks =
    "!!" ws? "hooks" ":"? ws? eol

end_hooks =
    "!!" ws? "endhooks" ws? eol
