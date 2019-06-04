function search() {
    var texte = $("#searchSaisie").val();
    var offset = 0;
    var span = "<span style='background-color:yellow'>";
    var span2 = "</span>";
    var re = new RegExp('(' + texte + ')(?![^<]*>)', "gi");
    $('span').contents().unwrap();

    var content = $('#contenu').html();
    offset = content.indexOf(texte);
    if (offset >= 0) {
        content = content.replace(re, span + texte + span2);
        $('#contenu').html(content);
    }

}

/* $("#searchSaisie").on("change", search); */

$("#searchButton").on("click", search);