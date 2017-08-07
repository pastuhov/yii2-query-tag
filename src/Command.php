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
     * Maximum trace entries in query.
     *
     * @var int
     */
    public $traceLevel = 4;
    /**
     * debug_backtrace() level param.
     *
     * @var int
     */
    public $backTraceLevel = 12;

    /**
     * @inheritdoc
     */
    public function setSql($sql)
    {
        $sql = $this->insertTag($sql);

        return parent::setSql($sql);
    }

    /**
     * Tag compilation.
     *
     * @return string
     */
    protected function getTag(): string
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

        return ' /* ' . implode(' ', $traces) . ' */';
    }

    /**
     * Inserts tag into query.
     *
     * @param string $sql Query.
     * @return string
     */
    protected function insertTag(string $sql): string
    {
        $position = strpos($sql, ' ');

        if ($position !== false) {
            $tag = $this->getTag();

            $sql = substr_replace($sql, $tag, $position, 0);
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
