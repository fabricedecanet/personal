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

<script>
	var localLink = '{html_entity_decode($localLink|escape:'htmlall':'UTF-8')}';
	var localtoken = '{$modToken|escape:'htmlall':'UTF-8'}';
    var errormail = "{l s='Your email was not sent!' mod='countdownvouchers'}";
    var succesmail = "{l s='Your email was sent!' mod='countdownvouchers'}";
    var mailsended = "{l s='All your customers have already been contact!' mod='countdownvouchers'}";
    var errorparams = "{l s='Backup faild!' mod='countdownvouchers'}";
    var succesparams = "{l s='Backup completed!' mod='countdownvouchers'}";
</script>
<div class="panel">
    <div class="panel-heading">
        <i class="icon icon-cogs"></i> {l s='Settings' mod='countdownvouchers'}
    </div>
    <div class="panel-body">
        <div class="row">
            <form novalidate="" method="POST" action="#" class="defaultForm  form-horizontal" id="send-params">
                <div class="form-wrapper">
                    <div class="form-group">
                       <label class="control-label col-lg-3">
                           {l s='Show the Countdown' mod='countdownvouchers'}
                       </label>
                       <div class="col-lg-9">
                               <span class="switch prestashop-switch fixed-width-lg">
                                   <input type="radio" name="showcountdown" {if isset($countdowns_params) AND $countdowns_params == '1'}checked{elseif !isset($countdowns_params)}checked{/if} id="showcountdown_on" value="1">
                                   <label for="showcountdown_on">{l s='Yes' mod='countdownvouchers'}</label>
                                   <input type="radio" name="showcountdown" {if isset($countdowns_params) AND $countdowns_params == '0'}checked{/if} id="showcountdown_off" value="0">
                                   <label for="showcountdown_off">{l s='No' mod='countdownvouchers'}</label>
                                   <a class="slide-button btn"></a>
                               </span>
                       </div>
                   </div>
                    <div class="form-group">
                       <label class="control-label col-lg-3">
                           {l s='Show next product promotion ' mod='countdownvouchers'}
                       </label>
                       <div class="col-lg-9">
                           <span class="switch prestashop-switch fixed-width-lg">
                               <input type="radio" name="promotion" {if isset($promotions_params) AND $promotions_params == '1'}checked{elseif !isset($promotions_params)}checked{/if} id="promotion_on" value="1">
                               <label for="promotion_on">{l s='Yes' mod='countdownvouchers'}</label>
                               <input type="radio" name="promotion" {if isset($promotions_params) AND $promotions_params == '0'}checked{/if} id="promotion_off" value="0">
                               <label for="promotion_off">{l s='No' mod='countdownvouchers'}</label>
                               <a class="slide-button btn"></a>
                           </span>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="control-label col-lg-3">
                           {l s='Show customer alert list product promotions' mod='countdownvouchers'}
                       </label>
                       <div class="col-lg-9">
                           <span class="switch prestashop-switch fixed-width-lg">
                               <input type="radio" name="alert_promotion" {if isset($alert_params) AND $alert_params == '1'}checked{elseif !isset($alert_params)}checked{/if} id="alert_promotion_on" value="1">
                               <label for="alert_promotion_on">{l s='Yes' mod='countdownvouchers'}</label>
                               <input type="radio" name="alert_promotion" {if isset($alert_params) AND $alert_params == '0'}checked{/if} id="alert_promotion_off" value="0">
                               <label for="alert_promotion_off">{l s='No' mod='countdownvouchers'}</label>
                               <a class="slide-button btn"></a>
                           </span>
                       </div>
                    </div>
                </div>
            </form>
        </div>
        <p><span>{l s='link to use for sending emails as cron task:' mod='countdownvouchers'}</span><br>
        <span><b>&nbsp;{$url|escape:'htmlall':'UTF-8'}{$link_guide|escape:'htmlall':'UTF-8'}{l s='sendMail.php' mod='countdownvouchers'}</b></span></p>
    </div>
    <div class="panel-footer">
        <button type="submit" value="1" id="params_submit" name="Addconfiguration" class="btn btn-default pull-right">
                <i class="process-icon-save"></i> {l s='Save' mod='countdownvouchers'}
        </button>
    </div>
</div>