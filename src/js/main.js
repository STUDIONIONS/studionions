(function($){
	var $tpl = $('<div class="col-sm-6 mix tab-pane-content-item sites"><div class="tab-pane-content-wrapper"><div style="background-image:url(\'/assets/templates/studionions/images/grid_1.jpg\');" class="tab-pane-content-wrapper-image"></div><div class="tab-pane-content-wrapper-link"><a href="javascript:;"><span class="title">Татьяна Алфеева</span><span class="text">Сайты</span><span class="icon"></span></a></div></div></div><div class="col-sm-6 mix tab-pane-content-item brand"><div class="tab-pane-content-wrapper"><div style="background-image:url(\'/assets/templates/studionions/images/grid_2.jpg\');" class="tab-pane-content-wrapper-image"></div><div class="tab-pane-content-wrapper-link"><a href="javascript:;"><span class="title">Татьяна Алфеева</span><span class="text">Бренд</span><span class="icon"></span></a></div></div></div><div class="col-sm-6 mix tab-pane-content-item content"><div class="tab-pane-content-wrapper"><div style="background-image:url(\'/assets/templates/studionions/images/grid_3.jpg\');" class="tab-pane-content-wrapper-image"></div><div class="tab-pane-content-wrapper-link"><a href="javascript:;"><span class="title">Татьяна Алфеева</span><span class="text">Контент</span><span class="icon"></span></a></div></div></div><div class="col-sm-6 mix tab-pane-content-item sites"><div class="tab-pane-content-wrapper"><div style="background-image:url(\'/assets/templates/studionions/images/grid_4.jpg\');" class="tab-pane-content-wrapper-image"></div><div class="tab-pane-content-wrapper-link"><a href="javascript:;"><span class="title">Татьяна Алфеева</span><span class="text">Сайты</span><span class="icon"></span></a></div></div></div><div class="col-sm-6 mix tab-pane-content-item brand"><div class="tab-pane-content-wrapper"><div style="background-image:url(\'/assets/templates/studionions/images/grid_5.jpg\');" class="tab-pane-content-wrapper-image"></div><div class="tab-pane-content-wrapper-link"><a href="javascript:;"><span class="title">Татьяна Алфеева</span><span class="text">Бренд</span><span class="icon"></span></a></div></div></div><div class="col-sm-6 mix tab-pane-content-item content"><div class="tab-pane-content-wrapper"><div style="background-image:url(\'/assets/templates/studionions/images/grid_6.jpg\');" class="tab-pane-content-wrapper-image"></div><div class="tab-pane-content-wrapper-link"><a href="javascript:;"><span class="title">Татьяна Алфеева</span><span class="text">Контент</span><span class="icon"></span></a></div></div></div>');
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
	$(".section-tabs").on("click mouseenter", ".tab-pane-content-wrapper", function(e){
		$(".section-tabs .tab-pane-content-wrapper").removeClass("active");
		$(this).addClass('active');
	}).on("mouseleave", ".tab-pane-content-wrapper", function(e){
		$(".section-tabs .tab-pane-content-wrapper").removeClass("active");
	});
	var container = $('.section-tabs .tabs'),
		showlink = $('.tab-pane .showlink'),
		mixer = mixitup(container, {
			load: {
				filter: '.mix'
			},
			animation: {
				effects: 'fade translateY(100%)',
				effectsOut: 'fade translateY(-100%)',
				reverseOut: true,
				animateResizeTargets: true,
				animateResizeContainer: true,
				nudge: false,
				clampHeight: true
			}
		});
	showlink.on('click', function(e){
		e.preventDefault();
		mixer.append($tpl.clone());
		return !1;
	});
	var $hero = $("main.main-hero"),
		$navtext = $("header.navigation .brand-logo-text"),
		dts = 300;
	$(window).on("scroll resize", function(e){
		var wst = $(window).scrollTop();
		if($hero.length){
			dts = $($hero[0]).outerHeight() - 140;
		}
		if(wst > dts){
			if(!$navtext.hasClass("fix")){
				$navtext.addClass("fix");
			}
		}else{
			if($navtext.hasClass("fix")){
				$navtext.removeClass("fix");
			}
		}
	}).trigger("resize");
}(jQuery));