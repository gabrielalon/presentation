@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Ean') }}: {{ $warehouseState->ean() }}</div>

                    <div class="card-body">
                        @php ($i = 1)
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Last version') }}</th>
                                <th scope="col">{{ __('Date of creation') }}</th>
                                <th scope="col">{{ __('Event name') }}</th>
                                <th scope="col">{{ __('Quantity') }}</th>
                                <th scope="col">{{ __('Responsible') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td scope="row">{{ $event->version }}</td>
                                    <td>{{$event->created_at}}</td>
                                    <td>{{$event->event_name}}</td>
                                    <td>{{$serializer->decode($event->payload)['quantity']}}</td>
                                    <td>{{$event->user_id}}</td>
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
