@extends('layouts.app')

@section('content')
    {{-- @dd(json_encode($form, JSON_PRETTY_PRINT)) --}}
    @csrf
    <div class="p-5">
        <la-form :form="{{ json_encode($form) }}">
        </la-form>
    </div>
        {{-- <user-edit-form :form="{{ json_encode($form) }}">
            @csrf
            <div slot="buttons">
                <button>Submit</button>
            </div>
        </user-edit-form> --}}
@endsection