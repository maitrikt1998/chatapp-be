const express = require('express'); 
const app = express(); 
const http = require('http'); 
const { Server } = require('socket.io'); 

const server = http.createServer(app); 
const io = new Server(server, {   
    cors: { origin: "*" } 
});  

app.get('/', (req, res) => {     
    res.send('<h1>Hello world</h1>');   
});     

io.on('connection', (socket) => {     
    console.log('A user connected');
    
    socket.on('message', (message) => {
        console.log('Received message:', message);
        // You can broadcast this message to other clients if needed
        // io.emit('message', message);
    });

    socket.on('disconnect', () => {             
        console.log('User disconnected');      
    });
});  

server.listen(3005, () => {   
    console.log('Socket server is running on port 3005'); 
});
