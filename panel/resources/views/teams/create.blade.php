@extends('layout._layout')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item">Ekipler</li>
            <li class="breadcrumb-item active">Ekip Oluştur</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
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
                        <div class="panel-tag">
                            Ekip oluşturarak çevrimiçi eğitimler verebilir, ekibinizdeki kişilere iletmek istediğiniz mesajlarınızı anlık ulaştırabilirsiniz.
                            <code>Ekip Kodu</code>
                            yardımı ile başka kişilerin ekibinize katılmasınız sağlayabilirsiniz. Bu özelliği kullanabilmek için "Ekip Kodu ile Katılım" seçeneğini işaretlemeniz gerektiğini unutmayınız.
                        </div>
                        <form type="POST" action="{{ route('teams.store') }}">
                            <div class="form-group col-6">
                                <label class="form-label" for="simpleinput">Ekip Adı</label>
                                <input type="text" id="name" class="form-control" name="name">
                            </div>

                            <div class="form-group col-6">
                                <label class="form-label text-muted" for="simpleinput-disabled">Ekip kodu</label>
                                <input type="text" id="simpleinput-disabled" class="form-control" name="code" readonly value="{{ GUID() }}">
                            </div>
                            <div class="form-group col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="isPublic" name="is_public" value="1">
                                    <label class="custom-control-label" for="isPublic">Ekip kodu ile katılım
                                        sağlanabilsin.</label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-6">
                                <button type="submit" class="btn btn-sm btn-default">
                                    <span class="fal fa-check mr-1"></span>
                                    Oluştur
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
