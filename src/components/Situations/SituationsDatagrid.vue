<template>

    <div>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Situações/ <span class="badge badge-primary"></span>

                </h4>

            </div>

            <div class="col-md-6 text-right">

                <h4>

                    <router-link to="/situations/form/" class="btn btn-primary">

                        Cadastro

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12">

                <div class="row">

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

                                            <a class="nav-link" href="#">

                                                <i class="fas fa-fire-alt"></i>

                                            </a>

                                        </li>

                                        <li class="nav-item">

                                            <a class="nav-link" href="#">

                                                <i class="fas fa-pencil-alt"></i>

                                            </a>

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

    /** Importo os componentes que irei utilizar **/
    import axios from 'axios';

    export default {

        /** Nome do componente atual **/
        name: "SituationDatagrid",

        data (){

            return {

                /** Grupo de variavei s para guardar consultas sql's **/
                query : {

                    result : [],

                }

            }

        },

        methods : {

            /** Método para listar registros **/
            List(){

                /** Envio uma requisição ao backend **/
                axios.post('router.php?TABLE=SITUATIONS&ACTION=SITUATIONS_DATAGRID')

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result = response.data.result;

                    })

                    /** Caso tenha erro **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            }

        },

        mounted(){

            /** Executo um método especifico **/
            this.List();

            /** Informo que o componente foi montado com sucesso **/
            console.log('Componente "SituationsDatagrid", montado com sucesso!');

        }

    }
</script>