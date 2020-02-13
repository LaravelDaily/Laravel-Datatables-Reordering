@extends('layouts.admin')
@section('content')
@can('currency_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.currencies.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.currency.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.currency.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Currency">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.currency.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.currency.fields.position') }}
                        </th>
                        <th>
                            {{ trans('cruds.currency.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.currency.fields.short_code') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($currencies as $key => $currency)
                        <tr data-entry-id="{{ $currency->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $currency->id ?? '' }}
                            </td>
                            <td>
                                {{ $currency->position ?? '' }}
                            </td>
                            <td>
                                {{ $currency->name ?? '' }}
                            </td>
                            <td>
                                {{ $currency->short_code ?? '' }}
                            </td>
                            <td>
                                @can('currency_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.currencies.show', $currency->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('currency_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.currencies.edit', $currency->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('currency_delete')
                                    <form action="{{ route('admin.currencies.destroy', $currency->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('currency_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.currencies.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 2, 'asc' ]],
    pageLength: 100,
    columnDefs: [
        ...$.fn.dataTable.defaults.columnDefs,
        {
            visible: false,
            searchable: false,
            targets: 2
        }
    ],
    rowReorder: {
        selector: 'tr td:not(:first-of-type,:last-of-type)',
        dataSrc: '2'
    },
  });
  let datatable = $('.datatable-Currency:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
    datatable.on('row-reorder', function (e, details) {
        if(details.length) {
            let rows = [];
            details.forEach(element => {
                rows.push({
                    id: $(element.node).data('entry-id'),
                    position: element.newData
                });
            });

            $.ajax({
                headers: {'x-csrf-token': _token},
                method: 'POST',
                url: "{{ route('admin.currencies.reorder') }}",
                data: { rows }
            }).done(function () { location.reload() });
        }

    });
})

</script>
@endsection
