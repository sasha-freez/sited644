function DragManager() {
    "use strict";

    function e() {
        s = new DragTouch({
            start: n,
            move: a,
            end: i,
            flick: o,
            velocityStop: r
        }), l = _.throttle(t, 50), window.addEventListener("devicemotion", l)
    }

    function t(e) {
        var t = e.accelerationIncludingGravity,
            n = t.x,
            i = t.y,
            a = !1;
        0 === Math.round(n) && 0 === Math.round(i) && (a = !0);
        var o = 0,
            r = 0;
        window.innerWidth > window.innerHeight ? (o = i, r = n, o = -o) : (o = n, r = i), r += 6, o = -o;
        r < -1.5 ? r = -1.5 : r > 1.5 && (r = 1.5), o < -1.5 ? o = -1.5 : o > 1.5 && (o = 1.5);
        var s = (o + 1.5) / 3,
            l = (r + 1.5) / 3;
        d.currentScroll.accPercX = s, d.currentScroll.accPercY = l, d.currentScroll.isFlat = a
    }

    function n(e, t) {
        d.currentScroll.startX = e, d.currentScroll.startY = t, d.dispatchEvent(DragManager.DRAG_START)
    }

    function i(e) {
        d.dispatchEvent(DragManager.DRAG_STOP, {
            movementSpeed: e
        })
    }

    function a(e, t) {
        d.currentScroll.x = e, d.currentScroll.y = t, d.dispatchEvent(DragManager.DRAG_MOVE)
    }

    function o(e) {
        d.dispatchEvent(DragManager.DRAG_FLICK, {
            direction: e
        })
    }

    function r(e) {
        d.dispatchEvent(DragManager.EASE_STOP)
    }
    DragManager.DRAG_START = "dragstart", DragManager.DRAG_MOVE = "dragmove", DragManager.DRAG_STOP = "dragstop", DragManager.DRAG_FLICK = "dragflick", DragManager.EASE_STOP = "easestop";
    var s, l, d = new EventDispatcher;
    return d.isClicking = !1, d.currentScroll = {
            x: 0,
            y: 0,
            startX: 0,
            startY: 0,
            accPercX: 0,
            accPercY: 0,
            isFlat: !1
        }, d.reset = function() {
            d.currentScroll = {
                x: 0,
                y: 0,
                startX: 0,
                startY: 0
            }, s.reset()
        }, d.setDragX = function(e, t) {
            d.currentScroll.y = e, s.updateDragX(e, t)
        }, d.setScrollWidth = function(e) {
            s.setMax(e), Model.resizeManager.refresh(!0)
        }, d.getScrollRange = function() {
            return s.maxDragX
        },
        function() {
            e()
        }(), d
}

function DragTouch(e) {
    function t() {
        window.addEventListener("touchstart", i, !1), window.addEventListener("touchend", o, !1), window.addEventListener("touchmove", n, !1)
    }

    function n(e) {
        if (!e.target.classList.contains("home-panel__cta")) {
            var t = e.touches[0] || e;
            l = t.pageX, d = t.pageY
        }
    }

    function i(t) {
        if (Model.dragManager.isClicking = !0, t.target.classList.contains("svg--hamburger") || t.target.classList.contains("svg--hamburger__shape") || t.target.classList.contains("home-panel__cta") || t.target.classList.contains("svg--arrow") || t.target.classList.contains("compact-timeline__arrow") || t.target.classList.contains("expanded-timeline__arrow") || t.target.classList.contains("expanded-timeline__arrow-svg-container") || t.target.classList.contains("athlete-timeline__gyroscope") || t.target.classList.contains("quote-panel__next-button-text") || t.target.classList.contains("quote-panel__next-button-bg") || t.target.classList.contains("quote-panel__next-button") || t.target.classList.contains("athlete-overlay__next-button") || t.target.classList.contains("athlete-overlay__previous-button") || t.target.classList.contains("athlete-timeline__zoom-button") || t.target.classList.contains("athlete-overlay__more-button") || t.target.classList.contains("athlete-overlay__less-button")) return void(u = !0);
        t.touches && t.touches.length > 1 && t.preventDefault(), g = !1;
        var n = t.touches[0] || t;
        l = n.pageX, d = n.pageY, c = null, s = 0, TweenLite.ticker.addEventListener("tick", a), e.start && e.start(l, d)
    }

    function a(t) {
        if (g !== !0) {
            var n = 0;
            if (c) {
                if (c === l) return;
                n = Math.max(l, c) - Math.min(l, c)
            }
            l > c && (n = -n), (n < -1 || n > 1) && (Model.dragManager.isClicking = !1);
            n > 150 && (n = 150), n < -150 && (n = -150), c = l, s = n, e.move && e.move(l, d)
        }
    }

    function o(t) {
        if (TweenLite.ticker.removeEventListener("tick", a), u === !0) return void(u = !1);
        e.end && e.end(s), setTimeout(function() {
            Model.dragManager.isClicking = !1
        }, 300)
    }
    var r = {};
    r.dragX = 0, r.maxDragX;
    var s, l, d, c = null,
        u = !1,
        g = !1;
    return r.reset = function() {
            c = null, l = 0, r.dragX = 0, s = 0, e.move && e.move()
        }, r.updateDragX = function(e, t) {
            c = e, s = 0, l = e, r.dragX = e, t || a()
        }, r.setMax = function(e) {
            r.maxDragX = e
        },
        function() {
            t()
        }(), r
}

function EventDispatcher() {
    "use strict";

    function e() {
        if (a === !0) {
            var e, t, i = n.length,
                o = [];
            for (e = 0; i > e; e += 1) t = n[e], t.kill === !1 && o.push(t);
            a = !1, n = o
        }
    }
    var t, n = [],
        i = this,
        a = !1;
    i.addEventListener = function(e, t) {
        n.push({
            name: e,
            callback: t,
            kill: !1
        })
    }, i.removeEventListener = function(e, t) {
        var i, o, r = n.length;
        for (i = 0; r > i; i += 1) o = n[i], o.name === e && o.callback === t && (o.kill = !0, a = !0)
    }, i.dispatchEvent = function(i, a) {
        clearTimeout(t), t = setTimeout(e, 1e3);
        var o, r, s = n.length;
        for (o = 0; s > o; o += 1)
            if (r = n[o], r.name === i) {
                if (r.kill === !0) continue;
                r.callback(a)
            }
    }
}

function MouseManager() {
    "use strict";

    function e() {
        window.addEventListener("mousemove", t)
    }

    function t(e) {
        n.settings.x = e.clientX, n.settings.y = e.clientY, n.dispatchEvent(MouseManager.MOUSE_MOVE, e)
    }
    MouseManager.MOUSE_MOVE = "custommousemove";
    var n = new EventDispatcher;
    return n.supportsPointerEvents = !1, n.settings = {
            x: 0,
            y: 0
        },
        function() {
            n.supportsPointerEvents = !1, e()
        }(), n
}

function ResizeManager() {
    "use strict";

    function e() {
        window.addEventListener("resize", _.throttle(o, 200)), window.addEventListener("resize", _.debounce(a, 300)), window.addEventListener("orientationchange", r)
    }

    function t() {
        s.settings.windowWidth = window.innerWidth - d, s.settings.windowHeight = window.innerHeight, s.settings.documentWidth = n(), s.settings.documentHeight = i()
    }

    function n() {
        return l
    }

    function i() {
        var e = document.body,
            t = document.documentElement;
        return Math.max(e.scrollHeight, e.offsetHeight, t.clientHeight, t.scrollHeight, t.offsetHeight)
    }

    function a(e) {
        t(), s.dispatchEvent(ResizeManager.RESIZE), s.dispatchEvent(ResizeManager.LAST_RESIZE)
    }

    function o(e) {
        t(), s.dispatchEvent(ResizeManager.RESIZE)
    }

    function r(e) {
        t(), s.dispatchEvent(ResizeManager.RESIZE), s.dispatchEvent(ResizeManager.LAST_RESIZE), s.dispatchEvent(ResizeManager.ORIENTATION_CHANGE), setTimeout(function() {
            s.dispatchEvent(ResizeManager.ORIENTATION_CHANGE)
        }, 500), setTimeout(function() {
            s.dispatchEvent(ResizeManager.ORIENTATION_CHANGE)
        }, 1e3)
    }
    ResizeManager.RESIZE = "resize", ResizeManager.LAST_RESIZE = "lastresize", ResizeManager.ORIENTATION_CHANGE = "orientationchange";
    var s = new EventDispatcher,
        l = 0,
        d = 0;
    return s.settings = {
            windowWidth: 0,
            windowHeight: 0,
            documentWidth: 0,
            documentHeight: 0
        }, s.refresh = function(e) {
            e === !0 ? t() : o()
        }, s.setDocumentWidth = function(e) {
            l = e, s.settings.documentWidth = e
        },
        function() {
            d = 0, t(), e()
        }(), s
}

function ScrollManager(e, t) {
    "use strict";

    function n() {
        window.addEventListener("DOMMouseScroll", _.throttle(i, 10)), window.addEventListener("DOMMouseScroll", _.debounce(a, 500, {
            trailing: !0
        })), window.addEventListener("mousewheel", _.throttle(i, 10)), window.addEventListener("mousewheel", _.debounce(a, 500, {
            trailing: !0
        }))
    }

    function i(e) {
        var t = e.deltaY || 4 * e.detail;
        if (t > 50 && (t = 50), t < -50 && (t = -50), o.dispatchEvent(ScrollManager.SCROLL_MOUSE_WHEEL, e), r !== !0 && (t > 4 || t < -4)) {
            r = !0, setTimeout(function() {
                r = !1
            }, 1e3);
            var n = t > 0 ? "forward" : "back";
            o.dispatchEvent(ScrollManager.SCROLL_TRIGGER, {
                direction: n
            })
        }
    }

    function a(e) {
        r = !1
    }
    ScrollManager.SCROLL_TRIGGER = "scrolltrigger", ScrollManager.SCROLL_MOUSE_WHEEL = "scrollmousewheel";
    var o = new EventDispatcher,
        r = !1;
    return function() {
        n()
    }(), o
}

function URLManager() {
    "use strict";

    function e() {
        window.addEventListener("hashchange", n)
    }

    function t() {
        var e = location.hash.replace("#!", ""),
            t = e.split(URLManager.SLASH);
        i.urlList = t
    }

    function n(e) {
        t(), i.dispatchEvent(URLManager.HASH_CHANGE)
    }
    URLManager.HASH_CHANGE = "hashchange", URLManager.SLASH = "_";
    var i = new EventDispatcher;
    return i.urlList = [], i.updateURL = function(e) {
            location.hash = "!" + e
        }, i.getDepth = function(e) {
            return i.urlList[e]
        },
        function() {
            e(), t()
        }(), i
}

function ZoomManager() {
    "use strict";

    function e(e) {
        t.zoomState = e, e !== ZoomManager.ZOOMED_IN && e !== ZoomManager.ZOOMED_OUT || t.dispatchEvent(e)
    }
    ZoomManager.ZOOMED_IN = "zoomedin", ZoomManager.ZOOMED_OUT = "zoomedout";
    var t = new EventDispatcher;
    return t.zoomState = ZoomManager.ZOOMED_IN, t.setState = function(n) {
        n !== t.zoomState && e(n)
    }, t
}

function View() {
    function e() {
        Model.urlManager.addEventListener(URLManager.HASH_CHANGE, o), Model.resizeManager.addEventListener(ResizeManager.RESIZE, a), Model.resizeManager.addEventListener(ResizeManager.LAST_RESIZE, a)
    }

    function t() {
        l = new Home, g.appendChild(l)
    }

    function n() {
        u = new Hamburger, g.appendChild(u), Model.burger = u
    }

    function i() {
        l.animateIn(), TweenLite.to(u, .4, {
            delay: 1,
            opacity: 1,
            ease: Linear.easeNone
        })
    }

    function a(e) {
        var t = window.innerWidth - u.clientWidth;
        t -= window.innerWidth < 768 ? 10 : 40, u.style.left = t + "px", 0 === u.clientWidth && setTimeout(a, 200)
    }

    function o(e) {
        for (var t = Model.urlManager.getDepth(0), n = Model.urlManager.getDepth(1), i = !1, a = Model.data.querySelectorAll(".athlete-list .athlete"), o = 0; o < a.length; o++)
            if (n === a[o].getAttribute("data-url")) {
                i = !0;
                break
            }
        if ("athletes" !== t && "" !== t) return void Model.urlManager.updateURL("");
        if ("athletes" === t && n && !i) return void Model.urlManager.updateURL("");
        if (!t) {
            if (d) d.close(r), l.enableScroll();
            else if (c) {
                var h = function() {
                    s(), l.enableScroll(), l.animateIn()
                };
                l.setupAnimateIn(), c.close(h)
            } else l.enableScroll();
            u.hideX()
        }
        if ("athletes" !== t || n || (u.showX(), c || l.disableScroll(), d = new Menu, g.appendChild(d)), "athletes" === t && n)
            if (u.showX(), c) c.close(s), setTimeout(function() {
                c = new Athlete, g.appendChild(c), c.setupAnimateIn("athlete"), setTimeout(function() {
                    c.animateIn("athlete")
                }, 100)
            }, 800);
            else if (d) d.removeListeners(), c = new Athlete, g.appendChild(c), c.setupAnimateIn("menu"), setTimeout(function() {
            d.close(r, !0), setTimeout(function() {
                d.galleryAnimateOut(r), c.animateIn("menu")
            }, 700)
        }, 100);
        else {
            var w = new HomeTransition;
            w.style.opacity = .01, g.appendChild(w), l.resetZoom(), l.hideTimeline(), l.removeListeners(), c = new Athlete, c.setupAnimateIn(), g.appendChild(c), TweenLite.to(w, .05, {
                delay: .1,
                onStart: function() {
                    w.animate(p)
                },
                opacity: 1,
                ease: Linear.easeNone
            });
            var m = function() {
                    g.removeChild(w)
                },
                p = function() {
                    l.disableScroll(), c.animateIn("", m)
                }
        }
    }

    function r() {
        g.removeChild(d), d = null
    }

    function s() {
        g.removeChild(c), c = null
    }
    var l, d, c, u, g = document.createElement("div"),
        h = "view";
    return function() {
        g.classList.add(h), t(), n(), e(), a(), l.setupAnimateIn(), setTimeout(i, 300), setTimeout(o, 1e3) // 300 2e3 главный экран скроллинг после загрузки
    }(), g
}

