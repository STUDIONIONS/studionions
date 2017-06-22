(function($){
	$("body").on("click", "a, button, input[type=submit], input[type=reset], input[type=button], input[type=file], input[type=checkbox], input[type=radio]", function(e){
		$(this).blur();
	})
	$(".menu-button").click(function(e){
		e.preventDefault();
		var $this = $(this),
			$nav = $(".menu", $this.parent());
		$nav.hasClass("open") ? ($nav.removeClass("open"), $('body, html').removeClass('openmenu')) : ($nav.addClass("open"), $('body, html').addClass('openmenu'));
		return !1;
	});
	$(".link_transform").on("mouseup pointerup", function(e){
		var $this = $(this);
		$this.removeClass("down").addClass("down");
		$(this).blur();
		setTimeout(function(el){
			el.removeClass("down");
			!el.hasClass("active") && ($(".link_transform", el.parent()).removeClass("active"), el.addClass("active"));
		}, 100, $this);
	});
	/*$("main.main-hero .block-messenger .contact-block a").click(function(e){
		var $this = $(this);
		$this.blur();
	});*/
}(jQuery));