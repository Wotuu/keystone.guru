<?php
$showLegalModal = isset($showLegalModal) ? $showLegalModal : true;
?>
<script>

    var _legalStartTimer = new Date().getTime();

    document.addEventListener("DOMContentLoaded", function (event) {
        @auth
        // Legal nag so that everyone agrees to the terms, that has registered.
        @if($showLegalModal && !Auth::user()->legal_agreed)
        $('#legal_modal').modal('show');
        $('#legal_confirm_btn').bind('click', _agreeLegalBtnClicked);
        @endif
        @endauth
    });

    /**
     * Handler for when the 'I agree' button has been pressed for a returning user.
     **/
    function _agreeLegalBtnClicked() {
        $.ajax({
            type: 'POST',
            url: '/ajax/profile/legal',
            dataType: 'json',
            data: {
                time: new Date().getTime() - _legalStartTimer
            },
            beforeSend: function () {
                $('#legal_confirm_btn').attr('disabled', 'disabled');
            },
            success: function () {
                $('#legal_modal').modal('hide');
            },
            complete: function () {
                $('#legal_confirm_btn').removeAttr('disabled');
            }
        });
    }
</script>
