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
            makeAjaxRequest($('#modal-settings'), el.firstElementChild.className);
        }
    });

    $('#general-modal input[type=checkbox]').on('change', function (event) {
        var inputId = $(this).attr('name').split('[')[0];

        if ($(this).is(':checked')) {
            $('#' + inputId + '-col > div.second-row').removeClass('hide');
        } else {
            $('#' + inputId + '-col > div.second-row').addClass('hide');
        }
    });

    function makeAjaxRequest($form, field) {
        var ajaxData = $form.serializeObject();
        ajaxData['action'] = $form.attr('action');
        return $.ajax({
            url:            vgJSON.ajaxUrl,
            type:           $form.attr('method'),
            data:           ajaxData,
            success: function (response, status, xhr) {
                initModal(response, field);
            },
            error: function (xhr, status, error) {

            }
        })
    }

    function initModal(ajaxResponse, field) {
        var modalId = getModalId(field);
        resetModal(modalId);

        $.each(ajaxResponse,function(indexLevel1, valueLevel1) {
            $.each(valueLevel1,function(indexLevel2, valueLevel2) {
                $(modalId + ' #' + indexLevel1 + '-' + indexLevel2 + '-span').text(valueLevel2);
            });
        });

        $(modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }

    function setInputValue($input, value)
    {
        $($input).val(value);
    }

    function getModalId(field) {
        if (field !== 'radio' && field !== 'checkbox') {
            return '#general-modal';
        } else {
            return '#special-modal';
        }
    }

    function resetModal(modalId)
    {
        $(modalId + ' .modal-body input[type=checkbox]').each(function (event) {
            if ($(this).is(':checked')) { $(this).click(); }
        });
        $(modalId + ' .modal-body input[type=text], ' + modalId + ' textarea').val("");
        $(modalId + ' .modal-body span:not(.slider)').text("");
    }
});