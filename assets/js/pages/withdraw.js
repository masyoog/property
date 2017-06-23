var Withdraw = function(){
    var initMe = function(){
//        $('.btn_transfer').click(function(){
//            e.prefentDefault();
//            var link = $(this).attr("href");
//            $('#frame-transfer').attr('src', link);
//            $('#area_modal_transfer').modal('show');
//        });
//        $('.btn_cancel').click(function(){
//            e.prefentDefault();
//            var link = $(this).attr("href");
//            $('#frame-cancel').attr('src', link);
//            $('#area_modal_cancel').modal('show');
//        });
        $('#modal_transfer').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id_request');
            var modal = $(this);
            modal.find('#input-id').val(id);
        });
        $('#modal_cancel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id_request');
            var modal = $(this);
            modal.find('#input-id').val(id);
        });
    };
    return {
        init: function(){
            initMe();
        }
    };
}();