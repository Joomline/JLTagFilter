var JlTagFilter = {
    autho_send: 0,
    ajax: 0,
    ajax_selector: '#content',
    form_identifier: '#mod-jltagfilter-form',
    init: function (data) {
        var $this = this;
        if (typeof data.ajax !== 'undefined') {
            this.ajax = data.ajax;
        }
        if (typeof data.ajax_selector !== 'undefined') {
            this.ajax_selector = data.ajax_selector;
        }
        jQuery(document).ready(function () {
            jQuery('#tag-select-1').on('change', function () {
                $this.onChangeFirstSelect(jQuery(this).val())
            });

            jQuery('#tag-select-2').on('change', function () {
                $this.onChangeLastSelect(jQuery(this).val())
            });

            jQuery('#mod-jltagfilter-dropdown-menu a.final').on('click', function (event) {
                event.preventDefault();
                var el = jQuery(this);
                var val = jQuery(this).data('id');
                var form = jQuery($this.form_identifier);
                form.find('input[name="filter_tag"]').val(val);

                if($this.ajax == 0){
                    form.submit();
                }
                else{
                    jQuery('#mod-jltagfilter-dropdown-menu li').removeClass('active');
                    el.parent().addClass('active');
                    el.parent().parent().parent('li').addClass('active');
                    $this.submit();
                }
            });
        });
    },
    onChangeFirstSelect: function (val) {
        jQuery('#tag-select-2').val('').find('option').not(':first').hide();
        jQuery('#tag-select-2').find('option[data-parent-id="'+val+'"]').show();
        jQuery('#tag-select-filter-tag').val(val);
    },
    onChangeLastSelect: function (val) {
        jQuery('#tag-select-filter-tag').val(val);
    },
    clearForm: function (element) {
        jQuery('#tag-select-1').val('');
        jQuery('#tag-select-2').val('').find('option').not(':first').hide();
        return false;
    },
    submit: function () {
        var $this = this;
        $this.ShowLoadingScreen();
        var form = jQuery($this.form_identifier);
        var val = jQuery('#tag-select-filter-tag').val();
        jQuery.ajax({
            type: 'get',
            url: form.attr('action'),
            cache: 'false',
            data: 'filter_tag='+val+'&tmpl=component',
            dataType: 'html',
            success: function (data) {
                jQuery($this.ajax_selector).html(data);
                $this.HideLoadingScreen();
            }
        });
    },
    ShowLoadingScreen: function () {
        jQuery("body").css("cursor", "wait");

        var fade_div = jQuery("#mod_jltagfilter_fade");

        if (fade_div.length == 0) {
            // Создаем div
            fade_div = jQuery('<div></div>')
                .appendTo(document.body)
                .hide()
                .attr('id', "mod_jltagfilter_fade")
                .attr('className', "shadowed")
                .css('z-index', "1500")
                .css('position', "absolute")
                .css('left', "50%")
                .css('top', "50%")
                .append('<img src="/modules/mod_jltagfilter/assets/images/ajax_loader.gif" id="id_fade_div_img" />')
                .css('width', "32");
        }

        fade_div
            .show()
            .css('top', (jQuery(window).height() - fade_div.outerHeight(true)) / 2 + jQuery(window).scrollTop())
            .css('left', (jQuery(window).width() - fade_div.outerWidth(true)) / 2 + jQuery(window).scrollLeft());
    },
    HideLoadingScreen: function () {
        jQuery("body").css("cursor", "auto");
        jQuery("#mod_jltagfilter_fade").css('display', 'none');
    }
};



