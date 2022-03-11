let sc_allowGA = !1;

function gtag() {
    dataLayer.push(arguments)
}

let sc_gaInfo = document.getElementById("_analytics");
let t = sc_gaInfo.dataset.keys.split(";"),
    u = sc_gaInfo.dataset.clientid;
window.dataLayer = window.dataLayer || [], t.forEach(t => window["ga-disable-" + t] = !sc_allowGA), (gtag("js", new Date), t.forEach(e => gtag("config", e, {
    anonymize_ip: true,
    send_page_view: false,
    client_id: u,
    link_attribution: true
})));

function sendAnalyticsEvent(action, category, label, value) {
    if (!label) label = "";
    if (!value) value = 0;
    gtag('event', action, {
        'event_category': category,
        'event_label': label,
        'value': value
    });
}