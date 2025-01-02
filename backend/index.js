const express = require('express');
const cors = require('cors');
const { createServer } = require('http');
const { Server } = require('socket.io');
const connectDb = require('./db/db.js');
const bodyParser = require('body-parser');
const { MongoClient } = require('mongodb');

const app = express();
app.use(cors());
app.use(bodyParser.json());

const uri = "mongodb://localhost:27017/";
const client = new MongoClient(uri);

let db;

async function connectToMongo() {
    try {
        await client.connect();
        db = client.db('chatApp');
        console.log("Connected to MongoDB");
    } catch (err) {
        console.error("Failed to connect to MongoDB", err);
    }
}

connectToMongo();

// const db = connectDb();

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
    // socket.on('username',(username) => {
    //   console.log(username, 'is connected');
    // })
    // socket.on('send-message', (message) => {
    //     console.log(message);
    //     io.emit('new-message', message);
    // });


    // console.log('a user connected:', socket.id);

    socket.on('username', (username) => {
        socket.username = username;
        console.log(`${username} connected`);
    });

    socket.on('send-message', async (message) => {
        const chat = {
            sender: socket.username,
            message: message,
            timestamp: new Date()
        };

        try {
            await db.collection('messages').insertOne(chat);
            io.emit('new-message', `${socket.username}: ${message}`);
        } catch (err) {
            console.error("Failed to save message", err);
        }
    });

    socket.on('disconnect', () => {
        console.log(socket.username, 'disconnected',);
    });
});

app.get('/get-messages', async (req, res) => {
  try {
      const messages = await db.collection('messages').find().toArray();
      res.json(messages);
  } catch (err) {
      console.error("Failed to fetch messages", err);
      res.status(500).send("Error fetching messages");
  }
});

server.listen(3000, () => {
  console.log('server running at http://localhost:3000');
});



// {
//     members: [ user_id1, user_id2 ],
//     messages: [
//         { author: user_2, body: 'Hi what's up' },
//         { author: user_1, body: 'Nothing out here :(' },
//         { author: user_2, body: 'Whanna ask some question on stackoverflow' },
//         { author: user_1, body: 'Okay, lets go' }
//     ]
// }