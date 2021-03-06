var PaymentMethodHabblet = {
    init: function () {
        PaymentMethodHabblet.container = $("credits-methods"); PaymentMethodHabblet.accordion = new PaymentAccordion(PaymentMethodHabblet.container, "method-", "credits-read-more", "method-full-", "credits.navi.read_more", "credits.navi.close_fulltext"); PaymentMethodHabblet.hijaxHabboIdForms(PaymentMethodHabblet.container)
    }, hijaxHabboIdForms: function (A) {
        A.select(".habboid-form").each(function (B) { Event.observe(B, "submit", function (C) { Event.stop(C); PaymentMethodHabblet.updateForm(B) }) }); A.select(".habboid-other").each(function (B) {
            Event.observe(B, "click", function (D) {
                Event.stop(D); var C = B.parentNode.parentNode; new Ajax.Updater(C, habboReqPath + "/habblet/ajax/habboid", {
                    method: "post", parameters: B.href.substring(B.href.indexOf("?") + 1), onComplete: function (E) {
                        PaymentMethodHabblet.hijaxHabboIdForms(C)
                    }
                })
            })
        })
    }, updateForm: function (B) { var D = B.id.split("-").last(); var A = $("habboid-" + D); var C = Form.serialize(B); Element.wait(A); new Ajax.Updater(A, habboReqPath + "/habblet/ajax/habboid", { method: "post", parameters: C, onComplete: function (E) { PaymentMethodHabblet.hijaxHabboIdForms(A) } }) }
}; var PaymentAccordion = Class.create(Accordion, {
    toggleItems: function ($super, C, B, D) {
        if (this.animating) {
            return false
        } var A = this.openedItem; if (!A || (A && A.link != C)) { B.select(".habboid-form").each(function (E) { var F = E.id.split("-").last(); if (habboName && !$("habboid_name_" + F).value) { $("habboid_name_" + F).value = habboName; PaymentMethodHabblet.updateForm(E) } }) } $super(C, B, D)
    }
}); var Collectibles = function () {
    var D; var B = function () {
        Overlay.show();
        D = Dialog.createDialog("collectibles-dialog", L10N.get("collectibles.purchase.title"), 9001, 0, -1000, C); Dialog.setAsWaitDialog(D); Dialog.moveDialogToCenter(D); new Ajax.Request(habboReqPath + "habblet/ajax_collectiblesConfirm.php", {
            onComplete: function (E) {
                Dialog.setDialogBody(D, E.responseText); if (!!$("collectibles-close")) {
                    $("collectibles-close").observe("click", C)
                } if (!!$("collectibles-purchase")) { $("collectibles-purchase").observe("click", function (F) { Event.stop(F); A() }) }
            }
        })
    }; var A = function () {
        Dialog.setAsWaitDialog(D); new Ajax.Request(habboReqPath + "habblet/ajax_collectiblesPurchase.php", {
            onComplete: function (E) {
                Dialog.setDialogBody(D, E.responseText); if (!!$("collectibles-close")) {
                    $("collectibles-close").observe("click", C)
                }
            }
        })
    }; var C = function (E) { if (!!E) { Event.stop(E) } $("collectibles-dialog").remove(); Overlay.hide(); D = null }; return {
        init: function (E) {
            if (E > 0) {
                timerEl = $("collectibles-timeleft-value"); if (!!timerEl) {
                    new PrettyTimer(E, function (F) { timerEl.update(F) }, {
                        localizations: { days: L10N.get("time.days") + " ", hours: L10N.get("time.hours") + " ", minutes: L10N.get("time.minutes") + " ", seconds: L10N.get("time.seconds") }, endCallback: function () {
                            $("collectibles-purchase").hide()
                        }
                    })
                } $$(".collectibles-purchase-current").invoke("observe", "click", function (F) { Event.stop(F); B() })
            }
        }
    }
}();