CONTENTS OF THIS FILE
---------------------
 * Requirements
 * Installation
 * Configuration
 * Features
 * FAQ

INTRODUCTION
------------
Todo

REQUIREMENTS
------------
No other modules required, we're supporting drupal core's search as a source for
creating facets. Though we recommend using Search API, as that integration is
better tested.


INSTALLATION
------------
 * Install as you would normally install a contributed drupal module. See:
   https://drupal.org/documentation/install/modules-themes/modules-7
   for further information.


CONFIGURATION
-------------
Before adding a facet, there should be a facet source. Facet sources can be:
- Drupal core's search.
- A view based on a Search API index with a page display.
- A page from the search_api_page module.

After adding one of those, you can add a facet on the facets configuration page:
/admin/config/search/facets, there's an `add facet` link, that links to:
admin/config/search/facets/add-facet. Use that page to add the facet by
selecting the correct facet source and field from that source.

If you're using Search API views, make sure to disable views cache when using
facets for that view.


KNOWN ISSUES
------------
When choosing the "Hard limit" option on a search_api_db backend, be aware that
the limitation is done internally after sorting on the amount of results ("num")
first and then sorting by the raw value of the facet (e.g. entity-id) in the
second dimension. This can lead to edge cases when there is an equal amount of
results on facets that are exactly on the threshold of the hard limit. In this
case the raw facet value with the lower value is preferred:


| num | value | label |
|-----|-------|-------|
|  3  |   4   | Bar   |
|  3  |   5   | Atom  |
|  2  |   2   | Zero  |
|  2  |   3   | Clown |

"Clown" will be cut off due to its higher internal value (entity-id). For
further details see: https://www.drupal.org/node/2834730


FEATURES
--------

If you are the developer of a search api backend implementation and want
to support facets with your service class, too, you'll have to support the
"search_api_facets" feature. In short, you'll just have to return facet terms
and counts according to the query's "search_api_facets" option, when executing a
query.
In order for the module to be able to tell that your server supports facets,
you will also have to change your service's supportsFeature() method to
something like the following:

```
  public function getSupportedFeatures() {
    return ['search_api_facets'];
  }
```

If you don't do that, there's no way for the facet source to pick up facets.

The "search_api_facets" option looks as follows:

```
$query->setOption('search_api_facets', [
  $facet_id => [
    // The Search API field ID of the field to facet on.
    'field' => (string),
    // The maximum number of filters to retrieve for the facet.
    'limit' => (int),
    // The facet operator: "and" or "or".
    'operator' => (string),
    // The minimum count a filter/value must have to be returned.
    'min_count' => (int),
    // Whether to retrieve a facet for "missing" values.
    'missing' => (bool),
  ],
  // …
]);
```

The structure of the returned facets array should look like this:

```
$results->setExtraData('search_api_facets', [
  $facet_id => [
    [
      'count' => (int),
      'filter' => (string),
    ],
    // …
  ],
  // …
]);
```

A filter is a string with one of the following forms:
- `"VALUE"`: Filter by the literal value VALUE (always include the quotes, not
  only for strings).
- `[VALUE1 VALUE2]`: Filter for a value between VALUE1 and VALUE2. Use
  parantheses for excluding the border values and square brackets for including
  them. An asterisk (*) can be used as a wildcard. E.g., (* 0) or [* 0) would be
  a filter for all negative values.
- `!`: Filter for items without a value for this field (i.e., the "missing"
  facet).


FAQ
---

Q: Why do the facets disappear after a refresh.
A: We don't support cached views, change the view to disable caching.

Q: Why doesn't chosen (or similiar javascript dropdown replacement) not work
with the dropdown widget.
A: Because the dropdown we create for the widget is created trough javascript,
the chosen module (and others, probably) doesn't find the select element.
So the library should be attached to the block in custom code, we haven't done
this in facets because we don't want to support all possible frameworks.
See https://www.drupal.org/node/2853121 for more information.
