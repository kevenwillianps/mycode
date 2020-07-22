<template>

    <div>

        <ModalConfirm title="Atenção!" message="Deseja excluir este registro ?" v-on:ConfirmRequest="Delete"></ModalConfirm>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Projetos/Classes/Métodos/ <span class="badge badge-primary">Listagem</span>

                </h4>

            </div>

            <div class="col-md-6 text-right animate__animated animate__fadeIn">

                <h4>

                    <router-link v-bind:to="{name : 'methods-form', params : { project_id : inputs.project_id, class_id : inputs.class_id, method_id : 0}}" class="btn btn-default">

                        Cadastro

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12 animate__animated animate__fadeIn">

                <div class="row">

                    <div class="col-md-3 mb-3" v-for="(result, index) in query.result.methods" v-bind:key="index">

                        <div class="card card-default shadow-sm">

                            <div class="card-body">

                                <h5 class="card-title">

                                    <span class="badge badge-primary mr-1">

                                        <i class="fas fa-hashtag mr-1"></i>{{ result.method_id }}

                                    </span>

                                    {{ result.name }}

                                </h5>

                                <h6 class="card-subtitle mb-2">

                                    Método

                                </h6>

                                <div class="card-text">

                                    {{ result.description}}

                                </div>

                            </div>

                            <nav class="navbar navbar-card navbar-expand-lg navbar-light bg-transparent card-footer">

                                <button class="navbar-toggler" type="button" data-toggle="collapse" v-bind:data-target="'#navbar_method_' + result.method_id" v-bind:aria-controls="'navbar_method_' + result.method_id" aria-expanded="false">

                                    <span class="navbar-toggler-icon"></span>

                                </button>

                                <div class="collapse navbar-collapse" v-bind:id="'navbar_method_' + result.method_id">

                                    <ul class="navbar-nav mr-auto">

                                        <li class="nav-item">

                                            <a class="nav-link" type="button" data-toggle="modal" data-target="#myModal" v-on:click="inputs.method_id = result.method_id">

                                                <i class="fas fa-fire-alt"></i>

                                            </a>

                                        </li>

                                        <li class="nav-item">

                                            <router-link class="nav-link" v-bind:to="{name : 'methods-form', params : { project_id : inputs.project_id, class_id : inputs.class_id, method_id : result.method_id}}">

                                                <i class="fas fa-pencil-alt"></i>

                                            </router-link>

                                        </li>

                                        <li class="nav-item">

                                            <router-link class="nav-link" v-bind:to="{name : 'methods-detail', params : { project_id : inputs.project_id, class_id : inputs.class_id, method_id : result.method_id}}">

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

        </div>

    </div>

</template>

<script type="text/ecmascript-6">

    /** Importação de componentes **/
    import axios from 'axios';
    import ModalConfirm from '../Geral/ModalConfirm';

    export default {

        /** Nome do componente atual **/
        name: "MethodsDatagrid",

        components : {

            ModalConfirm,

        },

        data (){

            return {

                inputs : {

                    project_id: this.$route.params.project_id,
                    class_id: this.$route.params.class_id,
                    method_id : null,

                },

                query : {

                    result: {

                        methods : []

                    },

                },

            }

        },

        methods : {

            /** Listo os registros **/
            List(){

                /** Envio uma requisição **/
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_DATAGRID', {

                    inputs : this.inputs,

                })

                /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.methods = response.data.result;

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Listagem de registros **/
            Delete(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_DELETE',{

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

            this.List();

        }

    }
</script>