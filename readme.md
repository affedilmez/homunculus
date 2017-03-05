Homunculus
==========

A PHP class for managing CMS-like global HTML without the
overhead of a DB or class hierarchy. Can be useful when you
want to:

* Generate a handful of static HTML files without having to
  copy/paste common elements
* Pull together content from multiple PHP sources/frameworks
  on the same page

Theme Files
-----------

* **include.ini** - lists CSS and Javascript files to be included on every page
* **head.php** - document open and HTML `<head>` element
* **header.php** - in-page header section
* **fragments.php** - code snippets which can be included in multiple places
* **footer.php** - in-page footer

Usage
-----

See the demo folder for an example.

License
-------

Released under the MIT license.
