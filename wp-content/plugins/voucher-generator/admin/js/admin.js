jQuery(document).ready(function($){
    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
    
    dragula([document.querySelector('.select-options'), document.querySelector('.form-class')], {
        mirrorContainer: document.body,
        copy: function (el, source) {
                return source === document.querySelector('.select-options')
            },
        accepts: function (el, target) {
                return target === document.querySelector('.form-class')
            },
        removeOnSpill: function (el, target) {
                return target === document.querySelector('.form-class')
            }
    }).on('drop', function (el, target, source, sibling) {
        if (source === document.querySelector('.select-options') && target === document.querySelector('.form-class')) {
            // document.getElementById(el.className).modal('show');
            setInputValue($('#modal-settings #field-id'), el.firstElementChild.className);
            initModal($('#modal-settings'));
        }
    });

    function initModal($form) {
        let settings = makeAjaxRequest($form);
    }
    
    function makeAjaxRequest($form) {
        var ajaxData = $form.serializeObject();
        ajaxData['action'] = $form.attr('action');
        $.ajax({
            url:            vgJSON.ajaxUrl,
            type:           $form.attr('method'),
            data:           ajaxData,
            success: function (response, status, xhr) {
                alert(response);
            },
            error: function (xhr, status, error) {

            }
        })
    }

    function setInputValue($input, value)
    {
        $($input).val(value);
    }
});