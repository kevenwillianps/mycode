<template>

    <div class="alert alert-info shadow-sm animated animatedFadeInUp fadeInUp">

        <i class="fa fa-info-circle mr-1"></i>

        <strong>Atenção!</strong>

        {{ message }}

    </div>

</template>

<script type="text/ecmascript-6">

    export default {

        name: "AlertInfo",

        props : {

            message : null,

        }

    };

</script>