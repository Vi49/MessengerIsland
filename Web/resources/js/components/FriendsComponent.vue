<template>

    <!-- Chat name -->
    <div class="container-fluid" style="border-bottom: 1px solid #666261; padding-bottom: 5px">
        <div class="row">
            <div class="col-md-11">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <ul class="nav col-lg-auto me-lg-auto mb-2 justify-content-left mb-md-0">
                            <li><span style="border-right: 2px solid #94928b" class="nav-link fs-5 fw-bold text-black"><i class="fa-solid fa-people-arrows"></i> Friends</span></li>
                            <li><a href="#" class="nav-link active fs-5 text-secondary ">All</a></li>
                            <li><a href="#" class="nav-link fs-5 text-secondary">Pending</a></li>
                            <li><a href="#" class="nav-link fs-5 text-secondary">Blocked</a></li>
                        </ul>
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

</style>
