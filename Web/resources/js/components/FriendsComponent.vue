<template>

    <!-- Friends bar -->
    <div class="container-fluid" style="border-bottom: 1px solid #666261; padding-bottom: 5px">
        <div class="row">
            <div class="col-md-11">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <ul class="nav col-lg-auto me-lg-auto mb-2 justify-content-left mb-md-0">
                            <li><span style="border-right: 2px solid #94928b" class="nav-link fs-5 fw-bold text-black"><i class="fa-solid fa-people-arrows"></i> Friends</span></li>
                            <li><a href="/friends/all" :class="'nav-link active fs-5 '+((this.$route.path === '/friends' || this.$route.path === '/friends/all') ? 'text-primary' : 'text-secondary')">All</a></li>
                            <li><a href="/friends/pending" :class="'nav-link active fs-5 '+((this.$route.path === '/friends/pending') ? 'text-primary' : 'text-secondary')">Pending</a></li>
                            <li><a href="/friends/blocked" :class="'nav-link active fs-5 '+((this.$route.path === '/friends/blocked') ? 'text-primary' : 'text-secondary')">Blocked</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Friends list -->
    <div class="container-fluid mt-3" style="display: flex; flex-direction: column; height: 90vh;">
        <div class="align-top" style="overflow-y: scroll; overflow-x: hidden; padding-left: 10px; margin-left: 0; width: 100%; height: 105vh">

            <div class="border-bottom d-flex flex-row" style="padding-bottom: 10px" v-for="friend in friend_list" :key="friend.last_seen">
                <div class="p-2 mt-3">
                    <img :src="'/avatars/'+ ((this.friend && this.friend.avatar)  ? this.friend.avatar : 'default.jpg')" class="settings-profile-pic">
                </div>
                <div class="p-2 align-self-center">
                    <div class="col-12"><span class="fs-4 text-black">{{ friend.first_name }} {{ friend.last_name }}</span></div>
                    <div class="col-12"><span class="text-black">{{ (friend.username) ? '@'+ friend.username : '' }}</span></div>
                </div>
                <div class="p-2 align-self-end align-self-center ms-auto m-4">
                    <!-- Friend Actions -->
                    <div class="d-flex justify-content-center" v-if="!friendlist_type || friendlist_type === 'all'">
                        <div class="p-1"><button @click="redirectToChat(friend.user_id)" type="button" title="Chat with user" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-paper-plane"></i></button></div>
                        <div class="p-1"><button @click="removeFromFriends(friend.id, friend)" type="button" title="Remove user from friends" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-user-slash"></i></button></div>
                        <div class="p-1" v-if="friend.is_blocked == false">
                            <button @click="blockFriend(friend)" type="button" title="Block user" class="btn btn-outline-danger rounded-pill"><i class="fa-solid fa-ban"></i></button>
                        </div>
                        <div class="p-1" v-if="friend.is_blocked == true">
                            <button @click="unblockFriend(friend)" type="button" title="Unblock user" class="btn btn-outline-success rounded-pill"><i class="fa-solid fa-unlock"></i></button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center" v-else-if="friendlist_type === 'pending'">
                        <div class="p-1"><button @click="acceptFriendRequest(friend)" type="button" title="Accept friend request" class="btn btn-outline-success rounded-pill"><i class="fa-solid fa-check"></i></button></div>
                        <div class="p-1"><button @click="rejectFriendRequest(friend)" type="button" title="Reject friend request" class="btn btn-outline-danger rounded-pill"><i class="fa-solid fa-xmark"></i></button></div>
                    </div>
                    <div class="d-flex justify-content-center" v-else-if="friendlist_type === 'blocked'">
                        <div class="p-1"><button @click="unblockFriend(friend)" type="button" title="Unblock" class="btn btn-outline-success rounded-pill">Unblock</button></div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            friend_list: [],
        };
    },
    props: ['jwtToken', 'friendlist_type', 'sidebar_friendlist'],
    mounted() {
        this.getFriendList();
    },
    methods: {
        getFriendList(){
            let friendListRequest = 'getFriendList';

            if(this.$route.path === '/friends/pending')
            {
                friendListRequest = 'getPendingFriendList';
            }
            else if(this.$route.path === '/friends/blocked')
            {
                friendListRequest = 'getBlockedFriendList';
            }

            axios.get('/api/friend/'+friendListRequest, {headers: {'Authorization': `Bearer ${localStorage.getItem('jwtToken')}`}})
                .then(response => {
                    this.friend_list = response.data.data;
                }).catch();

        },
        redirectToChat(user_id){
            location.href = '/chat/user/'+user_id;
        },
        removeFromFriends(second_user_id, friend){
            axios.delete('/api/friend/removeFriend', {
                headers: {
                    Authorization: `Bearer ${this.jwtToken}`
                },
                data: {
                    second_user_id: second_user_id
                }
            }).then(() => {
                this.friend_list = this.friend_list.filter(f => f.id !== friend.id);

                this.$parent.friend_list = this.$parent.friend_list.filter(f => f.id !== friend.id);
            }).catch(error => {
                console.error('Error:', error);
            });
        },
        blockFriend(friend){
            axios.post('/api/friend/block', {"second_user_id": friend.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(() => {
                friend.is_blocked = true;
            }).catch();
        },
        unblockFriend(friend){
            axios.post('/api/friend/unblock', {"second_user_id": friend.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(() => {
                friend.is_blocked = false;
                this.friend_list = this.friend_list.filter(f => f.id !== friend.id);
            }).catch();
        },
        acceptFriendRequest(friend){
            axios.post('/api/friend/acceptFriendRequest', {"second_user_id": friend.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(() => {
                this.friend_list = this.friend_list.filter(f => f.id !== friend.id);
            }).catch();
        },
        rejectFriendRequest(friend){
            axios.post('/api/friend/rejectFriendRequest', {"second_user_id": friend.id}, {headers: {Authorization: `Bearer ${this.jwtToken}`}}).then(() => {
                this.friend_list = this.friend_list.filter(f => f.id !== friend.id);
            }).catch();
        }
    }

}

</script>

<style scoped>


.settings-profile-pic {
    width: 60px; /* Adjust the width as needed */
    height: 60px; /* Adjust the height as needed */
    border-radius: 50%;
}
</style>
