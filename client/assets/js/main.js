let myVideoStream;

const muteUnmute = () => {
    const enabled = myVideoStream.getAudioTracks()[0].enabled;
    if (enabled) {
        myVideoStream.getAudioTracks()[0].enabled = false;
        setUnmuteButton();
    } else {
        setMuteButton();
        myVideoStream.getAudioTracks()[0].enabled = true;
    }
}

const playStop = () => {
    console.log('object')
    let enabled = myVideoStream.getVideoTracks()[0].enabled;
    if (enabled) {
        myVideoStream.getVideoTracks()[0].enabled = false;
        setPlayVideo()
    } else {
        setStopVideo()
        myVideoStream.getVideoTracks()[0].enabled = true;
    }
}


const setMuteButton = () => {
    const html = `
    <i class="unmute fas fa-microphone-slash"></i>
    <span>Mikrofonu Kapat</span>
  `
    document.querySelector('.main__mute_button').innerHTML = html;
}

const setUnmuteButton = () => {
    const html = `
    <i class="fas fa-microphone"></i>
    <span>Mikrofonu Kapat</span>
  `
    document.querySelector('.main__mute_button').innerHTML = html;
}

const setStopVideo = () => {

    const html = `
    <i class="stop fas fa-video-slash"></i>
    <span>Kamerayı Kapat</span>
  `
    document.querySelector('.main__video_button').innerHTML = html;
}

const setPlayVideo = () => {
    const html = `
  <i class="fas fa-video"></i>
    <span>Kamera</span>
  `
    document.querySelector('.main__video_button').innerHTML = html;
}


const setStopShare = () => {
    const html = `
    <i class="stop fas fa-share-alt"></i>
    <span>Kamerayı Kapat</span>
  `
    document.querySelector('.main__share_button').innerHTML = html;
}

const setPlayShare = () => {
    const html = `
    <i class=" fas fa-share-alt"></i>
    <span>Ekranı Paylaş</span>
  `
    document.querySelector('.main__share_button').innerHTML = html;
}

const scrollToBottom = () => {
    var d = $('.main__chat_window');
    d.scrollTop(d.prop("scrollHeight"));
}