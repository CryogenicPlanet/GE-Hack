//var port = process.env.PORT;
//server
//var express = require('express');
//var app = express();
//var server = app.listen(port);
//dependencies
var bodyParser = require('body-parser');

//var SimplyThread = require('simplythread');
var fs = require("fs");
var sleep = require('sleep');
//var http = require('http').Server(app);
//var io = require('socket.io')(http);
var jsonParser = bodyParser.json();
var mysql = require('mysql');
var connection = mysql.createConnection({
    host: process.env.IP,
    user: "healthbot",
    password: "password",
    database: 'c9'
});
//app.use(bodyParser.json());
connection.connect();


/*app.post("/phpget", jsonParser, function(req, res) {
    console.log(req.body);
    var columns = ['QID', 'Weightage'];
    var sum;
    var total;
    var query = connection.query('SELECT ?? FROM ?? WHERE VID = ??', [columns, 'users', req.body.vid], function(error, results) {
        if (error) throw error;
        results.forEach(function(result) {
            total += result.Weightage * result.Weightage;
            var query = connection.query('SELECT isTrue FROM answers WHERE QID = ?? AND UID = ??', [result.QID, req.body.uid], function(err, rows) {
                if (err) throw err;
                if (result.Weightage > 0 || rows[0].isTrue == 0) {
                    sum += result.Weightage * result.Weightage;
                }
                else if (result.Weightage < 0 || rows[0].isTrue == 1) {
                    sum += result.Weightage * result.Weightage;
                }
            });

        });
    });
    var risk = (sum / total) * 50;
    var query = connection.query('UPDATE INTO users SET Risk = ?? WHERE UID = ?? AND UID = ??', [risk, req.body.vid, req.body.uid], function(err) {
        if (err) throw err;
        res.send({
            patientrisk: risk
        });

    });

});
*/

var uid = 2147483647;
var vid = 1;
/*
while (1) {
    sleep.sleep(3);
    fs.readFile('tonode.json', function(err, data) {
        if(err){
            return console.error(err);
        }
       
        var obj = JSON.parse(data);
         uid = obj.UID;
         vid = obj.VID;
    });
    sleep.msleep(10);
    cleanTonode();
    if (uid != "") {
        
        risk = getRisk(uid, vid);
        sleep.msleep(10);
        toPHP(risk);
        uid = "";
        vid = "";
    }
}
function cleanTonode() {
fs.writeFile('tonode.json',"",jsonParser,function(err) {
    if(err) console.log(err);
});
}
function toPHP(risk) {
  
    fs.writeFile('tophp.txt', risk, jsonParser, function(err) {
        if (err) throw err;
    });
}
// var //sleep = require('//sleep');


        console.log(uid);
    }); */
var Ptrisk = getRisk(uid, vid);

function getRisk(uid, vid) {

    var temp = 0;
    var sum = 0;
    var total = 0;
    var query = connection.query('SELECT QID,Weightage FROM question WHERE VID = ?', vid, function(error, results) {
        if (error) throw error;
        console.log(query);
        results.forEach(function(result) {
            start: var weightage = parseFloat(result.Weightage);
            total = total + (weightage * weightage);
            var isTrue = query2(weightage, sum, result);

            sum += getSum(weightage, sum, isTrue);
            console.log(sum);
        });
        temp = risk(sum, total);
        console.log(temp);


    });
    if (temp != 0) {
        connection.end();
        Ptrisk = temp;

    }
    else getRisk(uid, vid);
}

function risk(sum, total) {

    var risk = (sum / total) * 50;
    var query2 = connection.query('UPDATE INTO users SET Risk = ' + risk + ' WHERE UID = ' + uid + ' AND VID = ' + vid, function(err) {
        if (err) throw err;

    });
    return risk;
}

function getSum(weightage, sum, isTrue) {
    if (weightage > 0 || isTrue == 0) {
        sum += weightage * weightage;
    }
    else if (weightage < 0 || isTrue == 1) {
        sum += weightage * weightage;
    }
    return sum;
}

function query2(weightage, sum, result) {
    var query1 = connection.query('SELECT isTrue FROM answers WHERE QID = ' + result.QID + ' AND UID =' + uid, function(err, rows) {
        if (err) throw err;
        return rows[0].isTrue;
        /*  //  sum = getSum(weightage,sum,rows[0].isTrue);
           if (weightage > 0 || rows[0].isTrue == 0) {
                sum += weightage * weightage;
            }
            else if (weightage < 0 || rows[0].isTrue == 1) {
                sum += weightage * weightage;
            } */

    });
}
console.log(Ptrisk);