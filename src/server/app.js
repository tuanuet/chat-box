const express = require('express');
const path = require('path');
// const favicon = require('serve-favicon');
const logger = require('morgan');
const bodyParser = require('body-parser');
require('dotenv').config({ path: '.env' });
const ChatSocketEvent = require('./ChatSocketEvent');
const chalk = require('chalk');
const Webhook = require('./routes/index');
/**
 * Create Express server.
 */
const app = express();


/**
 * Express configuration.
 */
app.set('port', process.env.PORT || 3001);
// uncomment after placing your favicon in /public
// app.use(favicon(path.join(__dirname, 'public', 'favicon.ico')));
app.use(logger('dev'));
app.use(function(req, res, next) {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Headers', 'X-Requested-With');
    res.header('access-control-allow-methods','GET, POST, PUT, DELETE, OPTIONS');
    next();
});
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: false}));
app.use('/', express.static(path.join(__dirname, '../..', 'static')));


// RUN SERVER
const server = app.listen(app.get('port'), () => {
    console.log('%s App is running at http://localhost:%d in %s mode', chalk.green('✓'), app.get('port'), app.get('env'));
    console.log('  Press CTRL-C to stop\n');
});
/**
 * Config Socket with adapter-redis
 */
const io = require('socket.io').listen(server);
const redis = require('socket.io-redis');
io.adapter(redis({host : process.env.REDIS_HOST, port : process.env.REDIS_PORT}));
ChatSocketEvent(io);

Webhook(app,io);

