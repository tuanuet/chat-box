const inVal = (token) => {
    if (token === '1') return true;
    return false;
};
module.exports = (io) => {
    io.use((socket, next) => {
        if (inVal(socket.request._query.token)) return next();
        next(new Error('unauthorization'));
    });
};
