<template>
    <div class="row">

        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Affiliate Details</span>
            </h4>

            <ul v-if="!affiliateDetails" class="list-group mb-3">
                <div>
                    <h6 class="my-0 text-center pb-3">Nothing selected</h6>
                    <div style="display: inline">
                        <small class="text-muted">Click on affiliate for details</small>
                    </div>
                </div>
            </ul>
            <ul v-else class="list-group mb-3" v-bind="affiliateDetails">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Name</h6>
                        <small class="text-muted">{{ affiliateDetails.name }}</small>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Affiliate ID</h6>
                        <small class="text-muted">{{ affiliateDetails.id }}</small>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Location</h6>
                        <small class="text-muted" data-toggle="tooltip" data-placement="bottom"
                            title="Could be replace with map marker">{{ affiliateDetails.location.latitude }}, {{
                                affiliateDetails.location.longitude }}</small>
                    </div>
                </li>
                <small class="text-muted text-small text-center">^Could be replace with map marker</small>
            </ul>

        </div>


        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Affiliates lists</h4>
            <div class="row p-4">
                <div class="form-group row">
                    <label for="city" class="col-sm-2 col-form-label">From</label>
                    <div class="col-sm-10">
                        <select id="city" class="form-control" v-model="city" @change="filterResults()">
                            <option selected disabled hidden value=''>Choose city...</option>
                            <option value="CORK">Cork</option>
                            <option value="DUBLIN">Dublin</option>
                            <option value="GALWAY">Galway</option>
                            <option value="LIMERICk">Limerick</option>
                            <option value="error">Error</option>
                        </select>

                    </div>
                </div>
                <div class="form-group row pt-4">
                    <label for="distance" class="col-sm-2 col-form-label">Distance</label>
                    <div class="col-sm-10">
                        <input style="width: 100%;" type="range" class="form-control-range" min="0" max="200" step="5"
                            id="distance" v-model="distance" @change="filterResults()">
                        <span>{{ distance }} Km</span>
                    </div>
                </div>


            </div>

            <table v-if="!affiliates.length" class="table table-hover">
                <thead>
                    <tr class="text-center">
                        Ops! no results for yor serach. Try again
                    </tr>
                </thead>
            </table>
            <table v-else class="table table-hover">
                <caption>Showing {{ affiliates.length }} from {{ total }}</caption>
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Distance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="cursor: pointer;" v-for="affiliate of affiliates" :key="affiliate.id"
                        @click="updateDetails(affiliate.id)">
                        <th scope="row">{{ affiliate.id }}</th>
                        <td style="width: 70%;">{{ affiliate.name }}</td>
                        <td v-if="affiliate.distance">{{ affiliate.distance }} Km</td>
                        <td v-else> - </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


<script>
import axios from 'axios'

export default {
    data() {
        return {
            affiliates: [],
            affiliateDetails: null,
            city: '',
            distance: 100,
            total: ''

        };
    },
    async created() {
        try {
            const res = await axios.get('/v1/affiliates')
            this.affiliates = res.data
            this.total = res.data.length
        } catch (error) {
            console.log(error);
        }
    },
    methods: {
        updateDetails(id) {
            if (id) {
                axios
                    .get(`/v1/affiliates/${id}`)
                    .then(response => {
                        this.affiliateDetails = response.data
                    })
            }
        },
        filterResults() {
            if (city.value && distance.value) {
                let params = {
                    from: city.value, km: distance.value
                }
                axios
                    .get('/v1/affiliates/getByDistance', { params })
                    .then(response => {
                        this.affiliates = response.data
                    }).catch((error) => {
                        this.$swal({
                            title: 'Error',
                            icon: 'error',
                            html: error.response.data.messages.map(error => error + '<br>'),
                            showConfirmButton: false,
                            timer: 2500
                        })
                        this.city = ''
                    })
            }
        }
    }
}
</script>