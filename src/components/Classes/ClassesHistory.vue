<template>

    <div>

        <ModalConfirm title="Atenção!" message="Deseja excluir este registro ?" v-on:ConfirmRequest="Delete"></ModalConfirm>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Projetos/Classes/Histórico/ <span class="badge badge-primary">Listagem</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <router-link v-bind:to="{name : 'projects-form', params : {project_id : 0}}" class="nav-link">

                            <i class="fas fa-pencil-alt mr-1"></i>Novo

                        </router-link>

                    </li>

                </ul>

            </div>

        </nav>

        <div class="col-md-12 mt-3">

            <div class="row">

                <div class="col-md-12 animate__animated animate__fadeIn">

                    <div class="animate__animated animate__fadeIn mb-2" v-if="query.success">

                        <div class="card">

                            <div class="card-body shadow-sm">

                                <h4 class="card-title">

                                    <span class="badge badge-success">Sucesso...</span>

                                </h4>

                                <h6 class="card-subtitle">

                                    Os arquivos do projeto foram gerados com sucesso

                                </h6>

                            </div>

                        </div>

                    </div>

                    <div class="animate__animated animate__fadeIn" v-if="controls.progress_bar">

                        <div class="card shadow-sm">

                            <div class="card-body">

                                <div class="progress">

                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="animate__animated animate__fadeIn" v-else-if="query.result <= 0">

                        <div class="card shadow-sm">

                            <div class="card-body">

                                <div class="media">

                                    <img src="image/svg/003-error.svg" width="70px" class="mr-3" alt="MyCMS - Keven Willian">

                                    <div class="media-body">

                                        <h3 class="mt-0">

                                            Ops!

                                        </h3>

                                        <h5 class="text-muted">

                                            Não foram localizado registros

                                        </h5>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" v-else>

                        <div class="col-md-3 mb-3" v-for="(result, index) in query.result" v-bind:key="index">

                            <div class="card card-default">

                                <div class="card-body">

                                    <h5 class="card-title">

                                    <span class="badge badge-primary">

                                        <i class="fas fa-hashtag mr-1"></i>{{result.class_log_id}}

                                    </span>

                                        {{result.name}}

                                    </h5>

                                    <h6 class="card-subtitle mb-2">

                                        Projeto

                                    </h6>

                                    <div class="card-text">

                                        {{ result.description }}

                                    </div>

                                </div>

                                <nav class="navbar navbar-card navbar-expand-lg navbar-light bg-transparent card-footer">

                                    <button class="navbar-toggler" type="button" data-toggle="collapse" v-bind:data-target="'#navbar_project_' + result.class_id" v-bind:aria-controls="'#navbar_project_' + result.class_id" aria-expanded="false">

                                        <span class="navbar-toggler-icon"></span>

                                    </button>

                                    <div class="collapse navbar-collapse" v-bind:id="'navbar_project_' + result.class_id">

                                        <ul class="navbar-nav mr-auto">

                                            <li class="nav-item">

                                                <router-link v-bind:to="{name : 'classes-datagrid', params : {class_id : result.class_id}}" class="nav-link">

                                                    <i class="far fa-eye mr-1"></i>Ver

                                                </router-link>

                                            </li>

                                            <li class="nav-item">

                                                <a class="nav-link" type="button" v-on:click="Restore(result.class_log_id, result.class_id)">

                                                    <i class="fas fa-hammer mr-1"></i>Restaurar

                                                </a>

                                            </li>

                                        </ul>

                                    </div>

                                </nav>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">

    /** Importação de componentes **/
    import axios from 'axios';
    import ModalConfirm from '../Geral/ModalConfirm';

    export default {

        /** Nome do componente atual **/
        name: "ClassesHistory",

        components : {

            ModalConfirm,

        },

        data (){

            return {

                inputs : {

                    class_id : this.$route.params.class_id,
                    class_log_id : null,

                },

                query : {

                    result : [],
                    success : false,

                },

                controls : {

                    progress_bar : true,

                }

            }

        },

        methods : {

            /** Listagem de registros **/
            List(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Escondo a mensagem de suscesos */
                this.query.success = false;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=CLASS_LOGS&ACTION=CLASS_LOGS_DATAGRID', {

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Guardo o Resultado */
                        this.query.result = response.data.result;

                        /** Retiro a barra de progresso */
                        window.setTimeout(() => {

                            this.controls.progress_bar = false;

                        }, 1000);

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Listagem de registros **/
            Restore(class_log_id, class_id){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Escondo a mensagem de suscesos */
                this.query.success = false;

                /** identificadores */
                this.inputs.class_id = class_id;
                this.inputs.class_log_id = class_log_id;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=CLASS_LOGS&ACTION=CLASS_LOGS_RESTORE', {

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(() => {

                        /** Listo todos os registros novamente */
                        this.List();

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

        },

        mounted(){

            this.List();

        },

    }

</script>