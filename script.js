$(function() { // .ready() handler
    function loadContent() {
        const client = getCookie('client');
        if (client!==null) 
        {
            const module = $('.dynamic-div').data('module');
            const script = $('.dynamic-div').data('script');

            const url = '/customs/' + client + '/modules/' + module + '/' + script + '.php';

            // Charge le titre
            $.get(url, function(data) {
                $('.dynamic-div').append(data);
            });

            // Charge la liste des voitures
            $.get('car-table-template.php', function(data) {
                $('.dynamic-div').append(data);
                attachRowClickHandler();
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

    function attachRowClickHandler() {
        $('#car-table-body tr').on('click', function() {
            const carID = $(this).data('car-id');
            console.log('Row clicked, car ID:', carID);
            $.post("edit.php", { carID: carID }, function(data) {
                $('.dynamic-div').html(data);
                attachBackButtonHandler();
            });
        });
    }

    function attachBackButtonHandler() {
        $('#back-button').on('click', function() {
            clearContent();
            loadContent();
        });
    }

    loadContent();

    $('#client-buttons button').on('click', function() {
        const client = $(this).data('client');
        document.cookie = "client=" + client + "; Secure";
        clearContent();
        loadContent();
    });
});