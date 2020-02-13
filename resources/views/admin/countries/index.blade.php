@extends('layouts.admin')
@section('content')
@can('country_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.countries.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.country.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.country.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Country">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.country.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.country.fields.position') }}
                    </th>
                    <th>
                        {{ trans('cruds.country.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.country.fields.short_code') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('country_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.countries.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.countries.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'position', name: 'position', visible: false, searchable: false },
{ data: 'name', name: 'name' },
{ data: 'short_code', name: 'short_code' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 2, 'asc' ]],
    pageLength: 100,
    rowReorder: {
        selector: 'tr td:not(:first-of-type,:last-of-type)',
        dataSrc: 'position'
    },
  };
  let datatable = $('.datatable-Country').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    datatable.on('row-reorder', function (e, details) {
        if(details.length) {
            let rows = [];
            details.forEach(element => {
                rows.push({
                    id: datatable.row(element.node).data().id,
                    position: element.newData
                });
            });

            $.ajax({
                headers: {'x-csrf-token': _token},
                method: 'POST',
                url: "{{ route('admin.countries.reorder') }}",
                data: { rows }
            }).done(function () { datatable.ajax.reload() });
        }
    });
});

</script>
@endsection
