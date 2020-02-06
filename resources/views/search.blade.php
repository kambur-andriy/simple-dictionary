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
                        <div class="ui left floated green icon button" id="show_new_word_frm">
                            <i class="plus icon"></i>
                        </div>

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
                                <i class="bell icon"></i>
                                <input type="text" name="example" placeholder="Example" required autocomplete="off">
                            </div>

                            <div class="ui left icon input fluid eight wide field">
                                <i class="info icon"></i>
                                <input type="text" name="translation" placeholder="Translation" required autocomplete="off">
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

                    <form id="translations_frm" class="ui form hidden">
                        <input type="hidden" name="word_id">

                        <div class="fields">
                            <div class="ui left icon input fluid eight wide field">
                                <i class="bell icon"></i>
                                <input type="text" name="example" placeholder="Example" required autocomplete="off">
                            </div>

                            <div class="ui left icon input fluid eight wide field">
                                <i class="info icon"></i>
                                <input type="text" name="translation" placeholder="Translation" required autocomplete="off">
                            </div>
                        </div>

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

                        <div id="original_word" class="ui huge header green center aligned"></div>

                        <table id="translations" class="ui celled striped table">
                            <thead>
                            <tr>
                                <th>Translation</th>
                                <th> Example</th>
                                <th class="collapsing center aligned"> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="ui celled padded green table" id="words_list">
        <thead>
        <tr>
            <th>Word</th>
            <th class="collapsing center aligned">Translation</th>
            <th class="collapsing center aligned" colspan="2">Actions</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <th class="center aligned" colspan="4">
                <div class="ui pagination menu">
                    <a class="icon item first-page">
                        <i class="left chevron icon"></i>
                    </a>
                    <a class="icon item last-page">
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </th>
        </tr>
        </tfoot>
    </table>

@endsection
