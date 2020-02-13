<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCountryRequest;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CountriesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('country_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Country::query()->select(sprintf('%s.*', (new Country)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'country_show';
                $editGate      = 'country_edit';
                $deleteGate    = 'country_delete';
                $crudRoutePart = 'countries';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('position', function ($row) {
                return $row->position ? $row->position : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('short_code', function ($row) {
                return $row->short_code ? $row->short_code : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.countries.index');
    }

    public function create()
    {
        abort_if(Gate::denies('country_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.countries.create');
    }

    public function store(StoreCountryRequest $request)
    {
        $country = Country::create($request->all());

        return redirect()->route('admin.countries.index');
    }

    public function edit(Country $country)
    {
        abort_if(Gate::denies('country_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.countries.edit', compact('country'));
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->update($request->all());

        return redirect()->route('admin.countries.index');
    }

    public function show(Country $country)
    {
        abort_if(Gate::denies('country_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.countries.show', compact('country'));
    }

    public function destroy(Country $country)
    {
        abort_if(Gate::denies('country_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $country->delete();

        return back();
    }

    public function massDestroy(MassDestroyCountryRequest $request)
    {
        Country::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function reorder(Request $request)
    {
        foreach($request->input('rows', []) as $row)
        {
            Country::find($row['id'])->update([
                'position' => $row['position']
            ]);
        }

        return response()->noContent();
    }
}
