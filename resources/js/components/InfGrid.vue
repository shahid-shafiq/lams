<template>
<div class="container" v-if="this.show">
    <div class="row" style="font-size:9px; height:17px;" v-for="(inf, infid) in infaaq" :key="infid">
        <div class="" style="display: inline-block">{{ inf.year }}</div>
        <div class=""
            v-for="(m, idx) in inf.months" :key="idx"
            style="
            margin-left:1px; padding:0;
            width:15px;height:15px;
            display:inline-block"
        >
        <span v-if="m != 0" v-bind:title="monthstr[idx]" style="
            border: 1px solid green;
            background-color: green;
            width:15px;height:15px;
            display:inline-block"></span>
        <span v-if="m == 0" v-bind:title="monthstr[idx]" style="
            border: 1px solid red;
            background-color: red;
            width:15px;height:15px;
            display:inline-block"></span>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: {
            visible: {type:Boolean, default:true},
            infaaq: {type:Array, default: function() { return [
                {year: 2018, months: [201,202,203,204, 205,206,0,208,209,210,211,212]},
                {year: 2019, months: [201,202,203,204, 205,206,207,208,209,210,0,0]},
                {year: 2020, months: [201,0,203,0, 205,0,0,208,209,210,0,0]},
            ] }
        },

        data: function() {
            return {
                monthstr : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                show: true,
            }
        },

        mounted: () => {
            console.log('InfGrid Component mounted');
        },

        methods: {
            toggle : function() {
                this.show = !this.show;
            }
        }

    }}
</script>