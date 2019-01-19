$(function () {
    var button = $("#new");
    var list = $("#ft_list");
    var max_id = 0;
    $.ajax({
        url: './select.php',
        type: 'POST',
        dataType: 'json',
        data: {
            val: "get"
        }
    }).done(function (data) {
        for (var n = 1; n < data.length; n++) {
            var str = String(data[n]);
            var i = parseInt(str);
            while (str.charAt(0) != "," && str) {
                str = str.substring(1);
            }
            str = str.substring(1);
            if (i > max_id) {
                max_id = i;
            }
            list.prepend("<div id='" + i + "'>" + str + "</div>");
        }
        list.children().on("click", function () {
            var r = confirm("Supprimer cet élément ?");
            var elem_id = $(this).attr('id');
            if (r) {
                $.ajax({
                    url: './delete.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: elem_id
                    }
                });
                $(this).remove();
            }
        });
    });

    button.on("click", function () {
        var ret = prompt("Élément à ajouter à la liste ?", "Nouvel élément");
        if (ret != null && ret != "") {
            addElemTop(ret);
        }
    });

    function addElemTop(text) {
        var elem_id = ++max_id;
        var elem = $("<div id='" + elem_id + "'>" + text + "</div>");
        list.prepend(elem);
        $.ajax({
            url: './insert.php',
            type: 'POST',
            dataType: 'json',
            data: {
                id: elem_id,
                text: text
            }
        });
        elem.on("click", function () {
            var r = confirm("Supprimer cet élément ?");
            var elem_id = $(this).attr('id');
            if (r) {
                $.ajax({
                    url: './delete.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: elem_id
                    }
                });
                $(this).remove();
            }
        });
    }
})