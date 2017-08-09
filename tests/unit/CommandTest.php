<?php
namespace pastuhov\querytag\tests\unit;

use pastuhov\querytag\tests\app\models\Page;

class CommandTest extends UnitTestCase
{
    public function testQueryTag()
    {
        $this->tester->assertLog(function (){
            \Yii::$app->db->createCommand('SELECT * FROM page WHERE 1=1')->execute();
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
