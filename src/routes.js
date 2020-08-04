import ProjectsDatagrid from './components/Projects/ProjectsDatagrid'
import ProjectsForm from './components/Projects/ProjectsForm'

import FoldersForm from './components/Folders/FoldersForm'
import FoldersDetail from './components/Folders/FoldersDetail'

import FoldersAuxiliaryForm from './components/FoldersAuxiliary/FoldersAuxiliaryForm'
import FoldersAuxiliaryDetail from './components/FoldersAuxiliary/FoldersAuxiliaryDetail'

import ClassesForm from './components/Classes/ClassesForm'
import ClassesDatagrid from './components/Classes/ClassesDatagrid'
import ClassesDetail from './components/Classes/ClassesDetail'

import MethodsForm from './components/Methods/MethodsForm'
import MethodsDatagrid from './components/Methods/MethodsDatagrid'
import MethodsDetail from './components/Methods/MethodsDetail'
import MethodsFormTemplateBuild from './components/Methods/MethodsFormTemplateBuild'

import MethodsTemplateForm from './components/MethodsTemplates/MethodsTemplatesForm'
import MethodsTemplateDatagrid from './components/MethodsTemplates/MethodsTemplatesDatagrid'
import MethodsTemplateDetail from './components/MethodsTemplates/MethodsTemplatesDetail'

import UsersForm from './components/Users/UsersForm'
import UsersDatagrid from './components/Users/UsersDatagrid'

import UserFunctionsForm from './components/UserFunctions/UserFunctionsForm'
import UserFunctionsDatagrid from './components/UserFunctions/UserFunctionsDatagrid'

import SituationsForm from './components/Situations/SituationsForm'
import SituationsDatagrid from './components/Situations/SituationsDatagrid'

const routes = [

    {

        /** Página Inicial **/
        path: '/',
        component: ProjectsDatagrid,
        name: 'projects-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/projects/form/:project_id',
        component: ProjectsForm,
        name: 'projects-form',

    },

    {

        /** Página Inicial **/
        path: '/folders/form/:project_id/:folder_id',
        component: FoldersForm,
        name: 'folders-form',

    },

    {

        /** Página Inicial **/
        path: '/folders/details/:project_id/:folder_id',
        component: FoldersDetail,
        name: 'folders-detail',

    },

    {

        /** Página Inicial **/
        path: '/folders/auxiliary/form/:project_id/:folder_id/:folder_auxiliary_id',
        component: FoldersAuxiliaryForm,
        name: 'folders-auxiliary-form',

    },

    {

        /** Página Inicial **/
        path: '/folders/auxiliary/details/:project_id/:folder_id',
        component: FoldersAuxiliaryDetail,
        name: 'folders-auxiliary-detail',

    },

    {

        /** Página Inicial **/
        path: '/classes/datagrid/:project_id',
        component: ClassesDatagrid,
        name: 'classes-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/classes/detail/:class_id',
        component: ClassesDetail,
        name: 'classes-detail',

    },

    {

        /** Página Inicial **/
        path: '/classes/form/:project_id/:class_id',
        component: ClassesForm,
        name: 'classes-form',

    },

    {

        /** Página Inicial **/
        path: '/methods/datagrid/:project_id/:class_id',
        component: MethodsDatagrid,
        name: 'methods-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/methods/form/:project_id/:class_id/:method_id',
        component: MethodsForm,
        name: 'methods-form',

    },

    {

        /** Página Inicial **/
        path: '/methods/form/template/build/:project_id/:class_id/',
        component: MethodsFormTemplateBuild,
        name: 'methods-form-template-build',

    },

    {

        /** Página Inicial **/
        path: '/methods/detail/:project_id/:class_id/:method_id',
        component: MethodsDetail,
        name: 'methods-detail',

    },

    {

        /** Página Inicial **/
        path: '/methods/templates/datagrid',
        component: MethodsTemplateDatagrid,
        name: 'methods-templates-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/methods/templates/form/:method_template_id',
        component: MethodsTemplateForm,
        name: 'methods-templates-form',

    },

    {

        /** Página Inicial **/
        path: '/methods/templates/detail/:method_template_id',
        component: MethodsTemplateDetail,
        name: 'methods-templates-detail',

    },

    {

        /** Página Inicial **/
        path: '/users/datagrid',
        component: UsersDatagrid,
        name: 'users-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/users/form',
        component: UsersForm,
        name: 'users-form',

    },

    {

        /** Página Inicial **/
        path: '/user/functions/datagrid',
        component: UserFunctionsDatagrid,
        name: 'user-functions-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/user/functions/form',
        component: UserFunctionsForm,
        name: 'user-functions-form',

    },

    {

        /** Página Inicial **/
        path: '/situations/datagrid',
        component: SituationsDatagrid,
        name: 'situations-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/situations/form',
        component: SituationsForm,
        name: 'situations-form',

    },


];

export default routes;