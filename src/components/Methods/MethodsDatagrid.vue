<template>

    <div>

        <ModalConfirm title="Atenção!" message="Deseja excluir este registro ?" v-on:ConfirmRequest="Delete"></ModalConfirm>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Projetos/Classes/Métodos/ <span class="badge badge-primary">Listagem</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <router-link v-bind:to="{name : 'methods-form', params : { project_id : inputs.project_id, class_id : inputs.class_id, method_id : 0}}" class="nav-link">

                            <i class="fas fa-plus mr-1"></i> Novo

                        </router-link>

                    </li>

                    <li class="nav-item">

                        <router-link v-bind:to="{name : 'methods-form-template-build', params : { project_id : inputs.project_id, class_id : inputs.class_id}}" class="nav-link">

                            <i class="fas fa-code-branch mr-1"></i> Template

                        </router-link>

                    </li>

                </ul>

            </div>

        </nav>

        <div class="col-md-12 mt-3"  v-if="controls.progress_bar">

           <div class="animate__animated animate__fadeIn">

               <div class="card shadow-sm">

                   <div class="card-body">

                       <div class="progress">

                           <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>

                       </div>

                   </div>

               </div>

           </div>

        </div>

        <div class="col-md-12 mt-3" v-else>

            <div class="animate__animated animate__fadeIn" v-if="query.result.methods <= 0">

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

                <div class="col-md-3 mb-3 animate__animated animate__fadeIn" v-for="(result, index) in query.result.methods" v-bind:key="index">

                    <div class="card card-default shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">

                            <span class="badge badge-primary mr-1">

                                <i class="fas fa-hashtag mr-1"></i>{{ result.method_id }}

                            </span>

                                {{ result.name }}

                            </h5>

                            <h6 class="card-subtitle mb-2">

                                Método

                            </h6>

                            <div class="card-text">

                                {{ result.description}}

                            </div>

                        </div>

                        <nav class="navbar navbar-card navbar-expand-lg navbar-light bg-transparent card-footer">

                            <button class="navbar-toggler" type="button" data-toggle="collapse" v-bind:data-target="'#navbar_method_' + result.method_id" v-bind:aria-controls="'navbar_method_' + result.method_id" aria-expanded="false">

                                <span class="navbar-toggler-icon"></span>

                            </button>

                            <div class="collapse navbar-collapse" v-bind:id="'navbar_method_' + result.method_id">

                                <ul class="navbar-nav mr-auto">

                                    <li class="nav-item">

                                        <a class="nav-link" type="button" data-toggle="modal" data-target="#myModal" v-on:click="inputs.method_id = result.method_id">

                                            <i class="fas fa-fire-alt mr-1"></i>Excluir

                                        </a>

                                    </li>

                                    <li class="nav-item">

                                        <router-link class="nav-link" v-bind:to="{name : 'methods-form', params : { project_id : inputs.project_id, class_id : inputs.class_id, method_id : result.method_id}}">

                                            <i class="fas fa-pencil-alt mr-1"></i>Alterar

                                        </router-link>

                                    </li>

                                    <li class="nav-item">

                                        <router-link class="nav-link" v-bind:to="{name : 'methods-detail', params : { project_id : inputs.project_id, class_id : inputs.class_id, method_id : result.method_id}}">

                                            <i class="fa fa-search mr-1"></i>Detalhes

                                        </router-link>

                                    </li>

                                </ul>

                            </div>

                        </nav>

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
        name: "MethodsDatagrid",

        components : {

            ModalConfirm,

        },

        data (){

            return {

                inputs : {

                    project_id: this.$route.params.project_id,
                    class_id: this.$route.params.class_id,
                    method_id : null,

                },

                query : {

                    result: {

                        methods : []

                    },

                },

                controls : {

                    progress_bar : false,

                }

            }

        },

        methods : {

            /** Listo os registros **/
            List(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio uma requisição **/
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_DATAGRID', {

                    inputs : this.inputs,

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.methods = response.data.result;

                        /** Defino um delay */
                        window.setTimeout(() => {

                            /** Desabilito a barra de progresso */
                            this.controls.progress_bar = false;

                        }, 1000);

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Listagem de registros **/
            Delete(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_DELETE',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.List();

                        /** Defino um delay */
                        window.setTimeout(() => {

                            console.log('Sucesso -> ' + response.data);

                            /** Desabilito a barra de progresso */
                            this.controls.progress_bar = false;

                        }, 1000);

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            }

        },

        mounted(){

            this.List();

        }

    }
</script>