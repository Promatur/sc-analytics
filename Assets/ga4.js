function gtag() {
    dataLayer.push(arguments)
}

let sc_gaInfo = document.getElementById("_ga4");
let sc_consent = sc_gaInfo.dataset.consent === "true";
let sc_tIDs = sc_gaInfo.dataset.keys.split(";");
let sc_clientId = sc_gaInfo.dataset.clientid;
let sc_sessionId = sc_gaInfo.dataset.sessionid;
let sc_sessionNumber = sc_gaInfo.dataset.sessionnumber;
window.dataLayer = window.dataLayer || [];
sc_tIDs.forEach(t => window["ga-disable-" + t] = !sc_consent);
gtag("js", new Date);
sc_tIDs.forEach(e => gtag("config", e, {
    anonymize_ip: true,
    send_page_view: false,
    client_id: sc_clientId,
    session_id: sc_sessionId,
    session_number: sc_sessionNumber,
    link_attribution: true
}));

function sendAnalyticsEvent(action, category, label, value) {
    if (!label) label = "";
    if (!value) value = 0;
    gtag('event', action, {
        'event_category': category,
        'event_label': label,
        'value': value
    });
}