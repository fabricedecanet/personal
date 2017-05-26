/**
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
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

$(document).ready(function() {
    $("#contact_promo").on('change', function(){
            $.ajax({
            type: 'POST',
            url: 'index.php?fc=module&module=countdownvouchers&controller=counterdown&ajax=1&action=default',
            async: true,
            cache: false,
            dataType: 'json',
            data:{ 
            contact_promo:$(this).is(':checked'),
            productId:$(this).data('id_product'),
            shop_id:$(this).data('id_shop'),
            customer_id:$(this).data('id_customer')
            },
            success: function(rep){
                if(rep)
                    console.log('ok');
            }
        });
    });
    $( "#alert_list" ).click(function() {
        $( "#alerte_liste" ).toggle( "slow", function() {
          // Animation complete.
        });
  });
});

