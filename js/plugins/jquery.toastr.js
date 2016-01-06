// Toastr v2.1.0
(function (e) {
    e(["jquery"], function (e) {
        return function () {
            function u(e, t, n) {
                return w({type: i.error, iconClass: E().iconClasses.error, message: e, optionsOverride: n, title: t})
            }

            function a(n, r) {
                if (!n) {
                    n = E()
                }
                t = e("#" + n.containerId);
                if (t.length) {
                    return t
                }
                if (r) {
                    t = g(n)
                }
                return t
            }

            function f(e, t, n) {
                return w({type: i.info, iconClass: E().iconClasses.info, message: e, optionsOverride: n, title: t})
            }

            function l(e) {
                n = e
            }

            function c(e, t, n) {
                return w({
                    type: i.success,
                    iconClass: E().iconClasses.success,
                    message: e,
                    optionsOverride: n,
                    title: t
                })
            }

            function h(e, t, n) {
                return w({
                    type: i.warning,
                    iconClass: E().iconClasses.warning,
                    message: e,
                    optionsOverride: n,
                    title: t
                })
            }

            function p(e) {
                var n = E();
                if (!t) {
                    a(n)
                }
                if (!m(e, n)) {
                    v(n)
                }
            }

            function d(n) {
                var r = E();
                if (!t) {
                    a(r)
                }
                if (n && e(":focus", n).length === 0) {
                    S(n);
                    return
                }
                if (t.children().length) {
                    t.remove()
                }
            }

            function v(n) {
                var r = t.children();
                for (var i = r.length - 1; i >= 0; i--) {
                    m(e(r[i]), n)
                }
            }

            function m(t, n) {
                if (t && e(":focus", t).length === 0) {
                    t[n.hideMethod]({
                        duration: n.hideDuration, easing: n.hideEasing, complete: function () {
                            S(t)
                        }
                    });
                    return true
                }
                return false
            }

            function g(n) {
                t = e("<div/>").attr("id", n.containerId).addClass(n.positionClass).attr("aria-live", "polite").attr("role", "alert");
                t.appendTo(e(n.target));
                return t
            }

            function y() {
                return {
                    tapToDismiss: true,
                    toastClass: "toast",
                    containerId: "toast-container",
                    debug: false,
                    showMethod: "fadeIn",
                    showDuration: 300,
                    showEasing: "swing",
                    onShown: undefined,
                    hideMethod: "fadeOut",
                    hideDuration: 1e3,
                    hideEasing: "swing",
                    onHidden: undefined,
                    extendedTimeOut: 1e3,
                    iconClasses: {
                        error: "toast-error",
                        info: "toast-info",
                        success: "toast-success",
                        warning: "toast-warning"
                    },
                    iconClass: "toast-info",
                    positionClass: "toast-top-right",
                    timeOut: 5e3,
                    titleClass: "toast-title",
                    messageClass: "toast-message",
                    target: "body",
                    closeHtml: "<button>&times;</button>",
                    newestOnTop: true,
                    preventDuplicates: false
                }
            }

            function b(e) {
                if (!n) {
                    return
                }
                n(e)
            }

            function w(n) {
                function d(t) {
                    if (e(":focus", f).length && !t) {
                        return
                    }
                    return f[i.hideMethod]({
                        duration: i.hideDuration, easing: i.hideEasing, complete: function () {
                            S(f);
                            if (i.onHidden && p.state !== "hidden") {
                                i.onHidden()
                            }
                            p.state = "hidden";
                            p.endTime = new Date;
                            b(p)
                        }
                    })
                }

                function v() {
                    if (i.timeOut > 0 || i.extendedTimeOut > 0) {
                        u = setTimeout(d, i.extendedTimeOut)
                    }
                }

                function m() {
                    clearTimeout(u);
                    f.stop(true, true)[i.showMethod]({duration: i.showDuration, easing: i.showEasing})
                }

                var i = E(), s = n.iconClass || i.iconClass;
                if (i.preventDuplicates) {
                    if (n.message === o) {
                        return
                    } else {
                        o = n.message
                    }
                }
                if (typeof n.optionsOverride !== "undefined") {
                    i = e.extend(i, n.optionsOverride);
                    s = n.optionsOverride.iconClass || s
                }
                r++;
                t = a(i, true);
                var u = null, f = e("<div/>"), l = e("<div/>"), c = e("<div/>"), h = e(i.closeHtml), p = {
                    toastId: r,
                    state: "visible",
                    startTime: new Date,
                    options: i,
                    map: n
                };
                if (n.iconClass) {
                    f.addClass(i.toastClass).addClass(s)
                }
                if (n.title) {
                    l.append(n.title).addClass(i.titleClass);
                    f.append(l)
                }
                if (n.message) {
                    c.append(n.message).addClass(i.messageClass);
                    f.append(c)
                }
                if (i.closeButton) {
                    h.addClass("toast-close-button").attr("role", "button");
                    f.prepend(h)
                }
                f.hide();
                if (i.newestOnTop) {
                    t.prepend(f)
                } else {
                    t.append(f)
                }
                f[i.showMethod]({duration: i.showDuration, easing: i.showEasing, complete: i.onShown});
                if (i.timeOut > 0) {
                    u = setTimeout(d, i.timeOut)
                }
                f.hover(m, v);
                if (!i.onclick && i.tapToDismiss) {
                    f.click(d)
                }
                if (i.closeButton && h) {
                    h.click(function (e) {
                        if (e.stopPropagation) {
                            e.stopPropagation()
                        } else if (e.cancelBubble !== undefined && e.cancelBubble !== true) {
                            e.cancelBubble = true
                        }
                        d(true)
                    })
                }
                if (i.onclick) {
                    f.click(function () {
                        i.onclick();
                        d()
                    })
                }
                b(p);
                if (i.debug && console) {
                    console.log(p)
                }
                return f
            }

            function E() {
                return e.extend({}, y(), s.options)
            }

            function S(e) {
                if (!t) {
                    t = a()
                }
                if (e.is(":visible")) {
                    return
                }
                e.remove();
                e = null;
                if (t.children().length === 0) {
                    t.remove()
                }
            }

            var t;
            var n;
            var r = 0;
            var i = {error: "error", info: "info", success: "success", warning: "warning"};
            var s = {
                clear: p,
                remove: d,
                error: u,
                getContainer: a,
                info: f,
                options: {},
                subscribe: l,
                success: c,
                version: "2.1.0",
                warning: h
            };
            var o;
            return s
        }()
    })
})(typeof define === "function" && define.amd ? define : function (e, t) {
    if (typeof module !== "undefined" && module.exports) {
        module.exports = t(require("jquery"))
    } else {
        window["toastr"] = t(window["jQuery"])
    }
});