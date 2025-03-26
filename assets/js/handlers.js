function attachDefaultEventHandlers() {
    $('#client-buttons button').on('click', function () {
        const client = $(this).data('client');
        document.cookie = "client=" + client + "; Secure";
        reloadContent();
    });

    $('#module-selector').on('change', function () {
        reloadContent();
    });
}


function attachBackButtonHandler() {
    $('#back-button').on('click', function () {
        reloadContent();
    });
}

function attachRowClickHandler(module) {
    const handler = handlers[module];
    if (handler) {
        $(handler.selector).on('click', function () {
            const id = $(this).data(handler.dataKey);
            // Appel pour charge le détail
            $.post(handler.url, { [handler.dataKey]: id }, function(data) {
                $('.dynamic-div').html(data);
                attachBackButtonHandler();
            })
            .fail(function() {
                $('.dynamic-div').html('<div class="alert alert-danger">Erreur lors de l\'affichage du détail.</div>');
            });
        });
    }
}
