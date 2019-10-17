require('./bootstrap');

const findWord = () => {
    const searchWord = $('input[name="search_word"]').val();

    axios.get(
        '/find-word',
        {
            params: {
                searchWord
            }
        }
    )
        .then(
            response => {
                $('input[name="search_word"]').val('')

                const {word} = response.data;

                if (!word) {
                    newWord(searchWord);
                } else {
                    showWord(word);
                }
            }
        )
        .catch(
            error => showError(error)
        )
};

const newWord = word => {
    $('#show_word').addClass('hidden');
    $('#new_word').removeClass('hidden');

    $('input[name="new_word"]').val(word);
    $('input[name="new_transcription"]').val('').focus();
};

const showWord = word => {
    $('#show_word').removeClass('hidden');
    $('#new_word').addClass('hidden');

    $('#word').text(word.text);
    $('#transcription').text(`[ ${word.transcription} ]`);
    $('#new_translation_frm').data('wordId', word.id);

    $('input[name="translation"]').focus();

    const {translations} = word;

    $('#translations tbody').empty();

    translations.map(
        translation => showTranslation(translation)
    );
};

const showTranslation = translation => {
    $('#translations tbody')
        .append(
            $('<tr />')
                .attr('id', translation.id)
                .append(
                    $('<td />').html(translation.text)
                )
                .append(
                    $('<td />').html(translation.example)
                )
                .append(
                    $('<td />')
                        .addClass('collapsing')
                        .append(
                            $('<div />')
                                .addClass('ui button icon red basic remove-translation')
                                .append(
                                    $('<i />')
                                        .addClass('trash icon')
                                )
                        )
                )
        )
};

const addWord = () => {
    const newWord = {
        text: $('input[name="new_word"]').val(),
        transcription: $('input[name="new_transcription"]').val(),
    }

    axios.post(
        '/add-word',
        newWord
    )
        .then(
            response => {
                showWord(response.data);
            }
        )
        .catch(
            error => showError(error)
        )
};

const addTranslation = () => {
    const newWord = {
        wordId: $('#new_translation_frm').data('wordId'),
        text: $('input[name="translation"]').val(),
        example: $('input[name="example"]').val(),
    }

    axios.post(
        '/add-translation',
        newWord
    )
        .then(
            response => {
                $('input[name="translation"]').val('').focus();
                $('input[name="example"]').val('');

                showTranslation(response.data)
            }
        )
        .catch(
            error => showError(error)
        )
};

const removeTranslation = translationId => {
    const translation = {
        translationId
    }

    axios.post(
        '/remove-translation',
        translation
    )
        .then(
            response => {
                $('#' + translationId).remove();
            }
        )
        .catch(
            error => showError(error)
        )
};

$(document).ready(function () {

    $('#find_word_frm').on('submit', function (event) {
        event.preventDefault();

        findWord();
    });

    $('#new_word_frm').on('submit', function (event) {
        event.preventDefault();

        addWord();
    });

    $('#new_translation_frm').on('submit', function (event) {
        event.preventDefault();

        addTranslation();
    });

    $('#translations').on('click', '.remove-translation',function (event) {
        event.preventDefault();

        const translationId = $(this).parents('tr').attr('id');

        removeTranslation(translationId);
    });

});
