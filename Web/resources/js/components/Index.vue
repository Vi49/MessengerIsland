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
            isUserOnline: false,
            jwtToken: '',
            jwtTokenExpires: '',
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
        jwtToken = localStorage.getItem('jwtToken');
        jwtTokenExpires = localStorage.getItem('jwtTokenExpires');

        if(jwtToken && jwtTokenExpires) {
            this.isUserOnline = true;

            window.addEventListener('mousemove', this.setUserOnline);
            window.addEventListener('keydown', this.setUserOnline);

            // Set user offline when user is inactive for a certain period (e.g., 5 minutes)
            this.setUserOfflineAfterInactivity();
        }
    },
    methods: {
        setUserOnline() {
            this.isUserOnline = true;

            const timestamp = Math.floor(Date.now() / 1000);
            axios.patch('/api/updateLastSeen', {}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then().catch();

        },
        setUserOffline() {
            this.isUserOnline = false;
        },
        setUserOfflineAfterInactivity() {
            let timer;
            const inactivityDuration = 1 * 60 * 1000; // 1 minute

            const resetTimer = () => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    this.setUserOffline();
                }, inactivityDuration);
            };

            resetTimer();

            window.addEventListener('mousemove', resetTimer);
            window.addEventListener('keydown', resetTimer);
        }
    }
}

</script>

<style scoped>

</style>
