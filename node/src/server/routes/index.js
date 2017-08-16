var express = require('express');
var router = express.Router();

/**
 * Get request
 */
router.get('/', (req, res) => {
    res.status(200).end(renderFullPage());
});
function renderFullPage() {
    return `
    <!doctype html>
    <html lang="en">
      <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,700" rel="stylesheet">
        <link rel="icon" href="./favicon.ico" type="image/x-icon" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <title>React Redux Socket.io Chat</title>
      </head>
      <body>
        <div id="root"></div>
        <script src="/dist/bundle.js"></script>
      </body>
    </html>
  `;
}
module.exports = router;
