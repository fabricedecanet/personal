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

class CountDownVouchersClass extends ObjectModel
{
    public static function findProductName($product_id, $shop_id)
    {
        $query = 'SELECT DISTINCT `name` '
                . 'FROM `'._DB_PREFIX_.'product_lang` '
                . 'WHERE `id_product` = '.(int)$product_id.' AND `id_shop`='.(int)$shop_id;
        $reponse = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
        return $reponse;
    }
    
    public static function insertProductAlert($product_id, $name, $id_customer, $shop_id, $mail_check)
    {
        $query = 'INSERT INTO `'._DB_PREFIX_.'countdownlist`'
                .'(`id_product`, `name`, `id_customer`, `id_shop`, `mail_check`)'
                . 'VALUES ('.(int)$product_id.', "'.$name.'",'
                . ' '.(int)$id_customer.', '.(int)$shop_id.', '.(int)$mail_check.')';
        $reponse = Db::getInstance()->execute($query);
        return $reponse;
    }
    
    public static function updateProductAlert($product_id, $mail_send, $id_customer)
    {
        $query = 'UPDATE  `'._DB_PREFIX_.'countdownlist` '
            . 'SET `mail_send`='.(int)$mail_send
            .' WHERE  `id_product`='.(int)$product_id.' '
            . 'AND `id_customer`='.(int)$id_customer;
        $reponse = Db::getInstance()->execute($query);
        return $reponse;
    }
    
    public static function selectProductAlert($id_customer, $product_id = null, $shop_id = null)
    {
        $query = 'SELECT DISTINCT * FROM `'._DB_PREFIX_.'countdownlist` '
            .' WHERE  `id_customer`='.(int)$id_customer.' '
            .($shop_id ? ' AND `id_shop` = '.(int)$shop_id : '')
            .($product_id ? ' AND `id_product` = '.(int)$product_id : '');
        $reponse = Db::getInstance()->executeS($query);
        return $reponse;
    }
    
    public static function selectProduct($id_customer, $mail_send)
    {
        $query = 'SELECT DISTINCT * FROM `'._DB_PREFIX_.'countdownlist` '
            .' WHERE  `id_customer`='.(int)$id_customer.' AND `mail_send` = '.(int)$mail_send;
        $reponse = Db::getInstance()->executeS($query);
        return $reponse;
    }
    
    public static function deleteProductAlert($product_id, $shop_id, $id_customer)
    {
        $query = 'DELETE FROM `'._DB_PREFIX_.'countdownlist` '
            .' WHERE  `id_product`='.(int)$product_id.' '
            . 'AND `id_shop`='.(int)$shop_id.' AND `id_customer`='.(int)$id_customer;
        $reponse = Db::getInstance()->execute($query);
        return $reponse;
    }
}
