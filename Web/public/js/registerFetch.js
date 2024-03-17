let jwtToken = localStorage.getItem('jwtToken');
let jwtTokenExpires = localStorage.getItem('jwtTokenExpires');

if(jwtToken && jwtTokenExpires){
    location.href = "/";
}

$(document).ready(function(){
    $('button[type="submit"]').click(function (e){
        e.preventDefault();

        let emailValue = $('#email').val();
        let passwordValue = $('#password').val();

        //Add email and password to localStorage to then login and get jwtToken
        localStorage.setItem('regEmail', emailValue);
        localStorage.setItem('regPassword', passwordValue);

        let expirationDate = new Date();
        expirationDate.setSeconds(expirationDate.getSeconds() + 43200*60-1);
        localStorage.setItem('jwtTokenExpires', expirationDate.toISOString());

        $('form[method="POST"]').submit();
    });
});
