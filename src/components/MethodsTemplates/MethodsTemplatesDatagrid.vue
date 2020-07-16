<template>

    <div>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Métodos/Template

                </h4>

            </div>

            <div class="col-md-6 text-right">

                <h4>

                    <router-link to="/methods/templates/form/" class="btn btn-default">

                        Cadastro

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12">

                <div class="row">

                    <div class="col-md-3 mb-3 animate__animated animate__fadeIn" v-for="(v, index) in value" v-bind:key="index">

                        <div class="card card-default shadow-sm">

                            <div class="card-body">

                                <h5 class="card-title">

                                    <span class="badge badge-light mr-1">

                                        <i class="fas fa-hashtag mr-1"></i>199

                                    </span>

                                    {{ v }}

                                </h5>

                                <h6 class="card-subtitle text-white-50 mb-2">

                                    Método

                                </h6>

                                <div class="card-text">

                                    Lorem Ipsum is simply dummy text of the printing and

                                </div>

                            </div>

                            <nav class="navbar navbar-footer navbar-expand-lg navbar-dark bg-transparent card-footer">

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

                                        <li class="nav-item">

                                            <router-link to="/methods/templates/detail" class="nav-link" href="#">

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

    export default {

        name: "ProjectsDetails",

        data (){

            return {

                value : [

                    'Save',
                    'Update',
                    'Delete',
                    'Get',
                    'All',
                    'GetLast',
                    'GetFirst',

                ]

            }

        }

    }
</script>