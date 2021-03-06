<template>
<div class="h-100">
    <!-- HIDE USERS CONTATINER IF THERE ARE NO USERS -->
    <div class="h-100 d-flex flex-column" v-if="users.length !== 0">
        <div class="text-white lead flex-grow-1 container-index--outer container-index__scroll">
            <UsersNavigation></UsersNavigation>
            <div class="flex-grow-1">
                <div class="pr-3 container-index__users">
                    <div v-for="(user, index) in users" :key="index" class="animated slideInDown my-3 wrapper--md-and-down user-grid-show">
                        <p class="lead p-2 my-auto text-center-md user-grid__username wrapper--md-and-up">{{ user.username }}</p>
                        <UsersChangeRole :user="user"></UsersChangeRole>
                        <UsersDelete :user="user"></UsersDelete>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button class="btn text-center w-auto btn-main" @click="loadMore()" :disabled="!isNotOnLastPage">{{ loadButtonText }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Loading v-else></Loading>
</div>

</template>

<script>
// COMPONENTS
import UsersDelete from './UsersDelete';
import UsersChangeRole from './UsersChangeRole';
import UsersNavigation from './UsersNavigation';
import Loading from '../Loading';

// EVENT BUS
import {EventBus} from '../../app';

export default {
    components: {
        UsersDelete, UsersChangeRole, UsersNavigation, Loading
    },

    computed: {
        isNotOnLastPage: function(){
            return this.pagination.page <= this.pagination.last_page;
        },
        loadButtonText: function(){
            return this.pagination.page <= this.pagination.last_page ? 'Load more users' : 'No more users';
        },
    },

    data(){
        return{
            // ALL USERS
            users: [],
            // DATA USED FOR FETCHING USERS
            pagination: {
                // CURRENT PAGE FOR PAGINATION
                page: 1,
                // NUMBER OF QUESTIONS BEING FETCHED PER REQUEST
                per_page: 15,
                // LAST PAGE FOR PAGIANTION
                last_page: null,
            },
        }
    },

    methods: {
        getUsers(append){
            this.$http.get('users',{
                params: {
                    'page': this.pagination.page,
                    'per_page': this.pagination.per_page,
                }
            })
            .then(response =>{
                // SHOULD APPEND TO USERS
                if(append){
                    // APPEND NEW USERS TO USERS ARRAY
                    this.users = this.users.concat(response.body.users);
                }
                // SHOULD RESET USERS ARRAY
                else{
                    // RESET USERS ARRAY
                    this.users = response.body.users;
                }
                // SET LAST PAGE
                this.pagination.last_page = response.body.last_page;
                // INCREMENT CURRENT PAGE
                this.pagination.page++;
            })
            .catch(error => {});
        },

        usersReload(){
            // RESET PAGINATION
            this.resetPagination();
            // RESET USER THAT IS BEING ALTERED
            this.user = {};
            //RELOAD USERS
            this.getUsers();

        },

        resetPagination(){
            this.pagination = {
                page: 1,
                per_page: 15,
                last_page: null,
            }
        },

        loadMore(){
            // GET USERS AND APPEND TO ARRAY
            this.getUsers(true);
        },
    },

    created(){
        // GET USERS
        this.getUsers();

        // EVENT BUS
        EventBus.$on('usersReload', this.usersReload);
    },

    beforeDestroy(){
        // NECESSARY SINCE COMPONENT IS BEING RELOADED ON CHANGE
        EventBus.$off('usersReload');
        // NECESSARY SINCE COMPONENT IS BEING RELOADED ON CHANGE
        EventBus.$off('userChangeRole');
    },
}
</script>

<style>

</style>

