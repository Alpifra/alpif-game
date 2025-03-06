require('dotenv').config();
const { createServer } = require("http");
const { Server } = require("socket.io");

const httpServer = createServer();
const io = new Server(httpServer, {
    cors: {
      origin: process.env.CLIENT_ENDPOINT
    }
});

io.on("connection", (socket) => {
  console.log("hello")
});

httpServer.listen(process.env.PORT);

console.log(process.env.CLIENT_ENDPOINT, process.env.PORT);
