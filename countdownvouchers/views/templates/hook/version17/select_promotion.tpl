{*
* 2007-2017 PrestaShop
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
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{if isset($list_promo) AND ($list_promo eq 1) AND $promotionlist}
    <section class="page-product-box">
            <h5 class="page-product-heading">{l s='FUTUR PROMOTIONS OF THIS PRODUCT' mod='countdownvouchers'}</h5>
            <table class="table-responsive-row table-bordered col-lg-12">
                <thead>
                    <tr>
                        <th><b>{l s='Reduction' mod='countdownvouchers'}</b></th>
                        <th><b>{l s='Date Start' mod='countdownvouchers'}</b></th>
                        <th><b>{l s='Date End' mod='countdownvouchers'}</b></th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$promotionlist item=list_promo}
                        <tr>
                            <td><b>{if $list_promo.reduction_type == 'percentage'}{$list_promo.reduction|escape:'htmlall':'UTF-8'}{l s='%' mod='countdownvouchers'}{else}{$list_promo.reduction}{$currency.sign}{/if}</b></td>
                            <td><b>{$list_promo.date_from|escape:'htmlall':'UTF-8'}</b></td>
                            <td><b>{$list_promo.date_to|escape:'htmlall':'UTF-8'}</b></td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
    </section>
{/if}
{if isset($alert) AND ($alert eq 1)}
    <p class="checkbox addressesAreEquals">
        <label for="contact_promotion">
            <input type="checkbox" name="contact_promotion" id="contact_promo" {if isset($verif_alert) AND ($verif_alert eq 1)}checked='checked'{/if}value="" data-id_product="{$id_product|intval}" data-id_customer="{$id_customer|intval}" data-id_shop="{$id_shop|intval}">
            {l s='Contact me for promotion' mod='countdownvouchers'}
        </label>
    </p>
{/if}