require('./bootstrap');

const getRandomWord = () => {
    axios.get(
        '/word/random'
    )
        .then(
            response => {
                showTrainingCard(response.data)
            }
        )
        .catch(
            error => showError(error)
        )
};

const showTrainingCard = trainingCard => {
    const replaceRegExp = new RegExp(`${trainingCard.word.toLowerCase()}[a-z]*`);
    const example = trainingCard.example.toLowerCase().replace(replaceRegExp, `<b>$&</b>`, trainingCard.example);

    $('#word').html(trainingCard.word);
    $('#translation').html(trainingCard.translation);
    $('#example').html(example);
};

$(document).ready(function () {

    getRandomWord();

    $('#generate_new_card').on('click', function (event) {
        event.preventDefault();

        getRandomWord();
    });

});
