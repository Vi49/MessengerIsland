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

        axios.post("/api/auth/login", {"email": emailValue, "password": passwordValue}).then(data=>{

            localStorage.setItem('jwtToken', data.data.access_token);

            let expirationDate = new Date();
            expirationDate.setSeconds(expirationDate.getSeconds() + 43200*60-1);
            localStorage.setItem('jwtTokenExpires', expirationDate.toISOString());

        }).catch(()=>{

        });

        $('form[method="POST"]').submit();
    });
});
