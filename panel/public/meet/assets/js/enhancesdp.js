let SDPOutput = {};
let videoChoice = "42e01f";
let audioChoice = "opus";
let videoIndex = -1;
let audioIndex = -1;

function addAudio(sdpStr, audioLine) {
    let sdpLines = sdpStr.split(/\r\n/);
    let sdpSection = 'header';
    let hitMID = false;
    let sdpStrRet = '';
    let done = false;

    for (let sdpIndex in sdpLines) {
        let sdpLine = sdpLines[sdpIndex];

        if (sdpLine.length <= 0)
            continue;

        sdpStrRet += sdpLine;
        sdpStrRet += '\r\n';

        if ('a=rtcp-mux'.localeCompare(sdpLine) == 0 && done == false) {
            sdpStrRet += audioLine;
            done = true;
        }
    }

    return sdpStrRet;
}

function addVideo(sdpStr, videoLine) {
    let sdpLines = sdpStr.split(/\r\n/);
    let sdpSection = 'header';
    let hitMID = false;
    let sdpStrRet = '';
    let done = false;

    let rtcpSize = false;
    let rtcpMux = false;

    for (let sdpIndex in sdpLines) {
        let sdpLine = sdpLines[sdpIndex];

        if (sdpLine.length <= 0)
            continue;

        if (sdpLine.includes("a=rtcp-rsize")) {
            rtcpSize = true;
        }

        if (sdpLine.includes("a=rtcp-mux")) {
            rtcpMux = true;
        }
    }

    for (let sdpIndex in sdpLines) {
        let sdpLine = sdpLines[sdpIndex];

        sdpStrRet += sdpLine;
        sdpStrRet += '\r\n';

        if (('a=rtcp-rsize'.localeCompare(sdpLine) == 0) && done == false && rtcpSize == true) {
            sdpStrRet += videoLine;
            done = true;
        }

        if ('a=rtcp-mux'.localeCompare(sdpLine) == 0 && done == true && rtcpSize == false) {
            sdpStrRet += videoLine;
            done = true;
        }

        if ('a=rtcp-mux'.localeCompare(sdpLine) == 0 && done == false && rtcpSize == false) {
            done = true;
        }
    }
    return sdpStrRet;
}

