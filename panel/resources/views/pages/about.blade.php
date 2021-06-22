@extends('layout._layout')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item">Hakkında</li>
        </ol>

        <div class="row">
            <p>
                Bu proje üniversite bitirme projesi olarak tasarlanmış ve buna uygun yapılmıştır.
            </p>
        </div>
    </main>
@stop
