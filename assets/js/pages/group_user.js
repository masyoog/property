var Group_user = function(){
    var initMe = function(){
        $('#outstanding_all').click(function(event) {
            if(this.checked) {
                $('.out-item').prop('checked', true);
            }else{
                $('.out-item').prop('checked', false);
            }
        });
        $('#summary_all').click(function(event) {
            if(this.checked) {
                $('.summary-item').prop('checked', true);
            }else{
                $('.summary-item').prop('checked', false);
            }
        });
        $('#panel_all').click(function(event) {
            if(this.checked) {
                $('.panel-item').prop('checked', true);
            }else{
                $('.panel-item').prop('checked', false);
            }
        });
        $('#modul_all').click(function(event) {
            if(this.checked) {
                $('.chk-menu').prop('checked', true);
            }else{
                $('.chk-menu').prop('checked', false);
                $('.chk-always').prop('checked', true);
            }
        });
        $('#action_all').click(function(event) {
            if(this.checked) {
                $('.chk-action').prop('checked', true);
            }else{
                $('.chk-action').prop('checked', false);
            }
        });
        $('.actionrow_all').click(function(event) {
            if(this.checked) {
                $('#print-'+$(this).val()).prop('checked', true);
                $('#add-'+$(this).val()).prop('checked', true);
                $('#delete-'+$(this).val()).prop('checked', true);
                $('#edit-'+$(this).val()).prop('checked', true);
                $('#export-'+$(this).val()).prop('checked', true);
            }else{
                $('#print-'+$(this).val()).prop('checked', false);
                $('#add-'+$(this).val()).prop('checked', false);
                $('#delete-'+$(this).val()).prop('checked', false);
                $('#edit-'+$(this).val()).prop('checked', false);
                $('#export-'+$(this).val()).prop('checked', false);
            }
        });
        $('.parent_all').click(function(event) {
            if(this.checked) {
                $('.childof-'+$(this).val()).prop('checked', true);
            }else{
                $('.childof-'+$(this).val()).prop('checked', false);
            }
        });
        $('.chk-action-parent').click(function(event) {
            if(this.checked) {
                $('.chk-childof-'+$(this).val()).prop('checked', true);
            }else{
                $('.chk-childof-'+$(this).val()).prop('checked', false);
            }
        });
    //        $("#tbl_connote_manifest tr[id^='row-"+cn+"_']").remove();
        $('[class^="child"]').click(function(event) {
            var id = $(this).attr('id').split("-");
            if(this.checked) {
                $('#parent-'+id[1]).prop('checked', true);
            }
        });
    };
    return {
        init: function () {
            initMe();
        }
    };
    
}();