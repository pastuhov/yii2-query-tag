<?php

namespace pastuhov\querytag\tests\unit;


class CommandTest extends UnitTestCase
{
    public function testQueryTag()
    {
        $this->tester->assertLog(function (){
            \Yii::$app->db->createCommand('SELECT * FROM page WHERE 1=1')->execute();
        }, \Yii::$app);
    }
}
