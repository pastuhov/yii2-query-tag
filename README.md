[![Build Status](https://travis-ci.org/pastuhov/yii2-query-tag.svg)](https://travis-ci.org/pastuhov/yii2-query-tag)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pastuhov/yii2-query-tag/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-query-tag/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pastuhov/yii2-query-tag/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-query-tag/?branch=master)
[![Total Downloads](https://poser.pugx.org/pastuhov/yii2-query-tag/downloads)](https://packagist.org/packages/pastuhov/yii2-query-tag)

Query tag extension for Yii 2
===========================
Adds trace lines to every DB query.

Before: 
```sql
SELECT * FROM page WHERE 1=1
```

After:
```sql
SELECT /* EExampleTest:11 UnitHelper:28 Step:218 */ * FROM page WHERE 1=1
```

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pastuhov/yii2-query-tag
```

or add

```
"require-dev": {
    "pastuhov/yii2-query-tag": "~1.0.0"
    ...
```

to the require section of your `composer.json` file.

Usage
-----

Change your app config:
```php
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'commandClass' => \pastuhov\querytag\Command::class, // <-- add this line
```

Testing
-------

```bash
./vendor/bin/codecept run unit,acceptance
```

Security
--------

If you discover any security related issues, please email pastukhov_k@sima-land.ru instead of using the issue tracker.
