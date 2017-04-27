<?php

class ViewConfigPageTest extends TestCase
{

    public function testBasicView()
    {
        $this->withoutMiddleware()
            ->visit('/config')
            ->see('MouseHunt Map Helper');
    }

    public function testConfigHasMiceView()
    {
        $this->withoutMiddleware()
            ->visit('/config')
            ->seeInElement('form', 'New Mouse')
            ->seeInElement('ul', 'Current Mice')
            ->seeElement('#mice');
    }

    public function testConfigHasCheesesView()
    {
        $this->withoutMiddleware()
            ->visit('/config')
            ->seeInElement('form', 'New Cheese')
            ->seeInElement('ul', 'Current Cheeses');
    }

    public function testConfigHasStagesView()
    {
        $this->withoutMiddleware()
            ->visit('/config')
            ->seeInElement('form', 'New Stage')
            ->seeInElement('ul', 'Current Stages');
    }

    public function testConfigHasLocationsView()
    {
        $this->withoutMiddleware()
            ->visit('/config')
            ->seeInElement('form', 'New Location')
            ->seeInElement('ul', 'Current Locations');
    }

    public function testConfigHasSetupsView()
    {
        $this->withoutMiddleware()
            ->visit('/config')
            ->seeInElement('form', 'New Setup')
            ->seeInElement('ul', 'Current Setups');
    }


}
