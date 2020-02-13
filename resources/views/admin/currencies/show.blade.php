@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.currency.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.currencies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.currency.fields.id') }}
                        </th>
                        <td>
                            {{ $currency->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.currency.fields.position') }}
                        </th>
                        <td>
                            {{ $currency->position }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.currency.fields.name') }}
                        </th>
                        <td>
                            {{ $currency->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.currency.fields.short_code') }}
                        </th>
                        <td>
                            {{ $currency->short_code }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.currencies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection