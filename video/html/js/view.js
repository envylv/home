var View = View || {
    init: function() {
        for (var i in View) {
            var obj = View[i];
            if (typeof obj == "object" && typeof obj.init != "undefined")
                obj.init();
        }
    }
};

View.bind = {
    init: function(){
        /*$(window).resize(View.bind.set_back_size);
        View.bind.set_back_size();*/
    },
    set_back_size: function() {
        back = $("#back");
        main = back.parent();
        back.width(main.width());
    },
};

$(View.init);