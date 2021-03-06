<?php
namespace pastuhov\querytag;

/**
 * Query trace tagging.
 *
 * Before: 'SELECT * FROM page WHERE 1=1'
 * After: 'SELECT \/* EExampleTest:11 UnitHelper:28 Step:218 *\/ * FROM page WHERE 1=1'
 */
class Command extends \yii\db\Command
{
    /**
     * Trace tag.
     */
    const TAG_TYPE_TRACE = 'TraceTag';
    /**
     * Custom tag.
     */
    const TAG_TYPE_CUSTOM = 'CustomTag';
    /**
     * Script entry point tag.
     */
    const TAG_TYPE_ENTRY_POINT = 'EnryPointTag';
    /**
     * Enabled tags.
     *
     * @var array
     */
    public $enabledTags = [
        self::TAG_TYPE_TRACE,
    ];
    /**
     * Custom tag value.
     *
     * @var string
     */
    public $customTag = '';
    /**
     * Maximum trace entries in query.
     *
     * @var int
     */
    public $traceLevel = 4;
    /**
     * Maximum debug_backtrace() level param.
     *
     * @var int
     */
    public $backTraceLevel = 12;

    /**
     * @inheritdoc
     */
    public function setSql($sql)
    {
        if ($sql !== null) {
            $sql = $this->insertTags($sql);
        }

        return parent::setSql($sql);
    }

    /**
     * Generates custom tag.
     */
    protected function getCustomTag()
    {
        return $this->customTag;
    }

    /**
     * Generates trace tag.
     *
     * @return string
     */
    protected function getTraceTag(): string
    {
        $count = 0;
        $traces = [];
        $ts = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $this->backTraceLevel);
        array_pop($ts); // remove the last trace since it would be the entry script, not very useful
        foreach ($ts as $trace) {
            if (isset($trace['file'], $trace['line']) && strpos($trace['file'], YII2_PATH) !== 0 && strpos($trace['file'], __DIR__) !== 0) {
                unset($trace['object'], $trace['args']);
                $traces[] = $this->getTraceLine($trace);
                if (++$count >= $this->traceLevel) {
                    break;
                }
            }
        }

        return implode(' ', $traces);
    }

    /**
     * Inserts tags into query string.
     *
     * @param string $sql Query.
     * @return string
     */
    protected function insertTags(string $sql): string
    {
        $position = strpos($sql, ' ');

        if ($position !== false) {
            $tags = [];
            foreach ($this->enabledTags as $tag) {
                $tags[] = $this->{'get' . $tag}();
            }

            $sql = substr_replace(
                $sql,
                ' /* ' . implode(' ', $tags) . ' */',
                $position,
                0
            );
        }

        return $sql;
    }

    /**
     * Trace entry.
     *
     * @param array $trace Trace properties array.
     * @return string
     */
    protected function getTraceLine(array $trace): string
    {
        $line = basename($trace['file'], '.php') . ':' . $trace['line'];

        return $line;
    }
}
