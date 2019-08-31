var List = List || {
    item_w       : 220,//宽
    item_h       : 344,//高
    line_count   : 4,//每行数
    line         : 3,//行数
    all_count    : 0,//总数
    item_count   : 12,//单页总数
    current_num  : 0,//当前数
    set_id       : "",//电影集id
    get_count_url: "../api/get_count.php",//获取总数api地址
    get_list_url : "../api/get_list.php",//获取列表api地址
    list_url     : "list.php?id=:id",
    item_url     : "view.php?type=:type&id=:id",
    init: function() {
        List.op.get_set_id();
        List.op.get_line_count();
        List.op.get_line();
        List.op.get_item_count();
        List.data.get_total_count();
        List.bind.resize();
    }
};

List.op = {
    get_line_count: function() {
        win_w           = $(window).width() - 40;
        List.line_count = Math.floor(win_w/List.item_w);
    },
    get_line: function() {
        win_h     = $(window).height();
        List.line = Math.ceil(win_h/List.item_h);
    },
    get_item_count: function() {
        List.item_count = List.line_count * List.line;
    },
    get_set_id: function() {
        List.set_id = $("body").attr("id");
    }
};

List.data = {
    get_total_count: function() {
        type = ("" == List.set_id)?"movie":"set";
        $.ajax({
            url: List.get_count_url,
            method: "POST",
            data: {"type":type,"id":List.set_id},
            dataType: "text",
            success: function(count){
                List.all_count = Number(count);
                List.data.get_data();
            }
        });
    },
    get_data: function(num) {
        List.bind.scroll_disable();
        if(!num){
            num = List.item_count;
        }
        $.ajax({
            url: List.get_list_url,
            method: "POST",
            dataType: "json",
            data: {"start":List.current_num,"num":num,"id":List.set_id},
            success:function(json){
                List.data.make_html(json);
            }
        });
    },
    make_html: function(data) {
        data.forEach(function(item){
            var li = $("<li></li>");
            var img = $("<img/>");
            var div1 = $("<div></div>");
            var div2 = $("<div></div>");
            var pre_id = ("" == item['size'])?"set_":"movie_";
            if("" == item['pic_url']){
                img = $("<div style='padding:115px 0 20px 0;font-size:20px'>"+item['name']+"</div><div style='font-size:12px'>网上都没找到图：(</div>");
            }else{
                img.attr("src", item['pic_url']);
            }
            div1.addClass("pic").append(img);
            div2.addClass("name").text(item['name']);
            li.attr("title",item['name']).attr("id", pre_id+item['id']).append(div1).append(div2).appendTo($("#list_ul"));
        });
        List.current_num += data.length;
        List.bind.li_click();
        if(List.current_num < List.all_count){
            List.bind.scroll_enable();
        }
    }
};

List.bind = {
    li_click: function(){
        $("li").on("click",function(){
            id = $(this).attr("id");
            target = " target='_blank'";
            if("set" == id.substring(0,3)) {
                url = List.list_url.replace(":id", id.replace("set_",""));
            } else {
                url = List.item_url.replace(":type","m").replace(":id",id.replace("movie_",""));
            }
            var a = $("<a href='"+url+"'"+target+">open</a>").get(0);
            var e = document.createEvent('MouseEvent');
            e.initEvent('click', true, true);
            a.dispatchEvent(e);
            return false;
        });
    },
    scroll_enable: function(){
        $(window).on("scroll", function(){
            buffer     = 20;
            win_h      = $(window).height();
            doc_h      = $(document).height();
            scroll_top = $(window).scrollTop();
            if(buffer + scroll_top >= doc_h - win_h) {
                List.data.get_data();
            }
        });
    },
    scroll_disable: function() {
        $(window).off("scroll");
    },
    resize: function() {
        var flag = null;
        $(window).resize(function() {
            if(flag === null && List.current_num < List.all_count) {
                flag = setTimeout(function(){
                    List.op.get_line_count();
                    List.op.get_line();
                    List.op.get_item_count();
                    var num = 0;
                    after = List.current_num % List.line_count;
                    if(0 != after) {
                        num = List.line_count - after;
                    }
                    while(num + List.current_num < List.item_count){
                        num += List.line_count;
                    }
                    if(0 < num){
                        List.data.get_data(num);
                    }
                    flag = null;
                },200);
            }
        });
    },
};

$(List.init);