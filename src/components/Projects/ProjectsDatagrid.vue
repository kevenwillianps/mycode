<template>

    <div>

        <ModalConfirm title="Atenção!" message="Deseja excluir este registro ?" v-on:ConfirmRequest="Delete"></ModalConfirm>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Projetos

                </h4>

            </div>

            <div class="col-md-6 text-right animate__animated animate__fadeIn">

                <h4>

                    <router-link v-bind:to="{name : 'projects-form', params : {project_id : 0}}" class="btn btn-default">

                        Cadastro

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12 animate__animated animate__fadeIn">

                <div class="row">

                    <div class="col-md-3 mb-3" v-for="(result, index) in query.result" v-bind:key="index">

                        <div class="card card-default">

                            <div class="card-body">

                                <h5 class="card-title">

                                    <span class="badge badge-light">

                                        <i class="fas fa-hashtag mr-1"></i>{{result.project_id}}

                                    </span>

                                    {{result.name}}

                                </h5>

                                <h6 class="card-subtitle text-white-50 mb-2">

                                    Projeto

                                </h6>

                                <div class="card-text">

                                    {{ result.description }}

                                </div>

                            </div>

                            <nav class="navbar navbar-footer navbar-expand-lg navbar-dark bg-transparent card-footer">

                                <button class="navbar-toggler" type="button" data-toggle="collapse" v-bind:data-target="'#navbar_project_' + result.project_id" v-bind:aria-controls="'#navbar_project_' + result.project_id" aria-expanded="false">

                                    <span class="navbar-toggler-icon"></span>

                                </button>

                                <div class="collapse navbar-collapse" v-bind:id="'navbar_project_' + result.project_id">

                                    <ul class="navbar-nav mr-auto">

                                        <li class="nav-item">

                                            <a class="nav-link" type="button" data-toggle="modal" data-target="#myModal" v-on:click="inputs.project_id = result.project_id">

                                                <i class="fas fa-fire-alt"></i>

                                            </a>

                                        </li>

                                        <li class="nav-item">

                                            <router-link v-bind:to="{name : 'projects-form', params : { project_id : result.project_id }}" class="nav-link">

                                                <i class="fas fa-pencil-alt"></i>

                                            </router-link>

                                        </li>

                                        <li class="nav-item">

                                            <router-link v-bind:to="{name : 'classes-datagrid', params : {project_id : result.project_id}}" class="nav-link">

                                                <i class="far fa-eye"></i>

                                            </router-link>

                                        </li>

                                        <li class="nav-item">

                                            <a class="nav-link" type="button" v-on:click="Build(result.project_id)">

                                                <i class="fas fa-hammer"></i>

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

</template>

<script type="text/ecmascript-6">

    /** Importação de componentes **/
    import axios from 'axios';
    import ModalConfirm from '../Geral/ModalConfirm';

    export default {

        /** Nome do componente atual **/
        name: "ProjectsDatagrid",

        components : {

            ModalConfirm,

        },

        data (){

            return {

                inputs : {

                    project_id : null,

                },

                query : {

                    result : [],

                },

            }

        },

        methods : {

            /** Listagem de registros **/
            List(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=PROJECTS&ACTION=PROJECTS_DATAGRID')

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result = response.data.result;

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Listagem de registros **/
            Delete(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=PROJECTS&ACTION=PROJECTS_DELETE',{

                    inputs : this.inputs

                })

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
            Build(project_id){

                this.inputs.project_id = project_id;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=PROJECTS&ACTION=PROJECTS_BUILD',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.List();
                        console.log('Sucesso -> ' + response.data);

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            }

        },

        mounted(){

            this.List();

        },

    }

</script>