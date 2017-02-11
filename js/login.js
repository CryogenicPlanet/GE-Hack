 var password = document.getElementById('password').value;

            function login(){
                if (password == "hostipal1") {
                    //   window.location.replace("/questions.php?userId='" + document.getElementById('userId').value + "'");
                }
                else{
                    invalidPassword();
                }
            }

            function newUser(){
                if (password == 'hostipal1') {
                   // window.location.replace("/questions.php?userId=0");
                }
                else {
                    invalidPassword();
                }
            }

            function invalidPassword() {
                var $toastContent = $('<span>Invalid Password! Please Enter a Valid Password or Use Guest User</span>');
                Materialize.toast($toastContent, 50000);
            }