function Athlete() {
    function e() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, l), Model.resizeManager.addEventListener(ResizeManager.LAST_RESIZE, s)
    }

    function t() {
        L = document.createElement("div"), L.classList.add(C + "__bg"), I.appendChild(L), L.style.width = Model.resizeManager.settings.windowWidth + "px", L.addEventListener("click", function(e) {
            Model.urlManager.updateURL("")
        })
    }

    function n() {
        v = new Gallery(T), I.appendChild(v)
    }

    function i() {
        y = new AthleteOverlay(T, r), I.appendChild(y)
    }

    function a() {
        S = new QuotePanel(T), I.appendChild(S)
    }

    function o() {
        Model.scrollManager && (E = setTimeout(M, 4e3)), y.animateInComplete(), setTimeout(v.loadGalleryImages, 500), window.addEventListener("keyup", p), Model.dragManager ? (Model.dragManager.addEventListener(DragManager.DRAG_START, c), Model.dragManager.addEventListener(DragManager.DRAG_MOVE, u), Model.dragManager.addEventListener(DragManager.DRAG_STOP, g), x = _.throttle(d, 50), window.addEventListener("devicemotion", x)) : (Model.scrollManager.addEventListener(ScrollManager.SCROLL_TRIGGER, m), Model.mouseManager.addEventListener(MouseManager.MOUSE_MOVE, f))
    }

    function r(e) {
        var t = z;
        "next" === e ? t + 1 <= v.slideLength && t++ : "previous" === e && t - 1 >= 0 && t--, h(t, 0)
    }

    function s(e) {}

    function l(e) {
        I.style.width = Model.resizeManager.settings.windowWidth + "px", I.style.height = Model.resizeManager.settings.windowHeight + "px", L.style.height = window.innerHeight + "px";
        Math.ceil(Model.resizeManager.settings.windowWidth * z);
        v.slideLength
    }

    function d(e) {
        Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN && v.updateDeviceMotion(Model.dragManager.currentScroll.accPercX, Model.dragManager.currentScroll.accPercY), y.updateDeviceMotion(Model.dragManager.currentScroll.accPercX, Model.dragManager.currentScroll.accPercY)
    }

    function c() {
        O !== !0 && (v.slides[z + 1] && v.slides[z + 1].positionImageForDragging(), z < v.slideLength - 1 && v.slides[z - 1] && v.slides[z - 1].positionImageForDragging(), TweenLite.killTweensOf(b), v.touchStart())
    }

    function u() {
        if (O !== !0) {
            var e = -Math.ceil(Model.resizeManager.settings.windowWidth * z);
            return Model.dragManager.currentScroll.x < Model.dragManager.currentScroll.startX ? (t = Model.dragManager.currentScroll.startX - Model.dragManager.currentScroll.x, n = Math.abs(t / Model.resizeManager.settings.windowWidth), b.x = e - Slice.width * n, n = -n) : (t = Model.dragManager.currentScroll.x - Model.dragManager.currentScroll.startX, n = Math.abs(t / Model.resizeManager.settings.windowWidth), b.x = e + Slice.width * n), void v.updateToTransitionPercent(n);
            var t, n
        }
    }

    function g(e) {
        var t = e.movementSpeed,
            n = z;
        t > 5 ? n + 1 <= v.slideLength && n++ : t < -5 && n - 1 >= 0 && n--, h(n, t, v.slides[n] ? v.slides[n].maskData : null)
    }

    function h(e, t, n) {
        if (O !== !0) {
            O = !0, TweenLite.killTweensOf(b);
            var i = Math.ceil(Model.resizeManager.settings.windowWidth * e),
                a = e > v.slideLength - 1;
            a === !0 && (window.innerWidth < 768 || (i -= .75 * window.innerWidth)), a === !0 ? Model.burger.turnBlack() : Model.burger.turnWhite();
            var o = v.slides[e],
                r = z;
            v.deactivateSlide(r), v.activateSlide(e);
            var s = e / (v.slideLength - 1);
            y.updateInfo(e, s);
            var l = v.slides[r];
            if (e === v.slideLength - 1) {
                if (z === v.slideLength) return S.hide(.45), v.setIndex(e), z = e, void w();
                O = !1
            } else {
                if (e === v.slideLength) return z !== e && (S.show(.45), v.setIndex(e), z = e, w()), void(O = !1);
                if (e > v.slideLength) return void(O = !1)
            }
            if (l.style.zIndex = "", o.style.zIndex = "1", Modernizr.cssclippathpolygon) {
                var d = {
                        x: 0
                    },
                    c = {
                        x: 0
                    },
                    u = {
                        x: window.innerWidth
                    },
                    g = {
                        x: window.innerWidth
                    };
                if (r < e) {
                    d.x = window.innerWidth, c.x = window.innerWidth, n && (d.x = window.innerWidth * (n.topLeft / 100), c.x = window.innerWidth * (n.bottomLeft / 100)), o.updateMask(d.x, c.x, u.x, g.x), TweenLite.set(o, {
                        x: 0
                    }), l.transitionLeft("out"), o.transitionLeft("in");
                    var h = d,
                        m = c;
                    Model.dragManager && Model.dragManager.currentScroll.startY < .5 * window.innerHeight && (h = c, m = d), TweenLite.to(m, .4, {
                        x: .2 * window.innerWidth,
                        ease: Quad.easeIn
                    }), TweenLite.to(m, .4, {
                        delay: .4,
                        x: 0,
                        ease: Quad.easeOut
                    }), TweenLite.to(h, .8, {
                        x: 0,
                        ease: Quad.easeInOut,
                        onUpdate: function() {
                            o.updateMask(d.x, c.x, u.x, g.x)
                        },
                        onComplete: function() {
                            v.playVideo(e), w()
                        }
                    })
                } else if (r > e) {
                    u.x = 0, g.x = 0, n && (u.x = window.innerWidth * (n.topRight / 100), g.x = window.innerWidth * (n.bottomRight / 100)), o.updateMask(d.x, c.x, u.x, g.x), TweenLite.set(o, {
                        x: 0
                    }), l.transitionRight("out"), o.transitionRight("in");
                    var h = u,
                        m = g;
                    Model.dragManager && Model.dragManager.currentScroll.startY < .5 * window.innerHeight && (h = g, m = u), TweenLite.to(m, .35, {
                        x: .8 * window.innerWidth,
                        ease: Quad.easeIn
                    }), TweenLite.to(m, .35, {
                        delay: .35,
                        x: window.innerWidth,
                        ease: Quad.easeOut
                    }), TweenLite.to(h, .7, {
                        x: window.innerWidth,
                        ease: Quad.easeInOut,
                        onUpdate: function() {
                            o.updateMask(d.x, c.x, u.x, g.x)
                        },
                        onComplete: function() {
                            v.playVideo(e), w()
                        }
                    })
                } else {
                    if (o = v.slides[e + 1], l = v.slides[e], null === o.maskData.topLeft || void 0 === o.maskData.topLeft || 0 === o.maskData.topLeft && 100 === o.maskData.topRight) {
                        if (log("trying!"), !(o = v.slides[e - 1])) return log("broken"), void(O = !1);
                        l.style.zIndex = "", o.style.zIndex = "1", TweenLite.set(o, {
                            x: 0
                        }), TweenLite.to(o.maskData, .3, {
                            topLeft: 0,
                            bottomLeft: 0,
                            topRight: 0,
                            bottomRight: 0,
                            ease: Quad.easeIn,
                            onUpdate: function() {
                                log(o.maskData), o.updateMask()
                            },
                            onComplete: function() {
                                O = !1
                            }
                        })
                    } else l.style.zIndex = "", o.style.zIndex = "1", TweenLite.set(o, {
                        x: 0
                    }), TweenLite.to(o.maskData, .3, {
                        topLeft: 100,
                        bottomLeft: 100,
                        topRight: 100,
                        bottomRight: 100,
                        ease: Quad.easeIn,
                        onUpdate: function() {
                            o.updateMask()
                        },
                        onComplete: function() {
                            O = !1
                        }
                    });
                    (null === o.maskData.topLeft || void 0 === o.maskData.topLeft || 0 === o.maskData.topLeft && 100 === o.maskData.topRight) && log("ah crap!")
                }
            } else r < e ? (TweenLite.set(o, {
                x: window.innerWidth
            }), l.transitionLeft("out"), o.transitionLeft("in"), TweenLite.to(o, .8, {
                x: 0,
                ease: Quad.easeOut,
                onComplete: function() {
                    v.playVideo(e), w()
                }
            })) : r > e ? (TweenLite.set(o, {
                x: -window.innerWidth
            }), l.transitionRight("out"), o.transitionRight("in"), TweenLite.to(o, .8, {
                x: 0,
                ease: Quad.easeOut,
                onComplete: function() {
                    v.playVideo(e), w()
                }
            })) : O = !1;
            f(), v.setIndex(e), z = e
        }
    }

    function w() {
        O = !1, v.touchStart()
    }

    function m(e) {
        var t = z;
        "forward" === e.direction ? t + 1 <= v.slideLength && t++ : "back" === e.direction && t - 1 >= 0 && t--, h(t, 0)
    }

    function p(e) {
        var t = z;
        if (13 === e.keyCode || 32 === e.keyCode) {
            var n = Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN ? ZoomManager.ZOOMED_OUT : ZoomManager.ZOOMED_IN;
            Model.zoomManager.setState(n)
        } else 27 === e.keyCode ? Model.urlManager.updateURL("") : 39 === e.keyCode ? t + 1 <= v.slideLength && t++ : 37 === e.keyCode && t - 1 >= 0 && t--;
        t !== z && h(t, 0)
    }

    function f(e) {
        E && (clearTimeout(E), E = null), e && e.target && e.target.classList && (e.target.classList.contains("athlete-overlay") || e.target.classList.contains("athlete-overlay__extra-info-gradient")) && (E = setTimeout(M, 3e3)), y.show();
        var t = Model.mouseManager.settings.x / Model.resizeManager.settings.windowWidth,
            n = Model.mouseManager.settings.y / Model.resizeManager.settings.windowHeight;
        y.updateDeviceMotion(t, n)
    }

    function M() {
        E && (clearTimeout(E), E = null), y.hide()
    }
    var L, v, y, S, T, E, x, I = document.createElement("div"),
        C = "athlete",
        z = 0,
        O = !1,
        b = {
            x: 0
        };
    return I.close = function(e) {
            TweenLite.killTweensOf(I), TweenLite.killTweensOf(b), E && (clearTimeout(E), E = null), Model.burger.turnWhite(), Model.burger.show(), v.pauseVideo(), window.removeEventListener("keyup", p), Model.resizeManager.removeEventListener(ResizeManager.RESIZE, l), Model.resizeManager.removeEventListener(ResizeManager.LAST_RESIZE, s), Modernizr.touch ? (Model.dragManager.removeEventListener(DragManager.DRAG_START, c), Model.dragManager.removeEventListener(DragManager.DRAG_MOVE, u), Model.dragManager.removeEventListener(DragManager.DRAG_STOP, g), x && window.removeEventListener("devicemotion", x)) : (Model.scrollManager.removeEventListener(ScrollManager.SCROLL_TRIGGER, m), Model.mouseManager.removeEventListener(MouseManager.MOUSE_MOVE, f)), v.slides[z] && (v.slides[z].transitionLeft("out"), v.slides[z].showTint());
            var t = document.createElement("div");
            t.classList.add(C + "__wipe"), I.appendChild(t), t.style.width = 0, t.style.height = window.innerHeight + "px", TweenLite.set(t, {
                x: window.innerWidth
            }), t.destinX = b.x;
            var n = b.x - .1 * window.innerWidth;
            TweenLite.to(t, .6, {
                x: 0,
                destinX: n,
                width: window.innerWidth,
                ease: Quart.easeIn,
                onComplete: function() {
                    requestAnimationFrame(function() {
                        v.kill(), S.kill(), e()
                    })
                },
                onUpdate: function() {}
            })
        }, I.setupAnimateIn = function(e) {
            I.style.display = "none"
        }, I.animateIn = function(e, t) {
            if (I.style.display = "block", "menu" === e) v.setupAnimateFirstImage(), TweenLite.set(I, {
                x: .05 * window.innerWidth
            }), TweenLite.to(I, 1, {
                delay: .1,
                x: 0,
                ease: Quart.easeInOut,
                onComplete: function() {
                    o()
                }
            }), TweenLite.to(v, 0, {
                delay: .2,
                onComplete: v.animateFirstImage
            });
            else if ("athlete" === e) {
                var n = document.createElement("div");
                n.classList.add(C + "__wipe"), I.appendChild(n), n.style.width = window.innerWidth + "px", n.style.height = window.innerHeight + "px", TweenLite.set(n, {
                    x: 0
                }), TweenLite.to(n, .7, {
                    width: 0,
                    ease: Quart.easeOut
                }), TweenLite.set(v, {
                    x: .05 * window.innerWidth
                }), TweenLite.to(v, .7, {
                    delay: .1,
                    x: 0,
                    ease: Quart.easeOut,
                    onComplete: o
                }), v.animateFirstImage()
            } else v.animateFirstImage(), setTimeout(function() {
                t(), o()
            }, 100)
        },
        function() {
            I.classList.add(C);
            var o = Model.urlManager.getDepth(1);
            T = Model.data.querySelector('.athlete[data-url="' + o + '"]');
            for (var r = Model.data.querySelector(".athlete-list"), s = 0; s < r.children.length; s++)
                if (o === r.children[s].getAttribute("data-url")) {
                    Model.athleteIndex = s;
                    break
                }
            if (!T) return void log("Could not find athleteData");
            t(), n(), i(), a(), Model.dragManager && Model.dragManager.reset(), e(), l()
        }(), I
}

function Home(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, f), Model.resizeManager.addEventListener(ResizeManager.LAST_RESIZE, m)
    }

    function n() {
        T = new HomePanel(_), T.style.zIndex = 2, x.appendChild(T)
    }

    function i() {
        v = new SliceList(_, 0), v.style.zIndex = 1, x.appendChild(v)
    }

    function a() {
        Math.min(screen.width, screen.height) > 500 && (y = new SliceList(_, 1), y.showTint(), x.appendChild(y))
    }

    function o() {
        E = new HomeTimeline({
            forwardClick: s,
            backClick: l
        }), x.appendChild(E)
    }

    function r(e) {
        var t = e;
        return t + 1 <= _.length && t++, t - 1 >= 0 && t--, t
    }

    function s() {
        u(r(C + 1), 0, !0)
    }

    function l() {
        u(r(C - 1), 0, !0)
    }

    function d(e) {
        z !== !0 && (TweenLite.killTweensOf(O), v.touchStart(), v.zoomOutImages(), y && (y.touchStart(), y.zoomOutImages()))
    }

    function c(e) {
        if (z !== !0) {
            TweenLite.killTweensOf(O);
            var t = -Math.floor(Math.floor(Slice.width) * C),
                n = 0,
                i = 0;
            Model.dragManager.currentScroll.x < Model.dragManager.currentScroll.startX ? (n = Model.dragManager.currentScroll.startX - Model.dragManager.currentScroll.x, i = Math.abs(n / Model.resizeManager.settings.windowWidth), O.x = t - Slice.width * i) : (n = Model.dragManager.currentScroll.x - Model.dragManager.currentScroll.startX, i = Math.abs(n / Model.resizeManager.settings.windowWidth), O.x = t + Slice.width * i), O.x > 0 && (O.x *= .75), v.updateX(O.x);
            var a = O.x;
            y && setTimeout(function() {
                y && y.updateX(a)
            }, 60)
        }
    }

    function u(e, t, n, i) {
        if (z !== !0) {
            z = !0, TweenLite.killTweensOf(O);
            var a = Math.floor(Slice.width * e) - .25 * e,
                o = C !== e;
            if (C = e, Model.athleteIndex = e, T.updateInfo(C), E.update(C + 1, v.length), v.updateX(O.x), y && setTimeout(function() {
                    y.updateX(O.x)
                }, 60), t < 15 && t > -15) {
                n === !0 && o && (v.zoomOutImages(), y && y.zoomOutImages(), setTimeout(function() {
                    v.zoomInImages(), y && y.zoomInImages()
                }, 220));
                var r = i === !0 ? 0 : .45;
                TweenLite.to(O, r, {
                    x: -a,
                    ease: Quad.easeInOut,
                    onUpdate: function() {
                        var e = O.x;
                        v.updateX(e), y && setTimeout(function() {
                            y.updateX(e)
                        }, 60)
                    },
                    onComplete: g
                })
            } else {
                a = Math.abs(a);
                var s = Math.abs(O.x),
                    l = Math.max(a, s) - Math.min(a, s),
                    d = l / 1e3;
                d *= window.innerWidth < 480 ? 3 : 1.5, TweenLite.to(O, d, {
                    x: -a,
                    ease: Expo.easeOut,
                    onUpdate: function() {
                        var e = O.x;
                        v.updateX(e), y && setTimeout(function() {
                            y.updateX(e)
                        }, 60)
                    },
                    onComplete: g
                })
            }
        }
    }

    function g() {
        z = !1, v.touchStart(), y && y.touchStart()
    }

    function h(e) {
        v.zoomInImages(), y && y.zoomInImages();
        var t = e.movementSpeed,
            n = C;
        if (t > 5) n = r(n + 1);
        else if (t < -5) n = r(n - 1);
        else {
            var i = v.getActiveSliceIndex();
            n = i
        }
        u(n, t)
    }

    function w(e) {
        var t = C;
        "forward" === e.direction ? t = r(t + 1) : "back" === e.direction && (t = r(t - 1)), u(t, 0, !0)
    }

    function m(e) {
        u(C, 0)
    }

    function p(e) {
        var t = C;
        13 === e.keyCode || 32 === e.keyCode ? v.triggerURL(t) : 39 === e.keyCode ? t = r(t + 1) : 37 === e.keyCode && (t = r(t - 1)), t !== C && u(t, 0, !0)
    }

    function f(e) {
        x.style.width = Model.resizeManager.settings.windowWidth + "px", x.style.height = Model.resizeManager.settings.windowHeight + "px", S = Slice.width * (v.length - 1), v.setWidth(S), y && y.setWidth(S), v.style.left = Slice.smallSideC + "px", y && (y.style.left = Math.floor(2 * Slice.smallSideC) - 1 + "px")
    }

    function M(e) {
        e.target.zoomOutImages()
    }

    function L(e) {
        e.target.zoomInImages()
    }
    var v, y, S, T, E, _, x = document.createElement("div"),
        I = "home",
        C = 0,
        z = !1,
        O = {
            x: 0
        };
    return x.resetZoom = function() {
            v.zoomInImages()
        }, x.setupAnimateIn = function() {
            x.style.backgroundColor = "#fff", TweenLite.set(T, {
                x: 2 * window.innerWidth
            }), v.style.opacity = .01, y && (y.style.opacity = .01), TweenLite.set(E, {
                x: Slice.smallSideC,
                y: 0,
                z: 1
            })
        }, x.animateIn = function() {
            var e = !1,
                t = !1;
            TweenLite.to(E, 1.2, {
                delay: .15,
                x: 0,
                ease: Quart.easeOut
            }), E.animateIn(1), T.animateIn(.9), TweenLite.to(T, 1.1, {
                delay: 0,
                x: 0,
                ease: Quart.easeOut,
                onUpdate: function() {
                    var n = T._gsTransform.x;
                    n < 2 * Slice.smallSideC + 50 && t === !1 && (t = !0, y && (y.style.opacity = 1, y.animateIn(C))), n < Slice.smallSideC + 50 && e === !1 && (e = !0, v.style.opacity = 1, v.animateIn(C))
                },
                onComplete: function() {
                    x.style.backgroundColor = "#666"
                }
            })
        }, x.animateOut = function() {}, x.enableScroll = function() {
            x.style.display = "block", z = !1, E.resize(), u(Model.athleteIndex, 0, !1, !0), window.addEventListener("keyup", p), Model.dragManager && (Model.dragManager.addEventListener(DragManager.DRAG_START, d), Model.dragManager.addEventListener(DragManager.DRAG_MOVE, c), Model.dragManager.addEventListener(DragManager.DRAG_STOP, h)), Model.scrollManager && (Model.scrollManager.addEventListener(ScrollManager.SCROLL_TRIGGER, w), v.addEventListener("mouseenter", M), v.addEventListener("mouseleave", L), y && (y.style.cursor = "pointer", y.addEventListener("mouseenter", M), y.addEventListener("mouseleave", L), y.addEventListener("click", s)))
        }, x.disableScroll = function() {
            setTimeout(function() {
                x.style.display = "none"
            }, 400), x.removeListeners()
        }, x.hideTimeline = function() {
            TweenLite.to(E, .3, {
                y: E.clientHeight,
                ease: Quad.easeIn
            })
        }, x.removeListeners = function() {
            window.removeEventListener("keyup", p), Model.dragManager && (Model.dragManager.removeEventListener(DragManager.DRAG_START, d), Model.dragManager.removeEventListener(DragManager.DRAG_MOVE, c), Model.dragManager.removeEventListener(DragManager.DRAG_STOP, h)), Model.scrollManager && (Model.scrollManager.removeEventListener(ScrollManager.SCROLL_TRIGGER, w), v.removeEventListener("mouseenter", M), v.removeEventListener("mouseleave", L), y && (y.removeEventListener("mouseenter", M), y.removeEventListener("mouseleave", L), y.removeEventListener("click", s)))
        },
        function() {
            x.classList.add(I);
            var e = Model.urlManager.getDepth(1),
                r = !1;
            if (e)
                for (var s = Model.data.querySelector(".athlete-list"), l = 0; l < s.children.length; l++)
                    if (e === s.children[l].getAttribute("data-url")) {
                        C = l, Model.athleteIndex = l, r = !0;
                        break
                    }
            if (_ = Model.data.querySelectorAll(".athlete-list .athlete"), i(), a(), n(), o(), t(), f(), r === !0) {
                var d = Math.floor(Slice.width * C) - .25 * C;
                E.update(C + 1, v.length), O.x = -d, T.updateInfo(C), v.updateX(O.x, !0), y && y.updateX(O.x, !0)
            }
        }(), x
}

/* Связана с загрузкой */
function Intro(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, a)
    }

    function n() {
        _introAnimation = new IntroAnimation(e), o.appendChild(_introAnimation)
    }

    function i() {
        a(), _introAnimation.animateIn()
    }

    function a(e) {
        o.style.width = window.innerWidth + "px", o.style.height = window.innerHeight + "px"
    }
    var o = document.createElement("div"),
        r = "intro";
    return o.kill = function() {
            Model.resizeManager.removeEventListener(ResizeManager.RESIZE, a)
        },
        function() {
            o.classList.add(r), n(), t(), a(), setTimeout(i, 500)
        }(), o
}

