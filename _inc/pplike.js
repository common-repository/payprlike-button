/**
 * @file
 * PayPRLike plugin.
 */
(function ($) {
    $(document).ready(function () {
        // Get protocol, host and pathname.
        var protocol = window.location.protocol;
        var host = window.location.hostname;
        var pathname = window.location.pathname;

        //console.log('protocol: ' + protocol);
        //console.log('host: ' + host);
        //console.log('path: ' + pathname);

        // Build blogger url.
        var blogger_url = protocol + '//' + host + pathname;

        // Get blogger name.
        var blogger = $('#payprlike').attr('name');
        //console.log('url: ' + blogger_url);
        //console.log('name: ' + blogger);

        //var server = 'http://pplike.dev';
        //var server = 'http://test.creativelab.us';
        var server = 'http://payprlike.com';

        // Pass variables to PayPRLike service.
        // $.get(server  + "/payprlike/blogger", { amount: amount, url: blogger_url, blogger: blogger } );

        // Load blogger information.
        var agreement = server + "/payprlike/" + blogger + "/agreement";
        var payment = server + "/payprlike/" + blogger + "/pay";

        // Make cross-browser ajax request.
//        $.ajax({
//            type: "POST",
//            url: server + "/payprlike/request",
//            async: false,
//            data: { url: blogger_url, blogger: blogger }, //amount: amount,
//            success: function (data) {
//                return true;
//            },
//            complete: function () {
//            },
//            error: function (xhr, textStatus, errorThrown) {
//                return false;
//            }
//        });

        var paymentOptions = '<div class="payment-options">';
        paymentOptions += '<div class="wrapper-option">';
        paymentOptions += '<div id="a1" class="option">1$</div>';
        paymentOptions += '<div id="a3" class="option">3$</div>';
        paymentOptions += '<div id="a5" class="option">5$</div>';
        paymentOptions += '</div>';
        paymentOptions += '<div class="option-message">select the payment method</div>';
        paymentOptions += '</div>';


        $dialogPayment = $('<div id="payment"></div>')
            .html(
                '<iframe id="dialog" name="dialog" style="border: 0px; " src="' + payment + '" width="100%" height="100%"></iframe>' + paymentOptions)
            .dialog({
                autoOpen: false,
                modal: true,
                resizable: false,
                draggable: false,
                height: 320,
                width: 500,
                buttons: [
                    { text: "PayPal", class: 'paypal-button payment-buttons', click: function () {
                        var amount = $('.payment-options .option-active').attr('id');
                        if (amount != undefined) {
                            payPRLikeRequest('paypal');
                            window.location.href = server + '/payprlike/paypal?a=' + amount.slice(1, 2);
                        }
                    } },
                    { text: "SMS", class: 'sms-button payment-buttons', click: function () {
                        payPRLikeRequest('sms');
                        window.location.href = server + '/payprlike/sms';

                    } },
                    { text: "Bitcoin", class: 'bitcoin-button payment-buttons', click: function () {
                        payPRLikeRequest('bitcoin');
                        window.location.href = server + '/payprlike/bitcoins';
                    } },
                    { text: "Credit", class: 'credit-card-button payment-buttons', click: function () {
                        var amount = $('.payment-options .option-active').attr('id');
                        if (amount != undefined) {
                            payPRLikeRequest('credit-card');
                            window.location.href = server + '/payprlike/credit-card?a=' + amount.slice(1, 2);
                        }
                    } }
                ]
            });

        var $dialogAgreement = $('<div></div>')
            .html('<iframe id="dialog" name="dialog" style="border: 0px; " src="' + agreement + '" width="100%" height="100%"></iframe>')
            .dialog({
                autoOpen: false,
                modal: true,
                resizable: false,
                draggable: false,
                height: 425,
                width: 500,
                buttons: [
                    {
                        text: "I'm Agree",
                        class: 'agree-button',
                        click: function () {
                            $(this).dialog("close");
                            $dialogPayment.dialog('open');
                        }
                    },
                    {
                        text: "Cancel",
                        class: "cancel-button",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }
                ]
            });


        // Initialize dialog.
        $('#payprlike a').click(function (e) {
            e.preventDefault();
            $dialogAgreement.dialog('open');
        });

        // Payment option select.
        $('.payment-options .option').click(function() {
            $('.payment-options .option').removeClass('option-active');
            $(this).addClass('option-active');
        });

        // Message validation.
        $('.paypal-button').click(function() {
            if (!$('.payment-options .option').hasClass('option-active')) {
                $('.option-message').css('color', 'red');
            }
        });

        $('.credit-card-button').click(function() {
            if (!$('.payment-options .option').hasClass('option-active')) {
                $('.option-message').css('color', 'red');
            }
        });

        var payPRLikeRequest = function (service) {
            $.ajax({
                type: "POST",
                url: server + "/payprlike/request",
                async: false,
                data: { url: blogger_url, blogger: blogger, service: service },
                success: function (data) {
                    return true;
                },
                complete: function () {
                },
                error: function (xhr, textStatus, errorThrown) {
                    return false;
                }
            });
        }

    });
})(jQuery);
