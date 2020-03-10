@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><img src="http://q.i-systems.pl/file/e7afc254.png" /></li>
                            <li class="list-group-item"><img src="http://q.i-systems.pl/file/0756ba9e.png" /></li>
                            <li class="list-group-item"><img src="http://q.i-systems.pl/file/c7d251c3.png" /></li>
                        </ul>

                        <h2>Bibliografia:</h2>
                        <ul class="list-group">
                            <li class="list-group-item"><p>Domain Driven Design Distilled by Vaughn Vernon</p></li>
                            <li class="list-group-item"><p>Domain-Driven Design Reference: Definitions and Pattern Summaries by Eric Evans</p></li>
                            <li class="list-group-item"><p>Domain-Driven Desing in PHP</p></li>
                            <li class="list-group-item"><a href="https://cqrs.nu/" target="_blank">https://cqrs.nu/</a></li>
                            <li class="list-group-item"><a href="https://zawarstwaabstrakcji.pl/" target="_blank">https://zawarstwaabstrakcji.pl/</a></li>
                        </ul>

                        <h2>Biblioteki:</h2>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="http://getprooph.org/">getprooph</a></li>
                            <li class="list-group-item"><a href="https://symfony.com/doc/current/components/messenger.html">Symfony messenger bundle</a></li>
                            <li class="list-group-item"><a href="http://labs.qandidate.com/blog/2014/08/26/broadway-our-cqrs-es-framework-open-sourced/">broadway</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
