const defaultModule = 'cars';
const handlers = {
    'cars': {
        selector: '.car-table tbody tr',
        dataKey: 'car-id',
        url: 'views/cars/edit.php'
    },
    'garages': {
        selector: '.garage-table tbody tr',
        dataKey: 'garage-id',
        url: 'views/garages/edit.php'
    }
};

function loadContent() {
    const client = getCookie("client");
    if (client !== null) {
        updateModules(client);

        const module = $(".dynamic-div").data("module");
        const script = $(".dynamic-div").data("script");

        const url = `includes/loader.php?module=${module}&script=${script}`;

        $.get(url)
            .done(function (data) {
                $(".dynamic-div").html(data);
                attachRowClickHandler(module);
            })
            .fail(function (jqXHR) {
                if (jqXHR.status === 403) {
                    $(".dynamic-div").html('<div class="alert alert-danger">Accès interdit.</div>');
                } else if (jqXHR.status === 404) {
                    $(".dynamic-div").html('<div class="alert alert-warning">Module introuvable.</div>');
                } else {
                    $(".dynamic-div").html('<div class="alert alert-danger">Une erreur est survenue.</div>');
                }
            });
    }
}

function updateModules(client) {
    if (client === 'clientb') {
        $('#module-selector').show();
        const activeModule = $('#module-selector').val();
        $(".dynamic-div").data("module", activeModule);
    } else {
        $('#module-selector').hide();
        $(".dynamic-div").data("module", defaultModule);
    }
}