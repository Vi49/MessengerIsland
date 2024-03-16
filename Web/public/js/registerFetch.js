$(document).ready(function(){
    $('button[type="submit"]').click(function (e){
        e.preventDefault();

        let emailValue = $('#email').val();
        let passwordValue = $('#password').val();

        //Add email and password to localStorage to then login and get jwtToken
        localStorage.setItem('regEmail', emailValue);
        localStorage.setItem('regPassword', passwordValue);

        e.submit();
    });
});
