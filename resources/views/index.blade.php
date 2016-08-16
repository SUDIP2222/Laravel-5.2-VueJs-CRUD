<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Event </title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ani.css') }}" rel="stylesheet">
    {{-- date piker--}}

    <link href="{{asset('date/bootstrap-datepicker.css')}}" rel="stylesheet">
    <script src="{{asset('date/jquery.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('date/bootstrap-datepicker.js')}}"></script>
</head>
<body>
    <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container" >
            <div class="navbar-header" >
                <a class="navbar-brand fn" href=""><span class="glyphicon glyphicon-list-alt"></span> Events </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">

                </ul>
            </div>
        </div>
    </div>


    <div class="container"  id="events">

        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading"> Add Event </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <input type="text"  class="form-control" placeholder="Enter Event" v-model="event.name">
                            <span class="help-block alert-danger" v-if="!isValid && !validation.name">
                                  <strong> *Event Name Is Require </strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <textarea  class="form-control" rows="8" cols="50" placeholder="Event Description" v-model="event.description"></textarea>
                            <span class="help-block alert-danger" v-if="!isValid && !validation.description">
                                  <strong> *Event Description Is Require </strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="date"  class=" date form-control" placeholder="Enter Date" v-model="event.date">
                            <span class="help-block alert-danger" v-if="!isValid && !validation.date">
                                  <strong> *Event Date is Require </strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button class="btn btn-primary" :disabled="!isValid" @click="addEvent" >Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- show the events -->
            <div class="col-sm-6">
                <div class="form-group">
                    <input type="text" v-model="filter" class="form-control" placeholder="Search">
                </div>
                <div  class="animated" transition="fade" class="list-group"  v-for="event in events|filterBy filter">

                    <a  class="list-group-item" v-show="show"  >
                        <h4 class="list-group-item-heading">

                            <p>  <span class="glyphicon glyphicon-bullhorn"></span> @{{event.name}}</p>
                        </h4>

                        <h5>
                            <p> <i class="glyphicon glyphicon-calendar"></i> @{{ event.date }}</p>
                        </h5>

                        <p class="list-group-item-text" > @{{ event.description }}</p> <br>

                        <button class="btn btn-sm btn-danger" @click="deleteEvent(event)" @click="show =!show">Delete</button>
                    </a>

                </div>
            </div>
        </div>
    </div>


    <div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
        <div class="container">
            <div class="navbar-text pull-left">
                <p> <span class="glyphicon glyphicon-globe"></span> 2016 Sudip Sarker </p>
            </div>

        </div>
    </div>


    <script src="{{asset('js/vue.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.1.17/vue-resource.js"></script>
    <script>
        /////////////////////// date picker //////////////////////////////////////////////////////////
        $('.date').datepicker({
            format: 'yyyy-mm-dd'
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////
        Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
        Vue.transition('fade',{
            enterClass:'fadeInUp',
            leaveClass:'fadeOutLeft'
        })
        new Vue({
            el:'#events',

            data:{
                filter:'',
                show:true,
                event: { name: '', description: '', date: '' },
                events: []
            },

            ready:function () {
                this.fetchEvents();
            },

            methods:{
                fetchEvents:function () {
                    this.$http.get('api/events').success(function(events) {
                        this.$set('events', events);
                    }).error(function(error) {
                        console.log(error);
                    });
                },
                addEvent:function(){
                    if(this.event.name&&this.event.date&&this.event.description) {
                        this.$http.post('api/events', this.event).success(function (response) {
                            this.fetchEvents();
                            this.event.name = '';
                            this.event.description = '';
                            this.event.date = '';
                        }).error(function (error) {
                            console.log(error);
                        });

                    }
                    else{
                        alert("Invalid Value");
                    }
                },
                deleteEvent: function(event) {
                    //console.log(event.id);
                    if(confirm("Are you sure you want to delete this event?")) {
                        this.$http.get('api/events/' + event.id).success(function (response) {
                            this.events.$remove(event);
                        }).error(function (error) {
                            console.log(error);
                        });
                    }
                }
            },
            computed: {

                validation: function(){
                    return {
                        name: !!this.event.name.trim(),
                        date: !!this.event.date.trim(),
                        description: !!this.event.description.trim(),

                    }
                },

                isValid: function () {
                    var validation = this.validation
                    return Object.keys(validation).every(function (key) {
                        return validation[key]
                    })

                }
            },
        });
    </script>


</body>
</html>