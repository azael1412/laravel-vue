<template>
    <div>
        <h3 class="text-center">Add Book</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addBook">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="book.name">
                       <p v-if="errors.name" class="text-danger">
                           {{errors.name[0]}}
                       </p>
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" class="form-control" v-model="book.author">
                        <p v-if="errors.author" class="text-danger">
                            {{errors.author[0]}}
                        </p>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Book</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                book: {},
                errors: [],
            }
        },
        methods: {
            addBook() {
                const self = this;
                this.axios
                    .post('http://laravel-vue.test/api/book/add', this.book)
                    .then(function(response){
                        if(typeof response.data.errors !== 'undefined'){
                                console.log(response.data.errors)
                                self.errors = response.data.errors;
                        }else{
                             self.$toastr.s("Libro registrado!");
                            self.$router.push({name: 'home'});
                        }
                    })
                    .catch(error =>  console.log(error))
                    .finally(() => console.log("terminado..."))
            }
        }
    }
</script>