<template>

    <div>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Projetos/Classes/ <span class="badge badge-light">Detalhes da Classe</span>

                </h4>

            </div>

            <div class="col-md-6 text-right animate__animated animate__fadeIn">

                <h4>

                    <router-link to="/classes/datagrid/" class="btn btn-default">

                        Listagem

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12 animate__animated animate__fadeIn">

                <div class="card card-default shadow-sm">

                    <div class="card-body">

                        <h5 class="card-title">

                            <span class="badge badge-light mr-1">#199</span>save

                        </h5>

                        <h6 class="card-subtitle text-white-50 mb-2">

                            Detalhes

                        </h6>

                        <div class="form-group">

                            <textarea name="" rows="10" class="form-control"></textarea>

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

                    1,
                    2,
                    3,
                    4,

                ]

            }

        }

    }
</script>