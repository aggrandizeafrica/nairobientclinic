(function($) {
    "use strict";

  //   $( window ).on( 'elementor/frontend/init', function() {
		// elementor.hooks.addAction( 'etc-custom-section-classes', function( settings ) {
		// 	settings.custom_section_classes = '312312312';
  //       	return settings;
		// } );
  //   } );

    var subMegamenu = $('.sub-megamenu');
    $.each(subMegamenu, function (index, megamenu) {
        megamenu = $(megamenu);
        if (megamenu.find('.menu .current-menu-item').length > 0) {
            megamenu.parents('.megamenu').addClass('current-menu-ancestor current-menu-parent');
        }
    });

    // load more
    $(document).on('click', '.cms-load-more', function() {
        var loadmore = $(this).data('loadmore');
        var _this = $(this).parents(".cms-grid");
        var layout_type = _this.data('layout');
        var loading_text = $(this).data('loading-text');
        var no_text = $(this).data('no-text');

        loadmore.maxPages = parseInt(_this.data('max-pages'));
        loadmore.paged = parseInt(_this.data('start-page')) + 1;

        _this.find('.cms-grid-overlay').addClass('loader');
        $(this).addClass('loading');
        $(this).find('.cms-btn-icon').addClass('loading');
        $(this).find('.cms-btn-text').text(loading_text);
        $(document).trigger('etc_grid_before_load_more', _this);
        $.ajax({
                url: main_data.ajax_url,
                type: 'POST',
                beforeSend: function() {

                },
                data: {
                    action: pagination_data.get_posts_action,
                    settings: loadmore
                }
            })
            .done(function(res) {
                if (res.status == true) {
                    _this.find('.cms-grid-content').append(res.data.html);
                    _this.data('start-page', res.data.paged);
                    _this.find('.cms-grid-overlay').removeClass('loader');
                    _this.find('.cms-load-more').removeClass('loading');
                    _this.find('.cms-btn-icon').removeClass('loading');
                    _this.find('.cms-btn-text').text('Load More');
                    if (res.data.paged == loadmore.maxPages) {
                        _this.find('.cms-load-more').addClass('no-more');
                        _this.find('.cms-btn-text').text(no_text);
                    }
                    if (layout_type == 'masonry') {
                        $.sep_grid_refresh();
                    }
                } else if (res.status == false) {
                    _this.find('.cms-load-more').addClass('no-more');
                }
                $(document).trigger('load_more_done', _this, res);
            })
            .fail(function(res) {
                _this.find('.cms-load-more').addClass('no-more');
                $(document).trigger('load_more_fail', _this, res);
                return false;
            })
            .always(function() {
                $(document).trigger('load_more_always', _this);
                return false;
            });
    });

    // pagination
    $(document).on('click', '.cms-grid-pagination .ajax a.page-numbers', function() {
        var _this = $(this).parents(".cms-grid");
        var loadmore = _this.find(".cms-grid-pagination").data('loadmore');
        var query_vars = _this.find(".cms-grid-pagination").data('query');
        var layout_type = _this.data('layout');
        var paged = $(this).attr('href');
        paged = paged.replace('#', '');
        loadmore.paged = parseInt(paged);
        query_vars.paged = parseInt(paged);
        _this.find('.cms-grid-overlay').addClass('loader');
        $('html,body').animate({ scrollTop: _this.offset().top - 100 }, 750);
        $(document).trigger('etc_grid_before_paginate', _this);
        // reload pagination
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function() {

            },
            data: {
                action: pagination_data.get_pagination_action,
                query_vars: query_vars
            }
        }).done(function(res) {
            if (res.status == true) {
                _this.find(".cms-grid-pagination").html(res.data.html);
                _this.find('.cms-grid-overlay').removeClass('loader');
            } else if (res.status == false) {}
            $(document).trigger('etc_grid_pagination_get_pagination_done', _this, res);
        }).fail(function(res) {
            $(document).trigger('etc_grid_pagination_get_pagination_fail', _this, res);
            return false;
        }).always(function() {
            $(document).trigger('etc_grid_pagination_get_pagination_always', _this);
            return false;
        });
        // load post
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function() {

            },
            data: {
                action: pagination_data.get_posts_action,
                settings: loadmore
            }
        }).done(function(res) {
            if (res.status == true) {
                _this.find('.cms-grid-content .cms-item').remove();
                _this.find('.cms-grid-content').append(res.data.html);
                _this.data('start-page', res.data.paged);
                if (layout_type == 'masonry') {
                    $.sep_grid_refresh();
                }
            } else if (res.status == false) {}
            $(document).trigger('etc_grid_pagination_get_posts_done', _this, res);
        }).fail(function(res) {
            $(document).trigger('etc_grid_pagination_get_posts_fail', _this, res);
            return false;
        }).always(function() {
            $(document).trigger('etc_grid_pagination_get_posts_always', _this);
            return false;
        });
        return false;
    });

    // post filter
    $(document).on('click', '.cms-grid .grid-filter-wrap .filter-item', function() {
        if ($(this).hasClass('active')) {
            return false;
        }
        let gridEl = $(this).parents('.cms-grid');
        gridEl.find('.grid-filter-wrap .filter-item').removeClass('active');
        $(this).addClass('active');

        let loadmore = gridEl.find(".cms-grid-pagination").data('loadmore') || gridEl.find(".cms-load-more").data('loadmore'); 
        loadmore = $.extend({}, loadmore);
        let query_vars = gridEl.find(".cms-grid-pagination").data('query') || gridEl.find(".cms-load-more").data('query');
        let layout_type = gridEl.data('layout');
        let filter = $(this).data('filter');
        if (typeof filter == 'undefined' || filter == "*" || filter == '') {
            filter = '';
        } else {
            loadmore.source = [filter];
        }

        loadmore.paged = 1;
        query_vars.paged = 1;
        gridEl.find('.cms-grid-overlay').addClass('loader');
        $(document).trigger('etc_grid_before_filter', gridEl);

        // reload pagination
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function() {

            },
            data: {
                action: pagination_data.get_pagination_action,
                query_vars: query_vars,
                filter: filter,
            }
        }).done(function(res) {
            if (res.status == true) {
                gridEl.find(".cms-grid-pagination").html(res.data.html);
                gridEl.find('.cms-grid-overlay').removeClass('loader');
            } else if (res.status == false) {}
            $(document).trigger('etc_grid_filter_get_pagination_done', gridEl, res);
        }).fail(function(res) {
            $(document).trigger('etc_grid_filter_get_pagination_fail', gridEl, res);
            return false;
        }).always(function() {
            $(document).trigger('etc_grid_filter_get_pagination_always', gridEl);
            return false;
        });
        // load post
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function() {

            },
            data: {
                action: pagination_data.get_posts_action,
                settings: loadmore
            }
        }).done(function(res) {
            if (res.status == true) {
                gridEl.find('.cms-grid-content .cms-item').remove();
                gridEl.find('.cms-grid-content').append(res.data.html);
                gridEl.data('start-page', res.data.paged);
            } else if (res.status == false) {}
            $(document).trigger('etc_grid_filter_get_posts_done', gridEl, res);
        }).fail(function(res) {
            $(document).trigger('etc_grid_filter_get_posts_fail', gridEl, res);
            return false;
        }).always(function() {
            $(document).trigger('etc_grid_filter_get_posts_always', gridEl);
            return false;
        });
        return false;
    });
}(jQuery));