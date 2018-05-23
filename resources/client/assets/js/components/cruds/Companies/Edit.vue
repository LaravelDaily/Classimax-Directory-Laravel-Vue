<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Companies</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            placeholder="Enter Name"
                                            :value="item.name"
                                            @input="updateName"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <v-select
                                            name="city"
                                            label="name"
                                            @input="updateCity"
                                            :value="item.city"
                                            :options="citiesAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="categories">Categories</label>
                                    <v-select
                                            name="categories"
                                            label="name"
                                            @input="updateCategories"
                                            :value="item.categories"
                                            :options="categoriesAll"
                                            multiple
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="address"
                                            placeholder="Enter Address"
                                            :value="item.address"
                                            @input="updateAddress"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea
                                            rows="3"
                                            class="form-control"
                                            name="description"
                                            placeholder="Enter Description"
                                            :value="item.description"
                                            @input="updateDescription"
                                            >
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updateLogo"
                                    >
                                    <ul v-if="item.uploaded_logo" class="list-unstyled">
                                        <li>
                                            {{ item.uploaded_logo.file_name }}
                                            <span><a href="#" @click="removeLogo"
                                                     class="btn btn-xs btn-danger">Remove file</a> </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="box-footer">
                                <vue-button-spinner
                                        class="btn btn-primary btn-sm"
                                        :isLoading="loading"
                                        :disabled="loading"
                                        >
                                    Save
                                </vue-button-spinner>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            // Code...
        }
    },
    computed: {
        ...mapGetters('CompaniesSingle', ['item', 'loading', 'citiesAll', 'categoriesAll']),
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('CompaniesSingle', ['fetchData', 'updateData', 'resetState', 'setName', 'setCity', 'setCategories', 'setAddress', 'setDescription', 'uploadLogo', 'destroyLogo']),
        updateName(e) {
            this.setName(e.target.value)
        },
        updateCity(value) {
            this.setCity(value)
        },
        updateCategories(value) {
            this.setCategories(value)
        },
        updateAddress(e) {
            this.setAddress(e.target.value)
        },
        updateDescription(e) {
            this.setDescription(e.target.value)
        },
        
            removeLogo(e, id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "To fully delete the file submit the form.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#dd4b39',
                    focusCancel: true,
                    reverseButtons: true
                }).then(result => {
                    if (typeof result.dismiss === "undefined") {
                        this.destroyLogo('');
                    }
                })
            },
            updateLogo(e) {
                this.uploadLogo(e.target.files[0]);
                this.$forceUpdate();
            },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'companies.index' })
                    this.$eventHub.$emit('update-success')
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style scoped>

</style>
