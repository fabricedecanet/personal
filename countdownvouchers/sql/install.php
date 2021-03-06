<?php
/**
* 2007-2017 Global Dynamics Technologies
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@gdt-core.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade Global Dynamics Technologies to newer
* versions in the future. If you wish to customize Global Dynamics Technologies for your
* needs please refer to http://www.gdt-core.com for more information.
*
*  @author    GDT <contact@gdt-core.com>
*  @copyright 2007-2017 GDT
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of GDT
*/

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'countdownlist` (
    `id_countdownlist` int(11) NOT NULL AUTO_INCREMENT,
    `id_product` int(11) NOT NULL,
    `name` VARCHAR (50) NOT NULL,
    `id_customer` int(11) NOT NULL,
    `id_shop` int(11) NOT NULL,
    `mail_check` int(1) NOT NULL,
    `mail_send` int(1) NOT NULL DEFAULT 0,
    PRIMARY KEY  (`id_countdownlist`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
