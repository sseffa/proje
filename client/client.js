let express = require('express')
let app = express();
let server = require('http').createServer(app);

app.use('/assets/js/', express.static(__dirname + '/assets/js/'));
app.use('/assets/css/', express.static(__dirname + '/assets/css/'));
app.use('/', express.static(__dirname + '/assets/images/'));

server.listen(9000);
console.log('Client started.');

app.get('/', function(req, res){
    res.sendFile(__dirname + '/index.html');
});