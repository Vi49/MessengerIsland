$(document).ready(function(){
    $('button[type="submit"]').click(function (e){
        e.preventDefault();

        let emailValue = $('#email').val();
        let passwordValue = $('#password').val();

        axios.post("/api/auth/login", {"email": emailValue, "password": passwordValue}).then(data=>{

            localStorage.setItem('jwtToken', data.data.access_token);

        }).catch(()=>{

        });

        e.submit();
    });
});
