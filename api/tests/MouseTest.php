<?php

use App\Mouse;

class MouseTest extends TestCase
{
    function testMouseFormatsName() {
        $this->assertEquals('TEST TEST TESTMOUSE', Mouse::formatName('TEST test TestMouse Mouse'));
        $this->assertEquals('TEST TEST TESTMOUSE', Mouse::formatName('TEST test TestMouse'));
    }

    function testWhiteMouseExists() {
        $mouse = Mouse::where('name', 'WHITE')->first();
        $this->assertInstanceOf(Mouse::class, $mouse);
        $this->assertInternalType('int', $mouse->id);
        $this->assertEquals('WHITE', $mouse->name);
        $this->assertNotEmpty($mouse->wiki_url);
        $this->assertInternalType('int', $mouse->ht_id);
    }
}
