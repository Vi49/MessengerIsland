<template>
    <div class="container-fluid">
        <div class="row">

            <div v-show="menubarShow" class="col-md-2" style="padding-right: 0; padding-left: 0; border-right: 1px solid #666261; height: 100vh;">
                <div class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
                    <div class="row">
                        <div @click="this.menubarShow = false" class="col-12 arrow-pointer">
                            <i class="fa-solid fa-arrow-left" style="cursor: pointer"></i> Go Back
                        </div>
                    </div>
                </div>

                <div class="align-items-center flex-shrink-0 link-dark text-decoration-none border-bottom">
                    <div class="row mt-3 mb-1 justify-content-center">
                        <div class="col-12 text-center">
                            <img :src="avatar" class="menu-profile-pic">
                        </div>
                    </div>

                    <div class="row mt-3 justify-content-center">
                        <div class="col-12 fs-4 fw-bold text-center">
                            {{ userMeData.first_name }} {{ userMeData.last_name }}
                        </div>
                    </div>

                    <div class="row mb-1 justify-content-center">
                        <div class="col-12 fs-6 fw-lighter text-center">
                            @{{ userMeData.username }}
                        </div>
                    </div>
                </div>

                <div class="list-group list-group-flush border-bottom scrollarea">
                    <a href="/friends" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
                        <div class="row">
                            <div class="col-md-2 mt-2">
                                <div class="text-center">
                                    <i class="fa-solid fw-1 fa-user-group"></i>
                                </div>
                            </div>

                            <div class="col-md-10 mt-2">
                                <span class="fw-1 fw-bold">Friends</span>
                            </div></div>
                    </a>

                    <a @click.prevent data-bs-toggle="modal" data-bs-target="#settingsModal" class="list-group-item list-group-item-action py-3 lh-tight arrow-pointer" aria-current="true">
                        <div class="row">
                            <div class="col-md-2 mt-2">
                                <div class="text-center">
                                    <i class="fa-solid fa-gear"></i>
                                </div>
                            </div>

                            <div class="col-md-10 mt-2">
                                <span class="fw-1 fw-bold">Settings</span>
                            </div></div>
                    </a>

                    <a @click.prevent="logOut()" class="list-group-item list-group-item-action py-3 lh-tight arrow-pointer" aria-current="true">
                        <div class="row">
                            <div class="col-md-2 mt-2">
                                <div class="text-center">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </div>
                            </div>

                            <div class="col-md-10 mt-2">
                                <span class="fw-1 fw-bold">Log out</span>
                            </div></div>
                    </a>
                </div>
            </div>

            <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="settingsModalLabel"> Settings</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <div class="text-center">
                                    <img v-bind:src="this.avatar" alt="Profile Picture" class="settings-profile-pic">
                                </div>

                                <div class="text-center mb-4">
                                    <div class="alert alert-danger" role="alert" :style="this.photoError == '' ? 'display: none' : ''">
                                        {{ this.photoError }}
                                    </div>

                                    <label for="fileInput" class="btn btn-success mt-3">
                                        Edit profile photo <i class="fas fa-camera"></i>
                                    </label>
                                    <!-- File input (hidden) -->
                                    <input type="file" id="fileInput" style="display: none;" @change="handleFileChange">
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input @change="editChangedValue('username', $event.target.value)" type="text" :value="userMeData.username" class="form-control" id="username" placeholder="Enter username">
                                </div>
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input @change="editChangedValue('first_name', $event.target.value)" type="text" :value="userMeData.first_name" class="form-control" id="firstName" placeholder="Enter first name">
                                </div>
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input @change="editChangedValue('last_name', $event.target.value)" type="text" :value="userMeData.last_name" class="form-control" id="lastName" placeholder="Enter last name">
                                </div>
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio</label>
                                    <input @change="editChangedValue('bio', $event.target.value)" type="text" :value="userMeData.bio" class="form-control" id="bio" placeholder="Any details about you">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-2" v-show="!menubarShow" style="display: none; padding-right: 0; padding-left: 0; border-right: 1px solid #666261; height: 100vh;">

                <div class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
                    <i @click="this.menubarShow = true" class="fa-solid fa-bars fs-3" style="cursor: pointer"></i>

                    <input @input="fetchResults" v-model="searchTerm" class="form-control rounded-pill" type="search" placeholder="Search" aria-label="Search" style="margin-left: 12px">

                </div>
                <div class="list-group list-group-flush border-bottom scrollarea" v-if="!isSearch">


                    <div v-for="friend in friend_list" :key="friend.last_seen">
                        <a :href="'/chat/user/' + friend.user_id" class="list-group-item list-group-item-action py-3 lh-tight friend-item" aria-current="true">
                            <div class="row">
                                <div class="col-md-3 mt-2">
                                    <img :src="'/avatars/'+ ((this.friend && this.friend.avatar)  ? this.friend.avatar : 'default.jpg')" class="profile-pic">
                                </div>

                                <div class="col-md-9" style="padding-left: 0px; margin-left: 0">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <strong class="mb-1">{{ friend.first_name }} {{ friend.last_name }}</strong>
                                        <small>Sun</small>
                                    </div>
                                    <!-- TODO: add last message here -->
                                    <div class="col-10 mb-1 small">Here must be last message </div>
                                </div></div>
                        </a>
                    </div>

                </div>
                <div v-else>
                    <search-results :searchResults="this.searchResults"></search-results>
                </div>

            </div>

            <!-- Friends -->
            <div class="col-md-10" style="padding-left: 0; padding-right: 0" v-if="isFriendsRoute">
                <friends :friendlist_type="friendlist_type" :jwtToken="jwtToken" :sidebar_friendlist="friend_list"></friends>
            </div>

            <!-- Chat -->
            <div class="col-md-10" style="padding-left: 0; padding-right: 0" v-else>
                <chat :chat_id="chat_id" :chat_type="chat_type" :jwtToken="jwtToken"></chat>
            </div>
        </div>
    </div>



