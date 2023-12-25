const express = require('express');
const app = express();
const bodyParser = require('body-parser')
const socketIO = require('socket.io')
const cors = require('cors')

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({extended:true}))
app.use(cors())


const server = app.listen(5000, () => {
    console.log('server is running....')
})

const io = socketIO(server, {
    cors: {
      origin: "*",
      methods: ["GET", "POST"]
    }
  });

var emit_orders_laoPY="emit_orders_laoPY";
var emit_get_cookingPY="emit_get_cookingPY";

var emit_barPY="emit_barPY";
var emit_get_barsPY="emit_get_barsPY";

var emit_call_ordersPY="emit_call_ordersPY";
var emit_get_call_ordersPY="emit_get_call_ordersPY";

var emit_call_sfaffPY="emit_call_sfaffPY";
var emit_get_call_staffPY="emit_get_call_staffPY";

var emit_submit_ordersPY="emit_submit_ordersPY";
var emit_get_submit_ordersPY="emit_get_submit_ordersPY";

var emit_edit_deletePY="emit_edit_deletePY";
var emit_get_edit_deletePY="emit_get_edit_deletePY";

var emit_monitorPY="emit_monitorPY";
var emit_get_monitorPY="emit_get_monitorPY";

io.on('connection', (socket) => {
    // console.log('client socket connected')
    socket.on(''+emit_orders_laoPY, (response) => {
        io.sockets.emit(''+emit_get_cookingPY, response);
    })
    socket.on(''+emit_barPY, (response) => {
      io.sockets.emit(''+emit_get_barsPY, response);
    })
    socket.on(''+emit_call_ordersPY, (response) => {
      io.sockets.emit(''+emit_get_call_ordersPY, response)
    })

    socket.on(''+emit_call_sfaffPY, (response) => {
      io.sockets.emit(''+emit_get_call_staffPY, response)
    })

    socket.on(''+emit_submit_ordersPY, (response) => {
      io.sockets.emit(''+emit_get_submit_ordersPY, response)
    })

    socket.on(''+emit_edit_deletePY, (response) => {
      io.sockets.emit(''+emit_get_edit_deletePY, response)
    })

    socket.on(''+emit_monitorPY, (response) => {
      io.sockets.emit(''+emit_get_monitorPY, response)
    })

})

