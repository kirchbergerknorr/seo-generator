<?php

/**
 * attribute   - {{atribute_name}}
 * options     - [[options]]
 * min/max     - ((min, max, avg))
 * limit words - ||a||
 */

class Kirchbergerknorr_SeoGenerator_Helper_Type_Attribute extends Mage_Core_Helper_Abstract
{
    protected $_resultMatchAttribute;

    public function matchAttribute($rules)
    {
        $pattern = '/{{(.+?)}}/i';
        if (sizeof(preg_match_all($pattern, $rules, $matchAttribute)) > 0) {
            $this->_resultMatchAttribute = $matchAttribute;
            return $matchAttribute;
        } else {
            return false;
        }
    }

    public function getArrayValueAttributeModel($_product)
    {
        $valuesArr = array();

        $matchAttribute = $this->getResultMatchAttribute();

        foreach ($matchAttribute[1] as $key => $attribute):
            if (preg_match('/\|\|(.+?)\|\|/', $attribute, $countWord) > 0) {
                $attribute = preg_replace('/\|\|(.+)\|\|/', '', $attribute);
            }


            //replace text
            if (preg_match('/\#(.+?)\#/i', $attribute, $replace) > 0) {
                $attribute = preg_replace('/\#(.+?)\#/i', '', $attribute);
            }

            $count = isset($countWord[1]) ? $countWord[1] : 0;
            $replaceStr = isset($replace[1]) ? $replace[1] : '';

            $attributeValue = $this->getValueAttributeFromModel($_product, $attribute, $count, $replaceStr);

            if (strlen($attributeValue) > 0) {
                $valuesArr[] = $attributeValue;
            } else {
                $valuesArr[] = ''; //'ERROR ATTRIBUTE '. $attribute;
            }
        endforeach;

        return $valuesArr;
    }

    //creating a template for the substitution of attributes in the rules
    public function createPatternAttribute()
    {
        $matchAttributes = $this->getResultMatchAttribute();
        $pattern = array();
        foreach ($matchAttributes[0] as $attr) {
            $attr = preg_replace('/\|/', '\|', $attr);
            $pattern[] = '/' . $attr . '/';
        }
        return $pattern;
    }

    public function getValueAttributeFromModel($product, $attribute, $countWord = 0, $replaceStr = '')
    {
        $attributeCollection = $product->getResource()->getAttribute($attribute);
        $res = '';
        if ($attributeCollection) {
            $attributeValue = $attributeCollection->getFrontend()->getValue($product);
            if (strlen($attributeValue) > 0) {
                if ($countWord > 0) {
                    $pattern = '/([^\s]+\s){' . $countWord . '}/i';
                    preg_match_all($pattern, $attributeValue, $expAttr);
                    $attributeValue = isset($expAttr[0][0]) ? trim($expAttr[0][0]) : '';
                }

                if (strlen($replaceStr) > 0) {
                    $explodeReplace = explode('->', $replaceStr);
                    $attributeValue = str_replace($explodeReplace[0], $explodeReplace[1], $attributeValue);
                }
            } else {
                return false;
            }
            return $attributeValue;
        }

    }

    //replacement code attribute with its value
    public function replaceAttributeInRules($rules, $_product)
    {
        $arrValueAttribute = $this->getArrayValueAttributeModel($_product);
        $pattern = $this->createPatternAttribute();
        $str = preg_replace($pattern, $arrValueAttribute, $rules);
        return $str;
    }


    public function getResultMatchAttribute()
    {
        return $this->_resultMatchAttribute;
    }

    private function setResultMatchAttribute($resultParseAttribute)
    {
        $this->_resultMatchAttribute = $resultParseAttribute;
    }
}