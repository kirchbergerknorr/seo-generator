<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category Kirchbergerknorr
 * @package Kirchbergerknorr_SeoGenerator
 * @copyright Copyright (c) 2011 Kirchbergerknorr
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
$installer = $this;

$installer->startSetup();

$installer->run("
CREATE TABLE {$this->getTable('Kirchbergerknorr_rulesmetatag')} (
     `rules_id` int(12) NOT NULL AUTO_INCREMENT,
     `category_id` int(12) DEFAULT NULL,
     `rules_title` text,
     `rules_description` text,
     `rules_keywords` text,
     `store_id` int(12) DEFAULT NULL,
     `rules_active` int(1) DEFAULT '1',
     PRIMARY KEY (`rules_id`)
   ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
");

$installer->endSetup();