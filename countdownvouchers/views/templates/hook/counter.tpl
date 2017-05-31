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


{if $unlimited}
<div class="action-buttons" >
    <p id="counter" style="margin-left: 0%;width: auto;text-align: center;">&nbsp;{l s='unlimited vouchers' mod='countdownvouchers'}</p>
</div>
{else}
    <div class="action-buttons countdown{$pid|escape:'htmlall':'UTF-8'}" data-countdown="{$time|escape:'htmlall':'UTF-8'}">
        
    </div>
    <script type="text/javascript">
        $('.countdown{$pid}').each(function(){
            var meobj = $(this);
            meobj.countdown(meobj.data('countdown'), function(event) {
                meobj.html(event.strftime('<p id="counter">{l s='You still have:' mod='countdownvouchers'}  <br /> %D {l s='Days' mod='countdownvouchers'} %HH:%MM:%SS</p>'));
            })
        });
        
    </script>
{/if}