<template>
    <div class="col-md-10" style="padding-left: 0; padding-right: 0">
        <div class="container-fluid last-time-bottom-line" style="padding-bottom: 5px">
            <div class="row">
                <div class="col-md-11">
                    <div class="row mt-3">
                        <span class="fs-5 fw-semibold">Roman Rotschild</span>
                    </div>
                    <div class="row">
                        <span class="text-last-time">last seen 2 hours ago</span>
                    </div>
                </div>

                <div class="col-md-1 text-md-end mt-4" style="padding-right: 20px">
                    <i class="fa-solid fa-ellipsis-vertical fs-2"></i>
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
                    <div class="form-group mt-3 mb-0">
                        <div class="row">
                            <div class="col-md-1">
                                <button type="button" class="btn btn-success rounded-pill w-100"><i class="fa-solid fa-paperclip"></i></button>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control rounded-pill w-100">
                            </div>
                            <div class="col-md-1">
                                <div class="row">
                                    <div class="col-4">
                                        <button type="button" id="emojiButton" class="btn btn-secondary rounded-pill"><i class="fa-regular fa-face-smile"></i></button>
                                    </div>
                                    <div class="col-7">
                                        <button type="button" class="btn btn-primary rounded-pill ">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {

}
</script>

<style scoped>

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

</style>
