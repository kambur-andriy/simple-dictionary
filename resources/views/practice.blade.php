@extends('layouts.index')

@push('scripts')
    <script src="{{ mix('/js/practice.js') }}"></script>
@endpush

@section('content')

    <div id="training_card" class="ui green raised segment">
        <div class="ui one column grid container">
            <div class="row">
                <div class="column">
                    <button id="generate_new_card" class="circular ui icon button green right floated">
                        <i class="icon sync"></i>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <div id="word" class="ui header green center aligned"></div>
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <div id="translation" class="ui header green center aligned"></div>
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <div id="example" class="ui sub header grey center aligned"></div>
                </div>
            </div>
        </div>
    </div>

@endsection
