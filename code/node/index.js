require('dotenv').config();
const { createServer } = require("http");
const { Server } = require("socket.io");

const httpServer = createServer();
const io = new Server(httpServer, {
    cors: {
      origin: process.env.CLIENT_ENDPOINT
    }
});

io.on('connection', (socket) => {

  socket.on('joinRoom', (room) => socket.join(room) );

  socket.on('messageLobby', (message) => {
      io.to('lobby').emit('messageLobby', message);
  });

  socket.on('messageGame', (message) => {
      io.to('game').emit('messageGame', message);
  });
});

httpServer.listen(process.env.PORT);