</template>

<script>

import SearchComponent from "./SearchComponent.vue";
import ChatComponent from "./ChatComponent.vue";
import FriendsComponent from "./FriendsComponent.vue";

export  default {
    data() {
        return {
            userMeData: {},
            menubarShow: false,
            jwtToken: localStorage.getItem('jwtToken'),
            jwtTokenExpires: localStorage.getItem('jwtTokenExpires'),
            file: null,
            avatar: '',
            photoError: '',
            searchTerm: '',
            searchResults: [],
            isSearch: false,
            chat_id: this.$route.params.chat_id ?? 0,
            chat_type: this.$route.params.chat_type ?? '',
            friend_list: [],
            friendlist_type: this.$route.params.friendlist_type ?? '',
        };
    },
    mounted() {
        this.getUserMe();
        this.getFriendList();
        this.setWindowTitle();
    },
    computed: {
        isFriendsRoute(){
            return this.$route.path === '/friends' || this.$route.path === '/friends/'+this.friendlist_type;
        }
    },
    methods: {
        setWindowTitle(){
            let title = 'Messenger Island';

            if(this.$route.path === '/friends'){
                title += " - Friends"
            }
            else if(this.$route.path === '/friends/all'){
                title += " - Friends (All)"
            }
            else if(this.$route.path === '/friends/pending'){
                title += " - Friends (Pending)"
            }
            else if(this.$route.path === '/friends/blocked'){
                title += " - Friends (Blocked)"
            }
            else if(this.$route.path.includes('chat/user/')){
                title += " - Chat"
            }

            document.title = title;
        },
        editChangedValue(editType, editValue){

            this.userMeData[editType] = editValue;

            if(editType == 'username') {
                axios.post('/api/user/editUsername', {'username': editValue}, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('jwtToken')}`
                    }
                })
                    .then(response => {

                    })
                    .catch(error => {
                        console.error('Error editing username:', error);
                    });
            }
            else if(editType == 'first_name'){
                axios.post('/api/user/editFirstName', {'first_name': editValue}, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('jwtToken')}`
                    }
                })
                    .then(response => {

                    })
                    .catch(error => {
                        console.error('Error editing first_name:', error);
                    });
            }else if(editType == 'last_name'){
                axios.post('/api/user/editLastName', {'last_name': editValue}, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('jwtToken')}`
                    }
                })
                    .then(response => {

                    })
                    .catch(error => {
                        console.error('Error editing last_name:', error);
                    });
            }
            else if(editType == 'bio'){
                axios.post('/api/user/editBio', {'bio': editValue}, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('jwtToken')}`
                    }
                })
                    .then(response => {

                    })
                    .catch(error => {
                        console.error('Error editing bio:', error);
                    });
            }
        },
        getUserMe(){
            axios.post('/api/auth/me', {}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(data => {
                const userData = data.data;

                for (let key in userData) {
                    this.userMeData[key] =  userData[key];
                }

                this.avatar = `/avatars/`+ ((this.userMeData.avatar == null) ? 'default.jpg' : this.userMeData.avatar);
            }).catch(error => {
                console.error('failed to getUserMe' + error);
            })
        },
        logOut(){

            //
            // console.log(this.jwtTokenn+" "+);

            axios.post('/api/auth/logout', {}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(()=>{
                localStorage.removeItem('jwtToken');
                localStorage.removeItem('jwtTokenExpires');

                location.href = '/login';
            }).catch(() => {})
        },
        fetchResults(event) {
            if(event.target.value.length == 0){
                this.isSearch = false;
            }

            if(event.target.value.length > 3) {

                // Send Axios request
                axios.post('/api/search', {'word': this.searchTerm}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(response => {
                    // Update searchResults with the response data
                    this.searchResults = response.data.data;

                })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    });

                this.isSearch = true;

            }


        },
        handleFileChange(event) {
            // Replace previously selected file with the new one
            this.file = event.target.files[0];

            if (this.file) {
                let fileExtension = this.file.name.split('.').pop();

                this.photoError = ''

                if(fileExtension != 'png' && fileExtension != 'jpg' && fileExtension != 'jpeg' && fileExtension != 'gif'){
                    this.photoError = 'Invalid profile photo type! Choose the other one.';
                    return;
                }

                if(this.file.size > 2*1024*1024){
                    this.photoError = 'This profile photo file is too big! Choose the other one.';
                    return;
                }

                const formData = new FormData();
                formData.append('avatar', this.file);

                axios.post('/api/user/editAvatar', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Authorization': `Bearer ${localStorage.getItem('jwtToken')}`
                    }
                })
                    .then(response => {

                    })
                    .catch(error => {
                        console.error('Error editing avatar:', error);
                    });

                const reader = new FileReader();
                reader.onload = () => {
                    this.avatar = reader.result;
                };
                reader.readAsDataURL(this.file);

            }
        },
        getFriendList(){
            axios.get('/api/friend/getFriendList', {headers: {'Authorization': `Bearer ${localStorage.getItem('jwtToken')}`}})
                .then(response => {
                    this.friend_list = response.data.data;
                }).catch();
        }
    },
    components: {
        'search-results': SearchComponent,
        'chat': ChatComponent,
        'friends': FriendsComponent
    }
}
</script>

