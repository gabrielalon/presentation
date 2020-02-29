@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('Warehouse items') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @php ($i = 1)
                        <table class="table ">
                            <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td scope="row">{{ $i++ }}</td>
                                    <td>{{$item->ean}}</td>
                                    <td>
                                        <a class="badge badge-info" href="{{ route('warehouse.state.list', ['ean' => $item->ean]) }}">
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
