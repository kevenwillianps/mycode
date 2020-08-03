<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Projetos/Classes/Métodos/ <span class="badge badge-primary">Detalhes do Método</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <router-link v-bind:to="{name : 'methods-datagrid', params : { project_id : inputs.project_id, class_id : inputs.class_id, method_id : 0}}" class="nav-link">

                            <i class="fas fa-bars mr-1"></i> Listagem

                        </router-link>

                    </li>

                </ul>

            </div>

        </nav>

        <div class="col-md-12 animate__animated animate__fadeIn mt-3">

            <div class="card card-default shadow-sm">

                <div class="card-body">

                    <h5 class="card-title">

                        <span class="badge badge-primary mr-1">

                            <i class="fas fa-hashtag mr-1"></i>{{ query.result.method_id }}

                        </span>

                        {{ query.result.name }}

                    </h5>

                    <h6 class="card-subtitle mb-2">

                        {{ query.result.description }}

                    </h6>

                    <div class="card-text">

                        <code>

                            {{ query.result.code }}

                        </code>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">

    import axios from 'axios';

    export default {

        name: "ProjectsDetails",

        data (){

            return {

                inputs : {

                    method_id : this.$route.params.method_id,

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
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_EDIT_FORM',{

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
            if (this.$route.params.method_id > 0){

                this.EditForm();

            }

        }

    }
</script>