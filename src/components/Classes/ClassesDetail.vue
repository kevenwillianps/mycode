<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Projetos/Classes/ <span class="badge badge-primary">Detalhes da Classe</span>

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

        <div class="col-md-12 animate__animated animate__fadeIn mt-3">

            <div class="card card-default shadow-sm">

                <div class="card-body">

                    <h5 class="card-title">

                        <span class="badge badge-primary"><i class="fas fa-hashtag mr-1"></i>{{query.result.classes.class_id}}</span>{{query.result.classes.name}}

                    </h5>

                    <h6 class="card-subtitle mb-2">

                        Detalhes da classe

                    </h6>

                    <div v-for="(result, index) in query.result.methods" v-bind:key="index">

                        <div class="card-text">

                            Método: <span class="badge badge-primary">{{ result.name }}</span>

                        </div>

                        <div class="card-text">

                             <pre>

                                <code class="php mt-1">

                                    {{ result.code }}

                                </code>

                            </pre>

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
        name: "ClassDetails",

        data (){

            return {

                inputs : {

                    class_id: this.$route.params.class_id,

                },

                query : {

                    result: {

                        methods : [],
                        classes : [],

                    },

                },

            }

        },

        methods : {

            /** Listo os registros **/
            Get(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_EDIT_FORM',{

                    inputs : this.inputs

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.classes = response.data.result;

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Listo os registros **/
            List(){

                /** Envio uma requisição **/
                axios.post('router.php?TABLE=METHODS&ACTION=METHODS_IN_CLASS', {

                    inputs : this.inputs,

                })

                    /** Caso tenha sucesso **/
                    .then(response => {

                        this.query.result.methods = response.data.result;
                        
                        for (let i = 0; i < this.query.result.methods.length; i++){

                            this.query.result.methods[i].code = atob(this.query.result.methods[i].code);

                        }

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

        },

        mounted(){

            this.Get();
            this.List();

        }

    }
</script>