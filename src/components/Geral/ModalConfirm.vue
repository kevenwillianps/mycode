<template>

    <div class="modal fade" id="myModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">

        <div class="modal-dialog text-dark" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="staticBackdropLabel">

                        {{ title }}

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    {{ message }}

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                        Cancelar

                    </button>

                    <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="ConfirmRequest()">

                        Continuar

                    </button>

                </div>

            </div>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">

    export default {

        name: "ModalConfirm",

        props : {

            title   : null,
            message : null,

        },

        methods : {

            ConfirmRequest(){

                this.$emit('ConfirmRequest');

            }

        }

    }

</script>