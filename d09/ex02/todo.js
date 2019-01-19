window.onload = function () {
    var button = document.getElementById("new");
    var list = document.getElementById("ft_list");
    var str = decodeURIComponent(getCookie());
    if (str && str != "" && str != null && str != "null") {
        list.innerHTML = str;
        var childs = list.childNodes;
        for (var i = 0; i < childs.length; i++) {
            childs[i].addEventListener("click", function () {
                var r = confirm("Supprimer cet élément ?");
                if (r) {
                    this.remove();
                    setCookie();
                }
            });
        }
    }

    button.addEventListener("click", function () {
        var ret = prompt("Élément à ajouter à la liste ?", "Nouvel élément");
        if (ret != null && ret != "") {
            addElemTop(ret);
        }
    });

    function setCookie() {
        var date = new Date();
        date.setTime(date.getTime() + 99999999999);
        document.cookie = "ftlist=" + encodeURIComponent(list.innerHTML) + "; expires= " + date.toGMTString () + "; path=/";
    }

    function getCookie() {
        var decoded = decodeURIComponent(document.cookie);
        var ca = decoded.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf("ftlist=") == 0) {
                return c.substring(7, c.length);
            }
        }
        return null;
    }

    function addElemTop(text) {
        var div = document.createElement("div");
        div.innerHTML = text;
        list.prepend(div);
        setCookie();
        div.addEventListener("click", function () {
            var r = confirm("Supprimer cet élément ?");
            if (r) {
                this.remove();
                setCookie();
            }
        });
    }
}