noMailNotice = document.createElement("div");
noMailNotice.setAttribute("class", "noMailNotice");
noMailNotice.innerHTML = "<span>Please add a mail address to your account so you can reset your password.</span>";
noMailNotice.innerHTML += "<div><button onclick='noMailOpen();'>Add E-Mail</button></div>";

window.addEventListener("load", function() {
    document.body.insertBefore(noMailNotice, document.body.firstChild);
}, false);

function noMailOpen() {
    if (!window.location.toString().includes("/settings")) window.location = "/settings";
}