<template>
   <div class="col-sm-12 login-wrapper">
       <div class="auth-form">
            <div class='auth-form-wrapper'>
                <h2 class="text-center">Login</h2>
                <b-form @submit="onSubmit" v-if="show">
                    <div class="form-group col-md-12">
                        <b-form-input v-model="form.username" type='text' placeholder="Username"  required></b-form-input>
                        <label for="id">Username</label>
                    </div>
                    <div class="form-group col-md-12">
                        <b-form-input v-model="form.password" :type='form.passwordFieldType' placeholder="Password"  required></b-form-input>
                        <label for="id">Password</label>
                        <button type='button' class='show-hide--btn' v-bind:class="{active:isActive}" @click="switchVisibility">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="12" cy="12" r="2" />
                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="3" y1="3" x2="21" y2="21" />
                                <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" />
                                <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
                            </svg>
                        </button>
                    </div>
                    <div class="form-group submit-btn">
                        <b-button type='submit' class='btn btn-success'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login" viewBox="0 0 24 24" stroke-width="1" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path transform="scale(-1,1) translate(-24,0)" stroke="none" d="M0 0h24v24H0z"/>
                                <path transform="scale(-1,1) translate(-24,0)" d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path transform="scale(-1,1) translate(-24,0)" d="M20 12h-13l3 -3m0 6l-3 -3" />
                            </svg>
                        </b-button>
                    </div>
                </b-form>
                <div class="text-center form-group btn-wrapper">
                    Don't have an account? <span><a href="/register">Sign up</a></span>
                </div>
            </div>
        </div>
   </div>

</template>
<script>
export default {
    props: {
        title: String,
        id: String,
        type: String
    },
    data: function() {
        return {
            isActive: true,
            form: {
                username: '',
                password: '',
                passwordFieldType: "password",
            },
            show: true
        }
    },
    methods: {
        switchVisibility() {
            this.isActive = !this.isActive;
            this.form.passwordFieldType = this.form.passwordFieldType === "password" ? "text" : "password";
        },
        onSubmit() {
            axios
            .post("/login", {
                username: this.form.username,
                password: this.form.password
            })
            .then((res) => {
                this.form.push(res.data);
            });
        }
    }
}
</script>