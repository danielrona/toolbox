<?php
    /**
     * Created by PhpStorm.
     * User: drona
     * Date: 19.02.2017
     * Time: 13:19
     */

    namespace Danielrona\Toolbox;


    class ConfigTest extends \PHPUnit_Framework_TestCase
    {
        public function testConfig()
        {
            $config = new Config;
            $this->assertNull($config->set('test','test'));
            $this->assertStringStartsWith('test',$config->get('test'));
        }
    }
