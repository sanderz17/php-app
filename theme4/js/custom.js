var SITEURL = $("#SITEURL").val();
$(".profile-dropdown").hide(), $(".profile a").click(function() { $(".profile-dropdown").slideToggle() }), $(".language-dropdown").hide(), $(".language-header").click(function() { $(".language-dropdown").slideToggle() }), $(document).ready(function() { $("#close-btn").click(function() { $("#search-overlay").fadeOut(), $("#search-btn").show() }), $("#search-btn").click(function() { $(this).hide(), $("#search-overlay").fadeIn() }) }), $(".size-caliber-control li a").mouseenter(function() {
    var e = $(this).position();
    $(this).find(".tooltipli").css("top", e.top + 40 + "px").fadeIn()
}).mouseleave(function() { $(this).find(".tooltipli").fadeOut() }), $(".caliber-slider").slick({ dots: !1, arrows: !1, infinite: !0, speed: 300, autoplay: !1, autoplaySpeed: 2e3, slidesToShow: 10, slidesToScroll: 6, responsive: [{ breakpoint: 1025, settings: { slidesToShow: 2, slidesToScroll: 1 } }, { breakpoint: 768, settings: { slidesToShow: 2, slidesToScroll: 1 } }, { breakpoint: 576, settings: { slidesToShow: 1, slidesToScroll: 1 } }] }), $(".Bought_Together").slick({ dots: !1, arrows: !1, infinite: !0, speed: 300, autoplay: !1, autoplaySpeed: 2e3, slidesToShow: 10, slidesToScroll: 6, responsive: [{ breakpoint: 1025, settings: { slidesToShow: 2, slidesToScroll: 1 } }, { breakpoint: 768, settings: { slidesToShow: 2, slidesToScroll: 1 } }, { breakpoint: 576, settings: { slidesToShow: 1, slidesToScroll: 1 } }] });
var stickyEl = document.querySelector(".me_sticky"),
    stickyPosition = stickyEl.getBoundingClientRect().top,
    offset = -20;