function Menu() {
    function e() {
        Model.dragManager && (Model.dragManager.addEventListener(DragManager.DRAG_START, p), Model.dragManager.addEventListener(DragManager.DRAG_MOVE, f), Model.dragManager.addEventListener(DragManager.DRAG_STOP, M)), Model.scrollManager && Model.scrollManager.addEventListener(ScrollManager.SCROLL_MOUSE_WHEEL, m), window.addEventListener("keyup", u), Model.resizeManager.addEventListener(ResizeManager.RESIZE, h)
    }

    function t() {
        L = document.createElement("div"), L.classList.add(O + "__bg"), z.appendChild(L), L.style.width = window.innerWidth + "px"
    }

    function n() {
        x = new SVGIcon("logo"), x.classList.add(O + "__logo"), z.appendChild(x)
    }

    function i() {
        I = new SVGIcon("logo"), I.classList.add(O + "__logo-bg"), z.appendChild(I), TweenLite.set(I, {
            z: 1
        })
    }

    function a() {
        v = new MenuNav(w), z.appendChild(v)
    }

    function o() {
        _ = document.createElement("div"), _.classList.add(O + "__close"), z.appendChild(_), _.addEventListener("click", function(e) {
            Model.urlManager.updateURL("")
        })
    }

    function r() {
        C = new MenuTimeline, z.appendChild(C), C.updateItem(0)
    }

    function s() {
        S = document.createElement("div"), S.classList.add(O + "__slider-container"), z.appendChild(S), y = document.createElement("div"), y.classList.add(O + "__slider"), S.appendChild(y), TweenLite.set(y, {
            z: 1
        }), T = new BlockList(Model.data.querySelector(".menu"), C.updateItem), y.appendChild(T)
    }

    function l() {
        L.style.height = window.innerHeight + "px", L.style.opacity = 0, v.style.opacity = 0, y.style.opacity = 0, I.style.opacity = 0, x.style.opacity = 0, C.style.opacity = 0, TweenLite.to(L, .25, {
            opacity: 1,
            ease: Linear.easeNone,
            onComplete: function() {}
        }), TweenLite.to(x, .4, {
            delay: .1,
            opacity: 1,
            ease: Linear.easeNone
        }), TweenLite.set(v, {
            x: 20
        }), TweenLite.to(v, .4, {
            delay: .3,
            opacity: 1,
            x: 0,
            ease: Quad.easeOut
        }), TweenLite.to(C, .3, {
            delay: .7,
            opacity: 1,
            ease: Linear.easeNone
        }), setTimeout(function() {
            y.style.opacity = 1, T.animateIn(), C.animateIn()
        }, 400);
        var e = I._gsTransform.x;
        TweenLite.set(I, {
            x: e - 40
        }), TweenLite.to(I, .6, {
            delay: .3,
            opacity: 1,
            x: e,
            ease: Quad.easeOut
        })
    }

    function d(e) {
        var t = (Model.resizeManager.settings.windowWidth, .5 * T.getFirstItem().clientWidth),
            n = .5 * T.getLastItem().clientWidth,
            i = -E + t + n;
        return e > 0 && (e = 0), e < i && (e = i), e
    }

    function c() {
        var e = T.getCurrentIndex(y._gsTransform.x);
        if (e !== k) {
            var t = T.getCategoryByIndex(e);
            t !== H && (H = t, v.selectCategory(H)), T.deactivateItem(k), T.activateItem(e), C.updateItem(e), k = e
        }
    }

    function u(e) {
        13 === e.keyCode || 32 === e.keyCode || (39 === e.keyCode ? g(A.x - .8 * window.innerWidth) : 37 === e.keyCode ? g(A.x + .8 * window.innerWidth) : 27 === e.keyCode && Model.urlManager.updateURL(""))
    }

    function g(e) {
        A.x = d(e);
        var t = .5 * T.getFirstItem().clientWidth,
            n = .5 * T.getLastItem().clientWidth,
            i = -E + t + n,
            a = A.x / i;
        TweenLite.to(y, .5, {
            x: A.x,
            ease: Quad.easeInOut,
            onUpdate: function() {
                var e = y._gsTransform.x / i;
                C.update(e), c()
            }
        }), TweenLite.to(I, .5, {
            x: (Model.resizeManager.settings.windowWidth - I.clientWidth - 140) * a,
            ease: Quad.easeInOut
        }), c()
    }

    function h(e) {
        z.style.width = Model.resizeManager.settings.windowWidth + "px", z.style.height = window.innerHeight + "px", L.style.width = Model.resizeManager.settings.windowWidth + "px", L.style.height = window.innerHeight + "px", S.style.left = .5 * (Model.resizeManager.settings.windowWidth - T.getFirstItem().clientWidth) + "px", y.style.height = Math.floor(.5 * window.innerHeight) + "px";
        var t = .4 * window.innerHeight,
            n = t / W * b;
        I.style.width = n + "px", I.style.height = t + "px", I.style.left = "70px", I.style.top = .5 * (window.innerHeight - t) + "px", E = T.listWidth, y.style.width = E + "px", TweenLite.set(y, {
            y: Math.floor(.5 * (window.innerHeight - y.clientHeight))
        })
    }

    function w(e) {
        var t = T.getCategoryX(e),
            n = t.x,
            i = .5 * T.getFirstItem().clientWidth,
            a = .5 * T.getLastItem().clientWidth,
            o = -E + i + a;
        n -= i, n += .5 * t.block.clientWidth, A.x = -n, v.selectCategory(e), TweenLite.to(y, .8, {
            x: A.x,
            ease: Quart.easeInOut,
            onUpdate: function() {
                var e = y._gsTransform.x / o;
                C.update(e)
            },
            onComplete: function() {
                c()
            }
        });
        var r = A.x / o;
        TweenLite.to(I, .8, {
            x: (Model.resizeManager.settings.windowWidth - I.clientWidth - 140) * r,
            ease: Quart.easeInOut
        })
    }

    function m(e) {
        var t = e.deltaY || 3 * e.detail;
        A.x = d(A.x - t);
        var n = .5 * T.getFirstItem().clientWidth,
            i = .5 * T.getLastItem().clientWidth,
            a = -E + n + i,
            o = A.x / a;
        C.update(o), TweenLite.to(y, .2, {
            x: A.x,
            ease: Quad.easeOut
        }), TweenLite.to(I, .2, {
            x: (Model.resizeManager.settings.windowWidth - I.clientWidth - 140) * o,
            ease: Quad.easeOut
        }), c()
    }

    function p() {
        R = A.x, c()
    }

    function f() {
        var e = 0;
        Model.dragManager.currentScroll.x < Model.dragManager.currentScroll.startX ? (e = Model.dragManager.currentScroll.startX - Model.dragManager.currentScroll.x, A.x = R - 2 * e) : (e = Model.dragManager.currentScroll.x - Model.dragManager.currentScroll.startX, A.x = R + 2 * e), A.x = d(A.x);
        var t = .5 * T.getFirstItem().clientWidth,
            n = .5 * T.getLastItem().clientWidth,
            i = -E + t + n;
        TweenLite.to(y, .4, {
            x: A.x,
            ease: Quad.easeOut,
            onUpdate: function() {
                var e = y._gsTransform.x / i;
                C.update(e)
            },
            onComplete: function() {
                c()
            }
        });
        var a = A.x / i;
        TweenLite.to(I, .4, {
            x: (Model.resizeManager.settings.windowWidth - I.clientWidth - 140) * a,
            ease: Quad.easeOut
        }), c()
    }

    function M() {
        c()
    }
    var L, v, y, S, T, E, _, x, I, C, z = document.createElement("div"),
        O = "menu",
        b = 130,
        W = 21,
        k = 0,
        R = 0,
        A = {
            x: 0
        },
        H = "athletes";
    return z.removeListeners = function() {
            window.removeEventListener("keyup", u), Model.resizeManager.removeEventListener(ResizeManager.RESIZE, h), Model.dragManager && (Model.dragManager.removeEventListener(DragManager.DRAG_START, p), Model.dragManager.removeEventListener(DragManager.DRAG_MOVE, f), Model.dragManager.removeEventListener(DragManager.DRAG_STOP, M)), Model.scrollManager && Model.scrollManager.removeEventListener(ScrollManager.SCROLL_MOUSE_WHEEL, m)
        }, z.close = function(e, t) {
            z.removeListeners(), T.kill(), C.kill(), TweenLite.killTweensOf([y, v, _, C, I, x]);
            var n = y._gsTransform.y,
                i = t === !0 ? .5 : .3;
            TweenLite.to(y, i, {
                y: n + 30,
                ease: Quad.easeIn
            }), TweenLite.to(y, i, {
                opacity: 0,
                ease: Linear.easeNone
            });
            var a = I._gsTransform.x - 40;
            TweenLite.to(I, i, {
                opacity: 0,
                x: a,
                ease: Quad.easeIn
            }), v.animateOut(), TweenLite.to(v, i, {
                opacity: 0,
                x: 20,
                ease: Quad.easeIn
            }), TweenLite.to([_, C, x], i - .1, {
                opacity: 0,
                ease: Linear.easeNone
            }), t === !0 || TweenLite.to(L, .3, {
                delay: .3,
                opacity: 0,
                ease: Linear.easeNone,
                onComplete: e
            })
        }, z.galleryAnimateOut = function(e) {
            TweenLite.to(L, 1, {
                delay: .1,
                width: 0,
                ease: Quart.easeInOut,
                onComplete: e
            })
        },
        function() {
            z.classList.add(O), TweenLite.set(z, {
                z: 1
            }), t(), n(), i(), a(), o(), r(), s(), e(), setTimeout(function() {
                h(), l(), c(), T.activateItem(0)
            }, 100)
        }(), z
}

function AthleteOverlay(e, t) {
    function n() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, w), S.addEventListener("click", m), T.addEventListener("click", p)
    }

    function i() {
        f = document.createElement("div"), f.classList.add(z + "__gradient"), C.appendChild(f)
    }

    function a() {
        M = document.createElement("div"), M.classList.add(z + "__info"), C.appendChild(M)
    }

    function o() {
        y = document.createElement("div"), y.classList.add(z + "__small-name"), y.innerHTML = e.querySelector(".athlete__name--one-line").innerHTML, C.appendChild(y), TweenLite.set(y, {
            x: 15
        })
    }

    function r() {
        var t;
        t = e.querySelector(".athlete__name--gallery") ? e.querySelector(".athlete__name--gallery").innerHTML : e.querySelector(".athlete__name").innerHTML, L = document.createElement("div"), L.classList.add(z + "__name"), L.innerHTML = t, M.appendChild(L);
        var n = document.createElement("div");
        if (n.classList.add(z + "__stats"), M.appendChild(n), W === !1) {
            var i = document.createElement("span");
            i.classList.add(z + "__stat"), i.classList.add(z + "__stat--uppercase"), i.innerHTML = e.querySelector(".athlete__sport").innerHTML, n.appendChild(i)
        }
        e.querySelector(".athlete__age") && (i = document.createElement("span"), i.classList.add(z + "__stat"), i.classList.add(z + "__stat--uppercase"), i.innerHTML = e.querySelector(".athlete__age").innerHTML, n.appendChild(i)), i = document.createElement("span"), i.classList.add(z + "__stat"), i.innerHTML = e.querySelector(".athlete__details").innerHTML,
            n.appendChild(i)
    }

    function s() {
        v = new AthleteTimeline, C.appendChild(v), v.animateIn()
    }

    function l() {
        S = document.createElement("div"), S.classList.add(z + "__next-button"), S.innerHTML = Model.data.querySelector(".misc__next").innerHTML, C.appendChild(S)
    }

    function d() {
        T = document.createElement("div"), T.classList.add(z + "__previous-button"), T.classList.add("hide"), T.innerHTML = Model.data.querySelector(".misc__previous").innerHTML, C.appendChild(T)
    }

    function c() {
        x = document.createElement("div"), x.classList.add(z + "__extra-info-gradient"), C.appendChild(x), _ = document.createElement("div"), _.classList.add(z + "__extra-info"), _.innerHTML = E.innerHTML, C.appendChild(_), x.style.opacity = 0, _.style.opacity = 0
    }

    function u() {
        I = document.createElement("div"), I.classList.add(z + "__button-container"), I.style.display = "none", C.appendChild(I);
        var e = document.createElement("div");
        e.classList.add(z + "__more-button"), e.innerHTML = Model.data.querySelector(".misc__more").innerHTML, I.appendChild(e);
        var t = document.createElement("div");
        t.classList.add(z + "__less-button"), t.innerHTML = Model.data.querySelector(".misc__less").innerHTML, I.appendChild(t), e.addEventListener("click", function(n) {
            e.style.display = "none", t.style.display = "block", _.style.height = "auto";
            var i = _.clientHeight;
            _.style.height = "", TweenLite.to(_, .2, {
                height: i,
                ease: Quad.easeInout
            }), TweenLite.to(x, .2, {
                opacity: .6,
                ease: Linear.easeNone
            })
        }), t.addEventListener("click", function(n) {
            e.style.display = "block", t.style.display = "none", TweenLite.to(_, .2, {
                height: 130,
                ease: Quad.easeInout,
                onComplete: function() {
                    _.style.height = ""
                }
            }), TweenLite.to(x, .2, {
                opacity: .3,
                ease: Linear.easeNone
            })
        })
    }

    function g() {
        W === !0 && (TweenLite.killTweensOf([_, x]), _.style.display = "block", x.style.display = "block", window.innerWidth < 580 && (I.style.display = "block", _.classList.add("compact")), TweenLite.to([_, I], .4, {
            opacity: 1,
            ease: Linear.easeNone
        }), TweenLite.to(x, .4, {
            opacity: .3,
            ease: Linear.easeNone
        }))
    }

    function h() {
        W === !0 && (TweenLite.killTweensOf([_, x]), TweenLite.to([_, x, I], .4, {
            opacity: 0,
            ease: Linear.easeNone,
            onComplete: function() {
                _.style.display = "", x.style.display = "", I.style.display = ""
            }
        }))
    }

    function w(e) {}

    function m(e) {
        t && t("next")
    }

    function p(e) {
        t && t("previous")
    }
    var f, M, L, v, y, S, T, E, _, x, I, C = document.createElement("div"),
        z = "athlete-overlay",
        O = !0,
        b = 0,
        W = !1;
    return C.updateInfo = function(e, t) {
            var n = b;
            v.updateTools(e), v.update(t), n !== e && (0 === n && 1 === e ? (T.classList.remove("hide"), window.innerWidth < 580 && (T.style.display = "none"), TweenLite.killTweensOf(M), TweenLite.killTweensOf(y), TweenLite.to(M, .2, {
                x: -20,
                ease: Quad.easeOut
            }), TweenLite.to(M, .2, {
                opacity: 0,
                ease: Linear.easeNone
            }), TweenLite.to(y, .2, {
                delay: .2,
                opacity: O === !0 ? 1 : .5,
                ease: Linear.easeNone
            }), TweenLite.to(y, .2, {
                delay: .2,
                x: 0,
                ease: Quad.easeOut
            }), W === !0 && setTimeout(g, 200)) : 1 === n && 0 === e ? (T.classList.add("hide"), TweenLite.killTweensOf(M), TweenLite.killTweensOf(y), W === !0 && h(), O === !0 ? (TweenLite.to(M, .2, {
                delay: .2,
                x: 0,
                ease: Quad.easeOut
            }), TweenLite.to(M, .2, {
                delay: .2,
                opacity: 1,
                ease: Linear.easeNone
            }), TweenLite.killTweensOf(y), TweenLite.to(y, .2, {
                opacity: 0,
                ease: Linear.easeNone
            }), TweenLite.to(y, .2, {
                x: 15,
                ease: Quad.easeOut
            })) : TweenLite.set(M, {
                x: 0
            })) : 2 === n && 1 === e ? g() : 1 === n && 2 === e && W === !0 && h(), b = e)
        }, C.show = function() {
            O !== !0 && (O = !0, TweenLite.to(f, .3, {
                opacity: .2,
                ease: Linear.easeNone
            }), TweenLite.to([v, S, T], .3, {
                opacity: 1,
                ease: Linear.easeNone
            }), Model.burger.show(), 0 === b ? TweenLite.to(M, .3, {
                opacity: 1,
                ease: Linear.easeNone
            }) : (TweenLite.killTweensOf(y), TweenLite.to(y, .3, {
                opacity: 1,
                ease: Linear.easeNone
            }), 1 === b && W && g()))
        }, C.hide = function() {
            O !== !1 && (O = !1, 0 === b && TweenLite.to(M, .4, {
                opacity: 0,
                ease: Linear.easeNone
            }), TweenLite.to(f, .4, {
                opacity: 0,
                ease: Linear.easeNone
            }), TweenLite.to([S, T], .4, {
                opacity: 0,
                ease: Linear.easeNone
            }), TweenLite.to(v, .4, {
                opacity: .5,
                ease: Linear.easeNone
            }), 0 === b ? TweenLite.to(y, .4, {
                opacity: 0,
                ease: Linear.easeNone
            }) : (1 === b && W && h(), TweenLite.to(y, .4, {
                opacity: .5,
                ease: Linear.easeNone
            })), Model.burger.hide())
        }, C.animateInComplete = function() {
            setTimeout(v.animateInComplete, 800), v.update(0);
            TweenLite.to(C, 0, {
                delay: .1,
                opacity: 1
            }), f.style.opacity = 0, v.style.opacity = 0, S.style.opacity = 0, TweenLite.set(M, {
                x: -20,
                opacity: 0
            }), TweenLite.to(M, .4, {
                delay: .4,
                x: 0,
                ease: Quad.easeOut
            }), TweenLite.to(M, .4, {
                delay: .4,
                opacity: 1,
                ease: Linear.easeNone
            }), TweenLite.to(v, .4, {
                delay: .6,
                opacity: 1,
                ease: Linear.easeNone
            }), TweenLite.to(f, .7, {
                delay: .4,
                opacity: .2,
                ease: Linear.easeNone
            }), window.innerWidth < 580 ? TweenLite.to(S, .4, {
                delay: .1 + .7,
                opacity: 1,
                ease: Linear.easeNone,
                onComplete: function() {
                    TweenLite.to(S, .4, {
                        delay: 3,
                        x: S.clientWidth,
                        ease: Quart.easeIn
                    })
                }
            }) : TweenLite.to(S, .4, {
                delay: .1 + .7,
                opacity: 1,
                ease: Linear.easeNone
            })
        }, C.updateDeviceMotion = function(e, t) {
            v.updateDeviceMotion(e, t)
        }, C.removeListeners = function() {},
        function() {
            C.classList.add(z), E = e.querySelector(".athlete__extra-info"), E && (W = !0), i(), W === !0 && c(), a(), o(), r(), s(), l(), d(), u(), n(), C.style.opacity = 0
        }(), C
}

function BlockList(e, t) {
    function n() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, s)
    }

    function i() {
        for (var e = 0; e < g; e++) {
            var t, n = c[e];
            n.classList.contains("spacer") ? (t = new Spacer(n), d.appendChild(t)) : n.getAttribute("data-video-id") ? (t = new BlockListVideo(n, l), d.appendChild(t), t.addEventListener("mouseenter", o), t.addEventListener("mouseleave", r)) : n.getAttribute("data-image") && (t = new BlockListImage(n), d.appendChild(t), t.addEventListener("mouseenter", o), t.addEventListener("mouseleave", r)), e < 5 && t.loadImages(), t.i = e, t.type = n.parentNode.className, h.push(t)
        }
    }

    function a() {
        if (h)
            for (var e = 5, t = 5; t < h.length; t++) {
                h[t];
                setTimeout(function() {
                    h && h[e] && h[e].loadImages && h[e].loadImages(), e++
                }, 150 * (t - 5))
            }
    }

    function o(e) {
        h[w] && (h[w].setSelected(!1)), t(e.target.i), e.target.mouseOver()
    }

    function r(e) {
        h[w] && (h[w].setSelected(!0)), t(w), e.target.mouseOut()
    }

    function s(e) {
        for (var t = 0, n = h.length, i = 0; i < n; i++) {
            var a = h[i];
            TweenLite.set(a, {
                x: t
            }), t += a.getWidth() + 6, a.style.position = "absolute"
        }
        t -= 6, d.style.width = t + "px", d.listWidth = t
    }

    function l(e) {
        window.espn.video.remove();
        for (var t = 0; t < h.length; t++) {
            var n = h[t];
            n.stopVideo && (n.i !== e ? n.stopVideo() : n.playVideo())
        }
    }
    var d = document.createElement("div");
    d.listWidth = 0;
    var c, u = "block-list",
        g = 0,
        h = [],
        w = 0;
    return d.animateIn = function() {
            if (h) {
                for (var e = 0; e < h.length; e++) {
                    var t = h[e];
                    e < 6 && (t.style.opacity = 0, TweenLite.set(t, {
                        y: 25
                    }), TweenLite.to(t, .5, {
                        delay: .15 * e,
                        y: 0,
                        opacity: 1,
                        ease: Quad.easeOut
                    }))
                }
                setTimeout(a, 1500)
            }
        }, d.getFirstItem = function() {
            return h[0]
        }, d.getLastItem = function() {
            return h[h.length - 1]
        }, d.showItems = function(e) {
            for (var t = 0; t < h.length; t++) h[t].style.display = "none";
            for (var t = 0; t < e.length; t++) h[e[t]] && (h[e[t]].style.display = "inline-block")
        }, d.deactivateItem = function(e) {
            h[e] && h[e].setSelected(!1)
        }, d.activateItem = function(e) {
            w = e, h[e] && h[e].setSelected(!0)
        }, d.getCategoryByIndex = function(e) {
            if (h[e]) return h[e].type
        }, d.getCurrentIndex = function(e) {
            e = Math.abs(e);
            for (var t = 0; t < g; t++) {
                var n = h[t];
                if (n._gsTransform.x + .5 * n.getWidth() > e) break
            }
            return t
        }, d.getCategoryX = function(e) {
            for (var t = 0; t < g; t++) {
                var n = h[t];
                if (n.type === e) return {
                    x: n._gsTransform.x,
                    block: n
                }
            }
        }, d.kill = function() {
            Model.resizeManager.removeEventListener(ResizeManager.RESIZE, s), h = null
        },
        function() {
            d.classList.add(u), c = e.querySelectorAll(".athletes > div, .covers > div, .videos > div"), g = c.length || 0, i(), n(), setTimeout(s, 100)
        }(), d
}

/* добавление чб */
function BlockListImage(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, s), w && (p.style.cursor = "pointer", p.addEventListener("click", r))
    }

    function n() {
        l = document.createElement("img"), l.classList.add(f + "__image"), l.addEventListener("load", o), l.style.opacity = 0, p.appendChild(l)
    }

    function i() {
        d = document.createElement("img"), d.classList.add(f + "__bw-image"), d.addEventListener("load", a), d.style.opacity = 0, p.appendChild(d)
    }

    function a(e) {
        s(), l.style.opacity = 0, d.style.opacity = 1, TweenLite.to(d, .5, {
            ease: Linear.easeNone,
            onComplete: function() {
                d.style.opacity = "", l.src = Assets.checkForMobile(u)
            }
        })
    }

    function o(e) {
        s(), l.style.opacity = 1
    }

    function r(e) {
        Model.urlManager.updateURL("athletes" + URLManager.SLASH + w)
    }

    function s(e) {
        var t = .5 * window.innerHeight,
            n = t / h;
        m = Math.floor(g * n), p.style.height = t + "px", p.style.width = m + "px"
    }
    var l, d, c, u, g, h, w, m, p = document.createElement("div"),
        f = "block-list-image",
        M = !1,
        L = !1;
    return p.getWidth = function() {
            return m
        }, p.loadImages = function() {
            M === !1 && (M = !0, d.src = Assets.checkForMobile(c))
        }, p.setSelected = function(e) {
            e === !0 ? (L = !0, p.classList.add("selected"), p.mouseOver()) : (L = !1, p.classList.remove("selected"), p.mouseOut())
        }, p.mouseOver = function() {
            p.classList.add("hover"), p.style.zIndex = 1, TweenLite.to(p, .4, {
                scale: 1.07,
                ease: Quart.easeOut
            })
        }, p.mouseOut = function() {
            p.classList.remove("hover"), L === !1 && (p.style.zIndex = "", TweenLite.to(p, .4, {
                scale: 1,
                ease: Quart.easeOut
            }))
        },
        function() {
            p.classList.add(f), c = e.getAttribute("data-bw-image"), u = e.getAttribute("data-image"), g = Number(e.getAttribute("data-width")), h = Number(e.getAttribute("data-height")), w = e.getAttribute("data-url"), n(), c && i(), t(), s()
        }(), p
}

