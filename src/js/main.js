(function($){
	$(".menu-button").click(function(e){
		e.preventDefault();
		var $this = $(this),
			$nav = $(".menu", $this.parent());
		$nav.hasClass("open") ? ($nav.removeClass("open"), $('body, html').removeClass('openmenu')) : ($nav.addClass("open"), $('body, html').addClass('openmenu'));
		return !1;
	});
	$("nav.menu .menu-list-item").on("mouseup pointerup", function(e){
		var $this = $(this);
		$this.removeClass("down").addClass("down");
		setTimeout(function(el){
			el.removeClass("down");
		}, 100, $this);
	});
	$("main.main-hero .block-messenger .contact-block a").click(function(e){
		var $this = $(this);
		$this.blur();
	});
}(jQuery));