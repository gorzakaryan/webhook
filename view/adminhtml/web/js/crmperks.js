require(['jquery'], function($){

    $( document ).ajaxComplete(function( event, xhr, settings ) {
        $('.crmperks-hook-index-edit .col-log_status, .crmperks_hook-index-edit .col-log_status').each(function(index, value) {
            if ($.trim($(value).html()) == 'success') {
                $(value).addClass('data-grid-success');
            }
            if ($.trim($(value).html()) == 'error') {
                $(value).addClass('data-grid-error');
            }
        });
        $('.crmperks-hook-index-index .data-grid-cell-content, .crmperks_hook-index-index .data-grid-cell-content').each(function(index, value) {
            if ($(value).html() == 'Enabled') {
                $(value).addClass('data-grid-enabled');
            }
            if ($(value).html() == 'Disabled') {
                $(value).addClass('data-grid-disabled');
            }
        });
        $('.crmperks-hook-logs-index .data-grid-cell-content, .crmperks_hook-logs-index .data-grid-cell-content').each(function(index, value) {
            if ($.trim($(value).html()) == 'success') {
                $(value).addClass('data-grid-success');
            }
            if ($.trim($(value).html()) == 'error') {
                $(value).addClass('data-grid-error');
            }
        });
    });

    var intervalHook = setInterval(function(){
        $('.crmperks-hook-index-index .data-grid-cell-content, .crmperks_hook-index-index .data-grid-cell-content').each(function(index, value) {
            if ($(value).html() == 'Enabled') {
                $(value).addClass('data-grid-enabled');
            }
            if ($(value).html() == 'Disabled') {
                $(value).addClass('data-grid-disabled');
            }
        });
        if ($('.crmperks-hook-index-index .data-grid-cell-content, .crmperks_hook-index-index .data-grid-cell-content').length > 0) {
            clearInterval(intervalHook);
        }
    }, 4000);

    var intervalLogs = setInterval(function(){
        $('.crmperks-hook-logs-index .data-grid-cell-content, .crmperks_hook-logs-index .data-grid-cell-content').each(function(index, value) {
            if ($.trim($(value).html()) == 'success') {
                $(value).addClass('data-grid-success');
            }
            if ($.trim($(value).html()) == 'error') {
                $(value).addClass('data-grid-error');
            }
        });
        if ($('.crmperks-hook-logs-index .data-grid-cell-content, .crmperks_hook-logs-index .data-grid-cell-content').length > 0) {
            clearInterval(intervalLogs);
        }
    }, 5000);
});
