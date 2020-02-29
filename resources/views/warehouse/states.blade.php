@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Ean') }}: {{ $ean }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @php ($i = 1)
                        <table class="table ">
                            <tbody>
                            @foreach ($warehouses as $warehouse)
                                <tr>
                                    <td scope="row">{{ $i++ }}</td>
                                    <td>{{$warehouse->name}}</td>
                                    <td>
                                        <form class="form"
                                              action="{{ route('warehouse.state.store', ['ean' => $ean, 'name' => $warehouse->name]) }}"
                                              method="POST">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col col-md-8"></div>
                                                <div class="col col-md-2">
                                                    <input type="number" id="quantity" class="form-control form-control-sm"
                                                           name="quantity" min="1" max="99"
                                                           value="{{$warehouseStateService->warehouseState($warehouse->name, $ean)}}" />
                                                </div>
                                                <div class="col col-md-2">
                                                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
