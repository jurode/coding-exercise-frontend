<template>
    <main class="pt-3 d-flex flex-column flex-sm-row container">

        <aside class="col-12 col-sm-3 col-md-2">
            <div class="col-6 col-md-12 ">
                <div class="fw-bold">Location</div>
                <div class="py-3">
                    <span v-for="(location, i) in locations"
                          class="d-block">
                    <input type="checkbox"
                           v-model="selectedLocations"
                           v-on:change="onChangeFilter('location', location, $event)"
                           :id="'location'+i"
                           :value="location"
                           name="location"
                           class="me-1">
                        <label :for="'location'+i">{{ location }}</label>
                    </span>
                </div>
            </div>
            <div class="col-md-12 col-6">
                <div class="fw-bold">Company</div>
                <div class="py-3">
                    <span v-for="(company, i) in companies"
                          class="d-block">
                    <input type="checkbox"
                           v-on:change="onChangeFilter('company', company.id, $event)"
                           :id="'company'+i"
                           class="me-1">
                        <label :for="'company'+i">{{ company.name }}</label>
                    </span>
                </div>
            </div>
        </aside>

        <div class="col-12 col-sm-9 col-md-10">

            <div class="d-flex">
                <input type="text"
                       v-model="searchterm"
                       id="input-search"
                       class="form-control"
                       placeholder="Search for title">
            </div>

            <ul class="ps-0">
                <template v-for="job in jobs">
                    <template v-if="job.published_at >= publishTimeframe">
                        <template v-if="selectedCompanies.length === 0 || (selectedCompanies.length > 0 && selectedCompanies.find(el => el === job.company_id))">
                            <template v-if="(selectedLocations.length === 0 || (selectedLocations.length > 0 && selectedLocations.find(el => el === job.location)))">
                                <li v-if="job.title.toLowerCase().includes(searchterm.toLowerCase()) || searchterm.length === 0 "
                                    :class="{'inactive': job.active === 0 }"
                                    class="bgr-light my-2 p-2 list-unstyled">
                                    <div class="fw-bold fs-5">{{ job.title }}</div>
                                    <div class="d-flex">
                                        <template v-for="company in companies">
                                            <span class="bgr-main text-white p-1 rounded me-2 font-14 company"
                                                  v-if="job.company_id === company.id">
                                                {{ company.name }}
                                            </span>
                                        </template>
                                        <span class="bgr-main text-white p-1 rounded me-2 font-14">
                                            {{ job.location }}
                                        </span>
                                        <span class="bgr-main text-white p-1 rounded me-2 font-14">
                                            {{ job.published_at }}
                                        </span>
                                    </div>
                                    <div>{{ job.description }}</div>
                                </li>
                            </template>
                        </template>
                    </template>
                </template>
            </ul>
        </div>

    </main>
</template>

<script>
export default {
    name: 'Home',
    data() {
        return {
            jobs: [],
            companies: [],
            locations: [],
            searchterm: '',
            selectedLocations: [],
            selectedCompanies: [],
            publishTimeframe: '',
        }
    },
    mounted() {
        window.axios({
            method: 'get',
            url: '/showjobs',
        }).then(result => {
            this.jobs = result.data.jobs;

            this.jobs.forEach(job => {
                if (!this.locations.find(el => el === job.location)) {
                    this.locations.push(job.location);
                }
            })
        });

        window.axios({
            method: 'get',
            url: '/companies',
        }).then(result => {
            this.companies = result.data.companies;
        });

        this.publishTimeframe = new Date;
        this.publishTimeframe.setTime(this.publishTimeframe.getTime() - (1000 * 60 * 60 * 24 * 7));
        this.publishTimeframe = this.publishTimeframe.toISOString();

    },
    methods: {
        onChangeFilter(type, value, event) {
            if (event.target.checked) {
                if (type === 'location' && !this.selectedLocations.find(el => el === value)) {
                    this.selectedLocations.push(value);
                }
                if (type === 'company' && !this.selectedCompanies.find(el => el === value)) {
                    this.selectedCompanies.push(value);
                }
            } else {
                if (type === 'location') {
                    this.selectedLocations.filter(el => el !== value);
                }
                if (type === 'company') {
                    // this.selectedCompanies.filter(el => el !== value); // ! not working
                    this.selectedCompanies.forEach((el, index) => {
                        if (value === el) {
                            this.selectedCompanies.splice(index, 1);
                        }
                    })
                }
            }
        },
    }
}
</script>

<style scoped>


.bgr-main {
    background-color: #2EA0B1;
}

.bgr-light {
    background-color: #DDEAEA;
}

.bgr-grey {
    background-color: #A2A4A4;
}


.font-14 {
    font-size: 14px;
}

.inactive {
    -webkit-filter: grayscale(1);
    filter: grayscale(1);
}

</style>
