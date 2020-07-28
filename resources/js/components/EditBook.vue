<template>
    <div>
        <h3 class="text-center">Edit Book</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateBook">
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
                    <button type="submit" class="btn btn-primary">Update Book</button>
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
        created() {
            this.axios
                .get(`http://laravel-vue.test//api/book/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.book = response.data;
                });
        },
        methods: {
            updateBook() {
                 const self = this;
                this.axios
                    .post(`http://laravel-vue.test/api/book/update/${this.$route.params.id}`, this.book)
                    .then(function(response) {
                        console.log(response.data);
                            if(typeof response.data.errors !== 'undefined'){
                                // console.log(response.data.errors);
                                self.errors = response.data.errors;
                        }else{
                             self.$toastr.w("Libro actualizado");
                             self.$router.push({name: 'home'});
                        }
                    });
            }
        }
    }
</script>