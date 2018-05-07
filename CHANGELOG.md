# Changelog

## 1.1.5
* Add class to list item if link is external

## 1.1.4
* Dynamic content can list terms in a taxonomy
* Dynamic content can limit posts to a set category

## 1.1.3
* Update module to new registration method introduced in [Hogan Core 1.1.7](https://github.com/DekodeInteraktiv/hogan-core/releases/tag/1.1.7)
* Set hogan-core dependency `"dekodeinteraktiv/hogan-core": ">=1.1.7"`
* Add Dekode Coding Standards.

## 1.1.2
* Add `$item` and `$this` to before and after text action [#19](https://github.com/DekodeInteraktiv/hogan-linklist/pull/19)
* Set link text if not set in WP link picker [#20](https://github.com/DekodeInteraktiv/hogan-linklist/pull/20)

## 1.1.1
* Added actions in template. `hogan_linklist_before_linktext` and `hogan_linklist_after_linktext`.

## 1.1.0
### Breaking Changes
* Remove heading field, provided from Core in [#53](https://github.com/DekodeInteraktiv/hogan-core/pull/53)
* Heading field has to be added using filter (was default on before).

## 1.0.14
### Internal
* Use core component to print heading.
* Add default classnames.
* Use `hogan_classnames` to join classnames together.
* Remove unused variables in template.

## 1.0.13
* Removed use of deprecated filter `hogan/module/linklist/inner_wrapper_tag`

## 1.0.12
* Filter fix

## 1.0.11
* Add counter as filter parameter

## 1.0.10
* Linklists without box view
