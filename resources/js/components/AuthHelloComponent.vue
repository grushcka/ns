<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        Your are logged {{username}}!!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['username']
    }
</script>
