<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eğitim Platformu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="/meet/assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="/meet/assets/js/socket.io.js"></script>
    <link rel="stylesheet" href="/meet/assets/css/style.css">
    <script src="https://kit.fontawesome.com/c939d0e917.js"></script>
    <script src="/meet/assets/js/lib.js" defer></script>
    <script src="/meet/assets/js/api.js"></script>
    <script src="/meet/assets/js/enhancesdp.js"></script>
    <script type="application/javascript">
        $(function () {

            let socketIoConnectionUrl = "http://127.0.0.1:3000";
            const videoGrid = document.getElementById('gallery');
            let myVideoStream;

            // Connection
            let socket = io.connect(socketIoConnectionUrl);

            socket.nickname = "{{ auth()->user()->username }}";

            socket.room = "{{ $channel }}";
            console.log({nickname: socket.nickname, room: socket.room});
            socket.emit("login", {nickname: socket.nickname, room: socket.room});
            $(".participants").append(`<li class="user user-${socket.nickname}"><b>${socket.nickname}</b></li>`);
            socket.emit("getRoomClients");

            socket.on("message", function (response) {

                switch (response.type) {
                    case "new_user_login":
                        console.log(response.data + " toplantıya katıldı.");

                        $(".participants").append(`<li class="user user-${response.data}"><b>${response.data}</b></li>`);
                        scrollToBottom();

                        break;
                    case "user_left":

                        console.log(response.data + " toplantıdan çıktı");

                        $(".user-" + response.data).remove();
                        $("#" + response.data).parent().remove();
                        closeStream(response.data);
                        break;
                    case "get_user_list":
                        console.log("aktif kullanıcılar: ", response.data);

                        for (let i = 0; i < response.data.length; i++) {
                            if (response.data[i] !== socket.nickname) {
                                playScreenStream(response.data[i]);
                            }
                        }

                        for (let i = 0; i < response.data.length; i++) {
                            if (response.data[i] !== socket.nickname) {
                                $(".participants").append(`<li class="user user-${response.data[i]}"><b>${response.data[i]}</b></li>`);
                            }
                        }
                        break
                    case "get_message":
                        $(".messages").append(`<li class="message"><b>${response.data.nickname}</b><br/><div class="content"><i class="fas fa-user-circle"></i><span>${response.data.message}</span></div></li>`);
                        scrollToBottom()
                        break;
                    case "publish_stream":
                        if (response.data.nickname !== socket.nickname) {
                            playStream(response.data.nickname);
                        }
                        break;
                }
            });

            $("#mute").click(function (event) {
                event.preventDefault();

                let streamName = socket.nickname;

                if (myVideoStream !== undefined) {
                    let enabled = myVideoStream.getAudioTracks()[0].enabled;
                    if (enabled) {
                        myVideoStream.getAudioTracks()[0].enabled = false;
                        setUnmuteButton();

                        return false;
                    } else {
                        setMuteButton();
                        myVideoStream.getAudioTracks()[0].enabled = true;

                        return false;
                    }
                }

                localUser = socket.nickname;
                navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;

                if (navigator.mediaDevices.getUserMedia) {

                    navigator.mediaDevices.getUserMedia({
                        video: false,
                        audio: true
                    }).then(function (stream) {

                        myVideoStream = stream;
                        setMuteButton();

                        getUserMediaSuccess(stream);
                    }).catch((error) => {

                        console.log('Hata Oluştu', error);
                    });
                }

                createUserBox(streamName);

                setTimeout(function () {
                    startPlay(streamName);
                }, 2000);

            });

            $("#play").click(function (event) {
                event.preventDefault();

                let streamName = socket.nickname;

                if (myVideoStream !== undefined) {
                    let enabled = myVideoStream.getVideoTracks()[0].enabled;

                    if (enabled) {
                        myVideoStream.getVideoTracks()[0].enabled = false;
                        setPlayVideo()

                        closeStream(streamName);
                        return false;
                    } else {
                        setStopVideo()
                        myVideoStream.getVideoTracks()[0].enabled = true;

                        startPlay(streamName);

                        return false;
                    }
                }

                socket.emit('publishStream');
                createUserBox(streamName);

                publishStream();

                setTimeout(function () {
                    startPlay(streamName);
                }, 5000);
            });

            function publishScreenStream() {
                localUser = socket.nickname;
                navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;

                if (navigator.mediaDevices.getUserMedia) {

                    navigator.mediaDevices.getDisplayMedia({cursor: true}).then(stream => {
                        myVideoStream = stream;
                        setStopShare();

                        getUserMediaSuccess(stream);

                        stream.getVideoTracks()[0].addEventListener('ended', () => {

                            setPlayShare();
                            closeStream(localUser);
                            localVideo.remove();
                        });

                    }).catch((error) => {

                        console.log('Hata oluştu:', error);
                    });
                } else {
                    alert('Tarayıcınız getUserMedia API desteklememektedir.');
                }
            }

            function publishStream() {
                localUser = socket.nickname;
                navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;

                if (navigator.mediaDevices.getUserMedia) {

                    navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: true
                    }).then(function (stream) {

                        myVideoStream = stream;
                        setMuteButton();
                        setStopVideo();

                        getUserMediaSuccess(stream);

                    }).catch((error) => {

                        console.log('Hata oluştu:', error);
                    });
                } else if (navigator.getUserMedia) {

                    navigator.getUserMedia({
                        video: true,
                        audio: true
                    }).then(getUserMediaSuccess).catch((error) => {

                        console.log('Hata oluştu:', error);
                    });

                } else {
                    alert('Tarayıcınız getUserMedia API desteklememektedir.');
                }
            }

            function playStream(streamName) {
                setTimeout(function () {
                    createUserBox(streamName, true);
                    startPlay(streamName);

                }, 5000);
            }

            function playScreenStream(streamName) {
                setTimeout(function () {
                    createUserDesktopBox(streamName, true);
                    startPlay(streamName);
                }, 5000);
            }


            function createUserBox(streamName, isDummy = false) {
                const video = document.createElement('video');
                video.autoplay = true;
                video.playsinline = true;
                video.controls = false;
                video.setAttribute('id', 'localVideo');

                if (isDummy) {
                    video.setAttribute('id', streamName);
                    video.muted = true;
                    video.loop = true;
                    video.play();
                }

                const userBox = document.createElement('div');
                userBox.classList.add("user-box");
                userBox.id = "box-" + streamName;
                const userInfoOperations = document.createElement('div');
                userInfoOperations.classList.add('user-info-operations');
                const userFullname = document.createElement('span');
                userFullname.classList.add('user-fullname');
                userFullname.innerText = streamName;

                userBox.appendChild(video);
                userInfoOperations.appendChild(userFullname);
                userBox.appendChild(userInfoOperations);

                videoGrid.append(userBox);

                recalculateLayout();
            }

            function removeUserBox(streamName) {
                $('#' + streamName).remove();
                recalculateLayout();
            }

            function removeDesktopBox(streamName) {
                $('#' + streamName).remove();
                recalculateLayout();
            }

            window.createUserBox = createUserBox;
            window.createUserDesktopBox = createUserDesktopBox;
            window.removeUserBox = removeUserBox;
            window.removeDesktopBox = removeDesktopBox;

            function createUserDesktopBox(streamName, isDummy = false) {
                const video = document.createElement('video');
                video.autoplay = true;
                video.playsinline = true;
                video.controls = false;
                video.setAttribute('id', 'localVideo');

                if (isDummy) {
                    video.setAttribute('id', streamName);
                    video.muted = true;
                    video.loop = true;
                    video.play();
                }

                const userBox = document.createElement('div');
                userBox.id = "desktop-box-" + streamName;
                userBox.classList.add("desktop-box");
                const userInfoOperations = document.createElement('div');
                userInfoOperations.classList.add('user-info-operations');
                const userFullname = document.createElement('span');
                userFullname.classList.add('user-fullname');
                userFullname.innerText = streamName;

                userBox.appendChild(video);
                userInfoOperations.appendChild(userFullname);
                userBox.appendChild(userInfoOperations);

                videoGrid.append(userBox);
                recalculateLayout();
            }


            $('#share-screen').click(function (e) {
                e.preventDefault();

                let streamName = socket.nickname;

                if (myVideoStream !== undefined) {
                    let enabled = myVideoStream.getVideoTracks()[0].enabled;
                    if (enabled) {
                        myVideoStream.getVideoTracks()[0].enabled = false;
                        setPlayShare()

                        closeStream(streamName);
                        return false;
                    } else {
                        setStopShare()
                        myVideoStream.getVideoTracks()[0].enabled = true;

                        startPlay(streamName);
                        return false;
                    }
                }

                publishScreenStream();
                createUserDesktopBox(streamName);

                setTimeout(function () {

                    playScreenStream(streamName);
                }, 5000);
            });


            $('.leave_meeting').click(function (e) {
                e.preventDefault();
                window.location = "/";
            });


            
            let text = $("#chat_message");
          
            $('html').keydown(function (e) {
                if (e.which === 13 && text.val().length !== 0) {
                    socket.emit('sendMessage', text.val());
                    text.val('')
                }
            });

            $('.send').click(function (){
                if (text.val().length !== 0) {
                    socket.emit('sendMessage', text.val());
                    text.val('')
                }
            });
        });
    </script>
    <script src="/meet/assets/js/main.js" defer></script>
    <script src="/meet/assets/js/gallery.js"></script>
    <script src="/meet/assets/js/chat.js"></script>
