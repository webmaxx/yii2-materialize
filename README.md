Materialize Extension for Yii 2
===============================

This is the Materialize extension for Yii 2. It encapsulates [Materialize](http://materializecss.com/) components
and plugins in terms of Yii widgets, and thus makes using Materialize components/plugins
in Yii applications extremely easy.

For license information check the [LICENSE](LICENSE.md)-file.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require altiore/yii2-materialize
```

or add

```
"altiore/yii2-materialize": "@stable"
```

to the require section of your `composer.json` file.

Usage
----

For example, the following
single line of code in a view file would render a Materialize Progress plugin:

```php
<?= altiore\materialize\Progress::widget(['percent' => 70]) ?>
```
