<template>
    <div>
        <div class="list-group list-group-flush border-bottom scrollarea">

            <div v-for="searchResult in searchResults" :key="searchResult.first_name">
                <a :href="'/chat/user/' + searchResult.user_id" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
                    <div class="row">
                        <div class="col-md-3 ">
                            <img :src="'/avatars/'+ ((this.searchResult && this.searchResult.avatar)  ? this.searchResult.avatar : 'default.jpg')" class="profile-pic">
                        </div>

                        <div class="col-md-9" style="padding-left: 0px; margin-left: 0">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <strong class="mb-1">{{ searchResult.first_name }} {{ searchResult.last_name }}</strong>
                            </div>
                            <div class="col-10 mb-1 small">last seen {{ searchResult.last_seen_human_ago }} </div>
                        </div></div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{

        };
    },
    props: [
        'searchResults'
    ],
}
</script>

<style scoped>
.profile-pic {
    width: 55px; /* Adjust the width as needed */
    height: 55px; /* Adjust the height as needed */
    border-radius: 50%;
}
</style>
