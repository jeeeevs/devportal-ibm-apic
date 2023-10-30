# Search API Autocomplete

This module adds autocomplete capabilities for Search API searches.

Autocompletion can be activated and configured for each search (all search views
and pages) individually, so you have fine-grained control over where
autocompletion can be used – and by whom.

For a full description of the module, visit the [project page].

Submit bug reports and feature suggestions, or track changes in the [issue
queue].

[project page]: https://www.drupal.org/project/search_api_autocomplete
[issue queue]: https://www.drupal.org/project/issues/search_api_autocomplete


## Requirements


This module requires the following other module:

- [Search API](https://www.drupal.org/project/search_api)


### Necessary server feature

The default “Retrieve from server” suggester provided by this module retrieves
autocomplete suggestions from the server, based on the indexed data. For this to
work, the server’s backend plugin has to support the `search_api_autocomplete`
feature. Having autocompletion for indexes on servers for which the backend
doesn’t support this feature is only possible if you use a different suggester
(like “Display live results”, or one provided by a separate module). Most
backends do support this feature, but please see the [list in the Search API
documentation] for more up-to-date information on available backends and whether
they support this feature.

[list in the Search API documentation]: https://www.drupal.org/docs/8/modules/search-api/getting-started/server-backends-and-features#backends


## Installation

After having installed and enabled the module (see [the Drupal wiki] for
details), you have to do some administrative steps to activate the autocomplete
functionality. Autocompletion can be enabled and configured for each search
separately.

To activate autocompletion for an index’s searches, go to the index’s
“Autocomplete” tab. There, you see all available searches for the index and can
enable (and afterwards configure) autocompletion for each of them. All fulltext
key fields on the searches should then become autocompletion fields.

There is an autocomplete permission for each separate search. Therefore, after
adding autocomplete to a new search, don’t forget to set the appropriate
permissions.

[the Drupal wiki]: https://www.drupal.org/docs/extending-drupal/installing-modules


## Supported searches

Currently, only search forms built by the Search API Pages or Views modules are
supported directly. However, other modules can easily also use this
functionality. See the “Information for developers” below for details.


## Configuration

To customize the behavior of autocompletion for a specific search, go to the
search index’s “Autocomplete” and click “Edit” next to the search in question.

Apart from this, there is also one global config setting not accessible via the
user interface, only meant for advanced users:

- `search_api_autocomplete.settings:enable_custom_scripts`:
  Enables the “Use custom script” suggester which lets you redirect the
  autocomplete AJAX request to a path or URL of your choosing. Since this is
  mostly interesting for developers, who want to write their own autocomplete
  code (possibly bypassing Drupal for performance reasons), this suggester is
  not available otherwise by default. (The setting defaults to `FALSE`, set to
  `TRUE` to make the suggester available.)


## Information for developers


### Supporting a new method of creating suggestions

You can add your own implementation for creating autocomplete suggestions by
creating a so-called “suggester” plugin. For details, see the interface
documentation in `src/Suggester/SuggesterPluginBase.php`.


### Supporting autocompletion with a backend plugin

To support autocompletion with a backend plugin, the plugin has to support the
`search_api_autocomplete` feature. This will necessitate the backend class to
have a `getAutocompleteSuggestions()` method as detailed in the interface in
`src/AutocompleteBackendInterface.php`.


### Supporting autocompletion on a search form

If you have a search form not generated by the Search views or Search pages
modules, you can add an autocomplete search plugin to support autocompletion for
it. See `src/Search/SearchPluginBase.php` for the plugin type documentation,
or `src/Plugin/search_api_autocomplete/search/` for examples. Additionally, you
will need to write a form alter hook to adapt your search form’s input element.
For examples, see `search_api_autocomplete_form_views_exposed_form_alter()` or
`search_api_autocomplete_form_search_api_page_block_form_alter()`.


## Maintainers

- [Thomas Seidl (drunken monkey)](https://www.drupal.org/u/drunken-monkey)