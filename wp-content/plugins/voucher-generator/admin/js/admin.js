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

    // TODO something goes wrong here
    $('.vg-body .vg-container').each(function(index, element) {
        $(this).on('hover', function () {
            $(this).find('.vg-container-actions').toggleClass('vg-default-visibility-hidden');
        });
    });

    $('.vg-list-load-more-forms-container .vg-list-load-more-forms').on('touch click', function(element) {
        let $index = 0;
        $('.vg-body .vg-container.vg-default-hide').each(function(index, element) {
            if ($index >= vgJSON.formsPerPage) { return; }
            $(this).removeClass('vg-default-hide');
            $index++;
        });
    });

    dragula([document.querySelector('.select-options'), document.querySelector('.target')], {
        mirrorContainer: document.body,
        copy: function (el, source) {
                return source === document.querySelector('.select-options')
            },
        accepts: function (el, target) {
                return target === document.querySelector('.target')
            },
        removeOnSpill: function (el, target) {
                return target === document.querySelector('.target')
            }
    }).on('drop', function (el, target, source, sibling) {
        if (source === document.querySelector('.select-options') && target === document.querySelector('.target')) {
            // document.getElementById(el.className).modal('show');
            setInputValue($('#modal-settings #field-id'), el.firstElementChild.className);
            makeAjaxRequest($('#modal-settings'), el.firstElementChild.className);
        }
    });

    $('#general-modal input[type=checkbox]').on('change', function (event) {
        var inputId = $(this).attr('name').split('][')[0];

        if ($(this).is(':checked')) {
            $('#' + inputId + '-col > div.second-row').removeClass('hide');
        } else {
            $('#' + inputId + '-col > div.second-row').addClass('hide');
        }
    });

    $('.vg-save-btn').on('click touch', function (event) {
        var count = $('.target-container .option-container').length;
        var target = $('.target-container .option-container:last-child');
        var field = $('.target-container .option-container:last-child div').attr('class');
        $(this).parent().prev().find('input, textarea').each(function (index, tag) {
            let name = $(tag).prop('name');
            let value;
            if ($(tag).prop('type') === 'checkbox') {
                if ($(tag).prop('checked') === true) {
                    value = 'yes';
                } else {
                    value = 'no';
                }
            } else {
                value = $(tag).prop('value');
            }

            target.append('<input type="hidden" name="' + field + '-' + count + '[' + name + '" value="' + value + '" />');
        });
        $(this).closest('div.modal').modal('hide');
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