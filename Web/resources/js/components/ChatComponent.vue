<template>

    <div v-if="chat_id && chat_type != ''">

        <!-- Chat name -->
        <div class="container-fluid last-time-bottom-line" style="padding-bottom: 5px">
            <div class="row">
                <div class="col-md-11" data-bs-toggle="modal" data-bs-target="#userInfoModal" style="cursor: pointer">
                    <div class="row mt-3">
                        <span class="fs-5 fw-semibold">{{ this.chat_information.first_name }} {{ this.chat_information.last_name }}</span>
                    </div>
                    <div class="row">
                        <span class="text-last-time">last seen {{ this.chat_information.last_seen_human_ago }}</span>
                    </div>
                </div>

                <div class="col-md-1 text-md-end mt-4" style="padding-right: 20px">
                    <!-- Dropdown for ellipsis -->
                    <div class="dropdown">
                        <button class="btn" type="button" id="ellipsisMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical fs-2"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="ellipsisMenu">
                            <li>
                                <div v-if="chat_information['friend_status'] == 'unknown'">
                                    <a class="dropdown-item" href="#" @click.prevent="sendFriendRequest"><i class="fa-solid fa-user-plus"></i> Send friend request</a>
                                </div>
                                <div v-else-if="chat_information['friend_status'] == 'requested first'">
                                    <a class="dropdown-item" href="#" @click.prevent="acceptFriendRequest"><i class="fa-solid fa-user-plus"></i> Accept friend request</a>
                                </div>
                                <div v-else-if="chat_information['friend_status'] == 'requested second'">
                                    <a class="dropdown-item" href="#" @click.prevent="removeFriendRequest"><i class="fa-solid fa-ban"></i> Remove my friend request</a>
                                </div>
                                <div v-else-if="chat_information['friend_status'] == 'friends'">
                                    <a class="dropdown-item" href="#" @click.prevent="removeFromFriends"><i class="fa-solid fa-bam"></i> Remove from friends</a>
                                </div>
                            </li>
                            <li>
                                <div v-if="chat_information['is_blocking']">
                                    <a class="dropdown-item" href="#" @click="unblockCurrentChat"><i class="fa-regular fa-circle-xmark"></i> Unblock</a>
                                </div>
                                <div v-else>
                                    <a class="dropdown-item" href="#" @click="blockCurrentChat"><i class="fa-solid fa-ban"></i> Block</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat messages -->
        <div class="container-fluid mt-3" style="display: flex; flex-direction: column; height: 90vh;">
            <div class="align-top" style="overflow-y: scroll; overflow-x: hidden; padding-left: 20px; width: 100%; height: 105vh">

                <div class="row message-body">
                    <div class="col-sm-12 message-main-receiver">
                        <div class="receiver">
                            <div class="message-text">
                                Hello kompaniya ZAO (((BURTAU))) budiet unechtozhena cherez 24 chasa.
                            </div>
                            <div class="text-end">
                                    <span class="message-time ">
                                        Sun
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row message-body">
                    <div class="col-sm-12 message-main-sender">
                        <div class="sender">
                            <div class="message-text">
                                Идите ка вы к ЧЁР.ТОВОЙ БАБУШКИ УРОТ
                            </div>
                            <div class="text-end">
                                    <span class="message-time">
                                            Sun
                                        </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Send message -->
            <div class="row justify-content-between mt-auto">
                <div class="align-self-end" >
                    <div class="form-group mt-3 mb-0" v-if="chat_information['is_blocking']">
                        <div class="row">
                            <div class="col-md-12">
                                <button @click="unblockCurrentChat()" type="button" class="btn btn-danger rounded-pill w-100"><i class="fa-solid fa-unlock"></i> Unblock</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3 mb-0" v-else>
                        <div class="row" v-if="chat_information['friend_status']=='friends'">
                            <div class="col-md-1">
                                <button data-bs-toggle="modal" data-bs-target="#sendFileModal"  type="button" class="btn btn-success rounded-pill w-100"><i class="fa-solid fa-paperclip"></i></button>
                            </div>
                            <div class="col-md-10">
                                <input maxlength="500" type="text" class="form-control rounded-pill w-100" v-model="message_text">
                            </div>
                            <div class="col-md-1">
                                <div class="row">
                                    <div class="col-4">
                                        <div>
                                            <button @click="toggleEmojiShow" type="button" id="emojiButton" class="btn btn-secondary rounded-pill"><i class="fa-regular fa-face-smile"></i></button>
                                        </div>
                                        <div id="emojiContainer" v-show="emoji_show">
                                            <EmojiPicker :native="true" @select="onSelectEmoji" />
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <button type="button" class="btn btn-primary rounded-pill ">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-else-if="chat_information['friend_status']=='unknown'">
                            <div class="col-md-12">
                                <button type="button" @click="sendFriendRequest()" class="btn btn-success rounded-pill w-100"><i class="fa-solid fa-user-plus"></i> Send friend request</button>
                            </div>
                        </div>
                        <div class="row" v-else-if="chat_information['friend_status']=='requested first'">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary rounded-pill w-100"><i class="fa-solid fa-envelope"></i> You were friend requested, please accept it in "Friends" tab </button>
                            </div>
                        </div>
                        <div class="row" v-else-if="chat_information['friend_status']=='requested second'">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary rounded-pill w-100"><i class="fa-solid fa-envelope"></i> Friend request was sent </button>
                            </div>
                            <div class="col-md-12 mt-2">
                                <button @click="removeFriendRequest()" type="button" class="btn btn-danger rounded-pill w-100"><i class="fa-solid fa-ban"></i> Remove your friend request </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div class="container-fluid d-flex justify-content-center mt-3" style="display: flex; flex-direction: column; height: 90vh;">
            <div class="row d-flex justify-content-center">
                <div class="col-4 d-flex justify-content-center">
                    <button class="btn btn-outline-primary rounded-pill select-a-chat-button">Select a chat to start messanging</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal show user info -->
    <div class="modal fade" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userInfoModalLabel"> {{ info_header }} Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="row border-bottom" style="padding-bottom: 12px">
                            <div class="col-md-3 mt-2 d-flex justify-content-center">
                                <img v-bind:src="`/avatars/`+ ((this.chat_information.avatar == null) ? 'default.jpg' : this.chat_information.avatar)" alt="Profile Picture" class="settings-profile-pic">
                            </div>
                            <div class="col-md-9 d-flex justify-content-left">
                                <div class="row">
                                    <span class="mt-2 fs-3 fw-bold"> {{ this.chat_information.first_name }} {{ this.chat_information.last_name }} </span>
                                    <span class="fs-6">last seen {{ (chat_information['is_blocking']) ? 'a long time ago' :this.chat_information.last_seen_human_ago }}</span>
                                </div>
                            </div>
                        </div>
                        <div v-if="chat_information.bio || chat_information.username" class="row border-bottom" style="padding-bottom: 12px">
                            <div class="row mt-3" v-if="chat_information.bio">
                                <div class="col-md-2 d-flex justify-content-center mt-1">
                                    <i class="fa-solid fa-circle-info fs-3"></i>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <span class="fs-5"> {{ this.chat_information.bio }} </span>
                                    </div>
                                    <div class="row">
                                        <span class="fw-light"> Bio </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3" v-if="chat_information.username">
                                <div class="col-md-2 d-flex justify-content-center ">

                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <span class="fs-5"> @{{ this.chat_information.username }} </span>
                                    </div>
                                    <div class="row">
                                        <span class="fw-light"> Username </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="row mt-3">
                                <div class="col-md-2 d-flex justify-content-center mt-1">
                                    <i class="fa-solid fa-users fs-3"></i>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <span class="fs-5"> {{ getFriendStatus }} </span>
                                    </div>
                                    <div class="row">
                                        <span class="fw-light"> Status </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal send file -->
    <div class="modal fade" id="sendFileModal" tabindex="-1" aria-labelledby="sendFileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendFileModalLabel">Send File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <input class="form-control" type="file" id="formFile">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import EmojiPicker from 'vue3-emoji-picker'
