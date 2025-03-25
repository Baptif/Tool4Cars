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

    loadContent();

    $('#client-buttons button').on('click', function() {
        const client = $(this).data('client');
        document.cookie = "client=" + client + "; Secure";
        clearContent();
        loadContent();
    });
});