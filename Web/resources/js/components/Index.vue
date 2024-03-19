<template>
    <div>
       <router-view></router-view>
    </div>

</template>

<script>
export default {
    name: "Index",
    data(){
        return {
            jwtToken: '',
            jwtTokenExpires: '',
            timerOnline: null
        };
    },
    beforeCreate() {
        let regEmail = localStorage.getItem('regEmail');
        let regPassword = localStorage.getItem('regPassword');

        if(regEmail && regPassword){

            axios.post('/api/auth/login', {"email": regEmail, "password": regPassword})
                .then(data => {
                    localStorage.setItem('jwtToken', data.data.access_token);

                    let expirationDate = new Date();
                    expirationDate.setSeconds(expirationDate.getSeconds() + 43200*60-1);
                    localStorage.setItem('jwtTokenExpires', expirationDate.toISOString());

                    localStorage.removeItem('regEmail');
                    localStorage.removeItem('regPassword');

                    return;
                }).catch(() => {
                    location.href = '/register';
            });
        }


        let jwtToken = localStorage.getItem('jwtToken');
        let jwtTokenExpires = localStorage.getItem('jwtTokenExpires');

        let jwtExpiredDate = new Date(jwtTokenExpires);
        let currentDate = new Date();

        if(!window.location.pathname.includes( "/register") || !window.location.pathname.includes( "/login")  || !window.location.pathname.includes( "/password/")){
            if(!jwtToken || !jwtTokenExpires || currentDate > jwtExpiredDate){
                localStorage.removeItem('jwtToken');
                localStorage.removeItem('jwtTokenExpires');
                //alert('error shite');
                location.href = "/login";
            }
        }

        axios.post('/api/auth/me', {}, {headers: {Authorization: `Bearer ${jwtToken}`}}).then(data => {
            if(data.data.is_afterreged == 0 && !window.location.pathname.includes( "/afterreg")){
                location.href = '/afterreg';
            }
        }).catch(errorData=>{
            localStorage.removeItem('jwtToken');
            localStorage.removeItem('jwtTokenExpires');
            //alert('error me');
            location.href = "/login";
        });
    },
    mounted() {
        this.jwtToken = localStorage.getItem('jwtToken');
        this.jwtTokenExpires = localStorage.getItem('jwtTokenExpires');


        if(this.jwtToken && this.jwtTokenExpires) {
            this.timerOnline = setInterval(this.checkUserPresence,  2*60*1000);
        }
    },
    beforeDestroy() {
        // Clear the timer to avoid memory leaks
        clearInterval(this.timerOnline);
    },
    methods: {
        checkUserPresence() {
            axios.patch('/api/user/updateLastSeen', {}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then().catch();
        }
    }
}

</script>

<style scoped>

</style>
