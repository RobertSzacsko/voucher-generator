jQuery(document).ready(function($) {
    $('.vg-placeholder-span').on('click', function () {
        $(this).prev('.vg-placeholder-input').focus();
    });

    $('.vg-placeholder-input').on('input',function(e){
        (function ($element) {
            if($element.val() !== '') {
                $element.addClass('vg-placeholder-input-focus');
            } else {
                $element.removeClass('vg-placeholder-input-focus');
            }
        }($(this)));
    }); 
});