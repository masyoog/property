var Default = function(){
    var getTotal = function(){
        $.getJSON(base_url("dashboard/get_total"), function(data){
            $.each(data, function(key, value){
                if(Number(value)<=0){
                    value='';
                }
                var el = $('#total_'+key);
                if(el.length){
                    el.html(value);
                }
            });
        });
    };
    var initMe = function(){
        getTotal();
        var interval = 1000*10;//60*10;
        setInterval(getTotal, interval);
    };
    return {
        init: function(){
            initMe();
        }
    };
}();