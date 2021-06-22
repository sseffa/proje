let express = require('express')
let app = express();
let server = require('http').createServer(app);
let io = require('socket.io').listen(server);
let roomMembers = [];
app.use(express.static('public'));

server.listen(3000);
console.log('Server started.');

io.sockets.on('connection', clientConnected);

function clientConnected(socket) {

    socket.on('disconnect', function () {

        io.to(socket.room).emit("message", {type: "user_left", data: socket.nickname});
        if (roomMembers[socket.room]) {
            roomMembers[socket.room].splice(roomMembers[socket.room].indexOf(socket.nickname), 1);
        }
    });

    socket.on('login', function (data) {

        socket.nickname = data.nickname;
        socket.room = data.room;
        socket.join(data.nickname);
        socket.join(data.room);
        socket.broadcast.to(data.room).emit("message", {type: "new_user_login", data: data.nickname});

        if (!roomMembers[socket.room]) {
            roomMembers[socket.room] = [];
        }
        roomMembers[socket.room].push(data.nickname);
       
    });

    socket.on('getRoomClients', function () {
        io.sockets.to(socket.nickname).emit("message", {type: "get_user_list", data: roomMembers[socket.room]});
    });

    socket.on('sendMessage', function (message) {
        
        io.sockets.to(socket.room).emit("message", {
            type: "get_message",
            data: {nickname: socket.nickname, message: message}
        })
    });

    socket.on('publishStream', function () {

         io.sockets.to(socket.room).emit("message", {
            type: "publish_stream",
            data: {nickname: socket.nickname}
        })
    });
}