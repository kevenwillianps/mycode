<template>

    <div>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Projetos/Classes/Métodos/ <span class="badge badge-primary">Formulário</span>

                </h4>

            </div>

            <div class="col-md-6 text-right animate__animated animate__fadeIn">

                <h4>

                    <router-link to="/methods/datagrid" class="btn btn-primary">

                        Listagem

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12 animate__animated animate__fadeIn">

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

                                    <input type="text" class="form-control" id="Version" v-model="inputs.version">

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="Release" class="col-form-label">Release</label>

                                    <input type="text" class="form-control" id="Release" v-model="inputs.release">

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

    </div>

</template>

<script type="text/ecmascript-6">

    /** Importação de componentes **/
    import axios from 'axios';

    export default {

        /** Nome do componente atual **/
        name: "MethodsTemplateForm",

        data(){

            return{

                inputs : {

                    method_template_id : this.$route.params.method_template_id,
                    situation_id : null,
                    user_id : null,
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

                }

            }

        },

        methods : {

            /** Método para salvar registro **/
            Save(){

                /** Criptografo em base64 o código escrito **/
                this.inputs.code = btoa(this.inputs.code);

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS_TEMPLATE&ACTION=METHODS_TEMPLATE_SAVE',{

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

                                this.$router.replace({name : 'methods-templates-datagrid'});
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
                axios.post('router.php?TABLE=METHODS_TEMPLATE&ACTION=METHODS_TEMPLATE_EDIT_FORM',{

                    inputs : this.inputs

                })

                /** Caso tenha sucesso **/
                    .then(response => {

                        this.inputs = response.data.result;
                        /** Descriptografo em base64 o código escrito **/
                        this.inputs.code = atob(this.inputs.code);

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

        },

        mounted(){

            /** Verifico se é cadastro ou alteração **/
            if (this.$route.params.method_template_id > 0){

                this.EditForm();

            }

            this.ListSituations();

        }

    }
</script>