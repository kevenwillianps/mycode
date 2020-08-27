<template>

    <div>

        <ModalConfirm title="Atenção!" message="Deseja excluir este registro ?" v-on:ConfirmRequest="Delete"></ModalConfirm>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Projetos/Classes/Pasta/ <span class="badge badge-primary">Arquivos</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <router-link v-bind:to="{name : 'classes-datagrid', params : {project_id : inputs.project_id}}" class="nav-link">

                            <i class="fas fa-bars mr-1"></i>Listagem

                        </router-link>

                    </li>

                    <!--
                    <li class="nav-item">

                        <router-link v-bind:to="{name : 'folders-auxiliary-form', params : {project_id : inputs.project_id, folder_id : inputs.folder_id, folder_auxiliary_id : 0}}" class="nav-link">

                            <i class="fas fa-pencil-alt mr-1"></i>SubPasta

                        </router-link>

                    </li>
                    -->

                </ul>

            </div>

        </nav>

        <div class="col-md-12 mt-3" v-if="controls.progress_bar">

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

            <div class="row">

                <FoldersAuxiliaryDatagrid v-bind:project-id="inputs.project_id" v-bind:folder-id="inputs.folder_id"></FoldersAuxiliaryDatagrid>

                <div class="col-md-3 mb-3" v-for="(result, index) in query.result.classes" v-bind:key="index">

                    <div class="card card-default shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">

                            <span class="badge badge-primary mr-1">

                                <i class="fas fa-hashtag mr-1"></i>{{result.class_id}}

                            </span>

                                {{ result.name }}

                            </h5>

                            <h6 class="card-subtitle mb-2">

                                Classe

                            </h6>

                            <div class="card-text">

                                {{ result.description }}

                            </div>

                        </div>

                        <nav class="navbar navbar-card navbar-expand-lg navbar-light bg-transparent card-footer">

                            <button class="navbar-toggler" type="button" data-toggle="collapse" v-bind:data-target="'#navbar_classes_' + result.folder_id" v-bind:aria-controls="'navbar_classes_' + result.folder_id" aria-expanded="false">

                                <span class="navbar-toggler-icon"></span>

                            </button>

                            <div class="collapse navbar-collapse" v-bind:id="'navbar_classes_' + result.folder_id">

                                <ul class="navbar-nav mr-auto">

                                    <li class="nav-item">

                                        <a class="nav-link" type="button" data-toggle="modal" data-target="#myModal" v-on:click="inputs.class_id = result.class_id">

                                            <i class="fas fa-fire-alt mr-1"></i>Excluir

                                        </a>

                                    </li>

                                    <li class="nav-item">

                                        <router-link v-bind:to="{name : 'classes-form', params : {project_id : inputs.project_id, class_id : result.class_id}}" class="nav-link">

                                            <i class="fas fa-pencil-alt mr-1"></i>Alterar

                                        </router-link>

                                    </li>

                                    <li class="nav-item">

                                        <router-link v-bind:to="{name : 'methods-datagrid', params : {project_id : inputs.project_id, class_id : result.class_id}}" class="nav-link">

                                            <i class="far fa-eye mr-1"></i>Ver

                                        </router-link>

                                    </li>

                                    <li class="nav-item">

                                        <router-link v-bind:to="{name : 'classes-detail', params : {class_id : result.class_id}}" class="nav-link">

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
    import FoldersAuxiliaryDatagrid from '../FoldersAuxiliary/FoldersAuxiliaryDatagrid';

    export default {

        /** Nome do componente atual **/
        name: "FoldersDetails",

        components : {

            ModalConfirm,
            FoldersAuxiliaryDatagrid

        },

        data (){

            return {

                inputs : {

                    project_id: this.$route.params.project_id,
                    folder_id: this.$route.params.folder_id,

                },

                controls : {

                    progress_bar : false,

                },

                query : {

                    result: {

                        classes : []

                    },

                },

            }

        },

        methods : {

            /** Listo os registros **/
            List(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio uma requisição **/
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_FILES_IN_FOLDER', {

                    inputs : this.inputs,

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.classes = response.data.result;

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
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_DELETE',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.List();
                        console.log('Sucesso -> ' + response.data);

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

            }

        },

        mounted(){

            this.List();

        }

    }
</script>