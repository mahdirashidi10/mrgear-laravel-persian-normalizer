<?php

namespace MRGear\PersianNormalizer;

use Illuminate\Support\Facades\Config;

class NormalizerManager
{
    /**
     * Normalize Persian text.
     *
     * @param string $value
     * @param string|null $inputName
     * @param array $excepts
     * @return string|null
     */
    public function normalize($value, $inputName = null, $excepts = [])
    {
        // Load configuration from config file
        $config = Config::get('mrgear-persian-normalizer');

        // If value is not "0" and not an uploaded file
        if ($value != "0") {
            if (!empty($value)) {
                if (!($value instanceof \Illuminate\Http\UploadedFile)) {
                    // Merge exceptions from config
                    $excepts = array_merge($excepts, $config['excepts']);

                    // Normalize numbers and special characters
                    if (!in_array($inputName, $excepts) && !is_array($value)) {
                        $value = $this->convertNumber(trim(preg_replace('!\s+!', ' ', $value)));
                        $value = str_replace('ي', 'ی', $value);
                        $value = str_replace('ك', 'ک', $value);
                        $value = $this->fixCommonMistakes($value);

                        if ($value == 'true' || $value == 'false') {
                            $value = $value == 'true' ? 1 : 0;
                        }

                        // If field is in 'lowercase' array, convert to lowercase
                        if (in_array($inputName, $config['lowercase'])) {
                            $value = strtolower($value);
                        }
                    }
                }
            } else {
                $value = null;
            }
        }

        return $value;
    }

    /**
     * Convert Persian and Arabic numbers to English.
     *
     * @param string $string
     * @return string
     */
    public function convertNumber($string)
    {
        $farsi_array = ['۰', '٠', '۱', '١', '۲', '٢', '۳', '٣', '۴', '٤', '۵', '٥', '۶', '۶', '۷', '۷', '۸', '۸', '۹', '٩'];
        $english_array = ['0', '0', '1', '1', '2', '2', '3', '3', '4', '4', '5', '5', '6', '6', '7', '7', '8', '8', '9', '9'];

        return str_replace($farsi_array, $english_array, $string);
    }

    /**
     * Fix common typing mistakes.
     *
     * @param string $text
     * @return string
     */
    private function fixCommonMistakes($text)
    {
        $mistakes = [
            'ه ی' => 'ه‌ی',  // Fix non-breaking space
            'می ' => 'می‌',
            'است ' => 'است‌',
        ];

        return strtr($text, $mistakes);
    }

    /**
     * Normalize all input fields.
     *
     * @param array $inputs
     * @param array $excepts
     * @return array
     */
    public function normalizeAll($inputs, $excepts = [])
    {
        foreach ($inputs as $inputName => $inputValue) {
            $inputs[$inputName] = $this->normalize($inputValue, $inputName, $excepts);
            // If password is empty, remove it
            if ($inputName === 'password' && empty($inputs[$inputName])) {
                unset($inputs[$inputName]);
            }
        }

        return $inputs;
    }
}
