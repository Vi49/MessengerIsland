<template>
    <div class="container" id="app">
        <div class="registration-container">
            <h2 class="text-center">Last Registration Step</h2>

            <form @submit.prevent="submitForm">
                <div class="text-center">
                    <img v-bind:src="this.avatar" alt="Profile Picture" class="profile-pic">
                </div>
                <div class="text-center mb-4">
                    <div class="alert alert-danger" role="alert" :style="this.photoError == '' ? 'display: none' : ''">
                        {{ this.photoError }}
                    </div>

                    <label for="fileInput" class="btn btn-success">
                        Add profile photo <i class="fas fa-camera"></i>
                    </label>
                    <!-- File input (hidden) -->
                    <input type="file" id="fileInput" style="display: none;" @change="handleFileChange">
                </div>

                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" placeholder="Enter your first name" v-model="firstName" required>
                    <div v-if="firstName === '' && submitted" class="invalid-feedback">First Name is required.</div>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" placeholder="Enter your last name" v-model="lastName">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Continue <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    beforeCreate() {
        let jwtToken = localStorage.getItem('jwtToken');

        if(jwtToken) {
            axios.post('/api/auth/me', {}, {headers: {Authorization: `Bearer ${jwtToken}`}}).then(data => {
                if (data.data.is_afterreged != 0) {

                    location.href = '/';
                }
            }).catch(errorData => {
                location.href = "/login";
            });
        }
        else{
            location.href = '/login';
        }
    },

    data(){
        return {
            firstName: '',
            lastName: '',
            submitted: false,
            file: null,
            avatar: 'avatars/default.jpg',
            photoError: ''
        };
    },
    methods: {
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

                const reader = new FileReader();
                reader.onload = () => {
                    this.avatar = reader.result;
                };
                reader.readAsDataURL(this.file);
            }


        },

        submitForm() {

            const formData = new FormData();

            this.file && formData.append('avatar', this.file);
            formData.append('first_name', this.firstName);
            this.lastName && formData.append('last_name', this.lastName);

            // Send POST request using Axios
            axios.post('/api/auth/afterreg', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${localStorage.getItem('jwtToken')}`
                }
            })
                .then(response => {
                    location.href = '/';
                })
                .catch(error => {
                    console.error('Error uploading file:', error);
                });
        }
    }
}
</script>

<style scoped>
/* Custom CSS for styling */
.registration-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.profile-pic {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin-bottom: 20px;
}
</style>
