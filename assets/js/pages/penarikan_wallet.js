var Penarikan_wallet = function(){
    var initMe = function(){
        
        $('#input-id_member').autocomplete({
            source: base_url('member/get_member_list'),
            delay: 100,
            select: function(e, dt){
                $('#input-nama').val(dt.item.nama);
            }
        });
    };
    return {
        init: function () {
            initMe();
        }
    };
    
}();
