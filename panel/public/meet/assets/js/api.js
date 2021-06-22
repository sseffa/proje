let wsURL = "wss://608ab183989d4.streamlock.net:9443/webrtc-session.json";
let application = "live";
let wsConnection = null;
let localUser = null;
let localVideo = null;
let peerConnectionConfig = {'iceServers': []};
let localStream = null;
let peerConnections = [];
let videoBitrate = 360;
let audioBitrate = 64;
let videoFrameRate = "29.97";
let players = [];


navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;
window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
window.RTCIceCandidate = window.RTCIceCandidate || window.mozRTCIceCandidate || window.webkitRTCIceCandidate;
window.RTCSessionDescription = window.RTCSessionDescription || window.mozRTCSessionDescription || window.webkitRTCSessionDescription;


function openCameraAndMicrophone() {

    localVideo = document.getElementById('localVideo');
    let constraints =
        {
            video: true,
            audio: true,
        };

    console.log("navigator.mediaDevices.getUserMedia", navigator.mediaDevices.getUserMedia.length);
    console.log("navigator.getUserMedia", navigator.getUserMedia.length);

    if (navigator.mediaDevices.getUserMedia) {

        navigator.mediaDevices.getUserMedia(constraints).then(getUserMediaSuccess).catch(errorHandler);
        newAPI = false;
    } else if (navigator.getUserMedia) {

        navigator.getUserMedia(constraints, getUserMediaSuccess, errorHandler);
    } else {
        alert('Your browser does not support getUserMedia API');
    }
}


function getUserMediaSuccess(stream) {

    console.log("getUserMediaSuccess: " + stream);
    localVideo = document.getElementById('localVideo');

    localStream = stream;
    try {
        localVideo.srcObject = stream;
    } catch (error) {
        console.log('Error:', error);
        localVideo.src = window.URL.createObjectURL(stream);
    }
    connectWebSocket(wsURL).then(function (wsConnectionFrom) {

        listenWebSocketEvents();

        peerConnections[localUser] = new RTCPeerConnection(peerConnectionConfig);
        peerConnections[localUser].onicecandidate = localIceCandidate;

        peerConnections[localUser].addStream(localStream);
        peerConnections[localUser].createOffer(gotLocalDescription, errorHandler);
    });
}

function errorHandler(error) {
    console.log(error);
}

function connectWebSocket(url) {
    return new Promise(function (resolve, reject) {
        if (wsConnection == null) {
            console.log("WebSocket instance created")
            wsConnection = new WebSocket(url);
            wsConnection.binaryType = 'arraybuffer';

            wsConnection.onopen = function () {
                console.log("Connection opened");
                resolve(wsConnection);
            }
        } else {
            console.log("existing ws instance");
            resolve(wsConnection);
        }
    })
}

function listenWebSocketEvents() {
    wsConnection.onmessage = function (evt) {
        console.log("Wowza Web Socket Response:" + evt.data);

        let msgJSON = JSON.parse(evt.data);
        let msgStatus = Number(msgJSON['status']);
        let msgCommand = msgJSON['command'];

        if(msgStatus === 502)
            return false;

        if (msgJSON.direction === "publish") {

            if (msgJSON.command === "sendOffer") {

                console.log("Send Offer Sdp Type Answer:", msgJSON["sdp"]);

                peerConnections[localUser].setRemoteDescription(new RTCSessionDescription(msgJSON["sdp"]), function () {

                }, errorHandler)

                var iceCandidates = msgJSON['iceCandidates'];
                if (iceCandidates !== undefined) {
                    for (var index in iceCandidates) {
                        console.log('iceCandidates: ' + iceCandidates[index]);
                        peerConnections[localUser].addIceCandidate(new RTCIceCandidate(iceCandidates[index]));
                    }
                }
            }

        } else if (msgJSON.direction === "play") {
            let remStreamName = msgJSON.streamInfo.streamName;
            let remSessionId = msgJSON.streamInfo.sessionId;

            if (msgCommand === "getOffer") {
                players[remStreamName].plSetRemoteDescription(new RTCSessionDescription(msgJSON.sdp), remSessionId);

            } else if (msgCommand === "sendResponse") {
                var iceCandidates = msgJSON['iceCandidates'];
                if (iceCandidates !== undefined) {
                    for (var index in iceCandidates) {
                        console.log(' sendResponse iceCandidates: ' + JSON.stringify(iceCandidates[index]));
                        players[remStreamName].addIceCandidate(new RTCIceCandidate(iceCandidates[index]));
                    }
                }
            }
        }
    }
}

