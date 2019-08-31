var Show_list = Show_list || {
    item_w       : 220,//宽
    item_h       : 344,//高
    line_count   : 4,//每行数
    line         : 3,//行数
    all_count    : 0,//总数
    item_count   : 12,//单页总数
    current_num  : 0,//当前数
    get_count_url: "/api/get_count",//获取总数api地址
    get_list_url : "/api/get_list",//获取列表api地址
    item_url     : "/videoShow/show/:id",
    init: function() {
        Show_list.op.get_line_count();
        Show_list.op.get_line();
        Show_list.op.get_item_count();
        Show_list.data.get_total_count();
        Show_list.bind.resize();
    },
};
Show_list.op = {
    get_line_count: function() {
        win_w           = $(window).width() - 40;
        Show_list.line_count = Math.floor(win_w/Show_list.item_w);
    },
    get_line: function() {
        win_h     = $(window).height();
        Show_list.line = Math.ceil(win_h/Show_list.item_h);
    },
    get_item_count: function() {
        Show_list.item_count = Show_list.line_count * Show_list.line;
    },
};
Show_list.data = {
    get_total_count: function() {
        type = "tvshow";
        $.ajax({
            url: Show_list.get_count_url,
            method: "POST",
            data: {"type":type},
            dataType: "text",
            success: function(count){
                Show_list.all_count = Number(count);
                Show_list.data.get_data();
            }
        });
    },
    get_data: function(num) {
        Show_list.bind.scroll_disable();
        if(!num){
            num = Show_list.item_count;
        }
        $.ajax({
            url: Show_list.get_list_url,
            method: "POST",
            dataType: "json",
            data: {"type":"tvshow","start":Show_list.current_num,"num":num},
            success:function(json){
                Show_list.data.make_html(json);
            }
        });
    },
    make_html: function(data) {
        data.forEach(function(item){
            var li = $("<li></li>");
            var img = $("<img/>");
            var div1 = $("<div></div>");
            var div2 = $("<div></div>");
            if("" == item['pic_url']){
                img = $("<div style='padding:115px 0 20px 0;font-size:20px'>"+item['name']+"</div><div style='font-size:12px'>网上都没找到图：(</div>");
            }else{
                img.attr("src", item['pic_url']);
            }
            div1.addClass("pic").append(img);
            div2.addClass("name").text(item['name']);
            li.attr("title",item['name']).attr("id", item['id']).append(div1).append(div2).appendTo($("#list_ul"));
        });
        Show_list.current_num += data.length;
        Show_list.bind.li_click();
        if(Show_list.current_num < Show_list.all_count){
            Show_list.bind.scroll_enable();
        }
    }
};
Show_list.bind = {
    li_click: function(){
        $("li").on("click",function(){
            id = $(this).attr("id");
            target = " target='_blank'";
            url = Show_list.item_url.replace(":id",id.replace("tvshow_",""));
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
                Show_list.data.get_data();
            }
        });
    },
    scroll_disable: function() {
        $(window).off("scroll");
    },
    resize: function() {
        var flag = null;
        $(window).resize(function() {
            if(flag === null && Show_list.current_num < Show_list.all_count) {
                flag = setTimeout(function(){
                    Show_list.op.get_line_count();
                    Show_list.op.get_line();
                    Show_list.op.get_item_count();
                    var num = 0;
                    after = Show_list.current_num % Show_list.line_count;
                    if(0 != after) {
                        num = Show_list.line_count - after;
                    }
                    while(num + Show_list.current_num < Show_list.item_count){
                        num += Show_list.line_count;
                    }
                    if(0 < num){
                        Show_list.data.get_data(num);
                    }
                    flag = null;
                },200);
            }
        });
    },
};
$(Show_list.init);