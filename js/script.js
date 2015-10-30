// ==============================================================
// 
// COPYRIGHT(C) CYBRiDGE CORPORATION.
// URL:http://www.cybridge.jp/
// 
// CB-STANDARD for HTML5
// --script.js--
// 
// デザイナー向け UI用スクリプト
// 
// デザイナーが扱うJavaScriptは、プラグイン本体を除き、原則全てここに記述し管理する
// script.jsはデフォルトで読み込み、必要な記述以外を削除・整理して使用する
// ※システム案件の場合、JSの管理はエンジニアの指示に従うこと
// 
// ==============================================================

(function($) {
	$(function() {
		
		// ==============================================================
		// Flashの読み込み swfobject.js
		// ==============================================================
		// ファイルパス、読み込み先のID、幅、高さ、FlashPlayerのバージョン、背景色の順番で記述
		if (typeof(swfobject) == "object") {
			swfobject.embedSWF("/media/cybridge_top.swf", "flashContent", "978", "300", "7", "#FFF");
		}
		
		
		// ==============================================================
		// ユーザーエージェント別の処理
		// ==============================================================
		var userAgent = window.navigator.userAgent;
		var appVersion = window.navigator.appVersion;
		
		// ユーザーエージェント判定
		if (userAgent.indexOf("MSIE") > -1) {
			// IE6～7で出現する、a要素foucs時の点線を消去
			if ((appVersion.indexOf("MSIE 7.0") > -1) || (appVersion.indexOf("MSIE 6.0") > -1)) {
				$("a").focus(function() { this.blur(); });
			}
			
		}
		
		
		// ==============================================================
		// ページの先頭へスクロール
		// ==============================================================
		// .pageTop aをクリックでページの先頭へ
		$(".pageTop a").click(function() {
			$("html, body").animate({ scrollTop : 0 });
			return false;
		});
		
		
		// ==============================================================
		// ホバー処理
		// ==============================================================
		$("a.hover, input.hover").hover(function() {
			$(this).fadeTo("fast", 0.6);
		},function(){
			$(this).fadeTo("fast", 1.0);
		});
		
		
		// ==============================================================
		// フェードイン・フェードアウト
		// ==============================================================
		$(".fade").click(function() {
			
			var elm = $(this);
			
			// 次の要素が非表示だった場合は、.fadeに.activeを付与+次の要素をフェードイン
			if (elm.next().is(":hidden")) {
				elm.addClass("active")
					.next()
					.fadeIn();
				
			// 次の要素が表示されていた場合は、.fadeと.activeを削除+次の要素をフェードアウト
			} else {
				elm.removeClass("active")
					.next()
					.fadeOut();
			}
		});
		
		
		// ==============================================================
		// スライド式トグル
		// ==============================================================
		$(".slideToggle").click(function() {
			
			var elm = $(this);
			elm.next().slideToggle(100);
			
			//.slideTogleに.activeが無ければ、.activeを付与
			if (elm.hasClass("active")) {
				elm.removeClass("active");
			} else {
				elm.addClass("active");
			}
		});
		
		
		// ==============================================================
		// アコーディオンパネル
		// ==============================================================
		$(".accordion").click(function() {
			
			var elm = $(this);
			
			// 開閉時の処理
			if (elm.next(".accordionBox").is(":visible")) {
				elm.removeClass("active")
					.next(".accordionBox")
					.slideUp(400);
					
			} else {
				
				// 兄弟要素の.activeを削除した後、クリックした要素に対して.activeを付与
				elm.next(".accordionBox")
					.slideDown(400)
					.siblings(".accordionBox")
					.slideUp(400)
					.siblings(".accordion")
					.removeClass("active");
				elm.addClass("active");
			}
		});
		
		
		// ==============================================================
		// タブメニュー
		// ==============================================================
		$(".tab a").click(function() {
			
			var elm = $(this);
			
			elm.parent("li")
				.siblings()
				.removeClass("active");
			
			elm.parent("li").addClass("active");
			
			// コンテンツ本体である.tabContentsを一旦隠す
			elm.parents(".tab")
				.next()
				.children(".tabBox")
				.hide();
			
			// htmlにはメニューのa要素href属性に
			// 表示したいボックスのIDを記述する
			// 例） <a href="#tab1"> など
			$(this.hash).fadeIn();
			return false;
		});
		
		
		// ==============================================================
		// フォントサイズ変更 jquery.cookie.js
		// ==============================================================
		if ($.cookie) {
			
			var history = $.cookie("fontSize");
			var elm = $("#wrapper");
			
			if (history) {
				elm.addClass(history);
			}
			
			// #fontChange内のli要素に書かれたidをclassに置き換えて#wrapperに付与する
			// 例） <li id="f17">をクリックすると#wrapperに.f17を付与
			// /css/common.cssの.f10～.f26を使用する
			$("#fontChange li").click(function() {
				
				var setFontSize = this.id;
				var siteDomain = location.hostname;
				
				$.cookie("fontSize", setFontSize, {
					path	: "/",
					domain	: siteDomain
				});
				
				elm.removeClass().addClass(setFontSize);
			});
		}
		
		
		// ==============================================================
		// 画像の遅延読み込み jquery.lazyload.js
		// ==============================================================
		// .lazyが付与されたimg要素をスクロールと共にフェードインさせる
		if ($().lazyload) {
			$("img.lazy").lazyload({
				effect		: "fadeIn",
				placeholder	: "/img/module/loading.gif",
				threshold	:"3",
				event		:"scroll"
			});
		}
		
		
		// ==============================================================
		// ライトボックス jquery.colorbox.js
		// ==============================================================
		if ($().colorbox) {
			// 画像をグループ化
			$("a.colorboxGroup").colorbox({
				rel			: "group",
				maxWidth	: "90%",
				maxHeight	: "90%"
			});
			
			// Ajaxで外部ファイル読み込み
			$("a.colorboxAjax").colorbox();
			
			// Youtubeの読み込み
			$("a.colorboxYoutube").colorbox({
				iframe		: true,
				innerWidth	: 425,
				innerHeight	: 344
			});
			
			// iframeで外部サイト読み込み
			$("a.colorboxIframe").colorbox({
				iframe	: true,
				width	:"80%",
				height	: "80%"
			});
			
			// インラインのHTML読み込み
			$("a.colorboxInline").colorbox({
				inline	: true,
				width	: "50%"
			});
		}
		
		
		// ==============================================================
		// ツールチップ jqury.tinyTips.js
		// ==============================================================
		// a.tTipのタイトル属性をツールチップとして表示
		if ($().tinyTips) {
			$("a.tTip").tinyTips("title");
		}
		
		
		// ==============================================================
		// コンテンツスライダー jqury.flexslider.js
		// http://flexslider.woothemes.com/
		// ==============================================================
		if ($().flexslider) {
			// スライダー
			$("div.flexSlider").flexslider({
				animation		: "slide",
				pauseOnAction	: false
			});
			
			// カルーセルパネル
			//itemWidthでボックス単体の横幅を指定
			$("div.flexCarousel").flexslider({
				animation	: "slide",
				itemWidth	: 221,
				itemMargin	: 0
			});
			// last-childが効かないIE対策用に、JSで罫線のスタイルを指定
			$(".carouselBox:last-child article").css("border-right", "none");
		}
	});
})(jQuery);

// ==============================================================
// function divTop()
// ==============================================================
$(window).load(function(){
	$('.thankList li:even').addClass('even');
	$('.memberTable tbody tr:odd').addClass('odd');
	$(".memberTable th img").hover(function() {
		$(this).fadeTo("fast", 0.6);
	},function(){
		$(this).fadeTo("fast", 1.0);
	});
});
$(window).resize(function(){
});
