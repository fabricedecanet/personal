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

$(document).ready( function() {
    $('button#params_submit').click(function(e){
        e.preventDefault();
		specificprice = $(this).attr('name');
		currentObj = $(this);
        var showcountdown = $('input[type=radio][name=showcountdown]:checked').attr('value');
        var promotion = $('input[type=radio][name=promotion]:checked').attr('value');
        var alert = $('input[type=radio][name=alert_promotion]:checked').attr('value');
		$.ajax({
            type:"POST",
            url: localLink+'&token='+token,
            datatype: 'json',
            data: {
                    action : 'SaveParam',  
                    ajax : 1,
                    controller : "AdminModules",
                    configure : 'countdownvouchers',
                    showcountdown: showcountdown,
                    promotion: promotion,
                    alert: alert,
            },
            success: function(rep){
				if (rep) {
                    showSuccessMessage(succesparams);
                }
                else 
                {
                    showErrorMessage(errorparams);
                }
                return false;
            }
		});
	});
});