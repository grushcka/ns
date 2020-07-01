<template>
    <div class="form-group row">

        <label :for="name"
               class="col-md-4 col-form-label text-md-right">{{name}}</label>
        <div class="col-md-6">
            <input :id="name" :type="type||'text'"
                   :class="{  'form-control': true, 'is-invalid': hasError(error_message) }"  :name="name"
                   :value="old_value" required autofocus>
            <span v-if="hasError(error_message)" class="invalid-feedback" role="alert">
                    <strong>{{ error_message }}</strong>
                </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'name',
            'type',
            'old_value',
            'error_message'
        ],
        name: "BaseInput",
        methods:{
            hasError(message) {
                return message && message.length;
            }
        }
    }
</script>

<style scoped>

</style>
