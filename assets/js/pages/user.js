var User = function(){
    var initMe = function(){
        $('#input-cabang').change(function(){
            $.post(base_url("data/get_customerlist"), {cabang: $(this).val()}, function(data) {
                var options = '<option></option>';
                $.each(data, function(i, dt) {
                    options += '<option value="' + dt.id + '">' + dt.value + '</option>';
                });
                $("#input-id_akun").empty();
                $("#input-id_akun").append(options);
                $("#input-id_akun").select2('val','');
                $("#input-id_akun").trigger('change');
            },'json');
        });
    };
    return {
        init: function () {
            initMe();
        }
    };
    
}();
