// jQuery( document ).ready(function($) {
//     dragula([$('.select-options'), $('.form-class')]);
// });

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
        document.getElementById(el.className).modal('show');
    }
});