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
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Warehouse name') }}</th>
                                <th scope="col">{{ __('Increase') }}:</th>
                                <th scope="col">{{ __('Decrease') }}:</th>
                                <th scope="col">{{ __('Enter') }}:</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($warehouses->all() as $warehouse)
                                <tr>
                                    <td scope="row">{{ $i++ }}</td>
                                    <td>{{$warehouse->name()}}</td>
                                    <td>
                                        <form class="form"
                                              action="{{ route('warehouse.state.increase', ['ean' => $ean, 'name' => $warehouse->name()]) }}"
                                              method="POST">
                                            @csrf

                                            <div class="input-group input-group-sm">
                                                <input type="number"
                                                       class="form-control form-control-sm"
                                                       name="quantity" min="1" max="9" placeholder="0" />
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-sm btn-primary input-group-text">{{ __('OK') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form class="form"
                                              action="{{ route('warehouse.state.decrease', ['ean' => $ean, 'name' => $warehouse->name()]) }}"
                                              method="POST">
                                            @csrf

                                            <div class="input-group input-group-sm">
                                                <input type="number"
                                                       class="form-control form-control-sm"
                                                       name="quantity" min="1" max="9" placeholder="0" />
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-sm btn-primary input-group-text">{{ __('OK') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form class="form"
                                              action="{{ route('warehouse.state.store', ['ean' => $ean, 'name' => $warehouse->name()]) }}"
                                              method="POST">
                                            @csrf

                                            <div class="input-group input-group-sm">
                                                <input type="number"
                                                       class="form-control form-control-sm"
                                                       name="quantity" min="1" max="99"
                                                       value="{{$warehouseStateService->warehouseState($warehouse->name(), $ean)}}" />
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-sm btn-primary input-group-text">{{ __('OK') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="badge badge-light" href="{{ route('warehouse.state.show', ['ean' => $ean, 'name' => $warehouse->name()]) }}">
                                            <span class="oi oi-magnifying-glass"></span>
                                        </a>
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