function BlockListVideo(e, t) {
    function n() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, u), g.addEventListener("click", c), v.addEventListener("click", c)
    }

    function i() {
        L = document.createElement("div"), L.classList.add(S + "__video-container"), y.appendChild(L)
    }

    function a() {
        w = document.createElement("img"), w.addEventListener("load", d), w.style.opacity = 0, y.appendChild(w)
    }

    function o() {
        g = document.createElement("img"), g.classList.add(S + "__bw-image"), g.addEventListener("load", d), g.style.opacity = 0, y.appendChild(g)
    }

    function r() {
        v = new SVGIcon("play"), v.classList.add(S + "__play"), y.appendChild(v)
    }

    function s() {
        var e = Model.isSmallScreen || Model.dragManager ? "mobile" : "desktop";
        L.querySelector(".mod-inline .embed-video img").style.display = "none", window.espn.video.play(T, {
            autoplay: !0,
            platform: e,
            targetReplaceId: "embedvideo-" + T
        }), L.style.display = "block", TweenLite.to([g, w, v], .2, {
            opacity: 0,
            ease: Linear.easeNone,
            onComplete: function() {
                w.style.display = "none", g.style.display = "none", v.style.display = "none"
            }
        })
    }

    function l() {
        L.style.display = "none", L.innerHTML = E, w.style.display = "block", g.style.display = "block", v.style.display = "block"
    }

    function d(e) {
        u(), g.style.opacity = "", w.style.opacity = 1
    }

    function c(e) {
        t && t(y.i)
    }

    function u(e) {
        var t = .5 * window.innerHeight,
            n = t / f;
        M = Math.floor(p * n), y.style.height = t + "px", y.style.width = M + "px"
    }
    var g, h, w, m, p, f, M, L, v, y = document.createElement("div"),
        S = "block-list-video",
        T = e.getAttribute("data-video-id"),
        E = '<div class="mod-inline video-player full-width"><a id="video-' + T + '" class="embed-video" href="http://www.espn.com/video/clip?id=' + T + '" target="_blank"><span href="#" class="video-icon"></span><img src="' + e.getAttribute("data-image") + '" alt="video" border="0" /></a><a id="embedvideo-' + T + '" style="height:0;"></a></div>',
        _ = !0;
    return y.getWidth = function() {
            return M
        }, y.playVideo = function() {
            s()
        }, y.stopVideo = function() {
            "none" === w.style.display && (w.style.display = "block", w.style.opacity = 0, g.style.display = "none", g.style.opacity = 0, v.style.display = "none", v.style.opacity = 0, TweenLite.to([v, g, w], .1, {
                opacity: 1,
                ease: Linear.easeNone,
                onComplete: function() {
                    l()
                }
            }))
        }, y.loadImages = function() {
            w.src = Assets.checkForMobile(m), g.src = Assets.checkForMobile(h)
        }, y.setSelected = function(e) {
            e === !0 ? (_ = !0, y.classList.add("selected"), y.mouseOver()) : (_ = !1, y.classList.remove("selected"), y.mouseOut())
        }, y.mouseOver = function() {
            y.classList.add("hover"), y.style.zIndex = 1, TweenLite.to(y, .4, {
                scale: 1.07,
                ease: Quart.easeOut
            })
        }, y.mouseOut = function() {
            y.classList.remove("hover"), _ === !1 && (y.style.zIndex = "", TweenLite.to(y, .4, {
                scale: 1,
                ease: Quart.easeOut
            }))
        },
        function() {
            y.classList.add(S), h = e.getAttribute("data-bw-image"), m = e.getAttribute("data-image"), p = Number(e.getAttribute("data-width")), f = Number(e.getAttribute("data-height")), i(), a(), h && o(), r(), l(), n(), u()
        }(), y
}

function Gallery(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, d), Model.resizeManager.addEventListener(ResizeManager.LAST_RESIZE, d), Model.zoomManager.addEventListener(ZoomManager.ZOOMED_IN, s), Model.zoomManager.addEventListener(ZoomManager.ZOOMED_OUT, l)
    }

    function n() {
        g = document.createElement("div"), g.classList.add(h + "__slider"), u.appendChild(g), TweenLite.set(g, {
            z: 1
        })
    }

    function i() {
        for (var t = e.querySelector(".athlete__images"), n = 0; n < t.children.length; n++) {
            var i, a = t.children[n];
            i = a.getAttribute("data-video") ? new GalleryVideo(a) : new GalleryImage(a), i.i = n, g.appendChild(i), w.push(i), 0 === n && i.loadImages()
        }
        u.slides = w, u.slideLength = w.length
    }

    function a() {
        for (var e = 0; e < w.length; e++) {
            var t, n = w[e];
            t = m === w.length ? e === w.length - 1 ? 0 : -Model.resizeManager.settings.windowWidth : m < e ? Model.resizeManager.settings.windowWidth : m === e ? 0 : -Model.resizeManager.settings.windowWidth, TweenLite.set(n, {
                x: t
            })
        }
    }

    function o() {
        var e = m;
        return [e - 1, e, e + 1]
    }

    function r() {
        for (var e = o(), t = 0; t < w.length; t++) w[t].style.display = "";
        for (var t = 0; t < e.length; t++) w[e[t]] && (w[e[t]].style.display = "block")
    }

    function s() {
        for (var e = m, t = 0; t < w.length; t++) {
            var n = w[t];
            t === e || n.zoomIn(!1)
        }
        w[m].zoomIn(!0)
    }

    function l() {
        for (var e = m, t = 0; t < w.length; t++) {
            var n = w[t];
            t === e || n.zoomOut(!1)
        }
        w[m].zoomOut(!0)
    }

    function d(e) {
        a()
    }

    function c() {
        var e = Model.galleryImageData,
            t = e.width,
            n = e.height,
            i = 1;
        return t + 40 + " " + window.innerWidth ? i = window.innerHeight / n : n + 40 + " " + window.innerHeight && (i = window.innerWidth / t), i += .15
    }
    var u = document.createElement("div");
    u.width = 0, u.slides, u.slideLength = 0;
    var g, h = "gallery",
        w = [],
        m = 0;
    return u.update = function(e) {
            return
        }, u.touchStart = function() {
            r()
        }, u.updateX = function(e) {
            TweenLite.set(g, {
                x: e
            })
        }, u.activateSlide = function(e) {
            if (w[e]) return w[e].activate(), w[e]
        }, u.deactivateSlide = function(e) {
            w[e] && w[e].deactivate(e === w.length - 1)
        }, u.updateDeviceMotion = function(e, t) {
            w && w[m] && w[m].updateDeviceMotion(e, t)
        }, u.setIndex = function(e) {
            m = e
        }, u.playVideo = function(e) {
            w && w[e] && w[e].playVideo && w[e].playVideo()
        }, u.pauseVideo = function() {
            w && w[m] && w[m].pauseVideo && w[m].pauseVideo()
        }, u.setupAnimateFirstImage = function() {
            var e = w[0].getImage(),
                t = Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT ? c() : 1.08;
            TweenLite.set(e, {
                scale: t
            })
        }, u.animateFirstImage = function() {
            var e = w[0].getImage(),
                t = Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT ? c() : 1.08;
            Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT ? (TweenLite.set(e, {
                scale: t
            }), TweenLite.to(e, .6, {
                scale: 1,
                ease: Quart.easeInOut
            })) : (TweenLite.set(e, {
                scale: t
            }), TweenLite.to(e, 1.7, {
                scale: 1,
                ease: Quad.easeOut
            }))
        }, u.loadGalleryImages = function() {
            for (var e = 0; e < w.length; e++) {
                var t = w[e];
                e > 0 && t.loadImages && t.loadImages()
            }
        }, u.updateToTransitionPercent = function(e) {
            e *= .5;
            var t, n = w[m],
                i = e < 0 ? "forward" : "back";
            if (t = "forward" === i ? w[m + 1] : w[m - 1], n && t) {
                n.style.zIndex = "", t.style.zIndex = "1", TweenLite.set(t, {
                    x: 0
                });
                var a = Math.abs(window.innerWidth * e);
                if ("forward" === i) {
                    var o = Math.abs(window.innerWidth - a),
                        r = Math.abs(window.innerWidth - .25 * a);
                    Model.dragManager.currentScroll.startY < .5 * window.innerHeight ? t.updateMask(o, r, window.innerWidth, window.innerWidth) : t.updateMask(r, o, window.innerWidth, window.innerWidth)
                } else {
                    var r = .5 * a;
                    Model.dragManager.currentScroll.startY < .5 * window.innerHeight ? t.updateMask(0, 0, a, r) : t.updateMask(0, 0, r, a)
                }
            }
        }, u.kill = function() {
            Model.resizeManager.removeEventListener(ResizeManager.RESIZE, d), Model.resizeManager.removeEventListener(ResizeManager.LAST_RESIZE, d), Model.zoomManager.removeEventListener(ZoomManager.ZOOMED_IN, s), Model.zoomManager.removeEventListener(ZoomManager.ZOOMED_OUT, l), TweenLite.killTweensOf(g);
            for (var e = 0; e < w.length; e++) w[e].kill();
            g = null, w = null
        },
        function() {
            u.classList.add(h), n(), i(), a(), t(), d(), setTimeout(function() {
                w[0].activate()
            }, 10), u.updateX(0), r()
        }(), u
}

function HomeTransition() {
    function e() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, n)
    }

    function t() {
        var e = Model.data.querySelector(".athlete-list"),
            t = e.querySelectorAll(".athlete");
        TransitionSlice.updateDimensions(), i = new TransitionSlice(t[Model.athleteIndex]), i.style.opacity = .01, a.appendChild(i), TweenLite.set(i, {
            z: 1
        })
    }

    function n() {
        a.style.width = window.innerWidth + "px", a.style.height = window.innerHeight + "px", i.resize()
    }
    var i, a = document.createElement("div"),
        o = "home-transition";
    return a.animate = function(e) {
            TransitionSlice.currentAngle = 25, TransitionSlice.updateDimensions();
            var t = {
                angle: 25,
                width: TransitionSlice.width,
                x: TransitionSlice.smallSideC + 6
            };
            TweenLite.set(i, {
                x: t.x,
                y: .5
            });
            var n = Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT ? Power2.easeInOut : Power2.easeIn;
            TweenLite.to(t, .6, {
                angle: 0,
                width: window.innerWidth,
                x: 0,
                ease: n,
                onUpdate: function() {
                    TransitionSlice.currentAngle = t.angle, TransitionSlice.updateDimensions(t.width), i.resize(), TweenLite.set(i, {
                        x: t.x,
                        opacity: 1
                    })
                }
            });
            var a = i.getImage();
            TweenLite.to(a, .6, {
                scale: 1.03,
                ease: n,
                onComplete: function() {
                    requestAnimationFrame(e)
                }
            })
        },
        function() {
            a.classList.add(o), t(), e(), n()
        }(), a
}

/* Анимация */
function IntroAnimation(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, l)
    }

    function n() {
        d = new IntroSliceList(c, 0), d.style.zIndex = 1, g.appendChild(d), TweenLite.set(d, {
            x: -IntroSlice.sideB
        })
    }

    function i() {
        for (var e = [], t = Model.data.querySelectorAll(".athlete-list .athlete"), n = Model.data.querySelectorAll(".intro .images div"), i = Model.data.querySelectorAll(".menu .athletes > div"), a = 0; a < t.length; a++) {
            var o = t[a].querySelector(".athlete__images").children[0];
            e.push(o.getAttribute("data-image"))
        }
        for (var a = 0; a < n.length; a++) e.push(n[a].getAttribute("data-image"));
        for (var a = 0; a < 5; a++) e.push(i[a].getAttribute("data-image")), e.push(i[a].getAttribute("data-bw-image"));
        u = new Preloader, u.load(e, s, r)
    }

	/* время слайдинга после показа картинок фукнция setTimeout(o(), 600) - показ основного экрана setTimeout(function() { n === !1 && (n = !0, e())}, 5e3)
	 function a() {
        d.showImages(), d.animateAngle(), o();
		}
	*/
    function a() {
        o();
    }
	/* анимания смены картинки setTimeout принудительный показ */
    function o() {
        g.style.backgroundColor = "#fff", d.animateOut();
        var t = d._gsTransform.x,
            n = !1;
        TweenLite.to(d, .01, {
            x: -d.length * IntroSlice.width - IntroSlice.width,
            ease: Quart.easeIn,
            onUpdate: function() {
                d.animateOutTicker(t - d._gsTransform.x)
            },
            onComplete: function() {
                0 == n && (n = !0, e())
            }
        }), n === !1 && (n = !0, e())
    }

    function r(e) {
        d.progressUpdate(e)
    }

    function s(t) {
        u.kill(), u = null, Model.MODE === Model.DEV_MODE ? e() : (setTimeout(d.animateIn, 300), setTimeout(a, 1e3))
    }

    function l(e) {}
    var d, c, u, g = document.createElement("div"),
        h = "intro-animation";
    return g.animateIn = function() {
            i()
        },
        function() {
            g.classList.add(h), c = Model.data.querySelectorAll(".intro .images div"), n(), t()
        }(), g
}

/* элементы скрипта при загрузки экрана */
function IntroSliceList(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, d)
    }

    function n() {
        u = document.createElement("div"), u.classList.add(p + "__slider"), c.appendChild(u), TweenLite.set(u, {
            z: 1
        })
    }

    function i() {
        IntroSlice.updateDimensions();
        for (var t = 0; t < c.length; t++) {
            var n = new IntroSlice(e[t]);
            u.appendChild(n), TweenLite.set(n, {
                z: 1
            }), f.push(n)
        }
        //window.innerWidth < 1050 && (f[0].style.display = "none"), f[3].style.zIndex = 3, f[4] && (f[4].style.zIndex = 3)
    }

    function a() {
        _redLine = document.createElement("div"), _redLine.classList.add(p + "__red-line"), u.appendChild(_redLine), TweenLite.set(_redLine, {
            z: 1
        })
    }
	

    function o() {
        w = new SVGIcon("logo-espn"), w.classList.add(p + "__espn"), u.appendChild(w), TweenLite.set(w, {
            z: 1
        }), w.style.zIndex = 3
    }

    function r() {
        g = new SVGIcon("logo-body"), g.classList.add(p + "__espn"), g.classList.add(p + "__body"), u.appendChild(g), h = g.querySelector(".svg--logo-body"), TweenLite.set(g, {
            z: 1
        })
    }

    function s() {
        m = document.createElement("div"), u.appendChild(m), TweenLite.set(m, {
            z: 1
        })
    }

    function l() {
        for (var e = 0; e < f.length; e++) {
            var t = f[e];
            t.resize();
            var n = Math.round(IntroSlice.smallSideC * e) + IntroSlice.smallSideC - IntroSlice.width;
            if (TweenLite.set(t, {
                    x: n
                }), 3 === e) {
                var n = Math.round(IntroSlice.smallSideC * e),
                    i = Math.floor(n - .5 * IntroSlice.sideB);
                w.style.left = i + "px", g.style.left = w.style.left, m.style.left = w.style.left, window.innerWidth < 550 ? "desktop" === v && (v = "mobile") : "mobile" === v && (v = "desktop")
            }
        }
    }

    function d(e) {
        IntroSlice.updateDimensions();
        var t = IntroSlice.sideB - 1.33 * IntroSlice.width;
        window.innerWidth < 1050 && (t = IntroSlice.sideB - .5 * IntroSlice.width - 1.51 * IntroSlice.width), _redLine.style.left = .5 * window.innerWidth + "px", c.style.height = window.innerHeight + "px", c.style.width = window.innerWidth + "px", c.style.height = window.innerHeight + "px", u.style.height = window.innerHeight + "px", w.style.width = 1.6 * IntroSlice.width + "px", w.style.marginLeft = .52 * -w.clientWidth + "px", w.style.top = .5 * (window.innerHeight - w.clientHeight) + "px", g.style.marginLeft = w.style.marginLeft, g.style.width = w.style.width, g.style.top = w.style.top, m.style.top = parseInt(w.style.top) + g.clientHeight + "px", m.style.marginLeft = w.style.marginLeft, M === !1 ? (TweenLite.set(g, {
            x: .53 * g.clientWidth
        }), TweenLite.set(m, {
            x: .53 * g.clientWidth * .5
        })) : (w.style.marginLeft = .52 * -w.clientWidth - .026 * w.clientWidth + "px", g.style.marginLeft = w.style.marginLeft, m.style.marginLeft = w.style.marginLeft, TweenLite.set([g, m], {
            x: 0
        })), L === !1 && TweenLite.set(c, {
            x: t
        }), l()
    }
    var c = document.createElement("div");
    c.length = 0;
    var u, g, h, w, m, p = "slice-list",
        f = [],
        M = !1,
        L = !1,
        v = "desktop";
    return c.animateIn = function(e) {
            TweenLite.set(w, {
                y: 40,
                opacity: 0
            }), TweenLite.to(w, .8, {
                opacity: .5,
                y: 0,
                ease: Quart.easeOut,
                onComplete: e
            })
        }, c.animateAngle = function() {
            M = !0;
            for (var e = {
                    angle: 0
                }, t = 0; t < f.length; t++) f[t].animateIn();
            TweenLite.set(_redLine, {
                width: 0,
                height: window.innerWidth < 480 || window.innerHeight < 440 ? 90 : 120,
                x: -c._gsTransform.x
            });
            var n = window.innerWidth;
            TweenLite.to(_redLine, 1.1, {
                delay: .1,
                skewX: -25,
                height: window.innerWidth < 480 || window.innerHeight < 440 ? 110 : 140,
                width: n,
                y: -5,
                x: -c._gsTransform.x - n - 0,
                ease: Quart.easeInOut
            }), g.angle = 0;
            h.clientWidth;
            TweenLite.to(m, .7, {
                delay: .4,
                opacity: 1,
                ease: Linear.easeNone
            }), TweenLite.to(g, 1, {
                delay: .1,
                angle: 25,
                x: 0,
                ease: Quart.easeInOut,
                onUpdate: function() {
                    var e = g.angle / 25,
                        t = Math.ceil(-(.52 * w.clientWidth) - .026 * w.clientWidth * e) + 1;
                    w.style.marginLeft = t + "px", g.style.marginLeft = w.style.marginLeft, m.style.marginLeft = w.style.marginLeft, TweenLite.set(m, {
                        x: g._gsTransform.x
                    })
                }
            }), L = !0, TweenLite.to(e, 1, {
                delay: .1,
                angle: 25,
                ease: Quart.easeInOut,
                onUpdate: function() {
                    IntroSlice.currentAngle = e.angle, IntroSlice.updateDimensions();
                    var t = .9 * IntroSlice.sideB - 1.33 * IntroSlice.width;
                    window.innerWidth < 1050 && (t = .35 * IntroSlice.sideB - .5 * IntroSlice.width - 1.51 * IntroSlice.width), TweenLite.set(c, {
                        x: t
                    }), l()
                }
            })
        }, c.progressUpdate = function(e) {
            for (var t = 0; t < f.length; t++) f[t].progressUpdate(e, t)
        }, c.showImages = function() {
            for (var e = 0; e < f.length; e++) f[e].createImage()
        }, c.animateOut = function() {
            TweenLite.to(w, .5, {
                delay: .4,
                opacity: 0,
                ease: Linear.easeNone
            }), TweenLite.to([g, m], .5, {
                delay: .6,
                opacity: 0,
                ease: Quad.easeOut
            })
        }, c.animateOutTicker = function(e) {
            var t = w._gsTransform.x + .64 * e;
            TweenLite.set([g, m], {
                x: t
            })
        },
		// c.classList.add(p), c.length = window.innerWidth < 1050 ? 5 : e.length, n(), i(), a(), o(), r(), s(), t(), setTimeout(d, 100) 
        function() {
            c.classList.add(p), c.length = window.innerWidth < 1050 ? 5 : e.length, n(), i(), a(), o(), r(), s(), t(), d()
        }(), c
}

