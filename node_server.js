const http=require('http');

const port=6379;

const app=require('./node_app');
const server=http.createServer(app);
const io= require('socket.io')(server);
const redis=require('redis');


const client =  redis.createClient();

server.listen(3000);
console.log("Listening.....");

io.listen(server).on('connection', function(client) {
    const redisClient = redis.createClient();

    redisClient.subscribe('message');

    console.log("Redis server running.....");

    redisClient.on("message", function(channel, message) {
        console.log(message);
        client.emit(channel, message);
    });

    client.on('disconnect', function() {
        redisClient.quit();
    });
});






