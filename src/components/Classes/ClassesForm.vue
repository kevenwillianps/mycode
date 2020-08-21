<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Projetos/Classes/ <span class="badge badge-primary">Formulário</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <router-link v-bind:to="{name : 'classes-datagrid', params : { project_id : inputs.project_id}}" class="nav-link">

                            <i class="fas fa-bars mr-1"></i> Listagem

                        </router-link>

                    </li>

                </ul>

            </div>

        </nav>

        <div class="col-md-12 animate__animated animate__fadeIn mt-3">

            <div class="card card-default shadow-sm">

                <div class="card-body">

                    <div class="form-group row">

                        <label for="NomeDaClasses" class="col-sm-2 col-form-label">Nome da Classes</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="NomeDaClasses" v-model="inputs.name">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="NomeDaClasses" class="col-sm-2 col-form-label">NameSpace</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="NameSpace" v-model="inputs.name_space">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="DescricaoDaClasses" class="col-sm-2 col-form-label">Descrição da Classes</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="DescricaoDaClasses" v-model="inputs.description">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="TableName" class="col-sm-2 col-form-label">

                            Nome da tabela

                        </label>

                        <div class="col-sm-10">

                            <select id="TableName" class="custom-select form-control" v-model="inputs.table_name">

                                <option v-bind:value="result.TABLE_NAME" v-for="(result, index) in query.result.tables" v-bind:key="index">

                                    {{ result.TABLE_NAME }}

                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <hr>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="Version" class="col-form-label">Versão</label>

                                <input type="text" class="form-control" id="Version" v-model="inputs.version" disabled>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="Release" class="col-form-label">Release</label>

                                <input type="text" class="form-control" id="Release" v-model="inputs.release" disabled>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="Situation" class="col-form-label">Situação</label>

                                <select id="Situation" class="custom-select form-control" v-model="inputs.situation_id">

                                    <option v-bind:value="result.situation_id" v-for="(result, index) in query.result.situations" v-bind:key="index">

                                        {{ result.name }}

                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="card shadow-sm">

                                <div class="card-body">

                                    <h5 class="card-title">

                                        Hirearquia de pastas cadastradas

                                    </h5>

                                    <div class="form-group">

                                        <ul class="list-unstyled">

                                            <li class="media mb-4" v-for="(result, index) in query.result.folders" v-bind:key="index">

                                                <div class="media-body">

                                                    <h5 class="mt-0">

                                                        Pasta Principal

                                                    </h5>

                                                    <div class="custom-control custom-radio">

                                                        <input type="radio" class="custom-control-input" v-bind:id="'folder_' + result.folder_id" v-model="inputs.folder_id" v-bind:value="result.folder_id" />

                                                        <label class="custom-control-label" v-bind:for="'folder_' + result.folder_id">

                                                            {{ result.name }}

                                                        </label>

                                                    </div>

                                                    <div v-for="(result_auxiliary, index_auxiliary) in query.result.folders_auxiliary" v-bind:key="index_auxiliary">

                                                        <div class="media ml-3 mt-3" v-if="result_auxiliary.folder_auxiliary_id === result.folder_id">

                                                            <div class="media-body">

                                                                <h6 class="mt-0">

                                                                    Sub Pasta

                                                                </h6>

                                                                <div class="custom-control custom-radio">

                                                                    <input type="radio" class="custom-control-input" v-bind:id="'folder_auxiliary_' + result_auxiliary.folder_id" v-model="inputs.folder_id" v-bind:value="result_auxiliary.folder_id"/>

                                                                    <label class="custom-control-label" v-bind:for="'folder_auxiliary_' + result_auxiliary.folder_id">

                                                                        {{ result_auxiliary.name }}

                                                                    </label>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <hr>

                                            </li>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-12 text-right mt-3">

                            <div class="form-group">

                                <div class="btn btn btn-primary" v-on:click="Save()">

                                    Salvar

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

    export default {

        /** Nome do componente atual **/
        name: "ClassesForm",

        data(){

            return {

                /** Campos do formulário **/
                inputs : {

                    class_id : this.$route.params.class_id,
                    situation_id : null,
                    user_id : null,
                    project_id : this.$route.params.project_id,
                    folder_id : null,
                    name : null,
                    name_space : null,
                    description : null,
                    version : null,
                    release : null,
                    table_name : null,
                    date_register : null,
                    date_update : null,

                },

                query : {

                    result : {

                        error : [],
                        situations : [],
                        folders : [],
                        count_folders : 0,
                        folders_auxiliary : [],
                        count_folders_auxiliary : 0,
                        tables : [],

                    }

                }

            }

        },

        methods : {

            /** Método para salvar registro **/
            Save(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_SAVE',{

                    inputs : this.inputs

                })

                /** Caso tenha sucesso **/
                    .then(response => {

                        /** Verificação do retorno **/
                        switch (response.data.cod){

                            case 0:

                                this.query.result.error = response.data.result;
                                break;

                            case 1:

                                this.$router.replace({name : 'classes-datagrid'});
                                break;

                            case 404:

                                location.reload();
                                break;

                        }

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Método para editar o registro **/
            EditForm(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_EDIT_FORM',{

                    inputs : this.inputs

                })

                /** Caso tenha sucesso **/
                    .then(response => {

                        this.inputs = response.data.result;

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Método para listar registros **/
            ListSituations(){

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=SITUATIONS&ACTION=SITUATIONS_DATAGRID')

                /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.situations = response.data.result;

                    })

                    /** Caso tenha erro **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Método para listar registros **/
            ListFolders(){

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=FOLDERS&ACTION=FOLDERS_DATAGRID', {

                    inputs : this.inputs,

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.folders = response.data.result;
                        this.query.result.count_folders = response.data.result.length;

                    })

                    /** Caso tenha erro **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Método para listar registros **/
            ListFoldersAuxiliary(){

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=FOLDERS_AUXILIARY&ACTION=FOLDERS_AUXILIARY_ALL', {

                    inputs : this.inputs,

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.folders_auxiliary = response.data.result;
                        this.query.result.count_folders_auxiliary = response.data.result.length;

                    })

                    /** Caso tenha erro **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Método para listar registros **/
            ListTables(){

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_FIND_TABLES', {

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.tables = response.data.result;

                    })

                    /** Caso tenha erro **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

        },

        mounted(){

            /** Verifico se é cadastro ou alteração **/
            if (this.$route.params.class_id > 0){

                this.EditForm();

            }

            this.ListSituations();
            this.ListFolders();
            this.ListFoldersAuxiliary();
            this.ListTables();

        }

    }

</script>