<template>
    <div>
        <div class="text-white text-center" v-if="show">
            <i class="fas fa-long-arrow-alt-left icon icon__back" @click="goBack" v-tooltip.top="'Go back'"></i>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        // CURRENT ROUTE
        name: function(){
            return this.$route.name;
        },
        // BACK IS SHOWN/HIDDEN
        show: function(){
            // CURRENT ROUTE EXISTS IN navigate OBJECT
            return this.navigate[this.name] !== undefined;
        }
    },
    data(){
        return{
            navigate: {
                // NAVIGATE FROM (ROUTE NAME) - TO (PATH)
                'questions.index': '/menu',
                'questions.create': '/questions',
                'users.password': '/menu',
                'users.index': '/menu',
                'game': '/menu',
                'highscores': '/menu',
            },
        }
    },
    methods: {
        goBack(){
            // PUSH FROM[TO]
            this.$router.push(this.navigate[this.name])
            // HANDLE ERRORS
            // MEANT TO HANDLE guard navigation ERROR
            .catch(error => {});
        }
    },
}
</script>

<style>

</style>
