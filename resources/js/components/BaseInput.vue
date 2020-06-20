<template>
    <div>
        <div class="form-group row">
            <label :for="name"
                   class="col-md-4 col-form-label text-md-right">{{name}}</label>

            <div class="col-md-6">
                <input :id="name" type="text"
                       class="form-control" :name="name"
                       :value="old_value" required autofocus>
                <span v-if="error_message.length" class="invalid-feedback" role="alert">
                    <strong>{{ error_message }}</strong>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: true
            },
            old_value: {
                default: ''
            },
            error_message: {
                default: ''
            }
        },
        name: "BaseInput"
    }
</script>

<style scoped>

</style>