function SliceList(e, t) {
    function n() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, d)
    }

    function i() {
        u = document.createElement("div"), u.classList.add(w + "__slider"), c.appendChild(u), TweenLite.set(u, {
            z: 1
        })
    }

    function a() {
        Slice.updateDimensions();
        for (var t = 0; t < e.length; t++) {
            var n = new Slice(e[t]);
            u.appendChild(n), f.push(n)
        }
    }

    function o() {
        TweenLite.set(c, {
            rotation: Slice.currentAngle
        }), TweenLite.set(u, {
            rotation: -Slice.currentAngle
        })
    }

    function r() {
        for (var e = window.innerWidth <= 640 ? "mobile" : "desktop", t = 0; t < f.length; t++) {
            var n = f[t];
            n.resize();
            var i;
            "mobile" === e ? (i = Math.floor(Slice.smallSideC * t) + Math.floor(Slice.smallSideC - Slice.width), p > 0 && (i -= Math.floor(p * Slice.smallSideC))) : (i = Math.ceil(Slice.smallSideC * t) + Math.ceil(Slice.smallSideC - Slice.width), p > 0 && (i -= Math.ceil(p * Slice.smallSideC))), TweenLite.set(n, {
                x: i
            })
        }
    }

    function s() {
        var e = c.getActiveSliceIndex() + p;
        return [e - 1, e, e + 1]
    }

    function l() {
        var e = c.getActiveSliceIndex() + p;
        if (e !== L) {
            for (var t = s(), n = 0; n < f.length; n++) f[n].style.display = "none";
            for (var n = 0; n < t.length; n++) f[t[n]] && (f[t[n]].style.display = "block");
            L = e
        }
    }

    function d(e) {
        Slice.updateDimensions();
        var t = Math.ceil(Slice.sideA + Slice.smallSideB);
        c.style.height = window.innerHeight + "px", c.style.width = Math.floor(Slice.width) + "px", c.style.height = t + "px", u.style.height = window.innerHeight + "px", u.style.top = Slice.tinySideA + "px", r()
    }
    var c = document.createElement("div");
    c.length = 0;
    var u, g, h, w = "slice-list",
        m = "zoomedin",
        p = t || 0,
        f = [],
        M = !1,
        L = -1;
    return c.animateIn = function(e) {
            M = !0;
            var t = document.createElement("div");
            t.classList.add(w + "__tint"), c.appendChild(t), TweenLite.set(t, {
                opacity: .5,
                z: 1
            }), TweenLite.to(t, .6, {
                opacity: 0,
                ease: Linear.easeNone,
                onComplete: function() {
                    c.removeChild(t)
                }
            });
            var n = f[e + p];
            if (n) {
                var i = n._gsTransform.x;
                TweenLite.set(n, {
                    x: i + 120
                }), TweenLite.to(n, 1.1, {
                    x: i,
                    ease: Quart.easeOut
                }), p > 0 && (n = f[e], i = n._gsTransform.x, TweenLite.set(n, {
                    x: i + 120
                }), TweenLite.to(n, 1.1, {
                    x: i,
                    ease: Quart.easeOut
                }))
            }
        }, c.showTint = function() {
            g = document.createElement("div"), g.classList.add(w + "__tint"), c.appendChild(g), h = document.createElement("div"), h.classList.add(w + "__gradient"), c.appendChild(h), TweenLite.set([g, h], {
                z: 1
            })
        }, c.setWidth = function(e) {
            u.style.width = e + "px"
        }, c.touchStart = function() {
            l()
        }, c.updateX = function(e, t) {
            var n = e * -.4665;
            TweenLite.set(u, {
                x: e,
                y: n
            }), (Model.scrollManager || t === !0) && l()
        }, c.getActiveSliceIndex = function() {
            return Math.round(Math.abs(u._gsTransform.x) / Slice.width)
        }, window.openMask = function() {}, c.zoomOutImages = function() {
            if ("zoomedout" !== m) {
                m = "zoomedout";
                for (var e = s(), t = 0; t < f.length; t++) {
                    for (var n = !1, i = 0; i < e.length; i++) t === e[i] && (n = !0);
                    f[t].zoomOutImage(n)
                }
                g && TweenLite.to(g, .3, {
                    opacity: .3,
                    ease: Linear.easeNone
                })
            }
        }, c.zoomInImages = function() {
            if ("zoomedin" !== m) {
                m = "zoomedin";
                for (var e = s(), t = 0; t < f.length; t++) {
                    for (var n = !1, i = 0; i < e.length; i++) t === e[i] && (n = !0);
                    f[t].zoomInImage(n)
                }
                g && TweenLite.to(g, .3, {
                    opacity: 1,
                    ease: Linear.easeNone
                })
            }
        }, c.triggerURL = function(e) {
            f[e].triggerURL()
        },
        function() {
            c.classList.add(w), c.length = e.length, i(), a(), n(), d(), o(), l()
        }(), c
}

function Spacer(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, a)
    }

    function n() {
        o = document.createElement("div"), o.classList.add(l + "__headline"), o.innerHTML = e.children[0].innerHTML, s.appendChild(o)
    }

    function i() {
        r = document.createElement("a"), r.classList.add(l + "__cta"), r.innerHTML = e.children[1].innerHTML, r.href = e.children[1].getAttribute("href"), r.target = "_blank", o.appendChild(r)
    }

    function a(e) {
        Spacer.updateWidth(), s.style.width = Spacer.width + "px", o.style.top = Math.floor(.5 * (s.clientHeight - o.clientHeight)) + "px", s.clientHeight || setTimeout(a, 100)
    }
    var o, r, s = document.createElement("div"),
        l = "spacer";
    return s.getWidth = function() {
            return Spacer.width
        }, s.setSelected = function(e) {},
        function() {
            s.classList.add(l), n(), i(), t(), setTimeout(a, 200)
        }(), s
}

function AthleteTimeline() {
    function e() {
        g.addEventListener("click", r), Model.resizeManager.addEventListener(ResizeManager.RESIZE, d), Model.resizeManager.addEventListener(ResizeManager.LAST_RESIZE, d), Model.zoomManager.addEventListener(ZoomManager.ZOOMED_IN, s), Model.zoomManager.addEventListener(ZoomManager.ZOOMED_OUT, l)
    }

    function t() {
        c = document.createElement("div"), c.classList.add(f + "__line-bg"), p.appendChild(c)
    }

    function n() {
        u = document.createElement("div"), u.classList.add(f + "__line"), p.appendChild(u)
    }

    function i() {
        g = new SVGIcon("gyroscope"), g.classList.add(f + "__zoom-button"), g.classList.add(f + "__zoom-button--first-slide"), p.appendChild(g), Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT && g.classList.add("active"), w = document.createElement("div"), w.classList.add(f + "__gyroscope"), g.appendChild(w), m = document.createElement("div"), m.classList.add(f + "__gyroscope-border"), m.classList.add("athlete-timeline__gyroscope-border--landscape"), g.appendChild(m);
        var e = new SVGIcon("gyroscope");
        m.appendChild(e)
    }

    function a() {
        h = document.createElement("div"), h.classList.add(f + "__disclaimer"), h.innerHTML = Model.data.querySelector(".misc__zoom").innerHTML, p.appendChild(h)
    }

    function o() {
        var e = Model.galleryImageData;
        e && (Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN ? "horizontal" === e.panMode ? m.classList.contains("athlete-timeline__gyroscope-border--landscape") || (m.classList.remove("athlete-timeline__gyroscope-border--portrait"), m.classList.add("athlete-timeline__gyroscope-border--landscape")) : m.classList.contains("athlete-timeline__gyroscope-border--portrait") || (m.classList.add("athlete-timeline__gyroscope-border--portrait"), m.classList.remove("athlete-timeline__gyroscope-border--landscape")) : (m.classList.remove("athlete-timeline__gyroscope-border--portrait"), m.classList.remove("athlete-timeline__gyroscope-border--landscape")), "video" === e.type && (m.classList.remove("athlete-timeline__gyroscope-border--portrait"), m.classList.remove("athlete-timeline__gyroscope-border--landscape")))
    }

    function r(e) {
        var t = Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN ? ZoomManager.ZOOMED_OUT : ZoomManager.ZOOMED_IN;
        Model.zoomManager.setState(t)
    }

    function s() {
        g.classList.remove("active"), o()
    }

    function l() {
        g.classList.add("active"), o()
    }

    function d(e) {
        var t = window.innerWidth < 800 ? 25 : 70;
        p.style.width = Model.resizeManager.settings.windowWidth - t - 60 + "px", o()
    }
    var c, u, g, h, w, m, p = document.createElement("div"),
        f = "athlete-timeline",
        M = 0;
    return p.animateIn = function() {
            c.style.width = 0, TweenLite.to(c, 1, {
                width: "100%",
                ease: Expo.easeInOut
            })
        }, p.update = function(e) {
            var t = Model.galleryImageData;
            o(), "video" === t.type ? TweenLite.to(w, .3, {
                opacity: 0,
                ease: Linear.easeNone
            }) : TweenLite.to(w, .3, {
                opacity: 1,
                ease: Linear.easeNone
            }), TweenLite.to(u, .6, {
                width: p.clientWidth * e,
                ease: Quart.easeInOut
            })
        }, p.animateInComplete = function() {
            Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT ? h.parentNode === p && p.removeChild(h) : (TweenLite.to(h, .4, {
                delay: 0,
                opacity: 1,
                ease: Linear.easeNone,
				onComplete: function() {
					if(!Modernizr.touch){
						document.querySelector(".athlete-timeline__zoom-button").dispatchEvent(new Event("click")); /* Костыль на работу галереи сразу с другого режима */
					}
				}
            }), TweenLite.to(h, 8, { /* настройка дискламера */
                delay: 4,
                opacity: 0,
                ease: Linear.easeNone,
                onComplete: function() {
                    h.parentNode === p && p.removeChild(h)
                }
            }))
        }, p.updateTools = function(e) {
            var t = M;
            e !== t && (M = e)
        }, p.updateDeviceMotion = function(e, t) {
            var n = Model.galleryImageData,
                i = 110 * e + 40 - 90;
            n && "vertical" === n.panMode && (i = 100 * t + 40), TweenLite.to(w, 1.7, {
                rotation: i,
                ease: Quad.easeOut
            })
        }, p.kill = function() {
            g.removeEventListener("click", r), Model.resizeManager.removeEventListener(ResizeManager.RESIZE, d), Model.resizeManager.removeEventListener(ResizeManager.LAST_RESIZE, d), Model.zoomManager.removeEventListener(ZoomManager.ZOOMED_IN, s), Model.zoomManager.removeEventListener(ZoomManager.ZOOMED_OUT, l)
        },
        function() {
            p.classList.add(f), t(), n(), i(), a(), e(), d()
        }(), p
}

function CompactTimeline(e) {
    function t() {
        l.addEventListener("click", o), d.addEventListener("click", r)
    }

    function n() {
        s = document.createElement("div"), s.classList.add(u + "__counter"), s.innerHTML = "1 / 16", c.appendChild(s)
    }

    function i() {
        l = new SVGIcon("arrow"), l.classList.add(u + "__arrow"), l.classList.add(u + "__arrow--left"), l.classList.add(u + "__arrow--disabled"), c.appendChild(l), d = new SVGIcon("arrow"), d.classList.add(u + "__arrow"), d.classList.add(u + "__arrow--right"), c.appendChild(d)
    }

    function a(e) {
        s.style.marginTop = .5 * (c.clientHeight - s.clientHeight) + "px", l.style.top = .5 * (c.clientHeight - l.clientHeight) + "px", d.style.top = l.style.top
    }

    function o(t) {
        e.backClick && e.backClick()
    }

    function r(t) {
        e.forwardClick && e.forwardClick()
    }
    var s, l, d, c = document.createElement("div"),
        u = "compact-timeline";
    return c.update = function(e, t) {
            s.innerHTML = e + " / " + t, 1 === e ? l.classList.add(u + "__arrow--disabled") : l.classList.remove(u + "__arrow--disabled"), e === t ? d.classList.add(u + "__arrow--disabled") : d.classList.remove(u + "__arrow--disabled")
        }, c.resize = function() {
            a()
        },
        function() {
            c.classList.add(u), n(), i(), t(), a(), setTimeout(a, 500)
        }(), c
}

function ExpandedTimeline(e) {
    function t() {
        c.addEventListener("click", s), u.addEventListener("click", l)
    }

    function n() {
        d = document.createElement("div"), d.classList.add(p + "__counter"), d.innerHTML = "1<br />16", m.appendChild(d)
    }

    function i() {
        c = document.createElement("div"), c.classList.add(p + "__arrow"), c.classList.add(p + "__arrow--left"), c.classList.add(p + "__arrow--disabled"), m.appendChild(c);
        var e = new SVGIcon("arrow");
        e.classList.add(p + "__arrow-svg-container"), c.appendChild(e), u = document.createElement("div"), u.classList.add(p + "__arrow"), u.classList.add(p + "__arrow--right"), m.appendChild(u);
        var e = new SVGIcon("arrow");
        e.classList.add(p + "__arrow-svg-container"), u.appendChild(e)
    }

    function a() {
        g = document.createElement("div"), g.classList.add(p + "__bg-bar"), m.appendChild(g)
    }

    function o() {
        h = document.createElement("div"), h.classList.add(p + "__bar"), h.perc = 0, g.appendChild(h)
    }

    function r(e) {
        c.style.top = Math.floor(.5 * (m.clientHeight - c.clientHeight)) + "px", u.style.top = c.style.top, w = m.clientWidth - 65 - 125, g.style.width = w + "px", h.style.width = w * h.perc + "px"
    }

    function s(t) {
        e.backClick && e.backClick()
    }

    function l(t) {
        e.forwardClick && e.forwardClick()
    }
    var d, c, u, g, h, w, m = document.createElement("div"),
        p = "expanded-timeline";
    return m.update = function(e, t) {
            var n = e / t;
            d.innerHTML = e + "<br />" + t, h.perc = n, TweenLite.to(h, .6, {
                width: w * n,
                ease: Quart.easeInOut
            }), 1 === e ? c.classList.add(p + "__arrow--disabled") : c.classList.remove(p + "__arrow--disabled"), e === t ? u.classList.add(p + "__arrow--disabled") : u.classList.remove(p + "__arrow--disabled")
        }, m.resize = function() {
            r()
        },
        function() {
            m.classList.add(p), n(), i(), a(), o(), t(), r(), setTimeout(r, 500)
        }(), m
}

function GalleryImage(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, d), Model.mouseManager.addEventListener(MouseManager.MOUSE_MOVE, c)
    }

    function n() {
        h = document.createElement("img"), h.classList.add(g + "__bg-asset"), h.onload = l, h.src = e.getAttribute("data-image"), u.appendChild(h), Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT && (h.style.display = "block"), TweenLite.set(h, {
            z: 1,
            scale: 1.1
        })
    }

    function i() {
        w = document.createElement("img"), w.classList.add(g + "__asset"), w.onload = l, w.src = e.getAttribute("data-image"), u.appendChild(w), TweenLite.set(w, {
            z: 1
        })
    }

    function a() {
        y = document.createElement("div"), y.classList.add(g + "__tint"), u.appendChild(y), TweenLite.set(y, {
            z: 1,
            opacity: 0
        })
    }

    function o(e) {
        var t = {
                width: 0,
                height: 0,
                panMode: "vertical",
                type: "image"
            },
            n = Model.resizeManager.settings.windowWidth,
            i = p * (n / m),
            a = "vertical";
        return Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT && (n -= 40, i = p * (n / m)), Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN || e === !0 ? i < window.innerHeight && (i = window.innerHeight, n = m * (i / p), a = "horizontal") : Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT && i > window.innerHeight - 40 && (i = window.innerHeight - 40, n = m * (i / p)), t.width = n, t.height = i, t.panMode = a, t
    }

    function r() {
        var e = o(!0),
            t = o();
        f = Math.ceil(t.width), M = Math.ceil(t.height), w.style.height = M + "px", w.style.width = f + "px", h.style.height = Math.round(e.height) + "px", h.style.width = Math.round(e.width) + "px"
    }

    function s(e) {
        var t = function() {
            if (m) {
                var e = .5,
                    n = .5;
                Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN && ("left" === L ? e = 0 : "right" === L && (e = 1), "top" === v ? n = 0 : "bottom" === v && (n = 1));
                var i = (Model.resizeManager.settings.windowWidth - f) * e,
                    a = (window.innerHeight - M) * n,
                    o = Model.mouseManager.settings.x,
                    r = Model.mouseManager.settings.y,
                    s = o / Model.resizeManager.settings.windowWidth,
                    l = r / window.innerHeight;
                Model.resizeManager.settings.windowWidth, window.innerHeight;
                if (Model.dragManager) {
                    var d = Model.resizeManager.settings.windowWidth - f,
                        c = window.innerHeight - M;
                    s = Model.dragManager.currentScroll.accPercX, l = Model.dragManager.currentScroll.accPercY, d * s, c * l
                }
                TweenLite.killTweensOf(w), TweenLite.set(w, {
                    x: i,
                    y: a
                }), _ ? setTimeout(function() {
                    E = !1
                }, 1500) : setTimeout(function() {
                    E = !1
                }, 500)
            } else setTimeout(t, 100)
        };
        t()
    }

    function l(e) {
        m = w.naturalWidth || w.clientWidth, p = w.naturalHeight || w.clientHeight, d()
    }

    function d(e) {
        if (m && r(), u.style.width = Model.resizeManager.settings.windowWidth + "px", u.style.height = window.innerHeight + "px", f) {
            var t = o(!0),
                n = .5 * (Model.resizeManager.settings.windowWidth - t.width),
                i = .5 * (window.innerHeight - t.height);
            TweenLite.set(h, {
                x: n,
                y: i
            });
            var n = .5 * (Model.resizeManager.settings.windowWidth - f),
                i = .5 * (window.innerHeight - M);
            TweenLite.set(w, {
                x: n,
                y: i
            })
        }
        S && (Model.galleryImageData = o())
    }

    function c(e) {
        if (!Model.dragManager && T !== !0 && E !== !0) {
            var t = Model.mouseManager.settings.x,
                n = Model.mouseManager.settings.y;
            Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT && (t = .5 * Model.resizeManager.settings.windowWidth, n = .5 * window.innerHeight);
            var i = t / Model.resizeManager.settings.windowWidth,
                a = n / window.innerHeight,
                o = (Model.resizeManager.settings.windowWidth - f) * i,
                r = (window.innerHeight - M) * a;
            S === !0 ? (TweenLite.killTweensOf(w), TweenLite.to(w, 1.5, {
                x: o,
                y: r,
                ease: Expo.easeOut
            })) : TweenLite.set(w, {
                x: o,
                y: r
            })
        }
    }
    var u = document.createElement("div"),
        g = "gallery-item";
    u.maskData = {};
    var h, w, m, p, f, M, L, v, y, S = !1,
        T = !1,
        E = !0,
        _ = !0;
    return u.activate = function() {
            if (S !== !0) {
                return S = !0, E = !0, Model.galleryImageData = o(), y && TweenLite.to(y, .8, {
                    opacity: 0,
                    ease: Quad.easeInOut
                }), Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT ? void(E = !1) : void s()
            }
        }, u.deactivate = function(e) {
            S = !1, E = !0, e || TweenLite.to(y, .8, {
                opacity: .85,
                ease: Quad.easeInOut
            })
        }, u.updateDeviceMotion = function(e, t) {
            if (T === !1 && E === !1) {
                if (Model.dragManager.currentScroll.isFlat === !0) {
                    var n = .5,
                        i = .5;
                    "left" === L ? n = 0 : "right" === L && (n = 1), "top" === v ? i = 0 : "bottom" === v && (i = 1), e = n, t = i
                }
                var a = Model.resizeManager.settings.windowWidth - f,
                    o = window.innerHeight - M;
                TweenLite.killTweensOf(w), TweenLite.to(w, 1.7, {
                    x: a * e,
                    y: o * t,
                    ease: Quad.easeOut
                })
            }
        }, u.zoomIn = function(e) {
            var t = o(),
                n = Model.mouseManager.settings.x,
                i = Model.mouseManager.settings.y,
                a = n / Model.resizeManager.settings.windowWidth,
                s = i / window.innerHeight,
                l = (Model.resizeManager.settings.windowWidth - t.width) * a,
                d = (window.innerHeight - t.height) * s;
            TweenLite.killTweensOf(w), e === !1 ? (r(), h.style.display = "none", TweenLite.set(w, {
                x: l,
                y: d
            })) : (T = !0, TweenLite.to(w, .4, {
                x: l,
                y: d,
                width: t.width,
                height: t.height,
                ease: Expo.easeOut,
                onComplete: function() {
                    T = !1, f = Math.ceil(t.width), M = Math.ceil(t.height), h.style.display = "none"
                }
            }))
        }, u.zoomOut = function(e) {
            var t = o(),
                n = .5 * (Model.resizeManager.settings.windowWidth - t.width),
                i = .5 * (window.innerHeight - t.height);
            h.style.display = "block", TweenLite.killTweensOf(w), e === !1 ? (r(), TweenLite.set(w, {
                x: n,
                y: i
            })) : (T = !0, TweenLite.to(w, .4, {
                x: n,
                y: i,
                width: t.width,
                height: t.height,
                ease: Expo.easeOut,
                onComplete: function() {
                    T = !1, f = Math.ceil(t.width), M = Math.ceil(t.height)
                }
            }))
        }, u.loadImages = function() {
            n(), i(), a(), t(), d(), c()
        }, u.getImage = function() {
            return w
        }, u.updateMask = function(e, t, n, i) {
            var a, o, r, s;
            isNaN(e) ? (a = u.maskData.topLeft, o = u.maskData.bottomLeft, r = u.maskData.topRight, s = u.maskData.bottomRight) : (a = e / window.innerWidth * 100, o = t / window.innerWidth * 100, r = n / window.innerWidth * 100, s = i / window.innerWidth * 100);
            var l = "polygon(" + a + "% 0%, " + r + "% 0%, " + s + "% 100%, " + o + "% 100%)";
            isNaN(e) || (u.maskData = {
                topLeft: a,
                bottomLeft: o,
                topRight: r,
                bottomRight: s
            }), TweenLite.set(u, {
                webkitClipPath: l,
                clipPath: l
            })
        }, u.kill = function() {
            TweenLite.killTweensOf(w), Model.mouseManager.removeEventListener(MouseManager.MOUSE_MOVE, c), Model.resizeManager.removeEventListener(ResizeManager.RESIZE, d)
        }, u.positionImageForDragging = function() {
            y.style.opacity = .85, s()
        }, u.transitionLeft = function(e) {
            var t = .1 * window.innerWidth;
            w && ("in" === e ? (w.style.marginLeft = t + "px", Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN && (TweenLite.set(w, {
                scale: 1.08
            }), TweenLite.to(w, 1.5, {
                delay: .5,
                scale: 1,
                ease: Quad.easeOut
            })), TweenLite.to(w, .8, {
                marginLeft: 0,
                ease: Quad.easeInOut
            })) : "out" === e && TweenLite.to(w, .8, {
                marginLeft: -t,
                ease: Quad.easeInOut,
                onComplete: function() {
                    TweenLite.set(u, {
                        x: -window.innerWidth
                    }), TweenLite.set(w, {
                        marginLeft: 0
                    })
                }
            }))
        }, u.transitionRight = function(e) {
            var t = .1 * window.innerWidth;
            w && ("in" === e ? (w.style.marginLeft = -t + "px", Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN && (TweenLite.set(w, {
                scale: 1.08
            }), TweenLite.to(w, 1.4, {
                delay: .5,
                scale: 1,
                ease: Quad.easeOut
            })), TweenLite.to(w, .7, {
                marginLeft: 0,
                ease: Quad.easeInOut
            })) : "out" === e && TweenLite.to(w, .7, {
                marginLeft: t,
                ease: Quad.easeInOut,
                onComplete: function() {
                    TweenLite.set(u, {
                        x: window.innerWidth
                    }), TweenLite.set(w, {
                        marginLeft: 0
                    })
                }
            }))
        }, u.showTint = function() {
            TweenLite.to(y, .8, {
                opacity: .85,
                ease: Quad.easeInOut
            })
        },
        function() {
            u.classList.add(g), u.classList.add(g + "--image");
            var t = e.getAttribute("data-position").split("-");
            L = t[0], v = t[1]
        }(), u
}

