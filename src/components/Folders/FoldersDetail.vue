<template>

    <div>

        <div id="context-menu" class="animate__animated animate__fadeIn">

            <div class="item">

                <router-link v-bind:to="{name : 'classes-form', params : {project_id : inputs.project_id, class_id : 0}}">

                    <i class="fas fa-file-code"></i> Classe

                </router-link>

            </div>

        </div>

        <ModalConfirm title="Atenção!" message="Deseja excluir este registro ?" v-on:ConfirmRequest="Delete"></ModalConfirm>

        <div class="row">

            <div class="col-md-12 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Projetos/Classes/Pasta/ <span class="badge badge-light">Arquivos</span>

                </h4>

            </div>

            <div class="col-md-12 animate__animated animate__fadeIn">

                <div class="row">

                    <div class="col-md-3 mb-3" v-for="(result, index) in query.result.classes" v-bind:key="index">

                        <div class="card card-default shadow-sm">

                            <div class="card-body">

                                <h5 class="card-title">

                                    <span class="badge badge-light mr-1">

                                        <i class="fas fa-hashtag mr-1"></i>{{result.class_id}}

                                    </span>

                                    {{ result.name }}

                                </h5>

                                <h6 class="card-subtitle text-white-50 mb-2">

                                    Classe

                                </h6>

                                <div class="card-text">

                                    {{ result.description }}

                                </div>

                            </div>

                            <nav class="navbar navbar-footer navbar-expand-lg navbar-dark bg-transparent card-footer">

                                <button class="navbar-toggler" type="button" data-toggle="collapse" v-bind:data-target="'#navbar_classes_' + result.folder_id" v-bind:aria-controls="'navbar_classes_' + result.folder_id" aria-expanded="false">

                                    <span class="navbar-toggler-icon"></span>

                                </button>

                                <div class="collapse navbar-collapse" v-bind:id="'navbar_classes_' + result.folder_id">

                                    <ul class="navbar-nav mr-auto">

                                        <li class="nav-item">

                                            <a class="nav-link" type="button" data-toggle="modal" data-target="#myModal" v-on:click="inputs.class_id = result.class_id">

                                                <i class="fas fa-fire-alt"></i>

                                            </a>

                                        </li>

                                        <li class="nav-item">

                                            <router-link v-bind:to="{name : 'classes-form', params : {project_id : inputs.project_id, class_id : result.class_id}}" class="nav-link">

                                                <i class="fas fa-pencil-alt"></i>

                                            </router-link>

                                        </li>

                                        <li class="nav-item">

                                            <router-link v-bind:to="{name : 'methods-datagrid', params : {project_id : inputs.project_id, class_id : result.class_id}}" class="nav-link">

                                                <i class="far fa-eye"></i>

                                            </router-link>

                                        </li>

                                        <li class="nav-item">

                                            <router-link v-bind:to="{name : 'classes-detail', params : {class_id : result.class_id}}" class="nav-link">

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

    window.addEventListener("contextmenu",function(event){
        event.preventDefault();
        var contextElement = document.getElementById("context-menu");
        contextElement.style.top = event.offsetY + "px";
        contextElement.style.left = event.offsetX + "px";
        contextElement.classList.add("active");
    });
    window.addEventListener("click",function(){
        document.getElementById("context-menu").classList.remove("active");
    });

    /** Importação de componentes **/
    import axios from 'axios';
    import ModalConfirm from '../Geral/ModalConfirm';

    export default {

        /** Nome do componente atual **/
        name: "FoldersDetails",

        components : {

            ModalConfirm,

        },

        data (){

            return {

                inputs : {

                    project_id: this.$route.params.project_id,
                    folder_id: this.$route.params.folder_id,

                },

                query : {

                    result: {

                        classes : []

                    },

                },

            }

        },

        methods : {

            /** Listo os registros **/
            List(){

                /** Envio uma requisição **/
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_FILES_IN_FOLDER', {

                    inputs : this.inputs,

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

            /** Listagem de registros **/
            Delete(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=CLASSES&ACTION=CLASSES_DELETE',{

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