function gotLocalDescription(description) {

    let enhanceData = {};

    if (audioBitrate !== undefined)
        enhanceData.audioBitrate = Number(audioBitrate);
    if (videoBitrate !== undefined)
        enhanceData.videoBitrate = Number(videoBitrate);
    if (videoFrameRate !== undefined)
        enhanceData.videoFrameRate = Number(videoFrameRate);

    description.sdp = enhanceSDP(description.sdp, enhanceData);

    console.log('gotLocalDescription: ' + JSON.stringify({'sdp': description}));


    peerConnections[localUser].setLocalDescription(description, function () {
        let streamInfo = {applicationName: application, streamName: localUser, sessionId: "[empty]"}

        wsConnection.send('{"direction":"publish", "command":"sendOffer", "streamInfo":' + JSON.stringify(streamInfo) + ', "sdp":' + JSON.stringify(description) + ', "userData":' + JSON.stringify({}) + '}');

    }, function (err) {
        console.log('set description error' + err)
    });
}


function stopLocalDescription(description) {

    let enhanceData = {};

    if (audioBitrate !== undefined)
        enhanceData.audioBitrate = Number(audioBitrate);
    if (videoBitrate !== undefined)
        enhanceData.videoBitrate = Number(videoBitrate);
    if (videoFrameRate !== undefined)
        enhanceData.videoFrameRate = Number(videoFrameRate);

    description.sdp = enhanceSDP(description.sdp, enhanceData);

    console.log('gotLocalDescription: ' + JSON.stringify({'sdp': description}));

    peerConnections[localUser].setLocalDescription(description, function () {
        let streamInfo = {applicationName: application, streamName: localUser, sessionId: "[empty]"}

        wsConnection.send('{"direction":"stop", "command":"sendOffer", "streamInfo":' + JSON.stringify(streamInfo) + ', "sdp":' + JSON.stringify(description) + ', "userData":' + JSON.stringify({}) + '}');

    }, function () {
        console.log('set description error')
    });
}

function localIceCandidate(event) {
    if (event.candidate != null) {
        console.log('localIceCandidate: ' + JSON.stringify({'ice': event.candidate}));
    }
}

function remoteIceCandidate(event) {
    if (event.candidate != null) {
        console.log('remoteIceCandidate: ' + JSON.stringify({'ice': event.candidate}));
    }
}

function startPlay(streamName) {

    console.log("stream name: ", streamName);
    players[streamName] = new Player(streamName);

    connectWebSocket(wsURL).then(function (connectWebSocketResponse) {

        listenWebSocketEvents();
        players[streamName].sendPlayOffer(streamName);

    });
}

function closeStream(videoTag) {

    if (players.hasOwnProperty(videoTag)) {
        players[videoTag].stop();

        console.log("Closing stream: ", players[videoTag]);
        console.log("Closing stream peerConnections: ", peerConnections);

        delete players[videoTag];
        delete peerConnections[videoTag];
    }
}

function Player(streamName) {

    let remoteVideo = document.getElementById(streamName);

    let remPeerConnection = new RTCPeerConnection(peerConnectionConfig);
    remPeerConnection.onicecandidate = remoteIceCandidate;
    remPeerConnection.onaddstream = gotRemoteStream;


    this.sendPlayOffer = sendPlayGetOffer;
    this.plSetRemoteDescription = plSetRemoteDescription;
    this.addIceCandidate = addIceCandidate;
    this.stop = stopStream;

    function stopStream() {
        remPeerConnection.close();
    }

    function addIceCandidate(candidate) {
        console.log("Player#addIceCandidate--" + streamName, candidate);
        remPeerConnection.addIceCandidate(candidate);
    }

    function plSetRemoteDescription(sdp, sessionId) {
        console.log("plSetRemoteDescription", sdp);
        remPeerConnection.setRemoteDescription(sdp).then(function () {
            return remPeerConnection.createAnswer();
        })
            .then(function (remoteDescription) {
                return remPeerConnection.setLocalDescription(remoteDescription);
            })
            .then(function () {
                let streamInfo = {applicationName: application, streamName: streamName, sessionId: sessionId};
                wsConnection.send('{"direction":"play", "command":"sendResponse", "streamInfo":' + JSON.stringify(streamInfo) + ', "sdp":' + JSON.stringify(remPeerConnection.localDescription) + ', "userData":' + JSON.stringify({}) + '}');

            })
    }

    function remoteIceCandidate(event) {
        if (event.candidate != null) {
            console.log('remoteIceCandidate: ' + JSON.stringify({'ice': event.candidate}));
        }
    }

    function gotRemoteStream(event) {

        console.log('event: ', event);
        console.log('gotRemoteStream: ', event.stream);

        try {
            if(remoteVideo !== null)
                remoteVideo.srcObject = event.stream;
                remoteVideo.autoplay = true;
        } catch (error) {
            console.log('Error: ', error);

            remoteVideo.src = window.URL.createObjectURL(event.stream);
        }
    }

    function sendPlayGetOffer(streamName) {

        let streamInfo = {applicationName: application, streamName: streamName, sessionId: "[empty]"};
        console.log("sendPlayGetOffer: " + JSON.stringify(streamInfo));
        wsConnection.send('{"direction":"play", "command":"getOffer", "streamInfo":' + JSON.stringify(streamInfo) + ', "userData":' + JSON.stringify({}) + '}');
    }
}
