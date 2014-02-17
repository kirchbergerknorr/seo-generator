<?php

class Kirchbergerknorr_SeoGenerator_Helper_Type_Options extends Mage_Core_Helper_Abstract
{
    protected $_resultMatchOptions;

    public function replaceOptionsInRules($rules, $_product)
    {
        $replacement = $this->getReplacement($rules, $_product);
        $pattern = $this->createPatternOptions();
        $str = preg_replace($pattern, $replacement, $rules);
        return $str;

    }

    //creating a template for the substitution of options in the rules
    public function createPatternOptions()
    {
        $options = $this->getResultMatchOptions();
        $pattern = array();
        foreach ($options[0] as $attr) {
            $attr = preg_replace('/\[/', '\[', $attr);
            $attr = preg_replace('/\(/', '\(', $attr);
            $attr = preg_replace('/\]/', '\]', $attr);
            $attr = preg_replace('/\)/', '\)', $attr);
            $pattern[] = '/' . $attr . '/';
        }
        return $pattern;
    }


    public function getReplacement($rules, $_product)
    {
        $matchOptions = $this->matchOptions($rules);
        $optionsFromModel = $this->getOptionsFromModel($_product);
        $valuesArr = array();
        $find = false;

        foreach ($matchOptions[1] as $matchOption):
            $option = preg_replace('/\(\((.+)\)\)/', '', $matchOption);
            $param = $this->getParam($matchOption);
            $position = 0;

            $replace = $this->getReplacePattern($option);

            if ($replace) {
                $option = preg_replace('/\#(.+)\#/', '', $option);
            }

            //param position
            if (is_numeric($param)) {
                $position = $param - 1;
                $param = 'position';
            }

            foreach ($optionsFromModel as $opt) {
                if ($opt['title'] == $option) {
                    $find = true;
                    switch ($param) {
                        case 'minceil':
                            $value = $opt['values'][0];
                            $value = floor($value);
                            if ($value == 0) {
                                $value = ceil($opt['values'][0]);
                            }
                            break;
                        case 'maxceil':
                            $value = $opt['values'][sizeof($opt['values']) - 1];
                            $value = floor($value);
                            if ($value == 0) {
                                $value = ceil($opt['values'][sizeof($opt['values']) - 1]);
                            }
                            break;
                        case 'minfloat':
                            $value = $opt['values'][0];
                            $value = floatval($value);
                            break;
                        case 'maxfloat':
                            $value = $opt['values'][sizeof($opt['values']) - 1];
                            $value = floatval($value);
                            break;
                        case 'min':
                            $value = $opt['values'][0];
                            break;
                        case 'max':
                            $value = $opt['values'][sizeof($opt['values']) - 1];
                            break;
                        case 'rand':
                            $value = $opt['values'][rand(1, sizeof($opt['values']) - 1)];
                            break;
                        case 'position':
                            isset($opt['values'][$position]) ? $value = $opt['values'][$position] : $value = '';
                            break;
                        default:
                            $value = '';
                    }
                    //replace text in option
                    if ($replace) {
                        $valuesArr[] = str_replace($replace[0], $replace[1], $value);
                    } else {
                        $valuesArr[] = $value;

                    }
                }
            }
            if (!$find) {
                $valuesArr[] = '';
            }
            $find = false;

        endforeach;
        return $valuesArr;
    }


    public function getParam($option)
    {
        $param = array();
        if (preg_match('/\(\((.+?)\)\)/', $option, $param) > 0) {
            return $param[1];
        } else {
            return false;
        }
    }

    public function getReplacePattern($option)
    {
        $param = array();
        if (preg_match('/\#(.+?)\#/i', $option, $param) > 0) {
            $exp = explode('->', $param[1]);
            return $exp;
        } else {
            return false;
        }
    }

    public function matchOptions($rules)
    {
        $pattern = '/\[\[(.+?)\]\]/i';
        if (sizeof(preg_match_all($pattern, $rules, $matchOptions)) > 0) {
            $this->_resultMatchOptions = $matchOptions;
            return $matchOptions;
        } else {
            return false;
        }
    }

    public function getOptionsFromModel($product)
    {
        $attVal = $product->getOptions();
        $arrOptions = array();

        if (sizeof($attVal)) {
            foreach ($attVal as $optionVal) {
                $titleOption = $optionVal->getTitle();
                foreach ($optionVal->getValues() as $valuesKey => $valuesVal) {
                    $arrayValue[] = $valuesVal->getTitle();
                }
                $arrOptions[] = array(
                    'title' => trim($titleOption),
                    'values' => $arrayValue
                );
                $arrayValue = array();
            }
        }

        return $arrOptions;
    }

    public function getResultMatchOptions()
    {
        return $this->_resultMatchOptions;
    }

    private function setResultMatchOptions($resultParseOptions)
    {
        $this->_resultMatchOptions = $resultParseOptions;
    }
}