# Link list Module for [Hogan](https://github.com/dekodeinteraktiv/hogan-core)

## Installation
Install the module using Composer `composer require dekodeinteraktiv/hogan-linklist` or simply by downloading this repository and placing it in `wp-content/plugins`

## Available filters
- `hogan/module/linklist/heading/enabled` for enabling heading field, default true.
- `hogan/module/linklist/post_types_in_link_field` for including custom post types in the native link popup.
```
//default values
[
	'post',
	'page',
];
```

## TODO's
- option to autocollapse list after a given number of link (like on REMA)
- listview layouts, filter to add new ones? ex. automatic selection from post type/tax, list with images. Always full width (from Kaare)
- ACF link field - can uploaded files be selected from the list in the link popup like posts?
- Modulename in admin: add heading and type to collapsed view
