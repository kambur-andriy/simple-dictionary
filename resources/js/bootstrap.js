window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Helpers
 */
window.startRequest = button => {
    button.addClass('disabled loading');
};

window.stopRequest = button => {
    button.removeClass('disabled loading');
};


window.showError = responseError => {

    $('#error_modal .header').empty();
    $('#error_modal .content').empty();

    if (responseError.response.status === 422) {

        const {message, errors} = responseError.response.data;

        $('#error_modal .header').text(message);
        $('#error_modal .content')
            .append(
                $('<div />')
                    .attr('id', 'errors_list')
                    .addClass('list')
            )

        for (let field in errors) {
            $('#errors_list')
                .append(
                    $('<li />')
                        .text(errors[field].join('; '))
                )
        }

    } else {

        const {message} = responseError.response.data;

        $('#error_modal .header').text(responseError);
        $('#error_modal .content').text(message);

    }

    $('#error_modal')
        .modal(
            {
                centered: false,
                blurring: true
            }
        )
        .modal('show');

};
