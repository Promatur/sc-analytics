let sc_matomoAllow = false;
let sc_matomoInfo = document.getElementById("_matomo");
let sc_matomoURL = sc_matomoInfo.dataset.url;
let sc_matomoPageViewId = sc_matomoInfo.dataset.pv;
let sc_matomoSiteId = sc_matomoInfo.dataset.siteid;
let sc_matomoVisitorId = sc_matomoInfo.dataset.visitorid;

let _paq = window._paq = window._paq || [];
if (!sc_matomoAllow)
    _paq.push(['requireCookieConsent']);
_paq.push(['setVisitorId', sc_matomoVisitorId]);
_paq.push(['setPageViewId', sc_matomoPageViewId]);

_paq.push(['enableLinkTracking']);
_paq.push(['enableHeartBeatTimer']);
_paq.push(['trackVisibleContentImpressions', true, 750]);
(function () {
    _paq.push(['setTrackerUrl', sc_matomoURL + 'matomo.php']);
    _paq.push(['setSiteId', sc_matomoSiteId]);
    let d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
    g.type = 'text/javascript';
    g.async = true;
    g.src = sc_matomoURL + 'matomo.js';
    s.parentNode.insertBefore(g, s);
})();

function sendAnalyticsEvent(action, category, label, value) {
    if (!label) label = "";
    if (!value) value = 0;
    _paq.push(['trackEvent', category, action, label, value]);
}