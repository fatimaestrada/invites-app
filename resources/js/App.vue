<template>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Invites App Solution</h2>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                labore et dolore magna aliqua. Tincidunt nunc pulvinar sapien et ligula. Ac turpis egestas sed tempus.</p>
        </div>

        <Affiliates />

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2023 Maria Fatima Estrada</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>
</template>


<script>
import affiliates from '@/components/Affiliates.vue'

export default {
    components: {
        Affiliates: affiliates,
    }
}
</script>
