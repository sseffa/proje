@extends('layout._layout')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item">Aktiviteler</li>
            <li class="breadcrumb-item active">{{ $team->name }}</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-users'></i> {{ $team->name }}
                <small>
                    Ekibe ait paylaşımlar ve toplantılar.
                </small>
            </h1>
        </div>

        <div class="row clearfix">
            <div class="col-12">

                @if(auth()->user()->type === 'instructor')
                    <div class="float-left">
                        <a href="{{ route('members.show', ['team' => $team_id]) }}"
                           class="btn btn-lg btn-outline-warning waves-effect waves-themed" data-toggle="modal"
                           data-target="#create-meeting"><i class="fal fa-video"> Toplantı Oluştur</i>
                        </a>
                    </div>

                    <div class="float-right">
                        <a href="{{ route('members.show', ['team' => $team_id]) }}"
                           class="btn btn-lg btn-outline-success waves-effect waves-themed"><i class="fal fa-users">
                                Üyeleri
                                Görüntüle</i>
                        </a>
                    </div>

                @endif
            </div>
        </div>
        @include('modals.create-meeting', ['team_id'=>$team_id])
        @include('modals.reply')
        <hr/>
        <div class="row">
            <div class="col-12">
                <form action="{{ route('create.comment') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $team->id }}" name="team_id"/>
                    <div class="col-12 mb-3">
                        <textarea class="form-control" id="content" name="content"
                                  placeholder="Ekip üyeleriniz ile paylaşmak istediğiniz içeriği buraya yazın." rows="5"
                                  required=""></textarea>
                        <div class="invalid-tooltip">
                            Mesaj içeriği
                        </div>
                    </div>
                    <div
                        class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center float-right">
                        <button class="btn btn-outline-primary waves-effect waves-themed" type="submit">Paylaş</button>
                    </div>
                </form>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col">
                @foreach($posts as $post)
                    <div class="card mb-g">
                        <div class="card-body pb-0 px-4">
                            <div class="d-flex flex-row pb-3 pt-2  border-top-0 border-left-0 border-right-0">
                                <div class="d-inline-block align-middle mr-3">
                                    <span class="profile-image rounded-circle d-block"
                                          style="background-image:url('{{ gravatarUrl( $post->user->email)  }}'); background-size: cover;"></span>
                                </div>
                                <h5 class="mb-0 flex-1 text-dark fw-500">
                                    {{ $post->user->name }}

                                </h5>
                                <span class="text-muted fs-xs opacity-70">
                                                {{ $post->created_at->diffForHumans() }}
                                            </span>
                            </div>
                            <div class="pb-3 pt-2 border-top-0 border-left-0 border-right-0 text-muted">
                                @if($post->type === "meeting")

                                    <a target="_blank"
                                       href="{{ route('meet', ['key' => $post->{$post->type}->meet_key]) }}">{{ env('APP_URL') }}/meet/{{ $post->{$post->type}->meet_key }}</a>
                                    <hr>
                                    <strong>Toplantı Tarihi: {{ $post->{$post->type}->meet_date }}</strong>
                                @else
                                    {{ $post->{$post->type}->content }}
                                @endif
                            </div>
                            <div class="d-flex align-items-center demo-h-spacing py-3">

                                <a href="javascript:void(0);" class="d-inline-flex align-items-center text-dark">
                                    <i class="fal fa-comment fs-xs mr-1"></i>
                                    <span>{{ $post->replies->count() }} Yorum</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body py-0 px-4 border-faded border-right-0 border-bottom-0 border-left-0">
                            <div class="d-flex flex-column align-items-center">

                            @foreach($post->replies as $reply)
                                <!-- comment -->
                                    <div class="d-flex flex-row w-100 py-4">
                                        <div class="d-inline-block align-middle mr-3">
                                            <span class="profile-image profile-image-md rounded-circle d-block mt-1"
                                                  style="background-image:url('{{ gravatarUrl( $reply->user->email)  }}'); background-size: cover;"></span>
                                        </div>
                                        <div class="mb-0 flex-1 text-dark">
                                            <div class="d-flex">
                                                <a href="javascript:void(0);" class="text-dark fw-500">
                                                    {{ $reply->user->name }}
                                                </a><span class="text-muted fs-xs opacity-70 ml-auto">
                                                             {{ $reply->created_at->diffForHumans() }}
                                                        </span>
                                            </div>
                                            <p class="mb-0">
                                                {{ $reply->message }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="m-0 w-100">
                                    <!-- comment end -->
                                @endforeach
                                <form class="reply-form col-12" action="{{ route('add.reply') }}" method="POST">
                                    @csrf
                                    <div class="py-3 w-100">
                                    <textarea class="form-control border-0 p-0 bg-transparent" name="message" rows="2"
                                              placeholder="mesajınız..."></textarea>
                                    </div>
                                    <input type="hidden" value="{{ $post->id }}" name="post_id" id="post_id">
                                    <input type="hidden" value="{{ $team->id }}" name="team_id" id="team_id">

                                    <div class="modal-footer col-12">
                                        <button type="submit" class="btn btn-xs btn-info">Yanıtla</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
                @if($posts->count() === 0)
                    <div class="alert alert-info" role="alert">
                        <strong>Bilgilendirme!</strong> Henüz bu ekip için herhangi bir paylaşım yapmadınız.
                    </div>
                @endif
                {{ $posts->render() }}
            </div>
        </div>
    </main>
    @push('scripts')
        <script type="application/javascript">
            $(document).ready(function () {

                $('.btnReply').click(function () {

                    $('#add-reply').modal('toggle');

                    let post_id = document.querySelector('.btnReply').getAttribute('data-postid');
                    let team_id = document.querySelector('.btnReply').getAttribute('data-teamid');

                    document.querySelector('#post_id').value = post_id;
                    document.querySelector('#team_id').value = team_id;
                });
            });
        </script>
    @endpush
@stop
