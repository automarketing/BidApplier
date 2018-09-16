$(function () {
    new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('bar'));
    getMorris('donut1', 'donut_chart1');
	getMorris('donut2', 'donut_chart2');
	getMorris('donut3', 'donut_chart3');
});

function getChartJs(type) {
    var config = null;

    if (type === 'bar') {
        config = {
            type: 'bar',
            data: {
                labels: ["Oct 10", "Oct 13", "Oct 16", "Oct 19", "Oct 22"],
                datasets: [{
                    label: "My First dataset",
                    data: [65, 59, 80, 87, 95],
                    backgroundColor: 'rgb(233, 239, 242)'
                }, {
                        label: "My Second dataset",
                        data: [28, 48, 40, 48, 53],
                        backgroundColor: 'rgb(178, 197, 205)'
                    }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    }
    return config;
}

function getMorris(type, element) {
    if (type === 'donut1') {
        Morris.Donut({
            element: element,
            data: [{
                	label: 'Visitor',
                	value: 600
            	},
				{
                    label: 'Active',
                    value: 750
                }],
            colors: ['rgb(118, 142, 152)', 'rgb(243, 243, 243)'],
            formatter: function (y) {
                return y;
            }
        });
    }
	if (type === 'donut2') {
        Morris.Donut({
            element: element,
            data: [{
                    label: 'Returned',
                    value: 2513
                }, {
                    label: 'Active',
                    value: 750
                }],
            colors: ['rgb(118, 142, 152)', 'rgb(243, 243, 243)'],
            formatter: function (y) {
                return y;
            }
        });
    }
	if (type === 'donut3') {
        Morris.Donut({
            element: element,
            data: [{
                	label: 'Visitor',
                	value: 1520
            	}, {
                    label: 'Returned',
                    value: 675
                }],
            colors: ['rgb(118, 142, 152)', 'rgb(243, 243, 243)'],
            formatter: function (y) {
                return y;
            }
        });
    }
}

$(document).ready(function() {

    $('.datePickerInput').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $("[id^=channelListTableDataTR_]").on('dblclick', function(event) {
    	event.preventDefault();

        var rowID = this.id;
        var channelUID = rowID.replace('channelListTableDataTR_', '');
        var channelUrl = $("#channelListTableDataTRChannelUrl_"+channelUID).text();

	    videojs('channelUrlVideoPlayer').ready(function() {
	    	var playerObj = this;

	    	playerObj.load();

	    	if(channelUrl != ""){
	    		$("#channelUrlVideoShowModal").modal("show");

				playerObj.pause();
				playerObj.src({type: 'application/x-mpegURL', src: channelUrl});
				playerObj.load();
				playerObj.play();
	    	}
	    	else{
	    		alert("This channel url is empty.");
	    	}
	    });
    });

    $("#channelUrlVideoShowModalCloseModal").on('click', function(event) {
    	event.preventDefault();
    	/* Act on the event */
	    videojs('channelUrlVideoPlayer').ready(function() {
	    	var playerObj = this;
	    	playerObj.load();
			playerObj.pause();
	    });

    	$("#channelUrlVideoShowModal").modal("hide");
    });

    // for masjid video url test play in masjid video add modal popup
    var masjidVideoListAddVideoPlayerPlayStatus = "pause";
    	
    $("#masjidVideoListAddUrlVideoCheckBtn").on('click', function(event) {
    	event.preventDefault();
    	
	    videojs('masjidVideoListAddVideoPlayer').ready(function() {
	    	var playerObj = this;
	    	playerObj.load();

	    	var masjidVideoListAddUrlInput = $("#masjidVideoListAddUrlInput").val();
	    	if(masjidVideoListAddUrlInput != ""){
	    		if(masjidVideoListAddVideoPlayerPlayStatus == "pause"){
					playerObj.pause();
					playerObj.src({type: 'video/mp4', src: masjidVideoListAddUrlInput});
					playerObj.load();
					playerObj.play();

					masjidVideoListAddVideoPlayerPlayStatus = "play";
					$("#masjidVideoListAddUrlVideoCheckBtn").html("<span class='glyphicon glyphicon-pause' aria-hidden='true'></span>");
	    		}
	    		else if(masjidVideoListAddVideoPlayerPlayStatus == "play"){
					playerObj.pause();

					masjidVideoListAddVideoPlayerPlayStatus = "pause";
					$("#masjidVideoListAddUrlVideoCheckBtn").html("<span class='glyphicon glyphicon-play' aria-hidden='true'></span>");
	    		}
	    	}
	    	else{
	    		alert("Masjid Video URL cannot be empty.");
	    	}
	    });
    });

    // for masjid video url test play in masjid video edit modal popup
    var masjidVideoListEditVideoPlayerPlayStatus = "pause";
    	
    $("#masjidVideoListEditUrlVideoCheckBtn").on('click', function(event) {
    	event.preventDefault();

	    videojs('masjidVideoListEditVideoPlayer').ready(function() {
	    	var playerObj = this;
	    	playerObj.load();

	    	var masjidVideoListEditUrlInput = $("#masjidVideoListEditUrlInput").val();
	    	if(masjidVideoListEditUrlInput != ""){
	    		if(masjidVideoListEditVideoPlayerPlayStatus == "pause"){
					playerObj.pause();
					playerObj.src({type: 'video/mp4', src: masjidVideoListEditUrlInput});
					playerObj.load();
					playerObj.play();

					masjidVideoListEditVideoPlayerPlayStatus = "play";
					$("#masjidVideoListEditUrlVideoCheckBtn").html("<span class='glyphicon glyphicon-pause' aria-hidden='true'></span>");
	    		}
	    		else if(masjidVideoListEditVideoPlayerPlayStatus == "play"){
					playerObj.pause();

					masjidVideoListEditVideoPlayerPlayStatus = "pause";
					$("#masjidVideoListEditUrlVideoCheckBtn").html("<span class='glyphicon glyphicon-play' aria-hidden='true'></span>");
	    		}
	    	}
	    	else{
	    		alert("Masjid Video URL cannot be empty.");
	    	}
	    });
    });


        // $("[id^=channelListTableDataTR_]").on("dblclick", function(event) {
        //     /* Act on the event */
        //     var rowID = this.id;
        //     var channelUID = rowID.replace('channelListTableDataTR_', '');
        //     var channelUrl = $("#channelListTableDataTRChannelUrl_"+channelUID).text();
        // });


		// $(".showVideoPopup").click(function() {
		// 	var urlData = $(this).data("url");
		// 	popular(urlData);
		// 	$.fancybox.open({
		// 		href : "/Kawnain/user/custom/platform?vdo_url="+urlData,
		// 		type : 'iframe',
		// 		padding : 5,
		// 		width: 650,
		// 		height: 350,
		// 		fitToView: true
		// 	});
		// });



	// $("[id^=subscriberTableDataTR_]").click(function() {

	// 	var subscriberTableDataTRId = this.id;
	// 	var subscriberUid = $("#"+subscriberTableDataTRId).data('uid');

	// 	$.fancybox.open({
	// 	// 	// href : 'custom-video.php?vdo_url='+urlData,
	// 		content: "<div>hello there...</div>",
	// 		hideOnOverlayClick:false,
	// 	    hideOnContentClick:false
	// 	// 	type : 'iframe',
	// 	// 	padding : 2,
	// 	// 	width: 650,
	// 	// 	height: 350,
	// 	// 	autoScale: false,
	// 	// 	autoDimensions: false,
	// 	// 	autoCenter: true
	// 	});
	// });

	

});