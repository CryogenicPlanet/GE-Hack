var port = process.env.PORT;
//server
var express = require('express');
var app = express();
var server = app.listen(port);
//dependencies
var bodyParser = require('body-parser');
var http = require('http').Server(app);
var io = require('socket.io')(http);
 var  jsonParser = bodyParser.json();
var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : process.env.IP,
  user     : "healthbot",
  password : "password",
  database : 'c9'
});
app.use(bodyParser.json());

connection.connect();

app.post("/phpget",jsonParser,function(req,res){
    console.log(req.body);
    var columns = ['QID', 'Weightage'];
     var sum;
     var total;
   var query = connection.query('SELECT ?? FROM ?? WHERE VID = ??', [columns, 'users', req.body.vid], function (error, results) {
        if (error) throw error;
        results.forEach(function(result) {
            total += result.Weightage * result.Weightage;
        var query = connection.query('SELECT isTrue FROM answers WHERE QID = ?? AND UID = ??',[result.QID,req.body.uid],function (err,rows){
            if(err) throw err;
            if(result.Weightage > 0 || rows[0].isTrue==0){
            sum += result.Weightage * result.Weightage;
            }else if(result.Weightage < 0 || rows[0].isTrue==1){
                sum += result.Weightage * result.Weightage;
            }
        });
        
   });
});
var risk = (sum/total)*50;
var query = connection.query('UPDATE INTO users SET Risk = ?? WHERE UID = ?? AND UID = ??',[risk,req.body.vid,req.body.uid],function(err){
    if(err) throw err;
res.send({patientrisk : risk});

});

});
http.listen(8080, function(){
  var addr = http.address();
  console.log('app listening on ' + addr.address + ':' + addr.port);
});
app.listen(8080);
connection.end();