function GalleryVideo(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, u)
    }

    function n() {
        w = document.createElement("img"), w.classList.add(h + "__bg-asset"), w.onload = c, w.src = e.getAttribute("data-image"), g.appendChild(w), Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT && (w.style.display = "block"), TweenLite.set(w, {
            z: 1,
            scale: 1.1
        })
    }

    function i() {
        m = document.createElement("img"), m.classList.add(h + "__asset"), m.onload = c, m.src = e.getAttribute("data-image"), g.appendChild(m), TweenLite.set(m, {
            z: 1
        })
    }

    function a() {
        r(), p = e.querySelector("video").cloneNode(!0), p.classList.add(h + "__asset"), p.addEventListener("playing", d), p.autoplay = !1, p.volume = 0, p.style.opacity = 0, g.appendChild(p), TweenLite.set(p, {
            z: 1
        }), l()
    }

    function o() {
        S = document.createElement("div"), S.classList.add(h + "__tint"), g.appendChild(S), TweenLite.set(S, {
            z: 1,
            opacity: 0
        })
    }

    function r() {
        p && (p.pause(), p.style.display = "none", p.removeEventListener("playing", d), p.onload = null, g.removeChild(p), p = null)
    }

    function s(e) {
        var t = {
                width: 0,
                height: 0,
                panMode: "none",
                type: "video"
            },
            n = Model.resizeManager.settings.windowWidth,
            i = M * (n / f);
        return Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN || e === !0 ? i < window.innerHeight && (i = window.innerHeight, n = f * (i / M)) : Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT && (n -= 40, (i = M * (n / f)) > window.innerHeight - 40 && (i = window.innerHeight - 40, n = f * (i / M))), t.width = n, t.height = i, t
    }

    function l() {
        var e = s(!0),
            t = s();
        v = Math.ceil(t.width), y = Math.ceil(t.height), m.style.height = y + "px", m.style.width = v + "px", w.style.height = Math.round(e.height) + "px", w.style.width = Math.round(e.width) + "px", p && (p.style.height = m.style.height, p.style.width = m.style.width)
    }

    function d(e) {
        p.removeEventListener("playing", d), p && TweenLite.to(p, .3, {
            opacity: 1,
            ease: Linear.easeNone
        })
    }

    function c(e) {
        u()
    }

    function u(e) {
        if (f && l(), g.style.width = Model.resizeManager.settings.windowWidth + "px", g.style.height = window.innerHeight + "px", v) {
            var t = s(!0),
                n = .5 * (Model.resizeManager.settings.windowWidth - t.width),
                i = .5 * (window.innerHeight - t.height);
            TweenLite.set(w, {
                x: n,
                y: i
            });
            var n = .5 * (Model.resizeManager.settings.windowWidth - v),
                i = .5 * (window.innerHeight - y);
            "left" === L ? (n = 0, Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT && (n += 20)) : "right" === L && (n = Math.round(Model.resizeManager.settings.windowWidth - Math.ceil(v)), Model.zoomManager.zoomState === ZoomManager.ZOOMED_OUT && (n -= 20));
            var a = [m];
            p && a.push(p), TweenLite.set(a, {
                x: n,
                y: i
            })
        }
        T === !0 && (Model.galleryImageData = s())
    }
    var g = document.createElement("div"),
        h = "gallery-item";
    g.maskData = {};
    var w, m, p, f, M, L, v, y, S, T = !1;
    return g.updateDeviceMotion = function(e, t) {}, g.zoomIn = function(e) {
            var t = s(),
                n = .5 * (Model.resizeManager.settings.windowWidth - t.width),
                i = .5 * (window.innerHeight - t.height);
            if ("left" === L ? n = 0 : "right" === L && (n = Math.round(Model.resizeManager.settings.windowWidth - Math.ceil(t.width))), TweenLite.killTweensOf(m), e === !1) l(), w.style.display = "none", TweenLite.set(m, {
                x: n,
                y: i
            });
            else {
                var a = [m];
                p && a.push(p), TweenLite.to(a, .4, {
                    x: n,
                    y: i,
                    width: t.width,
                    height: t.height,
                    ease: Expo.easeOut,
                    onComplete: function() {
                        v = Math.ceil(t.width), y = Math.ceil(t.height), w.style.display = "none"
                    }
                })
            }
        }, g.zoomOut = function(e) {
            var t = s(),
                n = .5 * (Model.resizeManager.settings.windowWidth - t.width),
                i = .5 * (window.innerHeight - t.height);
            if (w.style.display = "block", TweenLite.killTweensOf(m), e === !1) l(), TweenLite.set(m, {
                x: n,
                y: i
            });
            else {
                var a = [m];
                p && a.push(p), TweenLite.to(a, .4, {
                    x: n,
                    y: i,
                    width: t.width,
                    height: t.height,
                    ease: Expo.easeOut,
                    onComplete: function() {
                        v = Math.ceil(t.width), y = Math.ceil(t.height)
                    }
                })
            }
        }, g.activate = function() {
            T = !0, a(), u(), Model.galleryImageData = s(), S && TweenLite.to(S, .8, {
                opacity: 0,
                ease: Quad.easeInOut
            })
        }, g.deactivate = function(e) {
            T = !1, r(), !e && S && TweenLite.to(S, .8, {
                opacity: .85,
                ease: Quad.easeInOut
            })
        }, g.playVideo = function() {
            p && p.play()
        }, g.pauseVideo = function() {
            p && p.pause()
        }, g.loadImages = function() {
            n(), i(), o(), t(), u()
        }, g.updateMask = function(e, t, n, i) {
            var a, o, r, s;
            isNaN(e) ? (a = g.maskData.topLeft, o = g.maskData.bottomLeft, r = g.maskData.topRight, s = g.maskData.bottomRight) : (a = e / window.innerWidth * 100, o = t / window.innerWidth * 100, r = n / window.innerWidth * 100, s = i / window.innerWidth * 100);
            var l = "polygon(" + a + "% 0%, " + r + "% 0%, " + s + "% 100%, " + o + "% 100%)";
            isNaN(e) || (g.maskData = {
                topLeft: a,
                bottomLeft: o,
                topRight: r,
                bottomRight: s
            }), TweenLite.set(g, {
                webkitClipPath: l,
                clipPath: l
            })
        }, g.kill = function() {
            Model.resizeManager.removeEventListener(ResizeManager.RESIZE, u), r()
        }, g.positionImageForDragging = function() {
            S && (S.style.opacity = .85), u()
        }, g.transitionLeft = function(e) {
            var t = .1 * window.innerWidth,
                n = [m];
            p && n.push(p), "in" === e ? (m.style.marginLeft = t + "px", p && (p.style.marginLeft = m.style.marginLeft), Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN && (TweenLite.set(n, {
                scale: 1.08
            }), TweenLite.to(n, 1.5, {
                delay: .5,
                scale: 1,
                ease: Quad.easeOut
            })), TweenLite.to(n, .8, {
                marginLeft: 0,
                ease: Quad.easeInOut
            })) : "out" === e && TweenLite.to(n, .8, {
                marginLeft: -t,
                ease: Quad.easeInOut,
                onComplete: function() {
                    TweenLite.set(g, {
                        x: -window.innerWidth
                    }), TweenLite.set(n, {
                        marginLeft: 0
                    })
                }
            })
        }, g.transitionRight = function(e) {
            var t = .1 * window.innerWidth,
                n = [m];
            p && n.push(p), "in" === e ? (m.style.marginLeft = -t + "px", p && (p.style.marginLeft = m.style.marginLeft), Model.zoomManager.zoomState === ZoomManager.ZOOMED_IN && (TweenLite.set(n, {
                scale: 1.08
            }), TweenLite.to(n, 1.4, {
                delay: .5,
                scale: 1,
                ease: Quad.easeOut
            })), TweenLite.to(n, .7, {
                marginLeft: 0,
                ease: Quad.easeInOut
            })) : "out" === e && TweenLite.to(n, .7, {
                marginLeft: t,
                ease: Quad.easeInOut,
                onComplete: function() {
                    TweenLite.set(g, {
                        x: window.innerWidth
                    }), TweenLite.set(m, {
                        marginLeft: 0
                    })
                }
            })
        }, g.showTint = function() {
            S && TweenLite.to(S, .8, {
                opacity: .85,
                ease: Quad.easeInOut
            })
        },
        function() {
            g.classList.add(h), g.classList.add(h + "--video"), L = e.getAttribute("data-position"), f = e.getAttribute("data-width") || 1920, M = e.getAttribute("data-height") || 1080
        }(), g
}

function Hamburger() {
    function e() {
        i.addEventListener("click", n)
    }

    function t() {
        _burger = new SVGIcon("hamburger"), i.appendChild(_burger)
    }

    function n(e) {
        Model.urlManager.getDepth(0) ? Model.urlManager.updateURL("") : Model.urlManager.updateURL("athletes")
    }
    var i = document.createElement("div"),
        a = "hamburger";
    return i.showX = function() {
            Model.isFirefox || (i.classList.remove("open"), i.classList.add("close"))
        }, i.hideX = function() {
            Model.isFirefox || (i.classList.add("open"), i.classList.remove("close"))
        }, i.turnBlack = function() {
            i.classList.add("black")
        }, i.turnWhite = function() {
            i.classList.remove("black")
        }, i.hide = function() {
            TweenLite.to(i, .3, {
                opacity: .5,
                ease: Linear.easeNone
            })
        }, i.show = function() {
            TweenLite.to(i, 1, {
                opacity: 1,
                ease: Linear.easeNone
            })
        },
        function() {
            i.classList.add(a), i.classList.add("open"), i.style.zIndex = 10, TweenLite.set(i, {
                z: 2
            }), t(), e()
        }(), i
}

