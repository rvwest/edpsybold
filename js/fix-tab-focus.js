document.addEventListener("DOMContentLoaded", function () {
    // Force <a href="..."> elements to be tabbable
    document.querySelectorAll("a[href]").forEach(function (a) {
        a.setAttribute("tabindex", "0");
    });

    // Force all <button> elements to be tabbable
    document.querySelectorAll("button").forEach(function (btn) {
        btn.setAttribute("tabindex", "0");
    });
});