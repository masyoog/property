var Member = function(){
    var initMe = function(){
        
        $('#input-id_upline').autocomplete({
            source: base_url('member/get_member_list'),
            delay: 100,
            select: function(e, dt){
                $('#input-nama_upline').val(dt.item.nama);
            }
        });
    };
    return {
        init: function () {
            initMe();
        }
    };
    
}();
