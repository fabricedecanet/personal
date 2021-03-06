{*
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
*}
{extends file='page.tpl'}
{block name='page_content'}
    <div class="panel-vouchers text-center"  id="alerte_liste" style="text-align: center;">
        <h5 class="text-center">{l s='My promotions alerts' mod='countdownvouchers'}</h5>
        <ul class="list-group">
            <li class="list-group-item">
                <ul>
                    {if $show_alert_list eq 1}
                        {if $products}
                            {foreach from=$products item=product}
                                 <ol style="color:blue; font-size: 15px;"><a href="{$pdtlink[$product.id_product]|escape:'htmlall':'UTF-8'}" target="_blank"> {$product.name|escape:'htmlall':'UTF-8'}</a></ol>
                            {/foreach}
                        {else}
                            {l s='You have not selected any products for your promotions alerts' mod='countdownvouchers'}
                        {/if}
                    {else}
                        {l s='Please contact the administrator for the configuration of the list of alerts promotions' mod='countdownvouchers'}
                    {/if}
                </ul>
            </li>
        </ul>
    </div>
{/block}

