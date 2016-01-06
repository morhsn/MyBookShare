/*!
 * animsition v3.6.0
 * A simple and easy jQuery plugin for CSS animated page transitions.
 * http://blivesta.github.io/animsition
 * License : MIT
 * Author : blivesta (http://blivesta.com/)
 */
!function (n) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], n) : "object" == typeof exports ? module.exports = n(require("jquery")) : n(jQuery)
}(function (n) {
    "use strict";
    var i = "animsition", a = !1, t = {
        init: function (o) {
            o = n.extend({
                inClass: "fade-in",
                outClass: "fade-out",
                inDuration: 1500,
                outDuration: 800,
                linkElement: ".animsition-link",
                loading: !0,
                loadingParentElement: "body",
                loadingClass: "animsition-loading",
                loadingHtml: '<div class="css3-spinner-bounce1"></div><div class="css3-spinner-bounce2"></div><div class="css3-spinner-bounce3"></div>',
                unSupportCss: ["animation-duration", "-webkit-animation-duration", "-o-animation-duration"],
                overlay: !1,
                overlayClass: "animsition-overlay-slide",
                overlayParentElement: "body",
                timeOut: !1
            }, o);
            var e = t.supportCheck.call(this, o);
            if (!e && o.unSupportCss.length > 0 && (!e || !this.length))return "console" in window || (window.console = {}, window.console.log = function (n) {
                return n
            }), this.length || console.log("Animsition: Element does not exist on page."), e || console.log("Animsition: Does not support this browser."), t.destroy.call(this);
            var s = t.optionCheck.call(this, o);
            return s && t.addOverlay.call(this, o), o.loading && t.addLoading.call(this, o), this.each(function () {
                var e = this, s = n(this), l = n(window), r = s.data(i);
                if (!r) {
                    if (o = n.extend({}, o), s.data(i, {options: o}), l.on("load." + i + " pageshow." + i, function () {
                            0 == a && t.pageIn.call(e)
                        }), o.timeOut && !isNaN(o.timeOut)) {
                        setTimeout(function () {
                            0 == a && t.pageIn.call(e)
                        }, o.timeOut)
                    }
                    l.on("unload." + i, function () {
                    }), n(o.linkElement).on("click." + i, function (i) {
                        i.preventDefault();
                        var a = n(this), o = a.attr("href");
                        2 === i.which || i.metaKey || i.shiftKey || -1 !== navigator.platform.toUpperCase().indexOf("WIN") && i.ctrlKey ? window.open(o, "_blank") : t.pageOut.call(e, a, o)
                    })
                }
            })
        }, addOverlay: function (i) {
            n(i.overlayParentElement).prepend('<div class="' + i.overlayClass + '"></div>')
        }, addLoading: function (i) {
            n(i.loadingParentElement).append('<div class="' + i.loadingClass + '">' + i.loadingHtml + '</div>')
        }, removeLoading: function () {
            var a = n(this), t = a.data(i).options, o = n(t.loadingParentElement).children("." + t.loadingClass);
            o.fadeOut().remove()
        }, supportCheck: function (i) {
            var a = n(this), t = i.unSupportCss, o = t.length, e = !1;
            0 === o && (e = !0);
            for (var s = 0; o > s; s++)if ("string" == typeof a.css(t[s])) {
                e = !0;
                break
            }
            return e
        }, optionCheck: function (i) {
            var a, t = n(this);
            return a = i.overlay || t.data("animsition-overlay") ? !0 : !1
        }, animationCheck: function (a, t, o) {
            var e = n(this), s = e.data(i).options, l = typeof a, r = !t && "number" === l, c = t && "string" === l && a.length > 0;
            return r || c ? a = a : t && o ? a = s.inClass : !t && o ? a = s.inDuration : t && !o ? a = s.outClass : t || o || (a = s.outDuration), a
        }, pageIn: function () {
            var o = this, e = n(this), s = e.data(i).options, l = e.data("animsition-in-duration"), r = e.data("animsition-in"), c = t.animationCheck.call(o, l, !1, !0), d = t.animationCheck.call(o, r, !0, !0), u = t.optionCheck.call(o, s);
            s.loading && t.removeLoading.call(o), u ? t.pageInOverlay.call(o, d, c) : t.pageInBasic.call(o, d, c), a = !0
        }, pageInBasic: function (i, a) {
            var t = n(this);
            t.trigger("animsition.start").css({"animation-duration": a / 1e3 + "s"}).addClass(i).animateCallback(function () {
                t.removeClass(i).css({opacity: 1}).trigger("animsition.end")
            })
        }, pageInOverlay: function (a, t) {
            var o = n(this), e = o.data(i).options;
            o.trigger("animsition.start").css({opacity: 1}), n(e.overlayParentElement).children("." + e.overlayClass).css({"animation-duration": t / 1e3 + "s"}).addClass(a).animateCallback(function () {
                o.trigger("animsition.end")
            })
        }, pageOut: function (a, o) {
            var e = this, s = n(this), l = s.data(i).options, r = a.data("animsition-out"), c = s.data("animsition-out"), d = a.data("animsition-out-duration"), u = s.data("animsition-out-duration"), m = r ? r : c, h = d ? d : u, p = t.animationCheck.call(e, m, !0, !1), f = t.animationCheck.call(e, h, !1, !1), g = t.optionCheck.call(e, l);
            g ? t.pageOutOverlay.call(e, p, f, o) : t.pageOutBasic.call(e, p, f, o)
        }, pageOutBasic: function (i, a, t) {
            var o = n(this);
            o.css({"animation-duration": a / 1e3 + "s"}).addClass(i).animateCallback(function () {
                location.href = t
            })
        }, pageOutOverlay: function (a, o, e) {
            var s = this, l = n(this), r = l.data(i).options, c = l.data("animsition-in"), d = t.animationCheck.call(s, c, !0, !0);
            n(r.overlayParentElement).children("." + r.overlayClass).css({"animation-duration": o / 1e3 + "s"}).removeClass(d).addClass(a).animateCallback(function () {
                location.href = e
            })
        }, destroy: function () {
            return this.each(function () {
                var a = n(this);
                n(window).unbind("." + i), a.css({opacity: 1}).removeData(i)
            })
        }
    };
    n.fn.animateCallback = function (i) {
        var a = "animationend webkitAnimationEnd mozAnimationEnd oAnimationEnd MSAnimationEnd";
        return this.each(function () {
            n(this).bind(a, function () {
                return n(this).unbind(a), i.call(this)
            })
        })
    }, n.fn.animsition = function (a) {
        return t[a] ? t[a].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof a && a ? void n.error("Method " + a + " does not exist on jQuery." + i) : t.init.apply(this, arguments)
    }
});