<template>
    <div class="text-center user-grid__delete icon">
        <i class="fas fa-times icon icon__times" @click="controllerDelete()"></i>
    </div>
</template>

<script>
// EVENT BUS
import {EventBus} from '../../app';

export default {
    props: ['user'],
    data(){
        return {
            // DELETE MODAL CONFIGURATION
            swalConfigDelete: {
                // ICON
                type: 'error',
                // TITLE
                title: 'Delete',
                // BODY
                text: 'Are you sure you want to delete "'+this.user.username+'"?',
                // SHOW BUTTONS
                showConfirmButton: true,
                showCancelButton: true,
                // BUTTON TEXT
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                // BUTTON COLOR - BOOTSTRAP RED
                confirmButtonColor: '#dc3545',
                // MESSAGE POSITION
                position: 'center',
                // MESSAGE TO DISSAPEAR IN
                timer: false,
                // COMPACT MESSAGE
                toast: false,
                // PREVENT MESSAGE DISMISAL FROM AN OUTSIDE CLICK
                allowOutsideClick: false
            },
        }
    },
    methods: {
        controllerDelete(){
            // USER IS TRYING TO DELETE THEMSELF
            if(this.user.id === this.$auth.user().id){
                Vue.swal('Error','You can not delete yourself.','error');
            }
            // USER IS TRYING TO DELETE SOMEONE ELSE
            else{
                // RUN DELETE MODAL
                this.$swal(this.swalConfigDelete)
                .then(response => {
                    // AFFIRMATIVE ANSWER
                    if(response.value){
                        // DELETE USER
                        this.userDelete();
                    }
                });
            }
        },

        userDelete(){
            this.$http.delete('users',{
                params:{
                    id: this.user.id,
                }
            })
            .then(response =>{
                // USER DELETED THEMSELF AS ADMINISTRATOR
                if(response.data.logout){
                    // LOGOUT
                    this.$auth.logout();
                }
                // USER DELETED SOMEONE ELSE
                else{
                    // RUN usersReload BUS EVENT ON UsersIndex
                    EventBus.$emit('usersReload');
                }
            })
            .catch(error => {});
        },
    },
}
</script>

<style>

</style>
