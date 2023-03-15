<?php

namespace Typomedia\Enchant\Tests;

use Typomedia\Enchant\Enchant;
use PHPUnit\Framework\TestCase;

class EnchantTest extends TestCase
{
    public function setUp(): void
    {
        $this->enchant = new Enchant();
    }

    public function testGetSuggestions()
    {
        $suggestions = $this->enchant->getSuggestions('en_US', 'experiance');

        $this->assertIsArray($suggestions);
        $this->assertEquals(['experience', 'Spencerian'], $suggestions);
    }

    public function testAddWord()
    {
        $this->enchant->addWord('test.pwl', 'phonetic');
        $suggestions = $this->enchant->getSuggestionsFromPwl('test.pwl', 'fonetic');

        $this->assertIsArray($suggestions);
        $this->assertContains('phonetic', $suggestions);
    }

    public function testGetSuggestionsFromPwl()
    {
        $suggestions = $this->enchant->getSuggestionsFromPwl('test.pwl', 'fonetic');

        $this->assertIsArray($suggestions);
        $this->assertContains('phonetic', $suggestions);
    }

    public function testRemoveWord()
    {
        $this->enchant->removeWord('test.pwl', 'phonetic');
        $suggestions = $this->enchant->getSuggestionsFromPwl('test.pwl', 'fonetic');

        $this->assertEquals(null, $suggestions);
    }

    public function testRemovePwl()
    {
        $this->assertTrue($this->enchant->removePwl('test.pwl'));
    }

}
