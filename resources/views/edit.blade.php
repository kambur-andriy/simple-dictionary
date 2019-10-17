@extends('layouts.index')

@push('scripts')
    <script src="{{ mix('/js/edit.js') }}"></script>
@endpush

@section('content')

    <div class="ui green raised segment">
        <div class="ui one column grid container">
            <div class="row">
                <div class="column">
                    <form id="find_word_frm" class="ui form">
                        <div class="ui action input fluid">
                            <input type="text" name="search_word" autocomplete="off" autofocus>

                            <button class="ui right labeled icon button green">
                                <i class="search icon"></i>
                                Find
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="new_word" class="ui raised segment hidden">
        <div class="ui one column grid container">
            <div class="row">
                <div class="column">
                    <form id="new_word_frm" class="ui form">
                        <div class="fields">
                            <div class="ui left icon input fluid seven wide field">
                                <i class="book icon"></i>
                                <input type="text" name="new_word" placeholder="Word" required autocomplete="off">
                            </div>

                            <div class="ui left icon input fluid seven wide field">
                                <i class="paragraph icon"></i>
                                <input type="text" name="new_transcription" placeholder="Transcription" required autocomplete="off">
                            </div>

                            <div class="ui fluid two wide field">
                                <button class="ui button green fluid" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="show_word" class="ui raised segment hidden">
        <div class="ui one column grid container">
            <div class="row">
                <div class="column">
                    <div id="word" class="ui huge header green center aligned"></div>

                    <div id="transcription" class="ui medium header center aligned"></div>

                    <form id="new_translation_frm" class="ui form">
                        <div class="fields">
                            <div class="ui left icon input fluid seven wide field">
                                <i class="info icon"></i>
                                <input type="text" name="translation" placeholder="Translation" required autocomplete="off">
                            </div>

                            <div class="ui left icon input fluid seven wide field">
                                <i class="bell icon"></i>
                                <input type="text" name="example" placeholder="Example" required autocomplete="off">
                            </div>

                            <div class="ui fluid two wide field">
                                <button class="ui button green basic fluid" type="submit">Save</button>
                            </div>
                        </div>
                    </form>

                    <table id="translations" class="ui celled striped table">
                        <thead>
                        <tr>
                            <th>Translation</th>
                            <th>Example</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
