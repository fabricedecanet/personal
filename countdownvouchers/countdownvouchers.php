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

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__).'/classes/countDownVouchersClass.php';

class CountdownVouchers extends Module
{
    protected $config_form = false;

    public function __construct()
    {
            $this->name = 'countdownvouchers';
            $this->tab = 'front_office_features';
            $this->version = '1.0.0';
            $this->author = 'GDT';
            $this->need_instance = 0;

            /**
             * Set $this->bootstrap to true if your module is compliant with bootstrap (Global Dynamics Technologies 1.6)
             */
            $this->bootstrap = true;

            parent::__construct();

            $this->displayName = $this->l('Count down for vouchers');
            $this->description = $this->l(
                'This module helps you to view a Count down front office for a product promotion and
                configure alerts promotions for your customers'
            );

            $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
    }

    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        if (!parent::install() ||
            !$this->registerHook('header') ||
            !$this->registerHook('displayProductPriceBlock') ||
            !$this->registerHook('displayCustomerAccount') ||
            !$this->registerHook('displayFooterProduct') ||
            !$this->registerHook('displayRightColumnProduct') ||
            !Configuration::updateValue('GDT_COUNTDOWNS', 1) ||
            !Configuration::updateValue('GDT_PROMOTIONS', 1) ||
            !Configuration::updateValue('GDT_ALERT_PROMOTION', 1)
        ) {
            return false;
        }
        return true;
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');
        if (!parent::uninstall() ||
            !Configuration::deleteByName('GDT_ALERT_PROMOTION') ||
            !Configuration::deleteByName('GDT_COUNTDOWNS') ||
            !Configuration::deleteByName('GDT_PROMOTIONS')) {
            return false;
        }
        return true;
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $this->context->controller->addJS($this->_path.'views/js/countdownvouchers.js');
        $this->context->controller->addCSS($this->_path.'views/css/back.css');
//        $this->sendMail();
        $date = date("Y-m-d H:i:s");
        $dates = strtotime($date);
        $this->context->smarty->assign(array(
            'current_date' => $dates,
            'id_shop'=> $this->context->shop->id,
            'countdowns_params'=>Configuration::get('GDT_COUNTDOWNS'),
            'promotions_params'=>Configuration::get('GDT_PROMOTIONS'),
            'alert_params'=>Configuration::get('GDT_ALERT_PROMOTION'),
            'modToken'=> Tools::getAdminTokenLite('AdminModules'),
            'localLink'=> $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.
            '&tab_module='.$this->tab.
            '&module_name='.$this->name,
            'link_guide'=>'modules/countdownvouchers/',
            'url' => _PS_BASE_URL_.__PS_BASE_URI__,
            'modToken'=> Tools::getAdminTokenLite('AdminModules')
        ));
 
        return $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    public function ajaxProcessSaveParam()
    {
        $countdown_params = Tools::getValue('showcountdown');
        $promotion_params = Tools::getValue('promotion');
        $alert_params = Tools::getValue('alert');
        if (isset($countdown_params) && isset($promotion_params) && isset($alert_params)) {
            $countdown_params = Configuration::updateValue('GDT_COUNTDOWNS', $countdown_params);
            $promotion_params = Configuration::updateValue('GDT_PROMOTIONS', $promotion_params);
            $alert_params = Configuration::updateValue('GDT_ALERT_PROMOTION', $alert_params);
        }
        die(Tools::jsonEncode($countdown_params, $promotion_params, $alert_params));
    }

