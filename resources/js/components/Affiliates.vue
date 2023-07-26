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
                        <small class="text-muted">Click on the</small>
                        <span class="fa fa-plus ps-2 pe-2"></span>
                        <small class="text-muted">button to see affiliate details</small>
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="affiliate of affiliates" :key="affiliate.id">
                        <th scope="row">{{ affiliate.id }}</th>
                        <td>{{ affiliate.name }}</td>
                        <td><button class="btn btn-light" @click="updateDetails(affiliate.id)"><span
                                    class="fa fa-2x fa-plus"></span></button></td>
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

        };
    },
    async created() {
        try {
            const res = await axios.get('/api/affiliates')
            this.affiliates = res.data
        } catch (error) {
            console.log(error);
        }
    },
    methods: {
        updateDetails(id) {
            console.log('up;', id)
            if (id) {
                axios
                    .get(`/api/affiliates/${id}`)
                    .then(response => {
                        console.log(response.data)
                        this.affiliateDetails = response.data
                    })
            }


        }
    }
}
</script>