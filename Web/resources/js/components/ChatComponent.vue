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
            <div class="align-top" id="scrollableChat" ref="scrollableChat">


                <div v-for="chat_message in chat_messages">
                    <div class="row message-body">
                        <div :class="'col-sm-12 message-main-' + ((chat_message.second_user_id == chat_information.id) ? 'sender' : 'receiver')">
                            <div :class="(chat_message.second_user_id == chat_information.id) ? 'sender' : 'receiver'">
                                <div class="message-text" :style="(chat_message.type == 'file') ? 'cursor: pointer' : ''" @click="actionWithMessage(chat_message)">
                                    <i class='fa-solid fa-file' v-show="chat_message.type == 'file'"></i>
                                    {{ (chat_message.type == 'file') ? decodeB64Text(chat_message.content.split('|')[0]) : chat_message.content }}
                                </div>
                                <div class="text-end">
                                    <span class="message-time ">
                                        {{ chat_message.created_at_human }}
                                    </span>
                                </div>
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
                                <input maxlength="400" type="text" class="form-control rounded-pill w-100" v-model="message_text">
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
                                        <button @click="sendTextMessage" type="button" class="btn btn-primary rounded-pill ">Send</button>
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
    <div class="modal fade" id="sendFileModal" tabindex="-1" aria-labelledby="sendFileModalLabel" aria-hidden="true" v-show="modal_file_show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendFileModalLabel">Send File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <input class="form-control" type="file" id="formFile" @change="handleFileChange">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button @click="sendFileMessage" type="button" class="btn btn-primary"><i v-show="modal_file_show_send_load" class="fa-solid fa-spinner"></i>Send</button>
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
            message_text: '',
            message_file: null,
            modal_file_show_send_load: false,
            modal_file_show: false,
            chat_messages: [],
        };
    },
    props: [ 'chat_id', 'chat_type', 'jwtToken', 'friend_list', 'userMeData'],

    mounted() {

        //Load chat data
        if(this.chat_type == 'user') {
            this.info_header = "User";

            axios.post('/api/user/getInfo', {"user_id": this.chat_id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(data => {

                this.chat_information = data.data.data;

                axios.post('/api/friend/getStatus', {"second_user_id": this.chat_information.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(data => {
                    this.chat_information['friend_status'] = data.data.status;
                    this.chat_information['is_blocking'] = data.data.is_blocking;

                    this.getChatMessages();

                    window.Echo.private(`store_message_${this.userMeData.id}`).listen('.store_message', res => {
                        let message_item = {'content': res.message.content, 'created_at': new Date(), 'created_at_human': "now", 'encryption': res.message.encryption, 'second_user_id': res.message.second_user_id, 'first_user_id': res.message.first_user_id, 'type': res.message.type};
                        this.chat_messages.push(message_item);


                    });
                }).catch();

            }).catch();
        }

        //Scroll chat to the bottom
        this.scrollToBottom();


    },
    updated() {
        // Scroll chat to the bottom when the component is updated
        this.scrollToBottom();
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

        downloadFile(server_filename, origin_filename) {
            axios.get('/api/message/get/file', {
                responseType: 'blob',
                params: {
                    server_filename: server_filename,
                    origin_filename: origin_filename
                },
                headers: {Authorization: `Bearer ${this.jwtToken}`}
            })
                .then(response => {
                    // Create a Blob object from the response data
                    const blob = new Blob([response.data], { type: response.headers['content-type'] });

                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);

                    link.download = atob(origin_filename); // Specify the desired file name here

                    // Append the link to the body and click it to trigger the download
                    document.body.appendChild(link);
                    link.click();

                    // Remove the link from the body
                    document.body.removeChild(link);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },

        actionWithMessage(chat_message){
            if(chat_message.type == 'file')
            {
                this.downloadFile(chat_message.content.split('|')[1], chat_message.content.split('|')[0]);
            }
        },

        decodeB64Text(b64String){
            return atob(b64String);
        },

        scrollToBottom() {
            // Wait for next tick to ensure the DOM has been updated
            this.$nextTick(() => {
                // Scroll to the bottom of the chat
                let scrollableChatDiv = this.$refs.scrollableChat;
                scrollableChatDiv.scrollTop = scrollableChatDiv.scrollHeight;
            });
        },


        getChatMessages(){
            axios.get(`/api/message/get/all?second_user_id=${this.chat_information.id}`, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(res=>{
                this.chat_messages = res.data;
            }).catch();
        },

        handleFileChange(event) {
            this.file = event.target.files[0];
        },
        async sendFileMessage(){
            if (!this.file) {
                alert('You must select the file!');
                return;
            }

            this.modal_file_show_send_load = true;


            const formData = new FormData();
            formData.append('file', this.file);
            formData.append('second_user_id', this.chat_information.id);

            await axios.post('/api/message/send/sendFileMessage', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${this.jwtToken}`
                }
            }).then(res => {
                this.modal_file_show_send_load = false;

                //Close bootstrap modal
                $('#sendFileModal').modal('hide');
                this.modal_file_show = false;

                let message_item = {'content': res.data.content, 'created_at': new Date(), 'created_at_human': "now", 'encryption': "none", 'second_user_id': this.chat_information.id, 'type': 'file'};
                this.chat_messages.push(message_item);
            }).catch(error => {
                console.log('Error uploading file' + error);
            });
        },
        sendTextMessage(){
            let encryption = 'default'; //todo: add encryption and change this var name

            axios.post('/api/message/send/sendTextMessage', {"second_user_id": this.chat_information.id, 'content': this.message_text, 'encryption': encryption}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(()=>{
                let message_item = {'content': this.message_text, 'created_at': new Date(), 'created_at_human': "now", 'encryption': "none", 'second_user_id': this.chat_information.id, 'type': 'text'};
                this.chat_messages.push(message_item);

                this.message_text = '';
            }).catch();

        },

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

#scrollableChat {
    overflow-y: scroll;
    overflow-x: hidden;
    padding-left: 20px;
    width: 100%;
    height: 105vh;
}

</style>
