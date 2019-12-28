@extends('layouts.index')

@push('scripts')
    <script src="{{ mix('/js/search.js') }}"></script>
@endpush

@section('content')

    <div class="ui green raised segment">
        <div class="ui one column grid container">
            <div class="row">
                <div class="column">
                    <form id="search_frm" class="ui form">
                        <div class="ui action input fluid">
                            <input type="text" name="text_pattern" autocomplete="off" autofocus>

                            <button class="ui right labeled icon button green">
                                <i class="search icon"></i>
                                Find
                            </button>
                        </div>
                    </form>

                    <form id="new_word_frm" class="ui form hidden">
                        <div class="fields">
                            <div class="ui left icon input fluid eight wide field">
                                <i class="book icon"></i>
                                <input type="text" name="word" placeholder="Word" required autocomplete="off">
                            </div>

                            <div class="ui left icon input fluid eight wide field">
                                <i class="paragraph icon"></i>
                                <input type="text" name="transcription" placeholder="Transcription" required autocomplete="off">
                            </div>
                        </div>

                        <div class="fields">
                            <div class="ui left icon input fluid eight wide field">
                                <i class="info icon"></i>
                                <input type="text" name="translation" placeholder="Translation" required autocomplete="off">
                            </div>

                            <div class="ui left icon input fluid eight wide field">
                                <i class="bell icon"></i>
                                <input type="text" name="example" placeholder="Example" required autocomplete="off">
                            </div>
                        </div>

                        <div class="fields">
                            <div class="ui fluid fourteen wide field">
                            </div>

                            <div class="ui left icon input fluid two wide field">
                                <button id="close_new_word_frm" class="ui button green basic fluid" type="button">Close</button>
                            </div>

                            <div class="ui left icon input fluid two wide field">
                                <button class="ui button green fluid" type="submit">Save</button>
                            </div>
                        </div>
                    </form>

                    <form id="edit_word_frm" class="ui form hidden">
                        <input type="hidden" name="word_id">

                        <div class="fields">
                            <div class="ui left icon input fluid eight wide field">
                                <i class="book icon"></i>
                                <input type="text" name="word" placeholder="Word" required autocomplete="off">
                            </div>

                            <div class="ui left icon input fluid eight wide field">
                                <i class="paragraph icon"></i>
                                <input type="text" name="transcription" placeholder="Transcription" required autocomplete="off">
                            </div>
                        </div>

                        <table id="translations" class="ui celled striped table">
                            <thead>
                            <tr>
                                <th>
                                    <div class="ui left icon input fluid field">
                                        <i class="info icon"></i>
                                        <input type="text" name="translation" placeholder="Translation" autocomplete="off">
                                    </div>
                                </th>
                                <th>
                                    <div class="ui left icon input fluid field">
                                        <i class="bell icon"></i>
                                        <input type="text" name="example" placeholder="Example" autocomplete="off">
                                    </div>
                                </th>
                                <th class="collapsing center aligned">
                                    <button id="save_translation" class="ui icon button green basic fluid" type="button">
                                        <i class="plus icon"></i>
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <div class="fields">
                            <div class="ui fluid fourteen wide field">
                            </div>

                            <div class="ui left icon input fluid two wide field">
                                <button id="close_edit_word_frm" class="ui button green basic fluid" type="button">Close</button>
                            </div>

                            <div class="ui left icon input fluid two wide field">
                                <button class="ui button green fluid" type="submit">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <table class="ui celled padded green table" id="words_list">
        <thead>
        <tr>
            <th>Word</th>
            <th class="collapsing">Translation</th>
            <th class="collapsing">Actions</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <th>
                <div class="ui left floated pagination menu">
                    <a class="icon item first-page">
                        <i class="left chevron icon"></i>
                    </a>
                    <a class="icon item last-page">
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </th>
            <th colspan="2">
                <div class="ui right floated small green labeled icon button" id="show_new_word_frm">
                    <i class="user icon"></i> Add Word
                </div>
            </th>
        </tr>
        </tfoot>
    </table>

@endsection
