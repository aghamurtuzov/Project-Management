document.getElementById("hamburger").addEventListener("click", function () {
    var menu = document.getElementById("menu");
    if (menu.style.visibility === "hidden") {
        menu.style.opacity = "1";
        menu.style.visibility = "visible";
    } else {
        menu.style.opacity = "0";
        menu.style.visibility = "hidden";
    }
});
