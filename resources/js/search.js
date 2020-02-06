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
                                    .attr(
                                        {
                                            id: word.id,
                                        }
                                    )
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
                                                            'href': '#'
                                                        }
                                                    )
                                                    .addClass('circular ui icon button green show-edit-word-frm')
                                                    .append(
                                                        $('<i />')
                                                            .addClass('icon pencil')
                                                    )
                                            )
                                    )
                                    .append(
                                        $('<td />')
                                            .addClass('collapsing center aligned')
                                            .append(
                                                $('<a />')
                                                    .attr(
                                                        {
                                                            'href': '#'
                                                        }
                                                    )
                                                    .addClass('circular ui icon button green basic show-translations-frm')
                                                    .append(
                                                        $('<i />')
                                                            .addClass('icon list')
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

const editWord = wordId => {
    axios.get(
        '/word/find',
        {
            params: {
                wordId
            }
        }
    )
        .then(
            response => showWord(response.data)
        )
        .catch(
            error => showError(error)
        )
};

const showWord = word => {
    showEditWordForm();

    const form = $('#edit_word_frm');

    $('input[name="word_id"]', form).val(word.id);
    $('input[name="transcription"]', form).val(word.transcription);
    $('input[name="word"]', form).val(word.text).focus();
};

const saveWord = () => {
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
            () => {
                showSearchForm();

                searchWords();
            }
        )
        .catch(
            error => showError(error)
        )
};

// Translations
const editTranslations = wordId => {
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
                let {id, text, translations} = response.data;

                showTranslations(id, text, translations);
            }
        )
        .catch(
            error => showError(error)
        )
};

const showTranslations = (wordId, originalWord, translations) => {
    showTranslationsForm();

    // Form
    const form = $('#translations_frm');

    $('input[name="word_id"]', form).val(wordId);
    $('input[name="translation"]', form).val('');
    $('input[name="example"]', form).val('').focus();

    // Original word
    $('#original_word').text(originalWord);

    // Table
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

const addTranslation = () => {
    const form = $('#translations_frm');

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
                $('input[name="translation"]').val('');
                $('input[name="example"]').val('').focus();

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
    $('#new_word_frm input:first').focus();

    $('#words_list').addClass('hidden');

    $('#edit_word_frm').addClass('hidden');
    $('#search_frm').addClass('hidden');
    $('#translations_frm').addClass('hidden');
};

const showEditWordForm = () => {
    $('#edit_word_frm').removeClass('hidden');
    $('#edit_word_frm input').val('');

    $('#words_list').addClass('hidden');

    $('#new_word_frm').addClass('hidden');
    $('#search_frm').addClass('hidden');
    $('#translations_frm').addClass('hidden');
};

const showTranslationsForm = () => {
    $('#translations_frm').removeClass('hidden');
    $('#translations_frm input').val('');

    $('#words_list').addClass('hidden');

    $('#new_word_frm').addClass('hidden');
    $('#search_frm').addClass('hidden');
    $('#edit_word_frm').addClass('hidden');
};

const showSearchForm = () => {
    $('#search_frm').removeClass('hidden');
    $('#search_frm input').val('');

    $('#words_list').removeClass('hidden');

    $('#new_word_frm').addClass('hidden');
    $('#edit_word_frm').addClass('hidden');
    $('#translations_frm').addClass('hidden');
};

// Document
$(document).ready(function () {

    // Search
    searchWords();

    $('input[name="text_pattern"]').on('dblclick', function (event) {
        event.preventDefault();

        $(this).val('');

        searchWords();
    });

    $('input[name="text_pattern"]').on('keydown', function (event) {
        if (event.keyCode == 27) {
            $(this).val('');

            searchWords();
        }
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

    // New word
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

    // Edit word
    $('#words_list').on('click', '.show-edit-word-frm', function (event) {
        event.preventDefault();

        const wordId = $(this).parents('tr').attr('id');

        editWord(wordId);
    });

    $('#edit_word_frm').on('submit', function (event) {
        event.preventDefault();

        saveWord();
    });

    // Edit translations
    $('#words_list').on('click', '.show-translations-frm', function (event) {
        event.preventDefault();

        const wordId = $(this).parents('tr').attr('id');

        editTranslations(wordId);
    });

    $('#translations_frm').on('submit', function (event) {
        event.preventDefault();

        addTranslation();
    });

    $('#translations').on('click', '.remove-translation', function (event) {
        event.preventDefault();

        const translationId = $(this).parents('tr').attr('id');

        removeTranslation(translationId);
    });

});
