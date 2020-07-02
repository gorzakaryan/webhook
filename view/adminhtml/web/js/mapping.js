require(['jquery','jquery/ui','mage/url'], function($, ui, urlBuilder){
    'use strict';

        $('#event option:first').prop('disabled', true).prop('hidden', true);

        $('#event').on('change', function () {
            eventChange();
        });

        var interval = setInterval(function(){
            if ($('#crmperksMapping tbody.admin_tbody__dynamic-rows_mapping tr').length > 0) {
                addRowsAtrribute();
                clearInterval(interval);
            }
        }, 2000);

        deleteRows();
        addHeaders();
        deleteHeaders();

        function eventChange() {
            var ajaxUrl = urlBuilder.build('crmperks_hook/index/dataProvider');
            var eventName = $("#event option:selected").val();
            $.ajax({
                url: ajaxUrl,
                showLoader: true,
                type: "POST",
                data: {event: eventName},
                async: true
            }).done(function (data) {

                $("#crmperksMapping").replaceWith(data.html.mapping_fields);

                return true;
            });
        }

        function addRowsAtrribute() {
            var i = $('#crmperksMapping tbody.admin_tbody__dynamic-rows_mapping tr').length;
            $('body').on('click', '.add-row_dynamic-rows.add-row_dynamic-rows_mapping', function() {
                i++;
                $('.admin_tbody__dynamic-rows_mapping').append($(
                    '<tr data-row-index="'+ i +'" class="data-row">\n' +
                    '<td>\n' +
                    '<div class="admin__field">\n' +
                    '<div class="admin__field-control">\n' +
                    '<select class="admin__control-select admin__control-select_mapping select_mapping" name="mapping[valuesDynamic][]">\n' +
                    '</select>\n' +
                    '<span class="admin__control-or">or</span>\n' +
                    '<input type="text" placeholder="Static Value" name="mapping[valuesStatic][]" value=""/>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</td>\n' +
                    '<td>\n' +
                    '<div class="admin__field">\n' +
                    '<div class="admin__field-control admin__field-control_mapping">\n' +
                    '<input class="admin__control-text" type="text" name="mapping[names][]" value="">\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</td>\n' +
                    '<td class="data-grid-actions-cell">\n' +
                    '<button data-delete-row-index="'+ i +'" class="action-delete action-delete_mapping">\n' +
                    '<span></span>\n' +
                    '</button>\n' +
                    '</td>\n' +
                    '</tr>'
                ));

                $(".admin__dynamic-rows.admin__control-table tbody tr:first-child select option").map(function() {
                    $(".admin_tbody__dynamic-rows tr:last-child select").append($("<option value='"+ $(this).val() +"'>"+ $(this).html() +"</option>"));
                });
            });
        }

        function deleteRows() {
            $("body").on('click', '.action-delete.action-delete_mapping', function () {
                var tr_length = $('tbody.admin_tbody__dynamic-rows.admin_tbody__dynamic-rows_mapping tr').length;
                var rowId = $(this).attr('data-delete-row-index');
                if(tr_length > 1){
                    $('[data-row-index="'+ rowId +'"]').remove();
                }
                return false;
            });
        }

        function addHeaders() {
            var j = $('tbody.admin_tbody__dynamic-rows.admin_tbody__dynamic-rows_headers tr').length;
            $('body').on('click', '.add-row_dynamic-rows.add-row_dynamic-rows_headers', function() {
                j++;
                $('.admin_tbody__dynamic-rows_headers').append($(
                    '<tr data-row-head-index="'+ j +'" class="data-row">\n' +
                    '<td>\n' +
                    '<div class="admin__field">\n' +
                    '<div class="admin__field-control">\n' +
                    '<input class="admin__control-text_name" value="" type="text" name="headers[valuesName][]">\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</td>\n' +
                    '<td>\n' +
                    '<div class="admin__field">\n' +
                    '<div class="admin__field-control admin__field-control_headers">\n' +
                    '<input class="admin__control-text_value" type="text" name="headers[valuesValue][]" value="">\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</td>\n' +
                    '<td class="data-grid-actions-cell">\n' +
                    '<button data-delete-row-head-index="'+ j +'" class="action-delete action-delete_headers">\n' +
                    '<span></span>\n' +
                    '</button>\n' +
                    '</td>\n' +
                    '</tr>'
                ));
            });
        }

        function deleteHeaders() {
            $("body").on('click', '.action-delete.action-delete_headers', function () {
                var rowId = $(this).attr('data-delete-row-head-index');
                $('[data-row-head-index="'+ rowId +'"]').remove();
            });
        }
});
