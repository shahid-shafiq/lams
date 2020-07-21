<template>
    <div class="alert alert-success" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
        <input type="text" v-model="no" class="form-control" placeholder="Receipt no.">
        <input type="radio" id="on" value="1" v-model="active">
        <label for="on">Active</label>
        <input type="radio" id="off" value="0" v-model="active">
        <label for="off">Inactive</label>
        <select v-model="department">
            <option value='1'>Blue area</option>
            <option value='2'>Gulzar-e-Quaid</option>
            <option value='3'>Faizabad</option>
        </select>
        <div>
            <div>Receipt No. = {{no}}</div>
            <div>Status = {{active ? 'Active' : 'Inactive'}}</div>
            <div>Department = {{department}}</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                show: false,
                no: 1,
                department: ''
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message=> {
                this.flash(message);
            })
        },

        methods: {
            flash(message) {
                this.body = message;
                this.show = true;
                this.hide(); 
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 40000);
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>