<style scoped>
.friend-item {
    height: 90px;
    display: block; /* Ensure the link takes up the full width */
    padding: 10px 20px 0 10px;
}


.scrollarea {
    max-height: 92vh; /* Adjust the height as per your requirement */
    overflow-y: auto; /* Enable vertical scrolling */
}

.text-last-time{
    font-size: 13px;
    color: #666261;
}

div .last-time-bottom-line{
    border-bottom: 1px solid #666261;
}

div .chatting-area{

}

/*Conversation*/

.conversation {
    padding: 0 !important;
    margin: 0 !important;
    height: 100%;
    /*width: 100%;*/
    border-left: 1px solid rgba(0, 0, 0, .08);
    /*overflow-y: auto;*/
}

.message {
    padding: 0 !important;
    margin: 0 !important;

    background-size: cover;
    overflow-y: auto;
    border: 1px solid #f7f7f7;
    height: calc(100% - 120px);
}
.message-previous {
    margin : 0 !important;
    padding: 0 !important;
    height: auto;
    width: 100%;
}
.previous {
    font-size: 15px;
    text-align: center;
    padding: 10px !important;
    cursor: pointer;
}

.previous a {
    text-decoration: none;
    font-weight: 700;
}

.message-body {
    margin: 0 !important;
    padding: 0 !important;
    width: auto;
    height: auto;
}

.message-main-receiver {
    /*padding: 10px 20px;*/
    max-width: 60%;
}

.message-main-sender {
    padding: 3px 20px !important;
    margin-left: 40% !important;
    max-width: 60%;
}

.message-text {
    margin: 0 !important;
    padding: 5px !important;
    word-wrap:break-word;
    font-weight: 200;
    font-size: 14px;
    padding-bottom: 0 !important;
}

.message-time {
    margin: 0 !important;
    margin-left: 50px !important;
    font-size: 12px;
    text-align: right;
    color: #9a9a9a;

}

.receiver {
    width: auto !important;
    padding: 4px 10px 7px !important;
    border-radius: 10px 10px 10px 0;
    background: #ffffff;
    font-size: 12px;
    text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
    word-wrap: break-word;
    display: inline-block;
}

.sender {
    float: right;
    width: auto !important;
    background: #dcf8c6;
    border-radius: 10px 10px 0 10px;
    padding: 4px 10px 7px !important;
    font-size: 12px;
    text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
    display: inline-block;
    word-wrap: break-word;
}

.profile-pic {
    width: 90%; /* Adjust the width as needed */
    height: 90%; /* Adjust the height as needed */
    border-radius: 50%;
}


.settings-profile-pic {
    width: 120px; /* Adjust the width as needed */
    height: 120px; /* Adjust the height as needed */
    border-radius: 50%;
}

.menu-profile-pic{
    width: 5rem; /* Adjust the width as needed */
    height: 5rem; /* Adjust the height as needed */
    border-radius: 50%;
}


.arrow-pointer{
    cursor: pointer;
}

</style>
