(function($) {
	$(document).ready(function() {
		$(window).resize();
		
		//주소검색
		$("#map_search").click(function() {
			if($("#naver_map_api_key").val() == "") {
				show_msg(msg_object.check_key);
				return false;
			}
			if($("#query").val() == "") {
				show_msg(msg_object.check_address);
				return false;
			}
			$.post(ajax_object.ajax_url, {
				action : 'request_geo_code',
				query : $("#query").val()
			}, function(data) {
				responseData(data);
			});
		});

		//지도 타입 버튼
		$("#mtb").click(function() {
			if ($(this).attr("checked")) {
				oMap.addControl(mapTypeChangeButton);
			} else {
				oMap.removeControl(mapTypeChangeButton);
			}
			shortCode();
		});

		//실시간 교통지도 버튼
		$("#tmb").click(function() {
			if ($(this).attr("checked")) {
				oMap.addControl(trafficButton);
			} else {
				oMap.removeControl(trafficButton);
			}
			shortCode();
		});

		//줌 컨트롤 버튼
		$("#zcb").click(function() {
			if ($(this).attr("checked")) {
				oMap.addControl(mapZoom);
			} else {
				oMap.removeControl(mapZoom);
			}
			shortCode();
		});

		//줌 레벨
		$("#zl").change(function() {
			oMap.setLevel($(this).val());
			shortCode();
		});

		//마커 제목
		$("#mt").change(function() {
			oMarker.setTitle($(this).val());
			oLabel.setVisible(true, oMarker);
			shortCode();
		});
		
		//지도 크기 설정
		$("#mzw").change(function() {
			if (!($(this).val() == 0 || $(this).val() == "") && !($("#mzh").val() == 0 || $("#mzh").val() == "")) {
				mapSize($(this).val(), $("#mzh").val());
			}
		});
		
		$("#mzh").change(function() {
			if (!($(this).val() == 0 || $(this).val() == "") && !($("#mzh").val() == 0 || $("#mzh").val() == "")) {
				mapSize($("#mzw").val(), $(this).val());
			}
		});
		
		//반응형 옵션
		$("#r").click(function() {
			if ($(this).attr("checked")) {
				$("#mzw").attr("disabled", "disabled");
				$("#mzh_desc").removeClass("desc-info");
			} else {
				$("#mzw").removeAttr("disabled");
				$("#mzh_desc").addClass("desc-info");
			}
			shortCode();
		});

		/*
		$("#result_msg").mouseover(function() {
			$(this).text("");
			$(this).removeClass("result_msg");
		});
		*/
		
		$("#query").keypress(function(e) {
		    if(e.which == 13) {
		    	$("#map_search").click();
		    }
		});	
		
		$("#mzh_desc").addClass("desc-info");
	});
	
	function liHoverIn() {
		$(this).addClass("li_hover");
	}
	
	function liHoverOut() {
		$(this).removeClass("li_hover");
	}
	
	function show_msg(val) {
		$("#result_msg").addClass("result_msg");
		$("#result_msg").text(val);
	}
	
	function responseData(data) {
		var xmlDoc = $.parseXML(data);
	    var $xml = $( xmlDoc);
		var error_code = $xml.find("e").text();
		var total_cnt  = $xml.find("t").text();
		
		if (error_code == "010") {
			show_msg(msg_object.res_error_010);
		} else if (error_code == "011") {
			show_msg(msg_object.res_error_011);
		} else if (error_code == "020") {
			show_msg(msg_object.res_error_020);
		} else if (error_code == "200") {
			show_msg(msg_object.res_error_200);
		} else {
			if (total_cnt == "0") {
				show_msg(msg_object.res_success_01); 
			} else {
				show_msg(msg_object.res_success_02 + total_cnt); 

				//<li data-x="743594" data-y="743594">경상북도 울릉군 울릉읍 독도리 30</li>
				var items = [];
				$xml.find("i").each(function(idx) {
			        items.push("<li data-x=\"" + $(this).find("x").text() + "\" data-y=\"" + $(this).find("y").text() + "\">" + $(this).find("d").text() + "</li>");
			    });
				
			    $("#address_list li").remove();
			    $("#address_list").append(items.join(""));
			    addressHover();
			    $("#address_list li:first").trigger("click");
			}
		}
		//$("#log").text(data);
	}
	
	function changedMap(mapX, mapY) {
		oPoint.set(mapX, mapY);
		oMap.setCenter(oPoint);
		oMarker.setPoint(oMap.getCenter());
		oLabel.setVisible(true, oMarker);
		
		oMarker.setTitle("");
		oLabel.setVisible(true, oMarker);
		$("#mt").val("").focus();
		
	}
	
	function mapSize(mapW, mapH) {
		oMap.setSize(new nhn.api.map.Size(mapW, mapH));
		shortCode();
	}

	function shortCode() {
		var valArr = [];
		valArr.push("naver-map");
		if ($("#mpx").val() != "") valArr.push("x=\"" + $("#mpx").val() + "\"");
		if ($("#mpy").val() != "") valArr.push("y=\"" + $("#mpy").val() + "\"");
		valArr.push("r=\"" + ($("#r").attr("checked") ? true : false) + "\"");
		valArr.push("w=\"" + $("#mzw").val() + "\"");
		valArr.push("h=\"" + $("#mzh").val() + "\"");
		valArr.push("mt=\"" + $("#mt").val() + "\"");
		valArr.push("mtb=\"" + ($("#mtb").attr("checked") ? true : false) + "\"");
		valArr.push("tmb=\"" + ($("#tmb").attr("checked") ? true : false) + "\"");
		valArr.push("zcb=\"" + ($("#zcb").attr("checked") ? true : false) + "\"");
		valArr.push("zl=\"" + $("#zl").val() + "\"");
		
		$("#mapshortcode").val("[" + valArr.join(" ") + "]");
	}
	
	function addressHover() {
		$("#address_list li").click(function() {
			$("#address_list li").removeClass("curr_addr");
			$(this).addClass("curr_addr");
			
			$("#mpx").val($(this).data("x"));
			$("#mpy").val($(this).data("y"));
			changedMap($("#mpx").val(), $("#mpy").val());
			shortCode();
		});
	}
	
	function resizeMap(oMap, minHeight) {
		$(window).resize(function(){
			var resizeWidth = $("#map_area").width();
			var resizeHeight = resizeWidth / 2;
			resizeHeight = (resizeHeight < minHeight ? minHeight : resizeHeight);
			oMap.setSize(new nhn.api.map.Size(resizeWidth, resizeHeight));
		});
	}
})(jQuery);