</head>
<body>
<div id="gallery" class="main__videos">
</div>

<div id="gallery-horizontal">

</div>

<div class="main__controls">
    <div class="main__controls__block">
        <div id="mute" class="main__controls__button main__mute_button">
            <i class="fas fa-microphone"></i>
            <span>Mikrofon</span>
        </div>
        <div id="play" class="main__controls__button main__video_button">
            <i class="fas fa-video"></i>
            <span>Kamera</span>
        </div>
        <div id="share-screen" class="main__controls__button main__share_button">
            <i class="fas fa-share-alt"></i>
            <span>Ekranı Paylaş</span>
        </div>
    </div>
    <div class="main__controls__block">

        <div id="open-participant" class="main__controls__button">
            <i class="fas fa-user-friends"></i>
            <span>Katılımcılar</span>
        </div>
        <div id="open-chat" class="main__controls__button">
            <i class="fas fa-comment-alt"></i>
            <span>Sohbet</span>
        </div>
    </div>
    <div class="main__controls__block">
        <div class="main__controls__button">
            <i class="fas fa-sign-out-alt"></i>
            <span class="leave_meeting">Toplantıdan Ayrıl</span>
        </div>
    </div>
</div>

<div class="main__right">
    <div class="main__header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#chat" role="tab"
                   aria-controls="chat" aria-selected="true">Sohbet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="participants-tab" data-toggle="tab" href="#participants" role="tab"
                   aria-controls="participants" aria-selected="false">Katılımcılar</a>
            </li>
        </ul>
    </div>
    <div class="main__chat_window">
        <div class="tab-pane fade show active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
            <ul class="messages"></ul>
        </div>
        <div class="tab-pane fade" id="participants" role="tabpanel" aria-labelledby="participants-tab">
            <ul class="participants"></ul>
        </div>
    </div>
    <div class="main__message_container">
        <textarea id="chat_message" placeholder="Mesajınız..."></textarea>
        <i class="fas fa-paper-plane send"></i>
    </div>
</div>
</body>
</html>

