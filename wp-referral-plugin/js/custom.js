jQuery(document).ready(function($) {
    // Handle referral code validation
    $('#rp_referral_code').on('blur', function() {
        var referralCode = $(this).val();
        var statusElemet =  $('#rp_referral_code_status');
        
        $.ajax({
            url: wrp_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'validate_refferal_code',
                referral_code: referralCode
            },
            success: function(response) {
                if (response.success) {
                    statusElemet.text('✔').css('color', 'green');
                } else {
                    statusElemet.text('✘').css('color', 'red');
                }
            }
        });
    });
});