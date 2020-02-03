<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <form>

                    <div class="form-group" v-if="lastId">
                        <input type="text" class="form-control" placeholder="id" v-model="lastId">
                    </div>

                    <div class="form-group" v-if="lastId">
                        <button class="btn btn-success" v-on:click="process">Process</button>

                        <a v-if="url" v-bind:href="url" target="_blank">last image</a>
                    </div>



                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Width" v-model="form.width">
                        <small class="form-text text-muted">min 640, max 1920</small>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Height" v-model="form.height">
                        <small class="form-text text-muted">min 480, max 1080</small>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" v-model="form.color">
                    </div>

                    Rectangles

                    <button class="btn btn-success" v-on:click="addRectangle">Add</button>

                    <button class="btn btn-success" v-on:click="send">Submit</button>

                    <div class="row">

                        <div class="form-group col-md-4" v-for="rectangle in form.rectangles">

                            <div class="form-group">
                                <input type="text" class="form-control" v-model="rectangle.customId" placeholder="id">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" v-model="rectangle.x" placeholder="x">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" v-model="rectangle.y" placeholder="y">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" v-model="rectangle.width" placeholder="width">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" v-model="rectangle.height" placeholder="height">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" v-model="rectangle.color" placeholder="color">
                            </div>

                        </div>


                    </div>


                </form>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        data :  function () {
            return {
                lastId: null,
                url: null,
                form: {
                    width: null,
                    height: null,
                    color: '#AAA',
                    rectangles: []
                }

            }
        },
        mounted() {

            this.init();
        },
        methods: {
            init: function() {
            },
            addRectangle: function(ev) {

                ev.preventDefault();

                this.form.rectangles.push({
                    customId: null,
                    width: null,
                    height: null,
                    color: null,
                    x: null,
                    y: null
                })
            },
            send: function (ev) {
                ev.preventDefault();
                axios.post('/api/create', this.form)
                    .then((res) => {
                        console.log(res.data);
                        this.lastId = res.data.id;
                        this.url = null;
                    })
                    .catch(e => console.log(e));
            },
            process: function(ev) {
                ev.preventDefault();
                axios.post('/create', {id: this.lastId})
                    .then((res) => {
                        console.log(res.data);
                        this.url = res.data.url;
                    })
                    .catch(e => console.log(e));
            }
        }
    }
</script>