/* формирование панели */
function HomePanel(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, g), p.addEventListener("click", function(e) {
            window.open("http://mikerecord.com/", "_top")
        })
    }

    function n() {
        h = document.createElement("div"), h.classList.add(y + "__bg"), v.appendChild(h), TweenLite.set(h, {
            rotation: Slice.angle
        })
    }

    function i() {
        m = document.createElement("div"), m.classList.add(y + "__cover"), v.appendChild(m)
    }

    function a() {
        p = new SVGIcon("logo"), p.classList.add(y + "__logo"), v.appendChild(p)
    }
	/* второй логотип */
    function o() {
        w = new SVGIcon("espn"), w.classList.add(y + "__espn")
    }

    function r() {
        M = [];
        for (var t = 0; t < e.length; t++) {
            var n = e[t],
                i = document.createElement("div");
            i.classList.add(y + "__text-container"), v.appendChild(i);
            var a = document.createElement("div");
            a.classList.add(y + "__text"), a.innerHTML = n.querySelector(".athlete__name").innerHTML, i.appendChild(a);
            var o = document.createElement("div");
            o.classList.add(y + "__subtitle"), o.innerHTML = n.querySelector(".athlete__sport").innerHTML, i.appendChild(o);
            var r = document.createElement("div");
            r.classList.add(y + "__cta"), r.url = n.getAttribute("data-url"), r.innerHTML = n.querySelector(".athlete__cta").innerHTML, i.appendChild(r);
            var s = document.createElement("div");
            s.classList.add(y + "__line"), r.appendChild(s), r.line = s, r.addEventListener("click", u), r.addEventListener("mouseenter", function(e) {
                var t = this.line,
                    n = this.clientWidth;
                TweenLite.to(t, .3, {
                    x: n,
                    width: 0,
                    ease: Quad.easeInOut,
                    onComplete: function() {
                        TweenLite.set(t, {
                            x: 0
                        }), TweenLite.to(t, .3, {
                            width: n,
                            ease: Quad.easeInOut
                        })
                    }
                })
            }), i.headline = a, i.subtitle = o, i.cta = r, a.style.opacity = 0, o.style.opacity = 0, r.style.opacity = 0, M.push(i), i.style.display = 0 === t ? "block" : "none"
        }
    }

    function s() {
        f = document.createElement("div"), f.classList.add(y + "__footer"), v.appendChild(f), TweenLite.set(f, {
            skewX: -Slice.angle,
            z: 1
        })
    }

    function l() {
        L = document.createElement("div"), L.classList.add(y + "__social-container"), v.appendChild(L), TweenLite.set(L, {
            z: 2
        });
		/* добавление информации в подвал */
		
		socialFooter = '<a href="https://vk.com/id1267032" target="_blank" class="vk"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38.4 38.4"><g><g><path class="social-icon-bg" d="M19.2,0A19.2,19.2,0,1,0,38.4,19.2,19.2,19.2,0,0,0,19.2,0Zm7.68,21.18a14.21,14.21,0,0,0,1,1h0l0,0h0l0,0A12.13,12.13,0,0,1,30.34,25a1.14,1.14,0,0,1,.09.16,2.65,2.65,0,0,1,.08.33,1,1,0,0,1,0,.43.68.68,0,0,1-.32.34,1.46,1.46,0,0,1-.73.16l-3.21,0a1.46,1.46,0,0,1-.7-.06,3.4,3.4,0,0,1-.65-.28L24.65,26a6.41,6.41,0,0,1-.88-.8c-.33-.36-.62-.69-.86-1a4,4,0,0,0-.76-.73.8.8,0,0,0-.71-.19l-.1,0a1.1,1.1,0,0,0-.21.18,1.54,1.54,0,0,0-.27.37,2.6,2.6,0,0,0-.21.65,4.19,4.19,0,0,0-.08,1,1.29,1.29,0,0,1-.05.35,1.1,1.1,0,0,1-.09.23l-.05.06a1,1,0,0,1-.66.28H18.28a5.79,5.79,0,0,1-1.83-.21,6.93,6.93,0,0,1-1.65-.66,15.17,15.17,0,0,1-1.29-.83,7.26,7.26,0,0,1-.88-.72l-.31-.3a5.16,5.16,0,0,1-.35-.38c-.14-.16-.44-.54-.89-1.14S10.19,21,9.75,20.31s-.94-1.54-1.53-2.64-1.14-2.23-1.64-3.4a1,1,0,0,1-.07-.34.35.35,0,0,1,0-.2l0-.08a.89.89,0,0,1,.71-.23l3.43,0,.29.08.2.11.06,0a.83.83,0,0,1,.3.4c.17.42.36.85.58,1.29s.39.79.51,1l.2.37c.24.5.48.93.7,1.3a7.07,7.07,0,0,0,.61.86,3.21,3.21,0,0,0,.52.48.8.8,0,0,0,.42.18,1,1,0,0,0,.34-.07.17.17,0,0,0,.06-.06,2,2,0,0,0,.16-.28,1.91,1.91,0,0,0,.16-.59c0-.24.08-.58.12-1A10.09,10.09,0,0,0,16,16a5,5,0,0,0-.11-.92,2.9,2.9,0,0,0-.17-.57l-.08-.15a1.49,1.49,0,0,0-1.06-.54q-.17,0,.06-.3a1.67,1.67,0,0,1,.47-.38,8.36,8.36,0,0,1,3-.3,8.57,8.57,0,0,1,1.69.16,2,2,0,0,1,.42.17.68.68,0,0,1,.25.3,1.56,1.56,0,0,1,.13.4,2.79,2.79,0,0,1,.05.57c0,.24,0,.48,0,.69s0,.51,0,.88,0,.72,0,1c0,.09,0,.27,0,.52a5.87,5.87,0,0,0,0,.6c0,.15,0,.31,0,.51a1.29,1.29,0,0,0,.14.49.86.86,0,0,0,.29.31l.21.05a.48.48,0,0,0,.32-.14,4.29,4.29,0,0,0,.48-.43,7.19,7.19,0,0,0,.65-.84c.26-.38.54-.83.85-1.35a19.74,19.74,0,0,0,1.34-2.81.67.67,0,0,1,.13-.22.39.39,0,0,1,.13-.13l.05,0,.07,0,.16,0a.43.43,0,0,1,.25,0l3.61,0a2.05,2.05,0,0,1,.8,0,.76.76,0,0,1,.38.2l.08.13c.19.53-.43,1.76-1.88,3.68l-.81,1.06a9.76,9.76,0,0,0-1.13,1.64A1,1,0,0,0,26.88,21.18Z"></path></g></g></svg></a><a href="https://www.instagram.com/misha_kobelev/" target="_blank" class="inst"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38.4 38.4"><g><g><path class="social-icon-bg" d="M19.22,22.9a3.68,3.68,0,1,0-3.69-3.68A3.68,3.68,0,0,0,19.22,22.9Zm4.25-7.45h2.6a.54.54,0,0,0,.54-.54V12.32a.54.54,0,0,0-.54-.53h-2.6a.53.53,0,0,0-.53.53v2.59A.54.54,0,0,0,23.47,15.45ZM19.2,0A19.2,19.2,0,1,0,38.4,19.2,19.2,19.2,0,0,0,19.2,0Zm9.6,26.52a2.28,2.28,0,0,1-2.28,2.28H11.88A2.28,2.28,0,0,1,9.6,26.52V11.88A2.28,2.28,0,0,1,11.88,9.6H26.52a2.28,2.28,0,0,1,2.28,2.28Zm-3.74-7.3a5.84,5.84,0,0,1-11.68,0,5.61,5.61,0,0,1,.21-1.54h-1.8V26a.54.54,0,0,0,.54.54H26.11a.54.54,0,0,0,.54-.54V17.68H24.86A6,6,0,0,1,25.06,19.22Z"></path></g></g></svg></a><a href="https://www.youtube.com/channel/UCz0ZHkSbbITg19QgLiLEmOg" target="_blank" class="youtube"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38.4 38.4"><g><g><path class="social-icon-bg" d="M19.2,0A19.2,19.2,0,1,0,38.4,19.2,19.2,19.2,0,0,0,19.2,0Zm9.6,19.92A29.26,29.26,0,0,1,28.61,23a4.14,4.14,0,0,1-.77,1.91,2.71,2.71,0,0,1-1.92.81c-2.69.19-6.72.2-6.72.2s-5,0-6.53-.19a3.24,3.24,0,0,1-2.11-.82A4.14,4.14,0,0,1,9.79,23a29.26,29.26,0,0,1-.19-3.11V18.47a29.26,29.26,0,0,1,.19-3.11,4.12,4.12,0,0,1,.77-1.9,2.73,2.73,0,0,1,1.92-.82c2.69-.19,6.72-.19,6.72-.19h0s4,0,6.72.19a2.73,2.73,0,0,1,1.92.82,4.12,4.12,0,0,1,.77,1.9,29.26,29.26,0,0,1,.19,3.11ZM17.22,21.69,22.41,19l-5.19-2.71Z"></path></g></g></svg></a>';
		
        L.innerHTML = socialFooter;
    }

    function d(e) {
        var t = window.location.href;
        t = t.replace(/#/i, "%23"), window.open(T + t, "_blank", S)
    }

    function c(e) {
        var t = window.location.href;
        t = t.replace(/#/i, "%23"), window.open(E + t, "_blank", S)
    }

    function u(e) {
        var t = e.currentTarget.url;
        Model.urlManager.updateURL("athletes" + URLManager.SLASH + t)
    }

    function g(e) {
        h.style.width = Math.ceil(1.2 * Slice.width) + "px", h.style.height = Slice.sideA + Slice.smallSideB + "px", h.style.left = -Math.ceil(.2 * Slice.width) + "px";
        for (var t = 0; t < M.length; t++) {
            var n = M[t],
                i = window.innerWidth < 480 || window.innerHeight < 440 ? 45 : 75,
                a = window.innerWidth < 480 || window.innerHeight < 440 ? 90 : 120,
                o = Model.resizeManager.settings.windowHeight - i - a,
                r = .45 * (o - n.scrollHeight);
            r = i + 15 + r, n.style.top = r + "px"
        }
        m.style.width = window.innerWidth + "px", m.style.height = window.innerHeight + "px", m.style.left = -window.innerWidth + "px";
        var s = .75 * Slice.smallSideC,
            l = window.innerWidth < 480 || window.innerHeight < 440 ? 95 : 124,
            d = window.innerWidth < 480 || window.innerHeight < 440 ? 22 : 29,
            c = Slice.width - Slice.sideB + d;
        f.style.top = Slice.sideC - l + "px", f.style.left = c + "px", _ === !1 && (f.style.width = s + "px", TweenLite.set(f, {
            x: Math.floor(-s)
        })), L.style.top = window.innerHeight + "px";
    }
    var h, w, m, p, f, M, L, v = document.createElement("div"),
        y = "home-panel",
        S = "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600",
        T = "https://www.facebook.com/sharer.php?u=",
        E = "https://twitter.com/intent/tweet?url=",
        _ = !0,
        x = 0;
    return v.animateIn = function(e) {
            _ = !0;
            for (var t = 0; t < M.length; t++) M[t] && (M[t].style.display = "none");
            TweenLite.killTweensOf(M[x]), M[x].style.display = "block", M[x].style.opacity = 0, g(), p.style.opacity = 0, w.style.opacity = 0, f.style.width = 0, L.style.opacity = 0;
            for (var n = [M[x].headline, M[x].subtitle, M[x].cta], t = 0; t < n.length; t++) TweenLite.killTweensOf(n[t]), n[t].style.opacity = 0;
            TweenLite.set([p, w], {
                x: -20
            }), TweenLite.set(f, {
                x: 0
            }), TweenLite.to(f, 1.1, {
                width: Math.floor(.75 * Slice.smallSideC),
                x: Math.ceil(.75 * -Slice.smallSideC) - .5,
                ease: Linear.easeNone,
                onComplete: function() {
                    _ = !1
                }
            }), TweenLite.to(p, .5, {
                onStart: g,
                delay: e,
                opacity: 1,
                x: 0,
                ease: Quart.easeOut
            }), TweenLite.to(L, .5, {
                delay: e + .3,
                opacity: 1,
                ease: Linear.easeNone
            }), TweenLite.to(w, .5, {
                delay: e + .1,
                opacity: 1,
                x: 0,
                ease: Quart.easeOut
            });
            for (var t = 0; t < n.length; t++) {
                var i = n[t];
                i.style.opacity = 0, TweenLite.set(i, {
                    x: 20
                }), TweenLite.to(i, .5, {
                    onStart: function() {
                        M[x].style.opacity = 1
                    },
                    delay: e + .2 + .1 * t,
                    opacity: 1,
                    x: 0,
                    ease: Quart.easeOut
                }), i.line && (i.line.style.width = i.clientWidth + "px")
            }
        }, v.updateInfo = function(e) {
            if (e !== x) {
                var t = x;
                if (M[t])
                    for (var n = [M[x].headline, M[x].subtitle, M[x].cta], i = 0; i < n.length; i++) {
                        var a = n[i];
                        TweenLite.killTweensOf(a), e > t ? TweenLite.to(a, .5, {
                            delay: .1 * i,
                            opacity: 0,
                            x: -20,
                            ease: Quart.easeIn
                        }) : TweenLite.to(a, .5, {
                            delay: .1 * i,
                            opacity: 0,
                            x: 20,
                            ease: Quart.easeIn
                        })
                    }
                if (x = e, M[x]) {
                    if (_ === !0) return;
                    M[x].style.display = "block", M[x].cta.line.style.width = M[x].cta.clientWidth + "px", g();
                    for (var n = [M[x].headline, M[x].subtitle, M[x].cta], i = 0; i < n.length; i++) {
                        var a = n[i];
                        a.style.opacity = 0, e > t ? TweenLite.set(a, {
                            x: 20
                        }) : TweenLite.set(a, {
                            x: -20
                        }), TweenLite.killTweensOf(a), TweenLite.to(a, .5, {
                            delay: .4 + .1 * i,
                            opacity: 1,
                            x: 0,
                            ease: Quart.easeOut,
                            onComplete: function() {
                                M[t] && (M[t].style.display = "none")
                            }
                        })
                    }
                }
            }
        },
        function() {
            v.classList.add(y), n(), i(), a(), o(), r(), s(), l(), t(), g(), TweenLite.set(v, {
                x: -Slice.smallSideC
            })
        }(), v
}

function HomeTimeline(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, s), Model.resizeManager.addEventListener(ResizeManager.LAST_RESIZE, s)
    }

    function n() {
        l = document.createElement("div"), l.classList.add(g + "__bg"), u.appendChild(l), TweenLite.set(l, {
            skewX: -25
        })
    }

    function i() {
        d = new CompactTimeline({
            forwardClick: o,
            backClick: r
        }), u.appendChild(d)
    }

    function a() {
        c = new ExpandedTimeline({
            forwardClick: o,
            backClick: r
        }), u.appendChild(c)
    }

    function o(t) {
        e.forwardClick && e.forwardClick()
    }

    function r(t) {
        e.backClick && e.backClick()
    }

    function s(e) {
        var t = Slice.width + Slice.smallSideC - Slice.sideB + 25 - 1,
            n = Model.resizeManager.settings.windowWidth - t;
        window.innerWidth < 480 || window.innerHeight < 440 ? (n = .5 * window.innerWidth, t = window.innerWidth - n, u.style.zIndex = 3, u.classList.remove(g + "--tall")) : (u.classList.add(g + "--tall"), d.style.zIndex = ""), n < 300 ? (u.classList.add(g + "--mobile"), n < 150 && (n = .3 * window.innerWidth, t = .7 * window.innerWidth)) : u.classList.remove(g + "--mobile"), u.style.left = t + "px", u.style.width = n + "px", d.resize(), c.resize()
    }
    var l, d, c, u = document.createElement("div"),
        g = "home-timeline";
    return u.update = function(e, t) {
            d.update(e, t), c.update(e, t)
        }, u.resize = function() {
            s()
        }, u.animateIn = function(e) {
            s(), d.style.opacity = 0, c.style.opacity = 0, TweenLite.to([d, c], .3, {
                delay: e,
                opacity: 1,
                ease: Linear.easeNone
            })
        },
        function() {
            u.classList.add(g), n(), i(), a(), t(), s()
        }(), u
}

/* Начальная прогрузка */
function IntroSlice(e) {
    function t() {
        s = document.createElement("div"), s.style.position = "absolute", s.style.width = "1px", s.style.height = "0px", s.style.bottom = 0, s.style.backgroundColor = "rgba(255, 255, 255, .2)", l.appendChild(s)
    }
    function n() {
        var t = e.getAttribute("data-image");
        r = Assets.getImage(t), r.onload = function() {
            o(), l.resize()
        }, l.appendChild(r), TweenLite.set(r, {
            z: 1
        })
    }

    function i() {
        TweenLite.set(l, {
            rotation: IntroSlice.currentAngle
        }), r && TweenLite.set(r, {
            rotation: -IntroSlice.currentAngle
        })
    }

    function a() {
        var e = Math.ceil(IntroSlice.sideA + IntroSlice.smallSideB) + 2;
        if (l.style.width = Math.ceil(IntroSlice.width) + "px", l.style.height = e + "px", r) {
            var e = Math.ceil(IntroSlice.sideA + IntroSlice.smallSideB),
                t = IntroSlice.sideC,
                n = u * (t / g),
                i = IntroSlice.sideB + IntroSlice.smallSideC;
            n < i && (n = i, t = g * (n / u)), t *= 1.05, n *= 1.05, r.style.height = Math.ceil(t) + "px", r.style.width = Math.ceil(n) + "px";
            var a = window.innerWidth <= 480,
                o = .5 * (IntroSlice.width - n),
                s = Math.ceil(.5 * (e - t));
            if (a) {
                var d = window.innerWidth * c;
                log("look at this! _mobileOffsetX " + c), o -= d, s += .4665 * d
            }
            TweenLite.set(r, {
                x: o,
                y: s
            })
        }
    }

    function o(e) {
        u = r.naturalWidth || r.clientWidth, g = r.naturalHeight || r.clientHeight, a()
    }
    var r, s, l = document.createElement("div"),
        d = "slice",
        c = 0,
        u = 0,
        g = 0;
	// TweenLite.to .5 начальная загрузка логотип по центру
    return l.resize = function() {
            a(), i()
        }, l.animateIn = function() {
            TweenLite.to(r, .5, {
                onStart: function() {
                    r.style.display = "block"
                },
                delay: 0,
                opacity: 1,
                ease: Quad.easeIn,
                onComplete: function() {
                    s.style.display = "none"
                }
            })
        }, l.progressUpdate = function(e, t) {
            TweenLite.to(s, .4 * (t - 1), {
                delay: .05 * (t - 1),
                height: window.innerHeight * e,
                ease: Quart.easeOut
            })
        }, l.createImage = function() {
            n(), r.style.display = "none", r.style.opacity = 0, i()
        }, l.getImage = function() {
            return r
        },
        function() {
            l.classList.add(d), t(), l.resize()
        }(), l
}

function MenuNav(e) {
    function t() {
        Model.resizeManager.addEventListener(ResizeManager.LAST_RESIZE, a), Model.resizeManager.addEventListener(ResizeManager.RESIZE, a)
    }

    function n() {
        for (var e = 0; e < r.children.length; e++) {
            var t = r.children[e];
            if (t.getAttribute("data-category")) {
                var n = document.createElement("div");
                n.category = t.getAttribute("data-category"), n.classList.add(d + "__button"), n.innerHTML = t.innerHTML, l.appendChild(n), n.addEventListener("click", o), c.push(n)
            }
        }
    }

    function i() {
        s = document.createElement("div"), s.classList.add(d + "__line"), l.appendChild(s)
    }

    function a(e) {
        s.style.left = c[0].offsetLeft + "px", c && (c[0].offsetLeft || setTimeout(a, 100))
    }

    function o(t) {
        e && e(t.target.category)
    }
    var r, s, l = document.createElement("div"),
        d = "menu-nav",
        c = [],
        u = -1;
    return l.selectCategory = function(e) {
            for (var t = 0; t < c.length; t++) {
                var n = c[t];
                if (n.category === e) {
                    if (u === t) return;
                    n.classList.add("selected");
                    var i = 0,
                        a = 0,
                        o = u,
                        r = n.clientWidth;
                    o < 0 ? TweenLite.to(s, .8, {
                        delay: .5,
                        x: 0,
                        width: n.clientWidth,
                        ease: Expo.easeInOut
                    }) : (0 === t ? (i = 0, a = 0, r += c[1].clientWidth, 2 === o && (r += c[2].clientWidth)) : 1 === t ? (i = c[0].clientWidth, r += c[o].clientWidth, 0 === o ? a = 0 : 2 === o && (a = c[0].clientWidth)) : 2 === t && (i = c[0].clientWidth + c[1].clientWidth, 0 === o ? (r += c[0].clientWidth + c[1].clientWidth, a = 0) : 1 === o && (r += c[1].clientWidth, a = c[0].clientWidth)), TweenLite.to(s, .5, {
                        x: a,
                        width: r,
                        ease: Expo.easeInOut
                    }), TweenLite.to(s, .5, {
                        delay: .5,
                        x: i,
                        width: n.clientWidth,
                        ease: Expo.easeInOut
                    })), u = t
                } else n.classList.remove("selected")
            }
        }, l.animateOut = function() {
            Model.resizeManager.removeEventListener(ResizeManager.LAST_RESIZE, a), Model.resizeManager.removeEventListener(ResizeManager.RESIZE, a), TweenLite.to(s, .3, {
                width: 0,
                ease: Expo.easeInOut
            })
        },
        function() {
            l.classList.add(d), r = Model.data.querySelector(".menu"), n(), i(), t(), setTimeout(function() {
                a(), l.selectCategory("athletes")
            }, 200), a()
        }(), l
}

/* таймлиния */
function MenuTimeline() {
    function e() {
        Model.resizeManager.addEventListener(ResizeManager.RESIZE, o)
    }

    function t() {
        s = document.createElement("div"), s.classList.add(c + "__line-bg"), d.appendChild(s)
    }

    function n() {
        l = document.createElement("div"), l.classList.add(c + "__line"), d.appendChild(l)
    }

    function i() {
        r = document.createElement("div"), r.classList.add(c + "__text-container"), d.appendChild(r)
    }

    function a() {
        for (var e = Model.data.querySelectorAll(".athlete-list .athlete"), t = 0; t < e.length; t++) {
            var n = e[t],
                i = document.createElement("div");
            i.classList.add(c + "__text"), i.innerHTML = n.querySelector(".athlete__name--one-line").innerHTML, r.appendChild(i), u.push(i)
        }
    }

    function o(e) {
        var t = window.innerWidth < 800 ? 25 : 70;
        d.style.width = window.innerWidth - t + "px"
    }
    var r, s, l, d = document.createElement("div"),
        c = "menu-timeline",
        u = [],
        g = -1;
    d.animateIn = function() {
        s.style.width = 0, TweenLite.to(s, 1, {
            width: "100%",
            ease: Expo.easeInOut
        })
    };
    var h;
    return d.updateItem = function(e) {
            if (g !== e) {
                h && (clearTimeout(h), h = null);
                for (var t = 0; t < u.length; t++) u[t].classList.remove("show");
                if (u[e]) {
                    var n = u[e];
                    h = setTimeout(function() {
                        n.classList.add("show")
                    }, 400)
                }
                g = e
            }
        }, d.update = function(e) {
            l.style.width = d.clientWidth * e + "px"
        }, d.kill = function() {
            Model.resizeManager.removeEventListener(ResizeManager.RESIZE, o)
        },
        function() {
            d.classList.add(c), t(), n(), i(), a(), e(), o()
        }(), d
}

