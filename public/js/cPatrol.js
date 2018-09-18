setInterval(checkPatroli(), 3000);

function checkPatroli(data, cluster) {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: apihost + "/v1/check/not-patrol-yet",
        // url: "http://local.apialamsutera.mbp/v1/check/not-patrol-yet",
    })
    .done(function( msg ) {
        if (msg.cluster.length > 0) {
            $('.patrolstatus').html('Patroli belum dilakukan di:');
            $.each( msg.cluster, function( key, value ) {
              $('.patrolstatuslist').append("<span style=\"display:block\">" + value + "</span>");
            });
        }

        // $('.patrolstatus').html(JSON.stringify(msg));
    });
}