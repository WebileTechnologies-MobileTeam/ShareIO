(() => {
    var __webpack_modules__ = {
            567: (e, a, t) => {
                "use strict";
                t.d(a, {
                    O: () => i
                });
                const i = {
                    PLAYLIST_TRANSITION_DURATION: 300,
                    DEBUG_STYLE_1: "background-color: #aaa022; color: #222222;",
                    DEBUG_STYLE_2: "background-color: #7c3b8e; color: #ffffff;",
                    DEBUG_STYLE_3: "background-color: #3a696b; color: #eeeeee;",
                    DEBUG_STYLE_ERROR: "background-color: #3a696b; color: #eeeeee;",
                    URL_WAVESURFER_HELPER_BACKUP: "https://zoomthe.me/assets/dzsap-wave-generate.js",
                    WAVESURFER_MAX_TIMEOUT: 2e4,
                    URL_JQUERY: "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js",
                    DEBUG_STYLE_PLAY_FUNCTIONS: "background-color: #daffda; color: #222222;",
                    ERRORED_OUT_CLASS: "errored-out",
                    ERRORED_OUT_MAX_ATTEMPTS: 5
                }
            },
            424: (e, a) => {
                a.P = {
                    design_skin: "skin-default",
                    call_from: "default",
                    autoplay_on_scrub_click: "off",
                    cueMedia: "on",
                    preload_method: "metadata",
                    loop: "off",
                    pause_method: "pause",
                    settings_extrahtml: "",
                    settings_extrahtml_before_play_pause: "",
                    settings_extrahtml_after_play_pause: "",
                    settings_trigger_resize: "0",
                    design_thumbh: "default",
                    extra_classes_player: "",
                    disable_volume: "default",
                    disable_scrub: "default",
                    disable_timer: "default",
                    disable_player_navigation: "off",
                    scrub_show_scrub_time: "on",
                    player_navigation: "default",
                    type: "audio",
                    enable_embed_button: "off",
                    embed_code: "",
                    skinwave_dynamicwaves: "off",
                    soundcloud_apikey: "",
                    skinwave_enableSpectrum: "off",
                    skinwave_place_thumb_after_volume: "off",
                    skinwave_place_metaartist_after_volume: "off",
                    skinwave_spectrummultiplier: "1",
                    php_retriever: "soundcloudretriever.php",
                    skinwave_mode: "normal",
                    skinwave_wave_mode: "canvas",
                    skinwave_wave_mode_canvas_mode: "normal",
                    skinwave_wave_mode_canvas_normalize: "on",
                    skinwave_wave_mode_canvas_waves_number: "3",
                    skinwave_wave_mode_canvas_waves_padding: "1",
                    skinwave_wave_mode_canvas_reflection_size: "0.25",
                    wavesurfer_pcm_length: "200",
                    pcm_data_try_to_generate: "on",
                    pcm_data_try_to_generate_wait_for_real_pcm: "on",
                    pcm_notice: "off",
                    notice_no_media: "on",
                    sampleTimesMode: "realPrevivew",
                    mobile_delete: "off",
                    footer_btn_playlist: "off",
                    mobile_disable_fakeplayer: "off",
                    skinwave_comments_displayontime: "on",
                    skinwave_comments_allow_post_if_not_logged_in: "on",
                    skinwave_comments_links_to: "",
                    skinwave_comments_enable: "off",
                    skinwave_comments_mode_outer_selector: "",
                    skinwave_comments_playerid: "",
                    skinwave_timer_static: "off",
                    default_volume: "default",
                    volume_from_gallery: "",
                    design_menu_show_player_state_button: "off",
                    playfrom: "off",
                    design_animateplaypause: "default",
                    embedded: "off",
                    embedded_iframe_id: "",
                    google_analytics_send_play_event: "off",
                    fakeplayer: null,
                    failsafe_repair_media_element: "",
                    action_audio_play: null,
                    action_audio_play2: null,
                    action_audio_pause: null,
                    action_audio_end: null,
                    action_audio_comment: null,
                    action_received_time_total: null,
                    action_audio_change_media: null,
                    action_audio_loaded_metadata: null,
                    action_video_contor_60secs: null,
                    type_audio_stop_buffer_on_unfocus: "off",
                    settings_exclude_from_list: "off",
                    design_wave_color_bg: "222222",
                    design_wave_color_progress: "ea8c52",
                    skin_minimal_button_size: "100",
                    gallery_gapless_play: "off",
                    preview_on_hover: "off",
                    controls_external_scrubbar: "",
                    parentgallery: null,
                    scrubbar_type: "auto",
                    settings_php_handler: ""
                }
            },
            401: (e, a) => {
                a.decode_json = function(e) {
                    var a = {};
                    if (e) try {
                        a = JSON.parse(e)
                    } catch (a) {
                        return console.log(a, e), null
                    }
                    return a
                }, a.loadScriptIfItDoesNotExist = (e, a) => new Promise(((t, i) => {
                    if (a) t("loadfromvar");
                    else {
                        var s = document.createElement("script");
                        s.onload = function() {
                            t("loadfromload")
                        }, s.onerror = function() {
                            i()
                        }, s.src = e, document.head.appendChild(s)
                    }
                })), a.getBaseUrl = (e, a) => {
                    if (window[e]) return window[e];
                    let t = document.getElementsByTagName("script");
                    for (var i in t)
                        if (t[i] && t[i].src && String(t[i].src).indexOf(a) > -1) break;
                    var s = String(t[i].src).split("/");
                    s.splice(-1, 1);
                    const n = s.join("/");
                    return window[e] = n, n
                }, a.sanitizeToCssPx = e => String(e).indexOf("%") > -1 || String(e).indexOf("em") > -1 || String(e).indexOf("px") > -1 || String(e).indexOf("auto") > -1 ? e : e + "px", a.setupTooltip = e => {
                    var a = Object.assign({
                        tooltipInnerHTML: "",
                        tooltipIndicatorText: "",
                        tooltipConClass: ""
                    }, e);
                    return `<div class="dzstooltip-con ${a.tooltipConClass}"><span class="dzstooltip main-tooltip   talign-end arrow-bottom style-rounded color-dark-light  dims-set transition-slidedown " style="width: 280px;"><span class="dzstooltip--inner">${a.tooltipInnerHTML}</span> </span></span><span class="tooltip-indicator">${a.tooltipIndicatorText}</span></div>`
                }, a.isInt = function(e) {
                    return "number" == typeof e && Math.round(e) % 1 == 0
                }, a.isValid = function(e) {
                    return void 0 !== e && "" != e
                }, a.getRelativeX = function(e, a) {
                    if (jQuery) return e - jQuery(a).offset().left
                }
            },
            891: (e, a, t) => {
                "use strict";
                t.r(a), t.d(a, {
                    ajax_submit_views: () => n,
                    ajax_submit_like: () => o,
                    ajax_retract_like: () => r,
                    ajax_comment_publish: () => l,
                    ajax_submit_total_time: () => d,
                    ajax_submit_download: () => _
                });
                var i = t(586);
                const s = t(401),
                    n = function(e) {
                        var a = this,
                            t = jQuery,
                            n = {
                                action: "dzsap_submit_views",
                                postdata: 1,
                                playerid: a.the_player_id,
                                currip: a.currIp
                            };
                        a.cthis.attr("data-playerid-for-views") && (n.playerid = a.cthis.attr("data-playerid-for-views")), "" == n.playerid && (n.playerid = i.dzs_clean_string(a.data_source)), a.urlToAjaxHandler && (t.ajax({
                            type: "POST",
                            url: a.urlToAjaxHandler,
                            data: n,
                            success: function(e) {
                                window.console;
                                var t = a.cthis.find(".counter-hits .the-number").html();
                                t = parseInt(t, 10), 2 != a.increment_views && t++, e && s.decode_json(e) && (t = s.decode_json(e).number), a.cthis.find(".counter-hits .the-number").html(t), a.ajax_view_submitted = "on"
                            },
                            error: function(e) {
                                window.console;
                                var t = a.cthis.find(".counter-hits .the-number").html();
                                t = parseInt(t, 10), t++, a.cthis.find(".counter-hits .the-number").html(t), a.ajax_view_submitted = "on"
                            }
                        }), a.ajax_view_submitted = "on")
                    },
                    o = function(e) {
                        var a = this,
                            t = jQuery,
                            i = {
                                action: "dzsap_submit_like",
                                postdata: e,
                                playerid: a.the_player_id
                            };
                        a.cthis.find(".btn-like").addClass("disabled"), (a.urlToAjaxHandler || a.cthis.hasClass("is-preview")) && t.ajax({
                            type: "POST",
                            url: a.urlToAjaxHandler,
                            data: i,
                            success: function(e) {
                                window.console, a.cthis.find(".btn-like").addClass("active"), a.cthis.find(".btn-like").removeClass("disabled");
                                var t = a.cthis.find(".counter-likes .the-number").html();
                                t = parseInt(t, 10), t++, a.cthis.find(".counter-likes .the-number").html(t)
                            },
                            error: function(e) {
                                window.console, a.cthis.find(".btn-like").addClass("active"), a.cthis.find(".btn-like").removeClass("disabled");
                                var t = a.cthis.find(".counter-likes .the-number").html();
                                t = parseInt(t, 10), t++, a.cthis.find(".counter-likes .the-number").html(t)
                            }
                        })
                    },
                    r = function(e) {
                        var a = this,
                            t = jQuery,
                            i = {
                                action: "dzsap_retract_like",
                                postdata: e,
                                playerid: a.the_player_id
                            };
                        a.cthis.find(".btn-like").addClass("disabled"), a.urlToAjaxHandler && t.ajax({
                            type: "POST",
                            url: a.urlToAjaxHandler,
                            data: i,
                            success: function(e) {
                                window.console, a.cthis.find(".btn-like").removeClass("active"), a.cthis.find(".btn-like").removeClass("disabled");
                                var t = a.cthis.find(".counter-likes .the-number").html();
                                t = parseInt(t, 10), t--, a.cthis.find(".counter-likes .the-number").html(t)
                            },
                            error: function(e) {
                                window.console, a.cthis.find(".btn-like").removeClass("active"), a.cthis.find(".btn-like").removeClass("disabled");
                                var t = a.cthis.find(".counter-likes .the-number").html();
                                t = parseInt(t, 10), t--, a.cthis.find(".counter-likes .the-number").html(t)
                            }
                        })
                    },
                    l = function(e) {
                        var a = this,
                            t = jQuery,
                            s = a.initOptions;
                        console.log(" o - ", s, a);
                        var n = {
                            action: "dzsap_front_submitcomment",
                            postdata: e,
                            playerid: a.the_player_id,
                            comm_position: a.commentPositionPerc
                        };
                        window.dzsap_settings && (n.skinwave_comments_avatar = window.dzsap_settings.comments_avatar, n.skinwave_comments_account = window.dzsap_settings.comments_username), a.cthis.find("*[name=comment-email]").length > 0 && (n.email = a.cthis.find("*[name=comment-email]").eq(0).val()), a.urlToAjaxHandler && jQuery.ajax({
                            type: "POST",
                            url: a.urlToAjaxHandler,
                            data: n,
                            success: function(e) {
                                "0" == e.charAt(e.length - 1) && (e = e.slice(0, e.length - 1)), window.console;
                                var s = "";
                                s = "", s += '<span class="dzstooltip-con" style="left:' + a.commentPositionPerc + '"><span class="dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black" style="width: 250px;"><span class="the-comment-author">@' + window.dzsap_settings.comments_username + "</span> says:<br>", s += i.htmlEncode(n.postdata), s += '</span><div class="the-avatar" style="background-image: url(' + window.dzsap_settings.comments_avatar + ')"></div></span>', a._commentsHolder.children().each((function() {
                                    var e = t(this);
                                    0 == e.hasClass("dzstooltip-con") && e.addClass("dzstooltip-con")
                                })), a._commentsHolder.append(s), a.action_audio_comment && a.action_audio_comment(a.cthis, s)
                            },
                            error: function(e) {
                                window.console, a._commentsHolder.append(n.postdata)
                            }
                        })
                    },
                    d = function(e) {
                        e.isSentCacheTotalTime || ((!e.cthis.attr("data-sample_time_total") || e.cthis.attr("data-sample_time_total") && e.timeModel.getActualTotalTime() && e.timeModel.getActualTotalTime() != e.cthis.attr("data-sample_time_total") && !e.cthis.attr("data-sample_time_end")) && e.initOptions.action_received_time_total && (e.timeModel.refreshTimes(), e.initOptions.action_received_time_total(e.timeModel.getActualTotalTime(), e.cthis)), e.isSentCacheTotalTime = !0)
                    },
                    _ = function(e) {
                        var a = this,
                            t = {
                                action: "dzsap_submit_download",
                                postdata: e,
                                playerid: a.the_player_id
                            };
                        a.starrating_alreadyrated > -1 || a.urlToAjaxHandler && jQuery.ajax({
                            type: "POST",
                            url: a.urlToAjaxHandler,
                            data: t,
                            success: function(e) {},
                            error: function(e) {}
                        })
                    }
            },
            586: (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
                "use strict";
                __webpack_require__.r(__webpack_exports__), __webpack_require__.d(__webpack_exports__, {
                    dzsap_generate_keyboard_controls: () => dzsap_generate_keyboard_controls,
                    formatTime: () => formatTime,
                    can_history_api: () => can_history_api,
                    dzs_clean_string: () => dzs_clean_string,
                    get_query_arg: () => get_query_arg,
                    add_query_arg: () => add_query_arg,
                    dzsap_is_mobile: () => dzsap_is_mobile,
                    is_ie: () => is_ie,
                    is_ios: () => is_ios,
                    can_canvas: () => can_canvas,
                    is_safari: () => is_safari,
                    is_android: () => is_android,
                    select_all: () => select_all,
                    is_android_good: () => is_android_good,
                    htmlEncode: () => htmlEncode,
                    dzsap_generate_keyboard_tooltip: () => dzsap_generate_keyboard_tooltip,
                    handle_keypresses: () => handle_keypresses,
                    hexToRgb: () => hexToRgb,
                    assignHelperFunctionsToJquery: () => assignHelperFunctionsToJquery,
                    registerTextWidth: () => registerTextWidth,
                    player_checkIfWeShouldShowAComment: () => player_checkIfWeShouldShowAComment,
                    sanitizeObjectForChangeMediaArgs: () => sanitizeObjectForChangeMediaArgs,
                    utils_sanitizeToColor: () => utils_sanitizeToColor,
                    dzsapInitjQueryRegisters: () => dzsapInitjQueryRegisters,
                    player_radio_isNameUpdatable: () => player_radio_isNameUpdatable,
                    playerRegisterWindowFunctions: () => playerRegisterWindowFunctions,
                    dzsap_singleton_ready_calls: () => dzsap_singleton_ready_calls,
                    jQueryAuxBindings: () => jQueryAuxBindings,
                    selectText: () => selectText,
                    view_player_playMiscEffects: () => view_player_playMiscEffects,
                    view_player_globalDetermineSyncPlayersIndex: () => view_player_globalDetermineSyncPlayersIndex,
                    player_view_addMetaLoaded: () => player_view_addMetaLoaded,
                    player_determineActualPlayer: () => player_determineActualPlayer,
                    waitForScriptToBeAvailableThenExecute: () => waitForScriptToBeAvailableThenExecute,
                    configureAudioPlayerOptionsInitial: () => configureAudioPlayerOptionsInitial,
                    player_reinit_findIfPcmNeedsGenerating: () => player_reinit_findIfPcmNeedsGenerating,
                    playerFunctions: () => playerFunctions,
                    player_delete: () => player_delete,
                    player_viewApplySkinWaveModes: () => player_viewApplySkinWaveModes,
                    sanitizeToHexColor: () => sanitizeToHexColor,
                    player_identifySource: () => player_identifySource,
                    player_identifyTypes: () => player_identifyTypes,
                    player_adjustIdentifiers: () => player_adjustIdentifiers,
                    player_getPlayFromTime: () => player_getPlayFromTime,
                    sanitizeToIntFromPointTime: () => sanitizeToIntFromPointTime,
                    player_initSpectrum: () => player_initSpectrum,
                    player_initSpectrumOnUserAction: () => player_initSpectrumOnUserAction,
                    player_icecastOrShoutcastRefresh: () => player_icecastOrShoutcastRefresh,
                    player_determineStickToBottomContainer: () => player_determineStickToBottomContainer,
                    player_stickToBottomContainerDetermineClasses: () => player_stickToBottomContainerDetermineClasses,
                    player_service_getSourceProtection: () => player_service_getSourceProtection,
                    player_isGoingToSetupMediaNow: () => player_isGoingToSetupMediaNow,
                    player_determineHtmlAreas: () => player_determineHtmlAreas,
                    player_stopOtherPlayers: () => player_stopOtherPlayers,
                    player_syncPlayers_gotoItem: () => player_syncPlayers_gotoItem,
                    player_syncPlayers_buildList: () => player_syncPlayers_buildList,
                    player_detect_skinwave_mode: () => player_detect_skinwave_mode,
                    player_constructArtistAndSongCon: () => player_constructArtistAndSongCon,
                    convertPluginOptionsToFinalOptions: () => convertPluginOptionsToFinalOptions,
                    generateFakeArrayForPcm: () => generateFakeArrayForPcm,
                    scrubbar_modeWave_clearObsoleteCanvas: () => scrubbar_modeWave_clearObsoleteCanvas,
                    scrubbar_modeWave_setupCanvas: () => scrubbar_modeWave_setupCanvas
                });
                const dzsapSvgs = __webpack_require__(560),
                    dzsHelpers = __webpack_require__(401),
                    dzsap_generate_keyboard_controls = function() {
                        var e = {
                            play_trigger_step_back: "off",
                            step_back_amount: "5",
                            step_back: "37",
                            step_forward: "39",
                            sync_players_goto_next: "",
                            sync_players_goto_prev: "",
                            pause_play: "32",
                            show_tooltips: "off"
                        };
                        return window.dzsap_keyboard_controls && (e = jQuery.extend(e, window.dzsap_keyboard_controls)), e.step_back_amount = Number(e.step_back_amount), e
                    };

                function formatTime(e) {
                    var a = Math.round(e),
                        t = 0,
                        i = 0;
                    if (a > 0) {
                        for (; a > 3599 && a < 3e6 && isFinite(a);) i++, a -= 3600;
                        for (; a > 59 && a < 3e6 && isFinite(a);) t++, a -= 60;
                        return String(i ? (i < 10 ? "0" : "") + i + ":" + String((t < 10 ? "0" : "") + t + ":" + (a < 10 ? "0" : "") + a) : (t < 10 ? "0" : "") + t + ":" + (a < 10 ? "0" : "") + a)
                    }
                    return "00:00"
                }

                function can_history_api() {
                    return !(!window.history || !history.pushState)
                }

                function dzs_clean_string(e) {
                    return e ? e = (e = e.replace(/[^A-Za-z0-9\-]/g, "")).replace(/\./g, "") : ""
                }

                function get_query_arg(e, a) {
                    if (e) {
                        if (String(e).indexOf(a + "=") > -1) {
                            var t = new RegExp("[?&]" + a + "=.+").exec(e);
                            if (null != t) {
                                var i = t[0];
                                if (i.indexOf("&") > -1) {
                                    var s = i.split("&");
                                    i = s[1]
                                }
                                return i.split("=")[1]
                            }
                        }
                    } else console.log("purl not found - ", e)
                }

                function add_query_arg(e, a, t) {
                    e || (e = "");
                    var i = e,
                        s = (a = encodeURIComponent(a)) + "=" + (t = encodeURIComponent(t)),
                        n = new RegExp("(&|\\?)" + a + "=[^&]*");
                    if ((i = i.replace(n, "$1" + s)).indexOf(a + "=") > -1 || (i.indexOf("?") > -1 ? i += "&" + s : i += "?" + s), "NaN" === t) {
                        var o = new RegExp("[?|&]" + a + "=" + t); - 1 === (i = i.replace(o, "")).indexOf("?") && i.indexOf("&") > -1 && (i = i.replace("&", "?"))
                    }
                    return i
                }

                function dzsap_is_mobile() {
                    return is_ios() || is_android_good()
                }

                function is_ie() {
                    return !!window.MSInputMethodContext && !!document.documentMode
                }

                function is_ios() {
                    return -1 !== navigator.platform.indexOf("iPhone") || -1 !== navigator.platform.indexOf("iPod") || -1 !== navigator.platform.indexOf("iPad")
                }

                function can_canvas() {
                    return !!document.createElement("canvas").getContext("2d")
                }

                function is_safari() {
                    return Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor") > 0
                }

                function is_android() {
                    return is_android_good()
                }

                function select_all(e) {
                    if (void 0 !== window.getSelection && void 0 !== document.createRange) {
                        var a = document.createRange();
                        a.selectNodeContents(e);
                        var t = window.getSelection();
                        t.removeAllRanges(), t.addRange(a)
                    } else if (void 0 !== document.selection && void 0 !== document.body.createTextRange) {
                        var i = document.body.createTextRange();
                        i.moveToElementText(e), i.select()
                    }
                }

                function is_android_good() {
                    return navigator.userAgent.toLowerCase().indexOf("android") > -1
                }

                function htmlEncode(e) {
                    return jQuery("<div/>").text(e).html()
                }

                function dzsap_generate_keyboard_tooltip(e, a) {
                    var t = '<span class="dzstooltip color-dark-light talign-start transition-slidein arrow-bottom style-default" style="width: auto;  white-space:nowrap;"><span class="dzstooltip--inner">Shortcut: ' + e[a] + "</span></span>";
                    return (t = t.replace("32", "space")).replace("27", "escape")
                }

                function handle_keypresses(e) {
                    function a(a) {
                        let t = !1;
                        return a.indexOf("ctrl+") > -1 ? e.ctrlKey && (a = a.replace("ctrl+", ""), e.keyCode === Number(a) && (t = !0)) : e.keyCode === Number(a) && (t = !0), t
                    }
                    var t = jQuery,
                        i = t.extend({}, dzsap_generate_keyboard_controls());
                    if (dzsap_currplayer_focused && dzsap_currplayer_focused.api_pause_media) {
                        if (a(i.pause_play) && !1 === t(dzsap_currplayer_focused).hasClass("comments-writer-active") && (t(dzsap_currplayer_focused).hasClass("is-playing") ? dzsap_currplayer_focused.api_pause_media() : dzsap_currplayer_focused.api_play_media(), window.dzsap_mouseover)) return e.preventDefault(), !1;
                        a(i.step_back) && dzsap_currplayer_focused.api_step_back(i.step_back_amount), a(i.step_forward) && dzsap_currplayer_focused.api_step_forward(i.step_back_amount), a(i.sync_players_goto_next) && dzsap_currplayer_focused && dzsap_currplayer_focused.api_sync_players_goto_next && dzsap_currplayer_focused.api_sync_players_goto_next(), a(i.sync_players_goto_prev) && dzsap_currplayer_focused && dzsap_currplayer_focused.api_sync_players_goto_prev && dzsap_currplayer_focused.api_sync_players_goto_prev()
                    }
                }

                function hexToRgb(e, a) {
                    var t = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e),
                        i = "";
                    if (t) {
                        var s = 1;
                        a && (s = a), i = "rgba(" + (t = {
                            r: parseInt(t[1], 16),
                            g: parseInt(t[2], 16),
                            b: parseInt(t[3], 16)
                        }).r + "," + t.g + "," + t.b + "," + s + ")"
                    }
                    return i
                }

                function assignHelperFunctionsToJquery(e) {
                    e.fn.prependOnce = function(a, t) {
                        var i = e(this);
                        if (void 0 === t) {
                            var s = new RegExp('class="(.*?)"').exec(a);
                            void 0 !== s[1] && (t = "." + s[1])
                        }
                        return i.children(t).length < 1 && (i.prepend(a), !0)
                    }, e.fn.appendOnce = function(a, t) {
                        var i = e(this);
                        if (void 0 === t) {
                            var s = new RegExp('class="(.*?)"').exec(a);
                            void 0 !== s[1] && (t = "." + s[1])
                        }
                        return i.children(t).length < 1 && (i.append(a), !0)
                    }
                }

                function registerTextWidth(e) {
                    e.fn.textWidth = function() {
                        var e = jQuery(this),
                            a = e.html();
                        "INPUT" === e[0].nodeName && (a = e.val());
                        var t = '<span class="forcalc">' + a + "</span>";
                        jQuery("body").append(t);
                        var i = jQuery("span.forcalc").last();
                        i.css({
                            "font-size": e.css("font-size"),
                            "font-family": e.css("font-family")
                        });
                        var s = i.width();
                        return i.remove(), s
                    }
                }

                function player_checkIfWeShouldShowAComment(e, a, t) {
                    var i = jQuery,
                        s = Math.round(a / t * 100) / 100;
                    "fake" === e.audioType && (s = Math.round(e.timeCurrent / e.timeTotal * 100) / 100), e._commentsHolder && e._commentsHolder.children().each((function() {
                        var a = i(this);
                        if (a.hasClass("dzstooltip-con")) {
                            var t = a.offset().left - e._commentsHolder.offset().left,
                                n = Math.round(parseFloat(t) / e._commentsHolder.outerWidth() * 100) / 100;
                            n && (Math.abs(n - s) < .02 ? (e._commentsHolder.find(".dzstooltip").removeClass("active"), a.find(".dzstooltip").addClass("active")) : a.find(".dzstooltip").removeClass("active"))
                        }
                    }))
                }

                function sanitizeObjectForChangeMediaArgs(e) {
                    var a = {},
                        t = e,
                        i = "";
                    return e.data("original-settings") ? e.data("original-settings") : (a.source = null, t.attr("data-source") ? a.source = t.attr("data-source") : t.attr("href") && (a.source = t.attr("href")), t.attr("data-pcm") && (a.pcm = t.attr("data-pcm")), i = "thumb", t.attr("data-" + i) && (a[i] = e.attr("data-" + i)), i = "playerid", t.attr("data-" + i) && (a[i] = e.attr("data-" + i)), i = "type", t.attr("data-" + i) && (a[i] = e.attr("data-" + i)), t.attr("data-thumb_link") && (a.thumb_link = e.attr("data-thumb_link")), (e.find(".meta-artist").length > 0 || e.find(".meta-artist-con").length > 0) && (a.artist = e.find(".the-artist").eq(0).html(), a.song_name = e.find(".the-name").eq(0).html()), e.attr("data-thumb_for_parent") && (a.thumb = e.attr("data-thumb_for_parent")), (e.find(".feed-song-name").length > 0 || e.find(".feed-artist-name").length > 0) && (a.artist = e.find(".feed-artist-name").eq(0).html(), a.song_name = e.find(".feed-song-name").eq(0).html()), a)
                }

                function utils_sanitizeToColor(e) {
                    return -1 === e.indexOf("#") && -1 === e.indexOf("rgb") && -1 === e.indexOf("hsl") ? "#" + e : e
                }

                function dzsapInitjQueryRegisters() {
                    window.dzsap_generate_list_for_sync_players = function(e) {
                        var a = jQuery,
                            t = {
                                force_regenerate: !1
                            };
                        e && (t = a.extend(t, e)), window.dzsap_syncList_players = [], ("on" === window.dzsap_settings.syncPlayers_buildList || t.force_regenerate) && jQuery(".audioplayer,.audioplayer-tobe").each((function() {
                            var e = jQuery(this);
                            "on" !== e.attr("data-do-not-include-in-list") && ("fake" !== e.attr("data-type") || e.attr("data-fakeplayer")) && window.dzsap_syncList_players.push(e)
                        }))
                    }, jQuery(document).off("click.dzsap_global"), jQuery(document).on("click.dzsap_global", ".dzsap-btn-info", (function() {
                        var e = jQuery(this);
                        e.hasClass("dzsap-btn-info") && e.find(".dzstooltip").toggleClass("active")
                    })), jQuery(document).on("mouseover.dzsap_global", ".dzsap-btn-info", (function() {
                        var e = jQuery(this);
                        e.hasClass("dzsap-btn-info") && (window.innerWidth < 500 ? e.offset().left < window.innerWidth / 2 && e.find(".dzstooltip").removeClass("talign-end").addClass("talign-start") : e.find(".dzstooltip").addClass("talign-end").removeClass("talign-start"))
                    }))
                }

                function player_radio_isNameUpdatable(e, a, t) {
                    return !!(e._metaArtistCon.find(t).length && e._metaArtistCon.find(t).eq(0).text().length > 0 && e._metaArtistCon.find(t).eq(0).html().indexOf("{{update}}") > -1)
                }

                function playerRegisterWindowFunctions() {
                    window.dzsap_send_total_time = function(e, a) {
                        if (e && e !== 1 / 0) {
                            var t = {
                                action: "dzsap_send_total_time_for_track",
                                id_track: a.attr("data-playerid"),
                                postdata: Math.ceil(e)
                            };
                            jQuery.post(window.dzsap_ajaxurl, t, (function(e) {}))
                        }
                    }, window.dzs_open_social_link = function(e, a) {
                        var t, i, s = "status=no,height=500,width=500,resizable=yes,left=" + (t = window.screen.width / 2 - 260) + ",top=" + (i = window.screen.height / 2 - 300) + ",screenX=" + t + ",screenY=" + i + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
                        e = e.replace("{{replacewithcurrurl}}", encodeURIComponent(window.location.href)), a && a.attr && (e = e.replace(/{{replacewithdataurl}}/g, a.attr("data-url")));
                        var n = window.location.href.split("?"),
                            o = "",
                            r = "";
                        if (a || window.dzsap_currplayer_from_share && (a = window.dzsap_currplayer_from_share), a) {
                            var l = jQuery;
                            l(a).hasClass("audioplayer") ? (o = l(a).parent().children().index(a), r = l(a).parent().parent().parent().attr("id")) : (jQuery(a).parent().parent().attr("data-menu-index") && (o = jQuery(a).parent().parent().attr("data-menu-index")), jQuery(a).parent().parent().attr("data-gallery-id") && (r = jQuery(a).parent().parent().attr("data-gallery-id")))
                        }
                        var d = encodeURIComponent(n[0] + "?fromsharer=on&audiogallery_startitem_" + r + "=" + o);
                        e = e.replace("{{shareurl}}", d), window.open(e, "sharer", s)
                    }, window.dzsap_wp_send_contor_60_secs = function(e, a) {
                        var t = {
                                video_title: a,
                                video_analytics_id: e.attr("data-playerid"),
                                curr_user: window.dzsap_curr_user
                            },
                            i = "index.php?action=ajax_dzsap_submit_contor_60_secs";
                        window.dzsap_settings.dzsap_site_url && (i = dzsap_settings.dzsap_site_url + i), jQuery.ajax({
                            type: "POST",
                            url: i,
                            data: t,
                            success: function(e) {
                                window.console
                            },
                            error: function(e) {
                                window.console
                            }
                        })
                    }, window.dzsap_init_multisharer = function() {}, window.dzsap_submit_like = function(e, a) {
                        var t = {
                                action: "dzsap_submit_like",
                                playerid: e
                            },
                            i = null;
                        a && (i = jQuery(a.currentTarget)), window.dzsap_settings && window.dzsap_settings.ajax_url && jQuery.ajax({
                            type: "POST",
                            url: window.dzsap_settings.ajax_url,
                            data: t,
                            success: function(e) {
                                if (void 0 !== window.console && console.log("Got this from the server: " + e), i) {
                                    var a = i.html();
                                    i.html(a.replace("fa-heart-o", "fa-heart"))
                                }
                            },
                            error: function(e) {
                                window.console
                            }
                        })
                    }, window.dzsap_retract_like = function(e, a) {
                        var t = {
                                action: "dzsap_retract_like",
                                playerid: e
                            },
                            i = null;
                        a && (i = jQuery(a.currentTarget)), window.dzsap_settings && window.dzsap_settings.ajax_url && jQuery.ajax({
                            type: "POST",
                            url: window.dzsap_settings.ajax_url,
                            data: t,
                            success: function(e) {
                                if (void 0 !== window.console && console.log("Got this from the server: " + e), i) {
                                    var a = i.html();
                                    i.html(a.replace("fa-heart", "fa-heart-o"))
                                }
                            },
                            error: function(e) {
                                window.console
                            }
                        })
                    }
                }

                function dzsap_singleton_ready_calls() {
                    window.dzsap_singleton_ready_calls_is_called = !0, jQuery("body").append('<style class="dzsap--style"></style>'), window.dzsap__style = jQuery(".dzsap--style"), jQuery("audio.zoomsounds-from-audio").each((function() {
                        var e = jQuery(this);
                        e.after('<div class="audioplayer-tobe auto-init skin-silver" data-source="' + e.attr("src") + '"></div>'), e.remove()
                    })), jQuery(document).on("focus.dzsap", "input", (function() {
                        window.dzsap_currplayer_focused = null
                    })), registerTextWidth(jQuery)
                }

                function jQueryAuxBindings(e) {
                    e(document).off("click.dzsap_metas"), e(document).on("click.dzsap_metas", ".audioplayer-song-changer, .dzsap-wishlist-but", (function(a) {
                        var t = e(this);
                        if (console.log("$t - ", t), a.preventDefault(), a.stopPropagation(), a.stopImmediatePropagation(), t.hasClass("dzsap-syncPlayers-autoplay-toggler"), t.hasClass("audioplayer-song-changer")) {
                            var i = e(t.attr("data-fakeplayer")).eq(0);
                            return i && i.get(0) && i.get(0).api_change_media && i.get(0).api_change_media(t, {
                                feeder_type: "button",
                                call_from: "changed audioplayer-song-changer"
                            }), !1
                        }
                        if (t.hasClass("dzsap-wishlist-but")) {
                            var s = {
                                action: "dzsap_add_to_wishlist",
                                playerid: t.attr("data-post_id"),
                                wishlist_action: "add"
                            };
                            return t.find(".svg-icon").hasClass("fa-star") && (s.wishlist_action = "remove"), window.dzsap_lasto.settings_php_handler && e.ajax({
                                type: "POST",
                                url: window.dzsap_lasto.settings_php_handler,
                                data: s,
                                success: function(e) {
                                    t.find(".svg-icon").hasClass("fa-star-o") ? t.find(".svg-icon").eq(0).attr("class", "svg-icon fa fa-star") : t.find(".svg-icon").eq(0).attr("class", "svg-icon fa fa-star-o")
                                },
                                error: function(e) {
                                    window.console
                                }
                            }), !1
                        }
                    })), e(".dzsap-sticktobottom.dzsap-sticktobottom-for-skin-silver").length > 0 && setInterval((function() {
                        e(".dzsap-sticktobottom.dzsap-sticktobottom-for-skin-silver  .audioplayer").eq(0).hasClass("dzsap-loaded") && (e(".dzsap-sticktobottom-placeholder").eq(0).addClass("active"), !1 === e(".dzsap-sticktobottom").hasClass("audioplayer-was-loaded") && e(".dzsap-sticktobottom.dzsap-sticktobottom-for-skin-silver").addClass("audioplayer-loaded"))
                    }), 1e3), e(".dzsap-sticktobottom.dzsap-sticktobottom-for-skin-wave").length > 0 && setInterval((function() {
                        e(".dzsap-sticktobottom.dzsap-sticktobottom-for-skin-wave  .audioplayer").eq(0).hasClass("dzsap-loaded") && (e(".dzsap-sticktobottom-placeholder").eq(0).addClass("active"), !1 === e(".dzsap-sticktobottom").hasClass("audioplayer-was-loaded") && e(".dzsap-sticktobottom.dzsap-sticktobottom-for-skin-wave").addClass("audioplayer-loaded"))
                    }), 1e3), e(document).on("keydown.dzsapkeyup keypress.dzsapkeyup", (function(e) {
                        handle_keypresses(e)
                    })), e(document).on("keydown blur", ".zoomsounds-search-field", (function(a) {
                        var t = e(a.currentTarget);
                        setTimeout((function() {
                            if (t) {
                                var a = e(".audiogallery").eq(0);
                                t.attr("data-target") && (a = e(t.attr("data-target"))), a.get(0) && a.get(0).api_filter && a.get(0).api_filter("title", t.val())
                            }
                        }), 100)
                    })), e(document).on("click", ".dzsap-like-but", (function(a) {
                        var t = e(this),
                            i = t.attr("data-post_id");
                        return i && "0" != i || t.parent().parent().parent().parent().parent().hasClass("audioplayer") && (i = t.parent().parent().parent().parent().parent().attr("data-feed-playerid")), window.dzsap_submit_like(i, a), t.removeClass("dzsap-like-but").addClass("dzsap-retract-like-but"), !1
                    })), e(document).on("click", ".dzsap-retract-like-but", (function(a) {
                        var t = e(this),
                            i = t.attr("data-post_id");
                        return i && "0" != i || t.parent().parent().parent().parent().parent().hasClass("audioplayer") && (i = t.parent().parent().parent().parent().parent().attr("data-feed-playerid")), window.dzsap_retract_like(i, a), t.addClass("dzsap-like-but").removeClass("dzsap-retract-like-but"), !1
                    }))
                }

                function selectText(e) {
                    if (document.selection)(a = document.body.createTextRange()).moveToElementText(e), a.select();
                    else if (window.getSelection) {
                        var a;
                        (a = document.createRange()).selectNode(e), window.getSelection().removeAllRanges(), window.getSelection().addRange(a)
                    }
                }

                function view_player_playMiscEffects(e) {
                    e.$conPlayPause.addClass("playing"), e.cthis.parent().hasClass("zoomsounds-wrapper-bg-center") && e.cthis.parent().addClass("is-playing")
                }

                function view_player_globalDetermineSyncPlayersIndex(e) {
                    null === e._sourcePlayer && window.dzsap_syncList_players && window.dzsap_syncList_players.forEach(((a, t) => {
                        e.cthis.attr("data-playerid") == a.attr("data-playerid") && (window.dzsap_syncList_index = t)
                    }))
                }

                function player_view_addMetaLoaded(e) {
                    e.cthis.addClass("meta-loaded"), e.cthis.removeClass("meta-fake"), e._sourcePlayer && (e._sourcePlayer.addClass("meta-loaded"), e._sourcePlayer.removeClass("meta-fake")), e.$totalTime && (e.timeModel.refreshTimes(), e.$totalTime.html(formatTime(e.timeModel.getVisualTotalTime()))), e._sourcePlayer && e._sourcePlayer.addClass("meta-loaded")
                }

                function player_determineActualPlayer(e) {
                    var a = jQuery,
                        t = a(e.cthis.attr("data-fakeplayer"));
                    0 === t.length && (t = a(String(e.cthis.attr("data-fakeplayer")).replace("#", "."))).length && (e._actualPlayer = a(String(e.cthis.attr("data-fakeplayer")).replace("#", ".")), e.cthis.attr("data-fakeplayer", String(e.cthis.attr("data-fakeplayer")).replace("#", "."))), 0 === t.length ? e.cthis.attr("data-fakeplayer", "") : (e.cthis.addClass("player-is-feeding is-source-player-for-actual-player"), e.cthis.attr("data-type") && (e._actualPlayer = a(e.cthis.attr("data-fakeplayer")).eq(0), e.actualDataTypeOfMedia = e.cthis.attr("data-type"), e.cthis.attr("data-original-type", e.actualDataTypeOfMedia)))
                }

                function htmlEntities(e) {
                    return String(e).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                }

                function waitForScriptToBeAvailableThenExecute(e, a) {
                    new Promise(((a, t) => {
                        var i = 0;

                        function s() {
                            e && (clearInterval(i), a("var exists"))
                        }
                        s(), i = setInterval(s, 300), setTimeout((() => {
                            t("timeout")
                        }), 5e3)
                    })).then((e => {
                        a(e)
                    })).catch((e => {}))
                }

                function configureAudioPlayerOptionsInitial(e, a, t) {
                    t.cthis.addClass("preload-method-" + a.preload_method), a.wavesurfer_pcm_length = Number(a.wavesurfer_pcm_length), a.settings_trigger_resize = parseInt(a.settings_trigger_resize, 10), !1 === isNaN(parseInt(a.design_thumbh, 10)) && (a.design_thumbh = parseInt(a.design_thumbh, 10)), "" === a.skinwave_wave_mode && (a.skinwave_wave_mode = "canvas"), "" === a.skinwave_wave_mode_canvas_normalize && (a.skinwave_wave_mode_canvas_normalize = "on"), ("" === a.skinwave_wave_mode_canvas_waves_number || isNaN(Number(a.skinwave_wave_mode_canvas_waves_number))) && (a.skinwave_wave_mode_canvas_waves_number = 3), "on" === a.autoplay && "on" === a.cue && (a.preload_method = "auto"), e.addClass(a.extra_classes_player), "" === a.design_skin && (a.design_skin = "skin-default"), t.cthis.find(".feed-dzsap--embed-code").length ? t.feedEmbedCode = t.cthis.find(".feed-dzsap--embed-code").eq(0).html() : "" !== a.embed_code && (t.feedEmbedCode = a.embed_code), this.is_ios() && "on" === t.initOptions.skinwave_enableSpectrum && (t.initOptions.skinwave_enableSpectrum = "off"), / skin-/g.test(e.attr("class")) || e.addClass(a.design_skin), e.hasClass("skin-default") && (a.design_skin = "skin-default"), e.hasClass("skin-wave") && (a.design_skin = "skin-wave"), e.hasClass("skin-justthumbandbutton") && (a.design_skin = "skin-justthumbandbutton"), e.hasClass("skin-pro") && (a.design_skin = "skin-pro"), e.hasClass("skin-aria") && (a.design_skin = "skin-aria"), e.hasClass("skin-silver") && (a.design_skin = "skin-silver"), e.hasClass("skin-redlights") && (a.design_skin = "skin-redlights"), e.hasClass("skin-steel") && (a.design_skin = "skin-steel"), e.hasClass("skin-customcontrols") && (a.design_skin = "skin-customcontrols"), "skin-wave" === a.design_skin && "auto" === a.scrubbar_type && (a.scrubbar_type = "wave"), "auto" === a.scrubbar_type && (a.scrubbar_type = "bar"), "wpdefault" === a.settings_php_handler && (a.settings_php_handler = window.ajaxurl), "wpdefault" === a.action_received_time_total && (a.action_received_time_total = window.dzsap_send_total_time), "wpdefault" === a.action_video_contor_60secs && (a.action_video_contor_60secs = window.action_video_contor_60secs), (is_ios() || is_android()) && (a.autoplay = "off", a.disable_volume = "on", "off" === a.cueMedia && (a.cueMedia = "on"), a.cueMedia = "on"), "on" === e.attr("data-viewsubmitted") && (t.ajax_view_submitted = "on"), e.attr("data-userstarrating") && (t.starrating_alreadyrated = Number(e.attr("data-userstarrating"))), e.hasClass("skin-minimal") && (a.design_skin = "skin-minimal", "default" === a.disable_volume && (a.disable_volume = "on"), "default" === a.disable_scrub && (a.disable_scrub = "on"), a.disable_timer = "on"), e.hasClass("skin-minion") && (a.design_skin = "skin-minion", "default" === a.disable_volume && (a.disable_volume = "on"), "default" === a.disable_scrub && (a.disable_scrub = "on"), a.disable_timer = "on"), a.design_color_bg && (a.design_wave_color_bg = a.design_color_bg), a.design_color_highlight && (a.design_wave_color_progress = a.design_color_highlight), "skin-justthumbandbutton" === a.design_skin && ("default" === a.design_thumbh && (a.design_thumbh = ""), a.disable_timer = "on", a.disable_volume = "on", "default" === a.design_animateplaypause && (a.design_animateplaypause = "on")), "skin-redlights" === a.design_skin && (a.disable_timer = "on", a.disable_volume = "off", "default" === a.design_animateplaypause && (a.design_animateplaypause = "on")), "skin-steel" === a.design_skin && ("default" === a.disable_timer && (a.disable_timer = "off"), a.disable_volume = "on", "default" === a.design_animateplaypause && (a.design_animateplaypause = "on"), "default" === a.disable_scrub && (a.disable_scrub = "on")), "skin-customcontrols" === a.design_skin && ("default" === a.disable_timer && (a.disable_timer = "on"), a.disable_volume = "on", "default" === a.design_animateplaypause && (a.design_animateplaypause = "on"), "default" === a.disable_scrub && (a.disable_scrub = "on")), "reflecto" === a.skinwave_wave_mode_canvas_mode && (a.skinwave_wave_mode_canvas_reflection_size = .5), "reflecto" === a.skinwave_wave_mode_canvas_mode && (a.skinwave_wave_mode_canvas_reflection_size = .5), "" === a.embed_code && e.find("div.feed-embed-code").length > 0 && (a.embed_code = e.find("div.feed-embed-code").eq(0).html()), "default" === a.design_animateplaypause && (a.design_animateplaypause = "off"), "on" === a.design_animateplaypause && e.addClass("design-animateplaypause"), window.dzsap_settings && window.dzsap_settings.php_handler && (a.settings_php_handler || (a.settings_php_handler = window.dzsap_settings.php_handler)), a.settings_php_handler && (t.urlToAjaxHandler = a.settings_php_handler), player_reinit_findIfPcmNeedsGenerating(t)
                }

                function player_reinit_findIfPcmNeedsGenerating(e) {
                    const a = e.initOptions;
                    e.cthis.attr("data-pcm") && (e.hasInitialPcmData = !0), e.hasInitialPcmData || "canvas" !== a.skinwave_wave_mode || "skin-wave" !== a.design_skin && !e.cthis.attr("data-fakeplayer") || (e.isPcmRequiredToGenerate = !0)
                }

                function playerFunctions(e, a) {
                    var t = e.initOptions;
                    "detectIds" === a && ("" === t.skinwave_comments_playerid && void 0 !== e.cthis.attr("id") && (e.the_player_id = e.cthis.attr("id")), "" == e.the_player_id && (e.cthis.attr("data-computed-playerid") && (e.the_player_id = e.cthis.attr("data-computed-playerid")), e.cthis.attr("data-real-playerid") && (e.the_player_id = e.cthis.attr("data-real-playerid"))), e.uniqueId = e.the_player_id, e.identifier_pcm = e.uniqueId, "" === e.the_player_id && (t.skinwave_comments_enable = "off"))
                }

                function player_delete(e) {
                    var a = null;
                    return e.cthis.parent().parent().hasClass("dzsap-sticktobottom") && (a = e.cthis.parent().parent()), a && (a.prev().hasClass("dzsap-sticktobottom-placeholder") && a.prev().remove(), a.remove()), e.cthis.remove(), !1
                }

                function player_viewApplySkinWaveModes(e) {
                    var a = e.initOptions;
                    e.cthis.removeClass("skin-wave-mode-normal"), "skin-wave" === a.design_skin && (e.cthis.addClass("skin-wave-mode-" + e.skinwave_mode), e.cthis.addClass("skin-wave-wave-mode-" + a.skinwave_wave_mode), "on" === a.skinwave_enableSpectrum && e.cthis.addClass("skin-wave-is-spectrum"), e.cthis.addClass("skin-wave-wave-mode-canvas-mode-" + a.skinwave_wave_mode_canvas_mode))
                }

                function sanitizeToHexColor(e) {
                    return -1 === e.indexOf("#") && (e = "#" + e), e
                }

                function player_identifySource(e) {
                    e.data_source = e.cthis.attr("data-source") || ""
                }

                function player_identifyTypes(e) {
                    var a = e.initOptions;
                    const t = e.cthis;
                    "youtube" === t.attr("data-type") && (a.type = "youtube", e.audioType = "youtube"), "soundcloud" === t.attr("data-type") && (a.type = "soundcloud", e.audioType = "soundcloud", a.skinwave_enableSpectrum = "off", t.removeClass("skin-wave-is-spectrum")), "mediafile" === t.attr("data-type") && (a.type = "audio", e.audioType = "audio"), "shoutcast" === t.attr("data-type") && (a.type = "shoutcast", e.audioType = "audio", a.disable_timer = "on", a.skinwave_enableSpectrum = "off", "skin-default" === a.design_skin && (a.disable_scrub = "on")), "audio" !== e.audioType && "normal" !== e.audioType && "" !== e.audioType || (e.audioType = "selfHosted"), String(e.data_source).indexOf("https://soundcloud.com/") > -1 && (e.audioType = "soundcloud")
                }

                function player_adjustIdentifiers(e) {
                    e.identifier_pcm = e.the_player_id;
                    var a = null;
                    a = e.$feed_fakeButton ? e.$feed_fakeButton : e._sourcePlayer ? e._sourcePlayer : null, "dzs_footer" === e.identifier_pcm && (e.identifier_pcm = dzs_clean_string(e.cthis.attr("data-source"))), a && (a.attr("data-playerid") ? e.identifier_pcm = a.attr("data-playerid") : a.attr("data-source") && (e.identifier_pcm = a.attr("data-source")))
                }

                function player_getPlayFromTime(e) {
                    e.playFrom = e.initOptions.playfrom, dzsHelpers.isValid(e.cthis.attr("data-playfrom")) && (e.playFrom = e.cthis.attr("data-playfrom")), !1 === isNaN(parseInt(e.playFrom, 10)) && (e.playFrom = parseInt(e.playFrom, 10)), "off" !== e.playFrom && "" !== e.playFrom || this.get_query_arg(window.location.href, "audio_time") && (e.playFrom = this.sanitizeToIntFromPointTime(this.get_query_arg(window.location.href, "audio_time"))), e.timeModel.sampleTimeStart && (e.playFrom < e.timeModel.sampleTimeStart && (e.playFrom = e.timeModel.sampleTimeStart), "string" == typeof e.playFrom && (e.playFrom = e.timeModel.sampleTimeStart))
                }

                function sanitizeToIntFromPointTime(e) {
                    if (e = String(e).replace("%3A", ":"), (e = String(e).replace("#", "")) && String(e).indexOf(":") > -1) {
                        var a = /(\d.*):(\d.*)/g.exec(e);
                        return 60 * parseInt(a[1], 10) + parseInt(a[2], 10)
                    }
                    return Number(e)
                }

                function player_initSpectrum(e) {
                    if (null === window.dzsap_audio_ctx ? ("undefined" != typeof AudioContext ? e.spectrum_audioContext = new AudioContext : "undefined" != typeof webkitAudioContext ? e.spectrum_audioContext = new webkitAudioContext : e.spectrum_audioContext = null, window.dzsap_audio_ctx = e.spectrum_audioContext) : e.spectrum_audioContext = window.dzsap_audio_ctx, console.log("selfClass.spectrum_audioContext - ", e.spectrum_audioContext), e.spectrum_audioContext && null === e.spectrum_analyser && (e.spectrum_analyser = e.spectrum_audioContext.createAnalyser(), e.spectrum_analyser.smoothingTimeConstant = .3, e.spectrum_analyser.fftSize = 512, console.log("selfClass.spectrum_analyser - ", e.spectrum_analyser), "selfHosted" === e.audioType)) {
                        e.$mediaNode_.crossOrigin = "anonymous", e.spectrum_mediaElementSource = e.spectrum_audioContext.createMediaElementSource(e.$mediaNode_), e.spectrum_mediaElementSource.connect(e.spectrum_analyser), e.spectrum_audioContext.createGain && (e.spectrum_gainNode = e.spectrum_audioContext.createGain()), e.spectrum_analyser.connect(e.spectrum_audioContext.destination), e.spectrum_gainNode.gain.value = 1;
                        var a = 2 * e.spectrum_audioContext.sampleRate;
                        e.spectrum_audioContext_buffer = e.spectrum_audioContext.createBuffer(2, a, e.spectrum_audioContext.sampleRate)
                    }
                }

                function player_initSpectrumOnUserAction(e) {
                    function a(a) {
                        console.log("setting up audio context --", a), player_initSpectrum(e)
                    }
                    e.cthis.get(0).addEventListener("mousedown", a, {
                        once: !0
                    }), e.cthis.get(0).addEventListener("touchdown", a, {
                        once: !0
                    })
                }

                function player_icecastOrShoutcastRefresh(e) {
                    var a = e.cthis.attr("data-source");
                    "shoutcast" === e.audioTypeSelfHosted_streamType && (a = add_query_arg(e.urlToAjaxHandler, "action", "dzsap_shoutcast_get_streamtitle"), a = add_query_arg(a, "source", e.data_source)), jQuery.ajax({
                        type: "GET",
                        url: a,
                        crossDomain: !0,
                        success: function(a) {
                            a.documentElement && a.documentElement.innerHTML && (a = a.documentElement.innerHTML);
                            var t = "",
                                i = "";
                            if ("icecast" === e.audioTypeSelfHosted_streamType) {
                                var s = null;
                                (s = /<location>(.*?)<\/location>/g.exec(a)) && s[1] !== e.data_source && (e.data_source = s[1], e.setup_media({
                                    called_from: "icecast setup"
                                }))
                            }
                            e.radio_isGoingToUpdateSongName && ("icecast" === e.audioTypeSelfHosted_streamType && (s = /<title>(.*?)<\/title>/g.exec(a)) && (t = s[1]), "shoutcast" === e.audioTypeSelfHosted_streamType && (t = a)), e.radio_isGoingToUpdateArtistName && ("icecast" === e.audioTypeSelfHosted_streamType && (s = /<creator>(.*?)<\/creator>/g.exec(a)) && (i = s[1]), e.audioTypeSelfHosted_streamType), e.radio_isGoingToUpdateSongName && e._metaArtistCon.find(".the-name").html(t), e.radio_isGoingToUpdateArtistName && e._metaArtistCon.find(".the-artist").html(i)
                        },
                        error: function(e) {
                            console.log("error loading icecast - ", e)
                        }
                    })
                }

                function player_determineStickToBottomContainer(e) {
                    e.cthis.parent().hasClass("dzsap-sticktobottom") && (e.$stickToBottomContainer = e.cthis.parent()), e.cthis.parent().parent().hasClass("dzsap-sticktobottom") && (e.$stickToBottomContainer = e.cthis.parent().parent())
                }

                function player_stickToBottomContainerDetermineClasses(e) {
                    if (e.$stickToBottomContainer) {
                        e.cthis.hasClass("theme-dark") && e.$stickToBottomContainer.addClass("theme-dark"), setTimeout((function() {
                            e.$stickToBottomContainer.addClass("inited")
                        }), 500), e.$stickToBottomContainer.addClass("dzsap-sticktobottom-for-" + e.initOptions.design_skin), e.$stickToBottomContainer.prev().addClass("dzsap-sticktobottom-for-" + e.initOptions.design_skin), "skin-wave" === e.initOptions.design_skin && (e.$stickToBottomContainer.addClass("dzsap-sticktobottom-for-" + e.initOptions.design_skin + "--mode-" + e.skinwave_mode), e.$stickToBottomContainer.prev().addClass("dzsap-sticktobottom-for-" + e.initOptions.design_skin + "--mode-" + e.skinwave_mode));
                        var a = /(skinvariation-.*?)($| )/g.exec(e.cthis.attr("class"));
                        a && a[1] && (e.$stickToBottomContainer.addClass(a[1]), e.$stickToBottomContainer.prev().addClass(a[1]))
                    }
                }

                function player_service_getSourceProtection(e) {
                    return new Promise(((a, t) => {
                        jQuery.ajax({
                            type: "POST",
                            url: e.data_source,
                            data: {},
                            success: function(e) {
                                a(e)
                            },
                            error: function(e) {
                                t(e)
                            }
                        })
                    }))
                }

                function player_isGoingToSetupMediaNow(e) {
                    return "icecast" !== e.audioTypeSelfHosted_streamType && "youtube" !== e.audioType
                }

                function player_determineHtmlAreas(e) {
                    var a = e.initOptions;
                    let t = "",
                        i = "",
                        s = "";
                    for (var n in e.cthis.children(".feed-dzsap--extra-html").length > 0 && "" === a.settings_extrahtml ? (e.cthis.children(".feed-dzsap--extra-html").each((function() {
                            t += jQuery(this).html()
                        })), e.cthis.children(".feed-dzsap--extra-html").remove()) : a.settings_extrahtml && (t = a.settings_extrahtml), e.cthis.children(".feed-dzsap--extra-html-in-controls-left").length > 0 && (i = e.cthis.children(".feed-dzsap--extra-html-in-controls-left").eq(0).html()), e.cthis.children(".feed-dzsap--extra-html-in-controls-right").length > 0 && (s = e.cthis.children(".feed-dzsap--extra-html-in-controls-right").eq(0).html()), e.cthis.children(".feed-dzsap--extra-html-bottom").length > 0 && (t = e.cthis.children(".feed-dzsap--extra-html-bottom").eq(0).html()), e.extraHtmlAreas.controlsLeft = i, e.extraHtmlAreas.controlsRight = s, e.extraHtmlAreas.bottom = t, e.extraHtmlAreas.controlsRight && (e.extraHtmlAreas.controlsRight = String(e.extraHtmlAreas.controlsRight).replace(/{{svg_share_icon}}/g, dzsapSvgs.svg_share_icon)), e.extraHtmlAreas) e.extraHtmlAreas[n] = String(e.extraHtmlAreas[n]).replace("{{heart_svg}}", "\t&hearts;"), e.extraHtmlAreas[n] = String(e.extraHtmlAreas[n]).replace("{{embed_code}}", e.feedEmbedCode)
                }

                function player_stopOtherPlayers(e, a) {
                    var t = 0;
                    for (t = 0; t < e.length; t++) e[t].get(0) && e[t].get(0).api_pause_media && e[t].get(0) != a.cthis.get(0) && (e[t].data("type_audio_stop_buffer_on_unfocus") && "on" === e[t].data("type_audio_stop_buffer_on_unfocus") ? e[t].get(0).api_destroy_for_rebuffer() : e[t].get(0).api_pause_media({
                        audioapi_setlasttime: !1
                    }))
                }

                function player_syncPlayers_gotoItem(e, a) {
                    if (window.dzsap_settings.syncPlayers_autoplayEnabled)
                        for (var t in window.dzsap_syncList_players) {
                            var i = e.cthis;
                            if (e._sourcePlayer && (i = e._sourcePlayer), window.dzsap_syncList_players[t].get(0) === i.get(0)) {
                                t = parseInt(t, 10);
                                let e = window.dzsap_syncList_index + a;
                                if (e >= 0 && e < window.dzsap_syncList_players.length) {
                                    let a = window.dzsap_syncList_players[e].get(0);
                                    a && a.api_play_media && setTimeout((function() {
                                        a.api_play_media({
                                            called_from: "api_sync_players_prev"
                                        })
                                    }), 200)
                                }
                            }
                        }
                }

                function player_syncPlayers_buildList() {
                    window.syncPlayers_isDzsapListBuilt || (window.dzsap_syncList_players = [], window.syncPlayers_isDzsapListBuilt = !0, jQuery(".audioplayer.is-single-player,.audioplayer-tobe.is-single-player").each((function() {
                        var e = jQuery(this);
                        e.hasClass("dzsap_footer") || "on" !== e.attr("data-do-not-include-in-list") && window.dzsap_syncList_players.push(e)
                    })), clearTimeout(window.syncPlayers_buildTimeout), window.syncPlayers_buildTimeout = setTimeout((function() {
                        window.syncPlayers_isDzsapListBuilt = !1
                    }), 500))
                }

                function player_detect_skinwave_mode() {
                    var e = this;
                    e.skinwave_mode = e.initOptions.skinwave_mode, e.cthis.hasClass("skin-wave-mode-small") && (e.skinwave_mode = "small"), e.cthis.hasClass("skin-wave-mode-alternate") && (e.skinwave_mode = "alternate"), e.cthis.hasClass("skin-wave-mode-bigwavo") && (e.skinwave_mode = "bigwavo")
                }

                function player_constructArtistAndSongCon(e) {
                    var a = this;
                    if (0 === a.cthis.find(".meta-artist").length && (a.cthis.find(".feed-artist-name").length || a.cthis.find(".feed-song-name").length)) {
                        var t = '<span class="meta-artist player-artistAndSong">';
                        a.cthis.find(".feed-artist-name").length && (t += '<span class="the-artist">' + a.cthis.find(".feed-artist-name").eq(0).html() + "</span>"), a.cthis.find(".feed-song-name").length && (t += '<span class="the-name player-meta--songname">' + a.cthis.find(".feed-song-name").eq(0).html() + "</span>"), t += "</span>", a.cthis.append(t)
                    }
                    if ("fake" === a.cthis.attr("data-type") && 0 === a.cthis.find(".meta-artist").length && a.cthis.append('<span class="meta-artist"><span class="the-artist"></span><span class="the-name"></span></span>'), !a._metaArtistCon || "reconstruct" === e.call_from) {
                        a.cthis.children(".meta-artist").length > 0 && (a.cthis.hasClass("skin-wave-mode-alternate") ? (a._conControls.children().last().hasClass("clear") && a._conControls.children().last().remove(), a._conControls.append(a.cthis.children(".meta-artist"))) : a._audioplayerInner && a._audioplayerInner.append(a.cthis.children(".meta-artist"))), a._audioplayerInner.find(".meta-artist").eq(0).wrap('<div class="meta-artist-con"></div>'), a._metaArtistCon = a._audioplayerInner.find(".meta-artist-con").eq(0);
                        var i = a.initOptions;
                        a._apControls.find(".ap-controls-right").length > 0 && (a._apControlsRight = a.cthis.find(".ap-controls-right").eq(0)), a._apControls.find(".ap-controls-left").length > 0 && (a._apControlsLeft = a._apControls.find(".ap-controls-left").eq(0)), "skin-pro" === i.design_skin && (a._apControlsRight = a.cthis.find(".con-controls--right").eq(0)), "skin-wave" === i.design_skin && (a.cthis.find(".dzsap-repeat-button").length ? a.cthis.find(".dzsap-repeat-button").after(a._metaArtistCon) : a.cthis.find(".dzsap-loop-button").length && !1 === a.cthis.find(".dzsap-loop-button").eq(0).parent().hasClass("feed-dzsap-for-extra-html-right") ? a.cthis.find(".dzsap-loop-button").after(a._metaArtistCon) : a._conPlayPauseCon.after(a._metaArtistCon), "alternate" === a.skinwave_mode && a._apControlsRight.before(a._metaArtistCon)), "skin-aria" === i.design_skin && a._apControlsRight.prepend(a._metaArtistCon), "skin-redlights" !== i.design_skin && "skin-steel" !== i.design_skin || a._apControlsRight.prepend(a._metaArtistCon), "skin-silver" === i.design_skin && a._apControlsRight.append(a._metaArtistCon), "skin-default" === i.design_skin && a._apControlsRight.before(a._metaArtistCon)
                    }
                }

                function convertPluginOptionsToFinalOptions(elThis, defaultOptions, argOptions = null, searchedAttr = "data-options", $es) {
                    var finalOptions = null,
                        tempOptions = {},
                        sw_setFromJson = !1;
                    void 0 === $es && ($es = jQuery);
                    var $elThis = $es(elThis);
                    if (argOptions && "object" == typeof argOptions) tempOptions = argOptions;
                    else {
                        if ($elThis.attr(searchedAttr)) try {
                            tempOptions = JSON.parse($elThis.attr(searchedAttr)), sw_setFromJson = !0
                        } catch (e) {
                            console.log("err - ", e)
                        }
                        if (!(sw_setFromJson || void 0 !== argOptions && argOptions || void 0 === $elThis.attr(searchedAttr) || "" == $elThis.attr("data-options"))) {
                            var aux = $elThis.attr(searchedAttr);
                            aux = "var aux_opts = " + aux, eval(aux), tempOptions = Object.assign({}, aux_opts)
                        }
                    }
                    return finalOptions = Object.assign(defaultOptions, tempOptions), finalOptions
                }

                function generateFakeArrayForPcm() {
                    for (var e = [], a = 0; a < 256; a++) e[a] = 100 * Math.random();
                    return e
                }

                function scrubbar_modeWave_clearObsoleteCanvas(e) {
                    e._scrubbar && e._scrubbar.find(".scrubbar-type-wave--canvas.transitioning-out").remove()
                }

                function scrubbar_modeWave_setupCanvas(e, a) {
                    var t = {
                        prepare_for_transition_in: !1
                    };
                    e && (t = Object.assign(t, e));
                    var i = a.initOptions;
                    a._scrubbar.find(".scrub-bg").eq(0).append('<canvas class="scrubbar-type-wave--canvas scrub-bg-img" ></canvas>'), a._scrubbar.find(".scrub-prog").eq(0).append('<canvas class="scrubbar-type-wave--canvas scrub-prog-img" ></canvas>'), a._scrubbarbg_canvas = a._scrubbar.find(".scrub-bg-img").last(), a._scrubbarprog_canvas = a._scrubbar.find(".scrub-prog-img").last(), "on" === i.skinwave_enableSpectrum && a._scrubbarprog_canvas.hide(), t.prepare_for_transition_in && (a._scrubbarbg_canvas.addClass("preparing-transitioning-in"), a._scrubbarprog_canvas.addClass("preparing-transitioning-in"), setTimeout((function() {
                        a._scrubbarbg_canvas.addClass("transitioning-in"), a._scrubbarprog_canvas.addClass("transitioning-in")
                    }), 20))
                }
            },
            690: (e, a, t) => {
                "use strict";
                t.r(a), t.d(a, {
                    retrieve_soundcloud_url: () => n
                });
                var i = t(567);
                const s = t(348);

                function n(e, a) {
                    var t = e.initOptions;
                    "" == t.soundcloud_apikey && alert("soundcloud api key not defined, read docs!");
                    var n = "https://api.soundcloud.com/resolve?url=" + e.data_source + "&format=json&consumer_key=" + t.soundcloud_apikey;
                    n = encodeURIComponent(n);
                    var o = t.php_retriever + "?scurl=" + n;
                    jQuery.ajax({
                        type: "GET",
                        url: o,
                        data: {},
                        async: !0,
                        dataType: "text",
                        error: function(e, a, t) {
                            console.log("retried soundcloud error", e, a, t)
                        },
                        success: function(a) {
                            var n = [];
                            let r = "";
                            try {
                                n = JSON.parse(a), e.audioType = "selfHosted", "" == n && (e.cthis.addClass(i.O.ERRORED_OUT_CLASS), e.cthis.append('<div class="feedback-text">soundcloud track does not seem to serve via api</div>')), e.original_real_mp3 = e.cthis.attr("data-source"), n.stream_url ? (r = n.stream_url + "?consumer_key=" + t.soundcloud_apikey + "&origin=localhost", e.cthis.attr("data-source", r), e.$feed_fakeButton && e.$feed_fakeButton.attr("data-source", r), e._sourcePlayer && e._sourcePlayer.attr("data-source", r)) : (e.cthis.addClass(i.O.ERRORED_OUT_CLASS), e.cthis.append('<div class="feedback-text ">this soundcloud track does not allow streaming  </div>')), e.data_source = r, e.cthis.attr("data-pcm") && (e.isAlreadyHasRealPcm = !0), "skin-wave" == t.design_skin && "canvas" == t.skinwave_wave_mode && 0 == e.isAlreadyHasRealPcm && 0 == ("on" == t.pcm_data_try_to_generate && "on" == t.pcm_data_try_to_generate_wait_for_real_pcm) && s.scrubModeWave__initGenerateWaveData(e, {
                                    call_from: "soundcloud init(), pcm not real.."
                                }), e.setup_media({
                                    called_from: "change_media"
                                }), setTimeout((function() {
                                    e.isPlayPromised && (e.play_media({
                                        call_from: "change_media"
                                    }), e.isPlayPromised = !1)
                                }), 300)
                            } catch (e) {
                                console.log("soduncloud parse error -", a, " - ", o)
                            }
                        }
                    })
                }
            },
            209: (e, a, t) => {
                "use strict";
                t.r(a), t.d(a, {
                    registerToJquery: () => _
                });
                var i = t(586),
                    s = t(567);
                const n = {
                    design_skin: "skin-default",
                    cueFirstMedia: "on",
                    autoplay: "off",
                    autoplayNext: "on",
                    settings_enable_linking: "off",
                    design_menu_position: "bottom",
                    navigation_method: "mouseover",
                    design_menu_state: "open",
                    design_menu_show_player_state_button: "off",
                    design_menu_width: "default",
                    design_menu_height: "default",
                    design_menu_space: "default",
                    settings_php_handler: "",
                    design_menuitem_width: "default",
                    design_menuitem_height: "default",
                    design_menuitem_space: "default",
                    disable_menu_navigation: "off",
                    loop_playlist: "on",
                    menu_facebook_share: "auto",
                    enable_easing: "off",
                    settings_ap: "default",
                    playlistTransition: "fade",
                    embedded: "off",
                    mode_showall_layout: "one-per-row",
                    settings_mode: "mode-normal",
                    settings_mode_showall_show_number: "on",
                    mode_normal_video_mode: "auto"
                };
                var o = t(891);
                const {
                    sanitizeToCssPx: r
                } = t(401), l = class {
                    constructor(e) {
                        this.parentGallery = e, this.structZoomsoundsNav = "", this._navMain = null, this._navClipper = null, this.cgallery = null, this.size_navMainClipSize = null, this.size_navMainTotalSize = null, this.finish_viy = 0, this.init()
                    }
                    init() {
                        var e = this.parentGallery;
                        this.structZoomsoundsNav = '<div class="nav-main zoomsounds-nav ' + e.initOptions.design_skin + " navigation-method-" + e.initOptions.navigation_method + '" style="display: none;"><div class="nav-clipper"></div></div>', "full" === this.parentGallery.initOptions.navigation_method && (this.parentGallery.initOptions.design_menu_height = "auto")
                    }
                    init_ready() {
                        var e = this.parentGallery;

                        function a(a) {
                            var t = jQuery(this);
                            if ("click" == a.type) {
                                if (t.hasClass("menu-item")) {
                                    var i = t.parent().children().index(t);
                                    e.goto_item(i)
                                }
                                if (t.hasClass("menu-btn-like")) return t.parent().parent().attr("data-playerid") && o.ajax_submit_like.bind(e)(1, t.parent().parent().attr("data-playerid"), {
                                    refferer: t
                                }), !1;
                                if (t.hasClass("menu-facebook-share")) return t.parent().parent().attr("data-playerid") && o.ajax_submit_like.bind(e)(1, t.parent().parent().attr("data-playerid"), {
                                    refferer: t
                                }), !1
                            }
                        }
                        "on" == e.initOptions.disable_menu_navigation && this._navMain.hide(), isNaN(Number(e.initOptions.design_menu_height)) || this._navMain.css({
                            height: r(e.initOptions.design_menu_height)
                        }), (i.is_ios() || i.is_android()) && this._navMain.css({
                            overflow: "auto"
                        }), "closed" == e.initOptions.design_menu_state ? (this._navMain.css({
                            height: 0
                        }), this.cgallery.removeClass("menu-opened"), this.cgallery.addClass("menu-closed")) : (this.cgallery.addClass("menu-opened"), this.cgallery.removeClass("menu-closed")), this._navClipper.on("click", ".menu-btn-like,.menu-facebook-share", a), this._navClipper.on("click", ".menu-item", a)
                    }
                    get_structZoomsoundsNav() {
                        return this.structZoomsoundsNav
                    }
                    set_elements(e, a, t) {
                        this._navMain = e, this._navClipper = a, this.cgallery = t
                    }
                    calculateDims() {
                        this.size_navMainClipSize = this._navMain.height(), this.size_navMainTotalSize = this._navClipper.outerHeight();
                        const e = this;

                        function a(a) {
                            var t = jQuery(this),
                                s = (a.pageX, t.offset().left, a.pageY - t.offset().top);
                            if (!(e.size_navMainTotalSize <= e.size_navMainClipSize)) {
                                e.size_navMainClipSize = e._navMain.outerHeight();
                                var n = 0;
                                (n = s / e.size_navMainClipSize * -(e.size_navMainTotalSize - e.size_navMainClipSize + 10 + 40) + 20) > 0 && (n = 0), n < -(e.size_navMainTotalSize - e.size_navMainClipSize + 10) && (n = -(e.size_navMainTotalSize - e.size_navMainClipSize + 10)), e.finish_viy = n, 0 == i.is_ios() && 0 == i.is_android() && "on" != e.parentGallery.initOptions.enable_easing && e._navClipper.css({
                                    transform: "translateY(" + e.finish_viy + "px)"
                                })
                            }
                        }
                        "mouseover" === this.parentGallery.initOptions.navigation_method && (this.size_navMainTotalSize > this.size_navMainClipSize && this.size_navMainClipSize > 0 ? (this._navMain.unbind("mousemove", a), this._navMain.bind("mousemove", a)) : this._navMain.unbind("mousemove", a))
                    }
                    toggle_menu_state() {
                        const e = this;
                        0 == this._navMain.height() ? (this._navMain.css({
                            height: this.parentGallery.initOptions.design_menu_height
                        }), this.cgallery.removeClass("menu-closed"), this.cgallery.addClass("menu-opened")) : (this._navMain.css({
                            height: 0
                        }), this.cgallery.removeClass("menu-opened"), this.cgallery.addClass("menu-closed")), setTimeout((function() {
                            e.parentGallery.handleResize()
                        }), 400)
                    }
                    parseTrackData(e) {
                        var a = 0;
                        this._navMain.find(".menu-item-views").each((function() {
                            var t = $(this),
                                i = t.html(),
                                s = /{{views_(.*?)}}/g.exec(i),
                                n = "";
                            if (s && s[1]) {
                                for (var o in n = s[1], e)
                                    if (n == e[o].label || n == "ap" + e[o].label) {
                                        i = i.replace(s[0], e[o].views), a++;
                                        break
                                    } t.html(i)
                            }
                        })), a < e.length && this._navMain.find(".menu-item-views").each((function() {
                            var e = $(this),
                                a = e.html(),
                                t = /{{views_(.*?)}}/g.exec(a);
                            t && t[0] && (a = a.replace(t[0], 0), e.html(a))
                        }))
                    }
                };
                class d {
                    constructor(e, a, t) {
                        this.argThis = e, this.argOptions = a, this.$ = t, this.navClass = null, this.init()
                    }
                    init() {
                        var e, a, t, n, o = this.$,
                            r = this,
                            d = r.argOptions,
                            _ = o(r.argThis),
                            c = "ag1",
                            p = -1,
                            u = 0,
                            m = 0,
                            h = 0,
                            f = 0,
                            g = !1,
                            y = !0,
                            v = !0,
                            b = !1,
                            w = !1,
                            k = [],
                            C = [],
                            T = "You need to comment or rate before downloading.",
                            z = 0,
                            x = 0,
                            P = 0;

                        function S() {
                            if (v) return !1;
                            _.remove(), _ = null, v = !0
                        }

                        function $(e, t) {
                            e || (e = "title"), a.children().each((function() {
                                var i, s, n = (i = o(this), s = "", "title" === e && (s = i.find(".the-name").text()), "" === t || s.toLowerCase().indexOf(t.toLowerCase()) > -1);
                                n ? o(this).addClass("is-according-to-search") : o(this).removeClass("is-according-to-search"), a.hasClass("isotoped") ? a.isotope({
                                    filter: ".is-according-to-search"
                                }) : n ? o(this).fadeIn("fast") : o(this).fadeOut("fast")
                            }))
                        }

                        function O() {
                            window.dzsap_syncList_players = [], a.children(".audioplayer,.audioplayer-tobe").each((function() {
                                var e = o(this);
                                e.addClass("feeded-whole-playlist"), "on" != e.attr("data-do-not-include-in-list") && window.dzsap_syncList_players.push(e)
                            }))
                        }

                        function M() {
                            if (w) return !1;
                            w = !0, d.settings_php_handler && o.ajax({
                                type: "POST",
                                url: d.settings_php_handler,
                                data: {
                                    action: "dzsap_get_views_all",
                                    postdata: "1"
                                },
                                success: function(e) {
                                    _.attr("data-track-data", e), I()
                                },
                                error: function(e) {
                                    window.console
                                }
                            })
                        }

                        function I() {
                            if (_.attr("data-track-data")) {
                                try {
                                    C = JSON.parse(_.attr("data-track-data"))
                                } catch (e) {
                                    console.log(e)
                                }
                                C && C.length && r.navClass.parseTrackData(C)
                            }
                        }

                        function N() {
                            return m
                        }

                        function q() {
                            var e, t = _.find(".items").eq(0).children(".audioplayer-tobe").length;
                            for (k = [], f = 0; f < t; f++) {
                                var s = _.find(".items").children(".audioplayer-tobe").eq(0),
                                    o = "";
                                s.find(".menu-description").html() ? o = s.find(".menu-description").html() : (o = "", (s.find(".feed-artist-name").length || s.find(".feed-song-name").length) && (o = "", s.attr("data-thumb") && (o += `<div class="menu-item-thumb-con"><div class="menu-item-thumb" style="background-image: url(${s.attr("data-thumb")})"></div></div>`), o += `<div class="menu-artist-info"><span class="the-artist">${s.find(".feed-artist-name").html()}</span><span class="the-name">${s.find(".feed-song-name").html()}</span></div>`));
                                var r = {
                                    menu_description: o,
                                    player_id: (e = s, e.attr("data-player-id") ? e.attr("data-player-id") : e.attr("id") ? e.attr("id") : e.attr("data-source") ? i.dzs_clean_string(e.attr("data-source")) : void 0)
                                };
                                k.push(r), a.append(s)
                            }
                            for (f = 0; f < k.length; f++) {
                                var l = "";
                                k[f].menu_description && -1 == k[f].menu_description.indexOf('<div class="menu-item-thumb-con"><div class="menu-item-thumb" style="') && (l += " no-thumb");
                                var d = '<div class="menu-item' + l + '"  data-menu-index="' + f + '" data-gallery-id="' + c + '" data-playerid="' + k[f].player_id + '">';
                                _.hasClass("skin-aura") && (d += '<div class="menu-item-number">' + ++m + "</div>"), d += k[f].menu_description, _.hasClass("skin-aura") && 1 == String(k[f].menu_description).indexOf("menu-item-views") && (C && C.length > 0 ? d += '<div class="menu-item-views"></div>' : (M(), d += '<div class="menu-item-views">' + dzsapSvgs.svg_play_icon + ' <span class="the-count">{{views_' + k[f].player_id + "}}</span></div>")), d += "</div>", n.append(d), _.hasClass("skin-aura") && k[f] && k[f].menu_description && k[f].menu_description.indexOf("float-right") > -1 && n.children().last().addClass("has-extra-info")
                            }
                        }

                        function A() {
                            _.addClass("dzsag-loaded")
                        }

                        function j() {
                            if (0 == o(this).hasClass("active")) return alert(T), !1
                        }

                        function R() {
                            void 0 !== a.children().eq(p).get(0) && void 0 !== a.children().eq(p).get(0).api_play_media && a.children().eq(p).get(0).api_play_media({
                                call_from: "play_curr_media_gallery"
                            })
                        }

                        function H(e) {
                            if ("mode-showall" == d.settings_mode) {
                                var t = a.children(".audioplayer,.audioplayer-tobe").index(e);
                                p = t, _.get(0).currNr_2 = t
                            }
                        }

                        function E() {
                            isNaN(z) && (z = 0), x = z, P = r.navClass.finish_viy - x, z = Number(Math.easeIn(1, x, P, 20).toFixed(4)), 0 == i.is_ios() && 0 == i.is_android() && n.css({
                                transform: "translateY(" + z + "px)"
                            }), requestAnimationFrame(E)
                        }

                        function L() {
                            r.navClass.toggle_menu_state()
                        }

                        function F() {
                            "on" == d.autoplayNext && J()
                        }

                        function B() {
                            n.children(".menu-item").eq(p).find(".download-after-rate").addClass("active")
                        }

                        function D() {
                            n.children(".menu-item").eq(p).find(".download-after-rate").addClass("active")
                        }

                        function Q() {
                            "mode-showall" != d.settings_mode && 0 == a.hasClass("isotoped") && "one" != d.mode_normal_video_mode && 0 == a.children().eq(p).hasClass("zoomsounds-wrapper-bg-bellow") && a.css("height", a.children().eq(p).outerHeight()), 0 == a.hasClass("isotoped") && setTimeout((function() {
                                a.css("height", "auto")
                            }), s.O.PLAYLIST_TRANSITION_DURATION), r.navClass.calculateDims(), "on" == d.embedded && window.frameElement && (window.frameElement.height = _.height())
                        }

                        function V() {
                            r.navClass.calculateDims()
                        }

                        function W() {
                            "mode-showall" !== d.settings_mode && !1 === a.hasClass("isotoped") && setTimeout((function() {
                                a.css("height", a.children().eq(p).outerHeight())
                            }), 500), Q()
                        }

                        function U(e) {
                            a.children().eq(u).removeClass("transitioning-out"), a.children().eq(e).removeClass("transitioning-in"), u = p, g = !1
                        }

                        function G() {
                            _.parent().children(".the-bg").eq(0).remove(), g = !1
                        }

                        function Y() {
                            h = p;
                            var e = !0;
                            --h < 0 && (h = a.children().length - 1, "off" == d.loop_playlist && (e = !1)), e && X(h)
                        }

                        function J() {
                            h = p;
                            var e = !0;
                            "mode-showall" == d.settings_mode && (h = _.get(0).currNr_2), ++h >= a.children().length && (h = 0, "off" == d.loop_playlist && (e = !1)), e && X(h)
                        }

                        function X(e, t) {
                            var r = {
                                ignore_arg_currNr_check: !1,
                                ignore_linking: !1,
                                donotopenlink: "off",
                                called_from: "default"
                            };
                            if (t && (r = o.extend(r, t)), 1 != g)
                                if ("last" == e && (e = a.children().length - 1), p != e) {
                                    var l = a.children(".audioplayer,.audioplayer-tobe").eq(e),
                                        u = "";
                                    p > -1 && (void 0 !== a.children().eq(p).get(0) && (void 0 !== a.children().eq(p).get(0).api_pause_media && a.children().eq(p).get(0).api_pause_media(), void 0 !== a.children().eq(p).get(0).api_get_last_vol && (u = a.children().eq(p).get(0).api_get_last_vol())), n.children().removeClass("active active-from-gallery"), "one" == d.mode_normal_video_mode || "mode-showall" != d.settings_mode && (a.children().eq(p).removeClass("active active-from-gallery"), n.children().eq(p).removeClass("active active-from-gallery"))), "sameasgallery" === d.settings_ap.design_skin && (d.settings_ap.design_skin = d.design_skin), -1 == p && "on" == d.autoplay && (d.settings_ap.autoplay = "on"), p > -1 && "on" == d.autoplayNext && (d.settings_ap.autoplay = "on"), d.settings_ap.parentgallery = _, d.settings_ap.design_menu_show_player_state_button = d.design_menu_show_player_state_button, d.settings_ap.cue = "on", 1 == y && ("off" == d.cueFirstMedia && (d.settings_ap.cue = "off"), y = !1);
                                    var m = o.extend({}, d.settings_ap);
                                    if (m.volume_from_gallery = u, m.call_from = "gotoItem", m.player_navigation = d.player_navigation, "one" == d.mode_normal_video_mode && e > -1 && "init" != r.called_from) {
                                        var h = a.children().eq(0).get(0);
                                        l = a.children().eq(0), h && h.api_play_media && (h.api_change_media(a.children().eq(e), {
                                            called_from: "goto_item -- mode_normal_video_mode()",
                                            modeOneGalleryIndex: e,
                                            source_player_do_not_update: "on"
                                        }), "on" == d.autoplayNext && setTimeout((function() {
                                            h.api_play_media()
                                        }), 200))
                                    } else Z(l, m);
                                    "on" === d.autoplayNext && ("mode-showall" === d.settings_mode && (p = _.get(0).currNr_2), p > -1 && l.get(0) && l.get(0).api_play && l.get(0).api_play()), void 0 !== d.settings_ap.playfrom && "0" !== d.settings_ap.playfrom || (l.get(0) && l.get(0).api_seek_to ? l.get(0).api_seek_to(0, {
                                        call_from: "playlist_seek_from_0"
                                    }) : console.log("_audioplayerToBeActive not found - ", l)), l.get(0), "mode-showall" !== d.settings_mode && (a.children().eq(p).addClass("transitioning-out"), l.removeClass("transitioning-out-complete"), l.addClass("transitioning-in"), setTimeout((e => {
                                        e.addClass("transitioning-out-complete")
                                    }), s.O.PLAYLIST_TRANSITION_DURATION, a.children().eq(p)), "link" != l.attr("data-type") && 0 == r.ignore_linking && "on" == d.settings_enable_linking && history.pushState({
                                        foo: "bar"
                                    }, null, i.add_query_arg(window.location.href, "audiogallery_startitem_" + c, e)), "fade" === d.playlistTransition && (setTimeout(U, s.O.PLAYLIST_TRANSITION_DURATION, e), g = !0), "direct" === d.playlistTransition && U(e)), l.addClass("active active-from-gallery"), n.children().eq(e).addClass("active active-from-gallery");
                                    var f = "";
                                    l.attr("data-bgimage") && (f = l.attr("data-bgimage")), l.attr("data-wrapper-image") && (f = l.attr("data-wrapper-image")), f && _.parent().hasClass("ap-wrapper") && _.parent().children(".the-bg").length > 0 && (_.parent().children(".the-bg").eq(0).after('<div class="the-bg" style="background-image: url(' + f + ');"></div>'), _.parent().children(".the-bg").eq(0).css({
                                        opacity: 1
                                    }), _.parent().children(".the-bg").eq(1).css({
                                        opacity: 0
                                    }), _.parent().children(".the-bg").eq(1).animate({
                                        opacity: 1
                                    }, {
                                        queue: !1,
                                        duration: 1e3,
                                        complete: G,
                                        step: function() {
                                            g = !0
                                        }
                                    }), g = !0), "mode-showall" != d.settings_mode && (p = e, _.data("currNr", p)), a.children().eq(p).get(0) && a.children().eq(p).get(0).api_handleResize && a.children().eq(p).hasClass("media-setuped") && a.children().eq(p).get(0).api_handleResize(), Q()
                                } else a && a.children().eq(p).get(0) && a.children().eq(p).get(0).api_play_media && a.children().eq(p).get(0).api_play_media({
                                    call_from: "gallery"
                                })
                        }

                        function Z(e, a) {
                            var t = o.extend({}, d.settings_ap);
                            a && (t = o.extend(t, a)), e.hasClass("audioplayer-tobe") && (d.settings_ap.call_from = "init player from gallery", e.audioplayer(t))
                        }
                        r.goto_item = X, r.handleResize = W, r.initOptions = d, window.dzsap_settings && void 0 !== window.dzsap_settings.str_alertBeforeRate && (T = window.dzsap_settings.str_alertBeforeRate), _.get(0).currNr_2 = -1,
                            function() {
                                if ("default" === d.settings_ap)
                                    if (_.attr("data-player-options")) d.settings_ap = i.convertPluginOptionsToFinalOptions(_.get(0), {}, null, "data-player-options");
                                    else {
                                        const e = _.find(".audioplayer, .audioplayer-tobe").eq(0);
                                        e && (d.settings_ap = i.convertPluginOptionsToFinalOptions(e.get(0), {}, null))
                                    }
                                else "string" == typeof d.settings_ap && window.dzsap_apconfigs && "object" == typeof window.dzsap_apconfigs[d.settings_ap] && (d.settings_ap = {
                                    ...window.dzsap_apconfigs[d.settings_ap]
                                });
                                "default" !== d.settings_ap && "string" != typeof d.settings_ap || (d.settings_ap = {}), "default" === d.design_menu_width && (d.design_menu_width = "100%"), "default" === d.design_menu_height && (d.design_menu_height = "200"), _.hasClass("skin-wave") && (d.design_skin = "skin-wave"), _.hasClass("skin-default") && (d.design_skin = "skin-default"), _.hasClass("skin-aura") && (d.design_skin = "skin-aura"), _.addClass(d.settings_mode), _.append('<div class="slider-main"><div class="slider-clipper"></div></div>'), _.addClass("menu-position-" + d.design_menu_position), e = _.find(".slider-main").eq(0);
                                var p = _.find(".items").children(".audioplayer-tobe").length;
                                d.settings_ap.disable_player_navigation = d.disable_player_navigation, (0 === p || 1 === p) && (d.design_menu_position = "none", d.settings_ap.disable_player_navigation = "on"), r.navClass = new l(r), "top" === d.design_menu_position && e.before(r.navClass.get_structZoomsoundsNav()), "bottom" === d.design_menu_position && e.after(r.navClass.get_structZoomsoundsNav()), d.settings_php_handler || d.settings_ap.settings_php_handler && (d.settings_php_handler = d.settings_ap.settings_php_handler), _.attr("id"), c = _.attr("id"), a = _.find(".slider-clipper").eq(0), t = _.find(".nav-main").eq(0), n = _.find(".nav-clipper").eq(0), _.children(".extra-html").length && _.append(_.children(".extra-html")), "mode-showall" === d.settings_mode && a.addClass("layout-" + d.mode_showall_layout), r.navClass.set_elements(t, n, _), q(), r.navClass.init_ready(), I(), !1 === i.can_history_api() && (d.settings_enable_linking = "off"), o(window).bind("resize", W), W(), setTimeout(W, 1e3), _.get(0).api_skin_redlights_give_controls_right_to_all = function() {
                                    b = !0
                                }, i.get_query_arg(window.location.href, "audiogallery_startitem_" + c) && (h = Number(i.get_query_arg(window.location.href, "audiogallery_startitem_" + c)), u = h, Number(i.get_query_arg(window.location.href, "audiogallery_startitem_" + c)) && Number(i.get_query_arg(window.location.href, "audiogallery_startitem_" + c)) > 0 && "on" == d.force_autoplay_when_coming_from_share_link && (d.autoplay = "on")), "mode-normal" == d.settings_mode && X(h, {
                                    called_from: "init"
                                }), "mode-showall" === d.settings_mode && (a.children().each((function() {
                                    var e = o(this),
                                        a = e.parent().children(".audioplayer,.audioplayer-tobe").index(e);
                                    if (e.hasClass("audioplayer-tobe")) {
                                        var t = Object.assign({}, d.settings_ap);
                                        t.parentgallery = _, t.call_from = "mode show-all", t.action_audio_play = H, e.audioplayer(t), (a = String(a + 1)).length < 2 && (a = "0" + a), "one-per-row" === d.mode_showall_layout && "off" !== d.settings_mode_showall_show_number && (e.before('<div class="number-wrapper"><span class="the-number">' + a + "</span></div>"), e.after('<div class="clear for-number-wrapper"></div>'))
                                    }
                                })), o.fn.isotope && "one-per-row" !== d.mode_showall_layout && (a.find(".audioplayer,.audioplayer-tobe").addClass("isotope-item"), setTimeout((function() {
                                    a.prepend('<div class="grid-sizer"></div>'), a.isotope({
                                        itemSelector: ".isotope-item",
                                        layoutMode: "fitRows",
                                        percentPosition: !0,
                                        masonry: {
                                            columnWidth: ".grid-sizer"
                                        }
                                    }), a.addClass("isotoped"), setTimeout((function() {
                                        a.isotope("layout")
                                    }), 900)
                                }), s.O.PLAYLIST_TRANSITION_DURATION), a.append('<div class="clear"></div>')), b && a.children(".audioplayer").each((function() {
                                    var e = o(this);
                                    !1 === e.find(".ap-controls-right").eq(0).prev().hasClass("controls-right") && e.find(".ap-controls-right").eq(0).before('<div class="controls-right"> </div>')
                                }))), _.find(".download-after-rate").bind("click", j), _.get(0).api_regenerate_sync_players_with_this_playlist = O, _.get(0).api_goto_next = J, _.get(0).api_goto_prev = Y, _.get(0).api_goto_item = X, _.get(0).api_gallery_handle_end = F, _.get(0).api_toggle_menu_state = L, _.get(0).api_handleResize = W, _.get(0).api_player_commentSubmitted = B, _.get(0).api_player_rateSubmitted = D, _.get(0).api_reinit = q, _.get(0).api_play_curr_media = R, _.get(0).api_get_nr_children = N, _.get(0).api_init_player_from_gallery = Z, _.get(0).api_filter = $, _.get(0).api_destroy = S, setInterval(V, 1e3), setTimeout(A, 700), "on" == d.enable_easing && E(), _.addClass("dzsag-inited"), _.addClass("transition-" + d.playlistTransition), _.addClass("playlist-transition-" + d.playlistTransition)
                            }()
                    }
                }
                const _ = function(e) {
                    e.fn.audiogallery = function(a) {
                        var t;
                        const s = {
                            ...n
                        };
                        t = i.convertPluginOptionsToFinalOptions(this, s, a), this.each((function() {
                            this.linkedClassInstance = new d(this, t, e)
                        }))
                    }, window.dzsag_init = function(a, t) {
                        void 0 !== t && void 0 !== t.init_each && !0 === t.init_each ? (1 === Object.keys(t).length && (t = void 0), e(a).each((function() {
                            e(this).audiogallery(t)
                        }))) : e(a).audiogallery(t)
                    }
                }
            },
            560: (e, a) => {
                a.svg_footer_playlist = '<svg class="svg-icon" version="1.1" id="Layer_2" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="13.25px" height="13.915px" viewBox="0 0 13.25 13.915" enable-background="new 0 0 13.25 13.915" xml:space="preserve"> <path d="M1.327,4.346c-0.058,0-0.104-0.052-0.104-0.115V2.222c0-0.063,0.046-0.115,0.104-0.115H11.58 c0.059,0,0.105,0.052,0.105,0.115v2.009c0,0.063-0.046,0.115-0.105,0.115H1.327z"/> <path d="M1.351,8.177c-0.058,0-0.104-0.051-0.104-0.115V6.054c0-0.064,0.046-0.115,0.104-0.115h10.252 c0.058,0,0.105,0.051,0.105,0.115v2.009c0,0.063-0.047,0.115-0.105,0.115H1.351z"/> <path d="M1.351,12.182c-0.058,0-0.104-0.05-0.104-0.115v-2.009c0-0.064,0.046-0.115,0.104-0.115h10.252 c0.058,0,0.105,0.051,0.105,0.115v2.009c0,0.064-0.047,0.115-0.105,0.115H1.351z"/> </svg>', a.svg_embed_btn = '<svg class="svg-icon" version="1.2" baseProfile="tiny" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px" viewBox="0 0 15 15" xml:space="preserve"> <g id="Layer_1"> <polygon fill="#E6E7E8" points="1.221,7.067 0.494,5.422 4.963,1.12 5.69,2.767 "/> <polygon fill="#E6E7E8" points="0.5,5.358 1.657,4.263 3.944,10.578 2.787,11.676 "/> <polygon fill="#E6E7E8" points="13.588,9.597 14.887,8.34 12.268,2.672 10.969,3.93 "/> <polygon fill="#E6E7E8" points="14.903,8.278 14.22,6.829 9.714,11.837 10.397,13.287 "/> </g> <g id="Layer_2"> <rect x="6.416" y="1.713" transform="matrix(0.9663 0.2575 -0.2575 0.9663 2.1699 -1.6329)" fill="#E6E7E8" width="1.805" height="11.509"/> </g> </svg>', a.svg_prev_btn = '<svg class="svg-icon" version="1.1" id="Layer_2" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="14px" height="14px" viewBox="0 0 12.5 12.817" enable-background="new 0 0 12.5 12.817" xml:space="preserve"> <g> <g> <g> <path fill="#D2D6DB" d="M2.581,7.375c-0.744-0.462-1.413-0.94-1.486-1.061C1.021,6.194,1.867,5.586,2.632,5.158l2.35-1.313 c0.765-0.427,1.505-0.782,1.646-0.789s0.257,1.03,0.257,1.905V7.87c0,0.876-0.051,1.692-0.112,1.817 C6.711,9.81,5.776,9.361,5.032,8.898L2.581,7.375z"/> </g> </g> </g> <g> <g> <g> <path fill="#D2D6DB" d="M6.307,7.57C5.413,7.014,4.61,6.441,4.521,6.295C4.432,6.15,5.447,5.42,6.366,4.906l2.82-1.577 c0.919-0.513,1.809-0.939,1.979-0.947s0.309,1.236,0.309,2.288v3.493c0,1.053-0.061,2.033-0.135,2.182S10.144,9.955,9.25,9.4 L6.307,7.57z"/> </g> </g> </g> </svg>', a.svg_next_btn = '<svg class="svg-icon" version="1.1" id="Layer_2" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="14px" height="14px" viewBox="0 0 12.5 12.817" enable-background="new 0 0 12.5 12.817" xml:space="preserve"> <g> <g> <g> <path fill="#D2D6DB" d="M9.874,5.443c0.744,0.462,1.414,0.939,1.486,1.06c0.074,0.121-0.771,0.729-1.535,1.156L7.482,8.967 C6.719,9.394,5.978,9.75,5.837,9.756C5.696,9.761,5.581,8.726,5.581,7.851V4.952c0-0.875,0.05-1.693,0.112-1.816 c0.062-0.124,0.995,0.326,1.739,0.788L9.874,5.443z"/> </g> </g> </g> <g> <g> <g> <path fill="#D2D6DB" d="M6.155,5.248c0.893,0.556,1.696,1.129,1.786,1.274c0.088,0.145-0.928,0.875-1.847,1.389l-2.811,1.57 c-0.918,0.514-1.808,0.939-1.978,0.947c-0.169,0.008-0.308-1.234-0.308-2.287V4.66c0-1.052,0.061-2.034,0.135-2.182 s1.195,0.391,2.089,0.947L6.155,5.248z"/> </g> </g> </g> </svg>', a.svg_menu_state = '<svg class="svg-icon" version="1.1" id="Layer_2" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="13.25px" height="13.915px" viewBox="0 0 13.25 13.915" enable-background="new 0 0 13.25 13.915" xml:space="preserve"> <path d="M1.327,4.346c-0.058,0-0.104-0.052-0.104-0.115V2.222c0-0.063,0.046-0.115,0.104-0.115H11.58 c0.059,0,0.105,0.052,0.105,0.115v2.009c0,0.063-0.046,0.115-0.105,0.115H1.327z"/> <path d="M1.351,8.177c-0.058,0-0.104-0.051-0.104-0.115V6.054c0-0.064,0.046-0.115,0.104-0.115h10.252 c0.058,0,0.105,0.051,0.105,0.115v2.009c0,0.063-0.047,0.115-0.105,0.115H1.351z"/> <path d="M1.351,12.182c-0.058,0-0.104-0.05-0.104-0.115v-2.009c0-0.064,0.046-0.115,0.104-0.115h10.252 c0.058,0,0.105,0.051,0.105,0.115v2.009c0,0.064-0.047,0.115-0.105,0.115H1.351z"/> </svg>', a.svg_embed_button = ' <svg class="svg-icon" version="1.1" id="Layer_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="10.975px" height="14.479px" viewBox="0 0 10.975 14.479" enable-background="new 0 0 10.975 14.479" xml:space="preserve"> <g> <path d="M2.579,1.907c0.524-0.524,1.375-0.524,1.899,0l4.803,4.804c0.236-0.895,0.015-1.886-0.687-2.587L5.428,0.959 c-1.049-1.05-2.75-1.05-3.799,0L0.917,1.671c-1.049,1.05-1.049,2.751,0,3.801l3.167,3.166c0.7,0.702,1.691,0.922,2.587,0.686 L1.867,4.52c-0.524-0.524-0.524-1.376,0-1.899L2.579,1.907z M5.498,13.553c1.05,1.05,2.75,1.05,3.801,0l0.712-0.713 c1.05-1.05,1.05-2.75,0-3.8L6.843,5.876c-0.701-0.7-1.691-0.922-2.586-0.686l4.802,4.803c0.524,0.525,0.524,1.376,0,1.897 l-0.713,0.715c-0.523,0.522-1.375,0.522-1.898,0L1.646,7.802c-0.237,0.895-0.014,1.886,0.686,2.586L5.498,13.553z"/> </g> </svg> ', a.playbtn_svg = '<svg class="svg-icon" version="1.2" baseProfile="tiny" id="Layer_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="30px" viewBox="0 0 25 30" xml:space="preserve"> <path d="M24.156,13.195L2.406,0.25C2.141,0.094,1.867,0,1.555,0C0.703,0,0.008,0.703,0.008,1.562H0v26.875h0.008 C0.008,29.297,0.703,30,1.555,30c0.32,0,0.586-0.109,0.875-0.266l21.727-12.93C24.672,16.375,25,15.727,25,15 S24.672,13.633,24.156,13.195z"/> </svg>', a.svg_share_icon = '<svg class="svg-icon" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 511.626 511.627" style="enable-background:new 0 0 511.626 511.627;" xml:space="preserve"> <g> <path d="M506.206,179.012L360.025,32.834c-3.617-3.617-7.898-5.426-12.847-5.426s-9.233,1.809-12.847,5.426 c-3.617,3.619-5.428,7.902-5.428,12.85v73.089h-63.953c-135.716,0-218.984,38.354-249.823,115.06C5.042,259.335,0,291.03,0,328.907 c0,31.594,12.087,74.514,36.259,128.762c0.57,1.335,1.566,3.614,2.996,6.849c1.429,3.233,2.712,6.088,3.854,8.565 c1.146,2.471,2.384,4.565,3.715,6.276c2.282,3.237,4.948,4.859,7.994,4.859c2.855,0,5.092-0.951,6.711-2.854 c1.615-1.902,2.424-4.284,2.424-7.132c0-1.718-0.238-4.236-0.715-7.569c-0.476-3.333-0.715-5.564-0.715-6.708 c-0.953-12.938-1.429-24.653-1.429-35.114c0-19.223,1.668-36.449,4.996-51.675c3.333-15.229,7.948-28.407,13.85-39.543 c5.901-11.14,13.512-20.745,22.841-28.835c9.325-8.09,19.364-14.702,30.118-19.842c10.756-5.141,23.413-9.186,37.974-12.135 c14.56-2.95,29.215-4.997,43.968-6.14s31.455-1.711,50.109-1.711h63.953v73.091c0,4.948,1.807,9.232,5.421,12.847 c3.62,3.613,7.901,5.424,12.847,5.424c4.948,0,9.232-1.811,12.854-5.424l146.178-146.183c3.617-3.617,5.424-7.898,5.424-12.847 C511.626,186.92,509.82,182.636,506.206,179.012z" fill="#696969"/> </g></svg> ', a.pausebtn_svg = '<svg class="svg-icon" version="1.1" id="Layer_3" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" width="12px" height="13px" viewBox="0 0 13.415 16.333" enable-background="new 0 0 13.415 16.333" xml:space="preserve"> <path fill="#D2D6DB" d="M4.868,14.59c0,0.549-0.591,0.997-1.322,0.997H2.2c-0.731,0-1.322-0.448-1.322-0.997V1.618 c0-0.55,0.592-0.997,1.322-0.997h1.346c0.731,0,1.322,0.447,1.322,0.997V14.59z"/> <path fill="#D2D6DB" d="M12.118,14.59c0,0.549-0.593,0.997-1.324,0.997H9.448c-0.729,0-1.322-0.448-1.322-0.997V1.619 c0-0.55,0.593-0.997,1.322-0.997h1.346c0.731,0,1.324,0.447,1.324,0.997V14.59z"/> </svg>'
            },
            217: (e, a, t) => {
                "use strict";
                t.r(a), t.d(a, {
                    hide_comments_writer: () => o,
                    comments_setupCommentsInitial: () => r,
                    comments_setupCommentsHolder: () => l,
                    comments_handleClickCommentsBg: () => _,
                    comments_handleClickCancel: () => c,
                    comments_handleClickSubmit: () => u,
                    comments_selector_event: () => m
                });
                var i = t(586);
                const s = t(891),
                    n = t(401),
                    o = function(e) {
                        var a = jQuery;
                        e.cthis.removeClass("comments-writer-active"), e._commentsHolder.find(".dzstooltip-con.placeholder").remove(), e.$commentsWritter.removeClass("active"), e.$commentsWritter.css({
                            height: 0
                        }), e.initOptions.parentgallery && void 0 !== a(e.initOptions.parentgallery).get(0) && void 0 !== a(e.initOptions.parentgallery).get(0).api_handleResize && a(e.initOptions.parentgallery).get(0).api_handleResize(), setTimeout((function() {
                            e.cthis.find(".comments-writter-temp-css,.dzsap-style-comments").remove()
                        }), 300)
                    },
                    r = function(e) {
                        jQuery;
                        var a = e.initOptions;
                        e.cthis.find(".the-comments").length > 0 && e.cthis.find(".the-comments").eq(0).children().length > 0 && (e.$commentsChildren = e.cthis.find(".the-comments").eq(0).children());
                        var t = '<div class="comments-holder">';
                        a.skinwave_comments_links_to ? t += '<a href="' + a.skinwave_comments_links_to + '" target="_blank" class="the-bg"></a>' : t += '<div class="the-comments-holder-bg"><div class="the-avatar comments-avatar--placeholder"></div></div>', t += '</div><div class="clear"></div><div class="dzstooltip dzstooltip--comments-writer    talign-center arrow-top style-rounded color-dark-light    dims-set transition-slidedown " style="width: 330px;">  <div class="dzstooltip--inner"><div class="comments-writer"><div class="comments-writer-inner">\n<div class="comments-writer--form">\n\n                <div class="dzsap-comments--section">\n\n                  <textarea name="comment-text" placeholder="Your comment.." type="text" class="comment-input"></textarea>\n\n                </div>\n                <div class="dzsap-comments--section">\n                  <input placeholder="Your email.." name="comment-email" type="text" class="comment-input">\n                </div>\n                <div class="dzsap-comments--section overflow-and-fixed  ">\n\n                  <div class="flex-grow-1   "><span\n                    class="dzsap-comments--comment-form-label">commenting on </span> <span\n                    class="dzsap-comments--comment-form-label-time">1:07</span></div>\n                  <div class="flex-grow-0 margin-left-auto"><button class="submit-ap-comment dzs-button-dzsap float-right">&#10148; Submit</button></div>\n                  <div class="clear"></div>\n\n                </div>\n              </div>\n\n              <div class="comments-writer--avatar-con">\n                <div class="comments-writer--avatar" style=""></div>\n              </div>\n              </div></div><span class="dzstooltip--close"><span\n              class="label--x-button">&#10006;</span></span></div></div>', e._scrubbar.appendOnce(t), e._commentsHolder = e.cthis.find(".comments-holder").eq(0), e.$commentsWritter = e.cthis.find(".dzstooltip--comments-writer").eq(0);
                        var i = this;
                        this.comments_setupCommentsHolder(e, {
                            call_from: "default"
                        }), e._commentsHolder.on("click", (function(a) {
                            i.comments_handleClickCommentsBg(e, this, a)
                        })), e._commentsHolder.on("mousemove", (function(a) {
                            e._commentsHolder.find(".comments-avatar--placeholder").css("left", n.getRelativeX(a.pageX, a.currentTarget) - 7 + "px")
                        })), e.$commentsWritter.find(".dzstooltip--close").bind("click", (a => {
                            i.comments_handleClickCancel(e, a)
                        })), e.$commentsWritter.find(".submit-ap-comment").bind("click", (a => {
                            i.comments_handleClickSubmit(e, a)
                        }))
                    },
                    l = function(e) {
                        var a = jQuery,
                            t = e.initOptions;
                        e._commentsHolder && e.$commentsChildren && e.$commentsChildren.each((function() {
                            var i = a(this);
                            "on" === t.skinwave_comments_process_in_php && i && i.hasClass && i.hasClass("dzstooltip-con") && (i.find(".dzstooltip > .dzstooltip--inner").length || (i.find(".dzstooltip").wrapInner('<div class="dzstooltip--inner"></div>'), i.find(".the-avatar").addClass("tooltip-indicator"), i.find(".dzstooltip").before(i.find(".tooltip-indicator")), i.find(".dzstooltip").addClass("talign-start style-rounded color-dark-light"))), e._commentsHolder.append(i)
                        }))
                    };

                function d(e, a) {
                    e.timeModel.getVisualTotalTime() ? e.$commentsWritter.find(".dzsap-comments--comment-form-label-time").html(i.formatTime(a * e.timeModel.getVisualTotalTime())) : setTimeout((() => {
                        d(e, a)
                    }), 100)
                }
                const _ = function(e, a, t) {
                        var i = jQuery,
                            s = e.initOptions,
                            n = i(a),
                            o = parseInt(t.clientX, 10) - n.offset().left;
                        let r = o / n.width();
                        if (e.commentPositionPerc = `calc(${100*r}% - 7px)`, d(e, r), !s.skinwave_comments_links_to) {
                            if (!("off" !== s.skinwave_comments_allow_post_if_not_logged_in || window.dzsap_settings && window.dzsap_settings.comments_username)) return !1;
                            var l = !0;
                            if (e._commentsHolder.children().each((function() {
                                    var a = i(this);
                                    if (!a.hasClass("placeholder") && !a.hasClass("the-bg")) {
                                        var t = a.offset().left - n.offset().left;
                                        return Math.abs(t - o) < 20 ? (e._commentsHolder.find(".dzstooltip-con.placeholder").remove(), l = !1, !1) : void 0
                                    }
                                })), !l) return !1;
                            e.$commentsWritter.css({
                                    left: o + "px"
                                }), e.$commentsWritter.css("top", parseInt(e._commentsHolder.css("top"), 10) + 20 + "px"), !1 === e.$commentsWritter.hasClass("active") && (e.$commentsWritter.addClass("active"), e.cthis.addClass("comments-writer-active")), window.dzsap_settings && window.dzsap_settings.comments_username ? e.cthis.find("input[name=comment-email]").remove() : e.$commentsWritter.find(".comments-writer--avatar-con").remove(),
                                function(e) {
                                    var a = "";
                                    window.dzsap_settings && window.dzsap_settings.comments_avatar && (a = window.dzsap_settings.comments_avatar), e._commentsHolder.remove(".dzsap-style-comments"), e._commentsHolder.append('<style class="dzsap-style-comments">.dzstooltip-con:not(.placeholder) { opacity: 0.5; }</style>'), e._commentsHolder.find(".dzstooltip-con.placeholder").remove(), e._commentsHolder.append('<span class="dzstooltip-con placeholder" style="left:' + e.commentPositionPerc + ';"><div class="the-avatar" style="background-image: url(' + a + ')"></div></span>')
                                }(e)
                        }
                    },
                    c = function(e, a) {
                        this.hide_comments_writer(e)
                    };

                function p(e, a, t, i) {
                    var n = jQuery,
                        r = e.initOptions,
                        l = "";
                    if (t) {
                        if (0 == /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(t)) return alert("please insert email, your email is just used for gravatar. it will not be sent or stored anywhere"), !1;
                        l = String(t).split("@")[0], e.$commentsSelector && e.$commentsSelector.find("*[name=comment_email],*[name=comment_user]").remove(), window.dzsap_settings || (window.dzsap_settings = {}), window.dzsap_settings.comments_username = l, window.dzsap_settings.comments_avatar = "https://secure.gravatar.com/avatar/" + window.MD5(String(e.cthis.find("input[name=comment-email]").eq(0).val()).toLowerCase()) + "?s=20"
                    }
                    var d = "";
                    d += a, e.cthis.find("*[name=comment-text]").eq(0).val(""), e.cthis.find(".comments-writter-temp-css,.dzsap-style-comments").remove(), s.ajax_comment_publish.bind(e)(d), o(e), r.parentgallery && null != n(r.parentgallery).get(0) && null != n(r.parentgallery).get(0).api_player_commentSubmitted && n(r.parentgallery).get(0).api_player_commentSubmitted()
                }
                const u = function(e, a) {
                        var t = "";
                        return e.cthis.find("input[name=comment-email]").length && (t = e.cthis.find("input[name=comment-email]").eq(0).val()), p(e, e.cthis.find("*[name=comment-text]").eq(0).val(), t), !1
                    },
                    m = function(e, a) {
                        var t = jQuery(this),
                            i = null;
                        if (console.log("_t - ", t), t.parent().parent().hasClass("zoomsounds-comment-wrapper") && (i = t.parent().parent()), t.parent().parent().parent().hasClass("zoomsounds-comment-wrapper") && (i = t.parent().parent().parent()), "focusin" == a.type && (e.timeCurrent, e.timeTotal, e._commentsHolder.width(), e.commentPositionPerc = `calc(${e.timeCurrent/e.timeTotal*100}% - 7px)`, i.addClass("active"), this.add_comments_placeholder(e)), a.type, "click" == a.type && (t.hasClass("dzstooltip--close") && (i.removeClass("active"), i.find("input").val("")), t.hasClass("comments-btn-submit"))) {
                            var s = "";
                            return i.find(".comment_email").length && (s = i.find(".comment_email").eq(0).val()), p(e, i.find(".comment_text").eq(0).val(), s), i.removeClass("active"), i.find("input").val(""), !1
                        }
                    }
            },
            349: (e, a, t) => {
                "use strict";
                t.r(a), t.d(a, {
                    setup_structure: () => d,
                    setup_structure_extras: () => l
                });
                var i = t(586);
                window.dzsap_moving_playlist_item = !1, window.dzsap_playlist_con = null, window.dzsap_playlist_item_moving = null, window.dzsap_playlist_item_target = null;
                const s = t(560);
                class n {
                    constructor(e) {
                        this.dzsapClass = e, this.$playlistInner = null
                    }
                    init() {
                        var e = this.dzsapClass,
                            a = this;

                        function t(e) {
                            var t = jQuery(this);
                            if ("click" === e.type && t.hasClass("playlist-menu-item")) {
                                var i = t.parent().children().index(t);
                                a.playlistInner_gotoItem(i, {
                                    call_from: "handle_mouse"
                                })
                            }
                            if ("mousedown" === e.type) {
                                var s = t.parent();
                                s.parent().append(s.clone().addClass("cloner"));
                                var n = s.parent().children(".cloner").eq(0);
                                dzsap_playlist_con = s.parent(), dzsap_moving_playlist_item = !0, dzsap_playlist_item_target = s, dzsap_playlist_item_moving = n, s.addClass("target-playlist-item")
                            }
                        }
                        e._apControlsRight.append('<div class="btn-footer-playlist for-hover dzstooltip-con player-but"> <div class="tooltip-indicator tooltip-indicator--btn-footer-playlist"><div class="the-icon-bg"></div> ' + s.svg_footer_playlist + '    </div><div class="dzstooltip playlist-tooltip style-default color-light-dark arrow-bottom talign-end transition-scaleup active2"><div class="dzstooltip--inner"> </div></div></div>'), a.$playlistInner = e.cthis.find(".playlist-tooltip"), e.cthis.on("mousedown", ".the-sort-handle", t), e.cthis.on("click", ".playlist-menu-item", t), setTimeout((function() {
                            a.playlistInner_setupStructureInPlayer()
                        }), 100), setTimeout((function() {}), 1e3)
                    }
                    playlistInner_setupStructureInPlayer(e) {
                        var a = jQuery,
                            t = this,
                            i = (this.dzsapClass, {
                                call_from: "default"
                            });
                        if (e && (i = a.extend(i, e)), t.$playlistInner) {
                            window.dzsap_syncList_players.length ? t.$playlistInner.parent().removeClass("is-empty") : t.$playlistInner.parent().addClass("is-empty"), t.$playlistInner.find(".dzstooltip--inner").html("");
                            var s = "";
                            for (var n in window.dzsap_syncList_players) {
                                var o = window.dzsap_syncList_players[n];
                                o.hasClass("number-wrapper") || o.hasClass("for-number-wrapper") || (s += '<div class="playlist-menu-item"', a.each(o.get(0).attributes, (function() {
                                    this.specified && this.name && "id" !== this.name && "style" !== this.name && (s += " " + this.name + "='" + this.value + "'")
                                })), s += ">", o.attr("data-thumb") && (s += '<div class="pi-thumb-con">', s += '<div class="pi-thumb divimage" style="background-image: url(' + o.attr("data-thumb") + ')">', s += "</div>", s += "</div>"), s += '<div class="pi-meta-con">', s += '<div class="pi-the-artist">', s += o.find(".the-artist").eq(0).text(), s += "</div>", s += '<div class="pi-the-name">', s += o.find(".the-name").eq(0).text(), s += "</div>", s += "</div>", s += '<div class="the-sort-handle">', s += "&#x2195;", s += "</div>", s += "</div>")
                            }
                            t.$playlistInner.find(".dzstooltip--inner").append(s), a(document).on("mousemove.dzsap_playlist_item", (function(e) {
                                if (window.dzsap_moving_playlist_item) {
                                    var t = e.clientY;
                                    t -= dzsap_playlist_con.offset().top, dzsap_playlist_item_moving.css("top", t - 20), dzsap_playlist_item_target.parent().children(':not(".target-playlist-item"):not(".cloner")').each((function() {
                                        var e = a(this),
                                            i = e.offset().top - dzsap_playlist_con.offset().top;
                                        t > i && e.after(dzsap_playlist_item_target)
                                    })), t < 50 && dzsap_playlist_item_target.parent().prepend(dzsap_playlist_item_target)
                                }
                            })), a(document).on("mouseup.dzsap_playlist_item", (function(e) {
                                window.dzsap_moving_playlist_item && (window.dzsap_moving_playlist_item = !1, dzsap_playlist_item_moving.parent().children(".cloner").remove(), dzsap_playlist_item_target.removeClass("target-playlist-item"), dzsap_playlist_item_moving.remove(), dzsap_playlist_item_moving = null, dzsap_playlist_item_target = null)
                            }))
                        } else console.error("no tooltip .. why, should be here?")
                    }
                    player_determineSyncPlayersIndex(e, a) {
                        if (this.$playlistInner) {
                            var t = this.$playlistInner.children(".dzstooltip--inner").eq(0);
                            t.children().removeClass("current-playlist-item"), t.children().each((function() {
                                var t = jQuery(this);
                                console.log(t.attr("data-playerid"), a.attr("data-playerid")), t.attr("data-playerid") === a.attr("data-playerid") && (t.addClass("current-playlist-item"), e.playlist_inner_currNr = t.parent().children().index(t))
                            }))
                        }
                    }
                    playlistInner_gotoItem(e, a) {
                        var t = jQuery,
                            i = this.dzsapClass,
                            s = {
                                call_from: "default"
                            };
                        if (a && (s = t.extend(s, a)), this.$playlistInner) {
                            var n = this.$playlistInner.find(".dzstooltip--inner").children().eq(e).attr("data-playerid"),
                                o = t('.audioplayer[data-playerid="' + n + '"],.audioplayer-tobe[data-playerid="' + n + '"]');
                            if (n && o.length && o.eq(0).get(0) && o.eq(0).get(0).api_play_media) t('.audioplayer[data-playerid="' + n + '"]').eq(0).get(0).api_play_media({
                                called_from: "api_sync_players_prev"
                            });
                            else if (o.parent().parent().parent().hasClass("audiogallery")) o.parent().parent().parent().get(0).api_goto_item(e);
                            else {
                                var r = t(".dzsap_footer");
                                r.length && r.get(0).api_change_media && r.get(0).api_change_media(o)
                            }
                            i.playlist_inner_currNr = e
                        }
                    }
                }
                const o = t(560),
                    r = t(891);

                function l(e, a) {
                    "skin-wave" === a.design_skin && "bigwavo" === e.skinwave_mode && (e._audioplayerInner.after(e._scrubbar), e.cthis.find(".feed-description") && (e.$conControls.after(e.cthis.find(".feed-description").eq(0)), e.$conControls.next().removeClass("feed-description").addClass("song-desc"))), e.radio_isGoingToUpdateSongName = i.player_radio_isNameUpdatable(e, e.radio_isGoingToUpdateSongName, ".the-songname"), e.radio_isGoingToUpdateArtistName = i.player_radio_isNameUpdatable(e, e.radio_isGoingToUpdateArtistName, ".the-artist"), "on" === a.disable_scrub && e.cthis.addClass("disable-scrubbar");
                    const t = `<div class="btn-embed-code-con dzstooltip-con "><div class="btn-embed-code player-but "> <div class="the-icon-bg"></div>${o.svg_embed_btn}</div><span class="dzstooltip   transition-slidein arrow-bottom talign-end style-rounded color-dark-light " style="width: 350px; "><span class="dzstooltip--inner"><span class="embed-code--text"></span></span></span></div>`;
                    "" !== e.feedEmbedCode && function(e, a, t, i) {
                        var s = e.initOptions;
                        "skin-wave" === s.design_skin ? "on" === s.enable_embed_button && e._apControlsRight && (e._apControlsRight.appendOnce(i), e.$embedButton = e._apControlsRight.find(".btn-embed-code-con").eq(0), e.$embedButton.find(".btn-embed-code").addClass("player-but")) : "on" === s.enable_embed_button && (e._audioplayerInner.appendOnce(i), e.$embedButton = e._audioplayerInner.find(".btn-embed-code-con").eq(0)), e.$embedButton && e.$embedButton.find(".embed-code--text").html(e.feedEmbedCode), e.cthis.on("click", ".btn-embed-code-con, .btn-embed", (function() {
                            var e = a(this);
                            t.select_all(e.find(".dzstooltip").get(0)), document.execCommand("copy")
                        })), e.cthis.on("click", ".copy-embed-code-btn", (function() {
                            var e = a(this);
                            t.select_all(e.parent().parent().find(".dzstooltip--inner > span").get(0)), document.execCommand("copy"), setTimeout((function() {
                                t.select_all(e.get(0))
                            }), 100)
                        }))
                    }(e, jQuery, i, t), "on" === a.footer_btn_playlist && 0 === e._apControlsRight.find(".btn-footer-playlist").length && (e.classFunctionalityInnerPlaylist = new n(e), e.classFunctionalityInnerPlaylist.init()), setTimeout((function() {
                        e.cthis.find(".extra-html").length && function(e, a) {
                            e.initOptions, 1 === e.increment_views && (a.ajax_submit_views.bind(e)(), e.increment_views = 2), 0 === e.index_extrahtml_toloads && e.cthis.find(".extra-html").addClass("active"), setTimeout((function() {
                                e.cthis.find(".extra-html").addClass("active"), 0 === e.cthis.find(".float-left").length ? e.cthis.find(".extra-html").append(e.cthis.find(".extra-html-extra")) : e.cthis.find(".extra-html .float-left").append(e.cthis.find(".extra-html-extra")), e.cthis.find(".extra-html-extra").children().eq(0), e.cthis.find(".extra-html-extra").children().unwrap()
                            }), 2e3)
                        }(e, r)
                    }), 100), setTimeout((function() {
                        e.cthis.html().indexOf("dzsap-multisharer-but") > -1 && (e.isMultiSharer = !0, e.check_multisharer())
                    }), 1002), e.cthis.find(".con-after-playpause").length && e.$conPlayPause.after(e.cthis.find(".con-after-playpause").eq(0)), e.cthis.find(".afterplayer").length > 0 && e.cthis.append(e.cthis.find(".afterplayer"))
                }
                const d = function(e, a) {
                    var t = jQuery,
                        s = e.initOptions,
                        n = {
                            setup_inner_player: !0,
                            setup_media: !0,
                            setup_otherstructure: !0,
                            call_from: "default"
                        };
                    a && (n = t.extend(n, a)), "reconstruct" === n.call_from && (e._metaArtistCon, e._metaArtistCon = null, e.cthis.hasClass("skin-wave") && (s.design_skin = "skin-wave"), e.cthis.hasClass("skin-silver") && (s.design_skin = "skin-silver"));
                    var r = '<div class="ap-controls';
                    if ("skin-default" === s.design_skin && (r += " dzsap-color_inverse_ui_fill"), r += '"></div>', n.setup_inner_player && (e.cthis.appendOnce('<div class="audioplayer-inner"></div>'), e._audioplayerInner = e.cthis.children(".audioplayer-inner")), !n.setup_otherstructure) return !1;
                    e.cthis.attr("data-wrapper-image") && function(e) {
                        var a = new Image;
                        !1 === e.cthis.hasClass("zoomsounds-no-wrapper") && (a.onload = function() {
                            e.cthis.css("background-image", "url(" + this.src + ")"), setTimeout((function() {
                                e.cthis.find(".zoomsounds-bg").addClass("loaded"), e.cthis.hasClass("zoomsounds-wrapper-bg-bellow") && e.cthis.css("padding-top", 200)
                            }), 100)
                        }, a.src = e.cthis.attr("data-wrapper-image"))
                    }(e);
                    var d, c = '<div class="scrubbar">',
                        p = "";
                    c += '<div class="scrub-bg"></div><div class="scrub-buffer"></div>', c += '<div class="scrub-prog', "wave" !== s.scrubbar_type && (c += " dzsap-color_brand_bg"), c += '"></div><div class="scrubBox"></div><div class="scrubBox-prog"></div><div class="scrubBox-hover"></div>', d = '<div class="total-time">00:00</div><div class="curr-time">00:00</div>', e.sample_perc_start && (c += '<div class="sample-block-start" style="width: ' + 100 * e.sample_perc_start + '%"></div>'), e.sample_perc_end && (c += '<div class="sample-block-end" style="left: ' + 100 * e.sample_perc_end + "%; width: " + (100 - 100 * e.sample_perc_end) + '%"></div>'), c += "</div>", s.controls_external_scrubbar && (c = "");
                    var u = "";
                    p += '<div class="con-controls"><div class="the-bg"></div>' + (u += function(e) {
                        var a = e.initOptions;
                        let t = "";
                        return a.settings_extrahtml_before_play_pause && (t += a.settings_extrahtml_before_play_pause), t += '<div class="con-playpause-con">', t = _(e, ".feed-dzsap-before-playpause", t) + t, t += '<div class="con-playpause', "on" === e.keyboard_controls.show_tooltips && (t += " dzstooltip-con"), t += '">', "on" === e.keyboard_controls.show_tooltips && (t += i.dzsap_generate_keyboard_tooltip(e.keyboard_controls, "pause_play")), t += '<div class="playbtn player-but" aria-controls="' + e.uniqueId + '-audio"><div class="the-icon-bg"></div><div class="dzsap-play-icon">', t += o.playbtn_svg, t += "</div>", t += "</div>", t += '<div class="pausebtn player-but"', t += '><div class="the-icon-bg"></div><div class="pause-icon">', t += o.pausebtn_svg, t += "</div>", t += "</div>", t += "", t += "</div>", t += _(e, ".feed-dzsap-after-playpause", t), t += "</div>", t
                    }(e)), e.extraHtmlAreas.controlsLeft && (p += e.extraHtmlAreas.controlsLeft), "skin-pro" === s.design_skin && (p += '<div class="con-controls--right">', p += "</div>");
                    var m = '<div class="controls-volume"><div class="volumeicon"></div><div class="volume_static"></div><div class="volume_active"></div><div class="volume_cut"></div></div>';
                    if ("on" === s.disable_volume && (m = ""), "skin-default" !== s.design_skin && "skin-wave" !== s.design_skin || (p += '<div class="ap-controls-right">', "on" !== s.disable_volume && (p += '<div class="controls-volume"><div class="volumeicon"></div><div class="volume_static"></div><div class="volume_active"></div><div class="volume_cut"></div></div>'), p += "</div>"), p += "</div>", "skin-wave" === s.design_skin && "small" === e.skinwave_mode) p = '<div class="the-bg"></div><div class="ap-controls-left">' + u + "</div>" + c + '<div class="ap-controls-right">' + m + '<div class="extrahtml-in-float-right for-skin-wave-small">' + e.extraHtmlAreas.controlsRight + "</div></div>";
                    else if ("skin-aria" === s.design_skin || "skin-silver" === s.design_skin || "skin-redlights" === s.design_skin || "skin-steel" === s.design_skin) {
                        let a = o.playbtn_svg,
                            t = o.pausebtn_svg;
                        "skin-steel" === s.design_skin && (a = "", t = ""), p = '<div class="the-bg"></div><div class="ap-controls-left">', "skin-silver" === s.design_skin ? p += u : (p += '<div class="con-playpause', "on" === e.keyboard_controls.show_tooltips && (p += " dzstooltip-con"), p += '">', "on" === e.keyboard_controls.show_tooltips && (p += i.dzsap_generate_keyboard_tooltip(e.keyboard_controls, "pause_play")), p += '<div class="playbtn player-but playbtn-not-skin-silver"><div class="dzsap-play-icon">' + a + '</div></div><div class="pausebtn player-but" ', p += '><div class="pause-icon">' + t + "</div></div></div>"), _(e, ".feed-dzsap-after-playpause", u), p += "</div>", e.extraHtmlAreas.controlsRight && (p += '<div class="controls-right">' + e.extraHtmlAreas.controlsRight + "</div>", "skin-redlights" === s.design_skin && s.parentgallery && s.parentgallery.get(0).api_skin_redlights_give_controls_right_to_all && s.parentgallery.get(0).api_skin_redlights_give_controls_right_to_all()), p += '<div class="ap-controls-right">', "skin-silver" === s.design_skin ? (p += '<div class="controls-volume controls-volume-vertical"><div class="volumeicon"></div><div class="volume-holder"><div class="volume_static"></div><div class="volume_active"></div><div class="volume_cut"></div></div></div>', p += "</div>" + c) : ("skin-redlights" === s.design_skin && "on" != s.disable_volume && (p += '<div class="controls-volume"><div class="volumeicon"></div><div class="volume_static"></div><div class="volume_active"></div><div class="volume_cut"></div></div>'), p += c, "on" != s.disable_timer && (p += '<div class="total-time">00:00</div>')), "skin-silver" === s.design_skin || (p += "</div>")
                    }
                    if (n.setup_media && (e._audioplayerInner.append('<div class="the-media"></div>'), e.$theMedia = e._audioplayerInner.children(".the-media").eq(0)), "skin-customcontrols" !== s.design_skin && e._audioplayerInner.append(r), e._apControls = e._audioplayerInner.children(".ap-controls").eq(0), e._apControls.append(p), e.cthis.hasClass("skin-wave-mode-alternate") ? 0 === e.cthis.find(".scrubbar").length && e._apControls.append(c) : 0 === e.cthis.find(".scrubbar").length && e._apControls.prepend(c), e._apControlsRight = null, e._apControls.find(".ap-controls-right").length > 0 && (e._apControlsRight = e.cthis.find(".ap-controls-right")), e._apControls.find(".ap-controls-left").length > 0 && (e._apControlsLeft = e._apControls.find(".ap-controls-left").eq(0)), "skin-pro" === s.design_skin && (e._apControlsRight = e.cthis.find(".con-controls--right").eq(0)), _(e, ".feed-dzsap--custom-controls", null, e._audioplayerInner), _(e, ".feed-dzsap-after-con-controls", null, e._apControls), s.controls_external_scrubbar ? e._scrubbar = t(s.controls_external_scrubbar).children(".scrubbar").eq(0) : e._scrubbar = e._apControls.find(".scrubbar").eq(0), e.$$scrubbProg = e._scrubbar.find(".scrub-prog").get(0), e.$conControls = e._apControls.children(".con-controls"), e.$conPlayPause = e.cthis.find(".con-playpause").eq(0), e._conPlayPauseCon = e.cthis.find(".con-playpause-con").eq(0), e.$controlsVolume = e.cthis.find(".controls-volume").eq(0), i.player_constructArtistAndSongCon.bind(e)(n), e._scrubbar.addClass("scrubbar-inited"), "wave" === s.scrubbar_type && "on" != s.disable_timer && "" === s.controls_external_scrubbar && e._scrubbar.append(d), "skin-wave" != s.design_skin && "on" != s.disable_timer && e._apControls.append(d), "on" != s.disable_timer && (e.$currTime = e.cthis.find(".curr-time").eq(0), e.$totalTime = e.cthis.find(".total-time").eq(0), "skin-steel" === s.design_skin && 0 === e.$currTime.length && (e.$totalTime.before('<div class="curr-time">00:00</div> <span class="separator-slash">/</span> '), e.$currTime = e.$totalTime.prev().prev())), Number(s.sample_time_total) > 0 && (e.timeTotal = Number(s.sample_time_total), e.$totalTime && e.$totalTime.html(i.formatTime(e.time_total_for_visual))), e.struct_generate_thumb(), "skin-wave" === s.design_skin && s.parentgallery && void 0 !== s.parentgallery && "on" === s.design_menu_show_player_state_button && ("skin-wave" === s.design_skin ? e._apControlsRight ? e._apControlsRight.appendOnce('<div class="btn-menu-state player-but" style="display: none;"> <div class="the-icon-bg"></div> ' + o.svg_menu_state + "    </div></div>") : console.log("selfClass._apControlsRight not found ? ") : e._audioplayerInner.appendOnce('<div class="btn-menu-state"></div>')), "on" === s.skinwave_place_metaartist_after_volume && e.$controlsVolume.before(e._metaArtistCon), "on" === s.skinwave_place_thumb_after_volume && e.$controlsVolume.before(e.cthis.find(".the-thumb-con")), "skin-wave" === s.design_skin && (e.setup_structure_scrub(), "on" === s.skinwave_timer_static && (e.$currTime && e.$currTime.addClass("static"), e.$totalTime && e.$totalTime.addClass("static")), e._apControls.css({}), "canvas" === s.skinwave_wave_mode && setTimeout((function() {
                            e.cthis.addClass("scrubbar-loaded"), e._scrubbar.parent().addClass("scrubbar-loaded")
                        }), 700)), e.check_multisharer(), e.cthis.hasClass("skin-minimal") && (e.cthis.find(".the-bg").before('<div class="skin-minimal-bg skin-minimal--outer-bg"></div><div class="skin-minimal-bg skin-minimal--inner-bg-under dzsap-color_brand_bg"></div><div class="skin-minimal-bg skin-minimal--inner-bg"></div><div class="skin-minimal-bg skin-minimal--inner-inner-bg dzsap-color_brand_bg"></div>'), e.cthis.find(".the-bg").append('<canvas width="100" height="100" class="playbtn-canvas"/>'), e.skin_minimal_canvasplay = e.cthis.find(".playbtn-canvas").eq(0).get(0), e.$conPlayPause && (e.$conPlayPause.children(".playbtn").append(o.playbtn_svg), e.$conPlayPause.children(".pausebtn").append(o.pausebtn_svg)), setTimeout((function() {
                            e.isCanvasFirstDrawn = !1
                        }), 200)), e.cthis.hasClass("skin-minion") && e.cthis.find(".menu-description").length > 0 && (e.$conPlayPause.addClass("with-tooltip"), e.$conPlayPause.prepend('<span class="dzstooltip" style="left:-7px;">' + e.cthis.find(".menu-description").html() + "</span>"), e.$conPlayPause.children("span").eq(0).css("width", e.$conPlayPause.children("span").eq(0).textWidth() + 10)), "default" === s.player_navigation && (s.parentgallery && (s.player_navigation = "on"), s.parentgallery && s.parentgallery.hasClass("mode-showall") && (s.player_navigation = "off")), "on" === s.disable_player_navigation && (s.player_navigation = "off"), "default" === s.player_navigation && (s.player_navigation = "off"), "on" === s.player_navigation) {
                        var h = '<div class="prev-btn player-but" style="display: none;"><div class="the-icon-bg"></div>' + o.svg_prev_btn + " </div>",
                            f = '<div class="next-btn player-but" style="display: none;"><div class="the-icon-bg"></div>' + o.svg_next_btn + "  </div>",
                            g = h + f;
                        "skin-wave" === s.design_skin && "small" === e.skinwave_mode || "skin-aria" === s.design_skin ? (e.$conPlayPause.before(h), e.$conPlayPause.after(f)) : "skin-wave" === s.design_skin ? "on" === s.player_navigation && (e._conPlayPauseCon.prependOnce(h, ".prev-btn"), e._conPlayPauseCon.appendOnce(f, ".next-btn")) : "skin-steel" === s.design_skin ? (e._apControlsLeft.prependOnce(h, ".prev-btn"), e._apControlsLeft.children(".the-thumb-con").length > 0 ? e._apControlsLeft.children(".the-thumb-con").eq(0).length > 0 && !1 === e._apControlsLeft.children(".the-thumb-con").eq(0).prev().hasClass("next-btn") && e._apControlsLeft.children(".the-thumb-con").eq(0).before(f) : e._apControlsLeft.appendOnce(f, ".next-btn")) : e._audioplayerInner.appendOnce(g, ".prev-btn")
                    }
                    e.cthis.hasClass("skinvariation-wave-bigtitles") && e.cthis.find(".controls-volume").length && 0 === e._metaArtistCon.find(".controls-volume").length && (e._metaArtistCon.append("<br>"), e._metaArtistCon.append(e.cthis.find(".controls-volume"))), e.cthis.hasClass("skinvariation-wave-righter") && (e._apControls.appendOnce('<div class="playbuttons-con"></div>'), e.cthis.find(".playbuttons-con").eq(0).append(e.cthis.find(".con-playpause-con"))), "skin-pro" === s.design_skin && (e._apControlsRight.append(e.$currTime), e._apControlsRight.append(e.$totalTime)), "skin-silver" === s.design_skin && (e._scrubbar.after(e._apControlsRight), e._apControlsLeft.prepend(e._metaArtistCon), e._apControlsLeft.append(e.$currTime), e._apControlsRight.append(e.$totalTime)), "skin-redlights" === s.design_skin && (e._apControlsRight.append('<div class="ap-controls-right--top"></div>'), e._apControlsRight.append('<div class="ap-controls-right--bottom"></div>'), e._apControlsRight.find(".ap-controls-right--top").append(e._apControlsRight.find(".meta-artist-con")), e._apControlsRight.find(".ap-controls-right--top").append(e._apControlsRight.find(".controls-volume")), e._apControlsRight.find(".ap-controls-right--bottom").append(e._apControlsRight.find(".scrubbar"))), "reconstruct" === n.call_from && e.cthis.hasClass("skin-silver") && e._apControlsLeft.append(e.cthis.find(".con-playpause")), e.isMultiSharer && e.check_multisharer(), e.setup_structure_sanitizers(), l(e, s), e.cthis.addClass("structure-setuped"), e.extraHtmlAreas.afterArtist && e._metaArtistCon.find(".the-artist").append(e.extraHtmlAreas.afterArtist), "" !== e.extraHtmlAreas.bottom && e.cthis.append('<div class="extra-html">' + e.extraHtmlAreas.bottom + "</div>");
                    var y = "";
                    String(e.extraHtmlAreas.controlsRight).indexOf("dzsap-multisharer-but") > -1 && (e.isMultiSharer = !0), "skin-wave" === s.design_skin && "small" === e.skinwave_mode || (y += '<div class="extrahtml-in-float-right from-setup_structure from-js-setup_structure">' + e.extraHtmlAreas.controlsRight + "</div>"), y && ("skin-wave" !== s.design_skin && "skin-default" !== s.design_skin || e.cthis.find(".ap-controls-right").eq(0).append(y), "skin-pro" === s.design_skin && e.cthis.find(".con-controls--right").eq(0).append(y))
                };

                function _(e, a, t = null, i = null) {
                    if (e.cthis.find(a).length) {
                        if (null !== t && (t += e.cthis.find(a).eq(0).html()), null !== i) return i.append(e.cthis.find(a).eq(0).html()), i;
                        if (e.cthis.find(a).remove(), null !== t) return t
                    }
                    return "string" == typeof t ? "" : null
                }
            },
            348: (e, a, t) => {
                "use strict";
                t.r(a), t.d(a, {
                    scrubModeWave__checkIfWeShouldTryToGetPcm: () => o,
                    view_drawCanvases: () => r,
                    scrubModeWave__view_transitionIn: () => l,
                    draw_canvas: () => d
                });
                var i = t(586),
                    s = t(567),
                    n = t(401);

                function o(e, a) {
                    var t = {
                        call_from: "default",
                        call_attempt: 0
                    };
                    if (a && (t = jQuery.extend(t, a)), window.dzsap_wavesurfer_is_trying_to_generate) return setTimeout((function() {
                        t.call_attempt++, t.call_attempt < 10 && (o(e, t), console.log("%c [dzsap] trying to regenerate ", s.O.DEBUG_STYLE_1, window.dzsap_wavesurfer_is_trying_to_generate))
                    }), 1e3), !1;
                    if (e.isPcmRequiredToGenerate && function(e) {
                            return !e.isAlreadyHasRealPcm && "fake" != e.data_source
                        }(e)) {
                        window.dzsap_wavesurfer_is_trying_to_generate = e, window.dzsap_get_base_url();
                        //let a = window.dzsap_base_url ? window.dzsap_base_url + "/parts/wavesurfer/dzsap-wave-generate.js" : s.O.URL_WAVESURFER_HELPER_BACKUP;
                        let a = "files/audioplayer1/parts/wavesurfer/dzsap-wave-generate.js";
                        window.scrubModeWave__view_transitionIn = l, n.loadScriptIfItDoesNotExist(a, window.scrubModeWave__initGenerateWaveData).then((a => {
                            scrubModeWave__initGenerateWaveData(e)
                        }))
                    }
                }

                function r(e, a, t) {
                    var i = e.initOptions;
                    d(e._scrubbarbg_canvas.get(0), a, "#" + i.design_wave_color_bg, {
                        call_from: t + "_bg",
                        selfClass: e,
                        skinwave_wave_mode_canvas_waves_number: parseInt(i.skinwave_wave_mode_canvas_waves_number, 10),
                        skinwave_wave_mode_canvas_waves_padding: parseInt(i.skinwave_wave_mode_canvas_waves_padding, 10)
                    }), d(e._scrubbarprog_canvas.get(0), a, "#" + i.design_wave_color_progress, {
                        call_from: t + "_prog",
                        selfClass: e,
                        skinwave_wave_mode_canvas_waves_number: parseInt(i.skinwave_wave_mode_canvas_waves_number, 10),
                        skinwave_wave_mode_canvas_waves_padding: parseInt(i.skinwave_wave_mode_canvas_waves_padding, 10)
                    }, !0)
                }

                function l(e, a) {
                    e._scrubbar.find(".scrub-bg-img,.scrub-prog-img").removeClass("transitioning-in"), e._scrubbar.find(".scrub-bg-img,.scrub-prog-img").addClass("transitioning-out"), i.scrubbar_modeWave_setupCanvas({
                        prepare_for_transition_in: !0
                    }, e), r(e, a, "canvas_generate_wave_data_animate_pcm"), setTimeout((() => {
                        i.scrubbar_modeWave_clearObsoleteCanvas(e)
                    }), 300), e.isAlreadyHasRealPcm = !0, e.scrubbar_reveal()
                }

                function d(e, a, t, s, n) {
                    var o = {
                            call_from: "default",
                            is_sample: !1,
                            selfClass: null,
                            sample_time_start: 0,
                            sample_time_end: 0,
                            sample_time_total: 0,
                            skinwave_wave_mode_canvas_waves_number: 2,
                            skinwave_wave_mode_canvas_waves_padding: 1
                        },
                        r = jQuery;
                    s && (o = Object.assign(o, s)), t = i.sanitizeToHexColor(t);
                    var l = r(e),
                        d = e;
                    let _ = !1;
                    var {
                        selfClass: c,
                        skinwave_wave_mode_canvas_waves_number: p,
                        skinwave_wave_mode_canvas_waves_padding: u
                    } = o;
                    if (isNaN(Number(p)) && (p = 2), isNaN(Number(u)) && (u = 1 !== p ? 1 : 0), c) var m = c.initOptions;
                    if (!l || !l.get(0)) return !1;
                    var h = l.get(0).getContext("2d"),
                        f = a,
                        g = [];
                    if (c && c._scrubbar && c._scrubbarprog_canvas && (c._scrubbarbg_canvas.width(c._scrubbar.width()), c._scrubbarprog_canvas.width(c._scrubbar.width()), e.width = c._scrubbar.width(), e.height = c._scrubbar.height()), h.imageSmoothingEnabled = !1, h.imageSmoothing = !1, h.imageSmoothingQuality = "high", h.webkitImageSmoothing = !1, !a) return setTimeout((function() {}), 1e3), !1;
                    if ("object" == typeof f) g = f;
                    else try {
                        g = JSON.parse(f)
                    } catch (e) {}
                    var y = 0,
                        v = 0;
                    for (y = 0; y < g.length; y++) g[y] > v && (v = g[y]);
                    var b, w, k = [];
                    for (y = 0; y < g.length; y++) k[y] = parseFloat(Math.abs(g[y]) / Number(v));
                    g = k;
                    var C = null;
                    c && (d.width = c._scrubbar.width()), b = d.width, w = d.height;
                    var T = p,
                        z = u;
                    1 == T && (T = b / T), 2 == T && (T = b / 2), 3 == T && (T = b / 3);
                    var x = parseFloat(m.skinwave_wave_mode_canvas_reflection_size);
                    b / T < 1 && (T = Math.ceil(T / 3));
                    var P = Math.ceil(b / T),
                        S = 1 - x;
                    0 == P && (P = 1, z = 0), 1 == P && (z /= 2);
                    var $ = 0,
                        O = null,
                        M = t;
                    M = M.replace("#", "");
                    var I = [];
                    M.indexOf(",") > -1 && (I = M.split(","));
                    var N = "",
                        q = "";
                    "spectrum" == o.call_from && (N = (N = m.design_wave_color_progress).replace("#", ""), q = [], N.indexOf(",") > -1 && (q = N.split(",")));
                    var A = !1;

                    function j(e = !1) {
                        for (y = 0; y < T; y++) {
                            _ = !1, h.save(), O = Math.ceil(y * (g.length / T)), y < T / 5 && g[O] < .1 && (g[O] = .1), g.length > 2.5 * T && y > 0 && y < g.length - 1 && (g[O] = Math.abs(g[O] + g[O - 1] + g[O + 1]) / 3);
                            let l = S;
                            e && (l = x);
                            var a = Math.abs(g[O] * w * l);
                            "on" == m.skinwave_wave_mode_canvas_normalize && (isNaN($) && ($ = 0), a = a / 1.5 + $ / 2.5), $ = a, h.lineWidth = 0, a = Math.floor(a);
                            var s = e ? w * S : Math.ceil(w * l - a);
                            if (h.beginPath(), h.rect(y * P, s, P - z, a), "spectrum" == o.call_from && (A = y / T < c.timeCurrent / c.timeTotal), c.isSample && (_ = (r = y) / T < c.timeModel.sampleTimeStart / c.timeModel.sampleTimeTotal || r / T > c.timeModel.sampleTimeEnd / c.timeModel.sampleTimeTotal), A) {
                                if (e && "reflecto" !== m.skinwave_wave_mode_canvas_mode ? h.fillStyle = i.hexToRgb(N, .25) : h.fillStyle = _ ? i.hexToRgb(N, .5) : "#" + N, q.length) {
                                    const a = e && "reflecto" !== m.skinwave_wave_mode_canvas_mode ? i.hexToRgb("#" + q[0], .25) : "#" + q[0],
                                        t = e && "reflecto" !== m.skinwave_wave_mode_canvas_mode ? i.hexToRgb("#" + q[1], .25) : "#" + q[1];
                                    (C = h.createLinearGradient(0, 0, 0, w)).addColorStop(0, a), C.addColorStop(1, t), h.fillStyle = C
                                }
                            } else if (e && "reflecto" !== m.skinwave_wave_mode_canvas_mode ? h.fillStyle = i.hexToRgb(t, .25) : h.fillStyle = _ ? i.hexToRgb(t, .5) : "" + t, I.length) {
                                const a = e && "reflecto" !== m.skinwave_wave_mode_canvas_mode ? i.hexToRgb(i.utils_sanitizeToColor(I[0]), .25) : "" + i.utils_sanitizeToColor(I[0]),
                                    t = e && "reflecto" !== m.skinwave_wave_mode_canvas_mode ? i.hexToRgb(i.utils_sanitizeToColor(I[1]), .25) : "" + i.utils_sanitizeToColor(I[1]);
                                (C = h.createLinearGradient(0, 0, 0, w)).addColorStop(0, a), C.addColorStop(1, t), h.fillStyle = C
                            }
                            _ && n || (h.fill(), h.closePath()), h.restore()
                        }
                        var r
                    }
                    h.clearRect(0, 0, b, w), j(), j(!0), setTimeout((function() {
                        c.scrubbar_reveal()
                    }), 100)
                }
                window.dzsap_wavesurfer_load_attempt = 0, window.dzsap_wavesurfer_is_trying_to_generate = null
            }
        },
        __webpack_module_cache__ = {};

    function __webpack_require__(e) {
        if (__webpack_module_cache__[e]) return __webpack_module_cache__[e].exports;
        var a = __webpack_module_cache__[e] = {
            exports: {}
        };
        return __webpack_modules__[e](a, a.exports, __webpack_require__), a.exports
    }
    __webpack_require__.d = (e, a) => {
        for (var t in a) __webpack_require__.o(a, t) && !__webpack_require__.o(e, t) && Object.defineProperty(e, t, {
            enumerable: !0,
            get: a[t]
        })
    }, __webpack_require__.o = (e, a) => Object.prototype.hasOwnProperty.call(e, a), __webpack_require__.r = e => {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }, (() => {
        "use strict";
        var e = __webpack_require__(586),
            a = __webpack_require__(401),
            t = __webpack_require__(567);
        const i = (e, a = "", t = "") => {
                if (e.$theMedia.children().remove(), t) {
                    if (!e.$mediaNode_) return i(e, a), !1;
                    jQuery(e.$mediaNode_).append(t), e.$mediaNode_.load && e.$mediaNode_.load()
                } else e.$theMedia.append(a);
                e.$mediaNode_ = e.$theMedia.children("audio").get(0)
            },
            s = __webpack_require__(690),
            n = __webpack_require__(348);
        class o {
            constructor(e) {
                this.timeCurrent = 0, this.timeTotal = 0, this.sampleTimeStart = null, this.sampleTimeEnd = null, this.sampleTimeTotal = null, this.referenceMediaCurrentTime = 0, this.referenceMediaTotalTime = 0, this.visualCurrentTime = null, this.visualTotalTime = null, this.actualTotalTime = null, this.dzsapInstance = e, this.init()
            }
            init() {}
            initObjects() {
                var e = this.dzsapInstance,
                    a = this;
                e.cthis.get(0).api_set_timeVisualCurrent = function(e) {
                    a.visualCurrentTime = e
                }, e.cthis.get(0).api_get_time_total = function() {
                    return a.getVisualTotalTime()
                }, e.cthis.get(0).api_get_time_curr = function() {
                    return a.getVisualCurrentTime()
                }, e.cthis.get(0).api_set_timeVisualTotal = function(e) {
                    a.visualTotalTime = e, a.refreshTimes()
                }
            }
            refreshTimes() {
                var e = this.dzsapInstance;
                ("selfHosted" === e.audioType || "fake" === e.audioType && e._actualPlayer) && "shoutcast" !== e.dataType && (e.$mediaNode_ && !1 === isNaN(e.$mediaNode_.duration) && (this.referenceMediaTotalTime = e.$mediaNode_.duration), e.$mediaNode_ && null === e._actualPlayer && (this.referenceMediaCurrentTime = e.$mediaNode_.currentTime), "last" === e.playFrom && e.playFrom_ready && "undefined" != typeof Storage && (localStorage["dzsap_" + e.the_player_id + "_lastpos"] = e.timeCurrent)), e._sourcePlayer && e._sourcePlayer.get(0) && e._sourcePlayer.get(0).api_get_time_curr && (isNaN(e._sourcePlayer.get(0).api_get_time_total()) || "" === e._sourcePlayer.get(0).api_get_time_total() || e._sourcePlayer.get(0).api_get_time_total() < 1) && e._sourcePlayer.get(0).api_set_timeVisualTotal(this.getVisualTotalTime()), null === e._actualPlayer && this.referenceMediaCurrentTime > -1 && (e.timeCurrent = this.referenceMediaCurrentTime), null === e._actualPlayer && this.referenceMediaTotalTime > -1 && (e.timeTotal = this.referenceMediaTotalTime), this.sampleTimeStart && (this.visualCurrentTime < e.pseudo_sample_time_start && (this.visualCurrentTime = e.pseudo_sample_time_start), this.sampleTimeEnd && e.timeCurrent > this.sampleTimeEnd) && (e.handle_end({
                    call_from: "time_curr>pseudo_sample_time_end"
                }), e.isMediaEnded = !0, clearTimeout(e.inter_isEnded), e.inter_isEnded = setTimeout((function() {
                    e.isMediaEnded = !1
                }), 1e3))
            }
            processCurrentFrame() {
                var e = this.dzsapInstance;
                if (e._sourcePlayer)
                    if (e._sourcePlayer.get(0) && e._sourcePlayer.get(0).api_get_time_curr && e._sourcePlayer.get(0).api_set_timeVisualCurrent(e.timeCurrent), e._sourcePlayer.get(0) && e._sourcePlayer.get(0).api_seek_to_visual) {
                        var a = e.timeCurrent;
                        0 === e.pseudo_sample_time_start && e.sample_time_start && (a -= e.sample_time_start), e._sourcePlayer.get(0).api_seek_to_visual(a / e.timeTotal)
                    } else console.log("warning .. no seek to visual");
                e.isSafeToChangeTrack && e.timeTotal > 1 && e.timeCurrent >= e.timeTotal - .07 && null === e._actualPlayer && (e.handle_end({
                    call_from: "selfClass.timeTotal > 0 && selfClass.timeCurrent >= selfClass.timeTotal - 0.07 ... "
                }), e.isMediaEnded = !0, clearTimeout(e.inter_isEnded), e.inter_isEnded = setTimeout((function() {
                    e.isMediaEnded = !1
                }), 1e3))
            }
            getVisualCurrentTime() {
                var e = this.dzsapInstance;
                return null === e._actualPlayer && this.referenceMediaCurrentTime > -1 ? this.referenceMediaCurrentTime : this.visualCurrentTime ? this.visualCurrentTime : e.playFrom ? e.playFrom : 0
            }
            getActualTotalTime() {
                return this.actualTotalTime
            }
            getVisualTotalTime() {
                var e = this.dzsapInstance;
                if (this.sampleTimeTotal) return this.sampleTimeTotal;
                if (null === e._actualPlayer) {
                    if (this.referenceMediaTotalTime > -1) return this.referenceMediaTotalTime
                } else {
                    if (this.visualTotalTime) return this.visualTotalTime;
                    if (this.referenceMediaTotalTime > -1) return this.referenceMediaTotalTime
                }
                return 0
            }
            getActualTargetTime(e) {
                return this.sampleTimeStart && (e < this.sampleTimeStart && (e = this.sampleTimeStart), e > this.sampleTimeEnd && (e = this.sampleTimeEnd)), e
            }
            getSampleTimesFromDom(e = null) {
                var a = this.dzsapInstance;
                a.sample_time_start = 0, a.sample_time_total = 0, a.sample_time_start = 0, a.pseudo_sample_time_end = 0, null === e && (e = a.cthis), e.attr("data-sample_time_start") && (this.sampleTimeStart = Number(e.attr("data-sample_time_start"))), e.attr("data-sample_time_end") && (this.sampleTimeEnd = Number(e.attr("data-sample_time_end"))), e.attr("data-sample_time_total") && (this.sampleTimeTotal = Number(e.attr("data-sample_time_total"))), a.sample_perc_start = a.sample_time_start / a.sample_time_total, a.sample_perc_end = a.sample_time_end / a.sample_time_total, this.sampleTimeTotal && this.sampleTimeStart || this.sampleTimeStart && this.sampleTimeEnd ? a.isSample = !0 : a.isSample = !1
            }
        }
        var r = __webpack_require__(891);
        class l {
            constructor(e) {
                this.selfClass = e
            }
            set_extraHtmlFloatRight(e) {
                this.selfClass.cthis.find(".extrahtml-in-float-right").eq(0).html(e)
            }
        }
        const d = __webpack_require__(401),
            _ = __webpack_require__(217),
            c = __webpack_require__(560),
            p = __webpack_require__(209),
            u = __webpack_require__(690),
            m = __webpack_require__(349),
            h = __webpack_require__(348);
        window.dzsap_list = [];
        var f = 20;
        window.loading_multi_sharer = !1, window.dzsap_player_interrupted_by_dzsap = null, window.dzsap_audio_ctx = null, window.dzsap__style = null, window.dzsap_sticktobottom_con = null, window.dzsap_self_options = {}, window.dzsap_generating_pcm = !1, window.dzsap_box_main_con = null, window.dzsap_lasto = null, window.dzsap_syncList_players = [], window.dzsap_syncList_index = 0, window.dzsap_base_url = "", window.dzsap_player_index = 0;
        class g {
            constructor(e, a, t) {
                this.argThis = e, this.argOptions = a, this.$ = t, this.cthis = null, this.ajax_view_submitted = "auto", this.increment_views = 0, this.the_player_id = "", this.currIp = "127.0.0.1", this.index_extrahtml_toloads = 0, this.starrating_alreadyrated = -1, this.data_source = "", this.urlToAjaxHandler = null, this.playFrom = "", this._actualPlayer = null, this._audioplayerInner = null, this._metaArtistCon = null, this._conControls = null, this._conPlayPauseCon = null, this._apControls = null, this._apControlsLeft = null, this._apControlsRight = null, this._commentsHolder = null, this.$mediaNode_ = null, this._scrubbar = null, this._scrubbarbg_canvas = null, this._scrubbarprog_canvas = null, this.$feed_fakeButton = null, this._sourcePlayer = null, this.$realVisualPlayer = null, this.$theMedia = null, this.$conPlayPause = null, this.$conControls = null, this.$$scrubbProg = null, this.$controlsVolume = null, this.$currTime = null, this.$totalTime = null, this.$commentsWritter = null, this.$commentsChildren = null, this.$commentsSelector = null, this.$embedButton = null, this.$stickToBottomContainer = null, this.$reflectionVisualObject = null, this.audioType = "normal", this.audioTypeSelfHosted_streamType = "", this.skinwave_mode = "normal", this.action_audio_comment = null, this.commentPositionPerc = 0, this.spectrum_audioContext = null, this.spectrum_audioContextBufferSource = null, this.spectrum_audioContext_buffer = null, this.spectrum_mediaElementSource = null, this.spectrum_analyser = null, this.spectrum_gainNode = null, this.isMultiSharer = !1, this.hasInitialPcmData = !1, this.lastArray = null, this.last_lastArray = null, this.player_playing = !1, this.actualDataTypeOfMedia = "audio", this.youtube_retryPlayTimeout = 0, this.lastTimeInSeconds = 0, this.uniqueId = "", this.identifier_pcm = "", this.isAlreadyHasRealPcm = !1, this.isPcmTryingToGenerate = !1, this.isPlayPromised = !1, this.isCanvasFirstDrawn = !1, this.isPlayerLoaded = !1, this.original_real_mp3 = "", this.skin_minimal_canvasplay = null, this.classFunctionalityInnerPlaylist = null, this.feedEmbedCode = "", this.youtube_currentId = 0, this.youtube_isInited = !1, this.extraHtmlAreas = {
                    bottom: "",
                    afterArtist: "",
                    controlsLeft: "",
                    controlsRight: ""
                }, this.sample_time_start = 0, this.sample_time_end = 0, this.sample_time_total = 0, this.pseudo_sample_time_start = 0, this.pseudo_sample_time_end = 0, this.pseudo_sample_time_total = 0, this.playlist_inner_currNr = 0, this.timeCurrent = 0, this.timeModel = new o(this), this.isSample = !1, this.isSafeToChangeTrack = !1, this.isMediaEnded = !1, this.isSetupedMedia = !1, this.isSentCacheTotalTime = !1, this.isPcmRequiredToGenerate = !1, this.radio_isGoingToUpdateSongName = !1, this.radio_isGoingToUpdateArtistName = !1, this.classMetaParts = new l(this), this.inter_isEnded = 0, this.classInit()
            }
            set_sourcePlayer(e) {
                e ? e.get(0) != this.cthis.get(0) && (this._sourcePlayer = e) : this._sourcePlayer = e
            }
            reinit_beforeChangeMedia() {
                this.hasInitialPcmData = !1, this.isPcmRequiredToGenerate = !1, this.isAlreadyHasRealPcm = !1, this.cthis.attr("data-pcm", "")
            }
            reinit_resetMetrics() {
                this.isPlayerLoaded = !1
            }
            service_checkIfWeShouldUpdateTotalTime() {
                (0, r.ajax_submit_total_time)(this)
            }
            classInit() {
                var o = this.$,
                    l = this.argOptions,
                    p = o(this.argThis),
                    g = this;
                g.cthis = p, g.initOptions = l;
                var y, v, b = "ap1",
                    w = 0,
                    k = 0,
                    C = null,
                    T = !1,
                    z = !1,
                    x = !1,
                    P = !1,
                    S = !1,
                    $ = !1,
                    O = !1,
                    M = 0,
                    I = -1,
                    N = 1,
                    q = 1,
                    A = 0,
                    j = !1,
                    R = !1,
                    H = !1,
                    E = !1,
                    L = 0,
                    F = !1,
                    B = 0,
                    D = 0,
                    Q = 100,
                    V = 100,
                    W = "",
                    U = 1,
                    G = null,
                    Y = null,
                    J = null,
                    X = null,
                    Z = !0,
                    K = 20,
                    ee = 0,
                    ae = 0,
                    te = 0;

                function ie() {
                    var e = parseFloat(l.skinwave_wave_mode_canvas_reflection_size);
                    e = 1 - e;
                    var a = g._scrubbar.height();
                    "skin-wave" === l.design_skin && ("small" === g.skinwave_mode && (a = 60), g._commentsHolder && (0 === e ? g._commentsHolder.css("top", g._scrubbar.offset().top - p.offset().top + a * e - g._commentsHolder.height()) : (g._commentsHolder.css("top", g._scrubbar.offset().top - g._scrubbar.parent().offset().top + a * e), g.$commentsWritter.css("top", g._scrubbar.offset().top - g._scrubbar.parent().offset().top + a * e))), g.$currTime && g.$currTime.css("top", a * e - g.$currTime.outerHeight()), g.$totalTime && g.$totalTime.css("top", a * e - g.$totalTime.outerHeight())), p.attr("data-reflection-size", e)
                }

                function se(e, a) {
                    console.log("change_visual_target() - ", e);
                    var t = {};
                    a && (t = o.extend(t, a)), g._sourcePlayer && g._sourcePlayer.get(0) && g._sourcePlayer.get(0).api_pause_media_visual && g._sourcePlayer.get(0).api_pause_media_visual({
                        call_from: "change_visual_target"
                    }), g.set_sourcePlayer(e);
                    var i = g._sourcePlayer.get(0);
                    g.player_playing && g._sourcePlayer && i && i.api_play_media_visual && i.api_play_media_visual(), i && i.api_draw_curr_time && (i.api_set_timeVisualCurrent(g.timeCurrent), i.api_get_times({
                        call_from: " change visual target .. in api "
                    }), i.api_check_time({
                        fire_only_once: !0
                    }), i.api_draw_curr_time(), i.api_draw_scrub_prog()), setTimeout((function() {
                        i && i.api_draw_curr_time && (i.api_get_times(), i.api_check_time({
                            fire_only_once: !0
                        }), i.api_draw_curr_time(), i.api_draw_scrub_prog())
                    }), 800)
                }

                function ne(e) {
                    l.design_wave_color_progress = e, "canvas" === l.skinwave_wave_mode && h.view_drawCanvases(g, p.attr("data-pcm"), "canvas_change_pcm")
                }

                function oe() {
                    "normal" !== g.audioType && "detect" !== g.audioType && "audio" !== g.audioType || (g.audioType = "selfHosted")
                }

                function re() {
                    if (z) return !1;
                    Z = !0
                }

                function le() {
                    var e = o(this);
                    0 !== p.has(e).length && (e.hasClass("active") ? r.ajax_retract_like.bind(g)() : r.ajax_submit_like.bind(g)())
                }

                function de() {
                    if (z) return !1;
                    g.player_playing && Ue(), o(window).off("resize.dzsap"), p.remove(), p = null, z = !0
                }

                function _e(a, t) {
                    var i = {
                        do_not_autoplay: !1
                    };
                    t && (i = o.extend(i, t)), p.find(".playbtn").unbind("click", _e), p.find(".scrubbar").unbind("click", _e), ye(i), (e.is_android() || e.is_ios()) && Ye({
                        called_from: "click_for_setup_media"
                    })
                }

                function ce(e) {
                    l.parentgallery && void 0 !== l.parentgallery.get(0) && l.parentgallery.get(0).api_toggle_menu_state()
                }

                function pe() {
                    setTimeout((function() {
                        g.cthis.addClass("scrubbar-loaded")
                    }), 1e3)
                }

                function ue() {
                    if (p.attr("data-thumb")) {
                        p.addClass("has-thumb");
                        var e = "";
                        p.attr("data-thumb_link") ? e += '<a href="' + p.attr("data-thumb_link") + '"' : e += "<div", e += ' class="the-thumb-con"><div class="the-thumb" style=" background-image:url(' + p.attr("data-thumb") + ')"></div>', p.attr("data-thumb_link") ? e += "</a>" : e += "</div>", p.children(".the-thumb-con").length && (e = p.children(".the-thumb-con").eq(0)), "skin-customcontrols" !== l.design_skin && ("skin-wave" !== l.design_skin || "small" !== g.skinwave_mode && "alternate" !== g.skinwave_mode ? "skin-steel" === l.design_skin ? g._apControlsLeft.prepend(e) : g._audioplayerInner.prepend(e) : "alternate" === g.skinwave_mode ? g._audioplayerInner.prepend(e) : g._apControlsLeft.prepend(e)), g._audioplayerInner.children(".the-thumb-con").eq(0)
                    } else p.removeClass("has-thumb")
                }

                function me() {
                    p.hasClass("zoomsounds-wrapper-bg-bellow") && 0 === p.find(".dzsap-wrapper-buts").length && (p.append('<div class="temp-wrapper"></div>'), p.find(".temp-wrapper").append(g.extraHtmlAreas.controlsRight), p.find(".temp-wrapper").children("*:not(.dzsap-wrapper-but)").remove(), p.find(".temp-wrapper > .dzsap-wrapper-but").unwrap(), p.find(".dzsap-wrapper-but").each((function() {
                        var e = o(this).html();
                        e = (e = e.replace("{{heart_svg}}", "\t&hearts;")).replace("{{svg_share_icon}}", c.svg_share_icon), o(this).get(0) && o(this).get(0).outerHTML.indexOf("dzsap-multisharer-but") > -1 && (g.isMultiSharer = !0), o(this).html(e)
                    })).wrapAll('<div class="dzsap-wrapper-buts"></div>')), "skin-customcontrols" === l.design_skin && (p.html(String(p.html()).replace("{{svg_play_icon}}", c.svg_play_icon)), p.html(String(p.html()).replace("{{svg_pause_icon}}", c.pausebtn_svg)))
                }

                function he() {
                    g.cthis.find(".dzsap-multisharer-but").data("cthis", p), g.cthis.data("embed_code", g.feedEmbedCode)
                }

                function fe(a) {
                    var t = {
                        call_from: "default"
                    };
                    a && (t = o.extend(t, a));
                    var i = [];
                    if ("on" !== l.pcm_data_try_to_generate || "on" !== l.pcm_data_try_to_generate_wait_for_real_pcm) {
                        for (var s = 0; s < 200; s++) i[s] = Number(Math.random()).toFixed(2);
                        i = JSON.stringify(i), p.addClass("rnd-pcm-for-now"), p.attr("data-pcm", i)
                    }
                    e.scrubbar_modeWave_setupCanvas({}, g)
                }

                function ge() {
                    "on" !== l.skinwave_enableSpectrum ? "canvas" === l.skinwave_wave_mode && (p.attr("data-pcm") ? e.scrubbar_modeWave_setupCanvas({}, g) : fe()) : (e.scrubbar_modeWave_setupCanvas({}, g), (C = g.cthis.find(".scrub-bg-img").eq(0)).get(0).getContext("2d"))
                }

                function ye(s) {
                    var n = {
                        do_not_autoplay: !1,
                        called_from: "default",
                        newSource: ""
                    };
                    if (s && (n = o.extend(n, s)), "icecast" !== g.audioType && "shoutcast" !== g.audioType || (g.audioType = "selfHosted"), "off" === l.cueMedia && "auto" === g.ajax_view_submitted && (g.increment_views = 1, g.ajax_view_submitted = "off"), !0 === g.isPlayerLoaded) return;
                    if ("youtube" === p.attr("data-original-type")) return;
                    "youtube" === g.audioType && dzsap_youtube_setupMedia(g, n), n.newSource && (g.data_source = n.newSource), e.is_ios() && (l.preload_method = "metadata");
                    const r = function(a, t, i) {
                        var s = "",
                            n = "",
                            o = a.initOptions;
                        return a.data_source && a.data_source.indexOf("get_track_source") > -1 && (o.preload_method = "none"), s += "<audio", s += ' id="' + a.uniqueId + '-audio"', s += ' preload="' + o.preload_method + '"', "on" === o.skinwave_enableSpectrum && (s += ' crossOrigin="anonymous"'), e.is_ios(), s += ">", n = "", a.data_source && (a.data_source || "icecast" === t || (a.data_source = a.cthis.attr("data-source")), "fake" !== a.data_source ? (n += '<source src="' + a.data_source + '" type="audio/mpeg">', void 0 !== a.cthis.attr("data-sourceogg") && (n += '<source src="' + a.cthis.attr("data-sourceogg") + '" type="audio/ogg">')) : a.cthis.addClass("meta-loaded meta-fake")), {
                            stringAudioElementHtml: s + n + "</audio>",
                            stringAudioTagSource: n
                        }
                    }(g, g.audioTypeSelfHosted_streamType);
                    W = r.stringAudioElementHtml;
                    const d = r.stringAudioTagSource;
                    if ("selfHosted" !== g.audioType && "soundcloud" !== g.audioType || ("change_media" === n.called_from || "nonce generated" === n.called_from ? e.is_ios() || e.is_android() ? i(g, W, d) : "nonce generated" === n.called_from && g._actualPlayer || i(g, W) : (i(g, W), (e.is_ios() || e.is_android()) && "retrieve_soundcloud_url" === n.called_from && setTimeout((function() {
                            Ue()
                        }), 500)), g.$mediaNode_ && g.$mediaNode_.addEventListener && "fake" !== g.cthis.attr("data-source") && function(i, s, n, o, r) {
                            var l = 0;
                            i.$mediaNode_.addEventListener("error", (function(s) {
                                const n = this;
                                if (console.log("errored out", n, n.duration, s, s.target.error), n.networkState === HTMLMediaElement.NETWORK_NO_SOURCE && !1 === e.dzsap_is_mobile() && !1 === i.cthis.hasClass(t.O.ERRORED_OUT_CLASS))
                                    if (console.log("%c could not load audio source - ", "color:#ff2222;", i.cthis.attr("data-source")), l < t.O.ERRORED_OUT_MAX_ATTEMPTS) setTimeout((function(e) {
                                        i.$mediaNode_ && (i.$mediaNode_.src = ""), setTimeout((function() {
                                            i.$mediaNode_ && (i.$mediaNode_.src = i.data_source, i.$mediaNode_.load())
                                        }), 1e3)
                                    }), 1e3, s), l++;
                                    else if ("on" === i.initOptions.notice_no_media) {
                                    i.cthis.addClass(t.O.ERRORED_OUT_CLASS);
                                    var o = "error - file does not exist...";
                                    s.target.error && (o = s.target.error.message), i.cthis.append(a.setupTooltip({
                                        tooltipConClass: " feedback-tooltip-con",
                                        tooltipIndicatorText: '<span class="player-but"><span class="the-icon-bg" style="background-color: #912c2c"></span><span class="svg-icon dzsap-color-ui-inverse" >&#x2139;</span></span>',
                                        tooltipInnerHTML: "cannot load - ( " + i.data_source + " ) - error: " + o
                                    }))
                                }
                            }), !0), i.$mediaNode_.addEventListener("loadedmetadata", (function(a) {
                                e.player_view_addMetaLoaded(i);
                                const t = a.currentTarget;
                                i.timeModel.actualTotalTime = Math.ceil(t.duration), i.service_checkIfWeShouldUpdateTotalTime(), "change_media" === s.called_from && n({
                                    call_from: "force_reload_change_media"
                                }), ("change_media" === s.called_from || i._sourcePlayer) && o && setTimeout((() => {
                                    r(o, {
                                        call_from: "change_media"
                                    })
                                }), 50), i._sourcePlayer && this.duration && i._sourcePlayer.get(0).api_set_timeVisualTotal(this.duration), i.view_drawCurrentTime()
                            }), !0)
                        }(g, n, Ce, N, De)), g.cthis.addClass("media-setuped"), "change_media" === n.called_from) return !1;
                    "youtube" !== g.audioType && ("fake" === g.cthis.attr("data-source") ? (e.is_ios() || e.is_android()) && Ce(n) : e.is_ios() ? setTimeout((function() {
                        Ce(n)
                    }), 1e3) : v = setInterval((function() {
                        ! function(a) {
                            var t = {
                                do_not_autoplay: !1
                            };
                            if (g._actualPlayer && e.is_ios()) return !1;
                            a && (t = o.extend(t, a)), "youtube" === g.audioType ? Ce(t) : void 0 !== g.$mediaNode_ && g.$mediaNode_ && ("AUDIO" !== g.$mediaNode_.nodeName || "shoutcast" === l.type ? Ce(t) : e.is_safari() ? g.$mediaNode_.readyState >= 1 && (g.isPlayerLoaded, Ce(t), clearInterval(v), l.action_audio_loaded_metadata && l.action_audio_loaded_metadata(p)) : g.$mediaNode_.readyState >= 2 && (g.isPlayerLoaded, Ce(t), clearInterval(v), l.action_audio_loaded_metadata && l.action_audio_loaded_metadata(p)))
                        }(n)
                    }), 50), "none" === l.preload_method && function(e, a) {
                        setTimeout((function() {
                            e.$mediaNode_ && jQuery(e.$mediaNode_).attr("preload", "metadata")
                        }), 1e4 * Number(window.dzsap_player_index))
                    }(g), "skin-customcontrols" !== l.design_skin && "skin-customhtml" !== l.design_skin || (p.find(".custom-play-btn,.custom-pause-btn").off("click"), p.find(".custom-play-btn,.custom-pause-btn").on("click", Oe)), l.failsafe_repair_media_element && function(e, a) {
                        var t = e.initOptions;
                        setTimeout((function() {
                            if (e.$theMedia.children().eq(0).get(0) && "AUDIO" === e.$theMedia.children().eq(0).get(0).nodeName) return !1;
                            e.$theMedia.html(""), e.$theMedia.append(a);
                            var t = e.player_playing;
                            e.pause_media(), e.$mediaNode_ = e.$theMedia.children("audio").get(0), t && setTimeout((function() {
                                e.play_media({
                                    called_from: "aux_was_playing"
                                })
                            }), 20)
                        }), t.failsafe_repair_media_element), t.failsafe_repair_media_element = ""
                    }(g, W)), "wave" === l.scrubbar_type && "on" === l.skinwave_enableSpectrum && e.player_initSpectrumOnUserAction(g), g.isSetupedMedia = !0
                }

                function ve() {
                    o(g.$mediaNode_).remove(), g.$mediaNode_ = null, g.isSetupedMedia = !1, g.isPlayerLoaded = !1
                }

                function be() {
                    Ue(), g.$mediaNode_ && (g.$mediaNode_.children, "audio" === l.type && (g.$mediaNode_.innerHTML = "", g.$mediaNode_.load())), e.is_ios() || e.is_android() || g.$theMedia && (g.$theMedia.children().remove(), g.isPlayerLoaded = !1), ve()
                }

                function we() {
                    return O || (O = !0, g._scrubbar.unbind("mousemove"), g._scrubbar.unbind("mouseleave"), g._scrubbar.unbind("click"), g._scrubbar.bind("mousemove", He), g._scrubbar.bind("mouseleave", He), g._scrubbar.bind("click", He), g.$controlsVolume.on("click", ".volumeicon", Ve), g.$controlsVolume.bind("mousemove", Re), g.$controlsVolume.bind("mousedown", Re), o(document).on("mouseup", window, Re), "skin-silver" === l.design_skin && p.on("click", ".volume-holder", Re), p.find(".playbtn").unbind("click"), setTimeout(Ae, 300), setTimeout(Ae, 2e3), l.settings_trigger_resize > 0 && setInterval(Ae, l.settings_trigger_resize), p.addClass("listeners-setuped")), !1
                }

                function ke() {
                    return N
                }

                function Ce(a) {
                    if (!p.hasClass("dzsap-loaded")) {
                        var t = {
                            do_not_autoplay: !1,
                            call_from: "init"
                        };
                        a && (t = o.extend(t, a)), setTimeout((function() {
                            g.isSafeToChangeTrack = !0
                        }), 5e3), void 0 !== g.$mediaNode_ && g.$mediaNode_ && "AUDIO" === g.$mediaNode_.nodeName && g.$mediaNode_.addEventListener("ended", qe), clearInterval(v), clearTimeout(v), we(), setTimeout((function() {
                            g.$currTime && g.$currTime.outerWidth() > 0 && (M = g.$currTime.outerWidth())
                        }), 1e3), g.isPcmRequiredToGenerate && h.scrubModeWave__checkIfWeShouldTryToGetPcm(g, {
                            called_from: "init_loaded()"
                        }), "fake" !== g.audioType && "force_reload_change_media" !== t.call_from && ("on" !== l.settings_exclude_from_list && dzsap_list && -1 === dzsap_list.indexOf(p) && null === g._actualPlayer && dzsap_list.push(p), "on" === l.type_audio_stop_buffer_on_unfocus && (p.data("type_audio_stop_buffer_on_unfocus", "on"), p.get(0).api_destroy_for_rebuffer = function() {
                            "audio" === l.type && (g.playFrom = g.$mediaNode_.currentTime), be(), P = !0
                        })), "auto" === g.ajax_view_submitted && setTimeout((function() {
                            "auto" === g.ajax_view_submitted && (g.ajax_view_submitted = "off")
                        }), 1e3), g.isPlayerLoaded = !0, "fake" !== g.data_source && p.addClass("dzsap-loaded"), "default" === l.default_volume && (U = 1), !1 === isNaN(Number(l.default_volume)) ? U = Number(l.default_volume) : "last" === l.default_volume && (U = null !== localStorage && g.the_player_id && localStorage.getItem("dzsap_last_volume_" + g.the_player_id) ? localStorage.getItem("dzsap_last_volume_" + g.the_player_id) : 1), l.volume_from_gallery && (U = l.volume_from_gallery), De(U, {
                            call_from: "from_init_loaded"
                        }), g.pseudo_sample_time_start && (g.playFrom = g.pseudo_sample_time_start), d.isInt(g.playFrom) && Le(g.playFrom, {
                            call_from: "from_playfrom"
                        }), "last" === g.playFrom && "undefined" != typeof Storage && (setTimeout((function() {
                            g.playFrom_ready = !0
                        })), void 0 !== localStorage["dzsap_" + g.the_player_id + "_lastpos"] && Le(localStorage["dzsap_" + g.the_player_id + "_lastpos"], {
                            call_from: "last_pos"
                        })), !0 !== t.do_not_autoplay && "on" === l.autoplay && "on" === l.cueMedia && Ye({
                            called_from: "do not autoplay not true ( init_loaded() ) "
                        }), g.$mediaNode_ && g.$mediaNode_.duration && e.player_view_addMetaLoaded(g), oe(), $e({
                            fire_only_once: !1
                        }), "off" === l.autoplay && (Z = !0), p.addClass("init-loaded"), setTimeout((function() {
                            g.timeModel.refreshTimes({
                                call_from: "set timeout 500"
                            }), $e({
                                fire_only_once: !0
                            }), p.find(".wave-download").bind("click", xe)
                        }), 500), setTimeout((function() {
                            g.timeModel.refreshTimes({
                                call_from: "set timeout 1000"
                            }), $e({
                                fire_only_once: !0
                            })
                        }), 1e3), 0 === A && l.action_video_contor_60secs && (A = setInterval(Te, 3e4))
                    }
                }

                function Te() {
                    l.action_video_contor_60secs && p.hasClass("is-playing") && l.action_video_contor_60secs(p, "")
                }

                function ze(e) {
                    S = e
                }

                function xe(e) {
                    var a = o(this);
                    if ("click" === e.type) {
                        if (a.hasClass("wave-download") && r.ajax_submit_download.bind(g)(), a.hasClass("prev-btn") && (l.parentgallery && l.parentgallery.get(0) ? l.parentgallery.get(0).api_goto_prev() : Ie()), a.hasClass("next-btn") && (l.parentgallery && l.parentgallery.get(0) ? l.parentgallery.get(0).api_goto_next() : Ne()), a.hasClass("tooltip-indicator--btn-footer-playlist") && a.parent().find(".dzstooltip").toggleClass("active"), a.hasClass("zoomsounds-btn-go-beginning")) {
                            var t = p;
                            g._actualPlayer && (t = g._actualPlayer), t.get(0).api_seek_to_0()
                        }
                        a.hasClass("zoomsounds-btn-step-backward") && (t = p, g._actualPlayer && (t = g._actualPlayer), t.get(0).api_step_back()), a.hasClass("zoomsounds-btn-step-forward") && (t = p, g._actualPlayer && (t = g._actualPlayer), t.get(0).api_step_forward()), a.hasClass("zoomsounds-btn-slow-playback") && (t = p, g._actualPlayer && (t = g._actualPlayer), t.get(0).api_playback_slow()), a.hasClass("zoomsounds-btn-reset") && (t = p, g._actualPlayer && (t = g._actualPlayer), t.get(0).api_playback_reset()), a.hasClass("btn-zoomsounds-download") && r.ajax_submit_download.bind(g)(), a.hasClass("dzsap-repeat-button") && (g.player_playing, Le(0, {
                            call_from: "repeat"
                        })), a.hasClass("dzsap-loop-button") && (a.hasClass("active") ? (a.removeClass("active"), S = !1) : (a.addClass("active"), S = !0))
                    }
                    e.type, "mouseenter" === e.type && ("on" === l.preview_on_hover && (Ee(0), Ye({
                        called_from: "preview_on_hover"
                    }), console.log("mouseover")), window.dzsap_mouseover = !0), "mouseleave" === e.type && ("on" === l.preview_on_hover && (Ee(0), Ue()), window.dzsap_mouseover = !1)
                }

                function Pe() {
                    let a = g.timeModel.getVisualCurrentTime(),
                        t = g.timeModel.getVisualTotalTime();
                    if ("wave" === g.initOptions.scrubbar_type) {
                        if ("on" === g.initOptions.skinwave_enableSpectrum) {
                            if (!g.player_playing) return !1;
                            C && (Q = C.width(), V = C.height(), C.get(0).width = Q, C.get(0).height = V),
                                function() {
                                    if ("soundcloud" === g.initOptions.type ? g.lastArray = e.generateFakeArrayForPcm() : g.spectrum_analyser && (g.lastArray = new Uint8Array(g.spectrum_analyser.frequencyBinCount), g.spectrum_analyser.getByteFrequencyData(g.lastArray)), g.lastArray && g.lastArray.length) {
                                        for (var a = g.lastArray.length, t = a - 1; t >= 0; t--) g.lastArray[t] = t < a / 2 ? g.lastArray[t] / 255 * V : g.lastArray[a - t] / 255 * V;
                                        if (g.last_lastarray)
                                            for (var i = 0; i < g.last_lastarray.length; i++) ee = g.last_lastarray[i], ae = g.lastArray[i] - ee, K = 3, g.lastArray[i] = Math.easeIn(1, ee, ae, K);
                                        h.draw_canvas(C.get(0), g.lastArray, "" + g.initOptions.design_wave_color_bg, {
                                            call_from: "spectrum",
                                            selfClass: g,
                                            skinwave_wave_mode_canvas_waves_number: parseInt(g.initOptions.skinwave_wave_mode_canvas_waves_number),
                                            skinwave_wave_mode_canvas_waves_padding: parseInt(g.initOptions.skinwave_wave_mode_canvas_waves_padding)
                                        }), g.lastArray && (g.last_lastarray = g.lastArray.slice())
                                    }
                                }()
                        }
                        if (g.$currTime && g.$currTime.length && "on" !== g.initOptions.skinwave_timer_static) {
                            if (k < 0 && (k = 0), (k = parseInt(k, 10)) < 2 && p.data("promise-to-play-footer-player-from")) return !1;
                            g.$currTime.css({
                                left: k
                            }), k > w - M && g.$currTime.css({
                                left: w - M
                            }), k > w - 30 && w ? g.$totalTime.css({
                                opacity: 1 - (k - (w - 30)) / 30
                            }) : "1" !== g.$totalTime.css("opacity") && g.$totalTime.css({
                                opacity: ""
                            })
                        }
                    }
                    0 !== t && function(a) {
                        g.$totalTime && (g.$totalTime.html(e.formatTime(a)), g.$totalTime.fadeIn("fast"))
                    }(t), g.$currTime && (!1 === $ && g.$currTime.html(e.formatTime(a)), g.timeModel.getVisualTotalTime() && g.timeModel.getVisualTotalTime() > -1 && g.cthis.addClass("time-total-visible")), g.spectrum_audioContext && g.$totalTime && g.$totalTime.html(e.formatTime(t))
                }

                function Se() {
                    let e = g.timeModel.getVisualCurrentTime(),
                        a = g.timeModel.getVisualTotalTime();
                    if (k = e / a * w, isNaN(k) && (k = 0), k > w && (k = w), e < 0 && (k = 0), (0 === a || isNaN(a)) && (k = 0), k < 2 && p.data("promise-to-play-footer-player-from")) return !1;
                    null === g.spectrum_audioContext_buffer && g.$$scrubbProg && (g.$$scrubbProg.style.width = parseInt(k, 10) + "px")
                }

                function $e(e) {
                    var a = {
                        fire_only_once: !1
                    };
                    if (e && (a = o.extend(a, e)), z) return console.log("DESTROYED"), !1;
                    if (!1 === a.fire_only_once && Z) return requestAnimationFrame($e), !1;
                    if (g.timeModel.refreshTimes({
                            call_from: "checK_time"
                        }), g.audioType, Se(), g.timeModel.processCurrentFrame(), "skin-minimal" === l.design_skin && (g.player_playing || !1 === g.isCanvasFirstDrawn)) {
                        var t = g.skin_minimal_canvasplay.getContext("2d"),
                            i = g.skin_minimal_canvasplay.width,
                            s = g.skin_minimal_canvasplay.height,
                            n = i / 100,
                            r = s / 100;
                        g._actualPlayer, k = 2 * Math.PI * (g.timeModel.getVisualCurrentTime() / g.timeModel.getVisualTotalTime()), isNaN(k) && (k = 0), k > 2 * Math.PI && (k = 2 * Math.PI), t.clearRect(0, 0, i, s), t.beginPath(), t.arc(50 * n, 50 * r, 40 * n, 0, 2 * Math.PI, !1), t.fillStyle = "rgba(0,0,0,0.1)", t.fill(), t.beginPath(), t.arc(50 * n, 50 * r, 34 * n, 0, k, !1), t.lineWidth = 10 * n, t.strokeStyle = "rgba(0,0,0,0.3)", t.stroke(), g.isCanvasFirstDrawn = !0
                    }
                    Pe(), !0 !== a.fire_only_once && requestAnimationFrame($e)
                }

                function Oe(e) {
                    p.hasClass("prevent-bubble") && e && e.stopPropagation && (e.preventDefault(), e.stopPropagation());
                    var a = o(this),
                        t = !1;
                    if (!p.hasClass("listeners-setuped")) {
                        o(g.$mediaNode_).attr("preload", "auto"), we(), Ce();
                        var i = setInterval((function() {
                            g.$mediaNode_ && g.$mediaNode_.duration && !1 === isNaN(g.$mediaNode_.duration) && clearInterval(i)
                        }), 1e3)
                    }
                    if ("skin-minimal" === l.design_skin) {
                        var s = a.offset().left + L / 2,
                            n = a.offset().top + L / 2,
                            r = e.pageX,
                            d = e.pageY,
                            _ = .005 * -(r - s - L / 2);
                        d < n && (_ = .5 - _ + .5), (Math.abs(d - n) > 20 || Math.abs(r - s) > 20) && (Ee(_, {
                            call_from: "skin_minimal_scrub"
                        }), t = !0, $e({
                            fire_only_once: !0
                        }))
                    }
                    return !1 === t && (!1 === g.player_playing ? Ye({
                        called_from: "click_playpause"
                    }) : Ue()), !1
                }

                function Me(a = 0) {
                    var t = 0;
                    g.classFunctionalityInnerPlaylist ? (t = g.playlist_inner_currNr + a) >= 0 && g.classFunctionalityInnerPlaylist.playlistInner_gotoItem(t, {
                        call_from: "api_sync_players_prev"
                    }) : window.dzsap_syncList_players && window.dzsap_syncList_players.length > 0 ? (0, e.player_syncPlayers_gotoItem)(g, a) : console.log("[dzsap] [syncPlayers] no players found"), window.dzsap_syncList_players && window.dzsap_syncList_index >= window.dzsap_syncList_players.length && (window.dzsap_syncList_index = 0)
                }

                function Ie() {
                    if (g._actualPlayer) return g._actualPlayer.get(0).api_sync_players_goto_prev(), !1;
                    Me(-1)
                }

                function Ne() {
                    if (g._actualPlayer) return g._actualPlayer.get(0).api_sync_players_goto_next(), !1;
                    Me(1)
                }

                function qe(e) {
                    var a = {
                        called_from: "default"
                    };
                    return e && (a = o.extend(a, e)), !g.isMediaEnded && (g.isMediaEnded = !0, g.inter_isEnded = setTimeout((function() {
                        g.isMediaEnded = !1
                    }), 1e3), g._sourcePlayer && (S = g._sourcePlayer.get(0).api_get_media_isLoopActive()), (!g._actualPlayer || "fake_player" === a.call_from) && (Le(0, {
                        call_from: "handle_end"
                    }), S ? (Ye({
                        called_from: "track_end"
                    }), !1) : (Ue(), l.parentgallery && l.parentgallery.get(0).api_gallery_handle_end(), setTimeout((function() {
                        (g.cthis.hasClass("is-single-player") || g._sourcePlayer && g._sourcePlayer.hasClass("is-single-player")) && Ne()
                    }), 100), void setTimeout((function() {
                        if (g._sourcePlayer && (g._sourcePlayer.hasClass("is-single-player") || g._sourcePlayer.hasClass("feeded-whole-playlist"))) return g._sourcePlayer.get(0).api_handle_end({
                            call_from: "handle_end() fake_player"
                        }), !1;
                        G && G(p, {})
                    }), 200))))
                }

                function Ae(e, a) {
                    if (o(window).width(), y = p.width(), p.height(), C && "function" == typeof C.width && (Q = C.width(), V = C.height()), y <= 720 ? p.addClass("under-720") : p.removeClass("under-720"), y <= 500 ? (!1 === p.hasClass("under-500") && "skin-wave" === l.design_skin && "normal" === g.skinwave_mode && g._apControls.append(g._metaArtistCon), p.addClass("under-500")) : (!1 === p.hasClass("under-500") && "skin-wave" === l.design_skin && "normal" === g.skinwave_mode && g._conPlayPauseCon.after(g._metaArtistCon), p.removeClass("under-500")), w = y, "skin-default" === l.design_skin && (w = y), "skin-pro" === l.design_skin && (w = y), "skin-silver" !== l.design_skin && "skin-aria" !== l.design_skin || (w = y, w = g._scrubbar.width()), "skin-justthumbandbutton" === l.design_skin && (y = p.children(".audioplayer-inner").outerWidth(), w = y), "skin-redlights" !== l.design_skin && "skin-steel" !== l.design_skin || (w = g._scrubbar.width()), "skin-wave" === l.design_skin && (w = g._scrubbar.outerWidth(!1), g._scrubbar.outerHeight(!1), g._commentsHolder && (g._commentsHolder.css({
                            width: w
                        }), g._commentsHolder.addClass("active"))), !0 === j) {
                        if ("skin-default" === l.design_skin) {
                            void 0 !== p.get(0) && "auto" === p.get(0).style.height && p.height(200);
                            g._audioplayerInner.height();
                            void 0 === p.attr("data-initheight") && "" !== p.attr("data-initheight") ? p.attr("data-initheight", g._audioplayerInner.height()) : Number(p.attr("data-initheight")), l.design_thumbh
                        }
                        g._audioplayerInner.find(".the-thumb").eq(0).css({})
                    }
                    "none" !== p.css("display") && (g._scrubbar.find(".scrub-bg-img").eq(0).css({
                        width: g._scrubbar.children(".scrub-bg").width()
                    }), g._scrubbar.find(".scrub-prog-img").eq(0).css({
                        width: g._scrubbar.children(".scrub-bg").width()
                    })), p.removeClass("under-240 under-400"), y <= 240 && p.addClass("under-240"), y <= 500 ? (p.addClass("under-400"), !1 === E && (E = !0), g.$controlsVolume) : !0 === E && (E = !1);
                    var t = 50;
                    if ("skin-wave" === l.design_skin && (g._scrubbar.eq(0).height(), g.skinwave_mode, "small" === g.skinwave_mode && (w = g._scrubbar.width()), "canvas" === l.skinwave_wave_mode && p.attr("data-pcm") && (100 === g._scrubbarbg_canvas.width() && g._scrubbarbg_canvas.width(g._scrubbar.width()), "fake" !== g.data_source && (te ? (clearTimeout(te), te = setTimeout(je, 300)) : (je(), te = 1)))), "skin-minimal" === l.design_skin && (L = g._apControls.width(), g.skin_minimal_canvasplay && (g.skin_minimal_canvasplay.style.width = L, g.skin_minimal_canvasplay.width = L, g.skin_minimal_canvasplay.style.height = L, g.skin_minimal_canvasplay.height = L, o(g.skin_minimal_canvasplay).css({
                            width: L,
                            height: L
                        }))), "skin-default" === l.design_skin && g.$currTime && (parseInt(g._metaArtistCon.css("left"), 10), g._metaArtistCon.outerWidth(), "none" === g._metaArtistCon.css("display") && (g._metaArtistCon_w = 0), isNaN(g._metaArtistCon_l) && (g._metaArtistCon_l = 20)), "skin-minion" === l.design_skin && (t = parseInt(g.$conControls.find(".con-playpause").eq(0).offset().left, 10) - parseInt(g.$conControls.eq(0).offset().left, 10) - 18, g.$conControls.find(".prev-btn").eq(0).css({
                            top: 0,
                            left: t
                        }), t += 36, g.$conControls.find(".next-btn").eq(0).css({
                            top: 0,
                            left: t
                        })), "on" === l.embedded && window.frameElement) {
                        var i = {
                            height: p.outerHeight()
                        };
                        l.embedded_iframe_id && (i.embedded_iframe_id = l.embedded_iframe_id);
                        var s = {
                            name: "resizeIframe",
                            params: i
                        };
                        window.parent.postMessage(s, "*")
                    }
                    Se(), l.settings_trigger_resize > 0 && l.parentgallery && void 0 !== o(l.parentgallery).get(0) && void 0 !== o(l.parentgallery).get(0).api_handleResize && o(l.parentgallery).get(0).api_handleResize()
                }

                function je() {
                    h.view_drawCanvases(g, p.attr("data-pcm"), "canvas_normal_pcm"), te = 0
                }

                function Re(e) {
                    var a = o(this),
                        t = null;
                    if (g.$controlsVolume.find(".volume_static").length && (t = Number((e.pageX - g.$controlsVolume.find(".volume_static").eq(0).offset().left) / g.$controlsVolume.find(".volume_static").eq(0).width())), !t) return !1;
                    "mousemove" === e.type && R && (a.parent().hasClass("volume-holder") || a.hasClass("volume-holder"), "skin-redlights" === l.design_skin && (t *= 10, t = Math.round(t), t /= 10), De(t, {
                        call_from: "set_by_mousemove"
                    }), T = !1), e.type, "click" === e.type && (a.parent().hasClass("volume-holder") && (t = 1 - (e.pageY - g.$controlsVolume.find(".volume_static").eq(0).offset().top) / g.$controlsVolume.find(".volume_static").eq(0).height()), a.hasClass("volume-holder") && (t = 1 - (e.pageY - g.$controlsVolume.find(".volume_static").eq(0).offset().top) / g.$controlsVolume.find(".volume_static").eq(0).height()), De(t, {
                        call_from: "set_by_mouseclick"
                    }), T = !1), "mousedown" === e.type && (R = !0, p.addClass("volume-dragging"), a.parent().hasClass("volume-holder") && (t = 1 - (e.pageY - g.$controlsVolume.find(".volume_static").eq(0).offset().top) / g.$controlsVolume.find(".volume_static").eq(0).height()), De(t, {
                        call_from: "set_by_mousedown"
                    }), T = !1), "mouseup" === e.type && (R = !1, p.removeClass("volume-dragging"))
                }

                function He(a) {
                    var t = a.pageX;
                    if (o(a.target).hasClass("sample-block-start") || o(a.target).hasClass("sample-block-end")) return !1;
                    if ("mousemove" === a.type && (g._scrubbar.children(".scrubBox-hover").css({
                            left: t - g._scrubbar.offset().left
                        }), "on" === l.scrub_show_scrub_time && g.timeModel.getVisualTotalTime())) {
                        var i = (t - g._scrubbar.offset().left) / g._scrubbar.outerWidth() * g.timeModel.getVisualTotalTime();
                        g.$currTime && (g.$currTime.html(e.formatTime(i)), g.$currTime.addClass("scrub-time")), $ = !0
                    }
                    if ("mouseleave" === a.type && ($ = !1, g.$currTime && g.$currTime.removeClass("scrub-time"), Pe()), "click" === a.type) {
                        p.hasClass("prevent-bubble") && a && a.stopPropagation && (a.preventDefault(), a.stopPropagation()), 0 === w && (w = g._scrubbar.width()), 0 === w && (w = 300);
                        var s = (a.pageX - g._scrubbar.offset().left) / w * g.timeModel.getVisualTotalTime();
                        if (0 === g.pseudo_sample_time_start && g.sample_time_start > 0 && (s -= g.sample_time_start), g._actualPlayer && setTimeout((function() {
                                g._actualPlayer.get(0) && g._actualPlayer.get(0).api_pause_media && g._actualPlayer.get(0).api_seek_to_perc(s / g.timeModel.getVisualTotalTime(), {
                                    call_from: "from_feeder_to_feed"
                                })
                            }), 50), Le(s, {
                                call_from: "handleMouseOnScrubbar"
                            }), "on" === l.autoplay_on_scrub_click && !1 === g.player_playing && Ye({
                                called_from: "handleMouseOnScrubbar"
                            }), p.hasClass("from-wc_loop")) return !1
                    }
                }

                function Ee(e, a) {
                    Le(e * g.timeModel.getVisualTotalTime(), a)
                }

                function Le(a, t) {
                    var i = {
                        call_from: "default",
                        deeplinking: "off",
                        call_from_type: "default"
                    };
                    if (t && (i = o.extend(i, t)), i.call_from, "on" === i.deeplinking) {
                        var s = e.add_query_arg(window.location.href, "audio_time", a);
                        history.pushState({
                            foo: "bar"
                        }, null, s)
                    }
                    if (a = e.sanitizeToIntFromPointTime(a), a = g.timeModel.getActualTargetTime(a), g._actualPlayer) {
                        var n = {
                            type: g.actualDataTypeOfMedia,
                            fakeplayer_is_feeder: "on"
                        };
                        return g._actualPlayer.length && g._actualPlayer.data("feeding-from") !== p.get(0) && ("handle_end" !== i.call_from && "from_playfrom" !== i.call_from && "last_pos" !== i.call_from && "playlist_seek_from_0" !== i.call_from ? (n.called_from = "seek_to from player source->" + p.attr("data-source") + " < -  old call from - " + i.call_from, g._actualPlayer.get(0).api_change_media ? g._actualPlayer.get(0).api_change_media(p, n) : console.log("not inited ? ", g._actualPlayer)) : p.data("promise-to-play-footer-player-from", a)), setTimeout((function() {
                            g._actualPlayer.get(0) && g._actualPlayer.get(0).api_pause_media && "from_playfrom" !== i.call_from && "last_pos" !== i.call_from && g._actualPlayer.get(0).api_seek_to(a, {
                                call_from: "from_feeder_to_feed"
                            })
                        }), 50), !1
                    }
                    if ("youtube" === g.audioType) try {
                        g.$mediaNode_.seekTo(a)
                    } catch (e) {
                        console.log("yt seek err - ", e)
                    }
                    if ($e({
                            fire_only_once: !0
                        }), setTimeout((function() {
                            $e({
                                fire_only_once: !0
                            })
                        }), 20), "selfHosted" === g.audioType) {
                        if (g.$mediaNode_ && void 0 !== g.$mediaNode_.currentTime) try {
                            g.$mediaNode_.currentTime = a
                        } catch (e) {
                            console.log("error on scrub", e, " arg - ", a)
                        }
                        return !1
                    }
                }

                function Fe(e) {
                    $e({
                        fire_only_once: !0
                    }), setTimeout((function() {
                        $e({
                            fire_only_once: !0
                        })
                    }), 20)
                }

                function Be(e) {
                    "youtube" === g.audioType && g.$mediaNode_.setPlaybackRate(e), "selfHosted" === g.audioType && (g.$mediaNode_.playbackRate = e)
                }

                function De(e, a) {
                    var t = {
                        call_from: "default"
                    };
                    if (a && (t = o.extend(t, a)), e > 1 && (e = 1), e < 0 && (e = 0), "from_fake_player_feeder_from_init_loaded" === t.call_from && g._sourcePlayer) {
                        if ("default" !== l.default_volume && (H = !0), H) return !1;
                        H = !0
                    }
                    "set_by_mouseclick" !== t.call_from && "set_by_mousemove" !== t.call_from || (H = !0), "youtube" === g.audioType && g.$mediaNode_ && g.$mediaNode_.setVolume && g.$mediaNode_.setVolume(100 * e), "selfHosted" === g.audioType && (g.$mediaNode_ ? g.$mediaNode_.volume = e : g.$mediaNode_ && o(g.$mediaNode_).attr("preload", "metadata")), Qe(e), g._sourcePlayer && (t.call_from = "from_fake_player", g._sourcePlayer.get(0) && g._sourcePlayer.get(0).api_visual_set_volume(e, t) && g._sourcePlayer.get(0).api_visual_set_volume(e, t)), g._actualPlayer && "from_fake_player" !== t.call_from && ("from_init_loaded" === t.call_from ? t.call_from = "from_fake_player_feeder_from_init_loaded" : t.call_from = "from_fake_player_feeder", g._actualPlayer && g._actualPlayer.get(0) && g._actualPlayer.get(0).api_set_volume && g._actualPlayer.get(0).api_set_volume(e, t))
                }

                function Qe(e, a) {
                    g.$controlsVolume.hasClass("controls-volume-vertical") ? g.$controlsVolume.find(".volume_active").eq(0).css({
                        height: g.$controlsVolume.find(".volume_static").eq(0).height() * e
                    }) : "skin-redlights" === g.initOptions.design_skin ? g.$controlsVolume.find(".volume_active").eq(0).css({
                        "clip-path": "inset(0% " + 100 * Math.abs(1 - e) + "% 0% 0%)"
                    }) : g.$controlsVolume.find(".volume_active").eq(0).css({
                        width: g.$controlsVolume.find(".volume_static").eq(0).width() * e
                    }), "skin-wave" === l.design_skin && "on" === l.skinwave_dynamicwaves && (g._scrubbar.find(".scrub-bg-img").eq(0).css({
                        transform: "scaleY(" + e + ")"
                    }), g._scrubbar.find(".scrub-prog-img").eq(0).css({
                        transform: "scaleY(" + e + ")"
                    })), null !== localStorage && g.the_player_id && localStorage.setItem("dzsap_last_volume_" + g.the_player_id, e), N = e
                }

                function Ve(e) {
                    !1 === T ? (q = N, De(0, {
                        call_from: "from_mute"
                    }), T = !0) : (De(q, {
                        call_from: "from_unmute"
                    }), T = !1)
                }

                function We(e) {
                    var a = {
                        call_from: "default"
                    };
                    e && (a = o.extend(a, e)), g.$conPlayPause.removeClass("playing"), p.removeClass("is-playing"), g.player_playing = !1, p.parent().hasClass("zoomsounds-wrapper-bg-center") && p.parent().removeClass("is-playing"), g.$reflectionVisualObject && g.$reflectionVisualObject.removeClass("is-playing"), l.parentgallery && l.parentgallery.removeClass("player-is-playing"), Z = !0, X && X(p)
                }

                function Ue(e) {
                    var a = {
                        audioapi_setlasttime: !0,
                        donot_change_media: !1,
                        call_actual_player: !0
                    };
                    if (z) return !1;
                    if (e && (a = o.extend(a, e)), We({
                            call_from: "pause_media"
                        }), a.call_actual_player && !0 !== a.donot_change_media && null !== g._actualPlayer) {
                        var t = {
                            type: g.actualDataTypeOfMedia,
                            fakeplayer_is_feeder: "on"
                        };
                        return g._actualPlayer && g._actualPlayer.length && g._actualPlayer.data("feeding-from") !== p.get(0) && (t.called_from = "pause_media from player " + p.attr("data-source"), g._actualPlayer.get(0).api_change_media(p, t)), setTimeout((function() {
                            g._actualPlayer.get(0) && g._actualPlayer.get(0).api_pause_media && g._actualPlayer.get(0).api_pause_media()
                        }), 100), void(g.player_playing = !1)
                    }! function(e, a) {
                        var t = jQuery;
                        "youtube" === e.audioType && e.$mediaNode_ && e.$mediaNode_.pauseVideo && e.$mediaNode_.pauseVideo(), "selfHosted" === e.audioType && e.$mediaNode_ && ("stop" == e.initOptions.pause_method ? (e.$mediaNode_.pause(), e.$mediaNode_.src = "", e.destroy_cmedia(), t(e.$mediaNode_).remove(), e.$mediaNode_ = null) : e.$mediaNode_.pause && e.$mediaNode_.pause()), a()
                    }(g, (() => {
                        g._sourcePlayer && g._sourcePlayer.get(0) && g._sourcePlayer.get(0).api_pause_media_visual && g._sourcePlayer.get(0).api_pause_media_visual({
                            call_from: "pause_media in child player"
                        })
                    })), g.player_playing = !1
                }

                function Ge(a) {
                    g.player_playing = !0, Z = !1, p.addClass("is-playing"), p.addClass("first-played"), g.$reflectionVisualObject && g.$reflectionVisualObject.addClass("is-playing"), l.parentgallery && l.parentgallery.addClass("player-is-playing"), g.classFunctionalityInnerPlaylist && g.classFunctionalityInnerPlaylist.player_determineSyncPlayersIndex(g, g._sourcePlayer), e.view_player_globalDetermineSyncPlayersIndex(g), e.view_player_playMiscEffects(g), g.$stickToBottomContainer && g.$stickToBottomContainer.addClass("audioplayer-loaded"), Y && Y(p), J && J(p)
                }

                function Ye(a) {
                    var t = {
                        api_report_play_media: !0,
                        called_from: "default",
                        retry_call: 0
                    };
                    if (a && (t = o.extend(t, a)), g.isSetupedMedia || ye({
                            called_from: t.called_from + "[play_media .. not setuped]"
                        }), "api_sync_players_prev" === t.called_from && (I = p.parent().children(".audioplayer,.audioplayer-tobe").index(p), l.parentgallery && l.parentgallery.get(0) && l.parentgallery.get(0).api_goto_item && l.parentgallery.get(0).api_goto_item(I)), e.is_ios() && "waiting" === g.spectrum_audioContext_buffer) return setTimeout((function() {
                        a.call_from_aux = "waiting audioCtx_buffer or ios", Ye(a)
                    }), 500), !1;
                    if (t.called_from, !1 === p.hasClass("media-setuped") && null === g._actualPlayer && console.log("warning: media not setuped, there might be issues", p.attr("id")), t.called_from.indexOf("feed_to_feeder") > -1 && !1 === p.hasClass("dzsap-loaded")) {
                        Ce();
                        var i = 300;
                        if (e.is_android_good() && (i = 0), "with delay" !== t.call_from_aux) return i ? setTimeout((function() {
                            t.call_from_aux = "with delay", Ye(t)
                        }), i) : Ye(t), !1
                    }
                    if (g.audioType, e.player_stopOtherPlayers(dzsap_list, g), P && (ye({
                            called_from: "play_media() .. destroyed for rebuffer"
                        }), d.isInt(g.playFrom) && Le(g.playFrom, {
                            call_from: "destroyed_for_rebuffer_playfrom"
                        }), P = !1), "on" === l.google_analytics_send_play_event && window._gaq && !1 === x && (window._gaq.push(["_trackEvent", "ZoomSounds Play", "Play", "zoomsounds play - "]), x = !0), window.ga || window.__gaTracker && (window.ga = window.__gaTracker), "on" === l.google_analytics_send_play_event && window.ga && !1 === x && (window.console && console.log("sent event"), x = !0, window.ga("send", {
                            hitType: "event",
                            eventCategory: "zoomsounds play - ",
                            eventAction: "play",
                            eventLabel: "zoomsounds play - "
                        })), g._sourcePlayer && g._sourcePlayer.get(0) && g._sourcePlayer.get(0).api_pause_media_visual && g._sourcePlayer.get(0).api_play_media_visual({
                            api_report_play_media: !1
                        }), g._actualPlayer) {
                        var s = {
                            type: g.actualDataTypeOfMedia,
                            fakeplayer_is_feeder: "on",
                            call_from: "play_media_audioplayer"
                        };
                        try {
                            return "click_playpause" === t.called_from && l.parentgallery && (l.parentgallery.get(0).api_regenerate_sync_players_with_this_playlist(), g._actualPlayer.get(0).api_regenerate_playerlist_inner()), g._actualPlayer && g._actualPlayer.length && g._actualPlayer.data("feeding-from") !== p.get(0) && (s.called_from = "play_media from player 22 " + p.attr("data-source") + " < -  old call from - " + t.called_from, g._actualPlayer.get(0).api_change_media && g._actualPlayer.get(0).api_change_media(p, s), !1 === p.hasClass("first-played") && p.data("promise-to-play-footer-player-from") && (Le(p.data("promise-to-play-footer-player-from")), setTimeout((function() {
                                p.data("promise-to-play-footer-player-from", "")
                            }), 1e3))), setTimeout((function() {
                                g._actualPlayer.get(0) && g._actualPlayer.get(0).api_play_media && g._actualPlayer.get(0).api_play_media({
                                    called_from: "[feed_to_feeder]"
                                })
                            }), 100), void("off" === g.ajax_view_submitted && r.ajax_submit_views.bind(g)())
                        } catch (e) {
                            console.log("no fake player..", e)
                        }
                    }
                    "youtube" === g.audioType && dzsap_youtube_playMedia(g, t, g.youtube_currentId), g.audioType, "youtube" === g.audioType && Ge(),
                        function(a, t, i) {
                            (async function() {
                                return new Promise(((t, i) => {
                                    ! function(t, i) {
                                        a.cthis.attr("data-original-type") || (a.$mediaNode_ && a.$mediaNode_.play ? e.is_ios() && null !== a.spectrum_audioContext && "object" == typeof a.spectrum_audioContext ? (a.spectrum_audioContextBufferSource = a.spectrum_audioContext.createBufferSource(), a.spectrum_audioContextBufferSource.buffer = a.spectrum_audioContext_buffer, a.spectrum_audioContextBufferSource.connect(a.spectrum_audioContext.destination), a.spectrum_audioContextBufferSource.start(0, a.lastTimeInSeconds), t({
                                            resolve_type: "playing_context"
                                        })) : e.is_ie() ? (a.$mediaNode_.play(), t({
                                            resolve_type: "started_playing"
                                        })) : a.$mediaNode_.play().then((e => {
                                            t({
                                                resolve_type: "started_playing"
                                            })
                                        })).catch((e => {
                                            i({
                                                error_type: "did not want to play",
                                                error_message: e
                                            })
                                        })) : null == a._actualPlayer && (a.isPlayPromised = !0))
                                    }(t, i)
                                }))
                            })().then((e => {
                                t(e)
                            })).catch((e => {
                                i(e)
                            }))
                        }(g, (() => {
                            Ge(), "wave" === l.scrubbar_type && "on" === l.skinwave_enableSpectrum && e.player_initSpectrum(g), g._sourcePlayer ? (window.dzsap_currplayer_focused = g._sourcePlayer.get(0), g._sourcePlayer.get(0) && g._sourcePlayer.get(0).api_pause_media_visual && g._sourcePlayer.get(0).api_try_to_submit_view()) : (window.dzsap_currplayer_focused = p.get(0), Je()), "on" === g.keyboard_controls.play_trigger_step_back && dzsap_currplayer_focused && dzsap_currplayer_focused.api_step_back(g.keyboard_controls.step_back_amount)
                        }), (e => {
                            console.log("error autoplay playing -  ", e), setTimeout((() => {
                                Ue(), console.log("trying to pause")
                            }), 30)
                        }))
                }

                function Je() {
                    "auto" === g.ajax_view_submitted && (g.ajax_view_submitted = "off"), "off" === g.ajax_view_submitted && r.ajax_submit_views.bind(g)()
                }
                window.dzsap_player_index++, g.timeModel.getSampleTimesFromDom(),
                    function() {
                        if (p.hasClass("dzsap-inited")) return !1;
                        if (g.play_media_visual = Ge, g.play_media = Ye, g.pause_media = Ue, g.pause_media_visual = We, g.seek_to = Le, g.reinit = oe, g.handle_end = qe, g.init_loaded = Ce, g.scrubbar_reveal = pe, g.calculate_dims_time = ie, g.struct_generate_thumb = ue, g.check_multisharer = he, g.setup_structure_scrub = ge, g.setup_structure_sanitizers = me, g.destroy_cmedia = ve, g.view_drawCurrentTime = Pe, g.setupStructure_thumbnailCon = ue, g.setup_pcm_random_for_now = fe, g.handleResize = Ae, g.destroy_media = be, p.css({
                                opacity: ""
                            }), p.addClass("dzsap-inited"), window.dzsap_player_index++, g.keyboard_controls = e.dzsap_generate_keyboard_controls(), e.configureAudioPlayerOptionsInitial(p, l, g), "on" == l.loop && (S = !0), e.player_detect_skinwave_mode.bind(g)(), "skin-default" === l.design_skin && "default" === l.design_thumbh && (p.height(), j = !0), e.dzsap_is_mobile() && (o("body").addClass("is-mobile"), "on" === l.mobile_delete && e.player_delete(g), "on" === l.mobile_disable_fakeplayer && g.cthis.attr("data-fakeplayer", "")), e.player_viewApplySkinWaveModes(g), l.design_thumbh, e.playerFunctions(g, "detectIds"), p.attr("data-fakeplayer") && e.player_determineActualPlayer(g), g.cthis.addClass("scrubbar-type-" + l.scrubbar_type), e.player_determineHtmlAreas(g), "on" === window.dzsap_settings.syncPlayers_buildList && (0, e.player_syncPlayers_buildList)(), e.player_getPlayFromTime(g), e.player_adjustIdentifiers(g), e.player_identifySource(g), e.player_identifyTypes(g), "youtube" === g.audioType) {
                            window.dzsap_get_base_url(), console.log("window.dzsap_base_url- ", window.dzsap_base_url);
                            const e = window.dzsap_base_url ? window.dzsap_base_url + "/parts/youtube/dzsap-youtube-functions.js" : "";
                            d.loadScriptIfItDoesNotExist(e, window.dzsap_youtube_functions_inited).then((e => {
                                dzsap_youtube_functions_init(g)
                            }))
                        }
                        if (g.audioTypeSelfHosted_streamType = "", "selfHosted" === g.audioType && (p.attr("data-streamtype") && "off" !== p.attr("data-streamtype") ? (g.audioTypeSelfHosted_streamType = p.attr("data-streamtype"), g.data_source, p.addClass("is-radio-type")) : g.audioTypeSelfHosted_streamType = ""), g.audioTypeSelfHosted_streamType, !p.hasClass("audioplayer")) {
                            if (b = void 0 !== p.attr("id") ? p.attr("id") : "ap" + f++, g.youtube_currentId = "ytplayer_" + b, p.removeClass("audioplayer-tobe"), p.addClass("audioplayer"), Se(), setTimeout((function() {
                                    Se()
                                }), 1e3), "off" === l.cueMedia && (p.addClass("cue-off"), l.autoplay = "on"), "soundcloud" === g.audioType && u.retrieve_soundcloud_url(g), m.setup_structure(g), "wave" !== l.scrubbar_type || "selfHosted" !== g.audioType && "soundcloud" !== g.audioType && "fake" !== g.audioType || "on" !== l.skinwave_comments_enable || _.comments_setupCommentsInitial(g), "on" === l.autoplay && "on" === l.cueMedia && (g.increment_views = 1), "on" === l.cueMedia && "soundcloud" !== g.audioType)
                                if ((e.is_android() || e.is_ios()) && p.find(".playbtn").bind("click", Ye), g.data_source && g.data_source.indexOf("{{generatenonce}}") > -1) e.player_service_getSourceProtection(g).then((e => {
                                    e && (p.attr("data-source", e), ye({
                                        called_from: "nonce generated",
                                        newSource: e
                                    }))
                                }));
                                else {
                                    const a = e.player_isGoingToSetupMediaNow(g);
                                    "selfHosted" === g.audioType && ("icecast" !== g.audioTypeSelfHosted_streamType && "shoutcast" !== g.audioTypeSelfHosted_streamType || (("icecast" === g.audioTypeSelfHosted_streamType || g.radio_isGoingToUpdateArtistName || g.radio_isGoingToUpdateSongName) && e.player_icecastOrShoutcastRefresh(g), setInterval((function() {
                                        e.player_icecastOrShoutcastRefresh(g)
                                    }), 1e4))), a && ye({
                                        called_from: "normal setup media .. --- icecast must wait"
                                    })
                                }
                            else p.find(".playbtn").bind("click", _e), p.find(".scrubbar").bind("click", _e), Ae();
                            e.player_determineStickToBottomContainer(g), e.player_stickToBottomContainerDetermineClasses(g), g.timeModel.initObjects(), g.setup_media = ye, p.get(0).classInstance = g, p.get(0).api_init_loaded = Ce, p.get(0).api_destroy = de, p.get(0).api_play = Ye, p.get(0).api_set_volume = De, p.get(0).api_get_last_vol = ke, p.get(0).api_get_source = () => g.data_source, p.get(0).api_click_for_setup_media = _e, p.get(0).api_handleResize = Ae, p.get(0).api_set_playback_speed = Be, p.get(0).api_change_media = function(a, i) {
                                return function(o, r = {}) {
                                    var l = {
                                        type: "",
                                        fakeplayer_is_feeder: "off",
                                        called_from: "default",
                                        source: "default",
                                        pcm: "",
                                        artist: "",
                                        song_name: "",
                                        thumb: "",
                                        thumb_link: "",
                                        autoplay: "on",
                                        cue: "on",
                                        feeder_type: "player",
                                        source_player_do_not_update: "off",
                                        playerid: ""
                                    };
                                    a.ajax_view_submitted = "on";
                                    var d = {
                                            ...l,
                                            ...r
                                        },
                                        _ = a.initOptions,
                                        c = o,
                                        p = !0,
                                        u = !1,
                                        m = !1;
                                    let h = "";
                                    c && c.attr && (m = !0), a.reinit_resetMetrics(), a.reinit_beforeChangeMedia(), "string" == typeof c && (u = !0), i(".current-feeder-for-parent-player").removeClass("current-feeder-for-parent-player"), a.$reflectionVisualObject && a.$reflectionVisualObject.removeClass("is-playing"), u && (h = c), m && (h = c.attr("data-source"), a.$reflectionVisualObject = c, d = {
                                        ...d,
                                        ...e.sanitizeObjectForChangeMediaArgs(c)
                                    }), d.source && "default" != d.source && (h = d.source), a.data_source === h && (p = !1), p && a._sourcePlayer && (a._sourcePlayer.get(0).api_pause_media_visual({
                                        call_from: "change_media"
                                    }), a._sourcePlayer.get(0).api_set_timeVisualTotal(0)), a.cthis.data("original-settings") || "fake" === a.data_source || a.cthis.data("original-settings", e.sanitizeObjectForChangeMediaArgs(a.cthis));
                                    const f = a.data_source;
                                    if (a.data_source = h, (!(u || !c.hasClass("audioplayer") && !c.hasClass("is-zoomsounds-source-player")) || "on" === d.fakeplayer_is_feeder) && (a.set_sourcePlayer(c), a._sourcePlayer && (a.cthis.data("feeding-from", a._sourcePlayer.get(0)), a._sourcePlayer.addClass("current-feeder-for-parent-player"))), !u && c && (c && c.attr("data-playerid") ? a.cthis.attr("data-feed-playerid", c.attr("data-playerid")) : (a.cthis.attr("data-feed-playerid", ""), d.playerid = "")), f === h) return a.cthis.hasClass("is-playing") ? a.pause_media() : a.play_media(), !1;
                                    "detect" !== d.type && "audio" !== d.type && "normal" !== d.type || (d.type = "selfHosted"), a.cthis.removeClass("meta-loaded"), a.cthis.parent().hasClass("audioplayer-was-loaded") && (a.cthis.parent().addClass("audioplayer-loaded"), i("body").addClass("footer-audioplayer-loaded"), a.cthis.parent().removeClass("audioplayer-was-loaded")), a.$stickToBottomContainer && a.$stickToBottomContainer.addClass("audioplayer-loaded"), a.cthis.removeClass(t.O.ERRORED_OUT_CLASS), a.destroy_media(), a.cthis.attr("data-source", d.source);
                                    var g = d.type;
                                    if ("mediafile" === d.type && (d.type = "audio"), d.type && ("soundcloud" === d.type && (d.type = "audio"), "album_part" === d.type && (d.type = "audio"), a.cthis.attr("data-type", d.type), a.audioType = d.type, _.type = d.type), "skin-wave" === _.design_skin && ("canvas" === _.skinwave_wave_mode && (a._sourcePlayer ? a.data_source = c.attr("data-source") : "string" == typeof c && (a.data_source = c), c && d.pcm ? (a.cthis.attr("data-pcm", c.attr("data-pcm")), n.scrubModeWave__view_transitionIn(a, c.attr("data-pcm"))) : (e.player_reinit_findIfPcmNeedsGenerating(a), n.scrubModeWave__checkIfWeShouldTryToGetPcm(a))), d.thumb && (a.cthis.find(".the-thumb").length ? a.cthis.find(".the-thumb").css("background-image", "url(" + d.thumb + ")") : (a.cthis.attr("data-thumb", d.thumb), a.setupStructure_thumbnailCon()))), d.thumb ? (a.cthis.find(".the-thumb").length ? a.cthis.find(".the-thumb").css("background-image", "url(" + d.thumb + ")") : (a.cthis.attr("data-thumb", d.thumb), a.setupStructure_thumbnailCon()), a.cthis.removeClass("does-not-have-thumb"), a.cthis.addClass("has-thumb")) : (a.cthis.addClass("does-not-have-thumb"), a.cthis.removeClass("has-thumb")), "" === d.pcm && a.setup_pcm_random_for_now(), e.player_adjustIdentifiers(a), console.log("selfClass._sourcePlayer-  ", a._sourcePlayer), console.log("_sourceForChange - ", c), !u && c) {
                                        var y = null;
                                        c.find(".feed-dzsap-for-extra-html-right").length ? y = c.find(".feed-dzsap-for-extra-html-right").eq(0) : a._sourcePlayer && a._sourcePlayer.attr("data-playerid") && i(document).find('.feed-dzsap-for-extra-html-right[data-playerid="' + a._sourcePlayer.attr("data-playerid") + '"]').length && (y = i(document).find('.feed-dzsap-for-extra-html-right[data-playerid="' + a._sourcePlayer.attr("data-playerid") + '"]').eq(0)), console.log("$feedExtraHtmlRightFromSource - ", y), y && a.classMetaParts.set_extraHtmlFloatRight(y.html())
                                    }
                                    if (d.artist && a.cthis.find(".the-artist").html(d.artist), d.song_name && a.cthis.find(".the-name").html(d.song_name), "on" === l.source_player_do_not_update && a.set_sourcePlayer(null), "soundcloud" === g && -1 === d.source.indexOf("api.soundcloud") ? (a.data_source = d.source, a.isPlayPromised = !0, setTimeout((function() {
                                            a.isPlayPromised = !0
                                        }), 501), s.retrieve_soundcloud_url(a)) : a.setup_media({
                                            called_from: "change_media"
                                        }), a.timeModel.getSampleTimesFromDom(a._sourcePlayer), "fake" === a.audioType) return !1;
                                    a.initOptions.action_audio_change_media && a.initOptions.action_audio_change_media(d.source, d), "on" === d.autoplay && (a.play_media_visual(), setTimeout((function() {
                                        a.play_media({
                                            called_from: "changeMediaArgs.autoplay"
                                        })
                                    }), 500)), a.reinit(), setTimeout((function() {
                                        a.handleResize(null, {
                                            called_from: "change_media"
                                        })
                                    }), 100)
                                }
                            }(g, o), p.get(0).api_seek_to_perc = Ee, p.get(0).api_seek_to = Le, p.get(0).api_seek_to_visual = Fe, p.get(0).api_visual_set_volume = Qe, p.get(0).api_destroy_listeners = re, p.get(0).api_pause_media = Ue, p.get(0).api_get_media_isLoopActive = () => S, p.get(0).api_media_toggleLoop = ze, p.get(0).api_pause_media_visual = We, p.get(0).api_play_media = Ye, p.get(0).api_play_media_visual = Ge, p.get(0).api_handle_end = qe, p.get(0).api_change_visual_target = se, p.get(0).api_change_design_color_highlight = ne, p.get(0).api_draw_scrub_prog = Se, p.get(0).api_draw_curr_time = Pe, p.get(0).api_get_times = g.timeModel.refreshTimes, p.get(0).api_check_time = $e, p.get(0).api_sync_players_goto_next = Ne, p.get(0).api_sync_players_goto_prev = Ie, p.get(0).api_regenerate_playerlist_inner = function() {
                                g.classFunctionalityInnerPlaylist && g.classFunctionalityInnerPlaylist.playlistInner_setupStructureInPlayer()
                            }, p.get(0).api_step_back = function(e) {
                                e || (e = g.keyboard_controls.step_back_amount), Le(g.timeCurrent - e)
                            }, p.get(0).api_step_forward = function(e) {
                                e || (e = g.keyboard_controls.step_back_amount), Le(g.timeCurrent + e)
                            }, p.get(0).api_playback_speed = function(e) {
                                g.$mediaNode_ && g.$mediaNode_.playbackRate && (g.$mediaNode_.playbackRate = e)
                            }, p.get(0).api_set_action_audio_play = function(e) {
                                Y = e
                            }, p.get(0).api_set_action_audio_pause = function(e) {
                                X = e
                            }, p.get(0).api_set_action_audio_end = function(e) {
                                G = e, p.data("has-action-end", "on")
                            }, p.get(0).api_set_action_audio_comment = function(e) {
                                g.action_audio_comment = e
                            }, p.get(0).api_try_to_submit_view = Je, l.action_audio_play && (Y = l.action_audio_play), l.action_audio_pause && (X = l.action_audio_pause), l.action_audio_play2 && (J = l.action_audio_play2), l.action_audio_end && (G = l.action_audio_end, p.data("has-action-end", "on")), $e({
                                fire_only_once: !0
                            }), "skin-minimal" === l.design_skin && $e({
                                fire_only_once: !0
                            }), p.on("click", ".dzsap-repeat-button,.dzsap-loop-button,.btn-zoomsounds-download,.zoomsounds-btn-step-backward,.zoomsounds-btn-step-forward,.zoomsounds-btn-go-beginning,.zoomsounds-btn-slow-playback,.zoomsounds-btn-reset, .tooltip-indicator--btn-footer-playlist", xe), p.on("mouseenter", xe), p.on("mouseleave", xe), g.$conPlayPause.on("click", Oe), p.on("click", ".skip-15-sec", (function() {
                                p.get(0).api_step_forward(15)
                            })), o(window).on("resize.dzsap", Ae), Ae(), g._scrubbar && g._scrubbar.get(0) && g._scrubbar.get(0).addEventListener("touchstart", (function(e) {
                                g.player_playing && (F = !0)
                            }), {
                                passive: !0
                            }), o(document).on("touchmove", (function(e) {
                                if (F) return B = e.originalEvent.touches[0].pageX, (D = B - g._scrubbar.offset().left) < 0 && (D = 0), D > g._scrubbar.width() && (D = g._scrubbar.width()), Ee(D / g._scrubbar.width(), {
                                    call_from: "touch move"
                                }), !1
                            })), o(document).on("touchend", (function(e) {
                                F = !1
                            })), l.skinwave_comments_mode_outer_selector && (g.$commentsSelector = o(l.skinwave_comments_mode_outer_selector), g.$commentsSelector.data ? (g.$commentsSelector.data("parent", p), window.dzsap_settings.comments_username && g.$commentsSelector.find(".comment_email,*[name=comment_user]").remove(), g.$commentsSelector.on("click", ".dzstooltip--close,.comments-btn-submit", _.comments_selector_event), g.$commentsSelector.on("focusin", "input", _.comments_selector_event), g.$commentsSelector.on("focusout", "input", _.comments_selector_event)) : console.log("%c, data not available .. ", "color: #990000;", o(l.skinwave_comments_mode_outer_selector))), p.off("click", ".btn-like"), p.on("click", ".btn-like", le), e.waitForScriptToBeAvailableThenExecute(window.dzsap_part_starRatings_loaded, (function() {
                                window.dzsap_init_starRatings_from_dzsap(g)
                            })), setTimeout((function() {
                                Ae(), "canvas" === l.skinwave_wave_mode && (ie(), setTimeout((function() {
                                    ie()
                                }), 100))
                            }), 100), p.find(".btn-menu-state").eq(0).bind("click", ce), p.on("click", ".prev-btn,.next-btn", xe)
                        }
                    }()
            }
        }
        window.dzsap_singleton_ready_calls_is_called = !1, window.dzsap_get_base_url = function() {
            window.dzsap_base_url = d.getBaseUrl("dzsap_base_url", "audioplayer.js")
        }, window.dzsap_currplayer_focused = null, window.dzsap_currplayer_from_share = null, window.dzsap_mouseover = !1, window.dzsap_init_allPlayers = function(e) {
            e(".audioplayer.auto-init,.audioplayer-tobe.auto-init").each((function() {
                var a = e(this);
                !0 === a.hasClass("audioplayer-tobe") && window.dzsap_init && dzsap_init(a, {
                    init_each: !0
                })
            }))
        }, async function(e, a) {
            return new Promise(((e, a) => {
                if (window.jQuery) e("jQuery loaded");
                else {
                    var i = document.createElement("script");
                    i.onload = function() {
                        window.jQuery ? e("jQuery loaded") : a("error loading")
                    }, i.src = t.O.URL_JQUERY, document.head.appendChild(i)
                }
                setTimeout((() => {
                    a("error loading")
                }), 15e3)
            }))
        }().then((() => {
            window.dzsap_settings || (window.dzsap_settings = {}),
                function(a) {
                    Math.easeIn = function(e, a, t, i) {
                        return -t * (e /= i) * (e - 2) + a
                    }, e.assignHelperFunctionsToJquery(a), a.fn.audioplayer = function(t) {
                        var i, s = Object.assign({}, __webpack_require__(424).P);
                        i = e.convertPluginOptionsToFinalOptions(this, s, t), this.each((function() {
                            return new g(this, i, a), this
                        }))
                    }, p.registerToJquery(a)
                }(jQuery), jQuery(document).ready((function(a) {
                    window.dzsap_singleton_ready_calls_is_called || (0, e.dzsap_singleton_ready_calls)(), dzsag_init(".audiogallery.auto-init", {
                        init_each: !0
                    }), e.jQueryAuxBindings(a)
                })), jQuery(document).ready((function(e) {
                    window.dzsap_init_allPlayers(e)
                }))
        })).catch((e => {
            console.log(e)
        })), window.dzsap_init = function(a, t) {
            if (void 0 !== t && void 0 !== t.init_each && !0 === t.init_each) {
                var i = 0;
                for (var s in t) i++;
                1 === i && (t = void 0), jQuery(a).each((function() {
                    var e = jQuery(this);
                    t && void 0 === t.call_from && (t.call_from = "dzsap_init"), e.audioplayer(t)
                }))
            } else jQuery(a).audioplayer(t);
            window.dzsap_lasto = t, e.dzsapInitjQueryRegisters()
        }, e.playerRegisterWindowFunctions()
    })()
})();
//# sourceMappingURL=audioplayer.js.map