<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Projetos/ <span class="badge badge-primary">Formulário</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item" v-if="inputs.project_id > 0">

                        <router-link v-bind:to="{name : 'projects-history', params : { project_id : inputs.project_id }}" class="nav-link">

                            <i class="fas fa-history mr-1"></i>Histórico

                        </router-link>

                    </li>

                    <li class="nav-item">

                        <router-link to="/" class="nav-link">

                            <i class="fa fa-bars mr-1"></i>Listagem

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

            <div class="card card-default shadow-sm animate__animated animate__fadeIn mb-2" v-if="query.result.error.length > 0">

                <div class="card-body">

                    <h4 class="card-title">

                        <span class="badge badge-danger">Ops!</span> Alguns erros foram encontrados...

                    </h4>

                    <h6 class="card-subtitle">

                        Verifique os itens para prosseguir

                    </h6>

                    <hr>

                    <ul class="list-unstyled">

                        <li class="media" v-for="(result, index) in query.result.error" v-bind:key="index">

                            <div class="media-body">

                                {{ result }}

                            </div>

                        </li>

                    </ul>

                </div>

            </div>

            <div class="card card-default shadow-sm animate__animated animate__fadeIn mb-2" v-if="query.result.success.length > 0">

                <div class="card-body">

                    <h4 class="card-title">

                        <span class="badge badge-success">Ops!</span> Sucesso...

                    </h4>

                    <h6 class="card-subtitle">

                        Verifique os itens para prosseguir

                    </h6>

                    <hr>

                    <ul class="list-unstyled">

                        <li class="media" v-for="(result, index) in query.result.success" v-bind:key="index">

                            <div class="media-body">

                                {{ result }}

                            </div>

                        </li>

                    </ul>

                </div>

            </div>

            <div class="card card-default shadow-sm animate__animated animate__fadeIn">

                <div class="card-body">

                    <div class="form-group row">

                        <label for="NomeDoProjeto" class="col-sm-2 col-form-label">Nome do Projeto</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="NomeDoProjeto" v-model="inputs.name">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="DescricaoDoProjeto" class="col-sm-2 col-form-label">Descrição do Projeto</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="DescricaoDoProjeto"  v-model="inputs.description">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="CaminhoParaSalvarOProjeto" class="col-sm-2 col-form-label">Caminho para Salvar o Projeto</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="CaminhoParaSalvarOProjeto" v-model="inputs.path">

                        </div>

                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-group">

                                <label for="CaminhoDoBancoDeDados" class="col-form-label">Caminho do Banco de Dados</label>

                                <input type="text" class="form-control" id="CaminhoDoBancoDeDados" v-model="inputs.database_local">

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="NomeDoBancoDeDados" class="col-form-label">

                                    Nome do Banco de Dados

                                </label>

                                <div class="input-group mb-3">

                                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" id="NomeDoBancoDeDados" v-model="inputs.database_name">

                                    <div class="input-group-append">

                                        <button class="btn btn-outline-primary" type="button" id="button-addon2" v-on:click="TestConnection()">

                                            Testar Conexão

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="UsuarioDoBancoDeDados" class="col-form-label">Usuário do Banco de Dados</label>

                                <input type="text" class="form-control" id="UsuarioDoBancoDeDados" v-model="inputs.database_user">

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="SenhaDoBancoDeDados" class="col-form-label">Senha do Banco de Dados</label>

                                <input type="password" class="form-control" id="SenhaDoBancoDeDados" v-model="inputs.database_password">

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="Version" class="col-form-label">Versão</label>

                                <input type="text" class="form-control" id="Version" v-model="inputs.version" readonly>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="Release" class="col-form-label">Release</label>

                                <input type="text" class="form-control" id="Release" v-model="inputs.release" readonly>

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

                        <div class="col-md-4">

                            <div class="form-group">

                                <div class="custom-control custom-checkbox">

                                    <input type="checkbox" class="custom-control-input" id="GerarClassesAutomaticamente" v-model="inputs.generate_classes">

                                    <label class="custom-control-label" for="GerarClassesAutomaticamente">

                                        Gerar Classes Automaticamente

                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <div class="custom-control custom-checkbox" v-if="inputs.generate_classes">

                                    <input type="checkbox" class="custom-control-input" id="GerarMetodosAutomaticamente" v-model="inputs.generate_methods">

                                    <label class="custom-control-label" for="GerarMetodosAutomaticamente">

                                        Gerar Métodos Automaticamente

                                    </label>

                                </div>

                                <div class="custom-control custom-checkbox" v-else>

                                    <input type="checkbox" class="custom-control-input" id="GerarMetodosAutomaticamente" disabled>

                                    <label class="custom-control-label" for="GerarMetodosAutomaticamente">

                                        Gerar Métodos Automaticamente

                                    </label>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-12" v-if="query.result.tables.length > 0">

                            <div class="card shadow-sm">

                                <div class="card-body">

                                    <h5 class="card-title">

                                        <span class="badge badge-primary">Listagem de Tabela do Banco de Dados</span>

                                    </h5>

                                    <ul class="list-unstyled">

                                        <li class="media" v-for="(table, index) in query.result.tables" v-bind:key="index">

                                            <div class="media-body">

                                                <h5 class="mt-0 mb-1">

                                                    {{ table.TABLE_NAME }}

                                                </h5>

                                                {{ table.TABLE_TYPE }}

                                            </div>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-12 animate__animated animate__fadeIn" v-if="query.result.methods_templates.length > 0 && inputs.generate_classes && inputs.generate_methods">

                            <div class="card shadow-sm">

                                <div class="card-body">

                                    <h5 class="card-title">

                                        <span class="badge badge-primary">

                                            Métodos Disponiveis para Gerar

                                        </span>

                                    </h5>

                                    <div class="form-group" v-for="(result, index) in query.result.methods_templates" v-bind:key="index">

                                        <div class="custom-control custom-checkbox">

                                            <input type="checkbox" class="custom-control-input" v-bind:id="'check_method_template_' + result.method_template_id" v-on:click="AddOrRemoveMethodTemplateId(result.method_template_id)">

                                            <label class="custom-control-label" v-bind:for="'check_method_template_' + result.method_template_id">

                                                {{ result.name }}

                                            </label>

                                            -

                                            <span class="text-muted">

                                                <small>

                                                    {{ result.description }}

                                                </small>

                                            </span>

                                        </div>

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
        name: "ProjectsForm",

        data(){

            return {

                /** Campos do formulário **/
                inputs : {

                    project_id : this.$route.params.project_id,
                    situation_id : null,
                    user_id : null,
                    name : null,
                    description : null,
                    version : null,
                    release : null,
                    database_local : null,
                    database_name : null,
                    database_user : null,
                    database_password : null,
                    path : null,
                    date_register : null,
                    date_update : null,

                    /** Controlle de envio */
                    generate_classes : false,
                    generate_methods : false,

                },

                method_template : {

                    id : [],

                },

                query : {

                    result : {

                        error : [],
                        success : [],
                        situations : [],
                        tables : [],
                        methods_templates : [],

                    }

                },

                controls : {

                    progress_bar : false,

                }

            }

        },

        methods : {

            /** Adiciono ou removo um elemento da array **/
            AddOrRemoveMethodTemplateId(method_template_id){

                /** Verifico se existe o elemento na array **/
                if (this.method_template.id.indexOf(method_template_id) > -1){

                    /** Removo o elemento da array **/
                    this.method_template.id.splice(this.method_template.id.indexOf(method_template_id), 1);

                }else{

                    /** Adiciono elemento na array **/
                    this.method_template.id.push(method_template_id);

                }

            },

            /** Testar conexão */
            TestConnection()
            {

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Limpo as mensagens retornadas anteriormente */
                this.query.result.error = [];
                this.query.result.success = [];

                /** Envio de requisição **/
                axios.post('router.php?TABLE=PROJECTS&ACTION=PROJECTS_TEST_CONNECTION',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso */
                    .then(response => {

                        /** Verificação do retorno **/
                        switch (response.data.cod){

                            /** Erro **/
                            case 0:

                                /** Guardo a mensagem de erro */
                                this.query.result.error = response.data.result;
                                break;

                            /** Sucesso **/
                            case 1:

                                /** Pego os resultados retornados */
                                this.query.result.success = response.data.result;

                                /** Listo a tabelas existente*/
                                this.FindTables();
                                break;

                            /** Usuário não autenticado **/
                            case 404:

                                /** Recarrego a página **/
                                location.reload();
                                break;

                        }

                        /** Defino um delay */
                        window.setTimeout(() => {

                            /** Desabilito a barra de progresso */
                            this.controls.progress_bar = false;

                        }, 1000);

                    })

                    /** Caso tenha erro */
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Listar Tabelas */
            FindTables()
            {

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_FIND_TABLES_PROJECT',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso */
                    .then(response => {

                        /** Verificação do retorno **/
                        switch (response.data.cod){

                            /** Erro **/
                            case 0:

                                /** Guardo a mensagem de erro */
                                this.query.result.error = response.data.result;

                                /** Defino um delay */
                                window.setTimeout(() => {

                                    /** Desabilito a barra de progresso */
                                    this.controls.progress_bar = false;

                                }, 1000);
                                break;

                            /** Sucesso **/
                            case 1:

                                /** Guardo os resultados retornados */
                                this.query.result.tables = response.data.result;

                                /** Defino um delay */
                                window.setTimeout(() => {

                                    /** Desabilito a barra de progresso */
                                    this.controls.progress_bar = false;

                                }, 1000);
                                break;

                            /** Usuário não autenticado **/
                            case 404:

                                /** Recarrego a página **/
                                location.reload();
                                break;

                        }

                        /** Defino um delay */
                        window.setTimeout(() => {

                            /** Desabilito a barra de progresso */
                            this.controls.progress_bar = false;

                        }, 1000);

                    })

                    /** Caso tenha erro */
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Método para salvar registro **/
            Save(){

                /** habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Limpo as mensagens retornadas anteriormente */
                this.query.result.error = [];
                this.query.result.success = [];

                /** Envio de requisição **/
                axios.post('router.php?TABLE=PROJECTS&ACTION=PROJECTS_SAVE',{
                    inputs : this.inputs,
                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Verificação do retorno **/
                        switch (response.data.cod){

                            /** Erro **/
                            case 0:

                                this.query.result.error = response.data.result;
                                break;

                            /** Sucesso **/
                            case 1:

                                /** Verifica se deve gerar classes automaticamente **/
                                if (this.inputs.generate_classes){

                                    /** Executo o método para gerar classes automaticamente **/
                                    this.SaveClasses(response.data.project_id, this.inputs.database_name, this.inputs.generate_methods);

                                }else {

                                    /** Realizo o redirecionamento **/
                                    this.$router.replace({name : 'projects-datagrid'});

                                }
                                break;

                            /** Usuário não autenticado **/
                            case 404:

                                /** Recarrego a página **/
                                location.reload();
                                break;

                        }

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

            /** Método para salvar registro **/
            SaveClasses(project_id, database_name, generate_methods){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                this.inputs.project_id = project_id;
                this.inputs.database_name = database_name;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_GENERATE_SAVE',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Verificação do retorno **/
                        switch (response.data.cod){

                            /** Erro **/
                            case 0:

                                this.query.result.error = response.data.result;
                                break;

                            /** Sucesso **/
                            case 1:

                                /** Verifico se vai gerar o métodos automaticamente */
                                if (generate_methods){

                                    /** Gero os métodos automaticamente */
                                    this.SaveMethods(response.data.classes, response.data.tables);

                                }else {

                                    /** Redirecionamento de rots */
                                    this.$router.replace({name : 'projects-datagrid'});

                                }
                                break;

                            /** Usuário não autenticado **/
                            case 404:

                                location.reload();
                                break;

                        }

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

            /** Método para salvar registro **/
            SaveMethods(classes, tables){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                this.inputs.classes = classes;
                this.inputs.tables = tables;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_GENERATE_SAVE',{

                    inputs : this.inputs,
                    method_template : this.method_template

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Verificação do retorno **/
                        switch (response.data.cod){

                            /** Erro **/
                            case 0:

                                /** Guardo os dados de erros */
                                this.query.result.error = response.data.result;
                                break;

                            /** Sucesso **/
                            case 1:

                                /** Redirecionamento de rotas */
                                this.$router.replace({name : 'projects-datagrid'});
                                break;

                            /** Usuário não autenticado **/
                            case 404:

                                location.reload();
                                break;

                        }

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

            /** Método para editar o registro **/
            EditForm(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=PROJECTS&ACTION=PROJECTS_EDIT_FORM',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Guardo os dados */
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

            /** Método para listar registros **/
            ListSituations(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=SITUATIONS&ACTION=SITUATIONS_DATAGRID')

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Guardo os dados */
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

            /** Método para listar registros **/
            ListMethodsTemplates(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=METHODS_TEMPLATE&ACTION=METHODS_TEMPLATE_DATAGRID')

                    /** Caso tenha sucesso **/
                    .then(response => {

                        /** Guardo os dados */
                        this.query.result.methods_templates = response.data.result;

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
            if (this.$route.params.project_id > 0){

                this.EditForm();

            }

            /** Listagem de registros */
            this.ListMethodsTemplates();
            this.ListSituations();

        }

    }

</script>