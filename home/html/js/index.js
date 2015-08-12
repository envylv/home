var index = index || {
	init: function(){
        for(var i in index){
            var obj = index[i];
            if($.type(obj) === "object" && $.type(obj.init) === "function")
                obj.init();
        }
    }
};
index.bind = {
	init: function(){
		index.bind.dir_click();
		index.bind.check_box();
		index.other.make_color();
	},
	dir_click:function(){//目录点击事件绑定
		$('#content').delegate("a[id^='a_']",'click',function(){
			var a = $(this);
			var id = a.attr('id').replace(/a_/,'');
			var sons = $("div[id^='d_"+id+"_']");
			if(sons.length>0){
				sons.remove();
				index.other.make_color();
			}else{
				var text = a.attr('path')+'/'+a.text();
				var param = {'text':text,'type':'ajax','id':id};
				$.post('/', param, function(data) {
					a.parents("div[id!='content']").after(data);
					index.other.make_color();
				});
			}
		});
	},
	check_box:function(){//选择框点击事件绑定
		$('#content').delegate('input:checkbox','click',function(){
			alert('还没编呢，先别点！');
		});
	},
	title_float: function(){//页面滚动固定标题栏

	}
};
index.other = {
	make_color: function(){
		$('div[id^="d_"]:odd').find('span').css('background-color','#eee');
		$('div[id^="d_"]:even').find('span').css('background-color','#fff');
	}
};
$('document').ready(function(){
	index.init();
});