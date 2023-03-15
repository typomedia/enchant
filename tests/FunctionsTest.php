<?php

namespace Typomedia\Enchant\Tests;

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    public function setUp(): void
    {
        $this->broker = enchant_broker_init();
    }
    
    public function testBrokerInit()
    {
        $this->assertInstanceOf('EnchantBroker', $this->broker);
    }

    public function testDictionarySuggest()
    {
        $path = __DIR__ . '/../src/Enchant/Dictionaries';
        enchant_broker_set_dict_path($this->broker, ENCHANT_MYSPELL, $path);

        $dict = enchant_broker_request_dict($this->broker, 'en_GB');
        $results = enchant_dict_suggest($dict, 'sbellcheck');

        $this->assertEquals(['spellcheck', 'bellyache'], $results);
        $this->assertEquals($path, enchant_broker_get_dict_path($this->broker, ENCHANT_MYSPELL));
    }

    public function testPersonalWordlistDescribe()
    {
        $file = __DIR__ . '/../src/Enchant/Dictionaries/test.pwl';
        $dict = enchant_broker_request_pwl_dict($this->broker, $file);

        $info = enchant_dict_describe($dict);

        $this->assertEquals($file, $info['file']);
    }

    public function testPersonalWordlistAddWord()
    {
        $file = __DIR__ . '/../src/Enchant/Dictionaries/test.pwl';
        $dict = enchant_broker_request_pwl_dict($this->broker, $file);

        if (!enchant_dict_check($dict, 'test')) {
            enchant_dict_add_to_personal($dict, 'test');
            //enchant_dict_store_replacement($dict, 'test', '');
        }

        $this->assertTrue(enchant_dict_check($dict, 'test'));
    }

    public function testPersonalWordlistSuggest()
    {
        $file = __DIR__ . '/../src/Enchant/Dictionaries/test.pwl';
        $dict = enchant_broker_request_pwl_dict($this->broker, $file);

        $results = enchant_dict_suggest($dict, 'tesd');

        $this->assertEquals(['test'], $results);
    }

}
