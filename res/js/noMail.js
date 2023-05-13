noMailNotice = document.createElement("div");
noMailNotice.setAttribute("class", "noMailNotice");
noMailNotice.innerHTML = "<span>Please add a mail address to your account so you can reset your password.</span>";
noMailNotice.innerHTML += "<div><button onclick='noMailOpen();'>Add E-Mail</button></div>";

window.addEventListener("load", function() {
    document.body.insertBefore(noMailNotice, document.body.firstChild);
}, false);

const noMailOpen = () => window.open("https://accounttools.noten-app.de/email/add/", "_blank", "location=yes,height=800,width=800,scrollbars=yes,status=yes");