@extends('layout._layout')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item">{{ auth()->user()->name }}</li>
            <li class="breadcrumb-item active">Profil</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-edit'></i> <span class="fw-300">Profilinizi Güncelleyin</span>
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

                        <form type="POST" action="{{ route('account.update') }}">
                            <div class="form-group col-6">
                                <label class="form-label" for="simpleinput">Adınız</label>
                                <input type="text" id="first_name" class="form-control" value="{{ $user->first_name }}" name="first_name">
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label" for="simpleinput">Soyadınız</label>
                                <input type="text" id="last_name" class="form-control" value="{{ $user->last_name }}" name="last_name">
                            </div>

                            <div class="form-group col-6">
                                <label class="form-label" for="simpleinput">Kullanıcı Adınız</label>
                                <input type="text" id="name" class="form-control" value="{{ $user->username }}" name="username">
                            </div>

                            <div class="form-group col-6">
                                <label class="form-label" for="simpleinput">E-posta Adresiniz</label>
                                <input type="text" id="name" class="form-control" value="{{ $user->email }}" name="email" readonly>
                            </div>

                            <div class="form-group col-6">
                                <label class="form-label" for="simpleinput">Üyelik</label>
                                <input type="text" id="type" disabled class="form-control" value="{{ ($user->type == "instructor") ? 'Eğitmen' : 'Kullanıcı' }}" name="type" readonly>
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
