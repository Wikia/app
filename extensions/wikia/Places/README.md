Places
======

This extension allows you to geotag articles on a wiki by adding a simple `<place>` tag.
 
## `<place>`

`<place>` tag adds geolocation to the article and renders a static map.

The tag can be provided the following attributes:

* `align` (default: `right`) - align of the map
* `width` (default: `200px`) - the width of a map
* `height` (default: `200px`) - the height of a map
* `caption` (default: empty) - the optional map caption that will be rendered instead of geo coordinates below the map
* `lat` - the required geo latitude
* `lon` - the required geo longitude
* `zoom` (default: `14`) - the zoom level
* `hidden` - set this attribute to hide the static map and only render the geodata meta tag

Additionally the geodata meta tag is added in the `<head>` section:

```html
<meta name="geo.position" content="52.402987,16.933748" />
```

### Examples

Renders a map of a (52.40446931 N, 16.93271574 E) point with 300px width and zoom level set to 15.

```html
<place lat="52.40446931" lon="16.93271574" width=300 zoom=15 />
```

Renders a map with a custom caption (wikitext can be used).

```html
<place lat="52.40446931" lon="16.93271574" width=300 zoom=15 caption="This is a [[map]] of {{PAGENAME}}" />
```

## `<places>`

`<places>` tag renders an interactive map with provided set of points.

### Examples

Render a map of all geo-tagged articles on this wiki (limited to 100 articles).

```html
<places />
```

Render a map of all articles in "Foo" category.

```html
<places category="Foo" />
```

Render a map of all articles in either "Foo" or "Bar" category.

```html
<places category="Foo|Bar" />
```

Render a map of all articles in a current category (can be used in category page).

```html
<places category="{{PAGENAME}}" />
```

Render a map of all articles matching given [DPL query](http://semeb.com/dpldemo/index.php?title=DPL:Manual_-_DPL_parameters:_Criteria_for_page_selection) (please note the required `format` parameter).

```html
<places>
<dpl>
titlematch = Prefix%
namespace  = 0
format     = ,\n* %TITLE%,,
</dpl>
</places>
```

## API

All geo-tagged articles can be accessed via [MediaWiki API](http://poznan.wikia.com/api.php?action=places).