    public function hookHeader()
    {
            $this->context->controller->addJS($this->_path.'/views/js/front.js');
            $this->context->controller->addJS($this->_path.'/views/js/jquery.countdown.js');
            $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    /*
     * show the counter in FO
     */
    public function hookDisplayProductPriceBlock($params)
    {
        
        $specificprice = array();
        $countdown = true;
        $view_countdown = Configuration::get('GDT_COUNTDOWNS');
        
        if (isset($params['product']) && $view_countdown == 1) {
            $product = $params['product'];

            foreach ($product as $key => $value) {
                if ($key == 'specificPrice' || $key == 'specific_prices') {
                    $specificprice[] = $value;
                }
            }

            if ($specificprice) {
                $price_to = $specificprice[0]['to'];
                if ($specificprice[0]['to'] == null) {
                    $countdown = false;
                }
                if ($params['type'] == 'price' &&
                    $countdown &&
                    $view_countdown == '1' &&
                    $price_to != '0000-00-00 00:00:00'
                    ) {
                    $this->context->smarty->assign(array(
                        'pid' => is_array($product) ? $product["id_product"] : $product->id,
                        'time' => $specificprice[0]['to'],
                        'unlimited' => false,
                    ));
                    return $this->display(__FILE__, 'views/templates/hook/counter.tpl');
                } elseif ($params['type'] == 'price' &&
                    $countdown &&
                    $view_countdown == '1' &&
                    $price_to == '0000-00-00 00:00:00'
                ) {
                    $this->context->smarty->assign(array(
                        'pid' => is_array($product) ? $product["id_product"] : $product->id,
                        'time' => $specificprice[0]['to'],
                        'unlimited' => true,
                    ));
                    return $this->display(__FILE__, 'views/templates/hook/counter.tpl');
                }
            }
        }
    }

    /*
     * show alert button
     */
    public function hookDisplayRightColumnProduct($params)
    {
        $date = date("Y-m-d H:i:s");
        $dates = strtotime($date);
        $alert_params = Configuration::get('GDT_ALERT_PROMOTION');
        $id_product = Tools::getValue('id_product');
        $id_customer = $params['cart']->id_customer;
        $id_shop = $params['cart']->id_shop;
        $date_promo = array();
        $next_promo = Configuration::get('GDT_PROMOTIONS');

        if ((int)$next_promo == 1) {
            $query = 'SELECT `id_product`, `id_shop`, `from`,`reduction_type`,`reduction` ,`to`'
                . 'FROM `'._DB_PREFIX_.'specific_price` WHERE'
                . ' `id_product`='.$id_product;
            $promotionlist = Db::getInstance()->executeS($query);
            $date_promo = array();
            foreach ($promotionlist as $key => $value) {
                $value = $value;
                $date_start_promo = strtotime($promotionlist[$key]['from']);
                if ($promotionlist[$key]['reduction_type'] == 'percentage') {
                    $reduction = $promotionlist[$key]['reduction'] * 100;
                } else {
                    $reduction = $promotionlist[$key]['reduction'];
                }
                if (($date_start_promo - $dates) > 0) {
                    $date_promo[] = array(
                        'date_from'=>$promotionlist[$key]['from'],
                        'date_to'=>$promotionlist[$key]['to'],
                        'reduction_type'=>$promotionlist[$key]['reduction_type'],
                        'reduction'=>$reduction);
                }
            }

            if ($promotionlist != null) {
                $this->context->smarty->assign(array(
                        'promotionlist' => $date_promo,
                        'list_promo' => 1,
                    ));
            }
        }
        if ($this->context->customer->isLogged() && $alert_params == 1) {
            $verif_alert = CountDownVouchersClass::selectProductAlert($id_customer, $id_product, $id_shop);
            if ($verif_alert) {
                $mail_check = $verif_alert[0]['mail_check'];
            }
            $this->context->smarty->assign(array(
                'id_product' => $id_product,
                'id_customer' => $id_customer,
                'id_shop' => $id_shop,
                'alert' => 1,
                'verif_alert' => $verif_alert ? (int)$mail_check : '',
            ));
        }
        if (_PS_VERSION_ < '1.7') {
            return $this->display(__FILE__, 'views/templates/hook/select_promotion.tpl');
        }
    }
    public function hookDisplayFooterProduct($params)
    {
        if (_PS_VERSION_ >= '1.7') {
            $date = date("Y-m-d H:i:s");
            $dates = strtotime($date);
            $alert_params = Configuration::get('GDT_ALERT_PROMOTION');
            $id_product = Tools::getValue('id_product');
            $id_customer = $params['cart']->id_customer;
            $id_shop = $params['cart']->id_shop;
            $date_promo = array();
            $next_promo = Configuration::get('GDT_PROMOTIONS');
            if ((int)$next_promo == 1) {
                $query = 'SELECT `id_product`, `id_shop`, `from`,`reduction_type`,`reduction` ,`to`'
                    . 'FROM `'._DB_PREFIX_.'specific_price` WHERE'
                    . ' `id_product`='.$id_product;
                $promotionlist = Db::getInstance()->executeS($query);
                $date_promo = array();
                foreach ($promotionlist as $key => $value) {
                    $value = $value;
                    $date_start_promo = strtotime($promotionlist[$key]['from']);
                    if ($promotionlist[$key]['reduction_type'] == 'percentage') {
                        $reduction = $promotionlist[$key]['reduction'] * 100;
                    } else {
                        $reduction = $promotionlist[$key]['reduction'];
                    }
                    if (($date_start_promo - $dates) > 0) {
                        $date_promo[] = array(
                            'date_from'=>$promotionlist[$key]['from'],
                            'date_to'=>$promotionlist[$key]['to'],
                            'reduction_type'=>$promotionlist[$key]['reduction_type'],
                            'reduction'=>round($reduction, 2));
                    }
                }

                if ($promotionlist != null) {
                    $this->context->smarty->assign(array(
                        'promotionlist' => $date_promo,
                        'list_promo' => 1,
                    ));
                }
            }
 
            if ($this->context->customer->isLogged() && $alert_params == 1) {
                $verif_alert = CountDownVouchersClass::selectProductAlert($id_customer, $id_product, $id_shop);

                if ($verif_alert) {
                    $mail_check = $verif_alert[0]['mail_check'];
                }
                $this->context->smarty->assign(array(
                    'id_product' => $id_product,
                    'id_customer' => $id_customer,
                    'id_shop' => $id_shop,
                    'alert' => 1,
                    'verif_alert' => $verif_alert ? (int)$mail_check : '',
                ));
            }
        }
        return $this->display(__FILE__, 'views/templates/hook/version17/select_promotion.tpl');
    }

    /*
     * show alert list
     */
    public function hookDisplayCustomerAccount($params)
    {
        $alert_params = Configuration::get('GDT_ALERT_PROMOTION');
        $this->context->smarty->assign(array(
            'id_customer' => $params['cart']->id_customer,
            'alert_params' => $alert_params,
        ));
        if (_PS_VERSION_ < '1.7') {
            return $this->display(__FILE__, 'views/templates/hook/alert_product_list.tpl');
        } else {
            return $this->display(__FILE__, 'views/templates/hook/version17/alert_product_list.tpl');
        }
    }
    
    public function sendMail()
    {
        $users = CustomerCore::getCustomers(true);
        $mail = '';
        foreach ($users as $user) {
            $product = CountDownVouchersClass::selectProduct($user['id_customer'], 0);
            if ($product) {
                $link = new LinkCore();
                $product_link = '';
                foreach ($product as $value) {
                    $product_link .= '<a href="'.$link->getProductLink($value['id_product']).'" target="_blank">'
                                .$value['name'].'</a> <br>';
                }
                $mail = MailCore::Send(
                    $this->context->language->id,
                    'send_mail',
                    Mail::l('Welcome!'),
                    array(
                        '{firstname}' => $user['firstname'],
                        '{lastname}' => $user['lastname'],
                        '{email}' => $user['email'],
                        '{shop_name}' => Configuration::get('PS_SHOP_NAME'),
                        '{product_link}' => $product_link,
                    ),
                    $user['email'],
                    $user['lastname'] ? $user['firstname'] : ''
                    .' '
                    .$user['lastname'] ? $user['lastname'] : '',
                    null,
                    null,
                    null,
                    null,
                    dirname(__FILE__).'/mails/'
                );
                if ($mail) {
                    foreach ($product as $values) {
                        CountDownVouchersClass::updateProductAlert(
                            $values['id_product'],
                            $mail,
                            $values['id_customer']
                        );
                    }
                }
            }
        }
        if ($mail) {
            echo 'mails send';
        } elseif (!$product) {
            echo 'no products to send for promtion';
        }
        die;
    }
}
