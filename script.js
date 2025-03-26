$(function() {
    const defaultModule = 'cars';

    function loadContent() {
        const client = getCookie("client");
        if (client!==null) 
        {
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

    function clearContent() {
        $('.dynamic-div').empty();
    }

    function getCookie(name) {
        return document.cookie
            .split("; ")
            .find(row => row.startsWith(name + "="))
            ?.split("=")[1] || null;
    }

    function attachRowClickHandler(module) {
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

        const handler = handlers[module];
        if (handler) {
            $(handler.selector).on('click', function() {
                const id = $(this).data(handler.dataKey);

                $.post(handler.url, { [handler.dataKey]: id }, function(data) {
                    $('.dynamic-div').html(data);
                    attachBackButtonHandler();
                });
            });
        }
    }

    function attachBackButtonHandler() {
        $('#back-button').on('click', function() {
            clearContent();
            loadContent();
        });
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

    loadContent();

    $('#client-buttons button').on('click', function() {
        const client = $(this).data('client');
        document.cookie = "client=" + client + "; Secure";
        clearContent();
        loadContent();
    });

    $('#module-selector').on('change', function () {
        clearContent();
        loadContent();
    });
});