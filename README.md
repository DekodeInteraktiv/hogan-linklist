# Link list Module for [Hogan](https://github.com/dekodeinteraktiv/hogan-core) [![Build Status](https://travis-ci.org/DekodeInteraktiv/hogan-linklist.svg?branch=master)](https://travis-ci.org/DekodeInteraktiv/hogan-linklist)

## Installation
Install the module using Composer `composer require dekodeinteraktiv/hogan-linklist` or simply by downloading this repository and placing it in `wp-content/plugins`

## Available filters
- `hogan/module/linklist/heading/enabled` for enabling heading field, default true.
- `hogan/module/linklist/dynamic_content_post_types` - use to add custom post types to dynamic content
- `hogan/module/linklist/dynamic_content_taxonomy_list` - use to add custom taxonomies for listing out links to taxonomy pages
- `hogan/module/linklist/dynamic_content_terms_list` - use to modify taxonomy settings for dynamix posts
- `hogan/module/linklist/dynamic_content_query` - for modifying query that selects posts

## TODO's
- option to autocollapse list after a given number of link (like on REMA)
- listview layouts, filter to add new ones? ex. automatic selection from post type/tax, list with images. Always full width (from Kaare)
- ACF link field - can uploaded files be selected from the list in the link popup like posts?
- Modulename in admin: add heading and type to collapsed view
