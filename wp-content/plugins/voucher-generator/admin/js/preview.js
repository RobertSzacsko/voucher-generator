jQuery(document).ready(function($) {
    let modalId = '#preview-modal';

    // TODO reset modal before create html
    $(modalId + ' .modal-body').empty();

    $('.vg-form-details-preview-container .vg-preview').on('click touch',function(e){
        let html = '<div class="vg-container vg-preview-modal-container><div class="vg-col vg-col-sm-12 vg-col-md-12>"';
        let obj = {};
        $('.target .option-container').each(function(index, value) {

            // TODO think about how to do it
            // html += '<div class="">';
            let tmp = '{';
            let type = $(this).find("div").attr('class');
            $(this).find('input').each(function (indexInput, valueInput) {

                let split = $(valueInput).attr('name').split('[');
                let value = $(valueInput).attr('value');
                let aditionAttribute = split[1].slice(0, -1);
                let secondOption = split[2].slice(0, -1);

                tmp += aditionAttribute + ':' + value;

                console.log(aditionAttribute, secondOption, value);
            });
            // html += '</div>';
        });
        console.log(obj);
        html += '</div></div>';


        $(modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });

    $(modalId + ' .vg-close-btn').on('click touch',function(e){$(modalId).modal("hide");}); 
});