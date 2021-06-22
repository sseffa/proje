$(function () {

    let text = $('#chat_message');
    $('html').keydown(function (e) {
        if (e.which === 13 && text.val().length !== 0) {
            socket.emit('sendMessage', text.val());
            text.val('');
            e.preventDefault();
        }
    });

    $('#open-participant').click(function (e) {
        if ($('.main__right').hasClass("open")) {
            if ($('.main__right').hasClass("participant")) {
                $('.main__right').toggleClass("open participant");
            } else {
                // change tab
                $('#participants-tab').click();
                $('.main__right').removeClass("chat");
                $('.main__right').addClass("participant");
                $('#open-chat').toggleClass("active");
            }
        } else {
            $('.main__right').toggleClass("open participant");
            $('#participants-tab').click();
        }

        $('#open-participant').toggleClass("active");
    });

    $('#open-chat').click(function (e) {
        if ($('.main__right').hasClass("open")) {
            if ($('.main__right').hasClass("chat")) {
                $('.main__right').toggleClass("open chat");
            } else {
                // change tab
                $('#home-tab').click();
                $('.main__right').removeClass("participant");
                $('.main__right').addClass("chat");
                $('#open-participant').toggleClass("active");
            }

        } else {
            $('.main__right').toggleClass("open chat");
            $('#home-tab').click();
        }

        $('#open-chat').toggleClass("active");
    });
});
