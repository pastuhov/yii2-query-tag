<?php
namespace pastuhov\querytag\tests\unit;

use pastuhov\querytag\tests\app\models\Page;
use yii\db\Query;

class CommandTest extends UnitTestCase
{
    public function testQueryTag()
    {
        $this->tester->assertLog(function (){

            $query = new Query();

            $query->select('*')
                ->from('page')
                ->where('1=1')
                ->limit(10);
            $rows = $query->all();

            \Yii::$app->db->getSlave()->createCommand('select * from page WHERE  1=1')->execute();

        }, \Yii::$app);
    }

    public function testCreateEmptyCommand()
    {
        $this->tester->assertLog(function (){
            $command = \Yii::$app->db->createCommand(); // create empty command
            $command->delete(Page::tableName(), ['id' => 123]);
            $command->execute();
        }, \Yii::$app);
    }
}
