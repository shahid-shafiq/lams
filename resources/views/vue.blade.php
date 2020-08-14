
<!DOCTYPE html>
<html>
<head>
    <title>Laravel 7 Ajax Request example - codechief.org </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>
<body>
    <div id="app">
        <div class="container" v-if="show">
            <div class="row" style="font-size:9px; height:17px;" v-for="inf in infaaq">
                <div class="col" style="display: inline-block">@{{ inf.year }}</div>
                <div class="col"
                    v-for="(m, idx) in inf.months"
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
    </div>
</body>

<script type="text/javascript">

var app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!',
    monthstr : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    show: true,
    infaaq : [
        {year: 2018, months: [201,202,203,204, 205,206,0,208,209,210,211,212]},
        {year: 2019, months: [201,202,203,204, 205,206,207,208,209,210,0,0]},
    ]
  }
})
</script>
   
</html> 