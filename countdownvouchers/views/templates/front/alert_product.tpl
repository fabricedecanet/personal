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

<div class="panel-vouchers text-center"  id="alerte_liste" style="text-align: center;">
    <h5 class="text-center">{l s='My promotions alerts' mod='countdownvouchers'}</h5>
    <ul class="list-group">
        <li class="list-group-item">
            <ul>
                {if products}
                    {foreach from=$products item=product}
                         <ol style="color:blue; font-size: 15px;"><a href="{$pdtlink[$product.id_product]}" target="_blank"> {$product.name|escape:'htmlall':'UTF-8'}</a></ol>
                    {/foreach}
                {else}
                    {l s='You have not selected any products for your promotions alerts' mod='countdownvouchers'}
                {/if}
            </ul>
        </li>
    </ul>
</div>