function QuotePanel(e) {
    function t() {
        c && c.addEventListener("click", s), Model.resizeManager.addEventListener(ResizeManager.RESIZE, l)
    }

    function n() {
        d = document.createElement("div"), d.classList.add(h + "__container"), g.appendChild(d) // , d.innerHTML = e.querySelector(".athlete_quote").innerHTML
    }
	/* построение окна следующая галерея */
    function i() {
        for (var t = Model.data.querySelectorAll(".athlete-list .athlete"), n = 0; n < t.length && t[n] !== e; n++);
        if (t[n + 1]) {
            var i = t[n + 1];
            c = document.createElement("div"), c.url = t[n + 1].getAttribute("data-url"), c.classList.add(h + "__next-button"), d.appendChild(c);
			var imgWrap = document.createElement("div");
			var img = i.querySelector(".athlete__images").children[0];
			var imgContent = '<div class="'+h+'__next-img-title">Следующая:</div><img src="'+img.getAttribute("data-image")+'" alt="" border="0" />';
			imgWrap.classList.add(h + "__next-img"), imgWrap.innerHTML = imgContent, c.appendChild(imgWrap);
            var a = document.createElement("div");
            a.classList.add(h + "__next-button-bg"), c.appendChild(a);
            var o = document.createElement("div");
            o.classList.add(h + "__next-button-text"), o.innerHTML = i.querySelector(".athlete__name--one-line").innerHTML, c.appendChild(o), c.text = o;
            var r = new SVGIcon("arrow");

            r.classList.add(h + "__next-button-arrow"), c.appendChild(r), TweenLite.set(a, {
                skewX: -25
            })
        }
    }

    function a() {
        u = document.createElement("div"), u.classList.add(h + "__social-container"), TweenLite.set(u, { // , d.appendChild(u)
            z: 2
        });
		/*
			var e = new SVGIcon("facebook");
			e.classList.add(h + "__facebook"), u.appendChild(e);
			var t = new SVGIcon("twitter");
			t.classList.add(h + "__twitter"), u.appendChild(t), e.addEventListener("click", o), t.addEventListener("click", r), Modernizr.touch && (u.style.display = "none")
		*/
    }

    function o(e) {
        var t = window.location.href;
        t = t.replace(/#/i, "%23"), window.open(m + t, "_blank", w)
    }

    function r(e) {
        var t = window.location.href;
        t = t.replace(/#/i, "%23"), window.open(p + t, "_blank", w)
    }

    function s(e) {
        Model.urlManager.updateURL("athletes" + URLManager.SLASH + c.url)
    }

    function l(e) {
        if (c) {
            var t = window.innerWidth < 768 ? 145 : 215;
            window.innerHeight <= 600 && (t = 105), c.style.width = c.text.clientWidth + t + "px"
        }
        window.innerWidth < 768 ? g.style.width = window.innerWidth + "px" : g.style.width = .5 * window.innerWidth + "px", f ? TweenLite.set(g, {
            x: Math.floor(.5 * window.innerWidth)
        }) : TweenLite.set(g, {
            x: window.innerWidth
        })
    }
    var d, c, u, g = document.createElement("div"),
        h = "quote-panel",
        w = "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600",
        m = "https://www.facebook.com/sharer.php?u=",
        p = "https://twitter.com/intent/tweet?url=",
        f = !1;
    return g.show = function(e) {
            log("show"), g.style.display = "block", l(), f = !0, e = .6, TweenLite.set(g, {
                x: window.innerWidth
            }), window.innerWidth >= 768 ? TweenLite.to(g, e, {
                x: Math.floor(.5 * window.innerWidth),
                ease: Quart.easeOut
            }) : TweenLite.to(g, e, {
                x: 0,
                ease: Quart.easeOut
            })
        }, g.hide = function(e) {
            f === !0 && (f = !1, e = .6, TweenLite.to(g, e, {
                x: window.innerWidth,
                ease: Quart.easeOut,
                onComplete: function() {
                    g.style.display = "none"
                }
            }))
        }, g.kill = function() {
            c && c.removeEventListener("click", s), Model.resizeManager.removeEventListener(ResizeManager.RESIZE, l)
        },
        function() {
            g.classList.add(h), n(), i(), a(), t(), l(), g.style.display = "none"
        }(), g
}

function SVGIcon(e) {
    var t = document.createElement("div");
    return function() {
        var n = Model.data.querySelector(".icons"),
            i = n.querySelector(".svg--" + e);
        if (i) {
            var a = i.cloneNode(!0);
            return t.appendChild(a), a
        }
        log("SVG icon doesn't exist: " + e)
    }(), t
}

/* функция, когда у нас загружен экран */
function Slice(e) {
    function t() {
        l.addEventListener("click", o)
    }
    function n() {
        var t = e.querySelector(".athlete__images").children[0];
        s = Assets.getImage(t.getAttribute("data-image")), s.onload = function() {
            r(), l.resize()
        }, l.appendChild(s), TweenLite.set(s, {
            z: 1
        })
    }

    function i() {
        TweenLite.set(l, {
            rotation: Slice.currentAngle
        }), TweenLite.set(s, {
            rotation: -Slice.currentAngle
        })
    }

    function a() {
        l.style.width = Math.ceil(Slice.width) + "px";
        var e = Math.ceil(Slice.sideA + Slice.smallSideB),
            t = Slice.sideC,
            n = u * (t / g),
            i = Slice.sideB + Slice.smallSideC;
        n < i && (n = i, t = g * (n / u)), t *= 1.05, n *= 1.05, s.style.height = Math.ceil(t) + "px", s.style.width = Math.ceil(n) + "px";
        var a = window.innerWidth <= 640,
            o = .5 * (Slice.width - n),
            r = .5 * (e - t);
        if (a) {
            var d = window.innerWidth * c;
            o -= d, r += .4665 * d
        }
        TweenLite.set(s, {
            x: o,
            y: r
        })
    }

    function o(t) {
        var n = !0;
        if (Model.dragManager && Model.dragManager.isClicking === !1 && (n = !1), n) {
            var i = e.getAttribute("data-url");
            Model.urlManager.updateURL("athletes" + URLManager.SLASH + i)
        }
    }

    function r(e) {
        u = s.naturalWidth || s.clientWidth, g = s.naturalHeight || s.clientHeight, a()
    }
    var s, l = document.createElement("div"),
        d = "slice",
        c = 0,
        u = 0,
        g = 0;
    return l.resize = function() {
            var e = Math.ceil(Slice.sideA + Slice.smallSideB);
            l.style.height = e + "px", a()
        }, l.triggerURL = function(e) {
            o()
        }, l.zoomOutImage = function(e) {
            TweenLite.killTweensOf(s), e === !0 ? TweenLite.to(s, .2, {
                scale: .96,
                ease: Quad.easeInOut
            }) : TweenLite.set(s, {
                scale: .96
            })
        }, l.zoomInImage = function(e) {
            TweenLite.killTweensOf(s), e === !0 ? TweenLite.to(s, .2, {
                scale: 1,
                ease: Quad.easeInOut
            }) : TweenLite.set(s, {
                scale: 1
            })
        },
        function() {
            l.classList.add(d), TweenLite.set(l, {
                z: 1
            }), e.getAttribute("data-mobile-offset") && (c = e.getAttribute("data-mobile-offset")), n(), i(), t(), l.resize()
        }(), l
}

function TransitionSlice(e) {
    function t() {
        var t = e.querySelector(".athlete__images").children[0];
        o = Assets.getImage(t.getAttribute("data-image")), o.onload = function() {
            a(), r.resize()
        }, r.appendChild(o), TweenLite.set(o, {
            z: 1
        })
    }

    function n() {
        TweenLite.set(r, {
            rotation: TransitionSlice.currentAngle
        }), o && TweenLite.set(o, {
            rotation: -TransitionSlice.currentAngle
        })
    }

    function i() {
        var e = Math.ceil(TransitionSlice.sideA + TransitionSlice.smallSideB) + 2;
        if (r.style.width = Math.ceil(TransitionSlice.width) + "px", r.style.height = e + "px", o) {
            var e = Math.ceil(TransitionSlice.sideA + TransitionSlice.smallSideB),
                t = TransitionSlice.sideC,
                n = d * (t / c),
                i = TransitionSlice.sideB + TransitionSlice.smallSideC;
            n < i && (n = i, t = c * (n / d)), t *= 1.05, n *= 1.05, o.style.height = Math.ceil(t) + "px", o.style.width = Math.ceil(n) + "px";
            var a = window.innerWidth <= 640,
                s = .5 * (TransitionSlice.width - n),
                u = Math.ceil(.5 * (e - t)),
                g = TransitionSlice.currentAngle / 25;
            if (a) {
                var h = window.innerWidth * l;
                h *= g, s -= h, u += h * (.4665 * g)
            }
            TweenLite.set(o, {
                x: s,
                y: u
            })
        }
    }

    function a(e) {
        d = o.naturalWidth || o.clientWidth, c = o.naturalHeight || o.clientHeight, i()
    }
    var o, r = document.createElement("div"),
        s = "slice",
        l = 0,
        d = 0,
        c = 0;
    return r.resize = function() {
            i(), n()
        }, r.getImage = function() {
            return o
        },
        function() {
            r.classList.add(s), e.getAttribute("data-mobile-offset") && (l = e.getAttribute("data-mobile-offset")), t(), n(), r.resize()
        }(), r
}

/* Функция загрузки страницы */
function Preloader() {
    function e() {
        var e = document.createElement("img");
        e.onload = function() {
            e.onload = null, e.onerror = null, t(this)
        }, e.onerror = function() {
            e.onload = null, e.onerror = null, t()
        }, e.src = Assets.checkForMobile(i[s])
    }

    function t(t) {
        Assets.addImage(i[s], t), s++, o && o(s / (i.length - 1)), s < i.length - 1 ? e() : n()
    }

    function n() {
        a && a()
    }
    var i, a, o, r = {},
        s = 0;
    return r.load = function(t, n, r) {
        s = 0, i = t, a = n, o = r, e()
    }, r.kill = function() {
        s = null, i = null, a = null
    }, r
}
Array.prototype.equals && console.warn("Overriding existing Array.prototype.equals. Possible causes: New API defines the method, there's a framework conflict or you've got double inclusions in your code."), Array.prototype.equals = function(e) {
        if (!e) return !1;
        if (this.length != e.length) return !1;
        for (var t = 0, n = this.length; t < n; t++)
            if (this[t] instanceof Array && e[t] instanceof Array) {
                if (!this[t].equals(e[t])) return !1
            } else if (this[t] != e[t]) return !1;
        return !0
    }, Object.defineProperty(Array.prototype, "equals", {
        enumerable: !1
    }),
    function(e) {
        var t = {},
            n = e || "devmode";
        t.init = function(e) {
            n = e || "devmode"
        }, window.log = function(e) {
            "devmode" === n && console.log(e)
        }, window.dir = function(e) {
            "devmode" === n && console.dir(e)
        }, window.Log = t
    }(),
    function() {
        var e = {},
            t = {};
        e.addImage = function(n, i) {
            n = e.checkForMobile(n), t[n] ? log("Assets.js: image name already exists - " + n) : t[n] = i
        }, e.getImage = function(n) {
            if (n = e.checkForMobile(n), t[n]) {
                return t[n].cloneNode(!0)
            }
            log("Assets.js: Image doesnt exist - " + n)
        }, e.checkForMobile = function(e) {
            if (Model.isSmallScreen === !0 && e.indexOf("/images/mobile/") === -1) {
                var t = e.split("/images/");
                t.length > 1 && (e = t[0] + "/images/mobile/" + t[1])
            }
            return e
        }, window.Assets = e
    }(),
    function() {
        var e = {};
        e.DEV_MODE = "devmode", e.PROD_MODE = "prodmode", e.MODE = e.PROD_MODE, e.IMAGE_PATH = "", e.isSmallScreen = !1, e.isFirefox = !1, e.scrollContainer, e.main, e.mainContainer, e.data, e.urlManager, e.dragManager, e.scrollManager, e.mouseManager, e.resizeManager, e.zoomManager, e.burger, e.galleryImageData, e.athleteIndex = 0, e.init = function() {
            if (screen) {
                Math.max(screen.width, screen.height) < 800 && (e.isSmallScreen = !0)
            }
            window.navigator.userAgent.indexOf("Firefox") > -1 && (e.isFirefox = !0)
        }, window.Model = e
    }(), Spacer.width = 800, Spacer.updateWidth = function() {
        window.innerWidth < 800 ? Spacer.width = 400 : Spacer.width = 800
    }, Spacer.updateWidth(), Slice.toRadians = function(e) {
        return e * (Math.PI / 180)
    }, IntroSlice.angle = 0, IntroSlice.currentAngle = IntroSlice.angle, IntroSlice.angleA = Slice.toRadians(90), IntroSlice.angleB = Slice.toRadians(IntroSlice.angle), IntroSlice.angleC = Slice.toRadians(90 - IntroSlice.angle), IntroSlice.sideA, IntroSlice.sideB, IntroSlice.sideC, IntroSlice.smallSideA, IntroSlice.smallSideB, IntroSlice.smallSideC, IntroSlice.updateDimensions = function() {
        IntroSlice.angleA = Slice.toRadians(90), IntroSlice.angleB = Slice.toRadians(IntroSlice.currentAngle), IntroSlice.angleC = Slice.toRadians(90 - IntroSlice.currentAngle);
        var e = .3 * window.innerWidth;
        window.innerWidth < 1050 && (e = Math.floor(.51 * window.innerWidth)), IntroSlice.width = e, IntroSlice.sideC = window.innerHeight, IntroSlice.sideA = IntroSlice.sideC / Math.sin(IntroSlice.angleC) * Math.sin(IntroSlice.angleA), IntroSlice.sideB = IntroSlice.sideC / Math.sin(IntroSlice.angleC) * Math.sin(IntroSlice.angleB);
        var t = 1 - IntroSlice.sideC / IntroSlice.sideA;
        IntroSlice.smallSideC = IntroSlice.width * (1 + t), IntroSlice.smallSideA = IntroSlice.smallSideC / Math.sin(IntroSlice.angleA) * Math.sin(IntroSlice.angleC), IntroSlice.smallSideB = IntroSlice.smallSideC / Math.sin(IntroSlice.angleA) * Math.sin(IntroSlice.angleB);
        var n = IntroSlice.smallSideB,
            i = n / Math.sin(IntroSlice.angleA) * Math.sin(IntroSlice.angleC);
        IntroSlice.tinySideC = i, IntroSlice.tinySideA = IntroSlice.tinySideC / Math.sin(IntroSlice.angleC) * Math.sin(IntroSlice.angleA), IntroSlice.tinySideB = IntroSlice.tinySideC / Math.sin(IntroSlice.angleC) * Math.sin(IntroSlice.angleB)
    }, Slice.toRadians = function(e) {
        return e * (Math.PI / 180)
    }, Slice.angle = 25, Slice.currentAngle = Slice.angle, Slice.angleA = Slice.toRadians(90), Slice.angleB = Slice.toRadians(Slice.angle), Slice.angleC = Slice.toRadians(90 - Slice.angle), Slice.sideA, Slice.sideB, Slice.sideC, Slice.smallSideA, Slice.smallSideB, Slice.smallSideC, Slice.updateDimensions = function() {
        var e;
        window.innerWidth > 2200 ? e = .41 * window.innerWidth : window.innerWidth > 1300 ? (e = .41 * window.innerWidth, window.innerHeight > 1e3 && (e = .44 * window.innerWidth)) : window.innerWidth > 960 ? (e = .43 * window.innerWidth, window.innerHeight > 910 && (e = .475 * window.innerWidth)) : e = window.innerWidth > 640 ? .6 * window.innerWidth : window.innerWidth > 480 ? window.innerHeight < 440 ? .65 * window.innerWidth : .82 * window.innerWidth : window.innerWidth >= 414 ? .83 * window.innerWidth : window.innerWidth >= 375 ? .81 * window.innerWidth : (window.innerWidth, .82 * window.innerWidth), Slice.width = e, Slice.sideC = window.innerHeight, Slice.sideA = Slice.sideC / Math.sin(Slice.angleC) * Math.sin(Slice.angleA), Slice.sideB = Slice.sideC / Math.sin(Slice.angleC) * Math.sin(Slice.angleB), Slice.smallSideC = 1.103 * Slice.width, Slice.smallSideA = Slice.smallSideC / Math.sin(Slice.angleA) * Math.sin(Slice.angleC), Slice.smallSideB = Slice.smallSideC / Math.sin(Slice.angleA) * Math.sin(Slice.angleB);
        var t = Slice.smallSideB,
            n = t / Math.sin(Slice.angleA) * Math.sin(Slice.angleC);
        Slice.tinySideC = n, Slice.tinySideA = Slice.tinySideC / Math.sin(Slice.angleC) * Math.sin(Slice.angleA), Slice.tinySideB = Slice.tinySideC / Math.sin(Slice.angleC) * Math.sin(Slice.angleB)
    }, TransitionSlice.angle = 25, TransitionSlice.currentAngle = TransitionSlice.angle, TransitionSlice.angleA = Slice.toRadians(90), TransitionSlice.angleB = Slice.toRadians(TransitionSlice.angle), TransitionSlice.angleC = Slice.toRadians(90 - TransitionSlice.angle), TransitionSlice.sideA, TransitionSlice.sideB, TransitionSlice.sideC, TransitionSlice.smallSideA, TransitionSlice.smallSideB, TransitionSlice.smallSideC, TransitionSlice.updateDimensions = function(e) {
        TransitionSlice.angleA = Slice.toRadians(90), TransitionSlice.angleB = Slice.toRadians(TransitionSlice.currentAngle), TransitionSlice.angleC = Slice.toRadians(90 - TransitionSlice.currentAngle);
        var t;
        e ? t = e : window.innerWidth > 2200 ? t = .41 * window.innerWidth : window.innerWidth > 1300 ? (t = .41 * window.innerWidth, window.innerHeight > 1e3 && (t = .44 * window.innerWidth)) : window.innerWidth > 960 ? (t = .43 * window.innerWidth, window.innerHeight > 910 && (t = .475 * window.innerWidth)) : t = window.innerWidth > 640 ? .5 * window.innerWidth : window.innerWidth > 480 ? .82 * window.innerWidth : 414 === window.innerWidth ? .82 * window.innerWidth : 375 === window.innerWidth ? .81 * window.innerWidth : (window.innerWidth, .82 * window.innerWidth), TransitionSlice.width = t, TransitionSlice.sideC = window.innerHeight, TransitionSlice.sideA = TransitionSlice.sideC / Math.sin(TransitionSlice.angleC) * Math.sin(TransitionSlice.angleA), TransitionSlice.sideB = TransitionSlice.sideC / Math.sin(TransitionSlice.angleC) * Math.sin(TransitionSlice.angleB);
        var n = 1 - TransitionSlice.sideC / TransitionSlice.sideA;
        TransitionSlice.smallSideC = TransitionSlice.width * (1 + n), TransitionSlice.smallSideA = TransitionSlice.smallSideC / Math.sin(TransitionSlice.angleA) * Math.sin(TransitionSlice.angleC), TransitionSlice.smallSideB = TransitionSlice.smallSideC / Math.sin(TransitionSlice.angleA) * Math.sin(TransitionSlice.angleB)
    },
    function(e) {
        for (var t, n, i, a = [{
                name: "svg",
                value: "url(#test)"
            }, {
                name: "inset",
                value: "inset(10px 20px 30px 40px)"
            }, {
                name: "circle",
                value: "circle(60px at center)"
            }, {
                name: "ellipse",
                value: "ellipse(50% 50% at 50% 50%)"
            }, {
                name: "polygon",
                value: "polygon(50% 0%, 0% 100%, 100% 100%)"
            }], o = 0; o < a.length; o++) t = a[o].name, n = a[o].value, e.addTest("cssclippath" + t, function() {
            if ("CSS" in window && "supports" in window.CSS) {
                for (var t = 0; t < e._prefixes.length; t++)
                    if (i = e._prefixes[t] + "clip-path", window.CSS.supports(i, n)) return !0;
                return !1
            }
            return e.testStyles("#modernizr { " + e._prefixes.join("clip-path:" + n + "; ") + " }", function(t, n) {
                var i = getComputedStyle(t),
                    a = i.clipPath;
                if (!a || "none" == a) {
                    a = !1;
                    for (var o = 0; o < e._domPrefixes.length; o++)
                        if (test = e._domPrefixes[o] + "ClipPath", i[test] && "none" !== i[test]) {
                            a = !0;
                            break
                        }
                }
                return e.testProp("clipPath") && a
            })
        })
    }(Modernizr),
    function(e) {
        function t() {
            e.scrollTo(a.x, a.y)
        }
        var n, i = {},
            a = {};
        i.init = function() {
            n = e, i._setPositions(), n.addEventListener("scroll", function(e) {
                i._setPositions(e)
            })
        }, i.scroll = function(n) {
            var o = {
                x: 0,
                y: 0,
                speed: .8,
                ease: Quad.easeInOut,
                animate: !0,
                onComplete: function() {},
                onUpdate: function() {}
            };
            for (var r in n) o[r] = n[r];
            a.x = i.getPositionX(), a.y = i.getPositionY(), o.animate === !0 ? (TweenLite.killTweensOf(a), TweenLite.to(a, o.speed, {
                onUpdate: t,
                x: o.x,
                y: o.y,
                ease: o.ease,
                onComplete: o.onComplete
            })) : (TweenLite.killTweensOf(a), e.scrollTo(o.x, o.y), i._setPositions())
        }, i._setPositions = function(t) {
            a.x = e.pageXOffset, a.y = e.pageYOffset, a.x < 0 && (a.x = 0), a.y <= 0 && (a.y = 0)
        }, i.getPositionX = function() {
            return a.x
        }, i.getPositionY = function() {
            return a.y
        }, i.getDocumentHeight = function() {
            var e = document.body,
                t = document.documentElement;
            return Math.max(e.scrollHeight, e.offsetHeight, t.clientHeight, t.scrollHeight, t.offsetHeight)
        }, e.WindowScroll = i
    }(window),
    function() {
        "use strict";

        function e() {
            i = new Intro(t), Model.mainContainer.appendChild(i)
        }

        function t() {
            n()
        }

        function n() {
            i.kill(), Model.mainContainer.removeChild(i), i = null;
            var e = new View;
            Model.mainContainer.appendChild(e)
        }
        var i, a = {};
        a.init = function() {
            document.body.style.backgroundColor = "#fff", TweenLite.defaultEase = Linear.easeNone, Log.init(Model.MODE), Model.init(), Model.main = document.querySelector(".body-issue"), Model.mainContainer = document.querySelector(".body-issue__container"), Model.data = Model.mainContainer.querySelector(".data"), Model.mainContainer.removeChild(Model.data), Model.mouseManager = new MouseManager, WindowScroll.init(), setTimeout(function() {
                WindowScroll.scroll({
                    y: 0,
                    animate: !1
                })
            }, 100), Model.urlManager = new URLManager, Model.resizeManager = new ResizeManager, Model.zoomManager = new ZoomManager, Modernizr.touch ? Model.dragManager = new DragManager : Model.scrollManager = new ScrollManager(window, Model.scrollContainer), e()
        }, window.Main = a
    }(), window.onload = Main.init, window.onunload = function() {
        window.scrollTo(0, 0)
    };