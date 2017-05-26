<?php
/**
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2016 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

require_once(dirname(__FILE__) . '/../../classes/countDownVouchersClass.php');
class CountdownvouchersCounterdownModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        
        $alert_params = Configuration::get('GDT_ALERT_PROMOTION');
        if ($alert_params == 1) {
            $product = CountDownVouchersClass::selectProductAlert(Tools::getValue('customer_id'));
            $link = new LinkCore();
            $product_link = array();
            foreach ($product as $value) {
                if(_PS_VERSION_ < '1.7'){
                    $product_link[$value['id_product']] = $link->getProductLink($value['id_product']);
                }else{
                    $pdt = new ProductCore((int)$value['id_product']) ;
                    $cat = new CategoryCore((int)$pdt->id_category_default);
                    $tab_ipa = $pdt->getProductAttributesIds((int)$value['id_product']);
                    $product_link[$value['id_product']] = $link->getProductLink((int)$value['id_product'], $pdt->link_rewrite[$this->context->language->id], $cat->link_rewrite[$this->context->language->id], $pdt->ean13, null, null, (int)$tab_ipa[0]['id_product_attribute']);
                }
            }
            $this->context->smarty->assign(array(
                'products' => $product,
                'pdtlink' => $product_link,
            ));
        }
        if(_PS_VERSION_ < '1.7'){
            return $this->setTemplate('alert_product.tpl');
        }else{
            $this->setTemplate('module:countdownvouchers/views/templates/front/version17/alert_product.tpl');
        }
    }
    
    public function displayAjaxdefault()
    {
        $select_val = Tools::getValue('contact_promo');
        $id_product = Tools::getValue('productId');
        $shop_id = Tools::getValue('shop_id');
        $customer_id = Tools::getValue('customer_id');

        $name_product = countDownVouchersClass::findProductName($id_product, $shop_id);
        $name = $name_product[0]['name'];
        $verif_alert = countDownVouchersClass::selectProductAlert($customer_id, $id_product, $shop_id);
        if (!$verif_alert) {
            $mail_check = ($select_val === 'false') ? 0 : 1;
            $rep = countDownVouchersClass::insertProductAlert($id_product, $name, $customer_id, $shop_id, $mail_check);

        } else {
            $rep = countDownVouchersClass::deleteProductAlert($id_product, $shop_id, $customer_id);
        }
        echo $rep;
    }
}
