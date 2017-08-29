[![Build Status](https://travis-ci.org/pastuhov/yii2-query-tag.svg)](https://travis-ci.org/pastuhov/yii2-query-tag)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pastuhov/yii2-query-tag/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-query-tag/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pastuhov/yii2-query-tag/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-query-tag/?branch=master)
[![Total Downloads](https://poser.pugx.org/pastuhov/yii2-query-tag/downloads)](https://packagist.org/packages/pastuhov/yii2-query-tag)

Query tag extension for Yii 2
===========================
Do you use `pgbabger` or `pg_stat_statements` ? And sometimes it can be difficult to understand which code generates the request? `yii2-query-tag` will help!

Before: 
```sql
SELECT * FROM page WHERE 1=1
```

After:
```sql
SELECT /* ExampleTest:11 UnitHelper:28 Step:218 */ * FROM page WHERE 1=1
```

Features
--------

- Production ready/safe/tested
- Saves team time

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
    "pastuhov/yii2-query-tag": "~1.1.0"
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

Advanced usage
-----

Extend query tag command class:
```php
namespace app\components;

class Command extends \pastuhov\querytag\Command
{
    public $customTag = 'master';
    public $enabledTags = [
        self::TAG_TYPE_CUSTOM,
        self::TAG_TYPE_TRACE,
    ];
}
```


Testing
-------

```bash
./vendor/bin/codecept run
```

Security
--------

If you discover any security related issues, please email pastukhov_k@sima-land.ru instead of using the issue tracker.
