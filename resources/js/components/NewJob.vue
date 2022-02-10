<template>
    <main class="pt-3 container">

        <h2>Add a new job</h2>

        <div v-if="showFeedback"
             :class="feedbackClass"
             class="rounded text-white p-2 mb-2" v-html="feedbackText">
        </div>

        <form>

            <label class="fw-bold mt-2"
                   for="title">Title:</label>
            <input type="text"
                   minlength="2"
                   placeholder="Title"
                   required
                   class="form-control"
                   v-model="formTitle"
                   id="title">

            <label class="fw-bold mt-2"
                   for="description">Description:</label>
            <textarea name="description"
                      minlength="2"
                      class="form-control"
                      v-model="formDescription"
                      cols="30"
                      id="description"
                      required
                      rows="5">Description</textarea>

            <label class="fw-bold mt-2"
                   for="location">Location:</label>
            <input type="text"
                   minlength="2"
                   v-model="formLocation"
                   class="form-control"
                   id="location"
                   required
                   placeholder="Location">

            <label class="fw-bold mt-2"
                   for="company">Company:</label>
            <select name="company"
                    required
                    class="form-control"
                    v-model="formCompany"
                    id="company">
                <option value=""
                        selected
                        disabled>Select a company
                </option>
                <option v-for="company in companies"
                        :value="company.id">{{ company.name }}
                </option>
            </select>

            <button @click="onSubmitJob()"
                    type="button"
                    class="btn btn-success mt-3">Submit new job
            </button>
        </form>


    </main>
</template>

<script>
export default {
    name: 'NewJob',
    data() {
        return {
            isAuth: false,
            companies: [],
            formTitle: '',
            formDescription: '',
            formLocation: '',
            formCompany: '',
            showFeedback: false,
            feedbackClass: '',
            feedbackText: ''
        }
    },
    mounted() {
        // = GET AUTHENTICATION
        let url = window.location.href.split('?');
        if (url.length === 1 && !this.isAuth) {
            window.location.href = '/authenticate';
            return;
        }
        // FIXME: einfacher machen
        let auth = url[1].split('=');
        if (auth[0] === 'auth' && auth[1] === 'true') {
            this.isAuth = true;
        }

        // = GET COMPANIES
        window.axios({
            method: 'get',
            url: '/companies',
        }).then(result => {
            this.companies = result.data.companies;
        });

    },
    methods: {
        onSubmitJob() {
            // = VALIDATE DATA
            let isValid = true;

            if(this.formTitle.length > 255 || this.formTitle.length === 0){
                this.showFeedback = true;
                this.feedbackClass = 'bg-danger';
                this.feedbackText += '<div>Please insert between 0 and 255 letters in TITLE</div>'
                isValid = false;
            }
            if(this.formDescription.length > 255 || this.formDescription.length === 0){
                this.showFeedback = true;
                this.feedbackClass = 'bg-danger';
                this.feedbackText += '<div>Please insert between 0 and 255 letters in DESCRIPTION</div>'
                isValid = false;
            }
            if(this.formLocation.length > 255 || this.formLocation.length === 0){
                this.showFeedback = true;
                this.feedbackClass = 'bg-danger';
                this.feedbackText += '<div>Please insert between 0 and 255 letters in LOCATION</div>'
                isValid = false;
            }
            if(this.formCompany === ''){
                this.showFeedback = true;
                this.feedbackClass = 'bg-danger';
                this.feedbackText += '<div>Please choose a company</div>'
                isValid = false;
            }

            if(!isValid){
                return; // ! comment out for 422 inspection
            }

            // = POST REQUEST
            console.log('submit');
            window.axios({
                method: 'post',
                url: '/jobs',
                data: {
                    title: this.formTitle,
                    description: this.formDescription,
                    location: this.formLocation,
                    company_id: this.formCompany
                }
            }).then(result => {
                console.log(result);
                if (result.status === 201) {
                    this.showFeedback = true;
                    this.feedbackClass = 'bg-success';
                    this.feedbackText = 'Job "' + result.data.title + '" was created.'
                    setTimeout(() => window.location.href = '/', 2000);
                }

            }, error => {
                console.log(error);
                if (error.status === 422) {
                    console.log(error); // => hier kein 'error' in der error msg?
                    this.showFeedback = true;
                    this.feedbackClass = 'bg-danger';
                    this.feedbackText = 'There has been an error - please check your data.'
                    return;
                }
                this.showFeedback = true;
                this.feedbackClass = 'bg-danger';
                this.feedbackText = 'There has been an error - please try again later.'
            });
        }
    }
}
</script>

<style scoped>

</style>
