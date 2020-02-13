@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.currency.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.currencies.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.currency.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has(''))
                    <div class="invalid-feedback">
                        {{ $errors->first('') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.currency.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="short_code">{{ trans('cruds.currency.fields.short_code') }}</label>
                <input class="form-control {{ $errors->has('short_code') ? 'is-invalid' : '' }}" type="text" name="short_code" id="short_code" value="{{ old('short_code', '') }}" required>
                @if($errors->has(''))
                    <div class="invalid-feedback">
                        {{ $errors->first('') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.currency.fields.short_code_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