import 'vue3-emoji-picker/css'


export default {
    data(){
        return {
            chat_information: {},
            info_header: '',
            emoji_show: false,
            message_text: ''
        };
    },
    props: [ 'chat_id', 'chat_type', 'jwtToken' ],
    mounted() {


        if(this.chat_type == 'user') {
            this.info_header = "User";

            axios.post('/api/user/getInfo', {"user_id": this.chat_id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(data => {

                this.chat_information = data.data.data;

                axios.post('/api/friend/getStatus', {"second_user_id": this.chat_information.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(data => {
                    this.chat_information['friend_status'] = data.data.status;
                    this.chat_information['is_blocking'] = data.data.is_blocking;
                }).catch();

            }).catch();
        }
    },
    computed:{
        getFriendStatus(){
            if(this.chat_type == 'user') {
                let status = '';

                if (this.chat_information['friend_status'] == "friends") {
                    status = "Friend" + ((this.chat_information['is_blocking']) ? ' (Blocked)' : '');
                } else {
                    status = "Unknown" + ((this.chat_information['is_blocking']) ? ' (Blocked)' : '');
                }

                return status;
            }
        }
    },
    methods: {
        unblockCurrentChat(){
            if(this.chat_type == 'user') {
                axios.post('/api/friend/unblock', {"second_user_id": this.chat_information.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(() => {
                    this.chat_information['is_blocking'] = false;
                }).catch();
            }
        },
        blockCurrentChat(){
            if(this.chat_type == 'user') {
                axios.post('/api/friend/block', {"second_user_id": this.chat_information.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(() => {
                    this.chat_information['is_blocking'] = true;
                }).catch();
            }
        },
        sendFriendRequest(){
            axios.post('/api/friend/sendRequest', {"second_user_id": this.chat_information.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(() => {
                this.chat_information['friend_status'] = 'requested second';
            }).catch();
        },
        removeFriendRequest(){
            axios.delete('/api/friend/removeRequest', {
                headers: {
                    Authorization: `Bearer ${this.jwtToken}`
                },
                data: {
                    second_user_id: this.chat_information.id
                }
            }).then(() => {
                this.chat_information['friend_status'] = 'unknown';
            }).catch(error => {
                console.error('Error:', error);
            });
        },
        removeFromFriends(){
            axios.delete('/api/friend/removeFriend', {
                headers: {
                    Authorization: `Bearer ${this.jwtToken}`
                },
                data: {
                    second_user_id: this.chat_information.id
                }
            }).then(() => {
                this.chat_information['friend_status'] = 'unknown';
            }).catch(error => {
                console.error('Error:', error);
            });
        },
        acceptFriendRequest(){
            axios.post('/api/friend/acceptFriendRequest', {"second_user_id": this.chat_information.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(() => {
                this.chat_information['friend_status'] = 'friends';
            }).catch();
        },
        toggleEmojiShow(){
            this.emoji_show = !this.emoji_show;
        },
        onSelectEmoji(emoji) {
            this.message_text += emoji.i;
        }
    },
    components: {
        EmojiPicker
    }
}
</script>

<style scoped>
.select-a-chat-button {
    pointer-events: none;
}
.select-a-chat-button:hover {
    background-color: inherit; /* Keep background color unchanged on hover */
    border-color: inherit; /* Keep border color unchanged on hover */
    color: inherit; /* Keep text color unchanged on hover */
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


.settings-profile-pic {
    width: 70px; /* Adjust the width as needed */
    height: 70px; /* Adjust the height as needed */
    border-radius: 50%;
}

#emojiContainer {
    position: absolute;
    bottom: 50px;
    left: 87%;
    transform: translateX(-50%);
}

</style>
