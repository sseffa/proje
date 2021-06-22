@extends('layout._layout')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item">Ekipler</li>
            <li class="breadcrumb-item active">Üyeler</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-users'></i> {{ $team->name }}
                <small>
                    Ekibinizde kayıtlı olan üyeler.
                </small>
            </h1>
        </div>
        <div class="row">
            <div class="col">
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="float-right">
                            @if($members->count() !== 0)
                                <button
                                    class="btn btn-lg btn-primary waves-effect waves-themed"
                                    id="addMember"
                                    data-toggle="modal"
                                    data-target="#add-member">
                                    <span class="fal fa-plus mr-1"></span>
                                    Üye Ekle
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <hr/>

                @foreach($members as $member)
                    <div class="col-lg-6 member-{{ $member->id }}">
                        <div class="card mb-g">
                            <div class="card-body">
                                <h2 class="color-danger-400">
                                </h2>
                                {{ $member->name }} ({{ $member->email }})

                                &nbsp;<button
                                    class="btn btn-sm btn-primary waves-effect waves-themed float-right remove"
                                    id="removeMember"
                                    data-teamid="{{ $team->id }}"
                                    data-userid="{{ $member->id }}">
                                    <span class="fal fa-minus mr-1"></span>
                                    Üyeyi Çıkart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($members->count() === 0)
                    <div class="alert alert-info" role="alert">
                        <strong>Bilgilendirme!</strong> Bu ekipte henüz üye bulunmamaktadır. &nbsp;&nbsp;&nbsp;<button
                            class="btn btn-sm btn-primary waves-effect waves-themed"
                            id="addMember"
                            data-toggle="modal"
                            data-target="#add-member">
                            <span class="fal fa-plus mr-1"></span>
                            Üye Ekle
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script type="application/javascript">
        document.addEventListener('click', function (e) {

            if (e.target && e.target.classList.contains('remove')) {

                let userId = e.target.getAttribute("data-userid");
                let teamId = {{ $team->id }};
                let token = document.querySelector('meta[name="_token"]').getAttribute('content');

                fetch('/teams/removeMember', {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    method: 'post',
                    //credentials: "same-origin",
                    body: JSON.stringify({
                        userId: parseInt(userId),
                        teamId: teamId
                    })
                })
                    .then(response => response.json())
                    .then(result => {

                        if (result.status == "success") {
                            let el = document.querySelector('.member-' + userId);
                            el.parentNode.removeChild(el);
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        });

        document.querySelector('#addMember').addEventListener('click', async function () {

            async function getUsers() {
                let url = '/getAllUsers';
                try {
                    let res = await fetch(url);
                    return await res.json();
                } catch (error) {
                    console.log(error);
                }
            }

            let users = await getUsers();
            let html = '';
            users.forEach(user => {
                let htmlSegment = `<p class="user-${user.id}">
                                        <button data-userid="${user.id}" class="btn btn-outline-primary btn-icon add ">
                                            <i class="fal fa-plus"></i>
                                        </button>&nbsp;&nbsp;
                                        <span class="">${user.first_name} ${user.last_name} (${user.email})</span>
                                   </p>`;

                html += htmlSegment;
            });

            let container = document.querySelector('.users');
            container.innerHTML = html;


            document.addEventListener('click', function (e) {

                if (e.target && e.target.classList.contains('add')) {

                    let userId = e.target.getAttribute("data-userid");
                    let teamId = {{ $team->id }};
                    let token = document.querySelector('meta[name="_token"]').getAttribute('content');

                    fetch('/teams/addMember', {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        method: 'post',
                        //credentials: "same-origin",
                        body: JSON.stringify({
                            userId: parseInt(userId),
                            teamId: teamId
                        })
                    })
                        .then(response => response.json())
                        .then(result => {

                            if (result.status == "success") {
                                let el = document.querySelector('.user-' + userId);
                                el.parentNode.removeChild(el);
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            });
        });
    </script>
@stop
