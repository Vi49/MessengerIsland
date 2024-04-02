<template>

    <!-- Friends bar -->
    <div class="container-fluid" style="border-bottom: 1px solid #666261; padding-bottom: 5px">
        <div class="row">
            <div class="col-md-11">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <ul class="nav col-lg-auto me-lg-auto mb-2 justify-content-left mb-md-0">
                            <li><span style="border-right: 2px solid #94928b" class="nav-link fs-5 fw-bold text-black"><i class="fa-solid fa-people-arrows"></i> Friends</span></li>
                            <li><a href="/friends/all" class="nav-link active fs-5 text-secondary ">All</a></li>
                            <li><a href="/friends/pending" class="nav-link fs-5 text-secondary">Pending</a></li>
                            <li><a href="/friends/blocked" class="nav-link fs-5 text-secondary">Blocked</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Friends list -->
    <div class="container-fluid mt-3" style="display: flex; flex-direction: column; height: 90vh;">
        <div class="align-top" style="overflow-y: scroll; overflow-x: hidden; padding-left: 10px; margin-left: 0; width: 100%; height: 105vh">
            <div class="border-bottom d-flex flex-row" style="padding-bottom: 10px">
                <div class="p-2 mt-3">
                    <img src="/avatars/default.jpg" class="settings-profile-pic">
                </div>
                <div class="p-2 align-self-center">
                    <div class="col-12"><span class="fs-4 text-black">John Doe</span></div>
                    <div class="col-12"><span class=" text-black">@cock1337</span></div>
                </div>
                <div class="p-2 align-self-end align-self-center ms-auto m-4">
                    <div class="d-flex justify-content-center">
                        <div class="p-1"><button type="button" title="Chat with user" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-paper-plane"></i></button></div>
                        <div class="p-1"><button type="button" title="Remove user from friends" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-user-slash"></i></button></div>
                        <div class="p-1"><button type="button" title="Block user" class="btn btn-outline-danger rounded-pill"><i class="fa-solid fa-ban"></i></button></div>

                    </div>
                </div>
            </div>
            <div class="border-bottom d-flex flex-row" style="padding-bottom: 10px">
                <div class="p-2 mt-3">
                    <img src="/avatars/default.jpg" class="settings-profile-pic">
                </div>
                <div class="p-2 align-self-center">
                    <div class="col-12"><span class="fs-4 text-black">John Doe</span></div>
                    <div class="col-12"><span class=" text-black">@cock1337</span></div>
                </div>
                <div class="p-2 align-self-end align-self-center ms-auto m-4">
                    <div class="d-flex justify-content-center">
                        <div class="p-1"><button type="button" title="Chat with user" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-paper-plane"></i></button></div>
                        <div class="p-1"><button type="button" title="Remove user from friends" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-user-slash"></i></button></div>
                        <div class="p-1"><button type="button" title="Block user" class="btn btn-outline-danger rounded-pill"><i class="fa-solid fa-ban"></i></button></div>

                    </div>
                </div>
            </div>
            <div class="border-bottom d-flex flex-row" style="padding-bottom: 10px">
                <div class="p-2 mt-3">
                    <img src="/avatars/default.jpg" class="settings-profile-pic">
                </div>
                <div class="p-2 align-self-center">
                    <div class="col-12"><span class="fs-4 text-black">John Doe</span></div>
                    <div class="col-12"><span class=" text-black">@cock1337</span></div>
                </div>
                <div class="p-2 align-self-end align-self-center ms-auto m-4">
                    <div class="d-flex justify-content-center">
                        <div class="p-1"><button type="button" title="Chat with user" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-paper-plane"></i></button></div>
                        <div class="p-1"><button type="button" title="Remove user from friends" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-user-slash"></i></button></div>
                        <div class="p-1"><button type="button" title="Block user" class="btn btn-outline-danger rounded-pill"><i class="fa-solid fa-ban"></i></button></div>

                    </div>
                </div>
            </div>
            <div class="border-bottom d-flex flex-row" style="padding-bottom: 10px">
                <div class="p-2 mt-3">
                    <img src="/avatars/default.jpg" class="settings-profile-pic">
                </div>
                <div class="p-2 align-self-center">
                    <div class="col-12"><span class="fs-4 text-black">John Doe</span></div>
                    <div class="col-12"><span class=" text-black">@cock1337</span></div>
                </div>
                <div class="p-2 align-self-end align-self-center ms-auto m-4">
                    <div class="d-flex justify-content-center">
                        <div class="p-1"><button type="button" title="Chat with user" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-paper-plane"></i></button></div>
                        <div class="p-1"><button type="button" title="Remove user from friends" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-user-slash"></i></button></div>
                        <div class="p-1"><button type="button" title="Block user" class="btn btn-outline-danger rounded-pill"><i class="fa-solid fa-ban"></i></button></div>

                    </div>
                </div>
            </div>
            <div class="border-bottom d-flex flex-row" style="padding-bottom: 10px">
                <div class="p-2 mt-3">
                    <img src="/avatars/default.jpg" class="settings-profile-pic">
                </div>
                <div class="p-2 align-self-center">
                    <div class="col-12"><span class="fs-4 text-black">John Doe</span></div>
                    <div class="col-12"><span class=" text-black">@cock1337</span></div>
                </div>
                <div class="p-2 align-self-end align-self-center ms-auto m-4">
                    <div class="d-flex justify-content-center">
                        <div class="p-1"><button type="button" title="Chat with user" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-paper-plane"></i></button></div>
                        <div class="p-1"><button type="button" title="Remove user from friends" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-user-slash"></i></button></div>
                        <div class="p-1"><button type="button" title="Block user" class="btn btn-outline-danger rounded-pill"><i class="fa-solid fa-ban"></i></button></div>

                    </div>
                </div>
            </div>
            <div class="border-bottom d-flex flex-row" style="padding-bottom: 10px">
                <div class="p-2 mt-3">
                    <img src="/avatars/default.jpg" class="settings-profile-pic">
                </div>
                <div class="p-2 align-self-center">
                    <div class="col-12"><span class="fs-4 text-black">John Doe</span></div>
                    <div class="col-12"><span class=" text-black">@cock1337</span></div>
                </div>
                <div class="p-2 align-self-end align-self-center ms-auto m-4">
                    <div class="d-flex justify-content-center">
                        <div class="p-1"><button type="button" title="Chat with user" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-paper-plane"></i></button></div>
                        <div class="p-1"><button type="button" title="Remove user from friends" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-user-slash"></i></button></div>
                        <div class="p-1"><button type="button" title="Block user" class="btn btn-outline-danger rounded-pill"><i class="fa-solid fa-ban"></i></button></div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    props: ['friendlist_type'],

}

</script>

<style scoped>


.settings-profile-pic {
    width: 60px; /* Adjust the width as needed */
    height: 60px; /* Adjust the height as needed */
    border-radius: 50%;
}
</style>
