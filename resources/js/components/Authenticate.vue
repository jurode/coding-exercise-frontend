<template>

    <main class="pt-3 container">
        <h2>Please log in</h2>
        <div v-if="showFeedback" :class="feedbackClass" class="rounded text-white p-2 mb-2">{{feedbackText}}</div>
        <div>
            <input type="password"
                   class="form-control"
                   name="password"
                   v-model="password"
                   id="password">
            <button class="btn bgr-main mt-2 text-white"
                    v-on:click="onSubmitPassword()">Log in
            </button>
            <div>
                <small><sup>*</sup> Password = 'admin'</small>
            </div>
        </div>
    </main>

</template>

<script>
export default {
    name: 'Authenticate',
    data() {
        return {
            password: '',
            showFeedback: false,
            feedbackClass: '',
            feedbackText: ''
        }
    },
    methods: {
        onSubmitPassword() {
            if (this.password === 'admin') {
                this.showFeedback = false;
                window.location.href = '/jobs?auth=true';
            } else if(this.password !== 'admin') {
                this.showFeedback = true;
                this.feedbackClass = 'bg-danger';
                this.feedbackText = 'Wrong password. Please try again!'
            }
        }
    }
}
</script>

<style scoped>
/* FIXME: von allgemeinem Stylesheet ?? */
.bgr-main {
    background-color: #2EA0B1;
}
</style>
