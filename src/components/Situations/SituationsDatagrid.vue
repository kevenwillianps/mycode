s<template>

    <div>

        <ModalConfirm title="Atenção!" message="Deseja excluir este registro ?" v-on:ConfirmRequest="Delete"></ModalConfirm>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Situações/ <span class="badge badge-primary">Listagem</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <router-link v-bind:to="{name : 'situations-form', params : {situation_id : 0}}" class="nav-link">

                            <i class="fas fa-pencil-alt mr-1"></i>Novo

                        </router-link>

                    </li>

                </ul>

            </div>

        </nav>

        <div class="col-md-12 mt-3">

            <div class="animate__animated animate__fadeIn" v-if="controls.progress_bar">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="progress">

                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="animate__animated animate__fadeIn" v-else-if="query.result <= 0">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="media">

                            <img src="image/svg/003-error.svg" width="70px" class="mr-3" alt="MyCMS - Keven Willian">

                            <div class="media-body">

                                <h3 class="mt-0">

                                    Ops!

                                </h3>

                                <h5 class="text-muted">

                                    Não foram localizado registros

                                </h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row" v-else>

                <div class="col-md-3 mb-3 animate__animated animate__fadeIn" v-for="(result, index) in query.result" v-bind:key="index">

                    <div class="card card-default shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">

                                    <span class="badge badge-primary mr-1">

                                        <i class="fas fa-hashtag mr-1"></i>{{ result.situation_id }}

                                    </span>

                                {{ result.name }}

                            </h5>

                            <h6 class="card-subtitle mb-2">

                                {{ result.description }}

                            </h6>

                        </div>

                        <nav class="navbar navbar-card navbar-expand-lg navbar-light bg-transparent card-footer">

                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

                                <span class="navbar-toggler-icon"></span>

                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                                <ul class="navbar-nav mr-auto">

                                    <li class="nav-item">

                                        <a class="nav-link" type="button" data-toggle="modal" data-target="#myModal" v-on:click="inputs.situation_id = result.situation_id">

                                            <i class="fas fa-fire-alt"></i>

                                        </a>

                                    </li>

                                    <li class="nav-item">

                                        <router-link v-bind:to="{name : 'situations-form', params : {situation_id : result.situation_id }}" class="nav-link">

                                            <i class="fas fa-pencil-alt"></i>

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

</template>

<script type="text/ecmascript-6">

    /** Importo os componentes que irei utilizar **/
    import axios from 'axios';
    import ModalConfirm from '../Geral/ModalConfirm';

    export default {

        name: "SituationsDatagrid",

        components : {

            ModalConfirm

        },

        data (){

            return {

                inputs : {

                    user_id : 0,

                },

                /** Grupo de variavei s para guardar consultas sql's **/
                query : {

                    result : [],

                },

                controls : {

                    progress_bar : true,

                }

            }

        },

        methods : {

            /** Método para listar registros **/
            List(){

                /** Habilito a barra de progresso */
                this.controls.progress_bar = true;

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=SITUATIONS&ACTION=SITUATIONS_DATAGRID')

                /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result = response.data.result;

                        /** Delay de execução */
                        window.setTimeout(() => {

                            /** Desabilito a barra de progresso */
                            this.controls.progress_bar = false;

                        }, 1000);

                    })

                    /** Caso tenha erro **/
                    .catch(response => {

                        /** Habilito a barra de progresso */
                        this.controls.progress_bar = false;
                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Listagem de registros **/
            Delete(){

                this.controls.progress_bar = true;
                this.query.success = false;

                /** Envio de requisição **/
                axios.post('router.php?TABLE=SITUATIONS&ACTION=SITUATIONS_DELETE',{

                    inputs : this.inputs

                })

                /** Caso tenha sucesso **/
                    .then(response => {

                        console.log('Sucesso -> ' + response.data);
                        this.List();

                        /** Delay de execução */
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

            /** Executo um método especifico **/
            this.List();

            /** Informo que o componente foi montado com sucesso **/
            console.log('Componente "UsersDatagrid", montado com sucesso!');

        }

    }
</script>