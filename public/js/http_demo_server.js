	var http = require('http');
	const serialport = require('serialport');
	const port = new serialport('/dev/ttyS0', {baudRate: 9600});

	http.createServer(function (req, res) {
	  res.writeHead(200, {'Content-Type': 'text/plain'});
	  res.end('Welcome Node.js');
	}).listen(3001, "127.0.0.1");


	console.log('Server running at http://127.0.0.1:3001/');
	console.log("boa tarde");

	port.on('data', function (data) {
	  console.log('Data:', data);
	});

