@extends('layout._layout')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item">{{ auth()->user()->name }}</li>
            <li class="breadcrumb-item active">Ekipler</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-users'></i> <span class="fw-300">Ekip Oluştur</span>
                <small>
                    Takım üyeleri oluşturun ve toplantılar düzenleyin.
                </small>
            </h1>
        </div>
        <div class="card mb-g p-2">
            <div class="card-body">
                <h2>
                    Ekip Bilgileri
                </h2>

                <div class="panel-container show">
                    <div class="panel-content">

                        <div class="alert alert-primary alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="fal fa-times"></i>
                                </span>
                            </button>

                            <br>
                            Ekip oluşturarak çevrimiçi eğitimler verebilir, ekibinizdeki kişilere iletmek istediğiniz mesajlarınızı anlık ulaştırabilirsiniz.
                            <code>Ekip Kodu</code>
                            yardımı ile başka kişilerin ekibinize katılmasınız sağlayabilirsiniz. Bu özelliği kullanabilmek için "Ekip Kodu ile Katılım" seçeneğini işaretlemeniz gerektiğini unutmayınız.

                        </div>


                        <h5>Oluşturduğunuz ekipler:</h5>
                        <hr />
                        @foreach($teams as $team)
                            <div class="panel-tag">
                            <span><strong>{{ $team->name }}</strong></span>  <code>{{ $team->code }}</code>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
