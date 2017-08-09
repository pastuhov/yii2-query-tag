<?php
namespace pastuhov\querytag\tests\app\components;

/**
 * @inheritdoc
 */
class Command extends \pastuhov\querytag\Command
{
    /**
     * @inheritdoc
     */
    public $customTag = 'master';
    /**
     * @inheritdoc
     */
    public $enabledTags = [
        self::TAG_TYPE_CUSTOM,
        self::TAG_TYPE_TRACE,
    ];
}