function enhanceSDP(sdpStr, enhanceData) {
    let sdpLines = sdpStr.split(/\r\n/);
    let sdpSection = 'header';
    let hitMID = false;
    let sdpStrRet = '';

    // Firefox provides a reasonable SDP, Chrome is just odd
    // so we have to doing a little mundging to make it all work
    if (!sdpStr.includes("THIS_IS_SDPARTA") || videoChoice.includes("VP9")) {
        for (let sdpIndex in sdpLines) {
            let sdpLine = sdpLines[sdpIndex];

            if (sdpLine.length <= 0)
                continue;

            let doneCheck = checkLine(sdpLine);
            if (!doneCheck)
                continue;

            sdpStrRet += sdpLine;
            sdpStrRet += '\r\n';

        }
        sdpStrRet = addAudio(sdpStrRet, deliverCheckLine(audioChoice, "audio"));
        sdpStrRet = addVideo(sdpStrRet, deliverCheckLine(videoChoice, "video"));
        sdpStr = sdpStrRet;
        sdpLines = sdpStr.split(/\r\n/);
        sdpStrRet = '';
    }

    for (let sdpIndex in sdpLines) {
        let sdpLine = sdpLines[sdpIndex];

        if (sdpLine.length <= 0)
            continue;

        if (sdpLine.indexOf("m=audio") == 0 && audioIndex != -1) {
            audioMLines = sdpLine.split(" ");
            sdpStrRet += audioMLines[0] + " " + audioMLines[1] + " " + audioMLines[2] + " " + audioIndex + "\r\n";
            continue;
        }

        if (sdpLine.indexOf("m=video") == 0 && videoIndex != -1) {
            audioMLines = sdpLine.split(" ");
            sdpStrRet += audioMLines[0] + " " + audioMLines[1] + " " + audioMLines[2] + " " + videoIndex + "\r\n";
            continue;
        }

        sdpStrRet += sdpLine;

        if (sdpLine.indexOf("m=audio") === 0) {
            sdpSection = 'audio';
            hitMID = false;
        } else if (sdpLine.indexOf("m=video") === 0) {
            sdpSection = 'video';
            hitMID = false;
        } else if (sdpLine.indexOf("a=rtpmap") == 0) {
            sdpSection = 'bandwidth';
            hitMID = false;
        }

        if (sdpLine.indexOf("a=mid:") === 0 || sdpLine.indexOf("a=rtpmap") == 0) {
            if (!hitMID) {
                if ('audio'.localeCompare(sdpSection) == 0) {
                    if (enhanceData.audioBitrate !== undefined) {
                        sdpStrRet += '\r\nb=CT:' + (enhanceData.audioBitrate);
                        sdpStrRet += '\r\nb=AS:' + (enhanceData.audioBitrate);
                    }
                    hitMID = true;
                } else if ('video'.localeCompare(sdpSection) == 0) {
                    if (enhanceData.videoBitrate !== undefined) {
                        sdpStrRet += '\r\nb=CT:' + (enhanceData.videoBitrate);
                        sdpStrRet += '\r\nb=AS:' + (enhanceData.videoBitrate);
                        if (enhanceData.videoFrameRate !== undefined) {
                            sdpStrRet += '\r\na=framerate:' + enhanceData.videoFrameRate;
                        }
                    }
                    hitMID = true;
                } else if ('bandwidth'.localeCompare(sdpSection) == 0) {
                    let rtpmapID;
                    rtpmapID = getrtpMapID(sdpLine);
                    if (rtpmapID !== null) {
                        let match = rtpmapID[2].toLowerCase();
                        if (('vp9'.localeCompare(match) == 0) || ('vp8'.localeCompare(match) == 0) || ('h264'.localeCompare(match) == 0) ||
                            ('red'.localeCompare(match) == 0) || ('ulpfec'.localeCompare(match) == 0) || ('rtx'.localeCompare(match) == 0)) {
                            if (enhanceData.videoBitrate !== undefined) {
                                sdpStrRet += '\r\na=fmtp:' + rtpmapID[1] + ' x-google-min-bitrate=' + (enhanceData.videoBitrate) + ';x-google-max-bitrate=' + (enhanceData.videoBitrate);
                            }
                        }

                        if (('opus'.localeCompare(match) == 0) || ('isac'.localeCompare(match) == 0) || ('g722'.localeCompare(match) == 0) || ('pcmu'.localeCompare(match) == 0) ||
                            ('pcma'.localeCompare(match) == 0) || ('cn'.localeCompare(match) == 0)) {
                            if (enhanceData.audioBitrate !== undefined) {
                                sdpStrRet += '\r\na=fmtp:' + rtpmapID[1] + ' x-google-min-bitrate=' + (enhanceData.audioBitrate) + ';x-google-max-bitrate=' + (enhanceData.audioBitrate);
                            }
                        }
                    }
                }
            }
        }
        sdpStrRet += '\r\n';
    }
    
    return sdpStrRet;
}

function deliverCheckLine(profile, type) {

    let outputString = "";
    for (let line in SDPOutput) {
        let lineInUse = SDPOutput[line];
        outputString += line;
        if (lineInUse.includes(profile)) {
            if (profile.includes("VP9") || profile.includes("VP8")) {
                let output = "";
                let outputs = lineInUse.split(/\r\n/);
                for (let position in outputs) {
                    let transport = outputs[position];
                    if (transport.indexOf("transport-cc") !== -1 || transport.indexOf("goog-remb") !== -1 || transport.indexOf("nack") !== -1) {
                        continue;
                    }
                    output += transport;
                    output += "\r\n";
                }

                if (type.includes("audio")) {
                    audioIndex = line;
                }

                if (type.includes("video")) {
                    videoIndex = line;
                }

                return output;
            }
            if (type.includes("audio")) {
                audioIndex = line;
            }

            if (type.includes("video")) {
                videoIndex = line;
            }
            return lineInUse;
        }
    }
    return outputString;
}

function checkLine(line) {

    if (line.startsWith("a=rtpmap") || line.startsWith("a=rtcp-fb") || line.startsWith("a=fmtp")) {
        let res = line.split(":");

        if (res.length > 1) {
            let number = res[1].split(" ");
            if (!isNaN(number[0])) {
                if (!number[1].startsWith("http") && !number[1].startsWith("ur")) {
                    let currentString = SDPOutput[number[0]];
                    if (!currentString) {
                        currentString = "";
                    }
                    currentString += line + "\r\n";
                    SDPOutput[number[0]] = currentString;
                    return false;
                }
            }
        }
    }

    return true;
}

function getrtpMapID(line) {

    let findid = new RegExp('a=rtpmap:(\\d+) (\\w+)/(\\d+)');
    let found = line.match(findid);
    return (found && found.length >= 3) ? found : null;
}
