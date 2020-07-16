<template>

    <div class="col-md-12 animate__animated animate__fadeIn">

        <div class="row">

            <div class="col-md-3 mb-3">

                <div class="card card-default shadow-sm" v-if="!controls.form">

                    <div class="card-body">

                        <h5 class="card-title">

                            <span class="badge badge-warning mr-1">

                                <i class="far fa-folder-open"></i>

                            </span>

                            Cadastrar

                        </h5>

                        <h6 class="card-subtitle text-white-50 mb-2">

                            Pasta

                        </h6>

                    </div>

                    <nav class="navbar navbar-footer navbar-expand-lg navbar-dark bg-transparent card-footer">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_folder_form" aria-controls="navbar_folder_form" aria-expanded="false">

                            <span class="navbar-toggler-icon"></span>

                        </button>

                        <div class="collapse navbar-collapse" id="navbar_folder_form">

                            <ul class="navbar-nav mr-auto">

                                <li class="nav-item">

                                    <a class="nav-link" type="button" v-on:click="Form()">

                                        <i class="fas fa-plus-circle"></i>

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </nav>

                </div>

                <div class="card card-default shadow-sm" v-else>

                    <div class="card-body">

                        <h5 class="card-title">

                            <span class="badge badge-warning mr-1">

                                <i class="far fa-folder-open"></i>

                            </span>

                            Formulário

                        </h5>

                        <div class="input-group">

                            <input type="text" class="form-control" placeholder="Nome" aria-label="Nome" aria-describedby="button-addon2" v-model="inputs.name">

                            <div class="input-group-append">

                                <button class="btn btn-default" type="button" id="button-addon2" v-on:click="Save()">

                                    Salvar

                                </button>

                            </div>

                        </div>

                    </div>

                    <nav class="navbar navbar-footer navbar-expand-lg navbar-dark bg-transparent card-footer">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_folder_form_2" aria-controls="navbar_folder_form_2" aria-expanded="false">

                            <span class="navbar-toggler-icon"></span>

                        </button>

                        <div class="collapse navbar-collapse" id="navbar_folder_form_2">

                            <ul class="navbar-nav mr-auto">

                                <li class="nav-item">

                                    <a class="nav-link" type="button" v-on:click="Form()">

                                        <i class="fas fa-ban"></i>

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </nav>

                </div>

            </div>

            <div class="col-md-3 mb-3" v-for="(result, index) in query.result" v-bind:key="index">

                <div class="card card-default shadow-sm">

                    <div class="card-body">

                        <h5 class="card-title">

                                <span class="badge badge-primary mr-1">

                                    <i class="far fa-folder-open mr-1"></i>{{ result.folder_id }}

                                </span>

                            {{ result.name }}

                        </h5>

                        <h6 class="card-subtitle text-white-50 mb-2">

                            Pasta

                        </h6>

                    </div>

                    <nav class="navbar navbar-footer navbar-expand-lg navbar-dark bg-transparent card-footer">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" v-bind:data-target="'#navbar_folder_' + result.folder_id" v-bind:aria-controls="'navbar_folder_' + result.folder_id" aria-expanded="false">

                            <span class="navbar-toggler-icon"></span>

                        </button>

                        <div class="collapse navbar-collapse" v-bind:id="'navbar_folder_' + result.folder_id">

                            <ul class="navbar-nav mr-auto">

                                <li class="nav-item">

                                    <a class="nav-link" type="button" v-on:click="Delete(result.folder_id)">

                                        <i class="fas fa-fire-alt"></i>

                                    </a>

                                </li>

                                <li class="nav-item">

                                    <router-link v-bind:to="{name : 'folders-form', params : {folder_id : result.folder_id}}" class="nav-link">

                                        <i class="fas fa-pencil-alt"></i>

                                    </router-link>

                                </li>

                                <li class="nav-item">

                                    <router-link to="/methods/datagrid/" class="nav-link" href="#">

                                        <i class="far fa-eye"></i>

                                    </router-link>

                                </li>

                                <li class="nav-item">

                                    <router-link to="/classes/detail" class="nav-link" href="#">

                                        <i class="fa fa-search"></i>

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

        data (){

            return {

                controls : {

                    form : false,

                },

                inputs : {

                    folder_id : null,
                    name : null,
                    date_register : null,
                    date_update : null,

                },

                /** Grupo de variavei s para guardar consultas sql's **/
                query : {

                    result : [],

                }

            }

        },

        methods : {

            /** Controle do formulário **/
            Form(){

                /** Verifico se o formulário esta ativo **/
                if (this.controls.form){

                    /** Oculto o formulário **/
                    this.controls.form = false;

                }else{

                    /** Exibo o formulário **/
                    this.controls.form = true;

                }

            },

            /** Método para listar registros **/
            List(){

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=FOLDERS&ACTION=FOLDERS_DATAGRID')

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result = response.data.result;

                    })

                    /** Caso tenha erro **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            Save(){

                axios.post('router.php?TABLE=FOLDERS&ACTION=FOLDERS_SAVE', {

                    inputs : this.inputs

                })

                    .then(response => {

                        this.List();
                        this.Form();
                        console.log('Sucesso -> ' + response.data);

                    })

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