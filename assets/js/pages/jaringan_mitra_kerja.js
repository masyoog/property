var Jaringan_mitra_kerja = function(){
    var initMe = function(){
        
        $('#input-id_member').autocomplete({
            source: base_url('member/get_member_list'),
            delay: 100,
            select: function(e, dt){
                $('#input-nama_member').val(dt.item.nama);
                buildTree(dt.item.id_member);
            }
        });
        $('#btn-all').click(function(){
            $('#input-id_member').val('');
            $('#input-nama_member').val('');
            buildTree('');
        });
        var buildTree = function(idMember){
            $.getJSON(base_url('member/get_member_tree?id_member='+idMember), function(data){
                $('#tree').treeview({
//                    color: "#428bca",
                    expandIcon: 'glyphicon glyphicon-chevron-right',
                    collapseIcon: 'glyphicon glyphicon-chevron-down',
                    nodeIcon: "glyphicon glyphicon-user",
                    showTags: true,
                    data: data
                });
            });
        };
    };
    return {
        init: function () {
            initMe();
        }
    };
    
}();
