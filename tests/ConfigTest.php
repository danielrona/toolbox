<?php
    /**
     * Copyright (c) 2017.
     *
     * Daniel Rona
     */

    namespace Danielrona\Toolbox;


    class ConfigTest extends \PHPUnit_Framework_TestCase
    {
        public function testConfig()
        {
            $config = new Config;
            $this->assertNull($config->set('test', 'test'));
            $this->assertStringStartsWith('test', $config->get('test'));
        }
    }
