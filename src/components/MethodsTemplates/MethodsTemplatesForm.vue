<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Template de Métodos/ <span class="badge badge-primary">Formulário</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <router-link to="/methods/templates/datagrid" class="nav-link">

                            <i class="fa fa-bars mr-1"></i>Listagem

                        </router-link>

                    </li>

                </ul>

            </div>

        </nav>

        <div class="col-md-12 animate__animated animate__fadeIn mt-3">

            <div class="card card-default shadow-sm">

                <div class="card-body">

                    <div class="form-group row">

                        <label for="NomeDaClasses" class="col-sm-2 col-form-label">

                            Nome do Método

                        </label>

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

                            <a type="button" class="btn btn-primary btn-block" data-toggle="collapse" href="#marking" role="button" aria-expanded="false" aria-controls="marking">

                                Marcações

                            </a>

                            <div class="collapse mt-3" id="marking">

                                <div class="card shadow-sm">

                                    <div class="card-body">

                                        <ul class="list-unstyled">

                                            <li class="media">

                                                <div class="media-body">

                                                    <h5 class="mt-0 mb-1">

                                                        <span class="badge badge-primary">

                                                            [primary_key]

                                                        </span>

                                                    </h5>

                                                    <h6 class="mt-0 mb-1">

                                                        Chave primária

                                                    </h6>

                                                    <p>

                                                        Exemplo.: $chave_primaria;

                                                    </p>

                                                </div>

                                            </li>

                                            <li class="media">

                                                <div class="media-body">

                                                    <h5 class="mt-0 mb-1">

                                                        <span class="badge badge-primary">

                                                            [inputs_parameters_method]

                                                        </span>

                                                    </h5>

                                                    <h6 class="mt-0 mb-1">

                                                        Parâmetros de entrada do método

                                                    </h6>

                                                    <p>

                                                        Exemplo.: $this->chave_primari = $chave_primaria;

                                                    </p>

                                                </div>

                                            </li>

                                            <li class="media">

                                                <div class="media-body">

                                                    <h5 class="mt-0 mb-1">

                                                        <span class="badge badge-primary">

                                                            [sql_insert]

                                                        </span>

                                                    </h5>

                                                    <h6 class="mt-0 mb-1">

                                                        Sql de insert

                                                    </h6>

                                                    <p>

                                                        Exemplo.: 'INSERT INTO tabela (coluna_1, coluna_2) VALUES ('valor_', 'valor_2');'

                                                    </p>

                                                </div>

                                            </li>

                                            <li class="media">

                                                <div class="media-body">

                                                    <h5 class="mt-0 mb-1">

                                                        <span class="badge badge-primary">

                                                            [sql_update]

                                                        </span>

                                                    </h5>

                                                    <h6 class="mt-0 mb-1">

                                                        Sql de update

                                                    </h6>

                                                    <p>

                                                        Exemplo.: 'UPDATE tabela SET coluna_1 = "valor_1";'

                                                    </p>

                                                </div>

                                            </li>

                                            <li class="media">

                                                <div class="media-body">

                                                    <h5 class="mt-0 mb-1">

                                                        <span class="badge badge-primary">

                                                            [sql_select]

                                                        </span>

                                                    </h5>

                                                    <h6 class="mt-0 mb-1">

                                                        Sql de select

                                                    </h6>

                                                    <p>

                                                        Exemplo.: 'SELECT * FROM tabela;'

                                                    </p>

                                                </div>

                                            </li>

                                            <li class="media">

                                                <div class="media-body">

                                                    <h5 class="mt-0 mb-1">

                                                        <span class="badge badge-primary">

                                                            [sql_delete]

                                                        </span>

                                                    </h5>

                                                    <h6 class="mt-0 mb-1">

                                                        Sql de delete

                                                    </h6>

                                                    <p>

                                                        Exemplo.: 'DELETE FROM tabela WHERE chave_primari = 1;'

                                                    </p>

                                                </div>

                                            </li>

                                            <li class="media">

                                                <div class="media-body">

                                                    <h5 class="mt-0 mb-1">

                                                        <span class="badge badge-primary">

                                                            [inputs_parameters]

                                                        </span>

                                                    </h5>

                                                    <h6 class="mt-0 mb-1">

                                                        Parâmetros de entrada

                                                    </h6>

                                                    <p>

                                                        Exemplo.: $parametro_1, $parametro_2, $parametro_3, $parametro_4

                                                    </p>

                                                </div>

                                            </li>

                                            <li class="media">

                                                <div class="media-body">

                                                    <h5 class="mt-0 mb-1">

                                                        <span class="badge badge-primary">

                                                            [default_parameters_class]

                                                        </span>

                                                    </h5>

                                                    <h6 class="mt-0 mb-1">

                                                        Parâmetros da classe

                                                    </h6>

                                                    <p>

                                                        Exemplo.: private $chave_primaria;

                                                    </p>

                                                </div>

                                            </li>

                                            <li class="media">

                                                <div class="media-body">

                                                    <h5 class="mt-0 mb-1">

                                                        <span class="badge badge-primary">

                                                            [bind_param]

                                                        </span>

                                                    </h5>

                                                    <h6 class="mt-0 mb-1">

                                                        Bind Params

                                                    </h6>

                                                    <p>

                                                        Exemplo.: $this->stmt->bindParam(':chave_primaria', $this->chave_primaria);

                                                    </p>

                                                </div>

                                            </li>

                                        </ul>

                                    </div>

                                </div>

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