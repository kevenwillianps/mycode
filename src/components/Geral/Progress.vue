<template>

    <div class="progress">

        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" v-bind:aria-valuenow="percent" aria-valuemin="0" aria-valuemax="100" v-bind:style="'width:' + percent + '%'"></div>

    </div>
    
</template>

<script type="text/ecmascript-6">

    export default {

        name: "Progress",

        props : {

            percent : null,

        }

    }
</script>