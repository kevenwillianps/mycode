<template>

    <div class="col-md-12 animate__animated animate__fadeIn">

        <div class="row">

            <div class="col-md-3 mb-3" v-for="(result, index) in query.result" v-bind:key="index">

                <div class="card card-default shadow-sm">

                    <div class="card-body">

                        <h5 class="card-title">

                            <span class="badge badge-dark mr-1">

                                <i class="far fa-folder-open mr-1"></i>{{ result.folder_id }}

                            </span>

                            {{ result.name }}

                        </h5>

                        <h6 class="card-subtitle mb-2">

                            Pasta

                        </h6>

                    </div>

                    <nav class="navbar navbar-card navbar-expand-lg navbar-light bg-transparent card-footer">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" v-bind:data-target="'#navbar_folder_' + result.folder_id" v-bind:aria-controls="'navbar_folder_' + result.folder_id" aria-expanded="false">

                            <span class="navbar-toggler-icon"></span>

                        </button>

                        <div class="collapse navbar-collapse" v-bind:id="'navbar_folder_' + result.folder_id">

                            <ul class="navbar-nav mr-auto">

                                <li class="nav-item">

                                    <a class="nav-link" type="button" v-on:click="Delete(result.folder_id)">

                                        <i class="fas fa-fire-alt mr-1"></i>Excluir

                                    </a>

                                </li>

                                <li class="nav-item">

                                    <router-link v-bind:to="{name : 'folders-form', params : {project_id : projectId, folder_id : result.folder_id}}" class="nav-link">

                                        <i class="fas fa-pencil-alt mr-1"></i>Editar

                                    </router-link>

                                </li>

                                <li class="nav-item">

                                    <router-link v-bind:to="{name : 'folders-detail', params : {project_id : projectId, folder_id : result.folder_id}}" class="nav-link">

                                        <i class="far fa-eye mr-1"></i>Detalhes

                                    </router-link>

                                </li>

                            </ul>

                        </div>

                    </nav>

                </div>

            </div>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">

    /** Importo os componentes que irei utilizar **/
    import axios from 'axios';

    export default {

        /** Nome do componente atual **/
        name: "FoldersDatagrid",

        props : {

            projectId : null,

        },

        data (){

            return {

                /** Grupo de variavei s para guardar consultas sql's **/
                query : {

                    result : [],

                },

                inputs : {

                    folder_id : [],
                    project_id : null,

                }

            }

        },

        methods : {

            /** Método para listar registros **/
            List(){

                this.inputs.project_id = this.projectId;

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=FOLDERS&ACTION=FOLDERS_DATAGRID', {

                    inputs : this.inputs,

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result = response.data.result;

                    })

                    /** Caso tenha erro **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Listagem de registros **/
            Delete(folder_id){

                this.inputs.folder_id = folder_id;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=FOLDERS&ACTION=FOLDERS_DELETE',{

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

            /** Executo um método especifico **/
            this.List();

            /** Informo que o componente foi montado com sucesso **/
            console.log('Componente "FoldersDatagrid", montado com sucesso!');

        }

    }
</script>