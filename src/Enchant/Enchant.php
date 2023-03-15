<?php

namespace Typomedia\Enchant;

use EnchantBroker;
use Exception;

/**
 * Class Enchant
 * @package Typomedia\Enchant
 */
class Enchant
{
    /**
     * @var EnchantBroker|false|resource
     */
    protected $broker;

    /**
     * @var string
     */
    protected $path;

    /**
     * @param $path
     */
    public function __construct($path = null)
    {
        $this->path = $path ?? __DIR__ . '/Dictionaries';
        $this->broker = enchant_broker_init();

        enchant_broker_set_dict_path($this->broker, ENCHANT_MYSPELL, $this->path);
    }

    /**
     * @param string $tag
     * @param string $search
     * @return array|false
     */
    public function getSuggestions(string $tag, string $search)
    {
        if (enchant_broker_dict_exists($this->broker, $tag)) {
            $dict = enchant_broker_request_dict($this->broker, $tag);

            return enchant_dict_suggest($dict, $search);
        }
        return false;
    }

    /**
     * @param string $pwl
     * @param string $search
     * @return array
     */
    public function getSuggestionsFromPwl(string $pwl, string $search)
    {
        $file = $this->path . '/' . $pwl;
        $dict = enchant_broker_request_pwl_dict($this->broker, $file);

        return enchant_dict_suggest($dict, $search);
    }

    /**
     * @param string $pwl
     * @param string $word
     * @return bool
     */
    public function addWord(string $pwl, string $word)
    {
        $file = $this->path . '/' . $pwl;
        $dict = enchant_broker_request_pwl_dict($this->broker, $file);

        if (!empty($word) && !enchant_dict_check($dict, $word)) {
            try {
                enchant_dict_add_to_personal($dict, $word);
            } catch (Exception $e) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $pwl
     * @param string $word
     * @return false|int
     */
    public function removeWord(string $pwl, string $word)
    {
        $file = $this->path . '/' . $pwl;

        $contents = file_get_contents($file);
        $contents = str_replace(PHP_EOL . $word, null, $contents);

        return file_put_contents($file, $contents);
    }

    /**
     * @param string $pwl
     * @return bool
     */
    public function removePwl(string $pwl)
    {
        $file = $this->path . '/' . $pwl;

        return file_exists($file) && unlink($file);
    }

    public function __destruct()
    {
        enchant_broker_free($this->broker);
    }
}
