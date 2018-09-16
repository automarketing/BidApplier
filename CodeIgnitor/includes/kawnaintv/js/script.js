$(window).load(function() {
	$('#slider').nivoSlider({
		effect: 'random',
		slices: 15,
		boxCols: 8,
		boxRows: 4,
		animSpeed: 800,
		pauseTime: 3000,
		startSlide: 0,
		directionNav: true,
		controlNav: false,
		controlNavThumbs: false,
		pauseOnHover: true,
		manualAdvance: false,
		prevText: '',
		nextText: '',
		randomStart: false,
		beforeChange: function(){},
		afterChange: function(){},
		slideshowEnd: function(){},
		lastSlide: function(){},
		afterLoad: function(){}
	});
});

$(document).ready(function(){
    // $(".nav-tabs a").click(function(){
    //     $(this).tab('show');
    // });
    $("#rightSidebarLightSlider").lightSlider({
    	auto: true,
    	loop: true,
    	pager: false,
    	vertical: true,
    	verticalHeight:370,
    	item: 4,
    	pauseOnHover: true
    });

    $("#homepageBottomContentLightSlider").lightSlider({
    	auto: true,
    	loop: true,
    	pager: false,
    	item: 6,
    	pauseOnHover: true
    });

    $("#headerMenuHideBtn").click(function(event) {
    	/* Act on the event */
    	if($("#headerMenuUL").css('display') == 'none'){
	    	$("#headerMenuUL").css('display', 'block');
    	}
    	else{
	    	$("#headerMenuUL").css('display', 'none');   		
    	}
    });
});
