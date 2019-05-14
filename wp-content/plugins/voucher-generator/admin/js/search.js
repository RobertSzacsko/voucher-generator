jQuery(document).ready(function($) {
    $('#vg-js-search').on('input',function(e){
        let search = $(this).val();
        (function ($body) {
            $body.find('.vg-container:not(.vg-default-hide)').each(function(index, element) {
                if ($(element).find('.vg-title').text().toLowerCase().indexOf(search.toLowerCase()) === -1) {
                    $(element).addClass('vg-hide');
                } else {
                    $(element).removeClass('vg-hide');
                }
            });
        }($('.vg-table .vg-body')));
    }); 
});