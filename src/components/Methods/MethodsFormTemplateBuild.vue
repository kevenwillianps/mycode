<template>

    <div class="row">

        <div class="col-md-6 animate__animated animate__fadeIn">

            <h4>

                <i class="far fa-folder-open mr-1"></i>Projetos/Classes/Métodos/Template de Métodos/ <span class="badge badge-primary">Gerar</span>

            </h4>

        </div>

        <div class="col-md-6 text-right animate__animated animate__fadeIn">

            <h4>

                <router-link to="/methods/datagrid" class="btn btn-primary">

                    Listagem

                </router-link>

            </h4>

        </div>

        <div class="col-md-12 mt-3">

            <div class="row">

                <div class="col-md-3" v-for="(result, index) in query.result.methods_template" v-bind:key="index">

                    <div class="card card-default shadow-sm">

                        <div class="card-body">

                            <h4 class="card-title">

                                {{ result.name }}

                            </h4>

                            <h6 class="card-subtitle">

                                {{ result.description }}

                            </h6>

                            <p class="card-text">

                                {{ result.code }}

                            </p>

                            <div class="btn-group-toggle" data-toggle="buttons">

                                <label class="btn btn-outline-primary active" v-bind:for="'check_' + result" v-on:click="AddOrRemoveMethodTemplateId(result.method_template_id)">

                                    <input type="checkbox" v-bind:id="'check_' + result"> Marcar

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-12 text-right">

                    <button class="btn btn-primary" v-on:click="Save()">

                        Gerar

                    </button>

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
        name: "MethodsFormTemplateBuild",

        data(){

            return{

                inputs : {

                    project_id : this.$route.params.project_id,
                    class_id : this.$route.params.class_id,
                    method_id : this.$route.params.method_id,
                    method_template_id : [],

                },

                query : {

                    result : {

                        methods_template : [],

                    }

                }

            }

        },

        methods : {

            /** Adiciono ou removo um elemento da array **/
            AddOrRemoveMethodTemplateId(method_template_id){

                /** Verifico se existe o elemento na array **/
                if (this.inputs.method_template_id.indexOf(method_template_id) > -1){

                    /** Removo o elemento da array **/
                    this.inputs.method_template_id.splice(this.inputs.method_template_id.indexOf(method_template_id), 1);

                }else{

                    /** Adiciono elemento na array **/
                    this.inputs.method_template_id.push(method_template_id);

                }

            },

            /** Método para salvar registro **/
            Save(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_FORM_TEMPLATE_BUILD',{

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

            /** Listagem de registros **/
            ListMethodsTemplate(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS_TEMPLATE&ACTION=METHODS_TEMPLATE_DATAGRID')

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.methods_template = response.data.result;

                        /** Decodifico o código */
                        for (let i = 0; i < response.data.result.length; i++){

                            this.query.result.methods_template[i].code = atob(this.query.result.methods_template[i].code);

                        }

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

        },

        mounted(){

            this.ListMethodsTemplate();

        }

    }
</script>