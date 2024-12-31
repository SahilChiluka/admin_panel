const express = require('express');
const cors = require('cors');
const { createServer } = require('http');
const { Server } = require('socket.io');
const connectDb = require('./db/db.js');

const app = express();
app.use(cors());

const server = createServer(app);

const io = new Server(server, {
    cors: {
        origin: 'http://localhost:8080',
        credentials: true,
      },
});

app.get('/', (req, res) => {
  res.send('<h1>Hello world</h1>');
});

io.on('connection', (socket) => {
    socket.on('username',(username) => {
      console.log(username, 'is connected');
    })
    socket.on('send-message', (message) => {
        console.log(message);
        io.emit('new-message', message);
    });
});

server.listen(3000, () => {
  console.log('server running at http://localhost:3000');
});

connectDb();


// {
//     members: [ user_id1, user_id2 ],
//     messages: [
//         { author: user_2, body: 'Hi what's up' },
//         { author: user_1, body: 'Nothing out here :(' },
//         { author: user_2, body: 'Whanna ask some question on stackoverflow' },
//         { author: user_1, body: 'Okay, lets go' }
//     ]
// }