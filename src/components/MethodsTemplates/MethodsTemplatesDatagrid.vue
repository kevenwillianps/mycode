<template>

    <div>

        <ModalConfirm title="Atenção!" message="Deseja excluir este registro ?" v-on:ConfirmRequest="Delete"></ModalConfirm>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Template de Métodos/ <span class="badge badge-primary">Listagem</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <a type="button" v-on:click="GenerateDefault()" class="nav-link">

                            <i class="fas fa-pencil-alt mr-1"></i>Gerar

                        </a>

                    </li>

                    <li class="nav-item">

                        <router-link v-bind:to="{ name : 'methods-templates-form', params : { method_template_id : 0 }}" class="nav-link">

                            <i class="fas fa-pencil-alt mr-1"></i>Novo

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

        <div class="col-md-12 animate__animated animate__fadeIn mt-3" v-else>

            <div class="animate__animated animate__fadeIn" v-if="query.result <= 0">

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

                    <div class="card card-default shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">

                                <span class="badge badge-primary mr-1">

                                    <i class="fas fa-hashtag mr-1"></i>{{ result.method_template_id }}

                                </span>

                                {{ result.name }}

                            </h5>

                            <h6 class="card-subtitle mb-2">

                                Método Template

                            </h6>

                            <div class="card-text">

                                {{ result.description}}

                            </div>

                        </div>

                        <nav class="navbar navbar-card navbar-expand-lg navbar-light bg-transparent card-footer">

                            <button class="navbar-toggler" type="button" data-toggle="collapse" v-bind:data-target="'#navbar_method_' + result.method_template_id" v-bind:aria-controls="'navbar_method_' + result.method_template_id" aria-expanded="false">

                                <span class="navbar-toggler-icon"></span>

                            </button>

                            <div class="collapse navbar-collapse" v-bind:id="'navbar_method_' + result.method_template_id">

                                <ul class="navbar-nav mr-auto">

                                    <li class="nav-item">

                                        <a class="nav-link" type="button" data-toggle="modal" data-target="#myModal" v-on:click="inputs.method_template_id = result.method_template_id">

                                            <i class="fas fa-fire-alt mr-1"></i>Excluir

                                        </a>

                                    </li>

                                    <li class="nav-item">

                                        <router-link class="nav-link" v-bind:to="{name : 'methods-templates-form', params : { method_template_id : result.method_template_id}}">

                                            <i class="fas fa-pencil-alt mr-1"></i> Alterar

                                        </router-link>

                                    </li>

                                    <li class="nav-item">

                                        <router-link class="nav-link" v-bind:to="{name : 'methods-templates-detail', params : { method_template_id : result.method_template_id}}">

                                            <i class="fa fa-search mr-1"></i> Detalhes

                                        </router-link>

                                    </li>

                                    <li class="nav-item">

                                        <a class="nav-link" type="button" data-toggle="collapse" v-bind:href="'#navbar_method_template_' + result.method_template_id" role="button" aria-expanded="false" aria-controls="collapseExample">

                                            <i class="fas fa-hammer mr-1"></i> Gerar

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </nav>

                        <div class="collapse card-body" v-bind:id="'navbar_method_template_' + result.method_template_id">

                            <div class="card card-body">

                                <div class="form-group">

                                    <input type="text" class="form-control" v-model="inputs.database_name">

                                </div>

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
        name: "MethodsTemplateDatagrid",

        components : {

            ModalConfirm,

        },

        data (){

            return {

                inputs : {

                    method_template_id : null,
                    database_name : null,

                },

                query : {

                    result : [],

                },

                controls : {

                    progress_bar : false,

                },

            }

        },

        methods : {

            /** Listo os registros **/
            List(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio uma requisição **/
                axios.post('router.php?TABLE=METHODS_TEMPLATE&ACTION=METHODS_TEMPLATE_DATAGRID')

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result = response.data.result;

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
            GenerateDefault(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS_TEMPLATE&ACTION=METHODS_TEMPLATE_GENERATE_DEFAULT')

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.List();
                        console.log('Sucesso -> ' + response.data);

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
                axios.post('router.php?TABLE=METHODS_TEMPLATE&ACTION=METHODS_TEMPLATE_DELETE',{

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

            },

        },

        mounted(){

            this.List();

        },

    }

</script>