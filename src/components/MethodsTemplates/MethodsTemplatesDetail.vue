<template>

    <div>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Template de Métodos/ <span class="badge badge-primary">Detalhes do Template de Método</span>

                </h4>

            </div>

            <div class="col-md-6 text-right animate__animated animate__fadeIn">

                <h4>

                    <router-link to="/methods/templates/datagrid/" class="btn btn-default">

                        Listagem

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12 animate__animated animate__fadeIn">

                <div class="card card-default shadow-sm">

                    <div class="card-body">

                        <h5 class="card-title">

                            <span class="badge badge-primary mr-1">

                                <i class="fas fa-hashtag mr-1"></i>{{ query.result.method_template_id }}

                            </span>

                            {{ query.result.name }}

                        </h5>

                        <h6 class="card-subtitle mb-2">

                            {{ query.result.description }}

                        </h6>

                        <div class="form-group">

                            <textarea rows="10" class="form-control" v-model="query.result.code"></textarea>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">

    import axios from 'axios';

    export default {

        name: "MethodsTemplateDetails",

        data (){

            return {

                inputs : {

                    method_template_id : this.$route.params.method_template_id,

                },

                query : {

                    result : [],

                }

            }

        },

        methods : {

            /** Método para editar o registro **/
            EditForm(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS_TEMPLATE&ACTION=METHODS_TEMPLATE_EDIT_FORM',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result = response.data.result;
                        /** Descriptografo em base64 o código escrito **/
                        this.query.result.code = atob(this.query.result.code);

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

        },

        mounted(){

            /** Verifico se é cadastro ou alteração **/
            if (this.$route.params.method_template_id > 0){

                this.EditForm();

            }

        }

    }
</script>