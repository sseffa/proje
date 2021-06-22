@extends('layout._layout')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item">{{ auth()->user()->name }}</li>
            <li class="breadcrumb-item active">Güvenlik</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-edit'></i> <span class="fw-300">Parolanızı Güncelleyin</span>
                <small>

                </small>
            </h1>
        </div>
        <div class="card mb-g p-2">
            <div class="card-body">
                <h2>
                   Bilgiler
                </h2>
                <hr />
                <div class="panel-container show">
                    <div class="panel-content">

                        <form type="POST" action="{{ route('account.security.save') }}">
                            <div class="form-group col-6">
                                <label class="form-label" for="simpleinput">Eski Parola</label>
                                <input type="password" id="current_password" class="form-control"  name="current_password">
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label" for="simpleinput">Yeni Parola</label>
                                <input type="password" id="new_password" class="form-control" name="new_password">
                            </div>

                            <div class="form-group col-6">
                                <label class="form-label" for="simpleinput">Yeni Parola (tekrar)</label>
                                <input type="password" id="password_confirmation" class="form-control"  name="password_confirmation">
                            </div>
                            <hr>
                            <div class="form-group col-6">
                                <button type="submit" class="btn btn-sm btn-default">
                                    <span class="fal fa-check mr-1"></span>
                                    Güncelle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