window.addEventListener("scroll", function() { window.pageYOffset >= stickyPosition + offset ? (stickyEl.style.position = "fixed", stickyEl.style.top = "0px", stickyEl.style.background = "rgb(197, 52, 64)") : (stickyEl.style.position = "static", stickyEl.style.top = "", stickyEl.style.background = "") }), AOS.init(), $(document).ready(function() {
    $(window).on("load scroll", function() {
        var e = $(".parallax_scroll"),
            s = e.length;
        window.requestAnimationFrame(function() {
            for (var i = 0; i < s; i++) {
                var o = e.eq(i),
                    l = $(window).scrollTop(),
                    t = o.offset().top,
                    n = o.height(),
                    a = l - t + (.5 * window.innerHeight - .5 * n);
                o.css({ transform: "translate3d(0," + -.25 * a + "px, 0)" })
            }
        })
    })
}), $(".product-slider").slick({ dots: !0, arrows: !1, infinite: !0, speed: 300, autoplay: !0, autoplaySpeed: 2e3, slidesToShow: 3, slidesToScroll: 1, responsive: [{ breakpoint: 1025, settings: { slidesToShow: 2, slidesToScroll: 1 } }, { breakpoint: 768, settings: { slidesToShow: 2, slidesToScroll: 1 } }, { breakpoint: 576, settings: { slidesToShow: 1, slidesToScroll: 1 } }] }), $(".category-slider").slick({ dots: !1, arrows: !0, infinite: !0, autoplay: !0, autoplaySpeed: 1e3, slidesToShow: 5, slidesToScroll: 1, responsive: [{ breakpoint: 1025, settings: { slidesToShow: 3, slidesToScroll: 1 } }, { breakpoint: 768, settings: { slidesToShow: 2, slidesToScroll: 1 } }, { breakpoint: 576, settings: { slidesToShow: 1, slidesToScroll: 1 } }] }), $(".compatible-slider").slick({ dots: !1, arrows: !0, infinite: !0, autoplay: !0, autoplaySpeed: 3e3, slidesToShow: 3, slidesToScroll: 1, responsive: [{ breakpoint: 1140, settings: { slidesToShow: 3, slidesToScroll: 1 } }, { breakpoint: 800, settings: { slidesToShow: 3, slidesToScroll: 1 } }, { breakpoint: 610, settings: { slidesToShow: 2, slidesToScroll: 1 } }, { breakpoint: 425, settings: { slidesToShow: 1, slidesToScroll: 1 } }] }), $(".news-slider").slick({ dots: !0, arrows: !1, infinite: !1, autoplay: !0, speed: 300, slidesToShow: 4, slidesToScroll: 4, responsive: [{ breakpoint: 1024, settings: { slidesToShow: 3, slidesToScroll: 3, infinite: !0 } }, { breakpoint: 600, settings: { slidesToShow: 2, slidesToScroll: 2 } }, { breakpoint: 480, settings: { slidesToShow: 1, slidesToScroll: 1 } }] }), $(".testi-slider").slick({ dots: !0, arrows: !1, infinite: !0, centerMode: !0, speed: 300, autoplay: !0, autoplaySpeed: 2e3, slidesToShow: 3, slidesToScroll: 1, responsive: [{ breakpoint: 1025, settings: { centerMode: !1, slidesToShow: 2, slidesToScroll: 2 } }, { breakpoint: 768, settings: { centerMode: !1, slidesToShow: 2, slidesToScroll: 2 } }, { breakpoint: 576, settings: { centerMode: !1, slidesToShow: 1, slidesToScroll: 1 } }] }), $(document).ready(function() {
    var e = $("#resp-menu"),
        s = $(".sidebar-navigation");
    $(e).on("click", function(e) { e.preventDefault(), s.slideToggle() })
}), $(function() {
    var e = $(".sidebar-navigation > ul");
    e.find("li a").click(function(s) {
        var i = $(this).parent();
        i.find("ul").length > 0 && (s.preventDefault(), i.hasClass("selected") ? (i.removeClass("selected").find("li").removeClass("selected"), i.find("ul").slideUp(400), i.find("a em").removeClass("mdi-flip-v")) : (0 == i.parents("li.selected").length ? (e.find("li").removeClass("selected"), e.find("ul").slideUp(400), e.find("li a em").removeClass("mdi-flip-v")) : (i.parent().find("li").removeClass("selected"), i.parent().find("> li ul").slideUp(400), i.parent().find("> li a em").removeClass("mdi-flip-v")), i.addClass("selected"), i.find(">ul").slideDown(400), i.find(">a>em").addClass("mdi-flip-v")))
    }), $(".sidebar-navigation > ul ul").each(function(e) {
        if ($(this).find(">li>ul").length > 0) {
            var s = $(this).parent().parent().find(">li>a").css("padding-left"),
                i = parseInt(s) + 10;
            $(this).find(">li>a").css("padding-left", i)
        } else {
            s = $(this).parent().parent().find(">li>a").css("padding-left"), i = parseInt(s) + 20;
            $(this).find(">li>a").css("padding-left", i).parent().addClass("selected--last")
        }
    });
    for (var s = 1; s <= 10; s++) $(".sidebar-navigation > ul > " + " li > ul ".repeat(s)).addClass("subMenuColor" + s);
    var i = $("li.selected");
    i.length && function e(s) {
        var i = s.closest("ul");
        if (i.length) {
            if (s.addClass("selected"), i.addClass("open"), s.find(">a>em").addClass("mdi-flip-v"), !i.closest("li").length) return !1;
            e(i.closest("li"))
        }
    }(i)
}), $(function() { $(".slider-thumb").slick({ autoplay: !0, vertical: !0, infinite: !1, verticalSwiping: !0, slidesPerRow: 4, slidesToShow: 4, asNavFor: ".slider-preview", focusOnSelect: !0, prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-up"></i></button>', nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-down"></i></button>', responsive: [{ breakpoint: 767, settings: { vertical: !1 } }, { breakpoint: 479, settings: { vertical: !1, slidesPerRow: 3, slidesToShow: 3 } }] }), $(".slider-preview").slick({ autoplay: !1, vertical: !0, infinite: !0, slidesPerRow: 1, slidesToShow: 1, asNavFor: ".slider-thumb", arrows: !1, draggable: !1, responsive: [{ breakpoint: 767, settings: { vertical: !1, fade: !0 } }] }) }), $(".alternate-images-slider").slick({ dots: !0, arrows: !1, infinite: !0, speed: 300, autoplay: !0, autoplaySpeed: 2e3, slidesToShow: 1, slidesToScroll: 1 }), document.onreadystatechange = function() { var e = document.readyState; "interactive" == e ? $(".preloader").show() : "complete" == e && setTimeout(function() { document.getElementById("interactive"), $(".preloader").hide() }, 1e3) }, $(".google-trales").click(function() {});