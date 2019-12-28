require('./bootstrap');

// Search
const searchWords = (textPattern = '', page = 1) => {
    axios.get(
        '/words/search',
        {
            params: {
                textPattern,
                page
            }
        }
    )
        .then(
            response => {
                $('#words_list tbody').empty();

                const {wordsList, pagination} = response.data;

                // Build list
                wordsList.forEach(
                    word => {
                        $('#words_list tbody')
                            .append(
                                $('<tr />')
                                    .append(
                                        $('<td />')
                                            .html(word.text)
                                    )
                                    .append(
                                        $('<td />')
                                            .addClass('collapsing center aligned')
                                            .html(word.transcription)
                                    )
                                    .append(
                                        $('<td />')
                                            .addClass('collapsing center aligned')
                                            .append(
                                                $('<a />')
                                                    .attr(
                                                        {
                                                            id: word.id,
                                                            'href': '#'
                                                        }
                                                    )
                                                    .addClass('circular ui icon button green show-edit-word-frm')
                                                    .append(
                                                        $('<i />')
                                                            .addClass('icon edit')
                                                    )
                                            )
                                    )
                            )
                    }
                );

                // Build pagination
                $('#words_list .pagination').empty().hide();

                if (pagination.lastPage > 1) {
                    for (let i = 1; i <= pagination.lastPage; i++) {
                        $('#words_list .pagination')
                            .append(
                                $('<a />')
                                    .attr('data-page', i)
                                    .addClass(`item page-item ${i === pagination.currentPage && 'active'}`)
                                    .html(i)
                            )
                    }

                    $('#words_list .pagination').show();
                }
            }
        )
        .catch(
            error => showError(error)
        )
};

const findWord = wordId => {
    axios.get(
        '/word/find',
        {
            params: {
                wordId
            }
        }
    )
        .then(
            response => {
                const word = response.data;

                showWord(word);
            }
        )
        .catch(
            error => showError(error)
        )
};

// Word
const addWord = () => {
    const form = $('#new_word_frm');

    const word = {
        text: $('input[name="word"]', form).val(),
        transcription: $('input[name="transcription"]', form).val(),
        translation: $('input[name="translation"]', form).val(),
        example: $('input[name="example"]', form).val()
    };

    axios.post(
        '/word/add',
        word
    )
        .then(
            response => {
                showSearchForm();

                searchWords();
            }
        )
        .catch(
            error => showError(error)
        )
};

const editWord = () => {
    const form = $('#edit_word_frm');

    const word = {
        wordId: $('input[name="word_id"]', form).val(),
        text: $('input[name="word"]', form).val(),
        transcription: $('input[name="transcription"]', form).val(),
    };

    axios.post(
        '/word/edit',
        word
    )
        .then(
            response => {
                const word = response.data;

                showWord(word);

                searchWords();
            }
        )
        .catch(
            error => showError(error)
        )
};

const showWord = word => {
    const form = $('#edit_word_frm');

    showEditWordForm();

    $('input[name="word_id"]', form).val(word.id);
    $('input[name="word"]', form).val(word.text);
    $('input[name="transcription"]', form).val(word.transcription);

    $('input[name="word"]', form).focus();

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
                        .addClass('collapsing center aligned')
                        .append(
                            $('<div />')
                                .addClass('ui button icon red basic fluid remove-translation')
                                .append(
                                    $('<i />')
                                        .addClass('trash icon')
                                )
                        )
                )
        )
};

// Translations
const addTranslation = () => {
    const form = $('#edit_word_frm');

    const translation = {
        wordId: $('input[name="word_id"]', form).val(),
        text: $('input[name="translation"]', form).val(),
        example: $('input[name="example"]', form).val()
    };

    axios.post(
        '/translation/add',
        translation
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
        '/translation/remove',
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

// Forms
const showNewWordForm = () => {
    $('#new_word_frm').removeClass('hidden');
    $('#new_word_frm input').val('');

    $('#edit_word_frm').addClass('hidden');
    $('#search_frm').addClass('hidden');
};

const showEditWordForm = () => {
    $('#edit_word_frm').removeClass('hidden');
    $('#edit_word_frm input').val('');

    $('#new_word_frm').addClass('hidden');
    $('#search_frm').addClass('hidden');
};

const showSearchForm = () => {
    $('#search_frm').removeClass('hidden');
    $('#search_frm input').val('');

    $('#new_word_frm').addClass('hidden');
    $('#edit_word_frm').addClass('hidden');
};

// Document
$(document).ready(function () {

    searchWords();

    $('input[name="text_pattern"]').on('dblclick', function (event) {
        event.preventDefault();

        $(this).val('');

        searchWords();
    });

    $('#search_frm').on('submit', function (event) {
        event.preventDefault();

        const textPattern = $('input[name="text_pattern"]', $(this)).val();

        searchWords(textPattern);
    });

    $('.pagination').on('click', '.item', function (event) {
        event.preventDefault();

        const textPattern = $('input[name="text_pattern"]', $(this)).val();
        const page = $(this).data('page');

        searchWords(textPattern, page);
    });

    $('#show_new_word_frm').on('click', function (event) {
        event.preventDefault();

        showNewWordForm();
    });

    $('#close_new_word_frm, #close_edit_word_frm').on('click', function (event) {
        event.preventDefault();

        showSearchForm();
    });

    $('#new_word_frm').on('submit', function (event) {
        event.preventDefault();

        addWord();
    });

    $('#edit_word_frm').on('submit', function (event) {
        event.preventDefault();

        editWord();
    });

    $('#words_list').on('click', '.show-edit-word-frm', function (event) {
        event.preventDefault();

        const wordId = $(this).attr('id');

        findWord(wordId);
    });

    $('#save_translation').on('click', function (event) {
        event.preventDefault();

        addTranslation();
    });

    $('#translations').on('click', '.remove-translation',function (event) {
        event.preventDefault();

        const translationId = $(this).parents('tr').attr('id');

        removeTranslation(translationId);
    });

});
