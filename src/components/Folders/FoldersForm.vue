<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Projeto/Classes/Pastas/ <span class="badge badge-primary">Formulário</span>

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

        <div class="col-md-12 mt-3" v-else>

            <div class="card card-default animate__animated animate__fadeIn shadow-sm">

                <div class="card-body">

                    <div class="form-group row">

                        <label for="NomeDeUsuario" class="col-sm-2 col-form-label">Nome</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="NomeDeUsuario" v-model="inputs.name">

                        </div>

                    </div>

                    <div class="form-group text-right">

                        <div class="btn btn btn-primary" v-on:click="Save()">

                            Salvar

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
        name: "FoldersForm",

        data(){

            return{

                inputs : {

                    folder_id : this.$route.params.folder_id,
                    project_id : this.$route.params.project_id,
                    name : null,
                    date_register : null,
                    date_update : null,

                },

                controls : {

                    progress_bar : false,

                }

            }

        },

        methods : {

            Save(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                axios.post('router.php?TABLE=FOLDERS&ACTION=FOLDERS_SAVE', {

                    inputs : this.inputs

                })

                    .then(response => {

                        /** Redirecionamento de rota */
                        this.$router.replace({

                            name : 'classes-datagrid',
                            params : {

                                project_id : this.inputs.project_id,

                            }

                        });

                        console.log(response);

                        /** Defino um delay */
                        window.setTimeout(() => {

                            /** Desabilito a barra de progresso */
                            this.controls.progress_bar = false;

                        }, 1000);

                    })

                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Método para editar o registro **/
            EditForm(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=FOLDERS&ACTION=FOLDERS_EDIT_FORM',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.inputs = response.data.result;

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

        },

        mounted(){

            /** Verifico se é cadastro ou alteração **/
            if (this.$route.params.folder_id > 0){

                this.EditForm();

            }

            /** Listagem de registros */
            this.ListSituations();

        }

    }

</script>