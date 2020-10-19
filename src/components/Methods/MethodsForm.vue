<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Projetos/Classes/Métodos/ <span class="badge badge-primary">Formulário</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item" v-if="inputs.method_id > 0">

                        <router-link v-bind:to="{name : 'methods-history', params : { project_id : inputs.project_id, class_id : inputs.class_id, method_id : inputs.method_id }}" class="nav-link">

                            <i class="fas fa-history mr-1"></i>Histórico

                        </router-link>

                    </li>

                    <li class="nav-item">

                        <router-link v-bind:to="{name : 'methods-datagrid', params : { project_id : inputs.project_id, class_id : inputs.class_id, method_id : 0}}" class="nav-link">

                            <i class="fas fa-bars mr-1"></i> Listagem

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

            <div class="card card-default shadow-sm">

                <div class="card-body">

                    <div class="form-group row">

                        <label for="NomeDaClasses" class="col-sm-2 col-form-label">Nome do Método</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="NomeDaClasses" v-model="inputs.name">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="DescricaoDaClasses" class="col-sm-2 col-form-label">Descrição do Método</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="DescricaoDaClasses" v-model="inputs.description">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="VisibilidadeDoMetodo" class="col-sm-2 col-form-label">Visibilidade do Método</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="VisibilidadeDoMetodo" v-model="inputs.type">

                        </div>

                    </div>

                    <hr>

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

                            <div class="form-group">

                                <label for="CaminhoDoBancoDeDados" class="col-form-label">Código do Método</label>

                                <textarea class="form-control" id="CaminhoDoBancoDeDados" rows="5" v-model="inputs.code"></textarea>

                            </div>

                        </div>

                    </div>

                    <div class="form-group text-right" v-on:click="Save()">

                        <div class="btn btn btn-primary">

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
        name: "MethodsForm",

        data(){

            return{

                inputs : {

                    method_id : this.$route.params.method_id,
                    situation_id : null,
                    user_id : null,
                    class_id : this.$route.params.class_id,
                    name : null,
                    description : null,
                    type : null,
                    code : null,
                    version : null,
                    release : null,
                    date_register : null,
                    date_update : null,

                },

                query : {

                    result : {

                        situations : [],

                    }

                },

                controls : {

                    progress_bar : false,

                }

            }

        },

        methods : {

            /** Método para salvar registro **/
            Save(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Criptografo em base64 o código escrito **/
                this.inputs.code = btoa(this.inputs.code);

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_SAVE',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Verificação do retorno **/
                        switch (response.data.cod){

                            case 0:

                                /** Guardo a mensagem de erro */
                                this.query.result.error = response.data.result;

                                /** Defino um delay */
                                window.setTimeout(() => {

                                    /** Desabilito a barra de progresso */
                                    this.controls.progress_bar = false;

                                }, 1000);
                                break;

                            case 1:

                                /** Defino um delay */
                                window.setTimeout(() => {

                                    /** Redirecionamento de rota */
                                    this.$router.replace({name : 'methods-datagrid', params : {project_id : this.inputs.project_id, class_id : this.inputs.class_id }});

                                    /** Desabilito a barra de progresso */
                                    this.controls.progress_bar = false;

                                }, 1000);
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

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_EDIT_FORM',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Guardo o resultado */
                        this.inputs = response.data.result;

                        /** Descriptografo em base64 o código escrito **/
                        this.inputs.code = atob(this.inputs.code);

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

            /** Método para listar registros **/
            ListSituations(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=SITUATIONS&ACTION=SITUATIONS_DATAGRID')

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Guardo o resultado */
                        this.query.result.situations = response.data.result;

                        /** Defino um delay */
                        window.setTimeout(() => {

                            /** Desabilito a barra de progresso */
                            this.controls.progress_bar = false;

                        }, 1000);

                    })

                    /** Caso tenha erro **/
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

            this.ListSituations();

        }

    }
</script>