//Comentarios
var indexStorage = localStorage.length;
function save_todo() {
    var username = $("#usuario").val();
    var comment = $("#comentario").val();
    var titulo = $("#titulo").val();
    if (comment.length) {
        $.ajax({url: 'mobil/save_comments',
            data: {
                username: username,
                comment: comment,
                titulo: titulo,
                lugar_id: sessionStorage.lugar_id
            },
            type: 'post',
            dataType: "json",
            success: function(output) {
                todo = output.id_comment;
                $("#comments_list_" + sessionStorage.lugar_id).append('<li><a href="index.html"><h3>' + username + '</h3><p><strong>' + titulo +
                        '</strong></p><p>' + comment + '. < /p><p class="ui-li - aside"><strong>' + new Date() + '</strong></p></a></li>');
                //  Refresh list  so jquery mobile can apply iphone look to the list
                $("#comments_list_" + sessionStorage.lugar_id).listview();
                $("#comments_list_" + sessionStorage.lugar_id).listview("refresh");
            }
        });
        indexStorage++;
    }
}
//$('#add_comment').live('pageshow', function(event, ui) {
$(document).on('pageshow', '#add_comment', function() {
    $('#id_lugar').text(sessionStorage.lugar_id);
});